<?php

add_action('wp_enqueue_scripts', function () {
    if (is_profile_page() || is_product_page()) {
        wp_enqueue_script('intercom-chat', get_module_js('intercom/chat.js'), ['jquery'], gk_get_rev(), true);
    }
});
