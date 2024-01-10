<?php

namespace SimpleKit\Controllers;

use function SimpleKit\Helpers\redirect;
use SimpleKit\Helpers\Request;

class HomeController extends BaseController {
    
    protected $home;  // This translates to home
    
    // public function __construct() {
    //     // Instantiate the home and assign it to the protected property
    //     $this->home = new Home();
    // }

    public function renderHome() {
        // Fetch all users using the home
        // $home = $this->home->getAll();
        // Render the view and pass the home data to it
        $this->render("home", [], "WebCraft | Home");
    }

    public function renderLogin() {
        $this->render('Auth/login', [], "WebCraft | Login");
    }

    public function renderRegister() {
        $this->render('Auth/register', [], "WebCraft | Register");
    }

    public function renderDashboard() {
        $this->render('Dashboard/dashboard', [], "WebCraft | Dashboard");
    }

    public function renderCraftwiki () {
        $this->render('Dashboard/craftwiki', [], "WebCraft | Craft");
    }

    public function renderCreateWiki() {
        $this->render('Dashboard/createwiki', [], "WebCraft | Create");
    }

    public function store(Request $request) {
        $data = $request->getPostData();
        // Create a new home using the home
        $this->home->create($data);

        // Redirect back to the index page with a success message (or handle differently based on your needs)
        // You can also render a view or return a JSON response
        return redirect('/books')->with(['success' => 'book created successfully!']);  // Note the change here
    }

    public function show(int $id) {
        // Fetch a specific hom by ID using the home
        $hom = $this->home->getById($id);

        // Render the view and pass the hom data to it
        $this->render('hom/show', ['hom]' => $hom]);
        /*
        with javascript:
        http_response_code(200);
        echo json_encode($book);
        */
    }

    public function edit(int $id) {
        // Fetch a specific hom by ID using the home
        $hom = $this->home->getById($id);

        // Render the view for editing the hom
        $this->render('hom/edit', ['hom' => $hom]);
    }

    public function update(Request $request, int $id) {
        // Validate the request data (assuming a simple validation here)
        $data = $request->getPostData();
        
        // Update the hom using the homeModal
        $this->home->updateById($id, $data);

        // Redirect back to the index page with a success message (or handle differently based on your needs)
        return redirect('/home')->with(['modified' => 'hom has been updated!']);
    }

    public function destroy($id) {
        // Delete a specific hom by ID using the home
        $this->home->deleteById($id);

        // Redirect back to the index page with a success message (or handle differently based on your needs)
        return redirect('/home')->with(['destroy' => 'hom was deleted']);
    }

    // You can add more controller methods as needed to handle other hom-related functionalities
}