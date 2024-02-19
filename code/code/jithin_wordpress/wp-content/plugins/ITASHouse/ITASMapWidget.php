<?php
/**
 * Created by PhpStorm.
 * User: Jithin Jose
 * Date: 2019-10-21
 * Time: 10:50 AM
 */
class ITASMapWidget extends WP_Widget {

    // class constructor
    public function __construct() {
        $widget_ops = array(
            'classname' => 'ITASMapWidget',
            'description' => 'A plugin for a google map',
        );
        parent::__construct( 'ITASMapWidget', 'ITAS Map Widget', $widget_ops );

    }

    // output the widget content on the front-end
    public function widget( $args, $instance ) {
       //echo " ";
        echo " Hello ITAS Map Widget! by Jthin Jose";

        ?>
        <!doctype html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Pokemon Nanaimo Map!</title>
            <script
                src="https://code.jquery.com/jquery-3.4.1.min.js"
                integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
                crossorigin="anonymous">
            </script>
            <!-- old version of JQuery! -->
            <!-- <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script> -->
            <script>

                var map;

                function initMap() {
                    var nanaimo = {lat: 49.159700, lng: -123.907750};
                    map = new google.maps.Map(document.getElementById('map'), {
                        zoom: 13,
                        center: nanaimo
                    });
        <?php
        $post_list = get_posts( array(
            'orderby'    => 'menu_order',
            'sort_order' => 'asc'
        ) );

        $posts = array();

        foreach ( $post_list as $post ) {

            // grab the post id and title
            $print = "ID: " . $post->ID . " Title: " . $post->post_title;

            // we have to retrieve the custom field as 'meta' data
            $print .= " Lat: " . get_post_meta($post->ID, 'lat', true);

            $lat = get_post_meta($post->ID, 'lat', true);
            $long = get_post_meta($post->ID, 'long', true);

           // echo "<script>";
            // the n is the newline character to format how the JavaScript looks when we 'View Source'

            echo "\nconsole.log('Post info: $print')";
           echo "\nvar myLatlng = new google.maps.LatLng($lat, $long);";
           echo "\nvar marker =new google.maps.Marker({ position:myLatlng, title :'".$post->post_title."'})";
            echo "\nmarker.setMap(map);";
            // you'll need to also Create the marker
            // Add the marker to the google map variable with the setMap function

            //echo "</script>";
        }
            ?>

        }



        //var marker= new google.maps.Marker({position: uluru, map: map});


            </script>
        </head>

        <body>

        <br>
        <div id="map" style="width: 800px; height: 600px"></div>
       <!-- <a href="#" id="get-data">Attack! (one round)</a>
        <br>
        <a href="#" id="reset">Reset</a>
        <br>
        <a href="makepokemon.php" id="get-data">Fight with uour pokemon</a>-->

        <div id="show-data"></div>

        <!-- NOTE this google map is using an ITAS Google Map key! Do not use for any of your private applications hosted live anywhere-->
        <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCBqf_E1hYDcO8e7PMkoQ3Q4VbZ-jJZ7DE&callback=initMap">
        </script>


        </body>
        </html>
      <?php

        // TODO - either echo out or turn php off and insert the Google Map code from lab 1
        // After you've output the JavaScript and html divs etc. for the Google Map, turn php back on
    }

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
