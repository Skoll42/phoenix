<?php

namespace Bt\WP_CLI\ConfigData\media_library_assistant;

require_once realpath(dirname(dirname(__DIR__)) . '/wpcli-bt/php/commands/btconfig/plugin.php');

class Component extends \Bt\WP_CLI\ConfigData\Plugin
{
    protected function get_component_root() {
        return __DIR__;
    }

    protected function get_option_fields() {
        return array(
            'mla_upload_mimes',
            'mla_iptc_exif_mapping'
        );
    }
}