<div class="container">
    <div class="row">
        <div class="col-xs-7 col-sm-4 col-md-3 col-lg-2 hidden-xs left-menu-wrapper">
            <div class="menu-left-column hidden-xs">
            <a href="#" class="close-button category-svg-fill" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span>
                <?php insert_svg('header/close-button.svg'); ?>
            </a>
                <div class="pull-right">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" class="site-logo">
                        <?php insert_svg(bt_header_get_section_logo('sysla')); ?>
                    </a>
                    <ul class="menu-list">
                        <li class="about-us">
                            <?php wp_nav_menu([
                                'container' => false,
                                'menu_class' => '',
                                'menu' => 'about-us-menu',
                            ]); ?>
                        </li>
                        <li class="search-field">
                            <a href="#" class="open-search">
                                <span>søk</span>
                                <?php insert_svg('header/search-button.svg'); ?>
                            </a>
                            <a href="#" class="close-search hidden">Lukk søk <?php insert_svg('header/close-button.svg'); ?></a>
                            <div class="search-area hidden">
                                <input type="text" class="search-input" value="">
                                <input type="submit" class="search-button" value="">
                                <input type="submit" class="close-search-button hidden" value="">
                            </div>
                        </li>
                    </ul>
                    <div class="social-networks">
                        <a href="https://www.facebook.com/sysla.no">
                            <?php insert_svg('header/social/facebook-share.svg'); ?>
                        </a>
                        <a href="https://twitter.com/syslano">
                            <?php insert_svg('header/social/twitter-share.svg'); ?>
                        </a>
                        <a href="http://www.linkedin.com/company/sysla-no">
                            <?php insert_svg('header/social/linkedin-share.svg'); ?>
                        </a>
                    </div>
                </div>

        </div>
        </div>
        <div class="col-sm-3 col-md-5 col-lg-6 hidden-xs">
            <div class="row">
                <div class="menu-middle-column">
                    <div class="section-links">
                        <?php wp_nav_menu([
                            'walker' => new BT_Walker_Nav_Menu(),
                            'container' => false,
                            'menu_class' => '',
                            'nav_menu_css_class' => 'col-sm-6',
                            'menu' => 'header-menu',
                        ]); ?>
                        <div class="clearfix"></div>
                    </div>
                    <div class="search-container hidden">
                        <?php module_template('search/keywords'); ?>
                        <?php module_template('search/search-results'); ?>
                    </div>
                    <div class="shipdata-links">
                        <?php wp_nav_menu([
                            'container' => false,
                            'menu_class' => '',
                            'menu' => 'fishiri-menu'
                        ]); ?>
                    </div>
                    <div class="bottom-block">
                        <div class="menu-info">
                            Sysla.no arbeider etter<br>
                            Vær Varsom-plakatens regler for<br>
                            god presseskikk.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-5 col-md-4 hidden-xs">
            <div class="menu-right-column">
                <?php module_template('header/user-block-extended'); ?>
            </div>
        </div>
        <div class="col-xs-12 visible-xs">
            <?php module_template('header/mobile-menu'); ?>
        </div>
    </div>
</div>