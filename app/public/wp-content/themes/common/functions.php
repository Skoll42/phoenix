<?php

define('BT_THEME_DIR', __DIR__);
define('BT_THEME_PLUGINS_DIR', BT_THEME_DIR . '/plugins');
define('BT_THEME_MODULES_DIR', BT_THEME_DIR . '/modules');

bt_include_php_files_from_dir(BT_THEME_PLUGINS_DIR, true);

if (is_admin()) {
    foreach (glob(BT_THEME_MODULES_DIR . '/*/admin', GLOB_ONLYDIR) as $folder) {
        bt_include_php_files_from_dir($folder);
    }
}

foreach (glob(BT_THEME_MODULES_DIR . '/*/front', GLOB_ONLYDIR) as $folder) {
    bt_include_php_files_from_dir($folder);
}

foreach (glob(BT_THEME_MODULES_DIR . '/*/widgets', GLOB_ONLYDIR) as $folder) {
    bt_register_widgets_from_dir($folder);
}

/*----------------------------------------------------*/
// The end of new config
/*----------------------------------------------------*/
/*----------------------------------------------------*/
/*----------------------------------------------------*/
/*----------------------------------------------------*/


function get_current_frontpage() {
    if (strpos($_SERVER['REQUEST_URI'], '/gronn') === 0 ){
        return 'syslagronn';
    }
    if (strpos($_SERVER['REQUEST_URI'], '/maritim') === 0 ) {
        return 'maritime';
    }
    if (strpos($_SERVER['REQUEST_URI'], '/offshore') === 0 ) {
        return 'offshore';
    }
    return 'sysla';
}

function get_lazy_loaded_wp_attachment_image($attachment_id, $size = 'thumbnail', $icon = false, $attr = '') {
    $image = wp_get_attachment_image($attachment_id, $size, $icon, $attr);
    return (function_exists('lazyload_images_add_placeholders') && !in_iframe() ? lazyload_images_add_placeholders($image) : $image);
}

function nix_localize_script($variableName, $variableValue) {
    echo '<script> var '  . $variableName . ' = ' . json_encode($variableValue, true) . ';</script>';
}
