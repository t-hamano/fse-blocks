<?php
/**
 * @package Fse_Blocks
 * @author Tetsuaki Hamano
 * @license GPL-2.0+
 */

namespace Fse_Blocks;

use WP_Error;
use WP_REST_Response;

class Api {

	/**
	 * Constructor
	 */
	public function __construct() {
		// Register REST API route.
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	/**
	 * Register REST API route
	 */
	public function register_routes() {

		register_rest_route(
			FSEB_NAMESPACE . '/v1',
			'/option',
			array(
				array(
					'methods'             => 'POST',
					'callback'            => array( $this, 'update_options' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
				array(
					'methods'             => 'DELETE',
					'callback'            => array( $this, 'delete_options' ),
					'permission_callback' => function () {
						return current_user_can( 'manage_options' );
					},
				),
			)
		);
	}

	/**
	 * Update option
	 *
	 * @return WP_REST_Response
	 */
	public function update_options( $request ) {
		$params = $request->get_json_params();

		// Sanitize option values.
		foreach ( $params as $key => $items ) {
			if ( ! array_key_exists( $key, Settings::OPTIONS ) ) {
				continue;
			}

			$item_values = array();

			foreach ( $items as $item_key => $item_value ) {
				if ( ! array_key_exists( $item_key, Settings::OPTIONS[ $key ] ) ) {
					continue;
				}

				if ( 'boolean' === Settings::OPTIONS[ $key ][ $item_key ]['type'] ) {
					$item_value = $item_value ? 1 : 0;
				}
				$item_values[ $item_key ] = $item_value;
			}

			update_option( FSEB_NAMESPACE . '_' . $key, $item_values );
		}

		return rest_ensure_response(
			array(
				'type'    => 'success',
				'message' => __( 'Setting saved.', 'fse-blocks' ),
			)
		);
	}

	/**
	 * Delete option
	 *
	 * @return WP_REST_Response
	 */
	public function delete_options() {
		foreach ( Settings::OPTIONS as $key => $value ) {
			delete_option( FSEB_NAMESPACE . '_' . $key );
		}

		return rest_ensure_response(
			array(
				'options' => Settings::get_options(),
				'type'    => 'success',
				'message' => __( 'Settings have been restored.', 'fse-blocks' ),
			)
		);
	}
}

new Api();
