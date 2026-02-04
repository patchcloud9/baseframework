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
                    <div class="card-image image-protection">
                        <figure class="image">
                            <img src="<?= e($image['file_path']) ?>" alt="<?= e($image['title']) ?>" class="protected-image">
                            <div class="image-overlay"></div>
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
                        
                        <div class="buttons">
                            <a href="/gallery" class="button is-primary is-fullwidth">
                                <span class="icon">
                                    <i class="fas fa-arrow-left"></i>
                                </span>
                                <span>Back to Gallery</span>
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
    
    /* Image protection - disable right-click, drag, and select */
    .protected-image {
        user-select: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        pointer-events: none;
    }
    
    .image-protection {
        position: relative;
    }
    
    /* Transparent overlay to prevent right-click on image */
    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: transparent;
        z-index: 1;
    }
    
    /* Disable text selection on the entire image container */
    .image-protection * {
        user-select: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
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

<script>
    // Disable right-click on images
    document.addEventListener('DOMContentLoaded', function() {
        const images = document.querySelectorAll('.protected-image');
        
        images.forEach(img => {
            // Prevent right-click
            img.addEventListener('contextmenu', function(e) {
                e.preventDefault();
                return false;
            });
            
            // Prevent drag
            img.addEventListener('dragstart', function(e) {
                e.preventDefault();
                return false;
            });
        });
        
        // Prevent right-click on the entire image container
        const imageProtection = document.querySelector('.image-protection');
        if (imageProtection) {
            imageProtection.addEventListener('contextmenu', function(e) {
                e.preventDefault();
                return false;
            });
        }
    });
</script>
