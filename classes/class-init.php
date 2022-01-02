<?php
/**
 * @package Fse_Blocks;
 * @author Tetsuaki Hamano
 * @license GPL-2.0+
 */

namespace Fse_Blocks;

class Init {

	/**
	 * Constructor
	 */
	public function __construct() {
		// Load translated strings.
		load_plugin_textdomain( FSEB_NAMESPACE );

		// Add admin page
		add_action( 'admin_menu', array( $this, 'add_admin_page' ) );

		// Register blocks.
		add_action( 'init', array( $this, 'register_blocks' ) );

		// Register scripts.
		add_action( 'init', array( $this, 'register_scripts' ) );

		// Uninstallation process.
		register_uninstall_hook( FSEB_NAMESPACE, __NAMESPACE__ . '\Init::plugin_uninstall' );

		// Load classes.
		$this->load_classes();
	}

	/**
	 * Create admin page
	 */
	public function add_admin_page() {
		add_options_page(
			__( 'FSE Blocks', 'fse-blocks' ),
			__( 'FSE Blocks', 'fse-blocks' ),
			'manage_options',
			FSEB_NAMESPACE,
			function () {
				echo '<div id="fse-blocks-admin"></div>';
			},
		);
	}

	/**
	 * Register blocks
	 */
	public function register_blocks() {
		$blocks = array(
			'post-new-label',
			'test',
		);
		foreach ( $blocks as $name ) {
			require_once FSEB_PATH . "/src/blocks/{$name}/index.php";
		}
	}

	/**
	 * Register scripts
	 */
	public function register_scripts() {
		// Register admin page scripts.
		if ( is_admin() ) {
			wp_enqueue_style(
				FSEB_NAMESPACE . '-admin',
				FSEB_URL . '/build/style-admin.css',
				array( 'wp-components' ),
				filemtime( FSEB_PATH . '/build/style-admin.css' ),
			);

			$asset_file = include( FSEB_PATH . '/build/admin.asset.php' );

			wp_enqueue_script(
				FSEB_NAMESPACE . '-admin',
				FSEB_URL . '/build/admin.js',
				$asset_file['dependencies'],
				filemtime( FSEB_PATH . '/build/admin.js' ),
			);

			wp_localize_script(
				FSEB_NAMESPACE . '-admin',
				'fsebObj',
				array(
					'version' => FSEB_VERSION,
					'options' => Settings::get_options(),
				)
			);
		}

		// Load translated strings.
		wp_set_script_translations( FSEB_NAMESPACE, FSEB_NAMESPACE );
	}

	/**
	 * Uninstallation process
	 */
	public static function plugin_uninstall() {
		foreach ( Settings::OPTIONS as $option ) {
			delete_option( $option );
		}
	}

	/**
	 * Load classes
	 */
	public function load_classes() {
		require_once( FSEB_PATH . '/classes/class-settings.php' );
		require_once( FSEB_PATH . '/classes/class-api.php' );
	}
}
