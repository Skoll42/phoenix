<?php if ( have_posts() ) : the_post(); ?>
<?php
    $header_layout = get_field('article_header_layout');
    $showFullWidthHeader = ($header_layout == 'full');
    $shouldShowContent = spid_is_content_accessable() && !spid_cookies_disabled();
    $current_category = bt_archive_get_current_category()->slug;
?>
<div id="dynamic_content">
    <div id="article_page_content">
        <div class="article-content<?php echo !empty($header_layout) ? ' article-header-layout-' . $header_layout : '' ?>">

            <?php if ($showFullWidthHeader): ?>
                <?php module_template('article_header/header-full-width'); ?>
            <?php endif; ?>

            <div class="container">
                <div class="row">
                    <div class="<?php if (get_post_type() == 'sponsored') : ?>col-md-6 col-md-offset-3<?php else: ?>col-md-8<?php endif; ?>">
                        <div class="post">
                            <div class="post-head">
                                <?php if (!$showFullWidthHeader) : ?>
                                    <?php module_template('article_header/header'); ?>
                                <?php endif; ?>
                                <h1 class="title">
                                    <?php the_title(); ?>
                                </h1>

                                <?php if (has_excerpt()) : ?>
                                    <div class="lead-text">
                                        <?php the_excerpt(); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (!in_array(get_post_type(), ['snappet', 'sponsored'])): ?>
                                    <?php module_template('theme/block/byline'); ?>
                                <?php endif; ?>
                            </div>

                            <?php if (spid_cookies_disabled()) : ?>
                                <?php module_template('spid/enable-cookies-message'); ?>
                            <?php elseif (!spid_is_content_accessable()) : ?>
                                <?php module_template('spid/premium-message'); ?>
                            <?php else: ?>
                                <div class="post-content">
                                    <div class="post-body<?php echo ' ' . $current_category; ?>">
                                        <?php module_template('article_content/jobben'); ?>
                                        <?php the_content(); ?>
                                        <?php if (get_post_type() == 'sponsored') : ?>
                                            <?php module_template('sponsored/article-tail'); ?>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <?php if (get_post_type() == 'podcast') : ?>
                                    <?php module_template('podcast/latest'); ?>
                                <?php endif; ?>

                                <?php module_template('article_content/social_share'); ?>
                                <?php module_template('fishiri/article_fishiri_data', ['article_id' => get_the_ID()]); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if ($shouldShowContent && (get_post_type() !== 'sponsored')) : ?>
                        <div class="col-md-4">
                            <div class="sidebar">
                                <div class="sticky-wrapper">
                                    <div class="adv-block">
                                        <div class="ad-nexus-ad visible-md visible-lg" data-id="<?php echo (get_current_frontpage() . '-wde-article-skyscraperright-1'); ?>"></div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="sticky-wrapper">
                                    <?php module_template('oceanhub/widget'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-8">
                            <div class="adv-block">
                                <div class="ad-nexus-ad visible-md visible-lg" data-id="<?php echo (get_current_frontpage() . '-wde-article-netboard-1'); ?>"></div>
                                <div class="ad-nexus-ad visible-sm" data-id="<?php echo (get_current_frontpage() . '-wtb-article-netboard-1'); ?>"></div>
                                <div class="ad-nexus-ad visible-xs" data-id="<?php echo (get_current_frontpage() . '-wph-article-board-1'); ?>"></div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if(!in_iframe()) : ?>
    <?php module_template('sticky-footer/footer'); ?>
<?php endif; ?>
<?php endif; ?>
