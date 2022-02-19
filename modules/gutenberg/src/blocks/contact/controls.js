/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { Component, Fragment } from '@wordpress/element';
import { BlockControls } from '@wordpress/block-editor';
import { Toolbar } from '@wordpress/components';
import { createBlock } from '@wordpress/blocks';
import { select, dispatch } from '@wordpress/data';

const Controls = ( props ) => {
	const {
		clientId,
		attributes,
		setAttributes,
	} = props;

	const toolbarControls = [
		{
			icon: 'plus',
			title: __( 'Add Row', 'frontrom' ),
			isActive: false,
			onClick: () => { 
				let column = createBlock( 'frontrom/row' );
				let block = select( 'core/block-editor' ).getBlock( clientId );
				let index = block.innerBlocks.length;
				
				dispatch('core/block-editor').insertBlock( column, index+1, clientId );
			}
		}
	];

	return (
		<Fragment>
			<BlockControls>
				<Toolbar controls={ toolbarControls } />
			</BlockControls>
		</Fragment>
	);
}

export default Controls;
