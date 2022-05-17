<?php

/**
 * Adding Gutenberg Blocks for the Newletters.
 *
 */

function picts_newsletter_render_callback( $block_attributes, $content ) {
    $recent_posts = wp_get_recent_posts( array(
        'numberposts' => 1,
        'post_status' => 'publish',
    ) );
    if ( count( $recent_posts ) === 0 ) {
        return 'No posts';
    }
    $post = $recent_posts[ 0 ];
    $post_id = $post['ID'];
    return sprintf(
        '<a class="wp-block-my-plugin-latest-post" href="%1$s">%2$s</a>',
        esc_url( get_permalink( $post_id ) ),
        esc_html( get_the_title( $post_id ) )
    );
}

function picts_newsletter_block() {
    // automatically load dependencies and version
//    $asset_file = include( plugin_dir_path( __FILE__ ) . 'build/index.asset.php');

    wp_register_script(
        'picts-newsletter-block',
        plugins_url( 'build/block.js', __FILE__ ),
//        $asset_file['dependencies'],
//        $asset_file['version']
    );

    register_block_type( 'picts-newsletter/newsletter-block', array(
        'api_version' => 2,
        'editor_script' => 'picts-newsletter-block',
        'render_callback' => 'picts_newsletter_render_callback',
        "attributes" => array(
            "title" => array(
                "type" => "string"
            ),
            "numberofposts" => array(
                "type" => "number"
            ),
            "background" => array(
                "type" => "string"
            ),
        ),

    ) );

}
add_action( 'init', 'picts_newsletter_block' );
