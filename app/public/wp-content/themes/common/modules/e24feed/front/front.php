<?php
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('e24feed-cut', get_module_js('e24feed/e24cut.js'), ['jquery', 'jquery-dotdotdot'], gk_get_rev(), true);
});

add_action('wp_print_styles', function () {
    wp_enqueue_style('e24style', get_module_css('e24feed/front.css'), [], gk_get_rev());
});