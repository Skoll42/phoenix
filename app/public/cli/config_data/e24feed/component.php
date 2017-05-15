<?php

namespace Bt\WP_CLI\ConfigData\e24feed;

require_once realpath(dirname(dirname(__DIR__)) . '/wpcli-bt/php/commands/btconfig/plugin.php');

class Component extends \Bt\WP_CLI\ConfigData\Plugin
{
    protected function get_component_root() {
        return __DIR__;
    }

    protected function get_option_fields() {
        return array(
            'options_e24_feed_url',
            '_options_e24_feed_url',

            'options_e24_website_url',
            '_options_e24_website_url',
        );
    }
}