<?php

namespace App\Controllers;

use App\Models\GalleryImage;
use App\Services\LogService;
use Core\Validator;

/**
 * Gallery Controller
 * 
 * Handles both public gallery viewing and admin management.
 * 
 * Public routes:
 * - GET /gallery - View all images
 * - GET /gallery/{id} - View single image
 * 
 * Admin routes:
 * - GET /admin/gallery - Manage images (upload/delete)
 * - POST /admin/gallery - Upload new image
 * - DELETE /admin/gallery/{id} - Delete image
 */
class GalleryController extends Controller
{
    private LogService $logService;
    
    public function __construct()
    {
        $this->logService = new LogService();
    }
    
    /**
     * Public gallery - show all images in card layout
     */
    public function index(): void
    {
        $images = GalleryImage::allWithUploaders();
        
        $this->view('gallery/index', [
            'title' => 'Gallery',
            'images' => $images
        ]);
    }
    
    /**
     * Show single image with details
     */
    public function show(string $id): void
    {
        $imageId = (int) $id;
        $image = GalleryImage::findWithUploader($imageId);
        
        if (!$image) {
            throw new \Core\Exceptions\NotFoundHttpException("Image not found");
        }
        
        $this->view('gallery/show', [
            'title' => $image['title'],
            'image' => $image
        ]);
    }
    
    /**
     * Admin gallery management page
     */
    public function adminIndex(): void
    {
        $images = GalleryImage::allWithUploaders();
        $stats = [
            'total' => count($images),
            'recent' => count(array_filter($images, function($img) {
                return strtotime($img['created_at']) > strtotime('-7 days');
            }))
        ];
        
        $this->view('gallery/admin', [
            'title' => 'Manage Gallery',
            'images' => $images,
            'stats' => $stats
        ]);
    }
    
    /**
     * Upload new image (admin only)
     */
    public function store(): void
    {
        // Validate form input
        $validator = new Validator([
            'title' => $this->input('title'),
            'description' => $this->input('description'),
        ]);
        
        $validator->rules([
            'title' => ['required', 'min:3', 'max:255'],
            'description' => ['max:1000']
        ]);
        
        if (!$validator->validate()) {
            $this->flash('danger', 'Validation failed: ' . implode(', ', $validator->errors()));
            $this->redirect('/admin/gallery');
            return;
        }
        
        // Validate file upload
        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            $this->flash('danger', 'No image uploaded or upload error occurred');
            $this->redirect('/admin/gallery');
            return;
        }
        
        $file = $_FILES['image'];
        
        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        
        if (!in_array($mimeType, $allowedTypes)) {
            $this->flash('danger', 'Invalid file type. Only JPG, PNG, GIF, and WebP images are allowed.');
            $this->redirect('/admin/gallery');
            return;
        }
        
        // Validate file size (max 5MB)
        if ($file['size'] > 5 * 1024 * 1024) {
            $this->flash('danger', 'File size too large. Maximum 5MB allowed.');
            $this->redirect('/admin/gallery');
            return;
        }
        
        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('gallery_', true) . '.' . $extension;
        
        // Upload directory
        $uploadDir = BASE_PATH . '/public/uploads/gallery';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $filePath = $uploadDir . '/' . $filename;
        
        // Move uploaded file
        if (!move_uploaded_file($file['tmp_name'], $filePath)) {
            $this->flash('danger', 'Failed to save uploaded file');
            $this->redirect('/admin/gallery');
            return;
        }
        
        // Save to database
        $image = GalleryImage::create([
            'title' => $this->input('title'),
            'description' => $this->input('description') ?? '',
            'filename' => $filename,
            'file_path' => '/uploads/gallery/' . $filename,
            'uploaded_by' => auth_user()['id']
        ]);
        
        // Log the action
        $this->logService->add('info', 'Gallery image uploaded', [
            'image_id' => $image['id'],
            'title' => $image['title'],
            'user_id' => auth_user()['id'],
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
        ]);
        
        $this->flash('success', 'Image uploaded successfully!');
        $this->redirect('/admin/gallery');
    }
    
    /**
     * Delete image (admin only)
     */
    public function destroy(string $id): void
    {
        $imageId = (int) $id;
        $image = GalleryImage::find($imageId);
        
        if (!$image) {
            $this->flash('danger', 'Image not found');
            $this->redirect('/admin/gallery');
            return;
        }
        
        // Delete physical file
        $filePath = BASE_PATH . '/public' . $image['file_path'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        
        // Delete from database
        GalleryImage::delete($imageId);
        
        // Log the action
        $this->logService->add('info', 'Gallery image deleted', [
            'image_id' => $imageId,
            'title' => $image['title'],
            'user_id' => auth_user()['id'],
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
        ]);
        
        $this->flash('success', 'Image deleted successfully');
        $this->redirect('/admin/gallery');
    }
}
