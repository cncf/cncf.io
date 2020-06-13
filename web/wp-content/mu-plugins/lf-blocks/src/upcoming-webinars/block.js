/**
 * Register block JS
 *
 * @package WordPress
 * @since 1.0.0
 *
 * @tags
 * @phpcs:disable WordPress.WhiteSpace.OperatorSpacing.NoSpaceAfter
 * @phpcs:disable WordPress.WhiteSpace.OperatorSpacing.NoSpaceBefore
 * @phpcs:disable Generic.WhiteSpace.ScopeIndent.IncorrectExact
 * @phpcs:disable Generic.WhiteSpace.ScopeIndent.Incorrect
 * @phpcs:disable PEAR.Functions.FunctionCallSignature.Indent
 */

// Import CSS.
import './editor.scss';
import './style.scss';

import Edit from './edit.js';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

/**
 * Register: aa Gutenberg Block.
 *
 * Registers a new block provided a unique name and an object defining its
 * behavior. Once registered, the block is made editor as an option to any
 * editor interface where blocks are implemented.
 *
 * @link https://wordpress.org/gutenberg/handbook/block-api/
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully registered; otherwise `undefined`.
 */
registerBlockType(
	 'lf/upcoming-webinars',
	{
		title: __( 'LF | Upcoming Webinars' ),
		description: __( 'Block showing upcoming webinars' ),
		icon: 'video-alt3',
		category: 'lf',
		keywords: [
			__( 'webinars' ),
			__( 'upcoming' ),
			__( 'lf' ),
		],
		styles: [
			{
				name: 'vertical',
				label: __( 'Vertical' ),
				isDefault: true,
			},
			{
				name: 'horizontal',
				label: __( 'Horizontal' ),
			},
		],
		example: {},
		attributes: {
			numberposts: {
				type: 'integer',
				default: 4,
			},
		},
		html: false,
		edit: Edit,
		save() {
			return null;
		},
	}
);
