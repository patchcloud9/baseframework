<?php

namespace App\Controllers;

use App\Models\HomepageSetting;
use Core\Validator;

/**
 * Homepage Controller
 * 
 * Manages homepage customization (admin only).
 */
class HomepageController extends Controller
{
    /**
     * Show homepage settings form
     * Route: GET /admin/homepage
     */
    public function index(): void
    {
        $settings = HomepageSetting::getSettings();
        
        // If no settings exist yet, create defaults
        if (!$settings) {
            $this->flash('info', 'No homepage settings found. Using defaults.');
        }
        
        $this->view('admin/homepage', [
            'title' => 'Homepage Settings',
            'settings' => $settings
        ]);
    }
    
    /**
     * Update homepage settings
     * Route: POST /admin/homepage
     * Middleware: auth, role:admin, csrf
     */
    public function update(): void
    {
        // Validate input
        $validator = new Validator($_POST, [
            'hero_title' => 'required|max:100',
            'hero_subtitle' => 'max:255',
            'hero_background_type' => 'required|in:color,image',
            'card1_title' => 'required|max:100',
            'card2_title' => 'required|max:100',
            'card3_title' => 'required|max:100',
            'cta_button_text' => 'required|max:100',
            'cta_button_link' => 'required|max:255',
            'bottom_section_layout' => 'required|in:text-image,image-text',
            'bottom_section_title' => 'required|max:255',
        ]);
        
        if ($validator->fails()) {
            $errors = $validator->errors();
            $firstError = reset($errors)[0];
            $this->flash('error', $firstError);
            $this->redirect('/admin/homepage');
            return;
        }
        
        // Prepare update data
        $updateData = [
            'hero_title' => $this->input('hero_title'),
            'hero_subtitle' => $this->input('hero_subtitle'),
            'hero_background_type' => $this->input('hero_background_type'),
            'hero_background_color' => $this->input('hero_background_color'),
            'card1_icon' => $this->input('card1_icon'),
            'card1_title' => $this->input('card1_title'),
            'card1_text' => $this->input('card1_text'),
            'card2_icon' => $this->input('card2_icon'),
            'card2_title' => $this->input('card2_title'),
            'card2_text' => $this->input('card2_text'),
            'card3_icon' => $this->input('card3_icon'),
            'card3_title' => $this->input('card3_title'),
            'card3_text' => $this->input('card3_text'),
            'cta_button_text' => $this->input('cta_button_text'),
            'cta_button_link' => $this->input('cta_button_link'),
            'bottom_section_layout' => $this->input('bottom_section_layout'),
            'bottom_section_title' => $this->input('bottom_section_title'),
            'bottom_section_text' => $this->input('bottom_section_text'),
        ];
        
        // Get existing settings to preserve image paths if not uploading new ones
        $existingSettings = HomepageSetting::getSettings();
        
        // Handle hero background image upload
        if (isset($_FILES['hero_background_image']) && $_FILES['hero_background_image']['error'] === UPLOAD_ERR_OK) {
            $imagePath = $this->handleFileUpload($_FILES['hero_background_image'], 'hero');
            if ($imagePath) {
                $updateData['hero_background_image'] = $imagePath;
            }
        } elseif (!empty($existingSettings['hero_background_image'])) {
            // Preserve existing hero image
            $updateData['hero_background_image'] = $existingSettings['hero_background_image'];
        }
        
        // Handle bottom section image upload
        if (isset($_FILES['bottom_section_image']) && $_FILES['bottom_section_image']['error'] === UPLOAD_ERR_OK) {
            $imagePath = $this->handleFileUpload($_FILES['bottom_section_image'], 'content');
            if ($imagePath) {
                $updateData['bottom_section_image'] = $imagePath;
            }
        } elseif (!empty($existingSettings['bottom_section_image'])) {
            // Preserve existing bottom section image
            $updateData['bottom_section_image'] = $existingSettings['bottom_section_image'];
        }
        
        // Update settings
        if (HomepageSetting::updateSettings($updateData)) {
            $this->flash('success', 'Homepage settings updated successfully!');
        } else {
            $this->flash('error', 'Failed to update homepage settings');
        }
        
        $this->redirect('/admin/homepage');
    }
    
    /**
     * Clear hero background image
     * Route: POST /admin/homepage/clear-hero-image
     * Middleware: auth, role:admin, csrf
     */
    public function clearHeroImage(): void
    {
        $settings = HomepageSetting::getSettings();
        
        if ($settings && !empty($settings['hero_background_image'])) {
            // Delete the physical file
            $filePath = BASE_PATH . '/public' . $settings['hero_background_image'];
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
            
            // Update database
            HomepageSetting::updateSettings(['hero_background_image' => '']);
            $this->flash('success', 'Hero background image cleared successfully!');
        } else {
            $this->flash('info', 'No hero background image to clear');
        }
        
        $this->redirect('/admin/homepage');
    }
    
    /**
     * Clear bottom section image
     * Route: POST /admin/homepage/clear-bottom-image
     * Middleware: auth, role:admin, csrf
     */
    public function clearBottomImage(): void
    {
        $settings = HomepageSetting::getSettings();
        
        if ($settings && !empty($settings['bottom_section_image'])) {
            // Delete the physical file
            $filePath = BASE_PATH . '/public' . $settings['bottom_section_image'];
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
            
            // Update database
            HomepageSetting::updateSettings(['bottom_section_image' => '']);
            $this->flash('success', 'Bottom section image cleared successfully!');
        } else {
            $this->flash('info', 'No bottom section image to clear');
        }
        
        $this->redirect('/admin/homepage');
    }
    
    /**
     * Handle file upload
     */
    private function handleFileUpload(array $file, string $prefix): ?string
    {
        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        
        if (!in_array($mimeType, $allowedTypes)) {
            $this->flash('warning', 'Invalid image type for ' . $prefix . '. Only JPG, PNG, GIF, and WebP allowed.');
            return null;
        }
        
        // Validate file size (max 5MB)
        if ($file['size'] > 5 * 1024 * 1024) {
            $this->flash('warning', 'Image too large for ' . $prefix . '. Maximum 5MB allowed.');
            return null;
        }
        
        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = $prefix . '_' . uniqid() . '.' . $extension;
        
        // Upload directory
        $uploadDir = BASE_PATH . '/public/uploads/homepage';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0775, true);
        }
        
        $filePath = $uploadDir . '/' . $filename;
        
        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            return '/uploads/homepage/' . $filename;
        }
        
        $this->flash('warning', 'Failed to upload ' . $prefix . ' image');
        return null;
    }
}
