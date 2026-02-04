# Gallery Upload Directory

This directory stores uploaded gallery images.

## File Management

- Images are uploaded through the admin panel at `/admin/gallery`
- Files are automatically named with unique IDs to prevent collisions
- Supported formats: JPG, PNG, GIF, WebP
- Maximum file size: 5MB

## Permissions

This directory requires write permissions for the web server:
- Docker: Automatically set by entrypoint.sh (775, www-data:www-data)
- Manual: `chmod 775 public/uploads/gallery`

## Security

- File type validation enforced at upload (MIME type checking)
- File size limits prevent resource exhaustion
- Unique filenames prevent overwriting
- All files served with proper Content-Type headers

## Maintenance

To clean up orphaned files (images deleted from database but not filesystem):
1. Compare files in this directory with `gallery_images.file_path` in database
2. Remove any files not referenced in database
3. Consider implementing automated cleanup via cron job
