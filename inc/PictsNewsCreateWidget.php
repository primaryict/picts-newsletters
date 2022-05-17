<?php

/**
 * Register a widget to display the newsletters in the side bars.
 */
class PictsNewsCreateWidget extends WP_Widget {

    /**
     * Constructor.
     */
    public function __construct() {

        $widget_options = array (
            'classname' => 'picts_newsletter_display_widget',
            'description' => 'Add a call to action box with your own text and link.'
        );

        parent::__construct( 'picts_newsletter_display_widget', 'Display Newsletters', $widget_options );

    }

    //function to define the data saved by the widget
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['numberOfListings'] = strip_tags( $new_instance['numberOfListings'] );
        //$instance['link'] = strip_tags( $new_instance['link'] );
        return $instance;

    }


    //function to output the widget form

    function form( $instance ) {

        // Check values
        if( $instance) {
            $title = esc_attr($instance['title']);
            $numberOfListings = esc_attr($instance['numberOfListings']);
        } else {
            $title = '';
            $numberOfListings = '';
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'realty_widget'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('numberOfListings'); ?>"><?php _e('Number of Listings:', 'realty_widget'); ?></label>
            <select id="<?php echo $this->get_field_id('numberOfListings'); ?>"  name="<?php echo $this->get_field_name('numberOfListings'); ?>">
                <?php for($x=1;$x<=10;$x++): ?>
                    <option <?php echo $x == $numberOfListings ? 'selected="selected"' : '';?> value="<?php echo $x;?>"><?php echo $x; ?></option>
                <?php endfor;?>
            </select>
        </p>

    <?php }




    //function to display the widget in the site

    function widget( $args, $instance ) {
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        $numberOfListings = $instance['numberOfListings'];
        echo $before_widget;
        if ( $title ) {
            echo $before_title . $title . $after_title;
        }
        $this->getRealtyListings($numberOfListings);
        echo $after_widget;
    }

    // Query WP_Query to get the HTML for the widget
    function getRealtyListings($numberOfListings) { //html

        global $post;
        //add_image_size( 'realty_widget_size', 85, 45, false );
        $listings = new WP_Query();
        $listings->query('post_type=newsletter&amp;posts_per_page=' . $numberOfListings );

        if($listings->found_posts > 0) {

            echo '<ul class="realty_widget">';
            while ($listings->have_posts()) {
                $listings->the_post();
                //$image = (has_post_thumbnail($post->ID)) ? get_the_post_thumbnail($post->ID, 'realty_widget_size') : '<div class="noThumb"></div>';
                //$listItem = '<li>' . $image;
                $listItem = '<li>';
                $listItem .= '<a href="' . get_permalink() . '">';
                $listItem .= get_the_title() . '</a>';
                $listItem .= '</li>';
                echo $listItem;
            }
            echo '</ul>';
            wp_reset_postdata();
        } else {
            echo '<p style="padding:25px;">No listing found</p>';
        }
    }
}

new PictsClassCreateWidget();

//function to register the widget
function picts_newsletter_create_widget() {

    register_widget( 'PictsNewsCreateWidget' );

}
add_action( 'widgets_init', 'picts_newsletter_create_widget' );
