<?php

namespace App\Middleware;

use Core\Middleware;

/**
 * Authentication Middleware
 * 
 * Ensures user is logged in before accessing protected routes.
 * Redirects to login page if not authenticated.
 * 
 * Usage in routes:
 *   'GET' => [
 *       '/dashboard' => ['HomeController', 'dashboard', ['auth']],
 *       '/admin/users' => ['AdminController', 'index', ['auth']],
 *   ]
 */
class AuthMiddleware extends Middleware
{
    public function handle(array $params = []): bool
    {
        // Check if user is authenticated
        if (!isset($_SESSION['user_id'])) {
            // Store the intended destination
            $_SESSION['intended_url'] = $_SERVER['REQUEST_URI'];
            
            \flash('error', 'Please log in to access this page.');
            $this->redirect('/login');
            return false;
        }
        
        return true;
    }
}
