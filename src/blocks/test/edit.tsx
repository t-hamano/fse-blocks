/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
// @ts-ignore: has no exported member
import { InspectorControls, BlockControls, useBlockProps } from '@wordpress/block-editor';
import type { BlockEditProps } from '@wordpress/blocks';

/**
 * Internal dependencies
 */
import './editor.scss';
import type { BlockAttributes } from './BlockAttributes';

export default function PostNewLabelEdit( props: BlockEditProps< BlockAttributes > ) {
	const { attributes, setAttributes } = props;

	const onChangeLabel = ( value: string ) => {
		setAttributes( { content: value } );
	};

	const blockProps = useBlockProps();

	return <div { ...blockProps }>Post New Label</div>;
}
