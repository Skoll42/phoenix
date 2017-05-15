<?php

add_action('init', function() {
    register_post_type( 'snappet',
        array(
            'labels' => array(
                'name' => __( 'Snappet' ),
                'singular_name' => __( 'Snappet' )
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array(
                'title',
                'editor',
            ),
        )
    );
});