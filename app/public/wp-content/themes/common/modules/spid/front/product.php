<?php

function is_product_page() {
    return strpos($_SERVER['REQUEST_URI'], '/produkter') !== false;
}

function get_product_page_url() {
    return home_url('/produkter/');
}

function get_product_page_company_url() {
    return home_url('/produkter/?type=firma');
}

add_filter('body_class', function($classes, $class) {
    if (is_product_page()) {
        $classes[] = 'produkter';
    }
    return $classes;
}, 10, 2);


add_action('init', function() {
    add_rewrite_rule('^produkter/?', 'index.php?__produkter_page=1', 'top');
});

add_filter( 'query_vars', function( $vars ) {
    $vars[] = '__produkter_page';
    return $vars;
});

add_filter( 'template_include', function($template) {
    if (get_query_var('__produkter_page')) {
        return get_module_template_path('spid/produkter');
    }
    return $template;
});


add_action('wp_print_styles', function () {
    if (is_product_page()) {
        wp_enqueue_style('product-common', get_module_css('spid/bt-product-page.css'), [], gk_get_rev());
    }
});
