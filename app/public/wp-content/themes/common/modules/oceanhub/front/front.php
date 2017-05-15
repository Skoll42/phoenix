<?php

include_once( ABSPATH . WPINC . '/feed.php' );

add_action('wp_ajax_get_oceanhub_widget', 'get_oceanhub_widget_json');
add_action('wp_ajax_nopriv_get_oceanhub_widget', 'get_oceanhub_widget_json');

add_action('wp_print_styles', function () {
    wp_enqueue_style('oceanhub-front', get_module_css('oceanhub/front.css'), [], gk_get_rev());
});

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('oceanhub-manager', get_module_js('oceanhub/widget-manager.js'), ['jquery', 'theme-common'], gk_get_rev(), true);
});

add_filter('wp_footer', function () {
    wp_reset_query();
    nix_localize_script('oceanhubConfig', array(
        'pageType' => is_single() || is_dockedships() ? 'single' : ''
    ));
}, 5);

function get_oceanhub_widget_json() {
    wp_send_json_success(['widget_html' => get_oceanhub_widget()]);
}

function get_oceanhub_widget() {
    $rss = fetch_feed( 'http://sysla-offshore.oceanhub.com/rss/feed' );
    $maxitems = 0;
    if ( ! is_wp_error( $rss ) ) {
        $max = isset($_GET['page_type']) && $_GET['page_type'] == 'single' ? 2 : 3;
        $maxitems = $rss->get_item_quantity( $max );
        $rss_items = $rss->get_items( 0, $maxitems );
    }
    $html = '<div class="proff-block">' .
                '<div class="proff-header">' .
                    '<div class="proff-title">Sysla proff</div>' .
                    '<div class="annonse-title">Annonseinnhold</div>' .
                '</div>' .
                '<ul class="articles-list">';
    if ($maxitems == 0) {
        $html .= '<li class="article-item">' . _e( 'Ingen artikler' ) . '</li>';
    } else {
        $html .= format_oceanhub_items($rss_items);
    }
    return $html . '</ul></div>';
}

function format_oceanhub_items($rss_items) {
    $items = '';
    foreach ($rss_items as $item) {
        $items .= '<li class="article-item">' .
                    '<a href="' . esc_url( $item->get_permalink() ) . '" ' .
                       'title="' . sprintf( __("Posted %s", "my-text-domain" ), $item->get_date("j F Y | g:i a") ) . '" target="' . (in_iframe() ? '_parent' : '_blank') . '">' .
                            ($item->get_item_tags('', 'post_image_thumb') ? format_oceanhub_image($item) : '') .
                        '<div class="title">' . esc_html( $item->get_title() ) . '</div>' .
                        '<div class="excerpt">' . esc_html( mb_substr($item->get_description(), 0, 120, "utf-8") . "..." ) . '</div>' .
                    '</a>' .
                '</li>';
    }
    return $items;
}

function format_oceanhub_image($item) {
    $src = $item->get_item_tags('', 'post_image_thumb')[0]['data'];
    if(!in_iframe()) {
        $img = lazyload_images_add_placeholders('<img src="' . $src  . '" alt="' . $item->get_title() . '" srcset="' . $src . '">');
    } else {
        $img = '<img src="' . $src  . '" alt="' . $item->get_title() . '" srcset="' . $src . '">';
    }

    return '<div class="embed-responsive embed-responsive-16by9">' . $img . '</div>';
}