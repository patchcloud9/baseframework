<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>
<body>
    <section class="hero is-danger is-fullheight">
        <div class="hero-body">
            <div class="container has-text-centered">
                <h1 class="title is-1">404</h1>
                <h2 class="subtitle is-3">Page Not Found</h2>
                
                <p class="mb-5">
                    <?php if (isset($message)): ?>
                        <?= e($message) ?>
                    <?php else: ?>
                        The page you're looking for doesn't exist or has been moved.
                    <?php endif; ?>
                </p>
                
                <?php if (defined('APP_DEBUG') && APP_DEBUG): ?>
                <div class="box has-background-white has-text-left" style="max-width: 600px; margin: 0 auto;">
                    <h3 class="title is-5 has-text-dark">Debug Info</h3>
                    <table class="table is-fullwidth">
                        <tr>
                            <td><strong>Method</strong></td>
                            <td><code><?= $_SERVER['REQUEST_METHOD'] ?></code></td>
                        </tr>
                        <tr>
                            <td><strong>URI</strong></td>
                            <td><code><?= e($_SERVER['REQUEST_URI']) ?></code></td>
                        </tr>
                    </table>
                </div>
                <?php endif; ?>
                
                <a href="/" class="button is-light is-medium mt-5">Go Home</a>
            </div>
        </div>
    </section>
</body>
</html>
