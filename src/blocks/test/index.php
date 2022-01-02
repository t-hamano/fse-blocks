<?php
/**
 * Server-side rendering of the `fseb/test` block.
 *
 * @package Fse_Blocks;
 * @author Tetsuaki Hamano
 * @license GPL-2.0+
 */

function render_block_fseb_test( $attributes, $content, $block ) {
	$wrapper_attributes = get_block_wrapper_attributes();

	return sprintf(
		'<div %s>Test</div>',
		$wrapper_attributes,
	);
}

register_block_type_from_metadata(
	FSEB_PATH . '/src/blocks/test',
	array(
		'render_callback' => 'render_block_fseb_test',
	)
);
