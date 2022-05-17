<?php

/**
 * Adding a shortcode for displaying newsletters in a coloured box on the site.
 */
class PictsNewsCreateShortcode {

    public function __construct( ) {
        //equeue scripts and styles
        add_action( 'wp_enqueue_scripts', array($this, 'picts_newsletter_scripts_loader') );
        // Add shortcode
        add_shortcode( 'picts_newsletters', array($this,'shortcode_newsletter_function') );

    }

    function shortcode_newsletter_function($atts, $content, $tag)
    {
        $result="";

        $a = shortcode_atts( array(
            'numberofposts' => '5',
            'id' => 'newsletterlist',
            'bgcolor' => '#efefef',
            'title' => 'Button',
            'fontcolor' => '#333',
            'icon' => 'fa-link'
        ), $atts );

        $query_args = array(
            'posts_per_page' => 10,
            'post_type' => 'newsletter',
            'published_status' => 'published'
        );
        
        $query = new WP_Query($query_args);

        //echo "<pre>". var_export($query, true). "</pre>";
        if($query->have_posts()) :

            $result = '<div class="newsletter-display" style="background-color: '.$a['bgcolor'].';color:'.$a['fontcolor'].';">';
            $result .= '<h3 class="title" style="color:'.$a['fontcolor'].';">'.$a['title'].'</h3>';
            $result .= '<ul class="newletters">';

            while($query->have_posts()) :
                $query->the_post();

                $result .= '<li class="newsletter-posts"><a href="'.get_permalink( get_the_ID() ).'" title="' . get_the_title() . '" style="color:'.$a['fontcolor'].';"><span class="fa '.$a['icon'].'"></span> ' . get_the_title() . '</a></li>';

            endwhile;

            $result .= '</ul>';
            $result .= '</div>';

            wp_reset_postdata();
        endif;

        return $result;
    }

    function picts_newsletter_scripts_loader() {

        // 1. Styles.
        wp_enqueue_style( 'picts-newsletter-list', PICTS_NEWSLETTERS_PLUGIN_DIR . 'assets/css/picts-newsletter-display.css');
        wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/solid.min.css');

        // 2. Scripts.
//        wp_enqueue_script( 'picts-subpages-js', plugin_dir_url( __FILE__ ) . 'assets/js/picts-subpages.js', array(), false, true );


    }


}
new PictsNewsCreateShortcode;