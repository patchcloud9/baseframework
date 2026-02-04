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
            <div class="navbar-start">
                <a class="navbar-item" href="/">Home</a>
                <a class="navbar-item" href="/about">About</a>
                <a class="navbar-item" href="/contact">Contact</a>
            </div>
            
            <div class="navbar-end">
                <?php if (is_authenticated()): ?>
                    <?php $user = auth_user(); ?>
                    
                    <div class="navbar-item has-dropdown is-hoverable">
                        <a class="navbar-link">
                            <?= e($user['name']) ?>
                            <?php if (is_admin()): ?>
                                <span class="tag is-warning is-small ml-2">Admin</span>
                            <?php endif; ?>
                        </a>
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
                    <div class="navbar-item">
                        <a class="button is-primary" href="/login">
                            <strong>Log in</strong>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<script>
// Bulma navbar burger toggle
document.addEventListener('DOMContentLoaded', () => {
    const burgers = document.querySelectorAll('.navbar-burger');
    burgers.forEach(burger => {
        burger.addEventListener('click', () => {
            const target = document.getElementById(burger.dataset.target);
            burger.classList.toggle('is-active');
            target.classList.toggle('is-active');
        });
    });
});
</script>
