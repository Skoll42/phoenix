<div class="sticky-footer">
    <div class="progressbar">
        <div class="progress category-background"></div>
    </div>
    <div class="container sticky-footer-content hidden">
        <div class="row">
            <div class="col-xs-12">
                <div class="footer-status footer-status-announce">

                    <div class="footer-status-announce">
                        <div class="layout">
                            <div class="layout-left">
                                <?php the_field('spid_stickyfooter_promo_text_free', 'option', false); ?>
                            </div>
                            <div class="layout-right">
                                <?php module_template('sticky-footer/footer-user'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="footer-status-remains">
                        <div class="layout">
                            <div class="layout-left">
                                <span class="paywall-articles-remained-counter"><?php echo str_replace('{counter}', '<span class="paywall-articles-remained highlight category-color"></span>', get_field('spid_remains_article_text', 'option', false)); ?></span>
                                <span class="paywall-articles-remained-empty hidden"><?php the_field('spid_remains_article_empty_text', 'option', false); ?></span>
                            </div>
                            <div class="layout-right">
                                <?php module_template('sticky-footer/footer-user'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="footer-status-premium">
                        <div class="layout">
                            <div class="layout-left">
                                <?php the_field('spid_stickyfooter_promo_text_premium', 'option', false); ?>
                            </div>
                            <div class="layout-right">
                                <?php module_template('sticky-footer/footer-user'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="footer-status-cookies">
                        <div class="layout">
                            <div class="layout-left">
                                <?php the_field('enable_cookies_message', 'option', false); ?>
                            </div>
                            <div class="layout-right">
                                <?php module_template('sticky-footer/footer-user'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
