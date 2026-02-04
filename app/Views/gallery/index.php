<?php
/**
 * Public Gallery View
 * 
 * Displays all gallery images in a responsive card-based grid layout.
 */
?>

<section class="hero is-primary">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                <i class="fas fa-images"></i> Gallery
            </h1>
            <p class="subtitle">
                Browse our collection of images
            </p>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        
        <?php if (empty($images)): ?>
            <!-- Empty State -->
            <div class="notification is-info">
                <p class="has-text-centered">
                    <i class="fas fa-image fa-3x mb-3"></i>
                    <br>
                    <strong>No images yet</strong>
                    <br>
                    Check back later for new content!
                </p>
            </div>
        <?php else: ?>
            <!-- Image Grid -->
            <div class="columns is-multiline">
                <?php foreach ($images as $image): ?>
                    <div class="column is-one-quarter-desktop is-one-third-tablet is-half-mobile">
                        <div class="card">
                            <div class="card-image">
                                <figure class="image is-4by3">
                                    <a href="/gallery/<?= e($image['id']) ?>">
                                        <img src="<?= e($image['file_path']) ?>" alt="<?= e($image['title']) ?>" style="object-fit: cover;">
                                    </a>
                                </figure>
                            </div>
                            <div class="card-content">
                                <div class="content">
                                    <p class="title is-5">
                                        <a href="/gallery/<?= e($image['id']) ?>">
                                            <?= e($image['title']) ?>
                                        </a>
                                    </p>
                                    <?php if (!empty($image['description'])): ?>
                                        <p class="subtitle is-6">
                                            <?= e(substr($image['description'], 0, 100)) ?><?= strlen($image['description']) > 100 ? '...' : '' ?>
                                        </p>
                                    <?php endif; ?>
                                    <small class="has-text-grey">
                                        <i class="fas fa-user"></i> <?= e($image['uploader_name'] ?? 'Unknown') ?>
                                        <br>
                                        <i class="fas fa-clock"></i> <?= date('M j, Y', strtotime($image['created_at'])) ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
    </div>
</section>

<style>
    /* Ensure consistent card heights */
    .card {
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .card-content {
        flex-grow: 1;
    }
    
    /* Hover effect for images */
    .card-image img {
        transition: transform 0.3s ease;
    }
    
    .card-image:hover img {
        transform: scale(1.05);
    }
    
    /* Smooth image loading */
    .card-image figure {
        overflow: hidden;
    }
</style>
