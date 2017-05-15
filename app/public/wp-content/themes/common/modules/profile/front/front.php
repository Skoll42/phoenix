<?php

function is_profile_page() {
    return strpos($_SERVER['REQUEST_URI'], '/profile') !== false;
}

add_filter('body_class', function($classes, $class) {
    if (is_profile_page()) {
        $classes[] = 'profile';
    }
    return $classes;
}, 10, 2);

add_action('init', function() {
    add_rewrite_rule('^profile/?', 'index.php?__profile_page=1', 'top');
});

add_filter( 'query_vars', function( $vars ) {
    $vars[] = '__profile_page';
    return $vars;
});

add_action('wp_ajax_mailchimp_subscribe', 'mailchimp_subscribe');
add_action('wp_ajax_nopriv_mailchimp_subscribe', 'mailchimp_subscribe');

if (is_profile_page()) {
    add_action('wp_footer',function() {
        $mailchimpLists = get_mailchimp_lists();
        $mailchimpListsFormatted = [];

        foreach ($mailchimpLists as $list) {
            $mailchimpListsFormatted[$list->id] = $list->name;
        }
        $mailchimpListsFormatted = json_encode($mailchimpListsFormatted);
        nix_localize_script('mailchimpLists', $mailchimpListsFormatted);
    }, 5);
}

add_filter( 'template_include', function($template) {
    if (get_query_var('__profile_page')) {
        return get_module_template_path('profile/page');
    }
    return $template;
});

add_action('wp_enqueue_scripts', function () {
    if (is_profile_page()) {
        wp_enqueue_script('profile-common', get_module_js('profile/common.js'), ['spid-sdk', 'spid-sdk-uri', 'spid-common'], gk_get_rev(), true);
    }
});

add_action('wp_print_styles', function () {
    wp_enqueue_style('profile-common', get_module_css('profile/front.css'), [], gk_get_rev());
});