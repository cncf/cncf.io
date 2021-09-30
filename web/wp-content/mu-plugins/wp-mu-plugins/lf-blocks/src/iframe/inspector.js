/**
 * Inspector
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

const { __ } = wp.i18n;
const { Component } = wp.element;
const { InspectorControls } = wp.blockEditor;
const { PanelBody, TextControl } = wp.components;

/**
 * Inspector controls
 */
export default class Inspector extends Component {
	render() {
		const { attributes, setAttributes } = this.props;

		return (
			<InspectorControls key="inspector">
				<PanelBody title={ __( 'Settings' ) }
					initialOpen="true" >
					<TextControl
						label={ __( 'iFrame URL' ) }
						value={ attributes.iframeSrc }
						onChange={ ( value ) => {
							setAttributes( { iframeSrc: value } );
						} }
					/>
					<TextControl
						label={ __( 'iFrame Width' ) }
						value={ attributes.iframeWidth }
						help="Set this if the default options don't work i.e. 100%"
						onChange={ ( value ) => {
							setAttributes( { iframeWidth: value } );
						} }
					/>
					<TextControl
						label={ __( 'iFrame Max Width' ) }
						value={ attributes.iframeMaxWidth }
						help="Set this if the default options don't work i.e. 100%"
						onChange={ ( value ) => {
							setAttributes( { iframeMaxWidth: value } );
						} }
					/>
					<TextControl
						label={ __( 'iFrame Height' ) }
						value={ attributes.iframeHeight }
						help="Set this if the default options don't work i.e. 1000px"
						onChange={ ( value ) => {
							setAttributes( { iframeHeight: value } );
						} }
					/>
				</PanelBody>
			</InspectorControls>
		);
	}
}
