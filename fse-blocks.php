<?php
/**
 * Plugin Name: FSE Blocks
 * Description: WordPress plugin that provide useful blocks for full site editor.
 * Requires at least: 5.8
 * Requires PHP: 7.3
 * Version: 0.1.0
 * Author: Aki Hamano
 * Author URI: https://github.com/t-hamano
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: fse-blocks
 *
 * @package Fse_Blocks
 * @author Aki Hamano
 * @license GPL-2.0+
 */

defined( 'ABSPATH' ) || exit;

define( 'FSEB_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );

// Register blocks.
function fse_blocks_enqueue_editor_scripts() {
	$blocks = array(
		'post-archive-link',
		'post-meta',
		'post-new-label',
		'post-permalink',
		'post-reading-time',
		'post-share-links',
	);
	foreach ( $blocks as $name ) {
		require_once FSEB_PATH . "/build/{$name}/index.php";
	}
}
add_action( 'init', 'fse_blocks_enqueue_editor_scripts' );
