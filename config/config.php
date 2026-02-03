<?php
/**
 * Main Configuration File
 * 
 * In a real app, you'd load these from a .env file.
 * For now, we'll keep it simple with constants.
 */

// Application settings
define('APP_NAME', 'My PHP Framework');
define('APP_ENV', 'development');  // 'development' or 'production'
define('APP_DEBUG', true);
define('APP_URL', 'http://localhost:8080');

// Database settings (for later)
define('DB_HOST', 'localhost');
define('DB_NAME', 'myapp');
define('DB_USER', 'root');
define('DB_PASS', '');

// Timezone
date_default_timezone_set('America/Los_Angeles');
