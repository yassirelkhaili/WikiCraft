<?php

namespace SimpleKit\Controllers;

use function SimpleKit\Helpers\redirect;
use SimpleKit\Models\Auth;
use SimpleKit\Helpers\Request;

require __DIR__ . "/../Helpers/Redirector.php";

class AuthController extends BaseController {
    
    protected $auth;  // This translates to auth
    
    // public function __construct() {
    //     // Instantiate the auth and assign it to the protected property
    //     $this->auth = new Auth();
    // }


    public function authenticate() {
        
    }

    public function store(Request $request) {
        $data = $request->getPostData();
        // Create a new aut using the auth
        $this->auth->create($data);

        // Redirect back to the index page with a success message (or handle differently based on your needs)
        // You can also render a view or return a JSON response
        return redirect('/books')->with(['success' => 'book created successfully!']);  // Note the change here
    }

    public function show(int $id) {
        // Fetch a specific aut by ID using the auth
        $aut = $this->auth->getById($id);

        // Render the view and pass the aut data to it
        $this->render('aut/show', ['aut]' => $aut]);
        /*
        with javascript:
        http_response_code(200);
        echo json_encode($book);
        */
    }

    public function edit(int $id) {
        // Fetch a specific aut by ID using the auth
        $aut = $this->auth->getById($id);

        // Render the view for editing the aut
        $this->render('aut/edit', ['aut' => $aut]);
    }

    public function update(Request $request, int $id) {
        // Validate the request data (assuming a simple validation here)
        $data = $request->getPostData();
        
        // Update the aut using the authModal
        $this->auth->updateById($id, $data);

        // Redirect back to the index page with a success message (or handle differently based on your needs)
        return redirect('/auth')->with(['modified' => 'aut has been updated!']);
    }

    public function destroy($id) {
        // Delete a specific aut by ID using the auth
        $this->auth->deleteById($id);

        // Redirect back to the index page with a success message (or handle differently based on your needs)
        return redirect('/auth')->with(['destroy' => 'aut was deleted']);
    }

    // You can add more controller methods as needed to handle other aut-related functionalities
}