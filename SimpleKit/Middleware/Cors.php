<?php

namespace SimpleKit\Middleware;

class Cors {
    public static function handle() {
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: POST, GET, DELETE, PUT");
header('Access-Control-Allow-Headers: Content-Type, Authorization');
    }
}