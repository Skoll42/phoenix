<?php

if (bt_is_plugin_active(__FILE__)) {

    add_filter('http_request_args', function($r, $url) {
        if ($r['method'] == 'PURGE') {
            $r['headers']['X-Cache-Purge-Auth-Key'] = 'qN9pdCCJ38jjc9fB3UtE0nx1r3aFne7p';
        }

        return $r;
    }, 20, 2);

    add_filter('varnish_http_purge_events', function($actions) {
        $actions[] = 'pre_post_update';
        return $actions;
    });

    add_filter('vhp_purge_urls', function($purgeUrls, $postId) {
        $purgeUrls = [];

        $validPostStatus = array("publish", "trash");
        $thisPostStatus  = get_post_status($postId);

        if (get_permalink($postId) == true && in_array($thisPostStatus, $validPostStatus)) {
            $purgeUrls[] = get_permalink($postId) . '?vhp-regex';

            $categories = get_the_category($postId);
            if ($categories) {
                foreach ($categories as $cat) {
                    $category_link = get_category_link($cat->term_id);
                    $purgeUrls[] = $category_link;
                    $purgeUrls[] = $category_link . 'feed/?vhp-regex';
                    $purgeUrls[] = $category_link . 'page/?vhp-regex';
                }
            }

            $purgeUrls[] = get_author_posts_url(get_post_field('post_author', $postId)) . '?vhp-regex';

            $tags = get_the_tags($postId);
            if ($tags) {
                foreach ($tags as $tag) {
                    $purgeUrls[] = get_tag_link($tag->term_id) . '?vhp-regex';
                }
            }
        }

        return $purgeUrls;
    }, 5, 2);

    function bt_purge_varnish_urls($newPurgeUrls) {
        global $purger;
        $class = new ReflectionClass("VarnishPurger");
        $property = $class->getProperty("purgeUrls");
        $property->setAccessible(true);
        $purgeUrls = $property->getValue($purger);

        $purgeUrls = array_merge([], $purgeUrls, $newPurgeUrls);

        $property->setValue($purger, $purgeUrls);
    }
}
