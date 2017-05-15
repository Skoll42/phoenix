<?php

namespace Bt\WP_CLI\ConfigData\ewww_image_optimizer;

require_once realpath(dirname(dirname(__DIR__)) . '/wpcli-bt/php/commands/btconfig/plugin.php');

class Component extends \Bt\WP_CLI\ConfigData\Plugin
{
    protected function get_component_root() {
        return __DIR__;
    }

    protected function get_option_fields() {
        return array(
            'ewww_image_optimizer_optipng_level',
            'ewww_image_optimizer_metadata_skip_full',
            'ewww_image_optimizer_pngout_level',
            'ewww_image_optimizer_disable_pngout'
        );
    }
}