<?php

namespace SimpleKit\Routers;

use SimpleKit\Controllers\HomeController;
use SimpleKit\Controllers\AuthController;
use SimpleKit\Controllers\CategoryController;
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
$router->addRoute('/createwiki', HomeController::class,'renderCreateWiki', AuthMiddleware::class, 'handleCraftPage');

//protected routes

$router->addRoute('/dashboard', HomeController::class,'renderDashboard', AuthMiddleware::class);
$router->addRoute('/craftwiki', HomeController::class,'renderCraftwiki', AuthMiddleware::class, 'handleCraftPage');

// authentication routes

$router->addRoute('/authorize', AuthController::class,'authenticate');
$router->addRoute('/registeruser', AuthController::class,'register');
$router->addRoute('/validate', AuthController::class,'validate');
$router->addRoute('/logout', AuthController::class,'logout');

//crud

$router->addRoute('/fetchwikis', WikiController::class, 'index');
$router->addRoute('/postwiki', WikiController::class, 'create', AuthController::class, 'handleCraftPage');
$router->addRoute('/fetchcategories', CategoryController::class,'fetchCategories');
$router->addRoute('/deletewiki/{id}', WikiController::class,'destroy');

$uri = $_SERVER['REQUEST_URI'];

try {
    $router->dispatch($uri);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
