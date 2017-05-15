<?php

$cat = bt_archive_get_current_category();
$acf_key = 'category_' . $cat->term_id;

?>
<?php if ($cat): ?>
    <div class="nyhetsbrev-widget section-common">
        <h3 class="category-background"><?php the_field('share_category_title', $acf_key); ?></h3>
        <div class="down-arrow category-border-top"></div>
        <div class="social-block-wrapper">
            <div class="col-sm-6 col-md-4">
                <a href="<?php the_field('share_category_facebook_url', $acf_key); ?>" class="social-block category-border-bottom facebook" target="<?php echo (in_iframe() ? '_parent' : '_blank'); ?>">
                    <div class="social-icon">
                        <img src="<?php module_img('theme/social/facebook-icon.png'); ?>" alt="share icon" />
                    </div>
                    <div class="share-block">
                        <div class="share-title"><?php the_field('share_category_facebook_title', $acf_key); ?></div>
                        <div class="share-icon">
                            <img src="<?php module_img('theme/social/facebook-like-icon.png'); ?>" alt="follow icon" />
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-md-4">
                <a href="<?php the_field('share_category_twitter_url', $acf_key); ?>" class="social-block category-border-bottom twitter" target="<?php echo (in_iframe() ? '_parent' : '_blank'); ?>">
                    <div class="social-icon">
                        <img src="<?php module_img('theme/social/twitter-icon.png'); ?>" alt="share icon" />
                    </div>
                    <div class="share-block">
                        <div class="share-title"><?php the_field('share_category_twitter_title', $acf_key); ?></div>
                        <div class="share-icon">
                            <img src="<?php module_img('theme/social/twitter-follow-icon.png'); ?>" alt="follow icon" />
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-md-4">
                <a href="<?php the_field('share_category_instagram_url', $acf_key); ?>" class="social-block category-border-bottom instagram" target="<?php echo (in_iframe() ? '_parent' : '_blank'); ?>">
                    <div class="social-icon">
                        <img src="<?php module_img('theme/social/instagram-icon.png'); ?>" alt="share icon" />
                    </div>
                    <div class="share-block">
                        <div class="share-title"><?php the_field('share_category_instagram_title', $acf_key); ?></div>
                        <div class="share-icon">
                            <img src="<?php module_img('theme/social/instagram-follow-icon.png'); ?>" alt="follow icon" />
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-md-4">
                <a href="<?php the_field('share_category_linkedin_url', $acf_key); ?>" class="social-block category-border-bottom linkedin" target="<?php echo (in_iframe() ? '_parent' : '_blank'); ?>">
                    <div class="social-icon">
                        <img src="<?php module_img('theme/social/linkedin-icon.png'); ?>" alt="share icon" />
                    </div>
                    <div class="share-block">
                        <div class="share-title"><?php the_field('share_category_linkedin_title', $acf_key); ?></div>
                        <div class="share-icon">
                            <img src="<?php module_img('theme/social/linkedin-follow-icon.png'); ?>" alt="follow icon" />
                        </div>
                    </div>
                </a>
            </div>
            <div class="subscribe-block-wrapper">
                <div class="col-sm-12 col-md-8">
                    <?php module_template('newsletter/block'); ?>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
<?php endif; ?>
