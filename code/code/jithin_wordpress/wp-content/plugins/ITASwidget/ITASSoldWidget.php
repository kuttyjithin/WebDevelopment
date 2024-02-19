<?php
/**
 * Created by PhpStorm.
 * User: Jithin Jose
 * Date: 2019-10-21
 * Time: 10:50 AM
 */
class ITASSoldWidget extends WP_Widget {

    // class constructor
    public function __construct() {
        $widget_ops = array(
            'classname' => 'ITASSoldWidget',
            'description' => 'A plugin for a sold widget',
        );
        parent::__construct( 'ITASSoldWidget', 'ITAS Sold Widget', $widget_ops );

    }

    // output the widget content on the front-end
    public function widget( $args, $instance ) {
        echo "<br><br><h2 style='color: red'>Houses SOLD By jj.Com</h2> One of the two houses sold in Nanaimo is by Remax not this!<h3>";

        // haven't tested this.. but ordering by date will be something like:
        $post_list = get_posts( array(
            'orderby'    => 'post_date',
            'sort_order' => 'desc'
        ) );

        $count = 0;
        foreach ( $post_list as $post ) {
            $print = "<br>ID: " . $post->ID . " <br>Title: " . $post->post_title;
            ?>
            <p> <?php echo "$print"; ?></p>
            <a href="http://localhost:8000/?p=<?php echo $post->ID ?>">Link </a>
            

            <?php
            $count++;
            if($count > 5)
            {
                break;
            }
            // now for each post - maybe echo out some html with the title and price sold,
            // and echo out an anchor tag (href) to the 'permalink' showing the house details.

            // if you echo out details for a sold house, increment the $count variable
            // once you get to $count == 5, call return or break the loop as we only need to
            // display max 5 houses that were sold
        }
        echo "</h3>";
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
