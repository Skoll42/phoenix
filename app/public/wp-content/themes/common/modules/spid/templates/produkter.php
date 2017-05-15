<?php get_header(); ?>

<?php if (isset($_GET['redirect_to'])): ?>
    <?php
    $host = parse_url($_GET['redirect_to'], PHP_URL_HOST);
    if (strpos($host, 'offshore') !== false) {
        $website = 'Offshore';
    } else if (strpos($host, 'maritime') !== false) {
        $website = 'Maritime';
    } else if (strpos($host, 'syslagronn') !== false) {
        $website = 'Sysla grønn';
    } else {
        $website = 'Sysla';
    }
    ?>
    <div class="container visible-lg">
        <div class="back-button">
            <a href="<?php echo $_GET['redirect_to']; ?>">Tilbake til <span><?php echo $website; ?></span></a>
        </div>
    </div>
<?php endif; ?>

<div class="product-page">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-4">
                <div class="price-block">
                    <div class="price-wrapper">
                        <div class="price"><?php the_field('spid_product_page_prod1_main_text', 'option'); ?></div>
                        <div class="price-note"><?php the_field('spid_product_page_prod1_sub_text', 'option'); ?></div>
                    </div>                    
                    <div class="price-line-divider"></div>
                    <div class="action-button">
                        <button class="buy-button spid-buy-product-by-id" data-product-id="<?php the_field('spid_product_page_prod1_product_id', 'option'); ?>"><?php the_field('spid_product_page_prod1_button_text', 'option'); ?></button>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4">
                <div class="price-block">
                    <div class="price-wrapper">
                        <div class="price"><?php the_field('spid_product_page_prod2_main_text', 'option'); ?></div>
                        <div class="price-note"><?php the_field('spid_product_page_prod2_sub_text', 'option'); ?></div>
                    </div>                    
                    <div class="price-line-divider"></div>
                    <div class="action-button">
                        <button class="buy-button spid-buy-product-by-id" data-product-id="<?php the_field('spid_product_page_prod2_product_id', 'option'); ?>"><?php the_field('spid_product_page_prod2_button_text', 'option'); ?></button>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4">
                <div class="price-block price-block-third">
                    <div class="price-wrapper">
                        <div class="price">Firma eller organisasjon?</div>
                    </div>                    
                    <div class="price-line-divider"></div>
                    <div class="action-button">
                        <a href="#" class="contact-button">Kontakt oss</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="sites-information">
        <div class="container">
            <div class="sites-divider"></div>
        </div>  
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="logos">
                        <div class="sysla">
                            <span class="site-logo sysla-small">
                                <?php insert_svg(bt_header_get_section_logo('sysla')); ?>
                            </span>
                        </div>
                        <div class="syslagronn">
                            <span class="site-logo sysla-small">
                                <?php insert_svg(bt_header_get_section_logo('sysla')); ?>
                            </span>
                            <div class="logo-divider"></div>
                            <span class="site-logo logo-small">
                                <?php insert_svg(bt_header_get_section_logo('gronn')); ?>
                            </span>
                        </div>
                        <div class="offshore">
                            <span class="site-logo sysla-small">
                                <?php insert_svg(bt_header_get_section_logo('sysla')); ?>
                            </span>
                            <div class="logo-divider"></div>
                            <span class="site-logo logo-small">
                                <?php insert_svg(bt_header_get_section_logo('offshore')); ?>
                            </span>
                        </div>
                        <div class="maritim">
                            <span class="site-logo sysla-small">
                                <?php insert_svg(bt_header_get_section_logo('sysla')); ?>
                            </span>
                            <div class="logo-divider"></div>
                            <span class="site-logo logo-small">
                                <?php insert_svg(bt_header_get_section_logo('maritim')); ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="sites-divider sites-divider-bottom"></div>
        </div>
    </div>

    <div class="price-information">
        <div class="container">
            <div class="row">
                <?php the_field('spid_product_page_content', 'option'); ?>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
