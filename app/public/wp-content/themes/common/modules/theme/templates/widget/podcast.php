<?php
$podcast_tabs = [];
$terms = get_terms([
    'taxonomy' => 'podcast_category',
]);
if (!empty($terms) && !is_wp_error($terms)) {
    $i = 0;
    foreach ($terms as $term) {
        $category_logo = get_field('podcast_category_logo', $term->taxonomy . '_' . $term->term_id);
        if (!empty($category_logo)) {
            $podcast_tabs[] = [
                'id' => $term->term_id,
                'name' => $term->name,
                'logo-url' => $category_logo,
                'active' => $i == 0,
            ];
            $i++;
        }
    }
}
?>
<?php if (!empty($podcast_tabs)): ?>
    <div class="podcast-widget section-common">
        <h3 class="category-background"><a href="/podcasts/">Podkasts</a></h3>
        <div class="down-arrow category-border-top"></div>
        <div class="podcast-tabs">

            <div class="podcast-navigation podcast-prev"><?php insert_svg('theme/arrow-down.svg'); ?></div>

            <div class="nav-wrapper">
                <ul class="nav nav-tabs<?php echo count($podcast_tabs) < 7 ? ' tab-proportional' : ''; ?>">
                    <?php foreach ($podcast_tabs as $podcast_tab): ?>
                        <li class="category-border-bottom<?php echo $podcast_tab['active'] ? ' active' : ''; ?>">
                            <a data-toggle="tab" data-target-id="podcast-<?php echo $podcast_tab['id']; ?>"
                               title="<?php echo $podcast_tab['name']; ?>" style="background: url(<?php esc_attr_e($podcast_tab['logo-url']); ?>);">
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="podcast-navigation podcast-next"><?php insert_svg('theme/arrow-down.svg'); ?></div>

            <div class="tab-content">
                <?php foreach ($podcast_tabs as $podcast_tab): ?>
                    <div data-id="podcast-<?php echo $podcast_tab['id']; ?>" class="tab-pane" <?php echo $podcast_tab['active'] ? ' style="display: block;"' : ''; ?>">
                        <div class="podcast-title">Sysla <?php echo $podcast_tab['name']; ?></div>
                        <div class="all-button">
                            <a href="<?php echo get_category_link($podcast_tab['id']); ?>" class="category-color"<?php echo (in_iframe() ? ' target="_parent"' : ''); ?>>Se alle episodene &gt;</a>
                        </div>
                        <?php
                        $query = new WP_Query([
                            'posts_per_page' => 3,
                            'post_status' => 'publish',
                            'post_type' => 'podcast',
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'podcast_category',
                                    'field' => 'term_id',
                                    'terms' => $podcast_tab['id'],
                                    'include_children' => false,
                                ),
                            ),
                        ]);
                        ?>
                        <?php if ($query->have_posts()): ?>
                            <div class="podcast-articles">
                                <?php $j = 1; ?>
                                <?php while ($query->have_posts()): $query->the_post(); ?>
                                    <div class="<?php if ($j != 3): ?>col-sm-6 col-md-4<?php else: ?>col-sm-4 hidden-sm<?php endif; ?>">
                                        <?php module_template('theme/article/small'); ?>
                                    </div>
                                    <?php $j++; ?>
                                <?php endwhile; ?>
                                <div class="clearfix"></div>
                            </div>
                        <?php endif; ?>

                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>