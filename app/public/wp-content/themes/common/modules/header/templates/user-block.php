<div class="spid-user-status-default user-section">
    <div class="login-wrapper hidden-xs spid-user-status-default"><a class="spid-do-login hidden" href="#">Logg in</a></div>
    <?php module_template('header/user-block-status', ['status' => 'agreement']); ?>
    <?php module_template('header/user-block-status', ['status' => 'buy']); ?>
    <?php module_template('header/user-block-status', ['status' => 'ok']); ?>
    <a href="#" data-toggle="modal" data-target="#extended-menu" class="user-account hidden-xs">
        <?php insert_svg('header/user-icon.svg'); ?>
        <span class="user-notifier category-background hidden"></span>
    </a>
    <a href="#" data-toggle="modal" data-target="#profile-menu" class="user-account hidden-sm hidden-md hidden-lg">
        <?php insert_svg('header/user-icon.svg'); ?>
        <span class="user-notifier category-background hidden"></span>
    </a>
</div>