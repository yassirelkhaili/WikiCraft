<?php

use SimpleKit\BaseRouter;

// Create a new Router instance
$router = new BaseRouter();

$router->addRoute('/books', 'SimpleKit\Controllers\booksController', 'index');
$router->addRoute('/books/create', 'SimpleKit\Controllers\booksController', 'create');
$router->addRoute('/books/store', 'SimpleKit\Controllers\booksController', 'store');
$router->addRoute('/books/show/{id}', 'SimpleKit\Controllers\booksController', 'show');
$router->addRoute('/books/edit/{id}', 'SimpleKit\Controllers\booksController', 'edit');
$router->addRoute('/books/update/{id}', 'SimpleKit\Controllers\booksController', 'update');
$router->addRoute('/books/destroy/{id}', 'SimpleKit\Controllers\booksController', 'destroy');

$uri = $_SERVER['REQUEST_URI'];

try {
    $router->dispatch($uri);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
