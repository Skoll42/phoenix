<?php
$terms = get_terms([
	'taxonomy' => 'podcast_category',
]);
?>
<?php if (!empty($terms) && !is_wp_error($terms)): ?>
    <div class="podcast-menu-wrapper podcast-menu-collapsed category-background">
        <div class="container">
            <div class="row">
                <div class="podcast-menu">
                    <div class="podcast-menu-inner">
                        <div class="podcast-menu-content">
                            <div class="title">Velg podkast</div>
                            <div class="list">
                                <?php $i = 1; ?>
                                <?php foreach ($terms as $term): ?>
                                    <?php $category_logo = get_field('podcast_category_logo', $term->taxonomy . '_' . $term->term_id); ?>
                                    <?php if (!empty($category_logo)): ?>
                                        <a href="<?php echo get_category_link($term->term_id); ?>" class="category-logo"
                                           title="<?php esc_attr_e($term->name); ?>" style="background: url(<?php esc_attr_e($category_logo); ?>);"></a>
                                        <?php if ($i % 4 == 0): ?><span class="category-logo-separator"></span><?php endif; ?>
                                        <?php $i++; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="podcast-menu-toggle">
                        <div class="button category-background">
                            <div class="button-open">
                                <span class="icon"><?php insert_svg('podcast/menu-open.svg'); ?></span>
                                <span class="title">Vis podkastmenyen</span>
                            </div>
                            <div class="button-close">
                                <span class="icon category-svg-fill"><?php insert_svg('podcast/menu-close.svg'); ?></span>
                                <span class="title category-color">Skjul podkastmenyen</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>