<?php
$episode_id = get_the_ID();
$terms = wp_get_post_terms($episode_id, 'podcast_category');
$category = !empty($terms[0]) ? $terms[0] : null;

if (!empty($category)) {
    $query = new WP_Query([
        'posts_per_page' => 10,
        'post_status' => 'publish',
        'post_type' => 'podcast',
        'post__not_in' => [$episode_id],
        'tax_query' => array(
            array(
                'taxonomy' => 'podcast_category',
                'field' => 'term_id',
                'terms' => $category->term_id,
                'include_children' => false,
            ),
        ),
    ]);
}
?>
<?php if ($query->have_posts()): ?>
    <div class="podcast-latest">
        <div class="title">Hør tidligere <?php echo $category->name; ?>-episoder her:</div>
        <div class="list">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
	            <div class="episode-item">
	                <div class="episode-id category-color" style="display: none;"><?php /* TODO: temporarily hidden */ ?>
	                    Episode <?php the_ID(); ?>
	                </div>
	                <div class="episode-title">
	                    <a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a>
	                </div>
	            </div>
            <?php endwhile; ?>
        </div>
        <div class="button-wrapper">
            <a href="<?php echo get_category_link($category->term_id); ?>" class="category-background">Se podkast side</a>
        </div>
    </div>
<?php endif; ?>

<?php wp_reset_query(); ?>
