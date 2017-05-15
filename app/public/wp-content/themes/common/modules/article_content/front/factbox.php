<?php

add_action('wp_print_styles', function () {
    if (is_single() && bt_article_content_is_element('factbox')) {
        wp_enqueue_style('article-content-factbox', get_module_css('article_content/front.css'), [], gk_get_rev());
    }
});

function bt_article_content_get_factbox_by_id($id) {
    reset_rows();
    while( have_rows('article_content_factbox') ) {
        the_row();
        $shortcode = get_sub_field('article_content_factbox_shortcode');

        preg_match('(\d+)', $shortcode, $matches);
        $factbox_id = $matches[0];

        if ($factbox_id == $id) {
            return array(
                'layout' => get_sub_field('article_content_factbox_layout'),
                'content' => get_sub_field('article_content_factbox_text'),
                'copyright' => get_sub_field('article_content_factbox_copyright'),
            );
        }
    }

    return null;
}

add_shortcode('factbox', function($atts) {
    $factbox_id = isset($atts['id']) ? $atts['id'] : 1;
    $factbox = bt_article_content_get_factbox_by_id($factbox_id);
    if ($factbox) {
        return get_module_template('article_content/factbox_' . $factbox['layout'], [
            'content' => $factbox['content'],
            'copyright' => $factbox['copyright'],
            'factbox_id' => $factbox_id
        ]);
    }
});
