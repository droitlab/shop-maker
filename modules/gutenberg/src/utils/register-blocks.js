// Register Blocks
import * as contact from '../blocks/contact/index';

/**
 * WordPress dependencies
 */
 import { registerBlockType } from '@wordpress/blocks';

/**
 * Function to register an individual block.
 *
 * @param {Object} block The block to be registered.
 *
 */
const registerBlock = ( block ) => {
	if ( ! block ) {
		return;
	}

	const { name, settings } = block;
	
	registerBlockType( `sh-maker/${name}`, {
		category: 'shop-maker',
		...settings,
	} );
};

/**
 * Function to register blocks provided by CoBlocks.
 */
export const RegisterBlocks = () => {
	[
		contact
	].forEach( registerBlock );
};















