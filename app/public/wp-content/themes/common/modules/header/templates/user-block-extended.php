<div class="spid-user-status-default user-section">
    <a href="<?php echo get_product_page_url(); ?>" class="buy-subscription category-background hidden">bli abonnent</a>
    <div class="login-wrapper spid-user-status-default"><a class="spid-do-login hidden" href="#">Logg in</a></div>
    <?php module_template('header/user-block-status-extended', ['status' => 'agreement']); ?>
    <?php module_template('header/user-block-status-extended', ['status' => 'buy']); ?>
    <?php module_template('header/user-block-status-extended', ['status' => 'ok']); ?>
    <a href="#" data-toggle="modal" data-target="#extended-menu" class="user-account">
        <?php insert_svg('header/user-icon.svg'); ?>
        <span class="user-notifier category-background hidden"></span>
    </a>
</div>