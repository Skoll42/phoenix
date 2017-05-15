<?php

function bt_article_content_get_bio_photo($post_id = false) {
    return get_field('article_content_bio_photo', $post_id);
}

function bt_article_content_get_bio_name($post_id = false) {
    return get_field('article_content_bio_name', $post_id);
}

function bt_article_content_get_bio_text($post_id = false) {
    return get_field('article_content_bio_text', $post_id);
}


add_filter('the_content', function($content) {
    return get_module_template('article_content/bio', [
        'bio_img' => get_lazy_loaded_wp_attachment_image(bt_article_content_get_bio_photo()),
        'bio_name' => bt_article_content_get_bio_name(),
        'bio' => bt_article_content_get_bio_text(),
    ]) . $content;
});
