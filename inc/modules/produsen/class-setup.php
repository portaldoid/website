<?php
/**
 * Nod
 *
 * @package pdcovid_theme
 */

namespace Pdcovid_Modules\Produsen;
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
		add_action( 'init', [ $this, 'register_taxonomy' ] );
	}

    /**
	 * Register custom post types
	 *
	 * @return void
	 */
	public function register_post_types() {
		$labels = array(
			'name'               => __( 'Produsen', 'geip_theme' ),
			'singular_name'      => __( 'Produsen', 'geip_theme' ),
			'add_new'            => __( 'Add New', 'geip_theme' ),
			'add_new_item'       => __( 'Add New Produsen', 'geip_theme' ),
			'edit_item'          => __( 'Edit Produsen', 'geip_theme' ),
			'new_item'           => __( 'New Produsen', 'geip_theme' ),
			'view_item'          => __( 'View Produsen', 'geip_theme' ),
			'search_items'       => __( 'Search Produsen', 'geip_theme' ),
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
			'menu_icon'           => 'dashicons-image-crop',
			'show_in_rest'		  => true,
            'taxonomies'          => array( 'category' ),
			'supports'            => array( 'title', 'editor', 'thumbnail' )
		);

		register_post_type( 'produsen', $args );
	}

	/**
	 * Register taxonomy.
	 */
	public function register_taxonomy() {

        // Produksi
		$labels = array(
			'name'              => __( 'Produksi', 'pdcovid_theme' ),
			'singular_name'     => __( 'Produksi', 'pdcovid_theme' ),
			'search_items'      => __( 'Search Produksi', 'pdcovid_theme' ),
			'all_items'         => __( 'All Produksi', 'pdcovid_theme' ),
			'parent_item'       => __( 'Parent Produksi', 'pdcovid_theme' ),
			'parent_item_colon' => __( 'Parent Produksi:', 'pdcovid_theme' ),
			'edit_item'         => __( 'Edit Produksi', 'pdcovid_theme' ),
			'update_item'       => __( 'Update Produksi', 'pdcovid_theme' ),
			'add_new_item'      => __( 'Add New Produksi', 'pdcovid_theme' ),
			'new_item_name'     => __( 'New Produksi Name', 'pdcovid_theme' ),
			'menu_name'         => __( 'Produksi', 'pdcovid_theme' ),
		);

		$args = array(
			'hierarchical'      => true,
            'show_in_rest'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'query_var'         => true,
			'has_archive'       => true,
		);

		register_taxonomy( 'tipe_produksi', array( 'produsen' ), $args );
	}
}

new Setup();
