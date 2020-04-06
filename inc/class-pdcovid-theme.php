<?php
/**
 * Main IVA class
 *
 * @package pdcovid_theme
 */

defined( 'ABSPATH' ) || die( 'Can\'t access directly' );

/**
 *
 *
 * @class PDCOVID_THEME
 */
class pdcovid_theme {

	/**
	 * A dummy constructor to ensure the class is only initialized once
	 */
	public function __construct() {

		/* Do nothing here */

	}


	/**
	 * The real constructor to initialize Limit Login
	 *
	 * @return void
	 */
	public function initialize() {
		global $wpdb;

		$theme = wp_get_theme();

		// vars.
		$this->settings = array(

			// basic.
			'name'    => $theme->get( 'Name' ),
			'domain'  => $theme->get( 'TextDomain' ),
			'version' => $theme->get( 'Version' ),

			// urls.
			'file'    => __FILE__,
			'path'    => get_stylesheet_directory(),
			'url'     => get_stylesheet_directory_uri(),

		);

		// constants.
		$this->define( 'PDCOVID_THEME_URL', $this->settings['url'] );
		$this->define( 'PDCOVID_THEME_DIR', $this->settings['path'] );
		$this->define( 'PDCOVID_THEME_VERSION', $this->settings['version'] );

		$this->define( 'IVA_MODULES_URL', PDCOVID_THEME_URL . '/inc/modules' );
		$this->define( 'IVA_MODULES_DIR', PDCOVID_THEME_DIR . '/inc/modules' );

		// load all files.
		$this->loader(
			[
				PDCOVID_THEME_DIR . '/inc/setup/*.php',
				PDCOVID_THEME_DIR . '/inc/modules/*/autoload.php',
			]
		);

		// theme activated.
		add_action( 'after_switch_theme', [ $this, 'activate_theme' ], 10, 2 );

		// theme deactivated.
		add_action( 'switch_theme', [ $this, 'deactivate_theme' ], 10, 3 );

		// actions.
		add_action( 'init', [ $this, 'init' ], 5 );
	}

	/**
	 * Load files
	 *
	 * @param  array $files_path Path of file location.
	 * @return void
	 */
	private function loader( $files_path ) {
		foreach ( $files_path as $path ) {
			foreach ( glob( $path ) as $file ) {
				require_once $file;
			}
		}
	}

	/**
	 * This function will run once when theme activated
	 *
	 * @param  string           $oldname Old theme name.
	 * @param  WP_Theme|boolean $oldtheme WP_Theme instance of old theme.
	 * @return void
	 */
	public function activate_theme( $oldname, $oldtheme = false ) {
		/**
		 * You can create new database table in here.
		 *
		 * @link https://codex.wordpress.org/Creating_Tables_with_Plugins
		 */

		flush_rewrite_rules();
	}

	/**
	 * This function will run once when theme deactivated
	 *
	 * @param  string   $new_name New theme name.
	 * @param  WP_Theme $new_theme WP_Theme instance of new theme.
	 * @param  WP_Theme $old_theme WP_Theme instance of old theme.
	 * @return void
	 */
	public function deactivate_theme( $new_name, $new_theme, $old_theme ) {
		/**
		 * You can delete database table in here.
		 *
		 * @link https://codex.wordpress.org/Creating_Tables_with_Plugins
		 */

		flush_rewrite_rules();
	}

	/**
	 * This function will run after all plugins and theme functions have been included
	 *
	 * @return void
	 */
	public function init() {

		// textdomain.
		$this->load_plugin_textdomain();

	}


	/**
	 * This function will load the textdomain file
	 *
	 * @return void
	 */
	public function load_plugin_textdomain() {

		// vars.
		load_theme_textdomain( 'pdcovid_theme', PDCOVID_THEME_DIR . '/languages' );

	}


	/**
	 * This function will safely define a constant
	 *
	 * @param string $name Constant name.
	 * @param mixed  $value Constant value.
	 * @return mixed
	 */
	public function define( $name, $value = true ) {
		if ( ! defined( $name ) ) {
			// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.VariableConstantNameFound
			define( $name, $value );
		}
	}


	/**
	 * This function will return a value from the settings array found in this object
	 *
	 * @param  string $name Setting name.
	 * @param  mixed  $value Default value to return if setting not found.
	 * @return mixed
	 */
	public function get_setting( $name, $value = null ) {

		// check settings.
		if ( isset( $this->settings[ $name ] ) ) {

			$value = $this->settings[ $name ];

		}

		// return.
		return $value;

	}

}
