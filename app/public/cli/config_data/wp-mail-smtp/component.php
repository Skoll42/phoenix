<?php

namespace Bt\WP_CLI\ConfigData\wp_mail_smtp;

require_once realpath(dirname(dirname(__DIR__)) . '/wpcli-bt/php/commands/btconfig/plugin.php');

class Component extends \Bt\WP_CLI\ConfigData\Plugin
{
    protected function get_component_root() {
        return __DIR__;
    }

    protected function get_option_fields() {
        return array(
            'mail_from',
            'mail_from_name',
            'mailer',
            'mail_set_return_path',
            'smtp_host',
            'smtp_port',
            'smtp_ssl',
            'smtp_auth',
            'smtp_user',
            'smtp_pass'
        );
    }
}