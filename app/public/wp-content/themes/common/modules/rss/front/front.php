<?php

add_action('wp_print_styles', function () {
    wp_enqueue_style('rss-common', get_module_css('rss/front.css'), [], gk_get_rev());
});

function rss_get_source_domain_url($postID = null) {
    $url = rss_get_source_url($postID);

    $comp = parse_url($url);
    return sprintf('%s://%s', $comp['scheme'], $comp['host']);
}

function rss_get_source_url($postID = null) {
    if ($postID == null) {
        global $post;
        $postID = $post->ID;
    }

    return get_post_meta( $postID, 'wprss_url', true );
}

function rss_get_item_url($postID = null) {
    if ($postID == null) {
        global $post;
        $postID = $post->ID;
    }

    return get_post_meta( $postID, 'wprss_item_permalink', true );
}