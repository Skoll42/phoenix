<?php

function bt_is_sponsored_archive() {
    return is_post_type_archive('sponsored') || is_tax('sponsored_company');
}

function bt_is_sponsored_archive_query($query) {
    return ( $query->is_post_type_archive('sponsored') || $query->is_tax('sponsored_company') ) && $query->is_main_query();
}

function bt_sponsored_should_display() {
    return is_category() || is_single() || is_post_type_archive('pressrelease') || bt_is_podcast_archive();
}

add_action('wp_print_styles', function () {
    if (bt_sponsored_should_display()) {
        wp_enqueue_style('sponsored-common', get_module_css('sponsored/front.css'), [], gk_get_rev());
    }
});

add_action('wp_enqueue_scripts', function () {
    if (bt_sponsored_should_display()) {
        wp_enqueue_script('sponsored-common', get_module_js('sponsored/common.js'), ['jquery-cookie', 'theme-common'], gk_get_rev(), true);
    }
});

add_action('wp_head', function() {
    if (bt_sponsored_should_display()) {
        $args = [
            'posts_per_page' => 100, // isn't necessarily but more predictable
            'post_status' => 'publish',
            'fields' => 'ids',
            'post_type' => 'sponsored',
            'orderby' => 'id',
            'order'   => 'DESC',
        ];

        $query = new WP_Query(array_merge($args, [
            'tax_query' => array(
                array(
                    'taxonomy' => 'sponsored_company',
                    'field'    => 'slug',
                    'terms'    => 'annonse',
                ),
            ),
        ]));
        $e24_ids = $query->posts;

        $query = new WP_Query(array_merge($args, [
            'tax_query' => array(
                array(
                    'taxonomy' => 'sponsored_company',
                    'field'    => 'slug',
                    'terms'    => 'annonse',
                    'operator' => 'NOT IN',
                ),
            ),
        ]));
        $internal_ids = $query->posts;

        $sponsored_data = array(
            'e24Ids' => $e24_ids,
            'internalIds' => $internal_ids,
            'pageType' => (is_category() || is_post_type_archive('pressrelease') || bt_is_podcast_archive()) ? 'front' : 'article',
            'currentCategory' => get_current_frontpage(),
        );

        nix_localize_script('sponsoredData', $sponsored_data);
    }
}, 5);

add_action('init', function() {
    add_rewrite_rule('^bt_e24/article/([0-9]+)/?', 'index.php?__bt_e24=1&post_id=$matches[1]', 'top');
});

add_filter('query_vars', function($query_vars) {
    $query_vars[] = '__bt_e24';
    $query_vars[] = 'post_id';
    return $query_vars;
});

add_filter('template_include', function($template) {
    if (get_query_var('__bt_e24')) {
        return get_module_template_path('sponsored/block');
    }
    return $template;
});
