<?php

namespace SimpleKit\Controllers;

use function SimpleKit\Helpers\redirect;
use SimpleKit\Models\Wiki;
use SimpleKit\Models\Wikitags;
use SimpleKit\Models\Tag;
use SimpleKit\Helpers\Request;

class WikiController extends BaseController {
    
    protected $wiki;  // This translates to wiki
    protected $tag;

    protected $wikitag;

    public function __construct() {
        // Instantiate the wiki and assign it to the protected property
        $this->wiki = new Wiki();
        $this->tag = new Tag();
        $this->wikitag = new Wikitags();
    }

    public static function hasPermissionTo (int $id, Wiki $wiki) {
        return $wiki->getById($id)[0]['authorID'] === $_SESSION['user_id'] || $_SESSION['user_role'] === 'admin';
    }

    public function indexUserWikis() {
        if (!isset($_SESSION['user_id'])) {
            redirect('/login');
            exit();
        }
        // Fetch all users using the wiki
        try {
            $wikis = $this->wiki->raw("SELECT w.id, w.title, w.content, c.name AS category, u.username AS author, GROUP_CONCAT(t.name) AS tags FROM wiki w JOIN user u ON w.authorID = u.id JOIN category c ON w.categoryID = c.id LEFT JOIN wiki_tags wt ON w.id = wt.wikiID LEFT JOIN tag t ON wt.tagID = t.id WHERE w.authorID = :id GROUP BY w.id, w.title, w.content, c.name, u.username ORDER BY w.created_at DESC;", ['id' => $_SESSION['user_id']]);
            // Render the view and pass the wiki data to it
        echo json_encode(["status" => "success", "message" => "Wikis fetched successfuly", "content" => $wikis]);
        } catch (\Exception $e) {
            echo json_encode(["status" => "insert", "message" => "There was a problem fetching the wikis"]);
        }
    }

    public function index() {
        // Fetch all users using the wiki
        try {
            $wikis = $this->wiki->raw("SELECT w.id, w.title, w.content, c.name AS category, u.username AS author, GROUP_CONCAT(t.name) AS tags FROM wiki w JOIN user u ON w.authorID = u.id JOIN category c ON w.categoryID = c.id LEFT JOIN wiki_tags wt ON w.id = wt.wikiID LEFT JOIN tag t ON wt.tagID = t.id GROUP BY w.id, w.title, w.content, c.name, u.username ORDER BY w.created_at DESC;");
            // Render the view and pass the wiki data to it
        echo json_encode(["status" => "success", "message" => "Wikis fetched successfuly", "content" => $wikis]);
        } catch (\Exception $e) {
            echo json_encode(["status" => "insert", "message" => "There was a problem fetching the wikis"]);
        }
    }

    public function create(Request $request) {
        // Render the view for creating a new wik
        if (!isset($_SESSION['user_id'])) {
            redirect('/login');
            exit();
        } 
        $data = ['title' => $request->getPostData('title'), 'content' => $request->getPostData('content'), 'categoryID' => $request->getPostData('categoryID'), 'authorID' => $_SESSION['user_id']];
        try {
            $lastInsertedWikiID = $this->wiki->create($data)[0];
            //insert tags
            $lastInsertedTagIDs = [];
            $tags = $request->getPostData("tags");
            foreach ($tags as $value) $lastInsertedTagIDs[] = $this->tag->create(['name' => $value]);

            //assign tags to wiki in wiki_tags pivot table
            foreach ($tags as $index => $value) $this->wikitag->create(['wikiID' => $lastInsertedWikiID, 'tagID' => $lastInsertedTagIDs[$index][0]]);
        } catch (\Exception $e) {
            echo json_encode(["status" => "insert", "message" => "There was an error publishing the wiki"]);
        }
        echo json_encode(["status" => "success", "message" => "Wiki Created successfully"]);
    }

    public function store(Request $request) {
        $data = $request->getPostData();
        // Create a new wik using the wiki
        $this->wiki->create($data);

        // Redirect back to the index page with a success message (or handle differently based on your needs)
        // You can also render a view or return a JSON response
        return redirect('/books')->with(['success' => 'book created successfully!']);  // Note the change here
    }

    public function show(int $id) {
        // Fetch a specific wik by ID using the wiki
        $wik = $this->wiki->getById($id);

        // Render the view and pass the wik data to it
        $this->render('wik/show', ['wik]' => $wik]);
        /*
        with javascript:
        http_response_code(200);
        echo json_encode($book);
        */
    }

    public function edit(Request $request, $id) {
      if (WikiController::hasPermissionTo($id, $this->wiki)) {
        try {
            // Fetch a specific wik by ID using the wiki
            $this->wiki->updateById($id, ['title' => $request->getPostData("title"), 'content' => $request->getPostData("content"),'categoryID' => $request->getPostData("categoryID")]);
            //delete old tags
            $tagIdsToDelete = $this->wikitag->raw("SELECT tagID FROM wiki_tags WHERE wikiID = :wikiId", ['wikiId' => $id]);
            foreach ($tagIdsToDelete as $tagID) $this->tag->deleteById($tagID['tagID']);
            // add new tags
            $lastInsertedTagIDs = [];
                $tags = $request->getPostData("tags");
                foreach ($tags as $value) $lastInsertedTagIDs[] = $this->tag->create(['name' => $value]);
                //assign tags to wiki in wiki_tags pivot table
                foreach ($tags as $index => $value) $this->wikitag->create(['wikiID' => $id, 'tagID' => $lastInsertedTagIDs[$index][0]]);
                echo json_encode(["status" => "success", "message" => "Wiki edited successfully"]);
          } catch (\Exception $e) {
           echo json_encode(["status" => "insert", "message" => "There was an error editing the wiki"]);
          }
      } else {
        echo json_encode(["status" => "permission", "message" => "User doesnt have permission to perform this action"]);
      }
    }


    public function destroy($id) {
        if (WikiController::hasPermissionTo($id, $this->wiki)) {
            try {
                // Delete a specific wik by ID using the wiki
            $tagIdsToDelete = $this->wikitag->raw("SELECT tagID FROM wiki_tags WHERE wikiID = :wikiId", ['wikiId' => $id]);
            foreach ($tagIdsToDelete as $tagID) $this->tag->deleteById($tagID['tagID']);
            $this->wiki->deleteById($id);
            // Redirect back to the index page with a success message (or handle differently based on your needs)
            echo json_encode(["status" => "success", "message" => "Wiki Deleted successfully"]);
            } catch (\Exception $e) {
            echo json_encode(["status" => "success", "message" => "There was an error deleting the wiki"]);
            }
        } else {
            echo json_encode(["status" => "permission", "message" => "User doesnt have permission to perform this action"]);
        }
    }

    // You can add more controller methods as needed to handle other wik-related functionalities
}