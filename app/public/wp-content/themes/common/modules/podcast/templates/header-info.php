<?php
$terms = wp_get_post_terms(get_the_ID(), 'podcast_category');
$category = !empty($terms[0]) ? $terms[0] : null;
?>

<div class="podcast-byline">
    <div class="podcast-byline-inner">
        <?php if (!empty($category)): ?>
            <span class="category-wrapper">
                <?php $category_logo = get_field('podcast_category_logo', $category->taxonomy . '_' . $category->term_id); ?>
                <?php if (!empty($category_logo)): ?>
                    <span class="category-logo" style="background: url(<?php esc_attr_e($category_logo); ?>);"></span>
                <?php endif; ?>
                <a href="<?php echo get_category_link($category->term_id); ?>" class="category-title">Sysla <span><?php echo $category->name; ?></span></a>
            </span>
        <?php endif; ?>

        <?php $podcast_itunes_url = get_field('podcast_itunes_url'); ?>
        <?php if (!empty($podcast_itunes_url)) : ?>
            <span class="itunes-logo">
                <a href="<?php esc_attr_e($podcast_itunes_url); ?>">
                    <?php insert_svg('podcast/itunes.svg'); ?>
                </a>
            </span>
        <?php endif; ?>

        <?php $podcast_author = get_field('podcast_author'); ?>
        <?php if (!empty($podcast_author)) : ?>
            <span class="podcast-author">
                Arrangert av <span><?php echo $podcast_author; ?></span>
            </span>
        <?php endif; ?>
    </div>
</div>
