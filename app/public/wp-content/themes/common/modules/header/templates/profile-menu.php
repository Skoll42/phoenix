<div class="modal" id="profile-menu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content category-border-bottom menu-right-column">
            <div class="user-section">
                <a href="<?php echo get_product_page_url(); ?>" class="buy-subscription category-background">bli abonnent</a>
                <div class="login-wrapper spid-user-status-default"><div class="user-menu"><a class="spid-do-login" href="#">Logg in</a></div></div>
                <?php module_template('header/mobile-user-block-status-extended', ['status' => 'agreement']); ?>
                <?php module_template('header/mobile-user-block-status-extended', ['status' => 'buy']); ?>
                <?php module_template('header/mobile-user-block-status-extended', ['status' => 'ok']); ?>
            </div>
        </div>
    </div>
</div>