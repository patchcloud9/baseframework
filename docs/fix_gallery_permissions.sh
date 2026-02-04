#!/bin/bash
# Fix Gallery Upload Permissions
# Run this script on the server if you get permission denied errors when uploading images

echo "Fixing gallery upload directory permissions..."

# Create directory if it doesn't exist
mkdir -p /var/www/html/public/uploads/gallery

# Set ownership to web server user
chown -R www-data:www-data /var/www/html/public/uploads/gallery

# Set permissions (775 = rwxrwxr-x)
chmod -R 775 /var/www/html/public/uploads/gallery

echo "✓ Gallery upload directory permissions fixed!"
echo ""
echo "Directory: /var/www/html/public/uploads/gallery"
echo "Owner: www-data:www-data"
echo "Permissions: 775 (rwxrwxr-x)"
