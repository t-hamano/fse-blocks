<?php
/**
 * Server-side rendering of the `fseb/post-new-label` block.
 *
 * @package Fse_Blocks;
 * @author Tetsuaki Hamano
 * @license GPL-2.0+
 */

function render_block_fseb_post_new_label( $attributes, $content, $block ) {
	$wrapper_attributes = get_block_wrapper_attributes();

	return sprintf(
		'<div %s>New Post Label</div>',
		$wrapper_attributes,
	);
}

$hoge = register_block_type_from_metadata(
	FSEB_PATH . '/src/blocks/post-new-label',
	array(
		'render_callback' => 'render_block_fseb_post_new_label',
	)
);
