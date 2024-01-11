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

    public function index() {
        // Fetch all users using the wiki
        $wikis = $this->wiki->raw("SELECT w.id, w.title, w.content, c.name AS category, u.username AS author, GROUP_CONCAT(t.name) AS tags FROM wiki w JOIN user u ON w.authorID = u.id JOIN category c ON w.categoryID = c.id LEFT JOIN wiki_tags wt ON w.id = wt.wikiID LEFT JOIN tag t ON wt.tagID = t.id GROUP BY w.id, w.title, w.content, c.name, u.username;");

        // Render the view and pass the wiki data to it
        echo json_encode(["status" => "success", "message" => "Wikis fetched successfuly", "content" => $wikis]);
    }

    public function create(Request $request) {
        // Render the view for creating a new wik
        $request->getPostData();
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

    public function edit(int $id) {
        // Fetch a specific wik by ID using the wiki
        $wik = $this->wiki->getById($id);

        // Render the view for editing the wik
        $this->render('wik/edit', ['wik' => $wik]);
    }


    public function destroy($id) {
        // Delete a specific wik by ID using the wiki
        $this->wiki->deleteById($id);

        // Redirect back to the index page with a success message (or handle differently based on your needs)
        return redirect('/wiki')->with(['destroy' => 'wik was deleted']);
    }

    // You can add more controller methods as needed to handle other wik-related functionalities
}