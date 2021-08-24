<?php

/**
 *
*/

if ( !class_exists( 'Create_Post_Type' )) {
  class Create_Post_Type {

    private $file;

    private $properties;

    private $labels;

    private $args;

    public function __construct( $file )
    {
      $this->file = $file;
    }

    public function set_properties( $properties )
    {
      $this->properties = $properties;
    }

    public function initialize()
    {
      // Runs when plugin is initialized
      register_post_type( 'post_type', array($this, 'post_type_builder') );
    }

    public function post_type_builder() {
      // Register Custom Post Type
      $this->set_labels();
  	  register_post_type( 'post_type', $this->$args );
    }

    public function set_labels()
    {
      // Set all arguments
    	$this->$labels = array(
    		'name'                  => _x( $this->properties['plural_label'], 'Post Type General Name', 'picts' ),
    		'singular_name'         => _x( $this->properties['singular_label'], 'Post Type Singular Name', 'picts' ),
    		'menu_name'             => __( $this->properties['plural_label'], 'picts' ),
    		'name_admin_bar'        => __( $this->properties['singular_label'], 'picts' ),
    		'archives'              => __( $this->properties['singular_label'] . ' Archives', 'picts' ),
    		'attributes'            => __( $this->properties['singular_label'] . ' Attributes', 'picts' ),
    		'parent_item_colon'     => __( 'Parent ' . $this->properties['singular_label'] . .':', 'picts' ),
    		'all_items'             => __( 'All ' . $this->properties['plural_label'], 'picts' ),
    		'add_new_item'          => __( 'Add New ' . $this->properties['singular_label'], 'picts' ),
    		'add_new'               => __( 'Add New', 'picts' ),
    		'new_item'              => __( 'New Item', 'picts' ),
    		'edit_item'             => __( 'Edit Item', 'picts' ),
    		'update_item'           => __( 'Update Item', 'picts' ),
    		'view_item'             => __( 'View Item', 'picts' ),
    		'view_items'            => __( 'View Items', 'picts' ),
    		'search_items'          => __( 'Search Item', 'picts' ),
    		'not_found'             => __( 'Not found', 'picts' ),
    		'not_found_in_trash'    => __( 'Not found in Trash', 'picts' ),
    		'featured_image'        => __( 'Featured Image', 'picts' ),
    		'set_featured_image'    => __( 'Set featured image', 'picts' ),
    		'remove_featured_image' => __( 'Remove featured image', 'picts' ),
    		'use_featured_image'    => __( 'Use as featured image', 'picts' ),
    		'insert_into_item'      => __( 'Insert into item', 'picts' ),
    		'uploaded_to_this_item' => __( 'Uploaded to this item', 'picts' ),
    		'items_list'            => __( 'Items list', 'picts' ),
    		'items_list_navigation' => __( 'Items list navigation', 'picts' ),
    		'filter_items_list'     => __( 'Filter items list', 'picts' ),
    	);
    	$this->$args = array(
    		'label'                 => __( $this->properties['singular_label'], 'picts' ),
    		'description'           => __( $this->properties['description'], 'picts' ),
    		'labels'                => $labels,
    		'supports'              => $this->properties['supports'],
    		'taxonomies'            => $this->properties['taxonomies'],
    		'hierarchical'          => false,
    		'public'                => true,
    		'show_ui'               => true,
    		'show_in_menu'          => true,
    		'menu_position'         => 5,
    		'show_in_admin_bar'     => true,
    		'show_in_nav_menus'     => true,
    		'can_export'            => true,
    		'has_archive'           => true,
    		'exclude_from_search'   => false,
    		'publicly_queryable'    => true,
    		'capability_type'       => 'post',
    	);
    }

  }

}

new Create_Post_Type();
