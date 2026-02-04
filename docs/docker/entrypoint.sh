#!/bin/bash
# Docker entrypoint script
# Copy your entrypoint.sh configuration here
#!/bin/bash
set -e

# Check if pdo_mysql extension is installed
if ! php -m | grep -q pdo_mysql; then
    echo "Installing pdo_mysql extension..."
    docker-php-ext-install pdo_mysql
    echo "pdo_mysql extension installed successfully"
else
    echo "pdo_mysql extension already installed"
fi

# Enable Apache mod_rewrite (required for front controller routing)
a2enmod rewrite

# Change Apache DocumentRoot to /var/www/html/public
sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf
sed -ri -e 's!/var/www/!/var/www/html/public!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Enable .htaccess overrides (required for URL rewriting)
sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Create storage directories if they don't exist and set permissions
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/storage/cache
chown -R www-data:www-data /var/www/html/storage

# Create uploads directory for theme assets and gallery
mkdir -p /var/www/html/public/uploads/theme
mkdir -p /var/www/html/public/uploads/gallery
mkdir -p /var/www/html/public/uploads/homepage
chown -R www-data:www-data /var/www/html/public/uploads
chmod -R 775 /var/www/html/public/uploads

echo "=========================================="
echo "Apache configured:"
echo "  - DocumentRoot: /var/www/html/public"
echo "  - mod_rewrite: enabled"
echo "  - AllowOverride: All"
echo "  - Storage directories: created"
echo "  - Upload directories: created"
echo "=========================================="

# Start Apache in foreground
exec apache2-foreground