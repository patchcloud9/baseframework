<nav class="navbar is-primary" role="navigation" aria-label="main navigation">
    <div class="container">
        <div class="navbar-brand">
            <a class="navbar-item has-text-weight-bold" href="/">
                <?= APP_NAME ?>
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
                <a class="navbar-item" href="/users">Users</a>
                <a class="navbar-item" href="/logs">Logs</a>
                
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">Examples</a>
                    <div class="navbar-dropdown">
                        <a class="navbar-item" href="/users/1">User #1</a>
                        <a class="navbar-item" href="/users/42">User #42</a>
                        <a class="navbar-item" href="/users/999">User #999 (404)</a>
                        <hr class="navbar-divider">
                        <a class="navbar-item" href="/debug">Debug Info</a>
                        <a class="navbar-item" href="/nonexistent">Test 404</a>
                    </div>
                </div>
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
                            <form method="POST" action="/logout" style="margin: 0;">
                                <?= csrf_field() ?>
                                <button type="submit" class="navbar-item button is-text" style="width: 100%; text-align: left; border: none; background: none;">
                                    <span class="icon"><i class="fas fa-sign-out-alt"></i></span>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="navbar-item">
                        <a class="button is-primary" href="/register">
                            <strong>Sign up</strong>
                        </a>
                    </div>
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
