<?php

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('site-search-common', get_module_js('site-search/common.js'), ['jquery'], gk_get_rev(), true);
    wp_enqueue_script('cut-excerpt', get_module_js('site-search/cut-excerpt.js'), ['jquery'], gk_get_rev(), true);
});

add_filter('wp_footer', function () {
    wp_reset_query();
    nix_localize_script('site_search', array('ajax_url' => admin_url('admin-ajax.php')));
}, 5);

add_action('wp_print_styles', function () {
    wp_enqueue_style('site-search-common', get_module_css('site-search/front.css'), [], gk_get_rev());
});

add_action( 'admin_enqueue_scripts', function($hook) {
	// in JavaScript, object properties are accessed as ajax_object.ajax_url, ajax_object.we_value
});

add_action( 'wp_ajax_site-search-result', 'site_search_get_search_result' );
add_action( 'wp_ajax_nopriv_site-search-result', 'site_search_get_search_result' );
function site_search_get_search_result() {
    $q = new WP_Query(array(
        's' => $_POST['s'],
        'posts_per_page' => 5,
        'post_type' => 'post',
    ));

    $res = array();
    while ($q->have_posts()) {
        $q->the_post();
        $res[] = array(
            'id' => get_the_ID(),
            'title' => get_the_title(),
            'permalink' => get_the_permalink(),
        );
    }
    wp_send_json($res);
}

add_action( 'wp_ajax_site-search-popular', 'site_search_get_popular_result' );
add_action( 'wp_ajax_nopriv_site-search-popular', 'site_search_get_popular_result' );
function site_search_get_popular_result() {
    $popular_posts_instance = WordpressPopularPosts::get_instance();
    $reflection = new ReflectionMethod($popular_posts_instance, '_query_posts');
    $reflection->setAccessible(true);

    $popular_posts = $reflection->invoke($popular_posts_instance, array(
        'limit' => 5,
        'range' => 'all',
        'post_type' => 'post',
    ));

    $res = array();
    foreach($popular_posts as $post) {
        $res[] = array(
            'id' => $post->id,
            'title' => $post->title,
            'permalink' => get_the_permalink($post->id),
        );
    }
    wp_send_json($res);
}
