<?php

namespace SimpleKit\Routers;

class BaseRouter {
    protected $routes = [];

    public function addRoute(string $route, string $controller, string $action) {
        $this->routes[$route] = ['controller' => $controller, 'action' => $action];
    }

    public function dispatch(string $uri) {
        foreach ($this->routes as $route => $routeDetails) {
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([a-zA-Z0-9_]+)', $route);
            if (preg_match("#^$pattern$#", $uri, $matches)) {
                $controllerName = $routeDetails['controller'];
                $actionName = $routeDetails['action'];
                $controllerInstance = new $controllerName();
                if (isset($matches[1])) {
                $id = intval($matches[1]);
                $controllerInstance->$actionName($id);  
                } else {
                $controllerInstance->$actionName();  
                }
                return;
            }
        }
        
        throw new \Exception("No route found for URI: $uri");
    }
    
}