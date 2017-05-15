<?php

if( function_exists('acf_add_options_page') ) {

	$parent = acf_add_options_page(array(
		'page_title' 	=> 'SPiD Settings',
		'menu_title' 	=> 'SPiD Settings',
		'parent_slug'	=> 'bt-settings',
		'menu_slug' 	=> 'spid-settings',
		'redirect' 		=> false
	));
}