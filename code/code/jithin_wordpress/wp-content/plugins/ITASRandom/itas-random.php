<?php
/**
 *Plugin Name: ITAS Random
 *Description: ITAS 255 Plugin for the random pictures
 *Version:     0.1
 *Author:     Jithin Jose
 */
// security measure to prevent people from running this script directly
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once('ITASRandomWidget.php');

// possibly you want to register some other custom actions here

// register ITASMapWidget
add_action( 'widgets_init', function(){
    register_widget( 'ITASRandomWidget' );
});