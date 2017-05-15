<?php

namespace Bt\WP_CLI\ConfigData\options_fishiri;

require_once realpath(dirname(dirname(__DIR__)) . '/wpcli-bt/php/commands/btconfig/core.php');

class Component extends \Bt\WP_CLI\ConfigData\Core
{
    protected function get_component_root() {
        return __DIR__;
    }

    protected function get_option_fields() {
        return array(
            'fishiri_api_base_url',
            '_fishiri_api_base_url',

            'fishiri_client_id',
            '_fishiri_client_id',

            'fishiri_client_secret',
            '_fishiri_client_secret',

            'dockedships_head',
            '_dockedships_head',

            'dockedships_header_text',
            '_dockedships_header_text',
            
            'dockedships_title',
            '_dockedships_title',
            
            'dockedships_excerpt',
            '_dockedships_excerpt'
        );
    }
}