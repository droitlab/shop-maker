/**
 * Internal dependencies
 */
import Inspector from './inspector';
import Controls from './controls';


/**
 * External dependencies
 */
import classnames from 'classnames';

/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { Component, Fragment } from '@wordpress/element';


/**
 * Block edit function
 */
const Edit = ( props ) => {
	const {
		clientId,
		attributes,
		className,
		isSelected,
		setAttributes
	} = props

	const {
		text
	} = attributes

	return (
		<Fragment>
			{ isSelected && <Inspector { ...props }  /> }
			{ isSelected && <Controls { ...props } /> }
			<h1>{ text }</h1>
		</Fragment>
	)
}

export default Edit;
