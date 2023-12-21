<?php

namespace SimpleKit\Controllers;

require dirname(__DIR__) . "/Helpers/redirect.php";

use SimpleKit\Controller;
use SimpleKit\Models\BooksModal;

class booksController extends Controller {
    
    protected $booksModal;  // This translates to booksModal
    
    public function __construct() {
        // Instantiate the BooksModal and assign it to the protected property
        $this->booksModal = new booksModal();
    }

    public function index() {
        // Fetch all users using the booksModal
        $books = $this->booksModal->getAll();

        // Render the view and pass the books data to it
        $this->render('book/index', ['books' => $books]);
    }

    public function create() {
        // Render the view for creating a new book
        $this->render('book/create');
    }

    public function store(object $request) {
        // Validate the request data (assuming a simple validation here)
        $data = $request->all();
        
        // Create a new book using the BooksModal
        $this->booksModal->create($data);

        // Redirect back to the index page with a success message (or handle differently based on your needs)
        // You can also render a view or return a JSON response
        return redirect('/books')->with(['success', 'Book created successfully!']);
    }

    public function show(int $id) {
        // Fetch a specific book by ID using the BooksModal
        $book = $this->booksModal->getById($id);

        // Render the view and pass the book data to it
        $this->render('book/show', ['book' => $book]);
    }

    public function edit(int $id) {
        // Fetch a specific book by ID using the BooksModal
        $book = $this->booksModal->getById($id);

        // Render the view for editing the book
        $this->render('book/edit', ['book' => $book]);
    }

    public function update(object $request, int $id) {
        // Validate the request data (assuming a simple validation here)
        $data = $request->all();
        
        // Update the book using the BooksModal
        $this->booksModal->updateById($id, $data);

        // Redirect back to the index page with a success message (or handle differently based on your needs)
        return redirect('/books')->with(['success', 'Book updated successfully!']);
    }

    public function destroy($id) {
        // Delete a specific book by ID using the BooksModal
        $this->booksModal->deleteById($id);

        // Redirect back to the index page with a success message (or handle differently based on your needs)
        return redirect('/books')->with(['success', 'Book updated successfully!']);
    }

    // You can add more controller methods as needed to handle other book-related functionalities
}