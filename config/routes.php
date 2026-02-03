<?php
/**
 * Route Definitions
 * 
 * Format:
 *   'HTTP_METHOD' => [
 *       '/url/pattern'     => ['ControllerName', 'methodName'],
 *       '/with/(\d+)'      => ['ControllerName', 'methodName'],  // \d+ captures digits
 *       '/name/([a-z]+)'   => ['ControllerName', 'methodName'],  // [a-z]+ captures letters
 *   ]
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
        
        // Example routes showing URL parameters
        '/users'                => ['UserController', 'index'],
        '/users/(\d+)'          => ['UserController', 'show'],      // /users/42
        '/users/(\d+)/edit'     => ['UserController', 'edit'],      // /users/42/edit
        
        // Example with multiple parameters
        '/posts/(\d+)/comments/(\d+)' => ['PostController', 'showComment'], // /posts/5/comments/23
        
        // Debug route - shows how routing works
        '/debug'                => ['HomeController', 'debug'],

        // Logs
        '/logs'                 => ['LogController', 'index'],
        '/logs/test'            => ['LogController', 'test'],   // Add test data
        '/logs/test-file'       => ['LogController', 'testFile'], // Add test data to file only
        '/logs/(\d+)'           => ['LogController', 'show'],
    ],
    
    'POST' => [
        '/contact'              => ['HomeController', 'contactSubmit'],
        '/users'                => ['UserController', 'store'],
        '/users/(\d+)'          => ['UserController', 'update'],
        '/logs/clear'           => ['LogController', 'clear'],
        '/logs/sync'            => ['LogController', 'sync'],
    ],
    
    'DELETE' => [
        '/users/(\d+)'          => ['UserController', 'destroy'],
    ],
];
