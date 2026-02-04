<?php
// Load theme settings
$theme = get_site_theme();
$primaryColor = $theme['primary_color'] ?? '#667eea';
$secondaryColor = $theme['secondary_color'] ?? '#764ba2';
$accentColor = $theme['accent_color'] ?? '#48c78e';
$headerStyle = $theme['header_style'] ?? 'static';
$cardStyle = $theme['card_style'] ?? 'default';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? APP_NAME) ?> - <?= APP_NAME ?></title>
    
    <?php if (!empty($theme['favicon_path'])): ?>
    <!-- Custom Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= e($theme['favicon_path']) ?>">
    <?php endif; ?>
    
    <!-- Bulma CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/app.css">
    
    <style>
        /* Dynamic Theme Styles */
        :root {
            --primary-color: <?= e($primaryColor) ?>;
            --secondary-color: <?= e($secondaryColor) ?>;
            --accent-color: <?= e($accentColor) ?>;
            --navbar-color: <?= e($theme['navbar_color'] ?? '#667eea') ?>;
            --navbar-hover-color: <?= e($theme['navbar_hover_color'] ?? '#ffffff') ?>;
        }
        
        /* Hero gradient with theme colors */
        .hero.is-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        }
        
        /* Navbar with custom background color */
        .navbar.is-primary {
            background-color: var(--navbar-color);
            background-image: none;
        }
        
        /* Navbar item hover effects */
        .navbar.is-primary .navbar-item:hover,
        .navbar.is-primary .navbar-link:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
            color: var(--navbar-hover-color) !important;
        }
        
        /* Dropdown menu background */
        .navbar.is-primary .navbar-dropdown {
            background-color: white;
        }
        
        /* Dropdown menu items hover */
        .navbar.is-primary .navbar-dropdown a.navbar-item:hover {
            background-color: #f5f5f5 !important;
            color: var(--navbar-hover-color) !important;
        }
        
        /* Override Bulma's default link colors in navbar */
        .navbar.is-primary a.navbar-item:hover,
        .navbar.is-primary a.navbar-link:hover {
            color: var(--navbar-hover-color) !important;
        }
        
        /* Primary buttons with theme color */
        .button.is-primary {
            background-color: var(--primary-color);
            border-color: transparent;
        }
        
        .button.is-primary:hover {
            background-color: var(--secondary-color);
        }
        
        /* Link buttons */
        .button.is-link {
            background-color: var(--primary-color);
        }
        
        /* Success states with accent color */
        .button.is-success,
        .tag.is-success,
        .notification.is-success {
            background-color: var(--accent-color);
        }
        
        /* Content wrapper */
        .content-wrapper {
            min-height: calc(100vh - 200px);
        }
        
        /* Card styles based on theme preference */
        <?php if ($cardStyle === 'elevated'): ?>
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1), 0 2px 4px rgba(0, 0, 0, 0.08);
        }
        <?php elseif ($cardStyle === 'flat'): ?>
        .card {
            border: none;
            box-shadow: none;
        }
        <?php endif; ?>
        
        /* Header style */
        <?php if ($headerStyle === 'fixed'): ?>
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 30;
        }
        
        body {
            padding-top: 52px; /* Height of navbar */
        }
        <?php endif; ?>
    </style>
</head>
<body>
    <!-- Navigation -->
    <?php require BASE_PATH . '/app/Views/partials/nav.php'; ?>
    
    <!-- Main Content -->
    <main class="content-wrapper">
        <?= $content ?>
    </main>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="content has-text-centered">
            <p>
                <strong><?= APP_NAME ?></strong> - A simple PHP MVC framework.
                <br>
                <small>Current time: <?= date('Y-m-d H:i:s') ?></small>
            </p>
        </div>
    </footer>
    
    <!-- Custom JavaScript -->
    <script src="/assets/js/app.js"></script>
</body>
</html>
