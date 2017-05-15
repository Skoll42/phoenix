<?php
	$e24feed = get_e24feed();
	$amount_e24_items = count($e24feed);
	$counter = 0;
?>
<div class="e24-widget section-common">
	<h3 class="category-background">Aksjelive</h3>
	<div class="partner-company">
		<a href="<?php the_field('e24_website_url', 'option'); ?>" title="Aksjelive E24"<?php if (in_iframe()): ?> target="_parent"<?php endif; ?>>
			<span>I samarbeid med</span>
			<img src="<?php module_img('theme/e24-logo.png'); ?>" alt="Aksjelive E24 Logo" />
		</a>
	</div>
	<div class="down-arrow category-border-top"></div>
	<ul class="articles-list">
<?php while($counter < $amount_e24_items) : ?>
		<li>
			<a href="<?php echo $e24feed[$counter]['article_url'];?>" title="<?php echo $e24feed[$counter]['article_title'];?>" class="article-body" target="<?php echo (in_iframe() ? '_parent' : '_blank'); ?>">
				<div class="article-title"><?php echo $e24feed[$counter]['article_title'];?></div>
				<div class="article-excerpt"><?php echo $e24feed[$counter]['article_description'];?></div>
			</a>
		</li>
	<?php $counter++; ?>
<?php endwhile; ?>
	</ul>
</div>