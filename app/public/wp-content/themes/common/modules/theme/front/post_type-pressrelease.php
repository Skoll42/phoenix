<?php

add_action('init', function() {
    register_post_type( 'pressrelease',
        array(
            'labels' => array(
                'name' => __( 'Pressrelease' ),
                'singular_name' => __( 'Pressrelease' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array( 'slug' => 'pressemelding', 'with_front' => false ),
            'supports' => array(
                'title',
                'editor',
                'thumbnail',
                'excerpt',
            ),
        )
    );
});
