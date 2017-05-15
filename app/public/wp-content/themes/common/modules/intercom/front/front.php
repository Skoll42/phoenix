<?php

use Intercom\IntercomClient;

if (WP_ENV_PROD) {
    define('INTERCOM_APP_ID', 'ctfx6kzw');
    define('INTERCOM_API_KEY', '0b5f96fa3c069ea677beb5ba546a85a2f62b2a3a');
} else {
    define('INTERCOM_APP_ID', 'tkvkn0jq');
    define('INTERCOM_API_KEY', '617c2249c68d6609462470e7c7c7f5204e37781d');
}

add_action('wp_footer', function(){
    $app_id = INTERCOM_APP_ID;
    echo <<<"EOF"
<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/{$app_id}';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>
EOF;
});

add_action('wp_head', function() {
    nix_localize_script('appId', INTERCOM_APP_ID);
    nix_localize_script('showChat', intercom_should_chat_be_displayed());
},5);

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('intercom-common', get_module_js('intercom/common.js'), ['jquery'], gk_get_rev(), true);
});

add_action('wp_print_styles', function () {
    wp_enqueue_style('intercom-styles', get_module_css('intercom/front.css'), [], gk_get_rev());
});

function intercom_should_chat_be_displayed() {
    return is_profile_page() || is_product_page() || is_spid_logged_in_page() || is_spid_paid_page() || (is_single() && !spid_is_content_accessable()) || spid_cookies_disabled();
}

add_action('wp_ajax_intercom_create_user', 'intercom_create_user');
add_action('wp_ajax_nopriv_intercom_create_user', 'intercom_create_user');
function intercom_create_user()
{
    $spid_type = (isset($_POST['type']) && $_POST['type']) ? $_POST['type'] : null;

    $spid_user_id = (isset($_POST['spid_user_id']) && $_POST['spid_user_id']) ? $_POST['spid_user_id'] : null;
    if (!$spid_user_id) {
        wp_send_json_error('Parameter "spid_user_id" is not set.');
    }
    $spid_product_id = (isset($_POST['spid_product_id']) && $_POST['spid_product_id']) ? $_POST['spid_product_id'] : null;
    $spid_voucher_code = (isset($_POST['spid_voucher_code']) && $_POST['spid_voucher_code']) ? $_POST['spid_voucher_code'] : null;

    $spid_user = spid_get_user_by_id($spid_user_id);
    if (!$spid_user || !isset($spid_user['email'])) {
        wp_send_json_error('User does not have an email.');
    }


    if ($spid_type == 'login') {
        $session_user = intercom_get_session_user($spid_user['email']);
        if ($session_user->id) {
            wp_send_json_success(['id' => $session_user->id, 'email' => $session_user->id, 'from_session' => true]);
        }
    }


    $client = null;
    $user = null;

    try {
        $client = new IntercomClient(INTERCOM_APP_ID, INTERCOM_API_KEY);
    } catch (Exception $e) {
        wp_send_json_error($e->getMessage());
    }

    try {
        $result = $client->users->getUsers(['email' => $spid_user['email']]);
    } catch (Exception $e) {
        $result = null;
    }

    try {
        $user_id = isset($result) ? $result->id : null;

        $options = [
            'id' => $user_id,
            'email' => $spid_user['email'],
            'name' => $spid_user['name']['formatted'],
            'update_last_request_at' => true,
            'custom_attributes' => array(
                'given_name' => $spid_user['name']['givenName'],
                'family_name' => $spid_user['name']['familyName'],
                'spid_user_id' => $spid_user['userId'],
            ),
        ];
        if (!$user_id) {
            $options['custom_attributes']['signup_site'] = $_SERVER['HTTP_HOST'];
        }
        if ($spid_type == 'purchase') {
            $options['custom_attributes']['product_id'] = $spid_product_id;
            $options['custom_attributes']['voucher_code'] = $spid_voucher_code;
        }
        $user = $client->users->create($options);
    } catch (Exception $e) {
        wp_send_json_error($e->getMessage());
    }

    if ($spid_type == 'login') {
        intercom_set_session_user($user->id, $user->email);
    }
    wp_send_json_success(['id' => $user->id, 'email' => $user->email]);
}

function intercom_get_session_user($email) {
    session_start();

    if (!isset($_SESSION['intercom_users']) || !is_array($_SESSION['intercom_users'])) {
        $_SESSION['intercom_users'] = [];
    }
    $session_user_id = array_search($email, $_SESSION['intercom_users']);

    return (object) array(
        'id' => $session_user_id,
        'email' => $email,
    );
}

function intercom_set_session_user($id, $email) {
    $_SESSION['intercom_users'][$id] = $email;
}
