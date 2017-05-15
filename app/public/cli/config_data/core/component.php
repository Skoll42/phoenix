<?php

namespace Bt\WP_CLI\ConfigData\core;

require_once realpath(dirname(dirname(__DIR__)) . '/wpcli-bt/php/commands/btconfig/core.php');

class Component extends \Bt\WP_CLI\ConfigData\Core
{
    protected function get_component_root() {
        return __DIR__;
    }

    protected function get_option_fields() {
        return array(

            # Settings -> Reading
            'posts_per_page',
            'posts_per_rss',
            'blog_public',

            # Settings -> Permalink
            'selection',
            'permalink_structure',
            'category_base',
            'tag_base',
        );
    }
}