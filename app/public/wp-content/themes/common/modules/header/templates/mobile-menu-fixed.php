<div class="mobile-fixed-top visible-xs">
    <div class="mobile-top">
        <a class="close-button category-svg-fill" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span>
            <?php insert_svg('header/close-button.svg'); ?>
        </a>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" class="site-logo">
            <?php insert_svg(bt_header_get_section_logo('sysla')); ?>
        </a>
        <a href="#" data-toggle="modal" data-target="#profile-menu" class="user-account">
            <?php insert_svg('header/user-icon.svg'); ?>
            <span class="user-notifier category-background hidden"></span>
        </a>
    </div>
    <ul class="menu-list">
        <li class="about-us-menu">
            <?php wp_nav_menu([
                'container' => false,
                'menu_class' => '',
                'menu' => 'about-us-menu',
            ]); ?>
        </li>
        <li class="search-field">
            <a href="#" class="open-search-mobile"><span>søk</span><?php insert_svg('header/search-button.svg'); ?></a>
            <a href="#" class="close-search-mobile hidden"><span class="category-color">søk</span><?php insert_svg('header/close-button.svg'); ?></a>
        </li>
    </ul>
</div>