<?php
/**
 * Route Definitions
 * 
 * Format:
 *   'HTTP_METHOD' => [
 *       '/url/pattern'     => ['ControllerName', 'methodName'],
 *       '/with/(\d+)'      => ['ControllerName', 'methodName', ['middleware']],
 *   ]
 * 
 * Middleware:
 *   Third array element is optional middleware list:
 *   - 'csrf'                              - CSRF protection
 *   - 'auth'                              - Require authentication
 *   - 'guest'                             - Require NOT authenticated
 *   - 'rate-limit:key,max,seconds'        - Rate limiting
 *   - 'log-request'                       - Log the request
 * 
 * Examples:
 *   ['HomeController', 'index', ['log-request']]
 *   ['UserController', 'store', ['csrf', 'rate-limit:user-creation,3,300']]
 *   ['AdminController', 'index', ['auth', 'log-request']]
 * 
 * Common regex patterns:
 *   (\d+)       - One or more digits (for IDs)
 *   ([a-z]+)    - One or more lowercase letters
 *   ([a-z0-9-]+) - Lowercase letters, numbers, and hyphens (for slugs)
 *   (.+)        - Anything (be careful with this one)
 */

return [
    'GET' => [
        // Home routes
        '/'                     => ['HomeController', 'index'],
        '/about'                => ['HomeController', 'about'],
        '/contact'              => ['HomeController', 'contact'],
        
        // Authentication routes
        '/login'                => ['AuthController', 'showLogin', ['guest']],
        '/register'             => ['AuthController', 'showRegister', ['guest']],
        
        // Admin Panel
        '/admin'                => ['AdminController', 'index', ['auth', 'role:admin']],
        
        // User Management (Admin Only)
        '/admin/users'          => ['UserController', 'index', ['auth', 'role:admin']],
        '/admin/users/create'   => ['UserController', 'create', ['auth', 'role:admin']],
        '/admin/users/(\d+)/edit' => ['UserController', 'edit', ['auth', 'role:admin']],
        
        // Example with multiple parameters
        '/posts/(\d+)/comments/(\d+)' => ['PostController', 'showComment'], // /posts/5/comments/23
        
        // Debug route - shows how routing works (Admin Only)
        '/debug'                => ['HomeController', 'debug', ['auth', 'role:admin']],

        // Logs (Admin Only)
        '/logs'                 => ['LogController', 'index', ['auth', 'role:admin']],
        '/logs/(\d+)'           => ['LogController', 'show', ['auth', 'role:admin']],
    ],
    
    'POST' => [
        // Authentication routes
        '/login'                => ['AuthController', 'login', ['guest', 'csrf', 'rate-limit:login,5,300']],
        '/register'             => ['AuthController', 'register', ['guest', 'csrf', 'rate-limit:register,3,600']],
        '/logout'               => ['AuthController', 'logout', ['auth', 'csrf']],
        
        // User Management (Admin Only)
        '/admin/users'          => ['UserController', 'store', ['auth', 'role:admin', 'csrf', 'rate-limit:user-creation,3,300']],
        '/admin/users/(\d+)'    => ['UserController', 'update', ['auth', 'role:admin', 'csrf']],
        
        // Logs (Admin Only)
        '/logs/clear'           => ['LogController', 'clear', ['auth', 'role:admin', 'csrf']],
        '/logs/sync'            => ['LogController', 'sync', ['auth', 'role:admin', 'csrf']],
    ],
    
    'DELETE' => [
        '/admin/users/(\d+)'    => ['UserController', 'destroy', ['auth', 'role:admin', 'csrf']],
    ],
];
