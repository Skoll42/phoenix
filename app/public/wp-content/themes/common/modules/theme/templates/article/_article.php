<?php
$font_size_style = '';
$is_sponsored_article_anchor_target = (isset($__data['sponsored_target']) ? $__data['sponsored_target'] : false);
if (isset($__data['set_fontsize']) && $__data['set_fontsize']) {
    $font_size = bt_get_article_fronted_fontsize();
    if ($font_size) {
        $font_size_style = ' style="font-size: ' . $font_size . 'px; line-height: ' . ($font_size+2) . 'px;"';
    }
}
?>
<div class="header">
    <a href="<?php the_permalink(); ?>"<?php if (in_iframe()): ?> target="_parent"<?php endif; ?>>
        <div class="embed-responsive embed-responsive-16by9">
            <?php if (get_post_type() == 'pressrelease'): ?>
                <?php if (has_post_thumbnail() ): ?>
                    <?php echo get_lazy_loaded_wp_attachment_image(get_post_thumbnail_id(), $__data['image_size'], false, array('class' => 'img-responsive')); ?>
                <?php else: ?>
                    <?php $image = '<img src="' . get_module_img('theme/pressemelding.jpg') . '" alt="' . get_the_title() . '" class="img-responsive" />'; ?>
                    <?php echo (function_exists('lazyload_images_add_placeholders') ? lazyload_images_add_placeholders($image) : $image); ?>
                <?php endif; ?>
            <?php else: ?>
                <?php $article_fronted_image = bt_get_article_fronted_image(); ?>
                <?php if (get_post_type() == 'sponsored' && empty($article_fronted_image) && has_post_thumbnail()): ?>
                    <?php $article_fronted_image = get_post_thumbnail_id(); ?>
                <?php endif; ?>
                <?php echo get_lazy_loaded_wp_attachment_image($article_fronted_image, $__data['image_size'], false, array('class' => 'img-responsive')); ?>
            <?php endif; ?>
        </div>
    </a>
</div>
<?php if (bt_is_podcast_archive()): ?>
    <?php module_template('podcast/category-name'); ?>
<?php endif; ?>
<h4>
    <a class="title"<?php echo $font_size_style; ?> href="<?php the_permalink(); ?>" title="<?php echo esc_attr(bt_get_article_fronted_title()); ?>"<?php if (in_iframe() || $is_sponsored_article_anchor_target): ?> target="_parent"<?php endif; ?>><?php echo nl2br(bt_get_article_fronted_title()); ?></a>
</h4>
