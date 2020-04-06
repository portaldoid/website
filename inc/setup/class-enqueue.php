<?php
/**
 * CSS / JS script management
 *
 * @package pdcovid_theme
 */

namespace Pdcovid_Theme\Setup;

defined( 'ABSPATH' ) || die( 'Can\'t access directly' );

/**
 * Enqueue class
 */
class Enqueue {

	/**
	 * Setup class
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'theme_styles' ], 999 );
		add_action( 'wp_enqueue_scripts', [ $this, 'theme_scripts' ] );
	}

	/**
	 * Enqueue all style that must included to make theme work
	 *
	 * @return void
	 */
	public function theme_styles() {
		wp_enqueue_style(
			'bootstrap',
			PDCOVID_THEME_URL . '/assets/dists/bootstrap/css/bootstrap.min.css',
			[],
			PDCOVID_THEME_VERSION
        );

        wp_enqueue_style(
			'mdbootstrap',
			PDCOVID_THEME_URL . '/assets/dists/bootstrap/css/mdb.min.css',
			[],
			PDCOVID_THEME_VERSION
        );
        wp_enqueue_style(
			'mystyle',
			PDCOVID_THEME_URL . '/assets/dists/bootstrap/css/style.css',
			[],
			PDCOVID_THEME_VERSION
		);

		wp_enqueue_style(
			'jquery-ui-styles',
			'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css',
			[],
			PDCOVID_THEME_VERSION
		);
	}

	/**
	 * Enqueue all scripts that must included to make theme work
	 *
	 * @return void
	 */
	public function theme_scripts() {
        wp_enqueue_script( 'jquery-ui-autocomplete' );
		wp_enqueue_script(
			'fontawesome',
			"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js",
			array(),
			PDCOVID_THEME_VERSION,
			true
		);
		wp_enqueue_script(
			'bootstrap-js',
			PDCOVID_THEME_URL . "/assets/dists/bootstrap/js/bootstrap.bundle.min.js",
			array( 'jquery' ),
			PDCOVID_THEME_VERSION,
			true
		);

        wp_enqueue_script(
			'amcharts',
			"https://www.amcharts.com/lib/4/core.js",
			array( ),
			PDCOVID_THEME_VERSION,
			true
		);
        wp_enqueue_script(
			'amcharts-chart',
			"https://www.amcharts.com/lib/4/charts.js",
			array( 'amcharts' ),
			PDCOVID_THEME_VERSION,
			true
		);
        wp_enqueue_script(
			'amcharts-force-directed',
			"https://www.amcharts.com/lib/4/plugins/forceDirected.js",
			array( 'amcharts' ),
			PDCOVID_THEME_VERSION,
			true
		);
        //
		wp_enqueue_script(
			'amcharts-animated',
			"https://www.amcharts.com/lib/4/themes/animated.js",
			array( 'amcharts' ),
			PDCOVID_THEME_VERSION,
			true
		);
	}

}

new Enqueue();
