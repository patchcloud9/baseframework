<section class="hero is-primary is-medium">
    <div class="hero-body">
        <div class="container has-text-centered">
            <!-- Flash Messages inside hero -->
            <?php require BASE_PATH . '/app/Views/partials/messages.php'; ?>
            
            <h1 class="title is-1"><?= e($title) ?></h1>
            <h2 class="subtitle"><?= e($message) ?></h2>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="columns">
            <div class="column is-4">
                <div class="box">
                    <h3 class="title is-4">🛣️ Routing</h3>
                    <p>All requests go through <code>index.php</code>, which uses the Router to match URLs to controllers.</p>
                    <br>
                    <a href="/debug" class="button is-small is-info">View Debug Info</a>
                </div>
            </div>
            
            <div class="column is-4">
                <div class="box">
                    <h3 class="title is-4">🎮 Controllers</h3>
                    <p>Controllers handle the business logic and return views or JSON responses.</p>
                    <br>
                    <a href="/users" class="button is-small is-info">View Users</a>
                </div>
            </div>
            
            <div class="column is-4">
                <div class="box">
                    <h3 class="title is-4">👁️ Views</h3>
                    <p>Views are simple PHP files that render HTML. They're wrapped in layouts automatically.</p>
                    <br>
                    <a href="/about" class="button is-small is-info">About Page</a>
                </div>
            </div>
        </div>
        
        <div class="box mt-5">
            <h3 class="title is-4">How This Page Was Rendered</h3>
            <div class="content">
                <ol>
                    <li>You requested <code>GET /</code></li>
                    <li>Apache's <code>.htaccess</code> rewrote this to <code>index.php</code></li>
                    <li>The Router matched <code>/</code> to <code>HomeController::index()</code></li>
                    <li>The controller called <code>$this->view('home/index', $data)</code></li>
                    <li>The View class rendered <code>home/index.php</code> inside <code>layouts/main.php</code></li>
                </ol>
            </div>
            <p class="has-text-grey">
                <small>Rendered at: <?= e($time) ?></small>
            </p>
        </div>
    </div>
</section>
