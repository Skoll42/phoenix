<?php

add_action('wp_print_styles', function () {
    wp_enqueue_style('dockedships-widget-common', get_module_css('fishiri/bt-dockedships-widget-front.css'), [], gk_get_rev());
    if (is_dockedships() || is_archive()) {
        wp_enqueue_style('dockedships-common', get_module_css('fishiri/bt-dockedships.css'), [], gk_get_rev());
    }
});

add_action('wp_enqueue_scripts', function () {
    if (is_archive() && get_current_frontpage() == 'maritime') {
        wp_enqueue_script('chart-lib', get_module_js('fishiri/chart.js'), ['jquery'], gk_get_rev(), true);
        wp_enqueue_script('chart-init', get_module_js('fishiri/chart-init.js'), ['jquery', 'chart-lib'], gk_get_rev(), true);
    }
    if (is_dockedships()) {
        wp_enqueue_script('dockedships-manager', get_module_js('fishiri/dockedships-manager.js'), ['jquery'], gk_get_rev(), true);
        wp_enqueue_script('dockedships-component', get_module_js('fishiri/dockedships.js'), ['jquery', 'dockedships-manager'], gk_get_rev(), true);
    }
    if(is_post_edit()) {
        wp_enqueue_script('fix_none_select', get_module_js('fishiri/fix-select.js'), [], false, true);
    }
});

add_action('init', function() {
    add_rewrite_rule('^maritim/opplagsregisteret/ship/(.+)/page/?([0-9]{1,})/?$', 'index.php?__dockedships=1&ship_name=$matches[1]&paged=$matches[2]&category_name=maritim', 'top');
    add_rewrite_rule('^maritim/opplagsregisteret/ship/(.+)/?', 'index.php?__dockedships=1&ship_name=$matches[1]&category_name=maritim', 'top');
    add_rewrite_rule('^maritim/opplagsregisteret/?', 'index.php?__dockedships=1&category_name=maritim', 'top');
    register_taxonomy('ship_name', 'post', [
        'show_ui' => false,
        'show_in_nav_menu' => false,
        'hierarchical' => false,
        'rewrite' => [
            'slug' => 'maritim/opplagsregisteret/ship'
        ],
    ]);
});

add_filter( 'query_vars', function( $vars ) {
    $vars[] = '__dockedships';
    $vars[] = 'ship_name';
    return $vars;
});

add_filter('template_include', function($template) {
    if (get_query_var('__dockedships')) {
        $dockedships_template = 'fishiri/dockedships/';
        if (get_query_var('ship_name')) {
            $dockedships_template .= 'archive';
        } else {
            $dockedships_template .= 'component';
        }

        return get_module_template_path($dockedships_template);
    }
    return $template;
});

add_filter('rwmb_meta_boxes', function($meta_boxes) {
    if(is_post_edit()) {
        $currentShipNames = get_all_ship_names();
        $existingShipNames = get_terms(['hide_empty' => false, 'taxonomy' => 'ship_name']);
        if(count($currentShipNames) > count($existingShipNames)) {
            insert_ship_terms($currentShipNames);
        }
        $prefix = 'rw_';
        $meta_boxes[] = [
            'id'       => 'mentioned_ships',
            'title'    => 'Mentioned ships',
            'pages'    => ['post'],
            'context'  => 'normal',
            'priority' => 'high',
            'fields' => [
                [
                    'name'  => 'Ship name',
                    'id'    => $prefix . 'mentioned_ships',
                    'type'  => 'taxonomy_advanced',
                    'clone'      => true,
                    'taxonomy' => 'ship_name',
                    'field_type' => 'select_advanced',
                    'query_args' => [
                        'hide_empty' => false,
                    ],
                    'placeholder' => "Please select mentioned item",
                    'class' => 'mentioned-ship'
                ],
            ],
        ];
    }
    return $meta_boxes;
});

add_action('wp_head', function() {
    if(get_current_frontpage() == 'maritime') {
        $widgetData = get_docked_ships_widget_data();
        $updated = $widgetData['lastUpdated'];
        $shipTypesData = $widgetData['widgetData'];
        $shipTypes = array_keys($shipTypesData);
        $amount = [];
        foreach ($shipTypesData as $type => $value) {
            if($type != 'Totalt') {
                $amount[] = $value[0];
            }
        }
        nix_localize_script('dockedShipsWidgetData', [
            'types' => array_diff($shipTypes, ['Totalt']),
            'amount' => $amount,
            'total' => $shipTypesData['Totalt'][0],
            'updated' => $updated
        ]);
    }
});

