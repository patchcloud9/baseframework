<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? APP_NAME) ?> - <?= APP_NAME ?></title>
    
    <!-- Bulma CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/app.css">
    
    <style>
        /* Quick inline styles for demo - move to app.css in real app */
        .hero.is-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .content-wrapper {
            min-height: calc(100vh - 200px);
        }
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
