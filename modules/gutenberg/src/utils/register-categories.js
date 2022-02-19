/**
 * WordPress dependencies
 */
import { getCategories, setCategories } from '@wordpress/blocks';

/**
 * Internal dependencies
 */
import { BrandIcon } from './brand-assets';

export const RegisterCategories = () => {
	setCategories([
		{
			slug: 'shop-maker',
			title: 'Shop Maker',
			icon: BrandIcon,
		},
		...getCategories()
	]);
}

