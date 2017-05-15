<?php

function is_names() {
    return strpos($_SERVER['REQUEST_URI'], '/names') !== false;
}

function bt_names_set_page_title($title) {
    if (is_names()) {
        $title = 'Names';
    }
    return $title;
}

add_action('init', function() {
    add_rewrite_rule('^offshore/names/?$', 'index.php?__names_page=1&category_name=offshore', 'top');
});

add_filter( 'query_vars', function( $vars ) {
    $vars[] = '__names_page';
    return $vars;
});

add_filter( 'template_include', function($template) {
    if (get_query_var('__names_page')) {
        return get_module_template_path('names/names');
    }
    return $template;
});

add_filter( 'wpseo_title', 'bt_names_set_page_title');
add_filter( 'wp_title', 'bt_names_set_page_title');

add_action('wp_print_styles', function () {
    if (is_names()) {
        wp_enqueue_style('names-front', get_module_css('names/front.css'), [], gk_get_rev());
    }
});

add_action('wp_enqueue_scripts', function () {
    if (is_names()) {
        wp_enqueue_script('names-preview', get_module_js('names/image-preview.js'), ['jquery'], gk_get_rev(), true);
        wp_enqueue_script('names-appointment', get_module_js('names/new-appointment.js'), ['jquery', 'jquery-cookie'], gk_get_rev(), true);
    }
});
