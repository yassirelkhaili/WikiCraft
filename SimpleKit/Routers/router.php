<?php

namespace SimpleKit\Routers;

use SimpleKit\Controllers\BooksController;

$router = new BaseRouter();

$router->addRoute('/books', BooksController::class, 'index');
$router->addRoute('/books/create', BooksController::class, 'create');
$router->addRoute('/books/store', BooksController::class, 'store');
$router->addRoute('/books/show/{id}', BooksController::class, 'show');
$router->addRoute('/books/edit/{id}', BooksController::class, 'edit');
$router->addRoute('/books/update/{id}', BooksController::class, 'update');
$router->addRoute('/books/destroy/{id}', BooksController::class, 'destroy');

$uri = $_SERVER['REQUEST_URI'];

try {
    $router->dispatch($uri);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
