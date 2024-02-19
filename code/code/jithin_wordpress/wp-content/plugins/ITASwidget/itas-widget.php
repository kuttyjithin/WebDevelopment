<?php
/**
 *Plugin Name: ITAS widget
 *Description: ITAS 255 Plugin for custom House posts and the custom ITASMapWidget
 *Version:     0.1
 *Author:     Jithin Jose
 */
// security measure to prevent people from running this script directly
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once('ITASSoldWidget.php');

// possibly you want to register some other custom actions here

// register ITASMapWidget
add_action( 'widgets_init', function(){
    register_widget( 'ITASSoldWidget' );
});