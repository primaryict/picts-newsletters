<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Primary ICT Support - School Newsletters
 * Plugin URI:        www.primaryictsupport.co.uk
 * Description:       Primary ICT Support plugin to display newsletters
 * Version:           0.0.2
 * Author:            John Emmett
 * Author URI:        www.primaryictsupport.co.uk
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

// Set up plugin constants
define( 'PICTS_NEWSLETTERS_PLUGIN_DIR', plugin_dir_url( __FILE__ ) );
define( 'PICTS_NEWSLETTERS_PLUGIN_URI', plugin_dir_path( __FILE__ ) );
define( 'PICTS_NEWSLETTERS_BASENAME', plugin_basename(__FILE__) );


/**
 * Loading Classes.
 **/

// GIT HUB Updater
if( ! class_exists( 'Picts_Updater' ) ){
    include_once( plugin_dir_path( __FILE__ ) . 'inc/updater/updater.php' );
}

$updater = new Picts_Updater( __FILE__ );
$updater->set_username( 'primaryict' );
$updater->set_repository( 'picts-newsletters' );
$updater->initialize();

// Register post type
if( ! class_exists( 'Create_Post_Type' ) ){
    include_once( plugin_dir_path( __FILE__ ) . 'inc/CreatePostType.php' );
}

$newsletter = new Create_Post_Type( __FILE__ );
$newsletter->set_properties( array(
        'post_type'       => 'newsletter',
        'singular_label'  => 'Newsletter',
        'plural_label'    => 'Newsletters',
        'description'     => 'Post type to display newsletters',
        'supports'        => array('title'),
        'taxonomies'      => array('category'),
    )
);
$newsletter->initialize();

// Register Meta Box
if( ! class_exists( 'Add_Meta_Box' ) ){
    include_once( plugin_dir_path( __FILE__ ) . 'inc/AddMetaBox.php' );
}

// Change page template for single Newsletter
if( ! class_exists( 'NewsletterTemplate' ) ){
    include_once( plugin_dir_path( __FILE__ ) . 'inc/NewsletterTemplate.php' );
}

// Change page template for single Newsletter
if( ! class_exists('PictsNewsCreateWidget') ){
    include_once( plugin_dir_path( __FILE__ ) . 'inc/PictsNewsCreateWidget.php' );
}

// Adding Gutenberg Blocks - Removed for now using short code
//if( ! class_exists( 'PictsNewsGutenBlocks' ) ){
//    include_once( plugin_dir_path( __FILE__ ) . 'block/PictsNewsGutenBlocks.php' );
//}

// Change page template for single Newsletter
if( ! class_exists( 'PictsNewsCreateShortcode' ) ){
    include_once( plugin_dir_path( __FILE__ ) . 'inc/PictsNewsCreateShortcode.php' );
}

$picts_newsletter_settings = plugin_dir_path( __FILE__ ) . '/admin/inc/settings-page/settings-page.php';
if ( is_readable( $picts_newsletter_settings ) ) {
    require_once $picts_newsletter_settings;
}

