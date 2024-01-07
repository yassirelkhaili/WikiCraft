<?php

namespace SimpleKit\Routers;

use SimpleKit\Controllers\HomeController;
use SimpleKit\Controllers\AuthController;

$router = new BaseRouter();

// Add more routes here

$router->addRoute('/', HomeController::class, 'renderHome');
$router->addRoute('/login', AuthController::class,'renderLogin');
$router->addRoute('/register', AuthController::class,'renderRegister');

$uri = $_SERVER['REQUEST_URI'];

try {
    $router->dispatch($uri);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
