<?php
/**
 * Helper Functions
 * 
 * Global utility functions available throughout the application.
 * Loaded automatically in public/index.php
 */

/**
 * Escape HTML output to prevent XSS attacks
 * Shorthand for htmlspecialchars()
 * 
 * @param string $value The string to escape
 * @return string Escaped string safe for HTML output
 */
function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

/**
 * Generate a CSRF token
 * Creates and stores a token in the session if one doesn't exist
 * 
 * @return string The CSRF token
 */
function csrf_token(): string
{
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    
    return $_SESSION['csrf_token'];
}

/**
 * Generate a hidden CSRF token field for forms
 * 
 * @return string HTML input field with CSRF token
 */
function csrf_field(): string
{
    $token = csrf_token();
    return '<input type="hidden" name="csrf_token" value="' . e($token) . '">';
}

/**
 * Verify CSRF token from request
 * 
 * @param string|null $token The token to verify (from $_POST or $_GET)
 * @return bool True if token is valid
 */
function csrf_verify(?string $token): bool
{
    if (!isset($_SESSION['csrf_token']) || $token === null) {
        return false;
    }
    
    // Use hash_equals to prevent timing attacks
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Get the current URL
 * 
 * @return string Current URL
 */
function current_url(): string
{
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    return $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

/**
 * Redirect to a URL
 * 
 * @param string $url The URL to redirect to
 * @return void
 */
function redirect(string $url): void
{
    header("Location: $url");
    exit;
}

/**
 * Get old input value (after validation failure)
 * 
 * @param string $key The input field name
 * @param mixed $default Default value if not found
 * @return mixed
 */
function old(string $key, $default = '')
{
    return $_SESSION['old_input'][$key] ?? $default;
}

/**
 * Store old input in session (for repopulating forms after errors)
 * 
 * @param array $data Input data to store
 * @return void
 */
function flash_old_input(array $data): void
{
    $_SESSION['old_input'] = $data;
}

/**
 * Clear old input from session
 * 
 * @return void
 */
function clear_old_input(): void
{
    unset($_SESSION['old_input']);
}

/**
 * Check if app is in debug mode
 * 
 * @return bool
 */
function is_debug(): bool
{
    return defined('APP_DEBUG') && APP_DEBUG === true;
}

/**
 * Dump and die - for debugging
 * 
 * @param mixed ...$vars Variables to dump
 * @return void
 */
function dd(...$vars): void
{
    echo '<pre>';
    foreach ($vars as $var) {
        var_dump($var);
    }
    echo '</pre>';
    die();
}

/**
 * Get the authenticated user from the session
 * 
 * @return array|null User data if authenticated, null otherwise
 */
function auth_user(): ?array
{
    if (!isset($_SESSION['user_id'])) {
        return null;
    }
    
    return [
        'id' => $_SESSION['user_id'],
        'email' => $_SESSION['user_email'] ?? '',
        'name' => $_SESSION['user_name'] ?? '',
        'role' => $_SESSION['user_role'] ?? 'user',
    ];
}

/**
 * Check if a user is authenticated
 * 
 * @return bool
 */
function is_authenticated(): bool
{
    return isset($_SESSION['user_id']);
}

/**
 * Check if the authenticated user has a specific role
 * 
 * @param string $role Role to check (e.g., 'admin', 'user')
 * @return bool
 */
function has_role(string $role): bool
{
    if (!is_authenticated()) {
        return false;
    }
    
    return ($_SESSION['user_role'] ?? '') === $role;
}

/**
 * Check if the authenticated user is an admin
 * 
 * @return bool
 */
function is_admin(): bool
{
    return has_role('admin');
}