add_action('wp_ajax_get_docked_ships', 'get_docked_ships_objects');
add_action('wp_ajax_nopriv_get_docked_ships', 'get_docked_ships_objects');
add_action('wp_ajax_get_docked_ships_filters', 'get_docked_ships_filters');
add_action('wp_ajax_nopriv_get_docked_ships_filters', 'get_docked_ships_filters');

function insert_ship_terms($shipNames) {
    foreach($shipNames as $ship) {
        wp_insert_term($ship, 'ship_name');
    }
}

function get_ship_data_map() {
    $map_content = get_field('dockedships_head', 'option');
    if(strpos($map_content, 'iframe') !== false)
    {
        $map_content = '<div class="videoWrapper" id="videoWrapper">' . $map_content . '</div>';
    }
    else
    {
        $map_content = '<div class="videoWrapper" id="videoWrapper"><iframe width="800" height="600" scrolling="no" frameborder="no" src="' . $map_content . '"></iframe></div>';
    }
    return $map_content;
}

function is_post_edit() {
    global $pagenow;
    return (is_admin() && 'post.php' == $pagenow || 'post-new.php' == $pagenow);
}

function is_dockedships() {
    return strpos($_SERVER['REQUEST_URI'], 'maritim/opplagsregisteret') !== false;
}

function get_dockedships_articles() {
    $shipName = get_query_var('ship_name');
    return get_connected_dockedships_posts($shipName);
}

function get_connected_dockedships_posts($shipName) {
    return new WP_Query([
        'post_status' => 'publish',
        'orderby' => 'post_modified',
        'order'   => 'DESC',
        'post_type' => 'post',
        'posts_per_page' => 40,
        'meta_query' => [
            [
                'key' => 'rw_mentioned_ships',
                'value' => get_term_id_by_ship_name($shipName),
                'compare' => "RLIKE"
            ]
        ]
    ]);
}

function get_all_ship_names() {
    return perform_docked_ships_request('/names');
}

function get_docked_ships_objects() {
    $params = [
        'noPaging' => $_GET['noPaging'],
        'search' => $_GET['search'],
        'sortby' => $_GET['sortby'],
        'sortdir' => $_GET['sortdir'],
    ];
    $dockedShips = perform_docked_ships_request('?', $params);
    $dockedShips['dockedShips']['items'] = get_docked_ships_articles($dockedShips['dockedShips']['items']);
    wp_send_json_success($dockedShips);
}

function get_docked_ships_filters() {
    wp_send_json_success(perform_docked_ships_request('/filters'));
}

$dockedShipsWidgetData = null;
function get_docked_ships_widget_data() {
    global $dockedShipsWidgetData;
    if(!$dockedShipsWidgetData) {
        $dockedShipsWidgetData = perform_docked_ships_request('/widget'); 
    }
    return $dockedShipsWidgetData;
}

function perform_docked_ships_request($endpoint, $params = []) {
    $fishiriApiBaseUrl = get_field('fishiri_api_base_url', 'option');
    $ch = curl_init();
    $endpointUrl = $fishiriApiBaseUrl . '/api/v1/dockedships' . $endpoint . http_build_query($params);
    curl_setopt($ch, CURLOPT_URL, $endpointUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $endpointData = curl_exec($ch);
    curl_close($ch);
    return json_decode($endpointData, true);
}

function get_docked_ships_articles($ships) {
    foreach ($ships as &$ship) {
        $ship['articles'] = get_connected_dockedships_articles($ship['name']);
    }
    unset($ship);

    return $ships;
}

function get_connected_dockedships_articles($ship) {
    $posts = get_connected_dockedships_articles_objects($ship);
    $connectedArticles = [];
    foreach ($posts as $post) {
        $connectedArticles[] = [
            'link' => get_permalink($post->ID),
            'title' => get_the_title($post->ID),
        ];
    }
    return $connectedArticles;
}

function get_connected_dockedships_articles_objects($ship) {
    $termId = get_term_id_by_ship_name($ship);
    if (!$termId) {
        return [];
    }
    return get_posts(
        [
            'post_status' => 'publish',
            'orderby' => 'post_modified',
            'order'   => 'DESC',
            'post_type'      => 'post',
            'posts_per_page' => 3,
            'meta_query' => [
                [
                    'key' => 'rw_mentioned_ships',
                    'value' => get_term_id_by_ship_name($ship),
                    'compare' => "RLIKE"
                ]
            ]
        ]
    );
}

function get_term_id_by_ship_name($ship) {
    $term = get_term_by('slug', $ship, 'ship_name', ARRAY_A);
    return $term['term_id'];
}
