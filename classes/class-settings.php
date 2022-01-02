<?php
/**
 * @package Fse_Blocks;
 * @author Tetsuaki Hamano
 * @license GPL-2.0+
 */

namespace Fse_Blocks;

class Settings {

	// Default options.
	const OPTIONS = array(
		'post_new_label' => array(
			'test' => array(
				'type'    => 'boolean',
				'default' => true,
			),
		),
		'test'           => array(
			'test' => array(
				'type'    => 'boolean',
				'default' => true,
			),
		),
	);

	/**
	 * Constructor
	 */
	public function __construct() {
	}

	/**
	 * Get options
	 *
	 * @return array
	 */
	public static function get_options() {
		$options = array();

		// Override default options with option values.
		foreach ( Settings::OPTIONS as $key => $items ) {
			$default_option = array();
			$current_option = array();

			foreach ( $items as $item_key => $item_value ) {
				$default_option[ $item_key ] = $item_value['default'];
			}
			$current_options = (array) get_option( FSEB_NAMESPACE . '_' . $key );

			$options[ $key ] = array_merge( $default_option, $current_option );
		}

		return $options;
	}
}

new Settings();
