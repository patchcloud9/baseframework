<?php

namespace App\Models;

/**
 * GalleryImage Model
 * 
 * Represents an image in the gallery.
 * 
 * Usage:
 *   $image = GalleryImage::find(1);
 *   $images = GalleryImage::all();
 *   $image = GalleryImage::create([
 *       'title' => 'Sunset',
 *       'description' => 'Beautiful sunset photo',
 *       'filename' => 'sunset.jpg',
 *       'file_path' => '/uploads/gallery/sunset.jpg',
 *       'uploaded_by' => 1
 *   ]);
 */
class GalleryImage extends Model
{
    protected string $table = 'gallery_images';
    
    protected array $fillable = [
        'title',
        'description',
        'filename',
        'file_path',
        'uploaded_by',
    ];
    
    protected bool $timestamps = true;
    
    /**
     * Get images uploaded by a specific user
     */
    public static function getByUser(int $userId): array
    {
        return static::where(['uploaded_by' => $userId]);
    }
    
    /**
     * Get recent images
     */
    public static function recent(int $limit = 12): array
    {
        $instance = new static();
        
        $sql = "SELECT * FROM {$instance->table} ORDER BY created_at DESC LIMIT ?";
        return $instance->getDatabase()->fetchAll($sql, [$limit]);
    }
    
    /**
     * Get image with uploader information
     */
    public static function findWithUploader(int $id): ?array
    {
        $instance = new static();
        
        $sql = "SELECT gi.*, u.name as uploader_name 
                FROM {$instance->table} gi
                LEFT JOIN users u ON gi.uploaded_by = u.id
                WHERE gi.id = ?
                LIMIT 1";
        
        return $instance->getDatabase()->fetch($sql, [$id]);
    }
    
    /**
     * Get all images with uploader information
     */
    public static function allWithUploaders(): array
    {
        $instance = new static();
        
        $sql = "SELECT gi.*, u.name as uploader_name 
                FROM {$instance->table} gi
                LEFT JOIN users u ON gi.uploaded_by = u.id
                ORDER BY gi.created_at DESC";
        
        return $instance->getDatabase()->fetchAll($sql);
    }
    
    /**
     * Get paginated images with uploader information
     * 
     * @param int $page Current page number (1-based)
     * @param int $perPage Number of items per page
     * @return array ['images' => array, 'total' => int, 'page' => int, 'totalPages' => int]
     */
    public static function paginate(int $page = 1, int $perPage = 12): array
    {
        $instance = new static();
        
        // Ensure page is at least 1
        $page = max(1, $page);
        
        // Calculate offset
        $offset = ($page - 1) * $perPage;
        
        // Get total count
        $countSql = "SELECT COUNT(*) as total FROM {$instance->table}";
        $countResult = $instance->getDatabase()->fetch($countSql);
        $total = (int) $countResult['total'];
        
        // Calculate total pages
        $totalPages = (int) ceil($total / $perPage);
        
        // Get paginated images
        $sql = "SELECT gi.*, u.name as uploader_name 
                FROM {$instance->table} gi
                LEFT JOIN users u ON gi.uploaded_by = u.id
                ORDER BY gi.created_at DESC
                LIMIT ? OFFSET ?";
        
        $images = $instance->getDatabase()->fetchAll($sql, [$perPage, $offset]);
        
        return [
            'images' => $images,
            'total' => $total,
            'page' => $page,
            'totalPages' => $totalPages,
            'perPage' => $perPage
        ];
    }
}
