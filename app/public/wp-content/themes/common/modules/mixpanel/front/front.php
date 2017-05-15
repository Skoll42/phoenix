<?php

add_action('wp_head', function() {
    the_field('mixpanel_tracking_code', 'option');
});

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('mixpanel-common', get_module_js('mixpanel/common.js'), ['jquery'], gk_get_rev(), true);
});
