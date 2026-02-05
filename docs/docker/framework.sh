#!/bin/bash
# Base Framework Deployment Script
# Pulls latest changes from GitHub and deploys to web server

# Git credentials (hardcoded for convenience)
# WARNING: Keep this file secure and don't share it publicly
GIT_USERNAME="patchcloud9"
GIT_TOKEN="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"

# Server username
SERVER_USER="root"

REPO_URL="https://${GIT_USERNAME}:${GIT_TOKEN}@github.com/patchcloud9/baseframework.git"
REPO_DIR="/home/${SERVER_USER}/baseframework-repo"
WEB_DIR="/srv/docker_data/baseframework/var_www_html"

echo "Starting Base Framework deployment..."

# Clone if doesn't exist
if [ ! -d "$REPO_DIR" ]; then
    echo "Cloning repository for first time..."
    git clone "$REPO_URL" "$REPO_DIR"
else
    echo "Repository exists, updating remote URL with credentials..."
    cd "$REPO_DIR"
    git remote set-url origin "$REPO_URL"
fi

# Pull latest changes
echo "Pulling latest changes..."
cd "$REPO_DIR"
git pull origin main

# Copy files to web directory
# Note: Unlike mvelopes3, baseframework repo root IS the web root (no vs_code subfolder)
echo "Deploying files to $WEB_DIR..."
rsync -av --delete \
    --exclude '.git' \
    --exclude '.gitignore' \
    --exclude 'docs' \
    --exclude 'database' \
    --exclude '.github' \
    --exclude '.vscode' \
    --exclude 'public/uploads/' \
    --exclude 'storage/logs/' \
    --exclude 'storage/cache/' \
    "$REPO_DIR/" "$WEB_DIR/"

# Ensure public assets are explicitly synced (some deploy targets may have rsync filters)
echo "Ensuring public assets are synced..."
rsync -av --delete "$REPO_DIR/public/assets/" "$WEB_DIR/public/assets/"

# Post-deploy verification for critical front-end assets
echo "Verifying critical assets exist and are up-to-date..."
FILES_TO_CHECK=("public/assets/css/app.css" "public/assets/js/app.js")
MISSING=0
for f in "${FILES_TO_CHECK[@]}"; do
    if [ ! -f "$WEB_DIR/$f" ]; then
        echo "ERROR: $f is missing from $WEB_DIR"
        MISSING=1
    else
        REPO_MTIME=$(stat -c %Y "$REPO_DIR/$f" 2>/dev/null || echo "-")
        WEB_MTIME=$(stat -c %Y "$WEB_DIR/$f" 2>/dev/null || echo "-")
        echo "Found $f (repo mtime: $REPO_MTIME ; web mtime: $WEB_MTIME)"
        if [ "$REPO_MTIME" != "-" ] && [ "$REPO_MTIME" -ne "$WEB_MTIME" ]; then
            echo "WARNING: $f on the web server does not match repo mtime. You may have an out-of-date file or caching layer."
        fi
    fi
done

if [ "$MISSING" -ne 0 ]; then
    echo "ERROR: Deployment incomplete. One or more critical assets are missing. Aborting."
    exit 1
fi

echo "Asset verification complete."

# Set proper permissions
echo "Setting file permissions..."
sudo chown -R root:root "$WEB_DIR"
sudo chmod -R 755 "$WEB_DIR"

# Make storage writable by www-data (Apache)
echo "Setting storage permissions..."
sudo chown -R www-data:www-data "$WEB_DIR/storage"
sudo chmod -R 775 "$WEB_DIR/storage"

# Make uploads writable by www-data (Apache)
echo "Setting upload directory permissions..."
sudo mkdir -p "$WEB_DIR/public/uploads/theme"
sudo mkdir -p "$WEB_DIR/public/uploads/gallery"
sudo mkdir -p "$WEB_DIR/public/uploads/homepage"
sudo chown -R www-data:www-data "$WEB_DIR/public/uploads"
sudo chmod -R 775 "$WEB_DIR/public/uploads"

echo ""
echo "Deployment complete!"
echo "Files deployed from: $REPO_DIR"
echo "Files deployed to: $WEB_DIR"
echo ""
