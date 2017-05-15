<?php
    $should_be_podcast_header = bt_should_be_podcast_header();
    $current_category = ($should_be_podcast_header ? 'podcasts' : bt_archive_get_current_category()->slug);
    $is_main_category = bt_archive_is_default_category($current_category);
?>
<nav class="navbar navbar-bt main-header">
    <div class="container main-header-container">
        <div class="row">
            <div class="col-xs-7 col-sm-6 col-md-3 col-lg-2">
                <div class="menu-section">
                    <a href="#" data-toggle="modal" data-target="#extended-menu" class="menu-button category-svg-fill">
                        <?php insert_svg('header/menu-button.svg'); ?>
                    </a>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" class="site-logo <?php echo $is_main_category || is_page() ? 'sysla-big' : 'sysla-small' ; ?>">
                        <?php insert_svg(bt_header_get_section_logo('sysla')); ?>
                    </a>
                    <div class="logo-divider<?php echo $is_main_category || is_page() ? ' hidden' : '' ; ?>"></div>
                    
                    <?php if ($should_be_podcast_header): ?>
                        <a href="<?php echo esc_url( home_url( '/podcasts/' ) ); ?>" title="Podcasts" class="site-logo logo-small">
                            <?php insert_svg(bt_header_get_section_logo('podcasts')); ?>
                        </a>
                    <?php else: ?>
                        <a href="<?php echo get_category_link(bt_archive_get_current_category()); ?>" title="<?php echo strtoupper($current_category); ?>" class="site-logo <?php echo $is_main_category ? 'hidden' : 'logo-small' ; ?>">
                            <?php insert_svg(bt_header_get_section_logo($current_category)); ?>
                        </a>
                    <?php endif; ?>

                    <div class="modal" id="extended-menu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <?php module_template('header/mobile-menu-fixed'); ?>
                            <div class="modal-content category-border-bottom">
                                <?php module_template('header/menu-extended'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-5 col-sm-6 col-md-4 col-md-push-5 col-lg-push-6 user-section-container">
                <div class="spid-user-status-default user-section hidden-xs">
                    <a href="<?php echo get_product_page_url(); ?>" class="buy-subscription category-background hidden">bli abonnent</a>
                </div>
                <?php module_template('header/user-block'); ?>
            </div>
            <div class="col-xs-12">
                <?php module_template('header/profile-menu'); ?>
            </div>
        </div>
    </div>

    <?php if (get_post_type() == 'sponsored') : ?>
        <div class="sponsored-header">
            <div class="container">
                <div class="row">
                    <?php module_template('sponsored/header'); ?>
                </div>
            </div>
        </div>
    <?php elseif ($should_be_podcast_header) : ?>
        <?php module_template('podcast/menu'); ?>
    <?php endif; ?>
</nav>
