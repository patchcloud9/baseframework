<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Server Error</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>
<body>
    <section class="hero is-warning is-fullheight">
        <div class="hero-body">
            <div class="container has-text-centered">
                <h1 class="title is-1">500</h1>
                <h2 class="subtitle is-3">Something Went Wrong</h2>
                
                <p class="mb-5">
                    An internal error occurred. Please try again later.
                </p>
                
                <?php if (defined('APP_DEBUG') && APP_DEBUG && isset($message)): ?>
                <div class="box has-background-white has-text-left" style="max-width: 600px; margin: 0 auto;">
                    <h3 class="title is-5 has-text-dark">Debug Info</h3>
                    <p class="has-text-danger"><?= htmlspecialchars($message) ?></p>
                </div>
                <?php endif; ?>
                
                <a href="/" class="button is-dark is-medium mt-5">Go Home</a>
            </div>
        </div>
    </section>
</body>
</html>
