<?php

function bt_get_snappet_fronted_elements($post_id = false) {
    return get_field('snappet_fronted_elements', $post_id);
}

function bt_has_snappet_fronted_element($value, $post_id = false) {
    $elements = bt_get_snappet_fronted_elements($post_id);
    return !is_array($elements) || in_array($value, $elements);
}

function bt_has_article_fronted_element($value, $post_id = false) {
    $elements = bt_get_article_fronted_elements($post_id);
    return !is_array($elements) || in_array($value, $elements);
}

function bt_get_article_fronted_elements($post_id = false) {
    return get_field('article_fronted_elements', $post_id);
}

function bt_get_article_fronted_title($post_id = false) {
    $title = bt_get_real_article_fronted_title($post_id);
    if ($title) {
        return $title;
    }
    return get_the_title($post_id);
}

function bt_get_real_article_fronted_title($post_id = false) {
    return get_field('article_fronted_title', $post_id, false);
}

function bt_get_article_fronted_fontsize($post_id = false) {
    $fontsize = get_field('article_fronted_fontsize', $post_id);
    return $fontsize ? $fontsize : null;
}

function bt_get_article_fronted_excerpt($post_id = false) {
    $excerpt = bt_get_real_article_fronted_excerpt($post_id);
    if ($excerpt) {
        return $excerpt;
    }

    return get_the_excerpt($post_id);
}

function bt_get_real_article_fronted_excerpt($post_id = false) {
    return get_field('article_fronted_excerpt', $post_id, false);
}

function bt_get_article_fronted_image($post_id = false) {
    $image_id = bt_get_real_article_fronted_image($post_id);
    if ($image_id) {
        return $image_id;
    }

    return bt_get_article_header_image_id($post_id);
}

function bt_get_real_article_fronted_image($post_id = false) {
    return get_field('article_fronted_image', $post_id);
}
