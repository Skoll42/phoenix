<?php if (bt_is_article_header_type('image')): ?>
    <div class="post-thumbnail article-header article-header-<?php echo bt_get_article_header_type(); ?>">
        <div class="image-full-width-container">
            <div class="image-full-width">
                <?php echo get_lazy_loaded_wp_attachment_image(bt_get_article_header_image_id(), 'bt-large', false); ?>
            </div>
        </div>

        <?php if (bt_get_article_header_text()): ?>
            <div class="container">
                <div class="row">
                    <div class="image-description">
                        <?php echo bt_get_article_header_text(); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (get_post_type() == 'podcast') : ?>
            <div class="container podcast-byline-container">
                <div class="row">
                    <?php module_template('podcast/header-info'); ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
<?php endif; ?>
