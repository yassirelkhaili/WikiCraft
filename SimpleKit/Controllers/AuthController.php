<?php

namespace SimpleKit\Controllers;

use function SimpleKit\Helpers\redirect;
use SimpleKit\Models\User;
use SimpleKit\Helpers\Request;

require __DIR__ . "/../Helpers/Redirector.php";

class AuthController extends BaseController {
    
    protected $user;  // This translates to auth
    
    public function __construct() {
        // Instantiate the auth and assign it to the protected property
        $this->user = new User();
    }


    public function authenticate() {
        
    }

    public function validate() {
        
    }

    public function register(Request $request)
    {
       $emailExists = $this->user->emailExists($request->getPostData("email"));
        if (!$emailExists[0]["count"]) {
            //validate info here
            if ($request->getPostData("password") !== $request->getPostData("confirmPassword")) {
                echo json_encode(["status" => "passwords", "message" => "Passwords dont match"]);
                exit();
            }
            try {
                $this->user->create(["username" => $request->getPostData("username"), "email" => $request->getPostData("email"), "password" => $request->getPostData("password")]);
            } catch (\Exception $e) {
                echo json_encode(["status"=> "insert","message"=> "Error Registering an account" . $e->getMessage()]);
                exit();
            }
            $sessionToken = bin2hex(random_bytes(32));
            $_SESSION['session_token'] = $sessionToken;
            echo json_encode(["status"=> "success","message"=> "Account Created Successfuly"]);
            exit();
        } else {
            echo json_encode(["status" => "email", "message" => "Email address already exists"]);
            exit();
        }
    }

    public function logout () {
        session_destroy();
        $this->render('home');
    }

    public function show(int $id) {
        // Fetch a specific aut by ID using the user
        $aut = $this->user->getById($id);

        // Render the view and pass the aut data to it
        $this->render('aut/show', ['aut]' => $aut]);
        /*
        with javascript:
        http_response_code(200);
        echo json_encode($book);
        */
    }

    public function edit(int $id) {
        // Fetch a specific aut by ID using the user
        $aut = $this->user->getById($id);

        // Render the view for editing the aut
        $this->render('aut/edit', ['aut' => $aut]);
    }

    public function update(Request $request, int $id) {
        // Validate the request data (assuming a simple validation here)
        $data = $request->getPostData();
        
        // Update the aut using the userModal
        $this->user->updateById($id, $data);

        // Redirect back to the index page with a success message (or handle differently based on your needs)
        return redirect('/user')->with(['modified' => 'aut has been updated!']);
    }

    public function destroy($id) {
        // Delete a specific aut by ID using the user
        $this->user->deleteById($id);

        // Redirect back to the index page with a success message (or handle differently based on your needs)
        return redirect('/auth')->with(['destroy' => 'aut was deleted']);
    }

    // You can add more controller methods as needed to handle other aut-related functionalities
}