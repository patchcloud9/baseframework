<?php
// Test password verification

$password = 'password123';
$hash = '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFVNHMyIBnRaV59bGYWJJYkAqNBaEoW2';

echo "Testing password: {$password}\n";
echo "Against hash: {$hash}\n\n";

if (password_verify($password, $hash)) {
    echo "✓ Password verification SUCCESSFUL\n";
} else {
    echo "✗ Password verification FAILED\n";
    echo "\nGenerating new hash...\n";
    $newHash = password_hash($password, PASSWORD_DEFAULT);
    echo "New hash: {$newHash}\n";
    
    // Test the new hash
    if (password_verify($password, $newHash)) {
        echo "✓ New hash works!\n";
    }
}
