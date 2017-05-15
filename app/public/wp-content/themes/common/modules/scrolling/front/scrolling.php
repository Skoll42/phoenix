<?php

function in_iframe() {
    return isset($_GET['iniframe']) && $_GET['iniframe'] == 1;
}

add_action('wp_enqueue_scripts', function () {
    if (in_iframe()) {
        wp_enqueue_script('scrolling-inside-iframe', get_module_js('scrolling/iframeResizer.contentWindow.js'), [], gk_get_rev(), true);
    }

    if (is_single()) {
        $is_sponsored = get_post_type() === 'sponsored';
        wp_enqueue_script('scrolling-inside-iframe-main', get_module_js('scrolling/iframeResizer.js'), [], gk_get_rev(), true);
        if (!in_iframe() && spid_is_content_accessable() && !$is_sponsored && !spid_cookies_disabled()) {
            wp_enqueue_script('scrolling-article', get_module_js('scrolling/article.js'), ['jquery', 'scrolling-inside-iframe-main'], gk_get_rev(), true);
        }
    }
});

add_action('wp_head', function() {
    $in_iframe = in_iframe() ? 'true' : 'false';
    nix_localize_script('inIframe', $in_iframe);
    nix_localize_script('nextPosts', $in_iframe);
    if (is_single() && (spid_is_content_accessable() && !spid_cookies_disabled() && get_post_type() !== 'sponsored')) {
        // Not the best solution to check which front/category to display. The same with menu item icons.
        if (get_post_type() == 'podcast') {
            $permlink = home_url('/podcasts/');
        } else {
            $permlink = get_category_link(bt_archive_get_current_category());
        }

        $next_posts[] = array(
            'page_title' => get_bloginfo('description') . ' - ' . get_bloginfo(),
            'permlink' => $permlink,
        );
        nix_localize_script('nextPosts', $next_posts);
    }
}, 5);