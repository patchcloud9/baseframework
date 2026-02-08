<?php
/**
 * Public About Page
 */
$layout = 'main';
?>

<section class="section">
    <div class="container">

        <!-- Page Title -->
        <h1 class="title is-2 has-text-centered mb-6">
            <?= e($content['page_title'] ?? 'About the Artist') ?>
        </h1>
        <hr class="has-background-grey" style="max-width: 200px; margin: 0 auto 3rem auto; height: 2px;">

        <!-- Section 1 -->
        <?php if (!empty($content['section1_text']) || !empty($content['section1_image'])): ?>
        <div class="columns is-variable is-8 mb-6">
            <?php if (($content['section1_image_position'] ?? 'left') === 'left'): ?>
                <!-- Image on left -->
                <?php if (!empty($content['section1_image'])): ?>
                <div class="column is-5">
                    <figure class="image">
                        <img src="<?= e($content['section1_image']) ?>" alt="<?= e($content['page_title']) ?>" style="width: 100%; height: auto;">
                    </figure>
                </div>
                <?php endif; ?>
                <div class="column <?= empty($content['section1_image']) ? '' : 'is-7' ?>">
                    <div class="content is-size-5 has-text-justified">
                        <?= nl2br(e($content['section1_text'] ?? '')) ?>
                    </div>
                </div>
            <?php else: ?>
                <!-- Image on right -->
                <div class="column <?= empty($content['section1_image']) ? '' : 'is-7' ?>">
                    <div class="content is-size-5 has-text-justified">
                        <?= nl2br(e($content['section1_text'] ?? '')) ?>
                    </div>
                </div>
                <?php if (!empty($content['section1_image'])): ?>
                <div class="column is-5">
                    <figure class="image">
                        <img src="<?= e($content['section1_image']) ?>" alt="<?= e($content['page_title']) ?>" style="width: 100%; height: auto;">
                    </figure>
                </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Section 2 -->
        <?php if (!empty($content['section2_text']) || !empty($content['section2_image'])): ?>
        <div class="columns is-variable is-8 mt-6">
            <?php if (($content['section2_image_position'] ?? 'left') === 'left'): ?>
                <!-- Image on left -->
                <?php if (!empty($content['section2_image'])): ?>
                <div class="column is-5">
                    <figure class="image">
                        <img src="<?= e($content['section2_image']) ?>" alt="<?= e($content['page_title']) ?>" style="width: 100%; height: auto;">
                    </figure>
                </div>
                <?php endif; ?>
                <div class="column <?= empty($content['section2_image']) ? '' : 'is-7' ?>">
                    <div class="content is-size-5 has-text-justified">
                        <?= nl2br(e($content['section2_text'] ?? '')) ?>
                    </div>
                </div>
            <?php else: ?>
                <!-- Image on right -->
                <div class="column <?= empty($content['section2_image']) ? '' : 'is-7' ?>">
                    <div class="content is-size-5 has-text-justified">
                        <?= nl2br(e($content['section2_text'] ?? '')) ?>
                    </div>
                </div>
                <?php if (!empty($content['section2_image'])): ?>
                <div class="column is-5">
                    <figure class="image">
                        <img src="<?= e($content['section2_image']) ?>" alt="<?= e($content['page_title']) ?>" style="width: 100%; height: auto;">
                    </figure>
                </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Artist Signature -->
        <?php if (!empty($content['artist_signature'])): ?>
        <div class="has-text-centered mt-6">
            <p class="is-size-4 has-text-weight-semibold">
                <?= e($content['artist_signature']) ?>
            </p>
        </div>
        <?php endif; ?>

    </div>
</section>
