<?php
/**
 * Nod
 *
 * @package pdcovid_theme
 */

namespace Pdcovid_Modules\Post;
defined( 'ABSPATH' ) || die( 'Can\'t access directly' );

/**
 * Class Setup
 */
class Setup {

	/**
	 * Class constructor
	 */
	public function __construct() {
        add_action( 'init', [ $this, 'change_postname_to_penyalur'] );
        add_action( 'init', [ $this, 'change_cat_to_tempat_salur'] );
        add_action( 'init', [ $this, 'register_taxonomy' ] );

        add_action( 'wp_enqueue_scripts', [ $this, 'post_scripts' ] );
	}

    public function change_postname_to_penyalur( $translated ) {
        $get_post_type = get_post_type_object('post');

        $labels = $get_post_type->labels;
        $labels->name = 'Penyalur';
        $labels->singular_name = 'Penyalur';
        $labels->add_new = 'Add Penyalur';
        $labels->add_new_item = 'Add Penyalur';
        $labels->edit_item = 'Edit Penyalur';
        $labels->new_item = 'Penyalur';
        $labels->view_item = 'View Penyalur';
        $labels->search_items = 'Search Penyalur';
        $labels->not_found = 'No Penyalur found';
        $labels->not_found_in_trash = 'No Penyalur found in Trash';
        $labels->all_items = 'All Penyalur';
        $labels->menu_name = 'Penyalur';
        $labels->name_admin_bar = 'Penyalur';
    }

    public function change_cat_to_tempat_salur( $translated ) {
        global $wp_taxonomies;
        $labels = &$wp_taxonomies['category']->labels;
        $labels->name = 'Fokus Daerah';
        $labels->singular_name = 'Fokus Daerah';
        $labels->add_new = 'Add Daerah';
        $labels->add_new_item = 'Add Daerah';
        $labels->edit_item = 'Edit Daerah';
        $labels->new_item = 'Daerah';
        $labels->view_item = 'View Daerah';
        $labels->search_items = 'Search Daerah';
        $labels->not_found = 'No Daerah found';
        $labels->not_found_in_trash = 'No Daerah found in Trash';
        $labels->all_items = 'All Daerah';
        $labels->menu_name = 'Daerah';
        $labels->name_admin_bar = 'Daerah';
    }

    /**
	 * Register taxonomy.
	 */
	public function register_taxonomy() {
        // Unregister taxonomy
        unregister_taxonomy_for_object_type('post_tag', 'post');

        // Target
		$labels = array(
			'name'              => __( 'Target', 'pdcovid_theme' ),
			'singular_name'     => __( 'Target', 'pdcovid_theme' ),
			'search_items'      => __( 'Search Target', 'pdcovid_theme' ),
			'all_items'         => __( 'All Target', 'pdcovid_theme' ),
			'parent_item'       => __( 'Parent Target', 'pdcovid_theme' ),
			'parent_item_colon' => __( 'Parent Target:', 'pdcovid_theme' ),
			'edit_item'         => __( 'Edit Target', 'pdcovid_theme' ),
			'update_item'       => __( 'Update Target', 'pdcovid_theme' ),
			'add_new_item'      => __( 'Add New Target', 'pdcovid_theme' ),
			'new_item_name'     => __( 'New Target Name', 'pdcovid_theme' ),
			'menu_name'         => __( 'Target', 'pdcovid_theme' ),
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

		register_taxonomy( 'target', array( 'post' ), $args );


        $type_labels = array(
			'name'              => __( 'Tipe Donasi', 'pdcovid_theme' ),
			'singular_name'     => __( 'Tipe Donasi', 'pdcovid_theme' ),
			'search_items'      => __( 'Search Tipe Donasi', 'pdcovid_theme' ),
			'all_items'         => __( 'All Tipe Donasi', 'pdcovid_theme' ),
			'parent_item'       => __( 'Parent Tipe Donasi', 'pdcovid_theme' ),
			'parent_item_colon' => __( 'Parent Tipe Donasi:', 'pdcovid_theme' ),
			'edit_item'         => __( 'Edit Tipe Donasi', 'pdcovid_theme' ),
			'update_item'       => __( 'Update Tipe Donasi', 'pdcovid_theme' ),
			'add_new_item'      => __( 'Add New Tipe Donasi', 'pdcovid_theme' ),
			'new_item_name'     => __( 'New Tipe Donasi Name', 'pdcovid_theme' ),
			'menu_name'         => __( 'Tipe Donasi', 'pdcovid_theme' ),
		);

		$type_args = array(
			'hierarchical'      => true,
            'show_in_rest'      => true,
			'labels'            => $type_labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'query_var'         => true,
			'has_archive'       => true,
		);

		register_taxonomy( 'tipe_donasi', array( 'post' ), $type_args );
	}

    public function post_scripts() {
        wp_register_script(
            'post-script',
            PDCOVID_THEME_URL . '/assets/js/posts.js',
            array('jquery'),
            '',
            true
        );
        wp_localize_script('post-script', 'post', array(
            'ajaxurl'  => admin_url('admin-ajax.php'),
            'action'  => 'get_daerah'
        ));

        wp_enqueue_script('post-script');

        // if( is_front_page() ) {
        //     wp_register_script(
        //         'post-graph-script',
        //         PDCOVID_THEME_URL . '/assets/js/post-graph.js',
        //         array('jquery'),
        //         '',
        //         true
        //     );
        //     wp_localize_script('post-graph-script', 'postgraph', array(
        //         'ajaxurl'  => admin_url('admin-ajax.php'),
        //         'action'  => 'get_graph_data'
        //     ));
        //
        //     wp_enqueue_script('post-graph-script');
        // }
    }

}

new Setup();
