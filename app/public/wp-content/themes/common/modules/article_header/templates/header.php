<?php if (!bt_is_article_header_type('empty')): ?>
    <div class="post-thumbnail article-header article-header-<?php echo bt_get_article_header_type(); ?>">

        <?php if (bt_is_article_header_type('image')): ?>

            <?php echo get_lazy_loaded_wp_attachment_image(get_field('article_header_image'), 'bt-large', false, array('class' => 'img-responsive')); ?>

        <?php elseif (bt_is_article_header_type('carousel')): ?>

            <?php muneeb_ssp_slider( get_field('article_header_carousel') ); ?>

        <?php elseif (bt_is_article_header_type('embed_code')): ?>

            <div class="videoWrapper">
                <?php echo bt_insert_article_header_embed_code(); ?>
            </div>

        <?php endif; ?>

        <?php if (bt_get_article_header_text()): ?>
            <div class="image-description">
                <?php echo bt_get_article_header_text(); ?>
            </div>
        <?php endif; ?>

        <?php if (get_post_type() == 'podcast') : ?>
            <?php module_template('podcast/header-info'); ?>
        <?php endif; ?>

    </div>
<?php endif; ?>
