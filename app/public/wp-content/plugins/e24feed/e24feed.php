<?php
/*
Plugin Name: e24feed
Description: -
Author: N-iX
Version: 0.1
*/

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

class e24Feed
{
    protected $hook_name_grab = 'get_e24feed';
    protected $table_name;
    protected $feed_url;
    protected $e24_url;

    /**
     * @var wpdb
     */
    protected $wpdb;

    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table_name = $this->wpdb->prefix . 'e24feed';
        $this->feed_url = get_field('e24_feed_url', 'option');
        $this->e24_url = get_field('e24_website_url', 'option');

        register_activation_hook( __FILE__, array($this, 'plugin_activation') );
        register_deactivation_hook( __FILE__, array($this, 'plugin_deactivation') );

        add_action( $this->hook_name_grab, array($this, 'grab') );
    }

    public function plugin_activation() {
        $this->create_table();
        $extra_seconds = 60;
        wp_schedule_event( time() + $extra_seconds, 'hourly', $this->hook_name_grab );
    }

    public function plugin_deactivation() {
        $this->remove_table();
        wp_clear_scheduled_hook( $this->hook_name_grab );
    }

    protected function create_table() {
        $sql = "CREATE TABLE IF NOT EXISTS " . $this->table_name . " (
			`id` INT(10) NOT NULL AUTO_INCREMENT,
			`article_data` LONGTEXT,
			`date_created` DATETIME NOT NULL,
			PRIMARY KEY (`id`)
        ) COLLATE='utf8_general_ci' ENGINE=InnoDB";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    protected function remove_table() {
        $this->wpdb->query("DROP TABLE IF EXISTS `" . $this->table_name . "`");
    }

    public function grab() {
        $data = $this->grab_data();
        $this->insert_data($data);
        $this->clear_old_data();
    }

    protected function insert_data($data) {
        $res = $this->wpdb->query(sprintf("INSERT INTO `" . $this->table_name . "`(article_data, date_created) VALUES('%s', '%s')",
            esc_sql(serialize($data)), current_time('mysql')));

        if( is_wp_error( $res ) ) {
            throw new Exception(__CLASS__ . ': ' . $res->get_error_message());
        }

        return true;
    }

    protected function grab_data() {
        try {
            $http = new WP_Http_Curl();
            $response = $http->request($this->feed_url);
            $items = json_decode($response['body'], true);
        } catch (Exception $e) {
            return [];
        }

        $articles = [];

        $i = 0;
        foreach ($items as $article) {
            $articles[$i]['article_title'] = $article['title'];
            $articles[$i]['article_url'] = $this->e24_url . $article['slug'];

            $description = array();

            foreach ($article['rawContent']['blocks'] as $description_item) {
                $description[] = $description_item['text'];
            }
            $articles[$i]['article_description'] = implode("\n\n", $description);

            $i++;
        }
        return $articles;
    }

    public function clear_old_data() {
        $num = (int)$this->wpdb->get_var("SELECT COUNT(*) FROM `" . $this->table_name . "`");

        if ($num > 1) {
            $this->wpdb->query(sprintf("DELETE FROM `" . $this->table_name . "` ORDER BY date_created LIMIT %d",
                $num - 1));
        }
    }

    public function get_feed() {
        $feed = $this->wpdb->get_row("SELECT article_data FROM `" . $this->table_name . "` ORDER BY date_created DESC LIMIT 1", ARRAY_A);
        return unserialize($feed['article_data']);
   }

}

global $e24feed;
$e24feed = new e24Feed();

function get_e24feed() {
    global $e24feed;
    return $e24feed->get_feed();
}

if( function_exists('acf_add_options_page') ) {
    $parent = acf_add_options_page(array(
        'page_title' => 'E24Feed Settings',
        'menu_title' => 'E24Feed Settings',
        'menu_slug' => 'e24feed-settings',
        'redirect' => false
    ));
}