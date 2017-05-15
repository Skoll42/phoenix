<?php

function bt_article_content_get_jobben_text($post_id = false) {
    return get_field('article_content_jobben_text', $post_id);
}
