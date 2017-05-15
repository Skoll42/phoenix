<?php

class IteraNames
{
    public function __construct()
    {
        add_action( 'init', array($this, 'init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
        add_action('template_redirect', array($this, 'template_redirect'));
    }

    public function template_redirect()
    {
        if (isset($_POST['action']) && $_POST['action'] == 'names-add-new' && wp_verify_nonce( $_POST['_wpnonce'], 'names-add-new' )) {

            require_once( ABSPATH . 'wp-admin/includes/image.php' );
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
            require_once( ABSPATH . 'wp-admin/includes/media.php' );

            $postarr = array(
                'post_type' => 'name',
                'post_status' => get_option('names_auto_approve') ? 'publish' : 'pending',
                'post_title' => $_POST['name'],
                'post_excerpt' => $_POST['excerpt'],
            );
            $postID = wp_insert_post($postarr);

            update_field('email', $_POST['email'], $postID);
            update_field('employer', $_POST['employer'], $postID);

            $attachment_id = media_handle_upload( 'avatar', $postID );
            if ( is_wp_error( $attachment_id ) ) {
                // There was an error uploading the image.
            } else {
                add_post_meta($postID, '_thumbnail_id', $attachment_id);
            }
            setcookie('nytt_om_nawn_created', 'true', time() + (12000), "/");
            wp_redirect($_POST['redirect_url']); // add a hidden input with get_permalink()
            die();
        }
    }

    public function init()
    {
        register_post_type('name',
            array(
                'labels' => array(
                    'name' => __('Names'),
                    'singular_name' => __('Name'),
                    'add_new_item' => __('Add New Name'),
                    'edit_item' => __('Edit Name'),
                ),
                'show_ui' => true,
                'rewrite' => false,
                'supports' => array(
                    'title',
                    'thumbnail',
                    'excerpt',
                ),
            )
        );
    }

    public function admin_menu()
    {
        $page = add_submenu_page( 'edit.php?post_type=name', 'Options', 'Options', 'manage_options', 'names-options', array($this, 'displayOptionPage') );

        add_action('load-' . $page, array($this,'load'));
    }

    public function load()
    {
        if( isset($_POST['nonce']) && wp_verify_nonce($_POST['nonce'], 'names-add') )
        {
            $auto_approve = $_POST['auto_approve'] ? 1 : 0;
            update_option('names_auto_approve', $auto_approve );
        }

    }

    public function displayOptionPage()
    {
        $auto_approve = get_option('names_auto_approve');

        ?>
            <div class="wrap"><div id="icon-tools" class="icon32"></div>
                <h2>Names options</h2>
                <form method="post">
                    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce( 'names-add' ); ?>" />
                    <div class="wp-box">
                        <div class="title">
                            <h3>General</h3>
                        </div>
                        <table class="form-table">
                            <tr>
                                <th class="row">
                                    <label>Auto-approve</label>
                                </th>
                                <td>
                                    <input type="hidden" name="auto_approve" value="0" />
                                    <input type="checkbox" name="auto_approve" value="1"<?php echo $auto_approve ? ' checked="checked"' : ''; ?> />
                                </td>
                            </tr>
                        </table>
                        <?php submit_button('Save') ?>
                    </div>
                </form>

            </div>
        <?php
    }
}
$iteraNamesPlugin = new IteraNames();
