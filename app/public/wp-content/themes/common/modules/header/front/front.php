<?php

add_action('wp_print_styles', function () {
    wp_enqueue_style('header-common', get_module_css('header/front.css'), [], gk_get_rev());
});

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('prevent-menu-jump', get_module_js('header/prevent-jump.js'), ['jquery'], gk_get_rev(), true);
    wp_enqueue_script('header-scrolling-menu', get_module_js('header/scrolling-menu.js'), ['jquery', 'jquery-stickit'], gk_get_rev(), true);
});

function bt_header_get_section_logo($section) {
    $section_img_path = get_stylesheet_directory() . '/modules/header/assets/img/' . $section . '-section-logo.svg';
    if (!file_exists($section_img_path)) {
        $default_category = get_category(get_option('default_category'));
        return 'header/' . $default_category->slug . '-section-logo.svg';
    }
    return 'header/' . $section . '-section-logo.svg';
}

function bt_should_be_podcast_header() {
    return (is_single() && get_post_type() == 'podcast') || bt_is_podcast_archive();
}