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

const blockIcon = (
	<svg viewBox="0 -31 512 512">
		<path d="M497.094 60.004c-.031 0-.063-.004-.094-.004H361V45c0-24.813-20.188-45-45-45H196c-24.813 0-45 20.188-45 45v15H15C6.648 60 0 66.844 0 75v330c0 24.813 20.188 45 45 45h422c24.813 0 45-20.188 45-45V75.316v-.058c-.574-9.852-6.633-15.2-14.906-15.254zM181 45c0-8.27 6.73-15 15-15h120c8.27 0 15 6.73 15 15v15H181zm295.188 45l-46.583 139.742A14.975 14.975 0 0 1 415.38 240H331v-15c0-8.285-6.715-15-15-15H196c-8.285 0-15 6.715-15 15v15H96.621a14.975 14.975 0 0 1-14.226-10.258L35.813 90zM301 240v30h-90v-30zm181 165c0 8.27-6.73 15-15 15H45c-8.27 0-15-6.73-15-15V167.434l23.934 71.796A44.935 44.935 0 0 0 96.62 270H181v15c0 8.285 6.715 15 15 15h120c8.285 0 15-6.715 15-15v-15h84.379a44.935 44.935 0 0 0 42.687-30.77L482 167.434zm0 0"></path>
	</svg>
);

registerBlockType(
	'lf/latest-jobs',
	{
		title: __( 'Latest Jobs' ),
		description: __( 'Block showing the latest jobs from https://jobs.cncf.io' ),
		icon: {
			src: blockIcon,
		},
		category: 'cncf',
		keywords: [
			__( 'latest jobs' ),
			__( 'jobs' ),
			__( 'cncf' ),
			__( 'vacancies' ),
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
			quantity: {
				type: 'number',
				default: 4,
			},
		},
		html: false,
		edit: Edit,
		save: () => null,
	}
);
