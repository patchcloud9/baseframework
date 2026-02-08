<?php
$layout = 'main';
?>

<section class="section">
    <div class="container">
        <?php require BASE_PATH . '/app/Views/partials/messages.php'; ?>

        <div class="content has-text-centered">
            <h1 class="title is-2"><?= e($title ?? ($content['page_title'] ?? 'Purchase')) ?></h1>

            <!-- Small decorative underline -->
            <div style="width:56px;height:4px;background-color:var(--primary);margin:0.5rem auto 1.5rem;border-radius:2px;"></div>

            <div class="content" style="max-width:820px;margin:0 auto;text-align:left;">
                <?php if (!empty($content['content_text'])): ?>
                    <?php
                        // Replace {email} placeholder with the theme contact email
                        $text = nl2br(e($content['content_text']));
                        $email = \App\Models\ThemeSetting::get('gallery_contact_email', '');

                        if (!empty($email)) {
                            $text = str_replace('{email}', "<a href=\"mailto:" . e($email) . "\">" . e($email) . "</a>", $text);
                        } else {
                            // Remove the placeholder if no theme email is configured
                            $text = str_replace('{email}', '', $text);
                        }

                        echo $text;
                    ?>
                <?php endif; ?>

                <!-- Centered button -->
                <?php if (!empty($content['button_url'])): ?>
                    <div style="text-align:center;margin-top:2.5rem;">
                        <a href="<?= e($content['button_url']) ?>" class="button is-outlined" target="_blank" rel="noopener noreferrer"><?= e($content['button_text'] ?? 'Learn More') ?></a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
