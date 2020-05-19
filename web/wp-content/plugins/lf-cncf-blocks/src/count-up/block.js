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
import Save from './save.js';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

const blockIcon = (
	<svg height="20" viewBox="2 2 22 22" width="20" xmlns="http://www.w3.org/2000/svg">
		<path d="M0 0h24v24H0zm0 0h24v24H0z" fill="none" />
		<path d="M16.05 16.29l2.86-3.07c.38-.39.72-.79 1.04-1.18.32-.39.59-.78.82-1.17.23-.39.41-.78.54-1.17.13-.39.19-.79.19-1.18 0-.53-.09-1.02-.27-1.46-.18-.44-.44-.81-.78-1.11-.34-.31-.77-.54-1.26-.71-.51-.16-1.08-.24-1.72-.24-.69 0-1.31.11-1.85.32-.54.21-1 .51-1.36.88-.37.37-.65.8-.84 1.3-.18.47-.27.97-.28 1.5h2.14c.01-.31.05-.6.13-.87.09-.29.23-.54.4-.75.18-.21.41-.37.68-.49.27-.12.6-.18.96-.18.31 0 .58.05.81.15.23.1.43.25.59.43.16.18.28.4.37.65.08.25.13.52.13.81 0 .22-.03.43-.08.65-.06.22-.15.45-.29.7-.14.25-.32.53-.56.83-.23.3-.52.65-.88 1.03l-4.17 4.55V18H22v-1.71h-5.95zM8 7H6v4H2v2h4v4h2v-4h4v-2H8V7z" />
	</svg>
);

registerBlockType(
	'lf/count-up',
	{
		title: __( 'Count Up' ),
		icon: {
			src: blockIcon,
		},
		category: 'cncf',
		description: __( 'Block displaying a counting up animation for a custom number' ),
		keywords: [
			__( 'countup' ),
			__( 'count' ),
			__( 'counting' ),
			__( 'numbers' ),
			__( 'cncf' ),
			__( 'lf' ),
		],
		attributes: {
			sectionText: {
				type: 'string',
				default: '',
			},
			icon1: {
				type: 'string',
				default: 'https://placehold.it/100',
			},
			icon2: {
				type: 'string',
				default: 'https://placehold.it/100',
			},
			icon3: {
				type: 'string',
				default: 'https://placehold.it/100',
			},
			icon4: {
				type: 'string',
				default: 'https://placehold.it/100',
			},
			iconId1: {
				type: 'number',
				default: 0,
			},
			iconId2: {
				type: 'number',
				default: 0,
			},
			iconId3: {
				type: 'number',
				default: 0,
			},
			iconId4: {
				type: 'number',
				default: 0,
			},
			countUpNumber1: {
				type: 'string',
				default: '',
			},
			countUpNumber2: {
				type: 'string',
				default: '',
			},
			countUpNumber3: {
				type: 'string',
				default: '',
			},
			countUpNumber4: {
				type: 'string',
				default: '',
			},
			descText1: {
				type: 'string',
				default: '',
			},
			descText2: {
				type: 'string',
				default: '',
			},
			descText3: {
				type: 'string',
				default: '',
			},
			descText4: {
				type: 'string',
				default: '',
			},
			link1: {
				type: 'string',
				default: '',
			},
			link2: {
				type: 'string',
				default: '',
			},
			link3: {
				type: 'string',
				default: '',
			},
			link4: {
				type: 'string',
				default: '',
			},
			target1: {
				type: 'boolean',
				default: false,
			},
			target2: {
				type: 'boolean',
				default: false,
			},
			target3: {
				type: 'boolean',
				default: false,
			},
			target4: {
				type: 'boolean',
				default: false,
			},
			textColor: {
				type: 'string',
			},
			columns: {
				type: 'number',
				default: 1,
			},
		},
		edit: Edit,
		save: Save,
	}
);
