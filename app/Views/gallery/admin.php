<?php
/**
 * Admin Gallery Management View
 * 
 * Upload, view, and delete gallery images (admin only).
 */
?>

<section class="hero is-primary">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                <i class="fas fa-images"></i> Manage Gallery
            </h1>
            <p class="subtitle">
                Upload and manage gallery images
            </p>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        
        <!-- Breadcrumb -->
        <nav class="breadcrumb" aria-label="breadcrumbs">
            <ul>
                <li><a href="/admin">Admin</a></li>
                <li class="is-active"><a href="#" aria-current="page">Gallery</a></li>
            </ul>
        </nav>
        
        <!-- Flash Messages -->
        <?php require BASE_PATH . '/app/Views/partials/messages.php'; ?>
        
        <!-- Stats Cards -->
        <div class="columns">
            <div class="column">
                <div class="card">
                    <div class="card-content">
                        <div class="level">
                            <div class="level-item has-text-centered">
                                <div>
                                    <p class="heading">Total Images</p>
                                    <p class="title"><?= $stats['total'] ?></p>
                                </div>
                            </div>
                            <div class="level-item has-text-centered">
                                <div>
                                    <p class="heading">Recent (7 days)</p>
                                    <p class="title"><?= $stats['recent'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Upload Form -->
        <div class="card mb-5">
            <header class="card-header">
                <p class="card-header-title">
                    <span class="icon"><i class="fas fa-upload"></i></span>
                    <span>Upload New Image</span>
                </p>
            </header>
            <div class="card-content">
                <form action="/admin/gallery" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    
                    <div class="field">
                        <label class="label">Image File *</label>
                        <div class="control">
                            <div class="file has-name is-fullwidth">
                                <label class="file-label">
                                    <input class="file-input" type="file" name="image" accept="image/*" required onchange="updateFileName(this)">
                                    <span class="file-cta">
                                        <span class="file-icon">
                                            <i class="fas fa-upload"></i>
                                        </span>
                                        <span class="file-label">
                                            Choose a file…
                                        </span>
                                    </span>
                                    <span class="file-name" id="file-name">
                                        No file selected
                                    </span>
                                </label>
                            </div>
                        </div>
                        <p class="help">Supported formats: JPG, PNG, GIF, WebP. Max size: 5MB</p>
                    </div>
                    
                    <div class="field">
                        <label class="label">Title *</label>
                        <div class="control">
                            <input class="input" type="text" name="title" placeholder="Enter image title" required maxlength="255">
                        </div>
                    </div>
                    
                    <div class="field">
                        <label class="label">Description</label>
                        <div class="control">
                            <textarea class="textarea" name="description" placeholder="Optional description" rows="3" maxlength="1000"></textarea>
                        </div>
                        <p class="help">Maximum 1000 characters</p>
                    </div>
                    
                    <div class="field">
                        <div class="control">
                            <button type="submit" class="button is-primary">
                                <span class="icon">
                                    <i class="fas fa-upload"></i>
                                </span>
                                <span>Upload Image</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Images Grid -->
        <div class="card">
            <header class="card-header">
                <p class="card-header-title">
                    <span class="icon"><i class="fas fa-images"></i></span>
                    <span>Uploaded Images (<?= count($images) ?>)</span>
                </p>
            </header>
            <div class="card-content">
                
                <?php if (empty($images)): ?>
                    <div class="notification is-info">
                        <p class="has-text-centered">
                            <i class="fas fa-image fa-3x mb-3"></i>
                            <br>
                            <strong>No images yet</strong>
                            <br>
                            Upload your first image using the form above!
                        </p>
                    </div>
                <?php else: ?>
                    
                    <!-- Image Cards -->
                    <div class="columns is-multiline">
                        <?php foreach ($images as $image): ?>
                            <div class="column is-one-third">
                                <div class="card gallery-admin-card">
                                    <div class="card-image">
                                        <figure class="image gallery-admin-image-container">
                                            <img src="<?= e($image['file_path']) ?>" alt="<?= e($image['title']) ?>" class="gallery-admin-image">
                                        </figure>
                                    </div>
                                    <div class="card-content">
                                        <div class="content">
                                            <p class="title is-6"><?= e($image['title']) ?></p>
                                            <?php if (!empty($image['description'])): ?>
                                                <p class="is-size-7">
                                                    <?= e(substr($image['description'], 0, 80)) ?><?= strlen($image['description']) > 80 ? '...' : '' ?>
                                                </p>
                                            <?php endif; ?>
                                            <p class="is-size-7 has-text-grey">
                                                <i class="fas fa-user"></i> <?= e($image['uploader_name'] ?? 'Unknown') ?>
                                                <br>
                                                <i class="fas fa-clock"></i> <?= date('M j, Y g:i A', strtotime($image['created_at'])) ?>
                                            </p>
                                        </div>
                                    </div>
                                    <footer class="card-footer">
                                        <a href="#" class="card-footer-item" onclick="moveImage(<?= e($image['id']) ?>, 'up'); return false;">
                                            <span class="icon"><i class="fas fa-arrow-up"></i></span>
                                            <span>Up</span>
                                        </a>
                                        <a href="#" class="card-footer-item" onclick="moveImage(<?= e($image['id']) ?>, 'down'); return false;">
                                            <span class="icon"><i class="fas fa-arrow-down"></i></span>
                                            <span>Down</span>
                                        </a>
                                        <a href="/gallery/<?= e($image['id']) ?>" class="card-footer-item" target="_blank">
                                            <span class="icon"><i class="fas fa-eye"></i></span>
                                            <span>View</span>
                                        </a>
                                        <a href="#" class="card-footer-item has-text-danger" onclick="deleteImage(<?= e($image['id']) ?>, '<?= e($image['title']) ?>'); return false;">
                                            <span class="icon"><i class="fas fa-trash"></i></span>
                                            <span>Delete</span>
                                        </a>
                                    </footer>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                <?php endif; ?>
                
            </div>
        </div>
        
    </div>
</section>

<!-- Hidden delete form -->
<form id="delete-form" method="POST" style="display: none;">
    <?= csrf_field() ?>
    <input type="hidden" name="_method" value="DELETE">
</form>

<!-- Hidden reorder form -->
<form id="reorder-form" method="POST" action="/admin/gallery/reorder" style="display: none;">
    <?= csrf_field() ?>
    <input type="hidden" name="image_id" id="reorder-image-id">
    <input type="hidden" name="direction" id="reorder-direction">
</form>

<script>
    // Update file name display
    function updateFileName(input) {
        const fileName = input.files[0]?.name || 'No file selected';
        document.getElementById('file-name').textContent = fileName;
    }
    
    // Delete image with confirmation
    function deleteImage(imageId, imageTitle) {
        if (!confirm(`Are you sure you want to delete "${imageTitle}"?\n\nThis action cannot be undone.`)) {
            return;
        }
        
        const form = document.getElementById('delete-form');
        form.action = `/admin/gallery/${imageId}`;
        form.submit();
    }
    
    // Move image up or down
    function moveImage(imageId, direction) {
        document.getElementById('reorder-image-id').value = imageId;
        document.getElementById('reorder-direction').value = direction;
        document.getElementById('reorder-form').submit();
    }
</script>

<style>
    /* Gallery admin card layout - equal heights */
    .gallery-admin-card {
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .gallery-admin-card .card-content {
        flex-grow: 1;
    }
    
    /* Fixed height container for images */
    .gallery-admin-image-container {
        height: 250px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f5f5f5;
        overflow: hidden;
    }
    
    /* Images fit within container */
    .gallery-admin-image {
        max-width: 100%;
        max-height: 100%;
        width: auto;
        height: auto;
        object-fit: contain;
        display: block;
    }
    
    /* Hover effect */
    .gallery-admin-image {
        transition: transform 0.3s ease;
    }
    
    .card-image:hover .gallery-admin-image {
        transform: scale(1.05);
    }
</style>
