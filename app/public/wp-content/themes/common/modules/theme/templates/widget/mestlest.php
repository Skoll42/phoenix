<div class="<?php echo $__data['class']; ?> gk-block wpp most-popular-widget section-common">
    <?php
        wpp_get_mostpopular( array(
            'header' => 'Mest lest',
            'header_start'=> '<h3 class="category-background">',
            'header_end'=> '</h3><div class="down-arrow category-border-top"></div>',
            'wpp_start' => '<ol>',
            'wpp_end' => '</ol>',
            'pid' => $current_post_ID,
            'post_type' => 'post',
            'excerpt_length' => 99999,
            'limit' => 10,
            'post_html' => "<li><a href='{url}' title='{text_title}' " . (in_iframe() ? "target='_parent'" : "") . "><div class='title'>{text_title}</div></a></li>",
        ) );
    ?>
</div>