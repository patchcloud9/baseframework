<?php
/**
 * Main Configuration File
 * 
 * In a real app, you'd load these from a .env file.
 * For now, we'll keep it simple with constants.
 */

// Application settings
define('APP_NAME', 'Base Framework');
define('APP_ENV', 'development');  // 'development' or 'production'
define('APP_DEBUG', true);
define('APP_URL', 'https://framework.hexgrid.org');

// Database settings (for later)
define('DB_HOST', 'maria_db_mvelopes1');
define('DB_NAME', 'baseframework');
define('DB_USER', 'root');
define('DB_PASS', 'LrVTRoKd5SUKAt3XF3BvsW1r');

// Timezone
date_default_timezone_set('America/Los_Angeles');
