<?php
/**
 * Plugin Name: FSE Blocks
 * Description: WordPress plugin that provide useful blocks for full site editing.
 * Requires at least: 5.8
 * Requires PHP: 7.3
 * Version: 0.1.0
 * Author: Tetsuaki Hamano
 * Author URI: https://github.com/t-hamano
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: fse-blocks
 *
 * @package Fse_Blocks
 * @author Tetsuaki Hamano
 * @license GPL-2.0+
 */

defined( 'ABSPATH' ) || exit;

$fseb_data = get_file_data(
	__FILE__,
	array(
		'Version' => 'Version',
	)
);

define( 'FSEB_VERSION', $fseb_data['Version'] );
define( 'FSEB_NAMESPACE', 'fseb' );
define( 'FSEB_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'FSEB_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );

require_once __DIR__ . '/classes/class-init.php';

new Fse_Blocks\Init();
