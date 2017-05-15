<?php
  switch (WP_ENV) {
    case 'prod':
      $ep_host = 'search-phoenix-prod-cxyxzfhbkjel3rh4bkuvcyc2ly.eu-west-1.es.amazonaws.com';
      break;

    case 'stage':
      $ep_host = 'search-phoenix-stage-ri6lj4rednu7ztsrv2ig25kgse.eu-west-1.es.amazonaws.com';
      break;

    case 'local':
      $ep_host = 'search-phoenix-sysla-elasticsearch-i4dm4x4rc6q5zwg2kijfzt3fci.eu-west-1.es.amazonaws.com';
      break;

    default:
      $ep_host = 'search-phoenix-sysla-elasticsearch-i4dm4x4rc6q5zwg2kijfzt3fci.eu-west-1.es.amazonaws.com';
      break;
  }
return array (
  'general' => 
  array (
    'type' => 'plugin',
    'active' => true,
  ),
  'options' => 
  array (
      'ep_host' => $ep_host,
  ),
  'custom' => 
  array (
  ),
);