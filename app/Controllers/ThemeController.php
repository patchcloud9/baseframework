<?php

namespace App\Controllers;

use App\Models\ThemeSetting;

/**
 * Theme Controller
 * 
 * Manages site-wide theme customization (admin only).
 */
class ThemeController extends Controller
{
    /**
     * Show theme settings form
     * Route: GET /admin/theme
     */
    public function index(): void
    {
        $theme = ThemeSetting::getSiteTheme();
        
        // If no theme exists yet, create default
        if (!$theme) {
            ThemeSetting::createInitialTheme([]);
            $theme = ThemeSetting::getSiteTheme();
        }
        
        $this->view('admin/theme', [
            'title' => 'Theme Settings',
            'theme' => $theme
        ]);
    }
    
    /**
     * Update theme settings
     * Route: POST /admin/theme
     * Middleware: auth, role:admin, csrf
     */
    public function update(): void
    {
        // Validate input
        $validator = new \Core\Validator($_POST, [
            'primary_color' => 'required',
            'secondary_color' => 'required',
            'accent_color' => 'required',
            'header_style' => 'required|in:fixed,static',
            'card_style' => 'required|in:default,elevated,flat',
        ]);
        
        if ($validator->fails()) {
            $errors = $validator->errors();
            $firstError = reset($errors)[0];
            $this->flash('error', $firstError);
            $this->redirect('/admin/theme');
            return;
        }
        
        // Prepare update data
        $updateData = [
            'primary_color' => $this->input('primary_color'),
            'secondary_color' => $this->input('secondary_color'),
            'accent_color' => $this->input('accent_color'),            'navbar_color' => $this->input('navbar_color'),
            'navbar_hover_color' => $this->input('navbar_hover_color'),            'navbar_text_color' => $this->input('navbar_text_color'),
            'hero_background_color' => $this->input('hero_background_color'),
            'site_name' => $this->input('site_name'),
            'header_style' => $this->input('header_style'),
            'card_style' => $this->input('card_style'),
        ];
        
        // Handle logo upload
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            $logoPath = $this->handleFileUpload($_FILES['logo'], 'logo');
            if ($logoPath) {
                $updateData['logo_path'] = $logoPath;
            }
        }
        
        // Handle favicon upload
        if (isset($_FILES['favicon']) && $_FILES['favicon']['error'] === UPLOAD_ERR_OK) {
            $faviconPath = $this->handleFileUpload($_FILES['favicon'], 'favicon');
            if ($faviconPath) {
                $updateData['favicon_path'] = $faviconPath;
            }
        }
        
        // Handle hero background image upload
        if (isset($_FILES['hero_background']) && $_FILES['hero_background']['error'] === UPLOAD_ERR_OK) {
            $heroPath = $this->handleFileUpload($_FILES['hero_background'], 'hero_background');
            if ($heroPath) {
                $updateData['hero_background_image'] = $heroPath;
            }
        }
        
        // Update theme
        if (ThemeSetting::updateTheme($updateData)) {
            $this->flash('success', 'Theme settings updated successfully!');
        } else {
            $this->flash('error', 'Failed to update theme settings.');
        }
        
        $this->redirect('/admin/theme');
    }
    
    /**
     * Handle file upload for logo/favicon
     * 
     * @param array $file $_FILES array element
     * @param string $type 'logo' or 'favicon'
     * @return string|null File path on success, null on failure
     */
    private function handleFileUpload(array $file, string $type): ?string
    {
        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'];
        if ($type === 'favicon') {
            $allowedTypes[] = 'image/x-icon';
            $allowedTypes[] = 'image/vnd.microsoft.icon';
        }
        
        if (!in_array($file['type'], $allowedTypes)) {
            $this->flash('error', 'Invalid file type for ' . $type);
            return null;
        }
        
        // Validate file size (max 2MB)
        if ($file['size'] > 2 * 1024 * 1024) {
            $this->flash('error', ucfirst($type) . ' file size must be less than 2MB');
            return null;
        }
        
        // Create upload directory if it doesn't exist
        $uploadDir = BASE_PATH . '/public/uploads/theme/';
        if (!is_dir($uploadDir)) {
            if (!@mkdir($uploadDir, 0755, true)) {
                error_log("Failed to create upload directory: {$uploadDir}");
                $this->flash('error', 'Upload directory not writable. Please check server permissions.');
                return null;
            }
        }
        
        // Verify directory is writable
        if (!is_writable($uploadDir)) {
            error_log("Upload directory not writable: {$uploadDir}");
            $this->flash('error', 'Upload directory not writable. Please check server permissions.');
            return null;
        }
        
        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = $type . '_' . time() . '.' . $extension;
        $targetPath = $uploadDir . $filename;
        
        // Move uploaded file
        if (@move_uploaded_file($file['tmp_name'], $targetPath)) {
            return '/uploads/theme/' . $filename;
        }
        
        error_log("Failed to move uploaded file to: {$targetPath}");
        $this->flash('error', 'Failed to upload ' . $type . '. Please check server permissions.');
        return null;
    }
    
    /**
     * Reset theme settings to defaults
     * Route: POST /admin/theme/reset
     * Middleware: auth, role:admin, csrf
     */
    public function reset(): void
    {
        // Default theme values
        $defaults = [
            'primary_color' => '#667eea',
            'secondary_color' => '#764ba2',
            'accent_color' => '#48c78e',
            'navbar_color' => '#667eea',
            'navbar_hover_color' => '#ffffff',
            'navbar_text_color' => '#ffffff',
            'hero_background_color' => null,
            'hero_background_image' => null,
            'logo_path' => null,
            'favicon_path' => null,
            'header_style' => 'static',
            'card_style' => 'default',
        ];
        
        if (ThemeSetting::updateTheme($defaults)) {
            $this->flash('success', 'Theme settings have been reset to defaults.');
        } else {
            $this->flash('error', 'Failed to reset theme settings.');
        }
        
        $this->redirect('/admin/theme');
    }
}
