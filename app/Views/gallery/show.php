<?php
/**
 * Single Gallery Image View
 * 
 * Displays a single image with full details.
 */
?>

<section class="section">
    <div class="container">
        
        <!-- Breadcrumb -->
        <nav class="breadcrumb" aria-label="breadcrumbs">
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/gallery">Gallery</a></li>
                <li class="is-active"><a href="#" aria-current="page"><?= e($image['title']) ?></a></li>
            </ul>
        </nav>
        
        <div class="columns">
            <!-- Image Display -->
            <div class="column is-8">
                <div class="card">
                    <div class="card-image">
                        <figure class="image">
                            <img src="<?= e($image['file_path']) ?>" alt="<?= e($image['title']) ?>">
                        </figure>
                    </div>
                </div>
            </div>
            
            <!-- Image Details -->
            <div class="column is-4">
                <div class="card">
                    <div class="card-content">
                        <h1 class="title is-4">
                            <?= e($image['title']) ?>
                        </h1>
                        
                        <?php if (!empty($image['description'])): ?>
                            <div class="content">
                                <p><?= nl2br(e($image['description'])) ?></p>
                            </div>
                        <?php endif; ?>
                        
                        <hr>
                        
                        <div class="content">
                            <p>
                                <strong><i class="fas fa-user"></i> Uploaded by:</strong><br>
                                <?= e($image['uploader_name'] ?? 'Unknown') ?>
                            </p>
                            
                            <p>
                                <strong><i class="fas fa-calendar"></i> Date:</strong><br>
                                <?= date('F j, Y', strtotime($image['created_at'])) ?>
                            </p>
                            
                            <p>
                                <strong><i class="fas fa-clock"></i> Time:</strong><br>
                                <?= date('g:i A', strtotime($image['created_at'])) ?>
                            </p>
                        </div>
                        
                        <hr>
                        
                        <div class="buttons">
                            <a href="/gallery" class="button is-primary is-fullwidth">
                                <span class="icon">
                                    <i class="fas fa-arrow-left"></i>
                                </span>
                                <span>Back to Gallery</span>
                            </a>
                            
                            <a href="<?= e($image['file_path']) ?>" download class="button is-link is-fullwidth">
                                <span class="icon">
                                    <i class="fas fa-download"></i>
                                </span>
                                <span>Download</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</section>

<style>
    /* Ensure image doesn't exceed viewport */
    .card-image img {
        max-height: 70vh;
        width: 100%;
        object-fit: contain;
        background-color: #f5f5f5;
    }
    
    /* Responsive adjustments */
    @media screen and (max-width: 768px) {
        .columns {
            flex-direction: column-reverse;
        }
        
        .card-image img {
            max-height: 50vh;
        }
    }
</style>
