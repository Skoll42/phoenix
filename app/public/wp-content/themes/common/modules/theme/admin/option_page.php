<?php

if (function_exists('acf_add_options_page')) {
	$option_page = acf_add_options_page(array(
		'page_title' 	=> 'BT Settings',
		'menu_title' 	=> 'BT Settings',
		'menu_slug' 	=> 'bt-settings',
		'capability' 	=> 'edit_posts',
		'redirect' 	=> false
	));
}
