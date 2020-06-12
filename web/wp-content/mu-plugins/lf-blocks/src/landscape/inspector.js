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
const { InspectorControls } = wp.editor;
const { PanelBody, TextControl } = wp.components;

/**
 * Inspector controls
 */
export default class Inspector extends Component {
	render() {
		const { attributes, setAttributes } = this.props;

		return (
			<InspectorControls key="inspector">
				<PanelBody title={ __( 'Settings' ) } >
					<TextControl
						label={ __( 'iFrame URL' ) }
						value={ attributes.iframeSrc }
						onChange={ ( value ) => {
							setAttributes( { iframeSrc: value } );
						} }
					/>
					<TextControl
						label={ __( 'Override Width' ) }
						value={ attributes.iframeWidth }
						onChange={ ( value ) => {
							setAttributes( { iframeWidth: value } );
						} }
					/>
					<TextControl
						label={ __( 'Override Height' ) }
						value={ attributes.iframeHeight }
						onChange={ ( value ) => {
							setAttributes( { iframeHeight: value } );
						} }
					/>
				</PanelBody>
			</InspectorControls>
		);
	}
}
