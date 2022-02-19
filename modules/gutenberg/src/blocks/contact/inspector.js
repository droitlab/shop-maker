/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { Fragment } from '@wordpress/element';
import { InspectorControls } from '@wordpress/block-editor';
import { 
	TextControl,
	PanelBody, 
} from '@wordpress/components';

/**
 * Inspector controls
 */
const Inspector = ( props ) => {
	const {
		clientId,
		attributes,
		className,
		isSelected,
		setAttributes
	} = props;
	
	const {
		text
	} = attributes

	return (
		<Fragment>
			<InspectorControls>
				<PanelBody	
					title={ __( "Contact", 'frontrom' ) } 
					initialOpen={ false }
				>
					<TextControl
						label={ __( 'Text' ) }
						value={ text }
						onChange={ textValue => {
							setAttributes( { text: textValue } );
						} }
					/>
				</PanelBody>
			</InspectorControls>
		</Fragment>
	)
}

export default Inspector;
