<?php

/**
 * Adding a single page template for newsletters
 *
 */
class NewsletterTemplate {

    public function __construct( ) {
        // Filter the single_template with our custom function
        add_filter('single_template', array($this, 'single_template'), 999);
        add_filter( 'archive_template', array($this, 'archive_template'), 999) ;

    }

	public function single_template($single)
    {
        global $post;

        /* Checks for single template by post type */
        if ( $post->post_type == 'newsletter' ) {
            if ( file_exists( PICTS_NEWSLETTERS_PLUGIN_URI . 'templates/single-newsletter.php' ) ) {
                return PICTS_NEWSLETTERS_PLUGIN_URI . 'templates/single-newsletter.php';
            }
        }

        return $single;
    }



    function archive_template( $archive_template ) {
        global $post;

        if (is_archive() && $post->post_type == 'newsletter') {
            if ( file_exists( PICTS_NEWSLETTERS_PLUGIN_URI . 'templates/archive-newsletter.php' ) ) {
                $archive_template = PICTS_NEWSLETTERS_PLUGIN_URI.'templates/archive-newsletter.php';
            }
        }

        return $archive_template;
    }



}
new NewsletterTemplate;