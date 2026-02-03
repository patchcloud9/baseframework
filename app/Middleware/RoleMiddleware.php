<?php

namespace App\Middleware;

use Core\Middleware;

/**
 * Role Middleware
 * 
 * Ensures the authenticated user has a specific role.
 * Must be used after AuthMiddleware.
 * 
 * Usage in routes:
 *   'GET' => [
 *       '/admin/dashboard' => ['AdminController', 'index', ['auth', 'role:admin']],
 *       '/moderator/posts' => ['ModeratorController', 'index', ['auth', 'role:moderator']],
 *   ]
 */
class RoleMiddleware extends Middleware
{
    public function handle(array $params = []): bool
    {
        if (empty($params)) {
            if (APP_DEBUG) {
                error_log("RoleMiddleware: No role specified");
            }
            return true;
        }
        
        $requiredRole = $params[0];
        $userRole = $_SESSION['user_role'] ?? null;
        
        // Check if user has the required role
        if ($userRole !== $requiredRole) {
            flash('error', 'You do not have permission to access this page.');
            $this->redirect('/');
            return false;
        }
        
        return true;
    }
}
