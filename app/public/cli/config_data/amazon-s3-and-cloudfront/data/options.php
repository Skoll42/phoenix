<?php return array (
  'general' => 
  array (
    'type' => 'plugin',
    'active' => true,
  ),
  'options' => 
  array (
    'tantan_wordpress_s3' => 
    array (
      'post_meta_version' => 3,
      'bucket' => (WP_ENV_PROD) ? 'img1.sysla.no' : 'img1.sysla.no',
      'region' => 'eu-west-1',
      'domain' => 'virtual-host',
      'expires' => '1',
      'cloudfront' => '',
      'object-prefix' => 'wp-content/uploads/',
      'copy-to-s3' => '1',
      'serve-from-s3' => '1',
      'remove-local-file' => '1',
      'ssl' => 'request',
      'hidpi-images' => '0',
      'object-versioning' => '1',
      'use-yearmonth-folders' => '1',
      'enable-object-prefix' => '1',
    ),
  ),
  'custom' => 
  array (
  ),
);