<?php

namespace SimpleKit\Controllers;

use SimpleKit\Controller;
use SimpleKit\Models\BooksModal;

class booksController extends Controller {
    
    protected $booksModal;  // This translates to booksModal
    
    public function __construct() {
        // Instantiate the BooksModal and assign it to the protected property
        $this->booksModal = new booksModal();
    }

    public function index() {
        // Fetch all users using the UserModel
        $bookss = $this->booksModal->getAll();

        // Render the view and pass the bookss data to it
        $this->render('books/index', ['books' => $books]);
    }

    // You can add more controller methods as needed to handle other books-related functionalities
}