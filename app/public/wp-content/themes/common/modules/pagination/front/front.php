<?php

add_action('wp_print_styles', function() {
    if (bt_pagination_should_display()) {
        wp_enqueue_style('pagination', get_module_css('pagination/front.css'), [], gk_get_rev());
    }
});

add_action('wp_enqueue_scripts', function() {
    if (bt_pagination_should_display()) {
        wp_enqueue_script('pagination', get_module_js('pagination/load-more.js'), ['jquery', 'theme-common'], true);
    }
});

function bt_pagination_should_display() {
    return is_category() || is_search() || is_author() || is_tag()
        || is_post_type_archive('pressrelease') || bt_is_podcast_archive() || is_post_type_archive('snappet')
        || bt_is_sponsored_archive();
}

add_filter('previous_posts_link_attributes', function() {
    return 'class="prev"';
});

add_filter('next_posts_link_attributes', function() {
    return 'class="next"';
});
