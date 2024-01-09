<?php

namespace SimpleKit\Routers;

use SimpleKit\Controllers\HomeController;
use SimpleKit\Controllers\AuthController;
use SimpleKit\Middleware\Cors;

//add cors using middleware

Cors::handle();

//initialize BaseRouter

$router = new BaseRouter();

// Add more routes here

$router->addRoute('/', HomeController::class, 'renderHome');
$router->addRoute('/login', HomeController::class,'renderLogin');
$router->addRoute('/register', HomeController::class,'renderRegister');

// authentication routes

$router->addRoute('/authorize', AuthController::class,'authenticate');
$router->addRoute('/registeruser', AuthController::class,'register');
$router->addRoute('/validate', AuthController::class,'validate');
$router->addRoute('/logout', AuthController::class,'logout');

//protected routes

$router->addRoute('/dashboard', HomeController::class,'renderDashboard', ['middleware' => 'SimpleKit\Middleware\AuthMiddleware']);

$uri = $_SERVER['REQUEST_URI'];

try {
    $router->dispatch($uri);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
