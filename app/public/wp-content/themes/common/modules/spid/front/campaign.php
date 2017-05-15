<?php

function is_campaign_page() {
    return strpos($_SERVER['REQUEST_URI'], '/kampanje') !== false;
}

function get_campaign_page_url() {
    return home_url('/kampanje/');
}

add_filter('body_class', function($classes, $class) {
    if (is_campaign_page()) {
        $classes[] = 'campaign';
    }
    return $classes;
}, 10, 2);


add_action('init', function() {
    add_rewrite_rule('^kampanje/?', 'index.php?__kampanje_page=1', 'top');
});

add_filter( 'query_vars', function( $vars ) {
    $vars[] = '__kampanje_page';
    return $vars;
});

add_filter( 'template_include', function($template) {
    if (get_query_var('__kampanje_page')) {
        return get_module_template_path('spid/kampanje');
    }
    return $template;
});