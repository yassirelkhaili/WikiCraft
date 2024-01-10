<?php

namespace SimpleKit\Controllers;

use function SimpleKit\Helpers\redirect;
use SimpleKit\Models\User;
use SimpleKit\Helpers\Request;

class AuthController extends BaseController {
    
    protected $user;  // This translates to auth
    
    public function __construct() {
        // Instantiate the auth and assign it to the protected property
        $this->user = new User();
    }


    public function authenticate(Request $request) {
        $userEmail = $request->getPostData("email");
        $emailExists = $this->user->emailExists($userEmail)[0]["count"];
        if ($emailExists === 1) {
            $user = $this->user->getByEmail($userEmail)[0]; //database user data
            if (password_verify($request->getPostData("password"), $user["password"])) { //verify against user input
                $sessionToken = bin2hex(random_bytes(32));
                if (!isset($_SESSION['session_token'])) $_SESSION['session_token'] = $sessionToken;
                if (!isset($_SESSION['user_id'])) $_SESSION['user_id'] = $this->user->getByEmail($request->getPostData("email"))[0]['id'];
                if (!isset($_SESSION['user_role'])) $_SESSION['user_role'] = $user['role'];
                echo json_encode(["status" => "success", "message" => "Login successful"]);
            } else {
                echo json_encode(["status" => "password", "message" => "Incorrect Password"]);
            }
        } else {
            echo json_encode(["status" => "email", "message" => "This account doesn't exist"]);
        }
        exit();
    }

    public static function validate() {
        
    }

    public function register(Request $request)
    {
       $emailExists = $this->user->emailExists($request->getPostData("email"))[0]["count"];
        if ($emailExists === 0) {
            //validate info here
            if ($request->getPostData("password") !== $request->getPostData("confirmPassword")) {
                echo json_encode(["status" => "passwords", "message" => "Passwords dont match"]);
                exit();
            }
            try {
                $hashedPassword = password_hash($request->getPostData("password"), PASSWORD_DEFAULT);
                $this->user->create(["username" => $request->getPostData("username"), "email" => $request->getPostData("email"), "password" => $hashedPassword]);
            } catch (\Exception $e) {
                echo json_encode(["status"=> "insert","message"=> "Error Registering an account" . $e->getMessage()]);
            }
            $sessionToken = bin2hex(random_bytes(32));
            $_SESSION['session_token'] = $sessionToken;
            $_SESSION['user_id'] = $this->user->getByEmail($request->getPostData("email"))[0]['id'];
            echo json_encode(["status"=> "success","message"=> "Account Created Successfuly"]);
        } else {
            echo json_encode(["status" => "email", "message" => "Email address already exists"]);
        }
    exit();
    }

    public function logout () {
        session_destroy();
        redirect('/');
    }

    public function generateCsrfToken () {

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