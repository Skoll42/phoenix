<?php
/*
 * Template Name: Custom Page
 */
?>
<?php get_header(); ?>
<div class="custom-page-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="page-title"><?php echo get_the_title(); ?></div>
                <div class="horizontal-separator"></div>
            </div>
            <div class="custom-page-body">
                <div class="col-xs-12 col-sm-10 col-sm-offset-1">
                    <?php the_content(); ?>                    
                    <?php if(get_post_field( 'post_name') == 'kontakt-oss'): ?>
                        <div class="follow-block">
                            <div class="follow-title">Følg oss</div>
                            <div class="follow-links">
                                <a href="https://www.facebook.com/sysla.no" target="<?php echo (in_iframe() ? '_parent' : '_blank'); ?>"><img src="<?php module_img('theme/facebook-follow.png'); ?>" alt="Facebook"/></a>
                                <a href="https://www.twitter.com/syslano" target="<?php echo (in_iframe() ? '_parent' : '_blank'); ?>"><img src="<?php module_img('theme/twitter-follow.png'); ?>" alt="Twitter"/></a>
                                <a href="https://www.instagram.com/sysla.no" target="<?php echo (in_iframe() ? '_parent' : '_blank'); ?>"><img src="<?php module_img('theme/instagram-follow.png'); ?>" alt="Instagram" /></a>
                                <a href="https://www.linkedin.com/company/sysla-no" target="<?php echo (in_iframe() ? '_parent' : '_blank'); ?>"><img src="<?php module_img('theme/linkedin-follow.png'); ?>" alt="Linkedin"/></a>
                            </div>
                            <div class="follow-text">Sysla.no arbeider etter Vær Varsom-plakatens regler for god presseskikk.</div>
                        </div>
                    <?php endif; ?>
                    <div class="horizontal-separator"></div>
                </div>
            </div>            
            <div class="sysla-links">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-4">
                            <a href="http://www.bt.no/" target="<?php echo (in_iframe() ? '_parent' : '_blank'); ?>">
                                <img src="<?php module_img('theme/bt-logo.png'); ?>" alt="BT Logo" />
                            </a>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <a href="http://www.schibsted.com/" target="<?php echo (in_iframe() ? '_parent' : '_blank'); ?>">
                                <img src="<?php module_img('theme/schibsted-logo.png'); ?>" alt="Schibsted Logo" />
                            </a>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <a href="http://www.aftenbladet.no/" target="<?php echo (in_iframe() ? '_parent' : '_blank'); ?>">
                                <img src="<?php module_img('theme/aftenblad-logo.png'); ?>" alt="Aftenblad Logo" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>