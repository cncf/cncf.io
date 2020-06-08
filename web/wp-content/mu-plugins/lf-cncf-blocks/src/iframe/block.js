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
import Inspector from './inspector';

const { __ } = wp.i18n;
const { Fragment } = wp.element;
const { Placeholder } = wp.components;
const { registerBlockType } = wp.blocks;

registerBlockType(
	'lf/iframe',
	{
		title: __( 'LF | iFrame Embed' ),
		description: __( 'iFrame embed for adding iframes to a page' ),
		icon: 'welcome-view-site',
		category: 'cncf',
		keywords: [
			__( 'iframe' ),
			__( 'embed' ),
			__( 'cncf' ),
		],
		supports: {
			align: [ 'center' ],
		},
		example: {},
		attributes: {
			iframeSrc: {
				type: 'string',
			},
			iframeWidth: {
				type: 'string',
			},
			iframeHeight: {
				type: 'string',
			},
			iframeMaxWidth: {
				type: 'string',
			},
		},
		edit: function( props ) {
			const { attributes } = props;
			const { align } = attributes;

			const iframeStyle = {
				width: attributes.iframeWidth || '100%',
				height: attributes.iframeHeight || '500px',
				maxWidth: attributes.iframeMaxWidth || '700px',
			};

			const block = attributes.iframeSrc ?
				<div className={ `align${ align } ${ props.className }` }>
					<div className="iframe-overlay"></div>
					<iframe
						title="iframe"
						id="iframe"
						src={ attributes.iframeSrc }
						style={ iframeStyle }
						frameBorder="0"></iframe></div> :
				<Placeholder
					icon={ 'welcome-view-site' }
					label={ __( 'Enter the iFrame URL to embed in the sidebar' ) }
				/>;

			return (
				<Fragment>
					<Inspector { ...props } />
					{ block }
				</Fragment>
			);
		},

		save: function( props ) {
			const { attributes } = props;
			const { align } = attributes;

			const iframeStyle = {
				width: attributes.iframeWidth || '100%',
				height: attributes.iframeHeight || '500px',
				maxWidth: attributes.iframeMaxWidth || '700px',
			};

			return (
				<Fragment>
					<div className={ `align${ align } ${ props.className }` }>
						<iframe
							title="iframe"
							id="iframe"
							src={ attributes.iframeSrc }
							style={ iframeStyle }
							frameBorder="0"
							scrolling="yes"
						></iframe>
					</div>
				</Fragment>
			);
		},
	}
	);
