<?php
$post_id = get_query_var('post_id', null);
?>
<?php if (!is_null($post_id)) : ?>
    <?php $query = new WP_Query(array(
        'p' => $post_id,
        'post_status' => 'publish',
        'post_type' => 'sponsored',
    )); ?>

    <?php if ($query->have_posts()) : $query->the_post(); ?>
        <article class="article article-small article-e24">
            <?php module_template('sponsored/header'); ?>
            <?php module_template('theme/article/_article', [
                'image_size' => 'bt-small',
                'sponsored_target' => true
            ]); ?>
        </article>
    <?php endif; ?>

<?php else : ?>
    <div class="sponsor-block sponsor-block-<?php echo (!empty($__data['block_id']) ? $__data['block_id'] : 'e24'); ?>">
        <div class="sponsor-block-inner">Loading...</div>
    </div>
<?php endif; ?>
