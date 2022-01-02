/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { ToggleControl } from '@wordpress/components';

/**
 * Internal dependencies
 */
import type { ChildProps } from '../';

const TestSetting = ( props: ChildProps ) => {
	const { options, setOptions } = props;

	const handleTestChange = ( value: boolean ) => {
		setOptions( {
			...options,
			test: {
				...options.test,
				test: value,
			},
		} );
	};

	return (
		<ToggleControl
			label={ __( 'Test Dummy Item', 'fse-blocks' ) }
			checked={ options.test.test }
			onChange={ handleTestChange }
		/>
	);
};

export default TestSetting;
