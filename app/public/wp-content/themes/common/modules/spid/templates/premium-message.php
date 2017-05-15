<div class="subscription-block">
    <div class="experiment-1" id="premium-experiment-1">
        <div class="top-message-ab">
            <?php the_field('spid_exp1_top_text', 'option'); ?>
        </div>
        <div class="subscription-plans-ab">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="plan-body">
                            <div class="period">
                                <span class="days plan-a"><?php the_field('spid_exp1_prod_days', 'option'); ?></span>
                                <span class="for category-background">for</span>
                            </div>
                            <div class="price plan-a"><?php the_field('spid_exp1_prod_price', 'option'); ?></div>
                            <div class="try-button">
                                <button type="button" class="buy-button spid-buy-product-by-id category-background" data-product-id="<?php the_field('spid_exp1_prod_product_id', 'option'); ?>"><?php the_field('spid_exp1_prod_button_text', 'option'); ?></button>
                            </div>
                            <div class="bottom-text"><?php the_field('spid_exp1_bottom_text', 'option'); ?></div>
                            <a href="<?php echo get_product_page_url(); ?>" class="bottom-link">Eller prøv et av våre andre produkter</a>
                            <a href="<?php echo get_product_page_url(); ?>" class="bottom-link-color category-color">Firma eller organisasjon?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

