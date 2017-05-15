<?php get_header(); ?>
<div class="subscription-block">

    <div class="experiment-1" id="premium-experiment-1">
        <div class="top-message-ab">
            <?php the_field('spid_exp1_top_text', 'option'); ?>
        </div>
        <div class="subscription-plans-ab">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-4">
                        <div class="plan-body plan-first">
                            <div class="header-text"><?php the_field('spid_exp1_prod1_header_text', 'option'); ?></div>
                            <div class="line-divider hidden-xs"></div>
                            <div class="footer-text"><?php the_field('spid_exp1_prod1_footer_text', 'option'); ?></div>
                            <div class="action-button">
                                <button type="button" class="buy-button spid-buy-product-by-id" data-product-id="<?php the_field('spid_exp1_prod1_product_id', 'option'); ?>"><?php the_field('spid_exp1_prod1_button_text', 'option'); ?></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <div class="plan-body plan-second">
                            <div class="header-text"><?php the_field('spid_exp1_prod2_header_text', 'option'); ?></div>
                            <div class="line-divider hidden-xs"></div>
                            <div class="footer-text"><?php the_field('spid_exp1_prod2_footer_text', 'option'); ?></div>
                            <div class="action-button">
                                <button type="button" class="buy-button spid-buy-product-by-id" data-product-id="<?php the_field('spid_exp1_prod2_product_id', 'option'); ?>"><?php the_field('spid_exp1_prod2_button_text', 'option'); ?></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <div class="plan-body plan-third">
                            <div class="header-text">Firma eller<br/>ORGANISASJON?</div>
                            <div class="line-divider hidden-xs"></div>
                            <div class="footer-text">Kontakt oss for tilbud</div>
                            <div class="action-button">
                                <a href="#" class="contact-button">KONTAKT OSS</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="sub-plan-text">
                            <a href="<?php echo get_product_page_url(); ?>" class="bottom-link">Eller prøv et av våre andre produkter</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>