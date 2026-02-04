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
                    <div class="column is-one-quarter-desktop is-one-third-tablet is-full-mobile">
                        <div class="card gallery-card">
                            <div class="card-image">
                                <figure class="image gallery-image-container">
                                    <a href="/gallery/<?= e($image['id']) ?>">
                                        <img src="<?= e($image['file_path']) ?>" alt="<?= e($image['title']) ?>" class="gallery-image">
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
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
                <nav class="pagination is-centered mt-5" role="navigation" aria-label="pagination">
                    <a href="/gallery?page=<?= max(1, $currentPage - 1) ?>" 
                       class="pagination-previous <?= $currentPage <= 1 ? 'is-disabled' : '' ?>"
                       <?= $currentPage <= 1 ? 'disabled' : '' ?>>
                        Previous
                    </a>
                    <a href="/gallery?page=<?= min($totalPages, $currentPage + 1) ?>" 
                       class="pagination-next <?= $currentPage >= $totalPages ? 'is-disabled' : '' ?>"
                       <?= $currentPage >= $totalPages ? 'disabled' : '' ?>>
                        Next
                    </a>
                    <ul class="pagination-list">
                        <?php
                        // Calculate page range to show
                        $range = 2; // Show 2 pages on each side of current page
                        $start = max(1, $currentPage - $range);
                        $end = min($totalPages, $currentPage + $range);
                        
                        // Show first page if not in range
                        if ($start > 1): ?>
                            <li><a href="/gallery?page=1" class="pagination-link">1</a></li>
                            <?php if ($start > 2): ?>
                                <li><span class="pagination-ellipsis">&hellip;</span></li>
                            <?php endif; ?>
                        <?php endif;
                        
                        // Show page numbers in range
                        for ($i = $start; $i <= $end; $i++): ?>
                            <li>
                                <a href="/gallery?page=<?= $i ?>" 
                                   class="pagination-link <?= $i === $currentPage ? 'is-current' : '' ?>"
                                   <?= $i === $currentPage ? 'aria-current="page"' : '' ?>>
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor;
                        
                        // Show last page if not in range
                        if ($end < $totalPages): ?>
                            <?php if ($end < $totalPages - 1): ?>
                                <li><span class="pagination-ellipsis">&hellip;</span></li>
                            <?php endif; ?>
                            <li><a href="/gallery?page=<?= $totalPages ?>" class="pagination-link"><?= $totalPages ?></a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
                
                <!-- Results info -->
                <p class="has-text-centered has-text-grey mt-3">
                    Showing page <?= $currentPage ?> of <?= $totalPages ?> (<?= $total ?> total images)
                </p>
            <?php endif; ?>
        <?php endif; ?>
        
    </div>
</section>

<style>
    /* Gallery card layout - equal heights */
    .gallery-card {
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .card-content {
        flex-grow: 1;
    }
    
    /* Fixed height container for images to maintain consistent card heights */
    .gallery-image-container {
        height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f5f5f5;
        overflow: hidden;
    }
    
    /* Images fit within container while maintaining aspect ratio */
    .gallery-image {
        max-width: 100%;
        max-height: 100%;
        width: auto;
        height: auto;
        object-fit: contain;
        display: block;
    }
    
    /* Hover effect for images */
    .card-image a {
        display: flex;
        height: 100%;
        align-items: center;
        justify-content: center;
    }
    
    .gallery-image {
        transition: transform 0.3s ease;
    }
    
    .card-image:hover .gallery-image {
        transform: scale(1.05);
    }
    
    /* Mobile adjustments */
    @media screen and (max-width: 768px) {
        .gallery-image-container {
            height: 250px;
        }
        
        /* Full width columns on mobile with proper padding */
        .column.is-full-mobile {
            padding: 0.75rem;
        }
    }
</style>
