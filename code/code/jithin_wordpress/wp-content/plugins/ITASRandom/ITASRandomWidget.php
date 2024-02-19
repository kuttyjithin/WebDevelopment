<?php
/**
 * Created by PhpStorm.
 * User: Jithin Jose
 * Date: 2019-10-21
 * Time: 10:50 AM
 */
require_once ('Database.php');
class ITASRandomWidget extends WP_Widget {

    // class constructor
    public function __construct() {
        $widget_ops = array(
            'classname' => 'ITASRandomWidget',
            'description' => 'A plugin for a Random widget',
        );
        parent::__construct( 'ITASRandomWidget', 'ITAS Random Widget', $widget_ops );

    }

    // output the widget content on the front-end
    public function widget( $args, $instance ) {
        /*$db = Database::connect();
        //$sql= "SELECT `post_content` FROM `wp_posts` WHERE post_status = 'publish' ORDER BY RAND() LIMIT 1";
        $imageid = $db->get_var($db->prepare("SELECT ID FROM wp_posts WHERE post_type='revision' AND post_mime_type LIKE 'image/%' AND post_parent=$postid ORDER BY RAND() LIMIT 1"));
        if ($imageid) {
            echo wp_get_attachment_image( $imageid, 'full' );
        }
        else {
            return false;
        }*/


    }
    /*function fetch_random_img($postid='') {
        $wpdb = Database::connect();

        if (empty($postid))
        {
            //we are going for random post and random image
            $postid = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_status = 'publish' ORDER BY RAND() LIMIT 1");
        }
        $imageid = $wpdb->get_var($wpdb->prepare("SELECT ID FROM wp_posts WHERE post_type='attachment' AND post_mime_type LIKE 'image/%' AND post_parent=$postid ORDER BY RAND() LIMIT 1"));
        if ($imageid) {
            echo wp_get_attachment_image( $imageid, 'full' );
        }
        else {
            return false;
        }

    }*/



    // output the option form field in admin Widgets screen
    public function form( $instance ) {

        // TODO - this is for the widget admin interface, we will be adding support for options later
    }

    // save options
    public function update( $new_instance, $old_instance ) {

        // TODO - this allows the admin options to update
        // see:
    }
}
