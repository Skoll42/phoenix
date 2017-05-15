<?php

// TODO: add custom category filter on Sponsored Posts List


add_action( 'admin_init', function() {
//    remove_role( 'sponsored' ); // TODO: remove it when module is finished
    add_role( 'sponsored', 'Sponsored', array(
        'read'         => true,
        'upload_files' => true,
//        'edit_posts'   => true,
        'delete_posts'   => true,

        'sponsored_admin'         => true,
        'sponsored_company_admin' => true,
    ) );

    $editor = get_role('editor');
    $editor->add_cap('sponsored_company_admin');
    $editor->add_cap('sponsored_admin');

    $admin = get_role('administrator');
    $admin->add_cap('sponsored_company_admin');
    $admin->add_cap('sponsored_admin');
});

add_action('pre_get_posts', function( $wp_query_obj ) {
    global $current_user, $pagenow;

    if( !is_a( $current_user, 'WP_User') )
        return;

    if( !in_array( $pagenow, array( 'upload.php', 'admin-ajax.php' ) ) )
        return;

    if( !current_user_can('delete_pages') )
        $wp_query_obj->set('author', $current_user->ID );

    return;
});
