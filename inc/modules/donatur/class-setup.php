<?php
/**
 * Nod
 *
 * @package pdcovid_theme
 */

namespace Pdcovid_Modules\Donatur;
defined( 'ABSPATH' ) || die( 'Can\'t access directly' );

/**
 * Class Setup
 */
class Setup {

	/**
	 * Class constructor
	 */
	public function __construct() {
        add_action( 'init', [ $this, 'register_post_types' ], 20 );
	}

    /**
	 * Register custom post types
	 *
	 * @return void
	 */
	public function register_post_types() {
		$labels = array(
			'name'               => __( 'Donatur', 'geip_theme' ),
			'singular_name'      => __( 'Donatur', 'geip_theme' ),
			'add_new'            => __( 'Add New', 'geip_theme' ),
			'add_new_item'       => __( 'Add New Donatur', 'geip_theme' ),
			'edit_item'          => __( 'Edit Donatur', 'geip_theme' ),
			'new_item'           => __( 'New Donatur', 'geip_theme' ),
			'view_item'          => __( 'View Donatur', 'geip_theme' ),
			'search_items'       => __( 'Search Donatur', 'geip_theme' ),
			'not_found'          => __( 'Nothing found', 'geip_theme' ),
			'not_found_in_trash' => __( 'Nothing found in Trash', 'geip_theme' ),
		);

		$args = array(
			'labels'              => $labels,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'has_archive'         => false,
			'exclude_from_search' => false,
			'capability_type'     => 'post',
			'hierarchical'        => false,
			'rewrite'             => false,
			'menu_position'       => 9,
			'menu_icon'           => 'dashicons-networking',
			'show_in_rest'		  => true,
			'supports'            => array( 'title', 'editor', 'thumbnail' )
		);

		register_post_type( 'donatur', $args );
	}
}

new Setup();
