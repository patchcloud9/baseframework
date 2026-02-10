#!/bin/bash
# Docker entrypoint script
# Copy your entrypoint.sh configuration here
#!/bin/bash
set -e

echo "Starting Base Framework setup..."

# Create PHP upload configuration
echo "Configuring PHP upload limits..."
cat > /usr/local/etc/php/conf.d/uploads.ini <<EOF
upload_max_filesize = 10M
post_max_size = 12M
memory_limit = 256M
max_execution_time = 60
EOF

# Check if pdo_mysql extension is installed
if ! php -m | grep -q pdo_mysql; then
    echo "Installing pdo_mysql extension..."
    docker-php-ext-install pdo_mysql
    echo "pdo_mysql extension installed successfully"
else
    echo "pdo_mysql extension already installed"
fi

# Enable Apache mod_rewrite (required for front controller routing)
echo "Enabling Apache modules..."
a2enmod rewrite

# Only modify Apache config once (sed replacements are not idempotent)
if [ ! -f /var/tmp/.apache-configured ]; then
    # Change Apache DocumentRoot to /var/www/html/public
    echo "Configuring Apache DocumentRoot..."
    sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf

    # Update Directory directive path and enable AllowOverride in one pass
    echo "Enabling .htaccess overrides..."
    sed -ri -e 's!<Directory /var/www/>!<Directory /var/www/html/public>!' \
            -e '/<Directory \/var\/www\/html\/public>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' \
            /etc/apache2/apache2.conf

    touch /var/tmp/.apache-configured
fi

# Create and set permissions for storage directories
echo "Setting up storage directories..."
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/storage/cache
chown -R www-data:www-data /var/www/html/storage
chmod -R 775 /var/www/html/storage

# Create and set permissions for upload directories
echo "Setting up upload directories..."
mkdir -p /var/www/html/public/uploads/theme
mkdir -p /var/www/html/public/uploads/gallery
mkdir -p /var/www/html/public/uploads/homepage
chown -R www-data:www-data /var/www/html/public/uploads
chmod -R 775 /var/www/html/public/uploads

# Fix permissions on public directory itself
echo "Setting public directory permissions..."
chown -R www-data:www-data /var/www/html/public
chmod -R 755 /var/www/html/public
chmod 755 /var/www/html/public/index.php

# Verify critical files exist and have correct permissions
if [ ! -f /var/www/html/public/index.php ]; then
    echo "ERROR: index.php not found!"
    exit 1
fi

if [ ! -f /var/www/html/public/.htaccess ]; then
    echo "WARNING: .htaccess not found - creating default"
    cat > /var/www/html/public/.htaccess <<'HTACCESS'
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^ index.php [QSA,L]
HTACCESS
    chown www-data:www-data /var/www/html/public/.htaccess
fi

echo "=========================================="
echo "Apache Configuration Complete:"
echo "  - DocumentRoot: /var/www/html/public"
echo "  - mod_rewrite: enabled"
echo "  - AllowOverride: All"
echo "  - Storage directories: created & permissioned"
echo "  - Upload directories: created & permissioned"
echo "  - PHP upload_max_filesize: 10M"
echo "  - PHP post_max_size: 12M"
echo "=========================================="

# Start Apache in foreground
echo "Starting Apache..."
exec apache2-foreground