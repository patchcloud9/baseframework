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
        
        // Example routes showing URL parameters
        '/users'                => ['UserController', 'index'],
        '/users/create'         => ['UserController', 'create', ['auth']],
        '/users/(\d+)/edit'     => ['UserController', 'edit'],      // /users/42/edit
        
        // Example with multiple parameters
        '/posts/(\d+)/comments/(\d+)' => ['PostController', 'showComment'], // /posts/5/comments/23
        
        // Debug route - shows how routing works
        '/debug'                => ['HomeController', 'debug'],

        // Logs
        '/logs'                 => ['LogController', 'index'],
        '/logs/(\d+)'           => ['LogController', 'show'],
    ],
    
    'POST' => [
        // Authentication routes
        '/login'                => ['AuthController', 'login', ['guest', 'csrf', 'rate-limit:login,5,300']],
        '/register'             => ['AuthController', 'register', ['guest', 'csrf', 'rate-limit:register,3,600']],
        '/logout'               => ['AuthController', 'logout', ['auth', 'csrf']],
        
        // Contact and user routes
        '/contact'              => ['HomeController', 'contactSubmit', ['csrf', 'rate-limit:contact-form,5,60']],
        '/users'                => ['UserController', 'store', ['csrf', 'rate-limit:user-creation,3,300']],
        '/users/(\d+)'          => ['UserController', 'update', ['csrf']],
        '/logs/clear'           => ['LogController', 'clear', ['csrf']],
        '/logs/sync'            => ['LogController', 'sync', ['csrf']],
    ],
    
    'DELETE' => [
        '/users/(\d+)'          => ['UserController', 'destroy', ['csrf']],
    ],
];
