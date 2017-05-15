<?php

add_filter('acf/fields/relationship/query',  function($args, $field, $post_id) {
	if(is_admin() && strpos($field['name'], 'webwidget') !== false) {
		$args['orderby'] = 'post_modified';
		$args['post_status'] = 'publish';
	}

	return $args;
}, 10, 3);


if (function_exists('acf_add_options_page')) {
	acf_add_options_page(array(
		'page_title' 	=> 'Web Widget Settings',
		'menu_title'	=> 'Web Widget',
		'capability' 	=> 'edit_posts',
		'redirect' 	=> false
	));
}
