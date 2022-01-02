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
 * Constants
 */
export const DEFAULT_WIDTH_PC = 50;
export const DEFAULT_WIDTH_PX = 200;
export const DEFAULT_WIDTH_EM = 10;
export const MIN_WIDTH = 50;
export const MIN_WIDTH_UNIT = 'px';

export const MIN_DAY = 1;
export const MAX_DAY = 30;

/**
 *  Register block
 */
const config = {
	icon,
	example,
	edit,
	save: () => {
		return null;
	},
};
registerBlockType( metadata.name, config );
