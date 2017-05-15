<article class="article-snappet">
    <?php if (bt_has_snappet_fronted_element('title')): ?>
        <h4 class="category-color"><?php echo nl2br(get_the_title()); ?></h4>
        <?php if(is_post_type_archive('snappet')): ?>
            <div class="snappet-date"><?php echo get_the_date('d.m.Y'); ?></div>
        <?php endif; ?>
    <?php endif; ?>
    <?php if (bt_has_snappet_fronted_element('content')): ?>
        <p><?php the_content(); ?></p>
    <?php endif; ?>
</article>
