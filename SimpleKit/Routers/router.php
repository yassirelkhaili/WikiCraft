<?php

namespace SimpleKit\Routers;

use SimpleKit\Controllers\HomeController;
use SimpleKit\Controllers\AuthController;
use SimpleKit\Controllers\WikiController;
use SimpleKit\Middleware\AuthMiddleware;
use SimpleKit\Middleware\Cors;

//add cors using middleware

Cors::handle();

//initialize BaseRouter

$router = new BaseRouter();

// Add more routes here

$router->addRoute('/', HomeController::class, 'renderHome');
$router->addRoute('/login', HomeController::class,'renderLogin');
$router->addRoute('/register', HomeController::class,'renderRegister');
$router->addRoute('/createwiki', WikiController::class,'renderCreateWiki', AuthMiddleware::class);
// authentication routes

$router->addRoute('/authorize', AuthController::class,'authenticate');
$router->addRoute('/registeruser', AuthController::class,'register');
$router->addRoute('/validate', AuthController::class,'validate');
$router->addRoute('/logout', AuthController::class,'logout');

//protected routes

$router->addRoute('/dashboard', HomeController::class,'renderDashboard', AuthMiddleware::class);
$router->addRoute('/craftwiki', HomeController::class,'renderCraftwiki', AuthMiddleware::class, 'handleCraftPage');

//crud

$router->addRoute('/fetchwikis', WikiController::class, 'index');

$uri = $_SERVER['REQUEST_URI'];

try {
    $router->dispatch($uri);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
