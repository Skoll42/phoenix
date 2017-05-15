<?php

function bt_archive_get_current_category() {
    $queried_object = $GLOBALS['wp_the_query']->get_queried_object();
    
    if (!is_search() && $queried_object instanceof WP_Term && $queried_object->taxonomy == 'category') {
        return $queried_object;
    }

    if ($queried_object instanceof WP_Post) {
        $queried_object_id = $GLOBALS['wp_the_query']->get_queried_object_id();
        $categories = get_the_category($queried_object_id);
        if (isset($categories[0])) {
            return $categories[0];
        }
    }

    return get_category(get_option('default_category'));
}

function bt_archive_is_default_category($category) {
    $default_category = get_category(get_option('default_category'));

    if ($category instanceof WP_Term) {
        return $category->id == $default_category->id;
    }
    return $category == $default_category->slug;
}

function bt_archive_get_sickfront_ids($type, $category_slug = null) {
    if (!$category_slug) {
        $cat = bt_archive_get_current_category();
        $category_slug = ($cat) ? $cat->slug : '-';
    }
    return Sickfront_DbHelper::get_stack($type, $category_slug);
}

function bt_archive_is_category_fronted($query = null) {
    if (!$query) {
        global $wp_query;
        $query = $wp_query;
    }

    $obj = $query->get_queried_object();
    $has_sickfront = get_field('category_has_sickfront', $obj->taxonomy . '_' . $obj->term_id);

    return bt_archive_is_category_query($query) && $has_sickfront;
}

function bt_archive_is_category_query($query) {
    return $query->is_archive() && $query->is_main_query();
}

function bt_archive_get_category_color($default_color = '#000') {
    if (bt_is_podcast_archive() || get_post_type() == 'podcast') {
        return '#e32128';
    }

    $cat = bt_archive_get_current_category();
    if (!$cat) {
        return $default_color;
    }

    $color = get_field('category_color', $cat->taxonomy . '_' . $cat->term_id);
    if (!$color) {
        return $default_color;
    }

    return $color;
}

function bt_archive_insert_the_post($key, $cols = 12) {
    list($stack_name, $index, $layout) = explode('-', $key, 3);
    if (!$layout) {
        $layout = 'small';
    }

    echo '<div class="col-sm-' . $cols . '">';
    if (bt_archive_the_post($stack_name . '-' . $index)) {
        module_template('theme/article/' . $layout);
    }
    echo '</div>';
}

global $archive_the_post;
$archive_the_post = [];
function bt_archive_the_post($key) {
    global $post;
    global $archive_the_post;

    list($stack_name, $index) = explode('-', $key, 2);

    if (!isset($archive_the_post[$stack_name])) {
        $sickfront_ids = bt_archive_get_sickfront_ids($stack_name);

        if (!$sickfront_ids) {
            if ($stack_name == 'snappet') {
                $query = new WP_Query([
                    'fields' => 'ids',
                    'post_type' => 'snappet',
                    'post_status' => 'publish',
                    'posts_per_page' => 7,
                ]);
                $sickfront_ids = $query->posts;
            } else {
                $sickfront_ids = $GLOBALS['wp_query']->posts;
            }
        }

        $archive_the_post[$stack_name] = $sickfront_ids;
    }

    $post_id = isset($archive_the_post[$stack_name], $archive_the_post[$stack_name][$index])
        ? $archive_the_post[$stack_name][$index]
        : null;

    if (!$post_id) {
        return false;
    }

    $post = get_post($post_id);
    $GLOBALS['wp_query']->setup_postdata($post);

    return true;
}

add_action('pre_get_posts', function($query) {
    if (!is_admin() && bt_archive_is_category_query($query) && !bt_is_podcast_archive_query($query)) {
        $is_fronted = bt_archive_is_category_fronted($query);
        $paged = get_query_var('paged', 1);

        $first_count = $is_fronted ? 6 : 30;
        if ($paged <= 1) {
            $query->set('posts_per_page', $first_count);
        } else {
            $query->set('offset', $first_count + get_option('posts_per_page') * ($paged - 2));
        }

        if ($is_fronted) {
            $category_slug = $query->query['category_name'];
            $sickfront_posts_ids = bt_archive_get_sickfront_ids('main', $category_slug);
            $query->set('post__not_in', $sickfront_posts_ids);
        }
    }
});
