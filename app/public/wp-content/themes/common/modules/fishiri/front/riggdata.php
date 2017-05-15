<?php

add_action('wp_print_styles', function () {
    if (get_query_var('__riggdata')) {
        wp_enqueue_style('riggdata-common', get_module_css('fishiri/bt-riggdata.css'), [], gk_get_rev());
    }
});

add_action('wp_enqueue_scripts', function () {
    if (is_single()) {
        wp_enqueue_script('riggdata-cut-names', get_module_js('fishiri/cut-fishiri-names.js'), ['jquery'], gk_get_rev(), true);
    }
    if (is_rigg()) {
        wp_enqueue_script('riggdata-footable', get_module_js('fishiri/riggdata-footable.js'), ['jquery', 'footable-min', 'footable-filter-min', 'footable-sort-min'], gk_get_rev(), true);
        wp_enqueue_script('riggdata-component', get_module_js('fishiri/riggdata.js'), ['jquery', 'riggdata-footable'], gk_get_rev(), true);
    }
});

add_action('init', function () {
    add_rewrite_rule('^offshore/riggsaker/(.+)/(.+)/page/?([0-9]{1,})/?$', 'index.php?__riggdata=1&rigg_cat=$matches[1]&riggname=$matches[2]&paged=$matches[3]&category_name=offshore', 'top');
    add_rewrite_rule('^offshore/riggsaker/(.+)/(.+)/?$', 'index.php?__riggdata=1&rigg_cat=$matches[1]&riggname=$matches[2]&category_name=offshore', 'top');
    add_rewrite_rule('^offshore/riggdata/?$', 'index.php?__riggdata=1&category_name=offshore', 'top');
});

add_filter( 'query_vars', function( $vars ) {
    $vars[] = '__riggdata';
    $vars[] = 'rigg_cat';
    $vars[] = 'riggname';
    return $vars;
});

add_filter('template_include', function($template) {
    if (get_query_var('__riggdata')) {
        $riggdata_template = 'fishiri/riggdata/';
        if (get_query_var('riggname')) {
            $riggdata_template .= 'archive';
        } else {
            $riggdata_template .= (isset($_GET['navn']) ? 'detailed' : 'filter');
        }

        return get_module_template_path($riggdata_template);
    }

    return $template;
});

add_filter('rwmb_meta_boxes', function($meta_boxes) {
    if (is_post_edit()) {
        $currentRiggNames = get_all_riggdata_names();

        $prefix = 'rw_';
        $meta_boxes[] = [
            'id' => 'mentioned_rigs',
            'title' => 'Mentioned rigs',
            'pages' => ['post'],
            'context' => 'normal',
            'priority' => 'high',
            'fields' => [
                [
                    'name' => 'Rigg name',
                    'id' => $prefix . 'mentioned_rigs',
                    'options' => $currentRiggNames,
                    'placeholder' => "Please select mentioned item",
                    'type' => 'select_advanced',
                    'class' => 'mentioned-rigs',
                    'clone' => true,
                ],
            ]
        ];
    }

    return $meta_boxes;
});

function is_riggsaker() {
    return strpos($_SERVER['REQUEST_URI'], 'offshore/riggsaker') !== false;
}

function is_rigg() {
    return strpos($_SERVER['REQUEST_URI'], 'offshore/riggdata') !== false;
}

function is_rigg_filter() {
    return strpos($_SERVER['REQUEST_URI'], 'offshore/riggdata?navn=') !== false;
}

function get_all_riggdata_names() {
    return perform_riggdata_request('/names');
}

function get_riggdata_filters() {
    return perform_riggdata_request('/filters');
}

function get_riggsaker_articles() {
    $riggName = urldecode(get_query_var('riggname'));
    $riggCat = get_query_var('rigg_cat');
    return new WP_Query([
        'paged' => get_query_var('paged'),
        'post_status' => 'publish',
        'orderby' => 'post_modified',
        'order'   => 'DESC',
        'tag' => ($riggCat != 'all' ? $riggCat : null),
        'post_type' => 'post',
        'posts_per_page' => 40,
        'meta_query' => [
            [
                'key' => 'rw_mentioned_rigs',
                'value' => '"' . $riggName . '"',
                'compare' => 'LIKE',
            ]
        ]
    ]);
}

function get_single_riggdata_object() {
    $riggdataItem = perform_riggdata_request('/' . $_GET['navn']);
    $riggdataItem['riggData'] = fix_riggdata_fields($riggdataItem['riggData']);
    $riggdataItem['articles'] = get_connected_riggdata_articles($riggdataItem['riggData']['name']);
    return $riggdataItem;
}

