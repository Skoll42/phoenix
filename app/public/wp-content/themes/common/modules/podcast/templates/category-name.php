<?php
$terms = get_the_terms(get_the_ID(), 'podcast_category');
$category = !empty($terms[0]) ? $terms[0] : null;
?>
<?php if (!empty($category)): ?>
    <div class="podcast-category-name">
        <a href="<?php echo get_category_link($category->term_id); ?>">Sysla<span><?php echo $category->name; ?></span></a>
    </div>
<?php endif; ?>