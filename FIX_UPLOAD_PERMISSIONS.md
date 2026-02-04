# Fix Upload Directory Permissions

If you're getting "Permission denied" errors when uploading logos or favicons, run these commands on your server:

## Quick Fix (On the Server)

```bash
# SSH into your server
ssh user@framework.hexgrid.org

# Navigate to your project directory
cd /var/www/html

# Create the uploads directory if it doesn't exist
sudo mkdir -p public/uploads/theme

# Set proper ownership (www-data is the Apache/nginx user)
sudo chown -R www-data:www-data public/uploads

# Set proper permissions (775 allows write access)
sudo chmod -R 775 public/uploads

# Verify permissions
ls -la public/uploads/
```

## Verify It Works

After running the commands above:
1. Go to `/admin/theme` in your browser
2. Try uploading a new logo or favicon
3. The upload should now work without errors

## For Docker Users

If using Docker, the entrypoint.sh script should handle this automatically. 
If you're still having issues, rebuild your container:

```bash
docker-compose down
docker-compose up -d --build
```

## Permanent Fix

To prevent this issue in the future, ensure your deployment script includes:

```bash
mkdir -p public/uploads/theme
chown -R www-data:www-data public/uploads
chmod -R 775 public/uploads
```
