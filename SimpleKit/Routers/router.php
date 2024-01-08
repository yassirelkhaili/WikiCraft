<?php

namespace SimpleKit\Routers;

use SimpleKit\Controllers\HomeController;
use SimpleKit\Controllers\AuthController;

$router = new BaseRouter();

// Add more routes here

$router->addRoute('/', HomeController::class, 'renderHome');
$router->addRoute('/login', HomeController::class,'renderLogin');
$router->addRoute('/register', HomeController::class,'renderRegister');

// authentication routes

$router->addRoute('/authorize', AuthController::class,'authenticate');
$router->addRoute('/validate', AuthController::class,'validate');

$uri = $_SERVER['REQUEST_URI'];

try {
    $router->dispatch($uri);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
