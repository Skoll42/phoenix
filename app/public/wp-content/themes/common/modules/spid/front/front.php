<?php

define('SPID_CLIENT_ID', get_field('spid_client_id', 'option'));
define('SPID_SERVER', get_field('spid_server', 'option'));
define('SPID_PRODUCTS_IDS', get_field('spid_products_ids', 'option'));

define('SPID_BACKEND_CLIENT_ID', get_field('spid_backend_client_id', 'option'));
define('SPID_BACKEND_CLIENT_SECRET', get_field('spid_backend_client_secret', 'option'));
define('SPID_BACKEND_CLIENT_SIGN_SECRET', get_field('spid_backend_client_sign_secret', 'option'));


function is_spid_logged_in_page() {
    return strpos($_SERVER['REQUEST_URI'], '/spid/logged_in') !== false;
}

function is_spid_paid_page() {
    return strpos($_SERVER['REQUEST_URI'], '/spid/paid/') !== false;
}

add_action('wp_footer', function() {
    $const = get_defined_constants();
    $bounce_page = isset($_GET['spid_page']) && $_GET['spid_page'] ? $_GET['spid_page'] : null;
    $redirect_to_url = $_GET['redirect_to'];
    $voucher_code = $_GET['voucher_code'];

    nix_localize_script('spidClientId', $const['SPID_CLIENT_ID']);
    nix_localize_script('spidServer', $const['SPID_SERVER']);
    nix_localize_script('spidProductsIds', explode(',', str_replace(' ', '', $const['SPID_PRODUCTS_IDS'])));
    if(is_spid_paid_page() || is_spid_logged_in_page()) {
        nix_localize_script('redirectToUrl', $redirect_to_url);

        if($bounce_page) {
            nix_localize_script('bouncePage', $bounce_page);
        }
    }

    if(is_spid_paid_page() && !$bounce_page) {
        nix_localize_script('voucherCode', $voucher_code);
    }
}, 5);

add_action('wp_enqueue_scripts', function () {
    $bounce_page = isset($_GET['spid_page']) && $_GET['spid_page'] ? $_GET['spid_page'] : null;
    wp_enqueue_script('spid-sdk', get_module_js('spid/libs/spid-sdk.js'), ['jquery'], null, true);
    wp_enqueue_script('spid-sdk-uri', get_module_js('spid/libs/spid-uri.js'), ['spid-sdk'], null, true);
    wp_enqueue_script('spid-common', get_module_js('spid/common.js'), ['spid-sdk', 'jquery-cookie'], gk_get_rev(), true);
    if ((is_single() && !spid_is_content_accessable()) || spid_cookies_disabled()) {
        wp_enqueue_script('spid-ga-stat', get_module_js('spid/bt-stats.js'), ['jquery', 'spid-sdk', 'spid-sdk-uri', 'spid-common'], gk_get_rev(), true);
    }

    if(is_spid_logged_in_page()) {
        if($bounce_page) {
            wp_enqueue_script('spid-logged-in-bounce', get_module_js('spid/logged-in-bounce.js'), ['jquery', 'spid-common'], gk_get_rev(), true);
        } else {
            wp_enqueue_script('spid-logged-in', get_module_js('spid/logged-in.js'), ['jquery', 'spid-common'], gk_get_rev(), true);
        }
    }

    if(is_spid_paid_page()) {
        if($bounce_page) {
            wp_enqueue_script('spid-paid-bounce', get_module_js('spid/paid-bounce.js'), ['jquery', 'spid-common'], gk_get_rev(), true);
        } else {
            wp_enqueue_script('spid-paid', get_module_js('spid/paid.js'), ['jquery', 'spid-common'], gk_get_rev(), true);
        }
    }
});

add_action('wp_print_styles', function () {
    wp_enqueue_style('spid-common', get_module_css('spid/front.css'), [], gk_get_rev());
    if(spid_cookies_disabled()) {
        wp_enqueue_style('bt-enable-cookies-message', get_module_css('spid/bt-enable-cookies-message.css'), [], gk_get_rev());
    }
});

