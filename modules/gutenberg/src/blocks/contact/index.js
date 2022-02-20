/**
 * Internal dependencies
 */
import edit from './edit';
import metadata from './block';


/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

/**
 * Block Meta Data.
 */
const { name, category } = metadata;

/**
 * Block Attributes.
 */
const attributes = {
	...metadata.attributes,
};

/**
 * Block Properties.
 */
const settings = {
	title: __( 'Contact', 'frontrom' ),
	attributes,
	supports: {
		inserter: true,
	},
	getEditWrapperProps: ( attributes ) => {
		
	},
	edit
};

export { name, category, settings };
