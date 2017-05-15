<?php

add_action('wp_print_styles', function () {
    if (is_felt()) {
        wp_enqueue_style('feltdata-front', get_module_css('fishiri/bt-feltdata.css'), [], gk_get_rev());
    }
});

add_action('wp_enqueue_scripts', function () {
    if (is_felt()) {
        wp_enqueue_script('feltdata-footable', get_module_js('fishiri/footable-init-felt.js'), ['jquery', 'footable-min', 'footable-filter-min', 'footable-sort-min'], gk_get_rev(), true);
        wp_enqueue_script('feltdata-feltdata', get_module_js('fishiri/feltdata.js'), ['jquery', 'feltdata-footable'], gk_get_rev(), true);
        if(!is_felt_filter()) {
            wp_enqueue_script('chart-lib', get_module_js('fishiri/chart.js'), ['jquery'], gk_get_rev(), true);
            wp_enqueue_script('feltdata-chart', get_module_js('fishiri/feltdata-chart.js'), ['jquery', 'feltdata-feltdata', 'chart-lib'], gk_get_rev(), true);
        }
    }
});

add_action('init', function() {
    add_rewrite_rule('^offshore/feltsaker/(.+)/(.+)/page/?([0-9]{1,})/?$', 'index.php?__feltdata=1&felt_cat=$matches[1]&feltname=$matches[2]&paged=$matches[3]&category_name=offshore', 'top');
    add_rewrite_rule('^offshore/feltsaker/(.+)/(.+)/?$', 'index.php?__feltdata=1&felt_cat=$matches[1]&feltname=$matches[2]&category_name=offshore', 'top');
    add_rewrite_rule('^offshore/feltdata/?$', 'index.php?__feltdata=1&category_name=offshore', 'top');
});

add_action('init', function () {
    if(isset($GLOBALS['FooTable'])) {
        remove_action('wp_print_footer_scripts', [$GLOBALS['FooTable'], 'inline_dynamic_js']);
    }
});

add_filter( 'query_vars', function( $vars ) {
    $vars[] = '__feltdata';
    $vars[] = 'felt_cat';
    $vars[] = 'feltname';
    return $vars;
});

add_filter( 'template_include', function($template) {
    if (get_query_var('__feltdata')) {
        $feltdata_template = 'fishiri/feltdata/';
        if (get_query_var('feltname')) {
            $feltdata_template .= 'archive';
        } else {
            $feltdata_template .= (isset($_GET['navn']) ? 'detailed' : 'filter');
        }

        return get_module_template_path($feltdata_template);
    }
    return $template;
});

add_filter('rwmb_meta_boxes', function($meta_boxes) {
    if (is_post_edit()) {
        $currentFeltNames = get_all_feltdata_names();

        $prefix = 'rw_';
        $meta_boxes[] = [
            'id'       => 'mentioned_felt',
            'title'    => 'Mentioned Felt',
            'pages'    => ['post'],
            'context'  => 'normal',
            'priority' => 'high',

            'fields' => [
                [
                    'name'  => 'Felt name',
                    'id'    => $prefix . 'mentioned_felt',
                    'options' => $currentFeltNames,
                    'placeholder' => "Please select mentioned item",
                    'type' => 'select_advanced',
                    'class' => 'mentioned-felt',
                    'clone' => true,
                ],
            ]
        ];

    }

    return $meta_boxes;
});

add_action('wp_head', function() {
    if(is_felt() && !is_felt_filter()) {
        $feltData = get_single_feltdata_object();
        nix_localize_script('feltWidgetData', [
            'types' => ['Invested', 'Remaining'],
            'amount' => [
                $feltData['feltData']['investments']['so_far_investments'],
                $feltData['feltData']['investments']['remaining_investments']
            ]
        ]);
    }
});

function is_felt() {
    return strpos($_SERVER['REQUEST_URI'], 'offshore/feltdata') !== false;
}

function is_felt_filter() {
    return strpos($_SERVER['REQUEST_URI'], 'offshore/feltdata?navn=') !== false;
}

function is_feltsaker() {
    return strpos($_SERVER['REQUEST_URI'], 'offshore/feltsaker') !== false;
}

