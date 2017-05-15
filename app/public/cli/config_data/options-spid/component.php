<?php

namespace Bt\WP_CLI\ConfigData\options_spid;

require_once realpath(dirname(dirname(__DIR__)) . '/wpcli-bt/php/commands/btconfig/core.php');

class Component extends \Bt\WP_CLI\ConfigData\Core
{
    protected function get_component_root() {
        return __DIR__;
    }

    protected function get_option_fields() {
        return array(
            'options_spid_client_id',
            '_options_spid_client_id',

            'options_spid_server',
            '_options_spid_server',

            'options_spid_backend_client_id',
            '_options_spid_backend_client_id',

            'options_spid_backend_client_secret',
            '_options_spid_backend_client_secret',

            'options_spid_backend_client_sign_secret',
            '_options_spid_backend_client_sign_secret',
        );
    }
}