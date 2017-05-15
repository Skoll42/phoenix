<?php

add_action('init', function() {
    add_rewrite_rule('^offshore/company/(.+)/page/?([0-9]{1,})/?$', 'index.php?__mentioned_company=1&mentioned_company=$matches[1]&paged=$matches[3]&category_name=offshore', 'top');
    add_rewrite_rule('^offshore/company/(.+)/?$', 'index.php?__mentioned_company=1&mentioned_company=$matches[1]&category_name=offshore', 'top');
    register_taxonomy('mentioned_companies', 'post',
        [
            'label' => 'Mentioned Companies',
            'query_var' => true,
            'rewrite' => ['slug' => 'offshore/company'],
            'labels' => ['separate_items_with_commas' => __('Separate companies with commas'),
                'choose_from_most_used' => __('Choose from the most mentioned companies'),
                'not_found' => __('No companies found.')],
        ]); 
});

add_action('wp_print_styles', function () {
    if (is_single()) {
        wp_enqueue_style('fishiri-article-front', get_module_css('fishiri/bt-article-felt-rigg.css'), [], gk_get_rev());
    }
});

add_filter( 'query_vars', function( $vars ) {
    $vars[] = '__mentioned_company';
    $vars[] = 'mentioned_company';
    return $vars;
});

add_filter('template_include', function($template) {
    if (get_query_var('__mentioned_company')) {
        return get_module_template_path('fishiri/mentioned-companies/archive');
    }
    return $template;
});

function get_mentioned_companies_articles() {
    return new WP_Query([
        'post_status' => 'publish',
        'orderby' => 'post_modified',
        'order'   => 'DESC',
        'post_type' => 'post',
        'posts_per_page' => 40,
        'tax_query' => [
            [
                'taxonomy' => 'mentioned_companies',
                'field'    => 'slug',
                'terms' => get_query_var('mentioned_company'),
            ]
        ]
    ]);
}