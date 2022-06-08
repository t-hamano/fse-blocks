<?php
/**
 * Server-side rendering of the `fseb/post-new-label` block.
 *
 * @package Fse_Blocks;
 * @author Aki Hamano
 * @license GPL-2.0+
 */

function fse_blocks_post_new_label_render_block( $attributes, $content, $block ) {
	if ( ! isset( $block->context['postId'] ) ) {
		return '';
	}

	// Get post date timestamp.
	$post_date = get_the_time( 'U', $block->context['postId'] );

	// Create current timestamp in the WP timezone.
	$current_date = wp_date( 'U' );

	// Calculate the number of milliseconds that have elapsed since the publication date.
	$term_seconds = $current_date - $post_date;

	// Whether the number of days elapsed is within the date that is considered a new post.
	$is_new_post = ! isset( $attributes['day'] ) ? true : $term_seconds / 86400 < $attributes['day'];

	if ( ! $is_new_post || empty( $attributes['label'] ) ) {
		return;
	}

	$block_inner_styles     = fse_blocks_post_new_label_styles( $attributes );
	$block_inner_classnames = fse_blocks_post_new_label_classnames_inner( $attributes );

	$block_inner_markup = sprintf(
		'<div class="wp-block-fse-blocks-post-new-label__inner %s" %s>%s</div>',
		$block_inner_classnames,
		$block_inner_styles,
		$attributes['label'],
	);

	$block_classnames   = fse_blocks_post_new_label_classnames( $attributes );
	$wrapper_attributes = get_block_wrapper_attributes( array( 'class' => $block_classnames ) );

	$block_markup = sprintf(
		'<div %s>%s</div>',
		$wrapper_attributes,
		$block_inner_markup,
	);

	return $block_markup;
}

function fse_blocks_post_new_label_classnames( $attributes ) {
	$classnames = array();

	if ( ! empty( $attributes['textAlign'] ) ) {
		$classnames[] = "has-text-align-$attributes[textAlign]";
	}

	if ( ! empty( $attributes['contentJustification'] ) ) {
		$classnames[] = "is-content-justification-$attributes[contentJustification]";
	}

	return implode( ' ', $classnames );
}

