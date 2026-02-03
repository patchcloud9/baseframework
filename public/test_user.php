<?php
// Debug script - check user in database

// Define the base path for the application
define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/config/config.php';
require_once BASE_PATH . '/core/Autoloader.php';

use App\Models\User;

// Test finding Eve
$eve = User::findByEmail('eve@example.com');

echo "<h2>User Lookup Test</h2>";
echo "<pre>";
if ($eve) {
    echo "Found user:\n";
    echo "ID: " . $eve['id'] . "\n";
    echo "Name: " . $eve['name'] . "\n";
    echo "Email: " . $eve['email'] . "\n";
    echo "Role: " . $eve['role'] . "\n";
    echo "Password hash (first 50 chars): " . substr($eve['password'], 0, 50) . "...\n\n";
    
    // Test password verification
    $password = 'password123';
    $result = password_verify($password, $eve['password']);
    
    echo "Password verification test:\n";
    echo "Testing password: '{$password}'\n";
    echo "Result: " . ($result ? "SUCCESS ✓" : "FAILED ✗") . "\n\n";
    
    // If failed, generate what the hash should be
    if (!$result) {
        echo "Generating correct hash for '{$password}':\n";
        $correctHash = password_hash($password, PASSWORD_DEFAULT);
        echo $correctHash . "\n";
    }
} else {
    echo "User not found in database!\n";
    echo "Checking all users:\n\n";
    $allUsers = User::all();
    foreach ($allUsers as $user) {
        echo $user['email'] . " - " . $user['name'] . "\n";
    }
}
echo "</pre>";
