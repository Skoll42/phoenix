<div class="userdata userdata-status userdata-status-default">
    <div class="userdata-status-default">
        <a href="<?php echo get_product_page_url(); ?>" class="button buy-button hidden-xs category-background"><?php the_field('spid_stickyfooter_button_text', 'option'); ?></a>
        <span class="message"><span class="hidden-xs hidden-sm">Allerede abonnent?</span> <a href="#" class="login-button spid-do-login category-color">Logg inn</a></span>
    </div>
    <div class="userdata-status-authorized">
<!--        <span class="message hidden-xs hidden-sm"><span class="username"></span></span>-->
        <a href="<?php echo get_product_page_url(); ?>" class="button buy-button hidden-xs category-background"><?php the_field('spid_stickyfooter_button_text', 'option'); ?></a>
    </div>
    <div class="userdata-status-agreement">
<!--        <span class="message hidden-xs hidden-sm"><span class="username"></span></span>-->
        <button class="button spid-accept-agreement accept-button">ACCEPT AGREEMENT</button>
    </div>
</div>
