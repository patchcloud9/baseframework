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
                        
                        <?php
                        // Get gallery contact email from theme settings
                        $galleryEmail = theme_setting('gallery_contact_email');
                        ?>
                        
                        <!-- Pricing Information -->
                        <?php if (isset($image['price_type']) && $image['price_type'] !== 'hide'): ?>
                            <div class="box has-background-light mb-4">
                                <div class="content">
                                    <?php if ($image['price_type'] === 'amount' && !empty($image['price_amount'])): ?>
                                        <p class="has-text-weight-semibold is-size-5">
                                            <span class="icon-text">
                                                <span class="icon has-text-success">
                                                    <i class="fas fa-tag"></i>
                                                </span>
                                                <span>Original Artwork: $<?= number_format((float)$image['price_amount'], 2) ?></span>
                                            </span>
                                        </p>
                                    <?php elseif ($image['price_type'] === 'sold_prints'): ?>
                                        <p class="has-text-weight-semibold is-size-5">
                                            <span class="icon-text">
                                                <span class="icon has-text-warning">
                                                    <i class="fas fa-certificate"></i>
                                                </span>
                                                <span>Original Sold (Prints Available)</span>
                                            </span>
                                        </p>
                                    <?php elseif ($image['price_type'] === 'not_for_sale'): ?>
                                        <p class="has-text-weight-semibold is-size-5">
                                            <span class="icon-text">
                                                <span class="icon has-text-grey">
                                                    <i class="fas fa-ban"></i>
                                                </span>
                                                <span>Not for Sale</span>
                                            </span>
                                        </p>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($galleryEmail)): ?>
                                        <p class="mt-3">
                                            <span class="icon-text">
                                                <span class="icon has-text-info">
                                                    <i class="fas fa-envelope"></i>
                                                </span>
                                                <span>For inquiries: <a href="mailto:<?= e($galleryEmail) ?>"><?= e($galleryEmail) ?></a></span>
                                            </span>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Prints Button -->
                        <?php if (isset($image['prints_available']) && $image['prints_available']): ?>
                            <?php if (!empty($image['prints_url'])): ?>
                                <a href="<?= e($image['prints_url']) ?>" target="_blank" rel="noopener noreferrer" class="button is-success is-fullwidth mb-4">
                                    <span class="icon">
                                        <i class="fas fa-shopping-cart"></i>
                                    </span>
                                    <span>Purchase Prints and Merchandise</span>
                                    <span class="icon">
                                        <i class="fas fa-external-link-alt"></i>
                                    </span>
                                </a>
                            <?php endif; ?>
                        <?php else: ?>
                            <button class="button is-fullwidth mb-4" disabled>
                                <span class="icon">
                                    <i class="fas fa-times-circle"></i>
                                </span>
                                <span>Prints Not Available</span>
                            </button>
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
