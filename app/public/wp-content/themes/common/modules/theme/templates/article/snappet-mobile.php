<div class="snappet single-snappet">
	<h3 class="category-background">
		<a href="<?php echo get_category_link(get_category_by_slug('snappet')); ?>" target="<?php echo in_iframe() ? '_parent' : '_blank' ;?>">SNAPPET</a>
	</h3>
	<div class="snappet-body">
		<article>
            <?php if (bt_has_snappet_fronted_element('title')): ?>
                <h4 class="title category-color"><?php echo nl2br(get_the_title()); ?></h4>
            <?php endif; ?>
            <?php if (bt_has_snappet_fronted_element('content')): ?>
                <p><?php the_content(); ?></p>
            <?php endif; ?>
		</article>
	</div>        
</div>
