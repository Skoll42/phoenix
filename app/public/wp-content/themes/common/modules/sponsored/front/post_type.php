<?php

add_action('init', function() {

    register_post_type( 'sponsored',
        array(
            'labels' => array(
                'name' => __( 'Sponsored Posts' ),
                'singular_name' => __( 'Sponsored Post' ),
                'add_new' => _x('Add New', 'sponsored'),
                'add_new_item' => __("Add New Sponsored Post"),
                'edit_item' => __("Edit Sponsored Post"),
                'new_item' => __("New Sponsored Post"),
                'view_item' => __("View Sponsored Post"),
                'search_items' => __("Search Sponsored Posts"),
                'not_found' =>  __('No sponsored posts found'),
                'not_found_in_trash' => __('No sponsored posts found in Trash'),
                'parent_item_colon' => ''
            ),
            'public' => true,
            'has_archive' => false,
            'rewrite' => array( 'slug' => 'annonseartikkel/%sponsored_company%', 'with_front' => false ),
            'supports' => array(
                'title',
                'editor',
                'thumbnail',
                'excerpt',
                'revisions',
            ),
            'show_ui' => true,
            'publicly_queryable' => true,
            'query_var' => true,
            'capabilities' => array(
                'edit_post'		 => 'sponsored_admin',
                'read_post'		 => 'sponsored_admin',
                'delete_post'		 => 'sponsored_admin',

                'edit_posts'		 => 'sponsored_admin',
                'edit_others_posts'	 => 'sponsored_admin',
                'publish_posts'		 => 'sponsored_admin',

                'read'                   => 'sponsored_admin',
                'delete_posts'           => 'sponsored_admin',
                'delete_private_posts'   => 'sponsored_admin',
                'delete_published_posts' => 'sponsored_admin',
                'delete_others_posts'    => 'sponsored_admin',
                'edit_private_posts'     => 'sponsored_admin',
                'edit_published_posts'   => 'sponsored_admin',
                'create_posts'           => 'sponsored_admin',
            ),
            'taxonomies' => array( 'sponsored_company' ),
        )
    );

    register_taxonomy(
		'sponsored_company',
		'sponsored',
		array(
			'label' => __( 'Companies' ),
            'labels' => array(
                'name'                           => 'Companies',
                'singular_name'                  => 'Company',
                'search_items'                   => 'Search Companies',
                'all_items'                      => 'All Companies',
                'edit_item'                      => 'Edit Company',
                'update_item'                    => 'Update Company',
                'add_new_item'                   => 'Add New Company',
                'new_item_name'                  => 'New Company Name',
                'menu_name'                      => 'Company',
                'view_item'                      => 'View Company',
                'popular_items'                  => 'Popular Company',
                'separate_items_with_commas'     => 'Separate Companies with commas',
                'add_or_remove_items'            => 'Add or remove Companies',
                'choose_from_most_used'          => 'Choose from the most used Companies',
                'not_found'                      => 'No Companies found'
            ),
			'rewrite' => array( 'slug' => 'sponsored_company' ),
            'hierarchical' => true,
            'show_admin_column' => true,
            'capabilities' => array (
                'manage_terms' => 'sponsored_company_admin',
                'edit_terms' => 'sponsored_company_admin',
                'delete_terms' => 'sponsored_company_admin',
                'assign_terms' => 'sponsored_company_admin',
            ),
		)
	);
});

add_filter('post_type_link', function($post_link, $id = 0) {
    $post = get_post($id);
    if (is_object($post) && $post->post_type == 'sponsored') {
        $terms = wp_get_object_terms($post->ID, 'sponsored_company');
        if ($terms) {
            return str_replace('%sponsored_company%', $terms[0]->slug, $post_link);
        }
    }
    return $post_link;
}, 1, 2);
