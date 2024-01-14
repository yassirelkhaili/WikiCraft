<?php

namespace SimpleKit\Routers;

use SimpleKit\Controllers\AuthController;
use SimpleKit\Helpers\Request;

class BaseRouter {
    protected $routes = [];

    public function addRoute(string $route, string $controller, string $action, $middleware = null, string $method = "handle") {
        $this->routes[$route] = ['controller' => $controller, 'action' => $action, 'middleware' => $middleware, 'method' => $method];
    }

    public function dispatch(string $uri) {
        foreach ($this->routes as $route => $routeDetails) {
            if ($_SERVER['REQUEST_URI'] === $route) {
                if (!is_null($routeDetails['middleware'])) {
                $middlewareClass = $routeDetails['middleware'];
                $methodName = $routeDetails['method'];
            if (method_exists($middlewareClass, $methodName)) {
                $middlewareClass::$methodName();
            } else {
                throw new \Exception("Method $methodName does not exist in middleware class $middlewareClass");
            }
            }
        }
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([a-zA-Z0-9_]+)', $route);
                
        if (preg_match("#^$pattern$#", $uri, $matches)) {
            $controllerName = $routeDetails['controller'];
            $actionName = $routeDetails['action'];
            // Instantiate the controller
            $controllerInstance = new $controllerName();
            // If the request is POST, create a Request object and pass it to the controller
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $request = new Request();
                if (isset($matches[1])) {
                    $id = intval($matches[1]);
                    $controllerInstance->$actionName($request, $id);  // Pass the Request object and ID
                } else {
                
                    $controllerInstance->$actionName($request);  // Pass the Request object
                }
            } else {
                // Handle other request methods (e.g., GET) as required
                if (isset($matches[1])) {
                    $id = intval($matches[1]);
                    $controllerInstance->$actionName($id);  
                } else {
                    $controllerInstance->$actionName();  
                }
            }
            
            return;
        }
    }
    // If no route is found for the URI, throw an exception
    throw new \Exception("No route found for URI: $uri");
}
}