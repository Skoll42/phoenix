<?php return array (
  'general' => 
  array (
    'type' => 'core',
  ),
  'options' => 
  array (
    'posts_per_page' => '12',
    'posts_per_rss' => '10',
    'blog_public' => (WP_ENV_PROD) ? 1 : 0,
    'selection' => false,
    'permalink_structure' => '/%category%/%postname%/',
    'category_base' => '',
    'tag_base' => '',
  ),
);