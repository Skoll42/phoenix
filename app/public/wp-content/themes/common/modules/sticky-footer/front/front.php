<?php

add_action('wp_enqueue_scripts', function () {
    if (is_single()) {
        wp_enqueue_script('sticky-footer-common', get_module_js('sticky-footer/common.js'), ['paywall-common'], gk_get_rev(), true);
    }
});

add_action('wp_print_styles', function () {
    if (is_single()) {
        wp_enqueue_style('sticky-footer-common', get_module_css('sticky-footer/front.css'), [], gk_get_rev());
        wp_enqueue_style('sticky-footer-userdata', get_module_css('sticky-footer/bt-userdata.css'), [], gk_get_rev());
    }
});
