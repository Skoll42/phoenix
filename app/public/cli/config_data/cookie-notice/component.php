<?php

namespace Bt\WP_CLI\ConfigData\cookie_notice;

require_once realpath(dirname(dirname(__DIR__)) . '/wpcli-bt/php/commands/btconfig/plugin.php');

class Component extends \Bt\WP_CLI\ConfigData\Plugin
{
    protected function get_component_root() {
        return __DIR__;
    }

    protected function get_option_fields() {
        return array(
            'cookie_notice_version',
            'cookie_notice_options',
        );
    }
}