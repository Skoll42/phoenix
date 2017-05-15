<?php

if( function_exists('acf_add_options_page') ) {
	$parent = acf_add_options_page(array(
		'page_title' 	=> 'Fishiri Settings',
		'menu_title' 	=> 'Fishiri Settings',
		'parent_slug'	=> 'bt-settings',
		'menu_slug' 	=> 'fishiri-settings',
		'redirect' 		=> false
	));
}