function fse_blocks_post_new_label_styles( $attributes ) {
	$styles = array();

	if ( ! empty( $attributes['width'] ) && ! empty( $attributes['widthUnit'] ) ) {
		$styles[] = sprintf(
			'width: %d%s;',
			esc_attr( $attributes['width'] ),
			esc_attr( $attributes['widthUnit'] )
		);
	}

	if ( ! empty( $attributes['style']['spacing']['padding'] ) ) {
		$padding = $attributes['style']['spacing']['padding'];

		if ( ! empty( $padding['top'] ) ) {
			$styles[] = sprintf( 'padding-top: %s;', esc_attr( $padding['top'] ) );
		}
		if ( ! empty( $padding['right'] ) ) {
			$styles[] = sprintf( 'padding-right: %s;', esc_attr( $padding['right'] ) );
		}
		if ( ! empty( $padding['bottom'] ) ) {
			$styles[] = sprintf( 'padding-bottom: %s;', esc_attr( $padding['bottom'] ) );
		}
		if ( ! empty( $padding['left'] ) ) {
			$styles[] = sprintf( 'padding-left: %s;', esc_attr( $padding['left'] ) );
		}
	}

	if ( ! empty( $attributes['style']['spacing']['margin'] ) ) {
		$margin = $attributes['style']['spacing']['margin'];

		if ( ! empty( $margin['top'] ) ) {
			$styles[] = sprintf( 'margin-top: %s;', esc_attr( $margin['top'] ) );
		}
		if ( ! empty( $margin['right'] ) ) {
			$styles[] = sprintf( 'margin-right: %s;', esc_attr( $margin['right'] ) );
		}
		if ( ! empty( $margin['bottom'] ) ) {
			$styles[] = sprintf( 'margin-bottom: %s;', esc_attr( $margin['bottom'] ) );
		}
		if ( ! empty( $margin['left'] ) ) {
			$styles[] = sprintf( 'margin-left: %s;', esc_attr( $margin['left'] ) );
		}
	}

	if ( ! empty( $attributes['style']['border']['width'] ) ) {
		$border_width = $attributes['style']['border']['width'];
		$styles[]     = sprintf( 'border-width: %s;', esc_attr( $border_width ) );
	}

	if ( ! empty( $attributes['style']['border']['radius'] ) ) {
		$border_radius = $attributes['style']['border']['radius'];
		$border_radius = is_numeric( $border_radius ) ? $border_radius . 'px' : $border_radius;
		$border_style  = sprintf( 'border-radius: %s;', esc_attr( $border_radius ) );
		$styles[]      = $border_style;
	}

	if ( ! empty( $attributes['style']['border']['color'] ) ) {
		$border_color = $attributes['style']['border']['color'];
		$styles[]     = sprintf( 'border-color: %s;', esc_attr( $border_color ) );
	}

	if ( ! empty( $attributes['style']['border']['style'] ) ) {
		$border_style = $attributes['style']['border']['style'];
		$styles[]     = sprintf( 'border-style: %s;', esc_attr( $border_style ) );
	}

	if ( ! empty( $attributes['style']['color']['text'] ) ) {
		$styles[] = sprintf( 'color: %s;', esc_attr( $attributes['style']['color']['text'] ) );
	}

	if ( ! empty( $attributes['style']['color']['background'] ) ) {
		$styles[] = sprintf( 'background-color: %s;', esc_attr( $attributes['style']['color']['background'] ) );
	}

	if ( ! empty( $attributes['style']['color']['gradient'] ) ) {
		$styles[] = sprintf( 'background: %s;', $attributes['style']['color']['gradient'] );
	}

	return ! empty( $styles ) ? sprintf( ' style="%s"', implode( ' ', $styles ) ) : '';
}

function fse_blocks_post_new_label_classnames_inner( $attributes ) {
	$classnames = array();

	$has_named_text_color  = ! empty( $attributes['textColor'] );
	$has_custom_text_color = ! empty( $attributes['style']['color']['text'] );

	if ( $has_named_text_color ) {
		$classnames[] = sprintf( 'has-text-color has-%s-color', $attributes['textColor'] );
	} elseif ( $has_custom_text_color ) {
		$classnames[] = 'has-text-color';
	}

	$has_named_background_color  = ! empty( $attributes['backgroundColor'] );
	$has_custom_background_color = ! empty( $attributes['style']['color']['background'] );
	$has_named_gradient          = ! empty( $attributes['gradient'] );
	$has_custom_gradient         = ! empty( $attributes['style']['color']['gradient'] );

	if (
		$has_named_background_color ||
		$has_custom_background_color ||
		$has_named_gradient ||
		$has_custom_gradient
	) {
		$classnames[] = 'has-background';
	}
	if ( $has_named_background_color ) {
		$classnames[] = sprintf( 'has-%s-background-color', $attributes['backgroundColor'] );
	}
	if ( $has_named_gradient ) {
		$classnames[] = sprintf( 'has-%s-gradient-background', $attributes['gradient'] );
	}

	$has_custom_border_color = ! empty( $attributes['style']['border']['color'] );
	$classnames[]            = ! empty( $attributes['borderColor'] ) ? sprintf( 'has-border-color has-%s-border-color', $attributes['borderColor'] ) : '';

	if ( $has_custom_border_color && empty( $attributes['borderColor'] ) ) {
		$classnames[] = 'has-border-color';
	}

	return implode( ' ', $classnames );
}

register_block_type(
	FSEB_PATH . '/build/post-new-label',
	array(
		'render_callback' => 'fse_blocks_post_new_label_render_block',
	)
);
