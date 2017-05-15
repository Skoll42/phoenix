<?php

function _bt_custom_author_get_type($postID = false) {
    return get_field('custom_author_type', $postID);
}

function bt_custom_author_type_is($value, $postID = false) {
    return _bt_custom_author_get_type($postID) == $value;
}

function bt_custom_author_get_name($postID = false) {
    $custom_name = get_field('custom_author_name', $postID);
    return $custom_name ? $custom_name : 'Redaksjon';
}

function bt_custom_authors_get_list($postID = false) {
    $list = get_field('custom_author_list', $postID, false);
    return is_array($list) ? $list : [];
}

function bt_custom_authors_get_authors($postID = false) {
    if (bt_custom_author_type_is('none', $postID)) {
        return [];
    }

    if (bt_custom_author_type_is('name', $postID)) {
        return [[
            'ID' => null,
            'email' => null,
            'name' => bt_custom_author_get_name($postID),
        ]];
    }

    if (bt_custom_author_type_is('list', $postID)) {
        $authors_list = bt_custom_authors_get_list($postID);
    } else {
        $authors_list = [get_the_author_meta('ID')];
    }

    $authors = [];
    foreach ($authors_list as $author_id) {
        $authors[] = [
            'ID' => $author_id,
            'name' => get_the_author_meta('display_name', $author_id),
            'email' => get_the_author_meta('email', $author_id),
        ];
    }

    return $authors;
}
