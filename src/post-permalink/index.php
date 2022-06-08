<?php
/**
 * Server-side rendering of the `fseb/post-permalink` block.
 *
 * @package Fse_Blocks;
 * @author Aki Hamano
 * @license GPL-2.0+
 */

function fse_blocks_post_permalink_render_block( $attributes, $content, $block ) {
	return sprintf(
		'<div %1$s>%2$s</div>',
		get_block_wrapper_attributes(),
		'Post Permalink'
	);
}

register_block_type(
	FSEB_PATH . '/build/post-permalink',
	array(
		'render_callback' => 'fse_blocks_post_permalink_render_block',
	)
);
