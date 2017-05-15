<?php

function bt_is_podcast_archive() {
    return is_post_type_archive('podcast') || is_tax('podcast_category');
}

function bt_is_podcast_archive_query($query) {
    return ( $query->is_post_type_archive('podcast') || $query->is_tax('podcast_category') ) && $query->is_main_query();
}

add_action('wp_print_styles', function () {
    if (bt_is_podcast_archive() || get_post_type() == 'podcast') {
        wp_enqueue_style('podcast-common', get_module_css('podcast/front.css'),[], gk_get_rev());
    }
});

add_action('wp_enqueue_scripts', function () {
    if (bt_is_podcast_archive() || get_post_type() == 'podcast') {
        wp_enqueue_script('podcast-common', get_module_js('podcast/common.js'), ['jquery'], gk_get_rev(), true);
    }
});

add_action('pre_get_posts', function($query) {
    if (!is_admin() && bt_is_podcast_archive_query($query)) {
        $category = $query->get_queried_object();

        $query->set('post_type', 'podcast');
        $query->set('post_status', 'publish');

        $first_count = 21;
        $paged = get_query_var('paged', 1);
        if ($paged <= 1) {
            $query->set('posts_per_page', $first_count);
        } else {
            $query->set('offset', $first_count + get_option('posts_per_page') * ($paged - 2));
        }

        if (!empty($category->term_id)) {
            $query->set('tax_query', [
                [
                    'taxonomy' => 'podcast_category',
                    'field' => 'term_id',
                    'terms' => array($category->term_id),
                    'include_children' => false,
                ],
            ]);
        }
    }
});
