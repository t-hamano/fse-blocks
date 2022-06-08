<?php
/**
 * Server-side rendering of the `fseb/post-archive-link` block.
 *
 * @package Fse_Blocks;
 * @author Aki Hamano
 * @license GPL-2.0+
 */

function fse_blocks_post_archive_link_render_block( $attributes, $content, $block ) {
	return sprintf(
		'<div %1$s>%2$s</div>',
		get_block_wrapper_attributes(),
		'Post Archive Link'
	);
}

register_block_type(
	FSE_BLOCKS_PATH . '/build/post-archive-link',
	array(
		'render_callback' => 'fse_blocks_post_archive_link_render_block',
	)
);
