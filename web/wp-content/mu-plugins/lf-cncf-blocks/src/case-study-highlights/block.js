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
 * Register: Gutenberg Block.
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
	'lf/case-study-highlights',
	{
		title: __( 'LF | Case Study Highlights' ),
		description: __( 'A highlighted area in the page to showcase the results and changes in Case Studies' ),
		icon: 'grid-view',
		category: 'cncf',
		keywords: [
			__( 'case study' ),
			__( 'metrics' ),
			__( 'highlights' ),
			__( 'cncf' ),
		],
		example: {
			attributes: {
				headingText01: 'DEPLOYMENT TIME',
				smallerText01: 'Went from an hour to minutes',
			} },
		attributes: {
			headingText01: {
				type: 'string',
				default: '',
			},
			headingText02: {
				type: 'string',
				default: '',
			},
			headingText03: {
				type: 'string',
				default: '',
			},
			smallerText01: {
				type: 'string',
				default: '',
			},
			smallerText02: {
				type: 'string',
				default: '',
			},
			smallerText03: {
				type: 'string',
				default: '',
			},
		},
		html: false,
		edit: Edit,
		save() {
			return null;
		},
	}
);
