<?php

namespace SimpleKit\Controllers;

use function SimpleKit\Helpers\redirect;
use SimpleKit\Models\Books;

require __DIR__ . "/../Helpers/Redirector.php";

class BooksController extends BaseController {
    
    protected $books;  // This translates to books
    
    public function __construct() {
        // Instantiate the books and assign it to the protected property
        $this->books = new Books();
    }

    public function index() {
        // Fetch all users using the books
        $books = $this->books->getAll();

        // Render the view and pass the books data to it
        $this->render('Books/index', ['books' => $books]);
    }

    public function store() {
        
        // Create a new book using the books
        $this->books->create($data);

        // Redirect back to the index page with a success message (or handle differently based on your needs)
        // You can also render a view or return a JSON response
        return redirect('/books')->with(['success' => 'book created successfully!']);  // Note the change here
    }

    public function show(int $id) {
        // Fetch a specific book by ID using the books
        $book = $this->books->getById($id);

        // Render the view and pass the book data to it
        $this->render('book/show', ['book]' => $book]);
    }

    public function edit(int $id) {
        // Fetch a specific book by ID using the books
        $book = $this->books->getById($id);

        // Render the view for editing the book
        $this->render('book/edit', ['book' => $book]);
    }

    public function update(object $request, int $id) {
        // Validate the request data (assuming a simple validation here)
        $data = $request->all();
        
        // Update the book using the BooksModal
        $this->books->updateById($id, $data);

        // Redirect back to the index page with a success message (or handle differently based on your needs)
        return redirect('/books')->with(['success', 'book updated successfully!']);
    }

    public function destroy(int $id) {
        // Delete a specific book by ID using the books
        $this->books->deleteById($id);

        // Redirect back to the index page with a success message (or handle differently based on your needs)
        return redirect('/books')->with(['success', 'book updated successfully!']);
    }

    // You can add more controller methods as needed to handle other book-related functionalities
}