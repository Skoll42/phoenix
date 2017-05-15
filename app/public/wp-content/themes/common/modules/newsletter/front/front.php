<?php

add_action('wp_head',function() {
    if (bt_archive_is_category_fronted()) {
        $mailchimpLists = get_mailchimp_lists();
        $mailchimpListsFormatted = [];

        foreach ($mailchimpLists as $list) {
            $mailchimpListsFormatted[$list->id] = $list->name;
        }
        $mailchimpListsFormatted = json_encode($mailchimpListsFormatted);
        nix_localize_script('mailchimpLists', $mailchimpListsFormatted);
    }
});

add_action('wp_enqueue_scripts', function () {
    if (bt_archive_is_category_fronted()) {
        wp_enqueue_script('newsletter-common', get_module_js('newsletter/common.js'), ['jquery', 'spid-sdk', 'spid-sdk-uri'], gk_get_rev(), true);
    }
});

add_action('wp_print_styles', function () {
    if (bt_archive_is_category_fronted() || is_single()) {
        wp_enqueue_style('newsletter-common', get_module_css('newsletter/front.css'), [], gk_get_rev());
    }
});

add_action('wp_ajax_mailchimp_subscribtions', 'get_mailchimp_subscriptions');
add_action('wp_ajax_nopriv_mailchimp_subscribtions', 'get_mailchimp_subscriptions');
add_action('wp_ajax_bt_newsletter_subscribe', 'bt_newsletter_subscribe');
add_action('wp_ajax_nopriv_bt_newsletter_subscribe', 'bt_newsletter_subscribe');
add_action('wp_ajax_mailchimp_unsubscribe', 'mailchimp_unsubscribe');
add_action('wp_ajax_nopriv_mailchimp_unsubscribe', 'mailchimp_unsubscribe');

function get_mailchimp_subscriptions() {
    wp_send_json_success([
        'subscriptions' => get_subscribed_lists($_GET['email'])
    ]);
}

function bt_newsletter_subscribe() {
    if (!isset($_POST['lists']) || empty($_POST['lists'])) {
        wp_send_json_error('error_empty_list_parameter');
    }

    $result = null;

    $mailchimpClient = get_mailchimp_client();
    foreach ((array)$_POST['lists'] as $list) {
        $result = $mailchimpClient->subscribe($list, $_POST['email'], array(), 'html', false, true);
    }

    if ($result === true) {
        wp_send_json_success();
    } else {
        wp_send_json_error('error_something_went_wrong');
    }

}

function mailchimp_subscribe() {
    $mailchimpClient = get_mailchimp_client();
    wp_send_json_success([
        'subscribed' => $mailchimpClient->subscribe($_POST['list'], $_POST['email'], array(), 'html', false, true)
    ]);
}

function mailchimp_unsubscribe() {
    $mailchimpClient = get_mailchimp_client();
    wp_send_json_success([
        'unsubscribed' => $mailchimpClient->unsubscribe($_POST['list'], $_POST['email'], true, true, true)
    ]);
}

$mailchimpClient = null;
function get_mailchimp_client() {
    global $mailchimpClient;

    if (!$mailchimpClient) {
        $opts = mc4wp_get_options('general');
        $mailchimpClient = new MC4WP_API($opts['api_key']);
    }

    return $mailchimpClient;
}

$mailchimpLists = null;
function get_mailchimp_lists() {
    global $mailchimpLists;

    if (!$mailchimpLists) {
        $mailchimpManager = new MC4WP_MailChimp();
        $mailchimpLists = $mailchimpManager->get_lists();
    }

    return $mailchimpLists;
}

function get_subscribed_lists($email) {
    $opts = mc4wp_get_options('general');
    $apiKey = $opts['api_key'];
    $dataCenter = substr($apiKey, strpos($apiKey, '-') + 1);
    $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/search-members?query=' . strtolower($email);

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $result = curl_exec($ch);
    curl_close($ch);

    $response = json_decode( $result );
    return (is_object( $response ) && isset( $response->exact_matches )) ? $response->exact_matches : [];
}
