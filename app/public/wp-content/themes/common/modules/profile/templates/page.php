<?php get_header(); ?>

<div class="profile-content">
<?php if (!spid_is_user_authorized()) : ?>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="login-message">
                    <h3><?php the_field('logged_out_title', 'option'); ?></h3>
                    <button class="spid-do-login login-button"><?php the_field('log_in_button', 'option'); ?></button>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="user-profile-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="user-profile">
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#settings" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="true">PROFILINNSTILLINGER</a>
                            </li>
                            <li role="presentation">
                                <a href="#voucher" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="true">VOUCHER</a>
                            </li>
                        </ul>
                        <div class="expire-message hidden">
                            <?php the_field('expire_message', 'option'); ?>
                        </div>
                        <div class="tab-content row">
                            <div role="tabpanel" class="tab-pane active" id="settings">
                                <div class="col-xs-12 col-sm-4">
                                    <div class="profile-title">Profil</div>
                                    <ul class="user-info">
                                        <li class="user-name profile-username">-</li>
                                        <li class="user-email profile-email">-</li>
                                    </ul>
                                    <div class="profile-vertical-divider hidden-xs"></div>
                                    <a href="#" class="profile-history-link hidden-xs" target="_blank">Betalingsinfo</a>
                                    <a class="spid-do-logout logout-button hidden-xs">Logg ut</a>
                                </div>
                                <div class="col-xs-12 col-sm-8">
                                    <div class="abonement-section">
                                        <div class="abonement-title"><?php the_field('abonement_title', 'option'); ?></div>
                                        <div class="buy-block">
                                            <div class="buy-block-title"><?php the_field('buy_message', 'option'); ?></div>
                                            <div class="buy-button">
                                                <a href="<?php echo get_product_page_url(); ?>"><?php the_field('buy_button', 'option'); ?></a>
                                            </div>
                                        </div>
                                        <div class="show-block hidden">
                                            <div class="show-block-title"><?php the_field('show_message', 'option'); ?></div>
                                            <div class="show-block-note"></div>
                                            <div class="show-button">
                                                <a href="#"><?php the_field('show_button', 'option'); ?></a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php module_template('profile/newsletters'); ?>
                                    <div class="user-info-mobile visible-xs">
                                        <div class="profile-vertical-divider"></div>
                                        <a href="#" class="profile-history-link" target="_blank">Betalingsinfo</a>
                                        <a class="spid-do-logout logout-button">Logg ut</a>
                                    </div>
                                </div>                                
                            </div>                

                            <div role="tabpanel" class="tab-pane" id="voucher">
                                <div class="top-title"><?php the_field('voucher_top_title', 'option'); ?></div>
                                <div class="voucher-code">
                                    <input type="text" name="voucher code" placeholder="DIN KODE" class="profile-voucher-code">
                                </div>
                                <div class="voucher-value"></div>
                                <a class="verification-button profile-apply-voucher"><?php the_field('voucher_verification_button', 'option'); ?></a>
                                <div class="voucher-message"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
</div>

<?php get_footer(); ?>
