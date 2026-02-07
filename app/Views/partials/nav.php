<nav class="navbar is-primary" role="navigation" aria-label="main navigation">
    <div class="container">
        <div class="navbar-brand">
            <?php 
            $logo = theme_setting('logo_path');
            $siteName = theme_setting('site_name');
            ?>
            <a class="navbar-item has-text-weight-bold" href="/">
                <?php if ($logo): ?>
                    <img src="<?= e($logo) ?>" alt="<?= APP_NAME ?>" style="max-height: 40px;">
                <?php else: ?>
                    <?= APP_NAME ?>
                <?php endif; ?>
                <?php if ($siteName): ?>
                    <span class="ml-2"><?= e($siteName) ?></span>
                <?php endif; ?>
            </a>
            
            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="mainNavbar">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>
        
        <div id="mainNavbar" class="navbar-menu">
            <div class="navbar-end">
                <a class="navbar-item" href="/">Home</a>
                <a class="navbar-item" href="/about">About</a>
                <a class="navbar-item" href="/gallery">Gallery</a>
                <a class="navbar-item" href="/contact">Contact</a>

                <!-- TEMP: Test dropdown (QA only — visible to everyone) -->
                <div class="navbar-item has-dropdown is-hoverable">
                    <button class="navbar-link">Test Menu</button>
                    <div class="navbar-dropdown">
                        <a class="navbar-item" href="/">Test One</a>
                        <a class="navbar-item" href="/">Test Two</a>
                        <hr class="navbar-divider">
                        <a class="navbar-item" href="/">Test Three</a>
                    </div>
                </div>

                <?php if (is_authenticated()): ?>
                    <?php $user = auth_user(); ?>
                    
                    <div class="navbar-item has-dropdown is-hoverable">
                        <button class="navbar-link"><?= e($user['name']) ?></button>
                        <div class="navbar-dropdown is-right">
                            <a class="navbar-item" href="/profile">
                                <span class="icon"><i class="fas fa-user"></i></span>
                                <span>Profile</span>
                            </a>
                            <?php if (is_admin()): ?>
                                <a class="navbar-item" href="/admin">
                                    <span class="icon"><i class="fas fa-cog"></i></span>
                                    <span>Admin Panel</span>
                                </a>
                            <?php endif; ?>
                            <hr class="navbar-divider">
                            <form method="POST" action="/logout">
                                <?= csrf_field() ?>
                                <button type="submit" class="navbar-item" style="width: 100%; border: none; background: none; cursor: pointer; justify-content: flex-start; display: flex; align-items: center; font-family: inherit; font-size: inherit; padding: 0.5rem 0.75rem;">
                                    <span class="icon"><i class="fas fa-sign-out-alt"></i></span>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                <?php else: ?>
                    <a class="navbar-item" href="/login">Log in</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<!-- Overlay for mobile nav -->
<div id="navOverlay" class="nav-overlay" aria-hidden="true"></div>

<!-- ARIA live region for announcements -->
<div id="navLive" class="sr-only" aria-live="polite" aria-atomic="true"></div> 
