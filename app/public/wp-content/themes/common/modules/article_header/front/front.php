<?php

function bt_is_article_header_type($value, $post_id = false) {
    return bt_get_article_header_type($post_id) == $value;
}

function bt_get_article_header_type($post_id = false) {
    return get_field('article_header_type', $post_id);
}

function bt_get_article_header_image_id($post_id = false) {
    return get_field('article_header_image', $post_id);
}

function bt_get_article_header_text($post_id = false) {
    return get_field('article_header_text', $post_id);
}

function bt_insert_article_header_embed_code($post_id = false) {
    $embed_code = get_field('article_header_embed_code', $post_id);

    if (strpos($embed_code, 'iframe') !== false || strpos($embed_code, '<script') !== false) {
        return $embed_code;
    }

    $embed = wp_oembed_get($embed_code);
    if ($embed) {
        return $embed;
    }

    return '<iframe width="800" height="600" scrolling="no" frameborder="no" src="' . $embed_code . '"></iframe>';
}
