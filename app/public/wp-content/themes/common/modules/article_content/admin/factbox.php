<?php

add_action('admin_enqueue_scripts', function($hook) {
    if ( $hook == 'post.php' || $hook == 'post-new.php' ) {
        wp_enqueue_script('factbox_script', get_module_js('article_content/factbox.js'), ['jquery'], gk_get_rev(), true);
        wp_localize_script('factbox_script', 'factbox_script', array(
            'factbox_id' => 'acf-group_5881524aec7bb',
            'input_field_data_key'=> 'field_588155c12b245'
        ));
    }
});
