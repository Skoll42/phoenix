<?php

function is_stillinger() {
    return strpos($_SERVER['REQUEST_URI'], '/stillinger') !== false;
}

function is_stillinger_detailed() {
    return is_stillinger() && isset($_GET['id']);
}

function bt_rewrite_basic() {
    add_rewrite_rule('^maritim/stillinger/?$', 'index.php?__stillinger=1&site=maritim&category_name=jobb', 'top');
    add_rewrite_rule('^gronn/stillinger/?$', 'index.php?__stillinger=1&site=gronn&category_name=jobb', 'top');
    add_rewrite_rule('^offshore/stillinger/?$', 'index.php?__stillinger=1&site=offshore&category_name=jobb', 'top');
    add_rewrite_rule('^stillinger/?$', 'index.php?__stillinger=1&site=sysla&category_name=jobb', 'top');
    add_rewrite_rule('^jobb/page/?([0-9]{1,})/?$', 'index.php?category_name=jobb&paged=$matches[1]', 'top');
    add_rewrite_rule('^jobb/?$', 'index.php?category_name=jobb', 'top');
}
add_action('init', 'bt_rewrite_basic');

add_action('wp_print_styles', function () {
    wp_enqueue_style('jobb-front', get_module_css('jobb/front.css'), [], gk_get_rev());
});

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('jobb-sdk', get_module_js('jobb/jobb-sdk.js'), ['jquery'], gk_get_rev(), true);
    wp_enqueue_script('jobb-sdk-init', get_module_js('jobb/jobb-sdk-init.js'), ['jquery', 'jobb-sdk'], gk_get_rev(), false);
});

add_filter( 'query_vars', function( $vars ) {
    $vars[] = '__stillinger';
    $vars[] = 'site';
    return $vars;
});

add_filter('template_include', function($template) {
    if (get_query_var('__stillinger')) {
        $stillinger_template = 'jobb/';
        if(is_stillinger_detailed()) {
            $stillinger_template .= 'detailed';
        } else {
            $stillinger_template .= 'filter';
        }
        return get_module_template_path($stillinger_template);
    }
    return $template;
});

add_filter('wp_head', function () {
    wp_reset_query();
    $site_query = get_query_var('site');
    $site = $site_query ? $site_query : bt_archive_get_current_category()->slug;
    $site_name = get_bloginfo();
    $stillinger_url = home_url('/' . (is_stillinger() ? $site : bt_archive_get_current_category()->slug) . '/stillinger');
    $filter = json_encode(isset($_GET['filter']) ? $_GET['filter'] : array());
    $id = is_stillinger_detailed() ? intval($_GET['id']) : '0';

    nix_localize_script('jobbConfig', array(
            'site' => $site,
            'stillinger_url' => $stillinger_url,
            'filter' => $filter,
            'id' => $id,
            'site_name' => $site_name
        )
    );
}, 5);