function get_riggdata_by_names($names) {
    $params = [
        'noPaging' => true,
        'names' => $names,
    ];
    $riggdata = perform_riggdata_request('?', $params)['items'];
    return fix_riggdatas($riggdata, true);
}

function get_riggdata_objects() {
    $params = [
        'noPaging' => true
    ];
    $riggdata = perform_riggdata_request('?', $params)['items'];
    return fix_riggdatas($riggdata);
}

function perform_riggdata_request($endpoint, $params = []) {
    $fishiriApiBaseUrl = get_field('fishiri_api_base_url', 'option');
    $ch = curl_init();
    $endpointUrl = $fishiriApiBaseUrl . '/api/v1/riggdata' . str_replace(' ', '%20', $endpoint) . http_build_query($params);
    curl_setopt($ch, CURLOPT_URL, $endpointUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $endpointData = curl_exec($ch);
    curl_close($ch);

    return json_decode($endpointData, true);
}

function get_riggdata_filter_options($filters) {
    $html = '';
    foreach ($filters as $filter) {
        if ($filter != '') {
            $html .= '<option value="' . $filter . '">' . $filter . '</option>';
        }
    }
    return '<option>Alle</option><optgroup label="-------"></optgroup>' . $html;
}

function fix_riggdatas($riggdata, $addArticles = false) {
    foreach ($riggdata as &$item) {
        $item = fix_riggdata_fields($item);
        if($addArticles) {
            $item['articles'] = get_connected_riggdata_articles(!empty($item['name']) ? $item['name'] : $item['riggData']['name']);
        }
    }
    unset($item);
    return $riggdata;
}

function fix_riggdata_fields($item)
{
    $item['day_rate'] = '$0';
    $item['sector'] = 'Unknown';
    $contract = get_active_contract($item);
    if ($contract) {
        $item['comment'] = $contract['comment'];
        $item['day_rate'] = '$' . $contract['day_rate'];
        $item['sector'] = $contract['sector'];
        $item['operator']['name'] = $contract['operator'];
        unset($item['operator']['id'], $item['operator']['deleted_at']);
        return $item;
    }
    return $item;
}

function draw_related_rigs($relatedRigs) {
    foreach ($relatedRigs as $related) {
        echo '<li><a href="?navn=' . $related['rigId'] .'">' . $related['name'] . '</a></li>';
    }
}

function draw_contract_information($contracts) {
    echo format_contract_information($contracts);
}

function format_contract_information($contracts) {
    $html = '';
    foreach ($contracts as $contract) {
        $isActive = $contract['status'] == 'Active';
        $html .= '<tr class="' . ($isActive ? 'active' : '') . '">' .
            '<td>' . ($isActive ? $contract['status'] : '') . '</td>' .
            '<td>' . $contract['operator'] . '</td>' .
            '<td>' . date('d.m.Y', strtotime($contract['contract_started'])) . '</td>' .
            '<td>' . date('d.m.Y', strtotime($contract['contract_expires'])) . '</td>' .
            '<td>$' . $contract['day_rate'] . '</td>' .
            '<td>' . $contract['comment'] . '</td>' .
            '</tr>';
    }
    return $html;
}

function get_active_contract($item) {
    $active_contract = false;
    foreach ($item['contract_information'] as $contract) {
        if ($contract['status'] == 'Active') {
            $active_contract = $contract;
            break;
        }
    }

    return $active_contract;
}

function draw_riggdata_sector_image($sector) {
    $img = sprintf('Sector_%s.png', $sector ? $sector : 'Unknown');
    module_img('fishiri/' . $img);
}

function get_connected_riggdata_category_posts($rigName, $categorySlug = null, $amount = 10) {
    return new WP_Query([
        'post_status' => 'publish',
        'orderby' => 'post_modified',
        'order'   => 'DESC',
        'tag' => $categorySlug,
        'post_type' => 'post',
        'posts_per_page' => $amount,
        'meta_query' => [
            [
                'key' => 'rw_mentioned_rigs',
                'value' => $rigName,
                'compare' => 'LIKE',
            ]
        ]
    ]);
}

function get_connected_riggdata_articles($rigName) {
    $data = [];
    $categories = [
        'all' => 'Siste saker',
        'offshore-kontrakter' => 'Kontrakter',
        'offshore-feltnytt' => 'Feltutvikling',
        'offshore-hms_nytt' => 'HMS',
    ];
    foreach ($categories as $slug => $name) {
        $articles = get_connected_riggdata_category_posts($rigName, ($slug != 'all' ? $slug : null));
        if ($articles) {
            $data[] = [
                'category' => [
                    'name' => $name,
                    'slug' => $slug,
                ],
                'article_query' => $articles,
            ];
        }
    }
    return $data;
}