function spid_cookies_disabled() {
    return $_GET['redirected_no_cookies'] ? true : false;
}

function spid_is_content_accessable() {
    if (spid_is_user_subscribed()) {
        return true;
    }

    $access_level = get_field('access_level');

    if ($access_level == 'metered') {
        $x_paywall_key = isset($_SERVER['HTTP_X_PWQ']) ? $_SERVER['HTTP_X_PWQ'] : $_COOKIE['pwq'];
        $x_paywall_counter_key = isset($_SERVER['HTTP_X_PWQC']) ? $_SERVER['HTTP_X_PWQC'] : $_COOKIE['pwqc'];

        if (isset($x_paywall_key) && $x_paywall_key == 'TA') {
            return true;
        }
        if($x_paywall_counter_key != 'MA') {
            return true;
        }
    }
    return ($access_level == 'free' || is_null($access_level) || in_array(get_post_type(), ['pressrelease', 'sponsored']));
}

function spid_is_user_authorized() {
    $paywall_access = isset($_SERVER['HTTP_X_PWA']) ? $_SERVER['HTTP_X_PWA'] : $_COOKIE['pwa'];

    if (isset($paywall_access) && in_array($paywall_access, array('s', 'a'))) {
        return true;
    }
    return false;
}

function spid_is_user_subscribed() {
    $paywall_access = isset($_SERVER['HTTP_X_PWA']) ? $_SERVER['HTTP_X_PWA'] : $_COOKIE['pwa'];

    if (isset($paywall_access) && $paywall_access == 's') {
        return true;
    }
    return false;
}

$spid_client = null;
function spid_get_client() {
    global $spid_client;

    if (!$spid_client) {
        $spid_client = new VGS_Client(array(
            VGS_Client::CLIENT_ID          => SPID_BACKEND_CLIENT_ID,
            VGS_Client::CLIENT_SECRET      => SPID_BACKEND_CLIENT_SECRET,
            VGS_Client::CLIENT_SIGN_SECRET => SPID_BACKEND_CLIENT_SIGN_SECRET,
            VGS_Client::REDIRECT_URI       => home_url(),
            VGS_Client::DOMAIN             => getenv('DOMAIN_NAME'),
            VGS_Client::API_VERSION        => 2,
            VGS_Client::PRODUCTION         => SPID_ENV_PROD,
        ));
        $spid_client->auth();
    }

    return $spid_client;
}

function spid_get_user_by_id($user_id) {
    try {
        $client = spid_get_client();
        $user = $client->api("/user/{$user_id}");
    } catch (Exception $e) {
        return null;
    }

    return $user;
}

function spid_get_subscriptions_by_user_id($user_id) {
    try {
        $client = spid_get_client();
        $subscriptions = $client->api("/user/{$user_id}/subscriptions");
    } catch (Exception $e) {
        return null;
    }

    return $subscriptions;
}

function spid_rewrite_basic() {
    add_rewrite_rule('^spid/([^/]*)/([^/]*)/?', 'index.php?__spid_api=1&__spid_action=$matches[1]&__spid_param1=$matches[2]', 'top');
    add_rewrite_rule('^spid/([^/]*)/?', 'index.php?__spid_api=1&__spid_action=$matches[1]', 'top');
}
add_action('init', 'spid_rewrite_basic');

add_filter( 'query_vars', function( $vars ) {
    $vars[] = '__spid_api';
    $vars[] = '__spid_action';
    $vars[] = '__spid_param1';
    return $vars;
});

add_filter( 'template_include', function($template) {
    if (get_query_var('__spid_api')) {
        $action = get_query_var('__spid_action');

        switch ($action) {
            case 'userinfo':
                $user_id = get_query_var('__spid_param1');
                wp_send_json_success([
                    'user' => spid_get_user_by_id($user_id),
                    'subscriptions' => spid_get_subscriptions_by_user_id($user_id),
                ]);
                break;

            case 'logged_in':
                return get_module_template_path('spid/logged_in');

            case 'paid':
                return get_module_template_path('spid/paid');

            default:
                break;
        }
    }
    return $template;
});