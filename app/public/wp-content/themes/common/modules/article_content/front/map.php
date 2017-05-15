<?php

function bt_article_content_get_map($post_id = false) {
    return get_field('article_content_map', $post_id);
}

add_action('wp_enqueue_scripts', function() {
    if (is_single() && bt_article_content_is_element('map')) {
        wp_enqueue_script('article-content-map', get_module_js('article_content/googlemap.js'), ['jquery'], gk_get_rev(), true);
    }
});

add_filter('wp_head', function() {
    wp_reset_query();
    
    if (is_single() && bt_article_content_is_element('map')) {
        $api_key = 'AIzaSyBVK-TzcR_v2q-rIqGHSzCSVW7Epk-jxSo';
        nix_localize_script('googlemap', array(
            'api_key' => $api_key,
            'marker_color' => (get_post_type() !== 'sponsored') ? bt_archive_get_category_color() : '#b41c0a',
            'marker_icon' => get_module_img('article_content/ie/gm-marker-icon.png'),
        ));
    }
}, 20);

add_shortcode('map', function($atts) {
    $map_arr = bt_article_content_get_map();
    if(!empty($map_arr['address'])) {
        $lat = $map_arr['lat'];
        $lng = $map_arr['lng'];
    }
    return get_module_template('article_content/map', ['lat' => $lat, 'lng' => $lng]);
});
