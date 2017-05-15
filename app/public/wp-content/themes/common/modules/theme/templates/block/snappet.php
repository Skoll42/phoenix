<?php
$query = new WP_Query([
    'post_type' => 'snappet',
    'post_status' => 'publish',
    'posts_per_page' => 5,
]);
?>
<div class="snappet-block">
    <div class="header">
        <a href="<?php echo get_post_type_archive_link( 'snappet' ); ?>"<?php if (in_iframe()): ?> target="_parent"<?php endif; ?>>Snappet</a>
    </div>

    <div class="content">
        <?php while ($query->have_posts()): $query->the_post(); ?>
            <?php module_template('theme/article/snappet'); ?>
        <?php endwhile; ?>
    </div>

    <div class="footer">
        <a href="<?php echo get_post_type_archive_link( 'snappet' ); ?>"<?php if (in_iframe()): ?> target="_parent"<?php endif; ?>>Se Flere</a>
    </div>
</div>
