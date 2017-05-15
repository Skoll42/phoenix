<?php

add_action('wp_print_styles', function () {    
    wp_enqueue_style('bootstrap', get_module_css('theme/bootstrap.css'), [], null);
    wp_enqueue_style('styles-theme', get_module_css('theme/front.css'), [], gk_get_rev());

    if (is_archive()) {
        wp_enqueue_style('styles-category', get_module_css('theme/bt-archive.css'), [], gk_get_rev());
    }

    if (is_singular()) {
        wp_enqueue_style('styles-single', get_module_css('theme/bt-single.css'), [], gk_get_rev());
    }

    if (is_search()) {
        wp_enqueue_style('styles-search', get_module_css('theme/bt-search.css'), [], gk_get_rev());
    }

    if (is_404()) {
        wp_enqueue_style('styles-404', get_module_css('theme/bt-404.css'), [], gk_get_rev());
    }
});

// Prevent footable initializing on all pages by default
add_action('init', function () {
    if(isset($GLOBALS['FooTable'])) {
        remove_action('wp_print_footer_scripts', array($GLOBALS['FooTable'], 'inline_dynamic_js'));
        remove_action('wp_print_styles', array($GLOBALS['FooTable'], 'inline_dynamic_css'));
    }
});

add_action('wp_enqueue_scripts', function () {
    wp_deregister_script('jquery');
    wp_register_script('jquery', '/wp-includes/js/jquery/jquery.js', array(), '1.12.4', true);
    wp_enqueue_script('jquery');
    wp_register_script('jquery-cookie', get_module_js('theme/libs/jquery.cookie.js'), ['jquery'], '1.4.1', true);
    wp_enqueue_script('bootstrap', get_module_js('theme/libs/bootstrap.js'), ['jquery'], null, true);
    wp_enqueue_script('jquery-dotdotdot', get_module_js('theme/libs/jquery.dotdotdot.js'), ['jquery'], '1.6.10', true);
    wp_enqueue_script('jquery-stickit', get_module_js('theme/libs/jquery.stickit.js'), ['jquery'], '0.1.12', true);
    wp_enqueue_script('theme-common', get_module_js('theme/common.js'), ['jquery'], gk_get_rev(), true);
    wp_enqueue_script('sticky-elements', get_module_js('theme/sticky-elements.js'), ['jquery', 'jquery-stickit'], gk_get_rev(), true);
    wp_enqueue_script('cut-excerpt', get_module_js('theme/cut-excerpt.js'), ['jquery'], gk_get_rev(), true);
    wp_enqueue_script('podcast-navigation', get_module_js('theme/podcast-navigation.js'), ['jquery'], gk_get_rev(), true);
    wp_enqueue_script('unispring', get_module_js('theme/unispring.js'), [], gk_get_rev(), true);
    wp_enqueue_script('unispring-tns', get_module_js('theme/unispring-tns.js'), ['unispring'], gk_get_rev(), true);

    if (((is_single() && get_post_type() !== 'sponsored')) || is_dockedships()) {
        wp_enqueue_script('sticky-adv-ratio', get_module_js('theme/sticky-adv-ratio.js'), ['jquery', 'jquery-stickit'], gk_get_rev(), true);
        wp_enqueue_script('sponsor-content', get_module_js('theme/sponsor-content.js'), ['jquery'], gk_get_rev(), true);
    }

    if (is_singular()) {
        wp_enqueue_script('jquery-fitvids', get_module_js('theme/libs/jquery.fitvids.js'), ['jquery'], '1.1', true);
        wp_enqueue_script('video-wrapper', get_module_js('theme/video-wrapper.js'), ['jquery', 'jquery-fitvids'], gk_get_rev(), true);
    }
});

add_action( 'after_setup_theme', function () {
    register_nav_menu('header', 'Header Menu');
});

add_filter('wp_head', function() {
    nix_localize_script('ajaxurl', admin_url('admin-ajax.php'));
    $color = bt_archive_get_category_color();

    echo <<<EOF
<style>
    .category-color { color: {$color} !important; }
    .category-background { background-color: {$color} !important; }
    .category-border { border-color: {$color} !important; }
    .category-border-top { border-top-color: {$color} !important; }
    .category-border-bottom { border-bottom-color: {$color} !important; }
    .category-svg-fill { fill: {$color} !important; }
</style>

EOF;
});

// add SVG to allowed file uploads
add_filter('upload_mimes', function ($mime_types) {
    $mime_types['svg'] = 'image/svg+xml';
    return $mime_types;
}, 1, 1);

add_filter('wp_footer', function() {
    echo <<<EOF
<noscript><img src="http://offshore.tns-cs.net/j0=,,,;+,cp=offshore/sysla.no+url=http://www.sysla.no/noscript;;;"></noscript>
EOF;
}, 100);