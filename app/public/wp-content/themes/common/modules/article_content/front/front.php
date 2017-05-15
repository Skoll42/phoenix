<?php

function bt_article_content_get_elements($post_id = false) {
    return get_field('article_content_elements', $post_id);
}

function bt_article_content_is_element($name, $post_id = false) {
    $elements = bt_article_content_get_elements($post_id);
    return is_array($elements) && in_array($name, $elements);
}

add_action('wp_print_styles', function () {
    if (is_single()) {
        wp_enqueue_style('article-content', get_module_css('article_content/front.css'), [], gk_get_rev());
    }
});
