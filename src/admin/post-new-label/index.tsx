/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { ToggleControl } from '@wordpress/components';

/**
 * Internal dependencies
 */
import type { ChildProps } from '../';

const PostNewLabelSetting = ( props: ChildProps ) => {
	const { options, setOptions } = props;

	const handleTestChange = ( value: boolean ) => {
		setOptions( {
			...options,
			post_new_label: {
				...options.post_new_label,
				test: value,
			},
		} );
	};

	return (
		<ToggleControl
			label={ __( 'New Post Label Dummy Item', 'fse-blocks' ) }
			checked={ options.post_new_label.test }
			onChange={ handleTestChange }
		/>
	);
};

export default PostNewLabelSetting;
