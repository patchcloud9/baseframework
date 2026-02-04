<?php
// Hero background styling
$heroStyle = '';
if (($settings['hero_background_type'] ?? 'color') === 'image' && !empty($settings['hero_background_image'])) {
    $heroStyle = "background-image: url('" . e($settings['hero_background_image']) . "'); background-size: cover; background-position: center;";
} else {
    $heroStyle = "background-color: " . e($settings['hero_background_color'] ?? '#667eea') . ";";
}
?>

<!-- Hero Section -->
<section class="hero is-medium" style="<?= $heroStyle ?>; position: relative; min-height: 320px;">
    <!-- Flash Messages positioned at top of hero -->
    <div style="position: absolute; top: 10px; left: 50%; transform: translateX(-50%); width: 90%; max-width: 800px; z-index: 10;">
        <?php require BASE_PATH . '/app/Views/partials/messages.php'; ?>
    </div>
    
    <div class="hero-body" style="padding-top: 120px;">
        <div class="container has-text-centered">
            <h1 class="title is-1 has-text-white"><?= e($settings['hero_title'] ?? 'Welcome Home') ?></h1>
            <?php if (!empty($settings['hero_subtitle'])): ?>
                <h2 class="subtitle has-text-white-ter"><?= e($settings['hero_subtitle']) ?></h2>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Feature Cards Section -->
<section class="section">
    <div class="container">
        <div class="columns">
            <!-- Card 1 -->
            <div class="column is-4">
                <div class="box has-text-centered">
                    <span class="icon is-large has-text-info">
                        <i class="<?= e($settings['card1_icon'] ?? 'fas fa-rocket') ?> fa-3x"></i>
                    </span>
                    <h3 class="title is-4 mt-3"><?= e($settings['card1_title'] ?? 'Fast Performance') ?></h3>
                    <p><?= e($settings['card1_text'] ?? 'Built with modern PHP and optimized for speed.') ?></p>
                </div>
            </div>
            
            <!-- Card 2 -->
            <div class="column is-4">
                <div class="box has-text-centered">
                    <span class="icon is-large has-text-success">
                        <i class="<?= e($settings['card2_icon'] ?? 'fas fa-shield-alt') ?> fa-3x"></i>
                    </span>
                    <h3 class="title is-4 mt-3"><?= e($settings['card2_title'] ?? 'Secure') ?></h3>
                    <p><?= e($settings['card2_text'] ?? 'CSRF protection, authentication, and secure password hashing built in.') ?></p>
                </div>
            </div>
            
            <!-- Card 3 -->
            <div class="column is-4">
                <div class="box has-text-centered">
                    <span class="icon is-large has-text-danger">
                        <i class="<?= e($settings['card3_icon'] ?? 'fas fa-mobile-alt') ?> fa-3x"></i>
                    </span>
                    <h3 class="title is-4 mt-3"><?= e($settings['card3_title'] ?? 'Responsive') ?></h3>
                    <p><?= e($settings['card3_text'] ?? 'Mobile-friendly design using Bulma CSS framework.') ?></p>
                </div>
            </div>
        </div>
        
        <!-- CTA Button -->
        <div class="has-text-centered mt-5">
            <a href="<?= e($settings['cta_button_link'] ?? '/about') ?>" class="button is-primary is-large">
                <span class="icon">
                    <i class="fas fa-arrow-right"></i>
                </span>
                <span><?= e($settings['cta_button_text'] ?? 'Get Started') ?></span>
            </a>
        </div>
    </div>
</section>

<!-- Bottom Content Section -->
<?php if (!empty($settings['bottom_section_title']) || !empty($settings['bottom_section_text']) || !empty($settings['bottom_section_image'])): ?>
<section class="section has-background-light">
    <div class="container">
        <div class="columns is-vcentered <?= ($settings['bottom_section_layout'] ?? 'text-image') === 'image-text' ? 'is-reverse-mobile' : '' ?>">
            <?php if (($settings['bottom_section_layout'] ?? 'text-image') === 'text-image'): ?>
                <!-- Text Column -->
                <div class="column is-6">
                    <h2 class="title is-3"><?= e($settings['bottom_section_title'] ?? 'About This Framework') ?></h2>
                    <div class="content">
                        <p><?= nl2br(e($settings['bottom_section_text'] ?? 'This is a minimal, educational PHP MVC framework demonstrating front controller and routing patterns.')) ?></p>
                    </div>
                </div>
                
                <!-- Image Column -->
                <div class="column is-6">
                    <?php if (!empty($settings['bottom_section_image'])): ?>
                        <figure class="image">
                            <img src="<?= e($settings['bottom_section_image']) ?>" alt="<?= e($settings['bottom_section_title']) ?>" style="border-radius: 8px;">
                        </figure>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <!-- Image Column (Left) -->
                <div class="column is-6">
                    <?php if (!empty($settings['bottom_section_image'])): ?>
                        <figure class="image">
                            <img src="<?= e($settings['bottom_section_image']) ?>" alt="<?= e($settings['bottom_section_title']) ?>" style="border-radius: 8px;">
                        </figure>
                    <?php endif; ?>
                </div>
                
                <!-- Text Column (Right) -->
                <div class="column is-6">
                    <h2 class="title is-3"><?= e($settings['bottom_section_title'] ?? 'About This Framework') ?></h2>
                    <div class="content">
                        <p><?= nl2br(e($settings['bottom_section_text'] ?? 'This is a minimal, educational PHP MVC framework demonstrating front controller and routing patterns.')) ?></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

