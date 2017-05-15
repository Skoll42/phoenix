<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache



define('APP_PATH', dirname(__FILE__));
define('BT_FRAMEWORK_ROOT', APP_PATH . '/wp-content/mu-plugins/bt-framework');

require_once(__DIR__ . '/../vendor/autoload.php');
require_once(BT_FRAMEWORK_ROOT . '/wp-config/pre.php');

require_once(BT_FRAMEWORK_ROOT . '/wp-config/default.php');

/**
 * Authentication Unique Keys and Salts
 * https://api.wordpress.org/secret-key/1.1/salt/
 */
define('AUTH_KEY',         'XX#-|BRg$;x+6RD*AJhg7nZ02BufWk>J8GlLGui+ -[i.yl_G@w6+(@XM-yRb1M|');
define('SECURE_AUTH_KEY',  'U7}4*5wX+ PP[1CLgB+/*7`9.$%{gZ RE2HV&nW0I3LJ9)Zgnkr@rklfcf~Re4,}');
define('LOGGED_IN_KEY',    '&|k+aXWa2&zi=h Pk8- +.-@]~fmyL8~/)9!E!$yY,h]tJ52</:{,8Pb*T!Tk(8j');
define('NONCE_KEY',        'Jb]zr|i#ONTq72F&2`LZ$`lROhz+]H+U9YU9mp 3$l iy-1p&^B~-X5w<bl-pAq!');
define('AUTH_SALT',        'EEG}=a+6c{]t|o^IW&}I2@^@y(w5SE7LWg.f]]ox13C,@b,<i#[]Q,R|H^x-,$n-');
define('SECURE_AUTH_SALT', 'v([pa/juKgjS%#T(wT@=8rK0Y|%meYD8HmU/OrS}SIR/jyL|lJZmj}=F9JH+uq0|');
define('LOGGED_IN_SALT',   'zM+^mL+LO:(wxfw8J|>Ab%O83^%DV|_yaTs5/^jss p.yv_xBv(VP)/N%rI@%|+[');
define('NONCE_SALT',       'WBK=S:POhHvY#6*8o2EYep7U|A_IK8qj|<sikZD>3p+4wQzplez`Fzh[|{mvVMfK');

/**
 * Bootstrap WordPress
 */
if (!defined('ABSPATH')) {
    define('ABSPATH', APP_PATH . '/wp/');
}

require_once(ABSPATH . 'wp-settings.php');
