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

		const {
			iframeSrc, iframeWidth, iframeId,
		} = attributes;

		return (
			<InspectorControls key="inspector">
				<PanelBody title={ __( 'Settings' ) } >
					<TextControl
						label={ __( 'Landscape URL' ) }
						value={ iframeSrc }
						onChange={ ( value ) => {
							setAttributes( { iframeSrc: value } );
						} }
					/>
					<TextControl
						label={ __( 'Unique ID' ) }
						help="Give the landscape embed a unique ID reference (useful when embedding multiple landscapes in one page)"
						value={ iframeId }
						onChange={ ( value ) => {
							setAttributes( { iframeId: value } );
						} }
					/>
					<TextControl
						label={ __( 'Override Width' ) }
						value={ iframeWidth }
						onChange={ ( value ) => {
							setAttributes( { iframeWidth: value } );
						} }
					/>
				</PanelBody>
			</InspectorControls>
		);
	}
}
