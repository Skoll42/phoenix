<?php

add_action('wp_ajax_spid_apply_voucher', 'spid_apply_voucher');
add_action('wp_ajax_nopriv_spid_apply_voucher', 'spid_apply_voucher');
function spid_apply_voucher()
{
    $spid_code = isset($_POST['code']) && $_POST['code'] ? trim($_POST['code']) : null;
    $spid_user_id = isset($_POST['user_id']) && $_POST['user_id'] ? $_POST['user_id'] : null;

    if (!$spid_code) {
        wp_send_json_error('error_empty_code');
    }
    if (!$spid_user_id) {
        wp_send_json_error('error_empty_user');
    }
    $spid_user = spid_get_user_by_id($spid_user_id);
    if (!$spid_user || !isset($spid_user['email'])) {
        wp_send_json_error('error_user_without_email');
    }

    $personal_voucher = $spid_code;

    $corporate_group = null;
    if (strpos($spid_code, 'CORP-') === 0) {
        // The voucher should be like "CORP-[COMPANY_ABBR]-[VOUCHER_GOURP_ID][LETTER][LETTERS_OR_NUMBERS].
        // Example: CORP-INTEL-16RYS77A
        $parts = explode('-', $spid_code, 3);
        if (isset($parts[2])) {
            $corporate_group = intval($parts[2]);
        }
    }

    $subscription = null;
    $client = null;
    try {
        $client = spid_get_client();
    } catch (Exception $e) {
        wp_send_json_error($e->getMessage());
    }

    if ($corporate_group) {
        try {
            $generate = $client->api("/vouchers/generate/{$corporate_group}", 'POST');
            if (!$generate['success']) {
                wp_send_json_error('error_generate_noname');
            }
        } catch (Exception $e) {
            wp_send_json_error('error_generate_limit_exceeded');
        }

        try {
            $handout = $client->api("/vouchers/handout/{$corporate_group}", 'POST');
            if (!$handout) {
                wp_send_json_error('error_handout_noname');
            }

            $personal_voucher = $handout[0]['voucherCode'];

        } catch (Exception $e) {
            wp_send_json_error('error_handout_no_available');
        }
    }

    try {
        $voucher = $client->api("/voucher/{$personal_voucher}");
        $productId = $voucher['group']['productId'];


        $subscriptions = $client->api("/user/{$spid_user_id}/subscriptions");
        if ($subscriptions) {
            foreach ($subscriptions as $subscription) {
                if ($subscription['productId'] == $productId) {
                    wp_send_json_error('error_already_has_product');
                }
            }
        }

        $new_subscription = $client->api("/user/{$spid_user_id}/subscription", 'POST', [
            'userId' => $spid_user_id,
            'productId' => $productId,
        ]);
    } catch (Exception $e) {
        wp_send_json_error($e->getMessage());
    }

    wp_send_json_success(['subscription' => $new_subscription]);
}
