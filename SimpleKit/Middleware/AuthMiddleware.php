<?php

namespace SimpleKit\Middleware;

use function SimpleKit\Helpers\redirect;

class AuthMiddleware {
    public static function handle() {
        // If the user is already on the login page, allow the request to continue
        if ($_SERVER['REQUEST_URI'] === '/login') {
            return;
        }

        // If session token is not set, redirect to login
        if (!isset($_SESSION['session_token']) || $_SESSION['user_role'] !== 'admin') {
            redirect(isset($_SESSION['session_token']) ? '/' : '/login');
        }        
    }

    public static function handleCraftPage() {
        if ($_SERVER['REQUEST_URI'] === '/login' || $_SERVER['REQUEST_URI'] === '/dashboard') {
            return;
        }

        if (!isset($_SESSION['session_token'])) {
            redirect('/login');
        }
        if ($_SESSION['user_role'] === 'admin') { 
            redirect('/dashboard');
    }
    }
}