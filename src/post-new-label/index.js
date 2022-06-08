/**
 * WordPress dependencies
 */
import { registerBlockType } from '@wordpress/blocks';

/**
 * Internal dependencies
 */
import './style.scss';
import metadata from './block.json';
import example from './example';
import { Icon as icon } from './icon';
import edit from './edit';

/**
 *  Register block
 */
const config = {
	icon,
	example,
	edit,
	save: () => null,
};
registerBlockType( metadata.name, config );
