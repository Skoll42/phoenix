<?php if ( spid_is_content_accessable() ) : ?>
    <?php
    $raw_title = get_the_title();
    $raw_link = get_the_permalink();
    $esc_title = urlencode($raw_title);
    $esc_link = esc_url($raw_link);
    ?>
    <div class="social-share<?php echo ' ' . bt_archive_get_current_category()->slug; ?>">
        <div class="title">Del på</div>
        <div class="buttons">
            <a href="http://www.facebook.com/share.php?u=<?php echo $esc_link; ?>&amp;title=<?php echo $esc_title; ?>" class="category-background facebook" target="_blank">
                <?php insert_svg('article_content/facebook.svg'); ?>
            </a>
            <a href="http://twitter.com/home/?status=<?php echo $esc_title; ?> - <?php echo $esc_link; ?>" class="category-background twitter" target="_blank">
                <?php insert_svg('article_content/twitter.svg'); ?>
            </a>
            <a href="http://www.linkedin.com/shareArticle?mini=true&amp;title=<?php echo $esc_title; ?>&amp;url=<?php echo $esc_link; ?>" class="category-background linkedin" target="_blank">
                <?php insert_svg('article_content/linkedin.svg'); ?>
            </a>
            <a href="mailto:?subject=<?php echo $raw_title; ?>&body=<?php echo $raw_link; ?>" class="category-background email">
                <?php insert_svg('article_content/email.svg'); ?>
            </a>
        </div>
    </div>
<?php endif ?>