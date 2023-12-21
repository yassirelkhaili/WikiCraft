<?php

namespace SimpleKit\Routers;

require __DIR__ . "/../Routers/BaseRouter.php";

$router = new BaseRouter();

$router->addRoute('/books', '/SimpleKit/Controllers/BooksController', 'index');
$router->addRoute('/books/create', 'BooksController', 'create');
$router->addRoute('/books/store', 'BooksController', 'store');
$router->addRoute('/books/show/{id}', 'BooksController', 'show');
$router->addRoute('/books/edit/{id}', 'BooksController', 'edit');
$router->addRoute('/books/update/{id}', 'BooksController', 'update');
$router->addRoute('/books/destroy/{id}', 'BooksController', 'destroy');

$uri = $_SERVER['REQUEST_URI'];

try {
    $router->dispatch($uri);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