function get_feltsaker_articles() {
    $feltName = urldecode(get_query_var('feltname'));
    $feltCat = get_query_var('felt_cat');
    return new WP_Query([
        'paged' => get_query_var('paged'),
        'post_status' => 'publish',
        'orderby' => 'post_modified',
        'order'   => 'DESC',
        'tag' => ($feltCat != 'all' ? $feltCat : null),
        'post_type' => 'post',
        'posts_per_page' => 40,
        'meta_query' => [
            [
                'key' => 'rw_mentioned_felt',
                'value' => '"' . $feltName . '"',
                'compare' => 'LIKE',
            ]
        ]
    ]);
}

function get_felt_icon($status) {
    $imgs = [
        'PDO APPROVED' => 'checkmark.svg',
        'SHUT DOWN' => 'close.svg',
        'FUTURE PROJECTS' => 'arrow.svg',
    ];

    $img = array_key_exists($status, $imgs) ? $imgs[$status] : 'gear.svg';
    insert_svg('fishiri/' . $img);
}

function perform_feltdata_request($endpoint, $params = []) {
    $fishiriApiBaseUrl = get_field('fishiri_api_base_url', 'option');
    $ch = curl_init();
    $endpointUrl = $fishiriApiBaseUrl . '/api/v1/feltdata' . str_replace(' ', '%20', $endpoint) . http_build_query($params);
    curl_setopt($ch, CURLOPT_URL, $endpointUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $endpointData = curl_exec($ch);
    curl_close($ch);

    return json_decode($endpointData, true);
}

function get_all_feltdata_names() {
    return perform_feltdata_request('/names');
}

function get_feltdata_by_names($names) {
    $params = [
        'noPaging' => true,
        'names' => $names
    ];
    $feltdata = perform_feltdata_request('?', $params)['items'];
    return add_feltdata_articles($feltdata);
}

function get_feltdata_filters() {
    return perform_feltdata_request('/filters');
}

function draw_feltdata_sector_image($feltSector) {
    $img = sprintf('Sector_%s.png', $feltSector ? $feltSector : 'Unknown');
    module_img('fishiri/' . $img);
}

function get_feltdata_objects() {
    $params = [
        'noPaging' => true
    ];
    $feltdata = perform_feltdata_request('?', $params)['items'];
    return $feltdata;
}

$feltdataItem = null;
function get_single_feltdata_object() {
    global $feltdataItem;
    if(!$feltdataItem) {
        $feltdataItem = perform_feltdata_request('/' . $_GET['navn']);
        $feltdataItem['articles'] = get_connected_feltdata_articles($feltdataItem['feltData']['name']);
    }
    return $feltdataItem;
}

function pretty_number_format($number) {
    return isset($number) ? number_format(floatval(str_replace(",", "", $number)), 0, null, " ") : 0;
}

function format_money($money) {
    return 'kr ' . pretty_number_format($money);
}

function add_feltdata_articles($feltdata) {
    foreach ($feltdata as &$item) {
        $item['articles'] = get_connected_feltdata_articles(!empty($item['name']) ? $item['name'] : $item['feltData']['name']);
    }
    unset($item);
    return $feltdata;
}

function get_connected_feltdata_category_posts($feltName, $categorySlug = null, $amount = 10) {
    return new WP_Query([
        'post_status' => 'publish',
        'orderby' => 'post_modified',
        'order'   => 'DESC',
        'tag' => $categorySlug,
        'post_type' => 'post',
        'posts_per_page' => $amount,
        'meta_query' => [
            [
                'key' => 'rw_mentioned_felt',
                'value' => '"' . $feltName . '"',
                'compare' => 'LIKE',
            ]
        ]
    ]);
}

function get_connected_feltdata_articles($feltName) {
    $data = [];

    $categories = [
        'all' => 'Siste saker',
        'offshore-kontrakter' => 'Kontrakter',
        'offshore-feltnytt' => 'Feltutvikling',
        'offshore-hms_nytt' => 'HMS',
    ];
    foreach ($categories as $slug => $name) {
        $articles = get_connected_feltdata_category_posts($feltName, ($slug != 'all' ? $slug : null));
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