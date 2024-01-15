<?php

namespace SimpleKit\Controllers;

use function SimpleKit\Helpers\redirect;
use SimpleKit\Models\Category;
use SimpleKit\Helpers\Request;

class CategoryController extends BaseController {
    
    protected $category;  // This translates to category
    
    public function __construct() {
        // Instantiate the category and assign it to the protected property
        $this->category = new Category();
    }

    public function fetchCategories() {
        // Fetch all users using the category
        $categories = $this->category->getAll();

        // Render the view and pass the category data to it
        echo json_encode(["status" => "success", "message" => "Categories fetched successfuly", "content" => $categories]);
    }

    public function create() {
        // Render the view for creating a new categor
        $this->render('categor/create');
    }

    public function fetch($id) {
        // Fetch a specific hom by ID using the home
        try {
            $category = $this->category->getById($id);
            // Render the view and pass the hom data to it
        echo json_encode(["status" => "success", "message" => "Category fetched successfuly", "content" => $category]);
        } catch (\Exception $e) {
            echo json_encode(["status" => "success", "message" => "There was a problem fetching the category"]);
        }
    }

    public function store(Request $request) {
        // Create a new categor using the category
       try {
        $this->category->create(['name' => $request->getPostData('name'), 'description' => $request->getPostData('description')]);

        // Redirect back to the index page with a success message (or handle differently based on your needs)
        // You can also render a view or return a JSON response
        echo json_encode(["status" => "success", "message" => "Category created successfuly"]);  // Note the change here
       } catch (\Exception $e) {
        echo json_encode(["status" => "insert", "message" => "There was an erro creating the category"]);  
       }
    }

    public function show(int $id) {
        // Fetch a specific categor by ID using the category
        $categor = $this->category->getById($id);

        // Render the view and pass the categor data to it
        $this->render('categor/show', ['categor]' => $categor]);
        /*
        with javascript:
        http_response_code(200);
        echo json_encode($book);
        */
    }

    public function edit(int $id) {
        // Fetch a specific categor by ID using the category
        $categor = $this->category->getById($id);

        // Render the view for editing the categor
        $this->render('categor/edit', ['categor' => $categor]);
    }

    public function update(Request $request, int $id) {
        // Validate the request data (assuming a simple validation here)
        $data = $request->getPostData();
        
        // Update the categor using the categoryModal
        $this->category->updateById($id, $data);

        // Redirect back to the index page with a success message (or handle differently based on your needs)
        return redirect('/category')->with(['modified' => 'categor has been updated!']);
    }

    public function destroy($id) {

        try {
            // Delete a specific wik by ID using the wiki
        $this->category->deleteById($id);
        // Redirect back to the index page with a success message (or handle differently based on your needs)
        echo json_encode(["status" => "success", "message" => "Category Deleted successfully"]);
        } catch (\Exception $e) {
        echo json_encode(["status" => "success", "message" => "There was an error deleting the category"]);
        }
    }

    // You can add more controller methods as needed to handle other categor-related functionalities
}