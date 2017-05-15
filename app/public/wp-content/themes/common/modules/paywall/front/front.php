<?php

add_action('wp_head', function() {
    if (is_single()) {
        nix_localize_script('postAccessLevel', get_field('access_level'));
        nix_localize_script('paywallSettings', ['service_url' => get_field('spid_service_url', 'option')]);
    }
}, 5);

add_action('wp_enqueue_scripts', function () {
    if (is_single()) {
        wp_enqueue_script('paywall-common', get_module_js('paywall/common.js'), ['jquery-cookie'], gk_get_rev(), true);
    }
});