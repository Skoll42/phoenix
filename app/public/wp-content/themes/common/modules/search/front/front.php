<?php

add_action('wp_ajax_header_search', 'header_search');
add_action('wp_ajax_nopriv_header_search', 'header_search');

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('header-search', get_module_js('search/header-search.js'), ['jquery'], gk_get_rev(), true);
});

add_filter('ep_formatted_args_query', function($query) {
    // Fix to search only on phrase match
    unset($query['bool']['should'][2]);
    return $query;
}, 10, 1);

add_filter('register_post_type_args', function($args, $post_type) {
    if (!is_admin() && $post_type == 'page') {
        $args['exclude_from_search'] = true;
    }
    return $args;
}, 10, 2);

add_action('pre_get_posts', function($query) {
    if(!is_admin() && is_search() && $query->is_main_query()) {
        $category_slugs = !empty($_GET['site']) ? $_GET['site'] : [];
        $paged = get_query_var('paged', 1);

        // Fix for search to work properly with multiple categories. See: 'request' hook in theme/front/permalinks.php
        unset($query->query['category_name']);
        unset($query->query_vars['category_name']);
        unset($query->query_vars['cat']);

        $first_count = 6;
        if ($paged <= 1) {
            $query->set('posts_per_page', $first_count);
        } else {
            $query->set('offset', $first_count + get_option('posts_per_page') * ($paged - 2));
        }
        $query->set('post_type', ['post', 'podcast']);
        $query->set('ep_integrate', true);
        $query->set('post_status', 'publish');
        $query->set('search_fields', [
            'post_title',
            'post_content',
            'post_excerpt',
            'taxonomies' => ['category', 'post_tag'],
        ]);

        $query->set('orderby', 'post_modified');
        $query->set('order', 'DESC');
        if(!empty($category_slugs)) {
            $query->set('tax_query', [
                [
                    'taxonomy' => 'category',
                    'terms'    => $category_slugs,
                    'field'    => 'slug'
                ]
            ]);
        }
    }
    return $query;
});

function get_most_used_tags() {
    global $wpdb;
    $term_ids = $wpdb->get_col(
        "SELECT DISTINCT term_taxonomy_id FROM $wpdb->term_relationships
        INNER JOIN $wpdb->posts ON $wpdb->posts.ID = object_id
        WHERE DATE_SUB(CURDATE(), INTERVAL 7 DAY) <= $wpdb->posts.post_modified"
    );
    $uncategorized = get_term_by('slug', 'uncategorized', 'post_tag');
    $term_ids = array_diff($term_ids, [$uncategorized->term_id]);
    return get_tags([
        'orderby' => 'count',
        'order'   => 'DESC',
        'number'  => 12,
        'include' => $term_ids,
    ]);
}

function header_search() {
    $query = !empty($_GET['query']) ? $_GET['query'] : '';
    $articlesAmount = !empty($_GET['amount']) ? $_GET['amount'] : 50;
    $search_query = new WP_Query(
        [
            's' => $query,
            'ep_integrate'   => true,
            'post_status' => 'publish',
            'orderby' => 'post_modified',
            'order'   => 'DESC',
            'post_type'      => ['post', 'podcast'],
            'posts_per_page' => min(50, $articlesAmount),
            'search_fields' => [
                'post_title',
                'post_content',
                'post_excerpt',
                'taxonomies' => ['category', 'post_tag'],
            ]
        ]
    );
    $results = [];
    if ($search_query->have_posts()) {
        while ($search_query->have_posts()) {
            $search_query->the_post();
            $id = get_the_ID();
            $results[$id] = get_article_response_data($id);
        }
    }
    wp_send_json_success(['articles' => $results, 'total' => $search_query->found_posts, 'query' => $query]);
}

function get_article_response_data($id) {
    if (in_array(get_post_type($id), ['podcast'])) {
        $current_category = 'podcasts';
    } else if (in_array(get_post_type($id), ['pressrelease'])) {
        $current_category = null;
    } else {
        $categories = get_the_category($id);
        $current_category = (isset($categories[0])) ? $categories[0]->slug : null;
    }

    return [
        'title' => esc_html(mb_substr(get_the_title(), 0, 45, "utf-8") . "..."),
        'publish_date' => get_the_date('d. M Y'),
        'link' => get_the_permalink(),
        'svg_category' => get_module_img(bt_header_get_section_logo($current_category)),
    ];
}
