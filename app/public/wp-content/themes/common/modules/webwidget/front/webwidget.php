<?php

add_action('init', function() {
    add_rewrite_rule('^webwidget/e24/?', 'index.php?__webwidget=e24', 'top');
    add_rewrite_rule('^webwidget/e242/?', 'index.php?__webwidget=e24&__webwidget_format=structured', 'top');
    add_rewrite_rule('^webwidget/(.+)2/?', 'index.php?__webwidget=$matches[1]&__webwidget_format=structured', 'top');
    add_rewrite_rule('^webwidget/(.+)/?', 'index.php?__webwidget=$matches[1]', 'top');
    add_rewrite_rule('^webwidget/?', 'index.php?__webwidget=latest', 'top');
});

add_filter( 'query_vars', function($vars) {
    array_push($vars, '__webwidget');
    array_push($vars, '__webwidget_format');
    return $vars;
} );

add_action('template_include', function($template) {
    $channel = get_query_var('__webwidget', null);
    $format = get_query_var('__webwidget_format', null);

    if ($channel == 'ap') { // Fixed for old logic
        $format = 'structured';
    }

    if (!$channel) {
        return $template;
    }

    $channel = (isset($_REQUEST['type'])) ? $_REQUEST['type'] : $channel; // Back compatibility

    $args = [
        'posts_per_page' => 100,
        'post_status' => 'publish',
        'post_type' => ['post', 'podcast']
    ];

    $posts = get_field(sprintf('webwidget_%s_posts', $channel), 'option');
    if ($posts) {
        $args = array_merge([
            'post__in' => $posts,
            'orderby' => 'post__in',
        ], $args);
    } else {
        $args = array_merge([
            'category__not_in' => get_field('webwidget_latest_exclude_categories', 'option'),
        ], $args);
    }

    $query = new WP_Query($args);

    $image_size = 'itera-medium';
    if ($channel == 'e24') {
        $image_size = 'itera-e24';
    }


    $res = array();
    while ($query->have_posts()) {
        $query->the_post();
        $post_id = get_the_ID();

        $res[] = array(
            'id' => get_the_ID(),
            'title' => get_the_title(),
            'url' => bt_webwidget_get_url($post_id, $channel),
            'image' => bt_webwidget_get_thumbnail($post_id, $image_size),
            'publish_date' => bt_webwidget_get_publish_date($post_id),
        );
    }

    if ($format == 'structured') {
        $res = bt_webwidget_fix_ap_result($res);
    }

    wp_send_json($res);
});

function bt_webwidget_fix_ap_result($res) {
    $new_res = array(
        'name' => 'Sysla',
        'articles' => array(),
    );
    foreach ($res as $item) {
        $new_res['articles'][] = array(
            'title' => $item['title'],
            'urls' => array(
                'presentation' => $item['url'],
            ),
            'dates' => array(
                'published' => date('Y-m-d\TH:i:s.000\Z', strtotime($item['publish_date'])),
            ),
            'related' => array(
                'images' => array(
                    'teaser' => array(
                        'src' => $item['image'],
                    ),
                ),
            ),
        );
    }
    return $new_res;
}

function bt_webwidget_get_thumbnail($post_id, $size = 'itera-medium') {
    $post_thumbnail_id = (get_post_thumbnail_id($post_id)) ? get_post_thumbnail_id($post_id) : get_field('article_header_image', $post_id, false);
    $attachment = wp_get_attachment_image_src($post_thumbnail_id, $size);
    return is_array($attachment) ? $attachment[0] : '';
}

function bt_webwidget_get_publish_date($post_id) {
    return mysql2date('D, d M Y H:i:s +0000', get_post_time('Y-m-d H:i:s', true, $post_id), false);
}

function bt_webwidget_get_url($post_id, $channel) {
    $url = get_permalink($post_id);
    $url .= (strpos($url, '?') === false ? '?' : '&') . 'utm_source=' . $channel . '&utm_medium=webwidget&utm_campaign=promo';
    return $url;
}



add_action('acf/save_post', function($post_id) {
    $purgeUrls = [
        home_url() . '/webwidget/?vhp-regex'
    ];
    bt_purge_varnish_urls($purgeUrls);
}, 20);
