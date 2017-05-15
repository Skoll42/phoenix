<?php

add_action('init', function() {
    register_post_type( 'podcast',
        array(
            'labels' => array(
                'name' => __('Podcast Episodes'),
                'singular_name' => __('Podcast Episode'),
                'add_new' => _x('Add New', 'podcast'),
                'add_new_item' => __("Add New Podcast Episode"),
                'edit_item' => __("Edit Podcast Episode"),
                'new_item' => __("New Podcast Episode"),
                'view_item' => __("View Podcast Episode"),
                'search_items' => __("Search Podcast Episodes"),
                'not_found' =>  __('No podcast episodes found'),
                'not_found_in_trash' => __('No podcast episodes found in Trash'),
                'parent_item_colon' => ''
            ),
            'public' => true,
            'has_archive' => 'podcasts',
            'rewrite' => array( 'slug' => 'podcasts/%podcast_category%', 'with_front' => false ),
            'supports' => array(
                'title',
                'editor',
                'thumbnail',
                'excerpt',
                'revisions',
            ),
            'taxonomies' => array( 'podcast_category' ),
        )
    );

    register_taxonomy(
        'podcast_category',
        'podcast',
        array(
            'label' => __( 'Podcast Categories' ),
            'labels' => array(
                'name'                           => 'Podcast Categories',
                'singular_name'                  => 'Podcast Category',
                'search_items'                   => 'Search Podcast Categories',
                'all_items'                      => 'All Podcast Categories',
                'edit_item'                      => 'Edit Podcast Category',
                'update_item'                    => 'Update Podcast Category',
                'add_new_item'                   => 'Add New Podcast Category',
                'new_item_name'                  => 'New Podcast Category Name',
                'menu_name'                      => 'Podcast Category',
                'view_item'                      => 'View Podcast Category',
                'popular_items'                  => 'Popular Podcast Category',
                'separate_items_with_commas'     => 'Separate Categories with commas',
                'add_or_remove_items'            => 'Add or remove Podcast Categories',
                'choose_from_most_used'          => 'Choose from the most used Podcast Categories',
                'not_found'                      => 'No Categories found'
            ),
            'rewrite' => array( 'slug' => 'podcasts', 'with_front' => false ),
            'hierarchical' => true,
            'show_admin_column' => true,
        )
    );
});

add_filter('post_type_link', function($post_link, $id = 0) {
    $post = get_post($id);
    if (is_object($post) && $post->post_type == 'podcast') {
        $terms = wp_get_object_terms($post->ID, 'podcast_category');
        if ($terms) {
            return str_replace('%podcast_category%', $terms[0]->slug, $post_link);
        }
    }
    return $post_link;
}, 1, 2);

