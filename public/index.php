<?php
/**
 * Front Controller
 * 
 * This is the single entry point for all requests.
 * Apache's .htaccess redirects everything here.
 */

// Show errors during development (disable in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Define the base path for the application
define('BASE_PATH', dirname(__DIR__));

// Load the configuration
require_once BASE_PATH . '/config/config.php';

// Load the autoloader
require_once BASE_PATH . '/core/Autoloader.php';

// Load helper functions
require_once BASE_PATH . '/core/helpers.php';

// Start session with secure settings
session_start([
    'cookie_httponly' => true,
    'cookie_secure' => APP_ENV === 'production',
    'cookie_samesite' => 'Strict',
    'use_strict_mode' => true,
]);

// Get the request URI and method
// parse_url extracts just the path, ignoring query strings
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Create router and dispatch the request
$router = new Core\Router();
$router->dispatch($method, $uri);
