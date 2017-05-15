<?php

add_filter('request', function($query_vars) {
    if (isset($query_vars['category_name'])) { // Handle "/%postname" and "/%category_name"
        $category = get_category_by_slug($query_vars['category_name']);
        if (is_wp_error($category) || !$category) {
            $query_vars['name'] = $query_vars['category_name'];
            unset($query_vars['category_name']);
        }
    }

    if ('/' === parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
        || strpos($_SERVER['REQUEST_URI'], '/page/') === 0)
    {
        $category = get_category(get_option('default_category'));
        if (!is_wp_error($category) || $category) {
            $query_vars['category_name'] = $category->slug;
        }
    }

    return $query_vars;
});

add_filter('category_link', function($categorylink, $category_id) {
    $default_category_id = get_option('default_category');
    if ($default_category_id == $category_id) {
        $default_category = get_category($default_category_id);
        if (!is_wp_error($default_category) || $default_category) {
            $categorylink = preg_replace('#\/' . preg_quote($default_category->slug, '/') . '\/#', '/', $categorylink, 1);
        }
    }
    return $categorylink;
}, 10, 2);

add_filter('post_link', function($permalink, $post, $leavename) {
    $default_category = get_category(get_option('default_category'));
    if (!is_wp_error($default_category) || $default_category) {
        $permalink = preg_replace('#\/' . preg_quote($default_category->slug, '/') . '\/#', '/', $permalink, 1);
    }
    return $permalink;
}, 10, 3);
