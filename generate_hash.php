<?php
// Generate password hash for seed file
$password = 'password123';
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "Password: {$password}\n";
echo "Hash: {$hash}\n";
