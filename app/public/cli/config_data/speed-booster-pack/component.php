<?php

namespace Bt\WP_CLI\ConfigData\speed_booster_pack;

require_once realpath(dirname(dirname(__DIR__)) . '/wpcli-bt/php/commands/btconfig/plugin.php');

class Component extends \Bt\WP_CLI\ConfigData\Plugin
{
    protected function get_component_root() {
        return __DIR__;
    }

    protected function get_option_fields() {
        return array(
            'sbp_settings'
        );
    }
}