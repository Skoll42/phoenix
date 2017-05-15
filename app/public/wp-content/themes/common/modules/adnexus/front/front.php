<?php

add_action('wp_print_styles', function () {
    wp_enqueue_style('ad-nexus', get_module_css('adnexus/front.css'), [], gk_get_rev());
});

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('ad-nexus-init', get_module_js('adnexus/init.js'), ['jquery'], gk_get_rev(), true);
    wp_enqueue_script('ad-nexus-manager', get_module_js('adnexus/manager.js'), ['jquery'], gk_get_rev(), true);
    wp_enqueue_script('ad-nexus-codes', get_module_js('adnexus/common.js'), ['jquery', 'ad-nexus-init', 'ad-nexus-manager'], gk_get_rev(), true);
});

add_filter('wp_footer', function () {
    wp_reset_query();
    nix_localize_script('adPage', array('pageName' => is_single() ? 'article' : 'front'));
    nix_localize_script('adCategory', array('categoryName' => get_current_frontpage()));
}, 5);