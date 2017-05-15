<?php
add_filter( 'wp_terms_checklist_args', 'checklist_args', 10, 1);

function checklist_args( $args ) {
    $args['checked_ontop'] = false;
    return $args;
}

function enqueue_category_tree_script($hook) {
    if ( $hook == 'post.php' || $hook == 'post-new.php' ) {
        wp_enqueue_script('category_tree', get_module_js('category_tree/category_tree.js'), ['jquery'], gk_get_rev(), true);
    }
    else return;
}
add_action( 'admin_enqueue_scripts', 'enqueue_category_tree_script' );
