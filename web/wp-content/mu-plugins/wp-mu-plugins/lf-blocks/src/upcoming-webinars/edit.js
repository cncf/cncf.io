/**
 * Edit screen code
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
const { InspectorControls } = wp.blockEditor;
const { Component, Fragment } = wp.element;
const { RangeControl, PanelBody, ToggleControl } = wp.components;

class UpcomingWebinars extends Component {
	toggleAttribute( attribute ) {
		return ( newValue ) => {
			this.props.setAttributes( { [ attribute ]: newValue } );
		};
	}

	render() {
		const { attributes, setAttributes } = this.props;
		const { numberposts, showImages, showBorder } = attributes;

		const elements = [ ...Array( numberposts ).keys() ];

		const inspectorControls = (
			<InspectorControls key="lf-upcoming-webinars-block-panel">
				<PanelBody title={ __( 'Settings' ) } initialOpen={ true }>
					<RangeControl
						label={ __( 'Number of Webinars' ) }
						min={ 1 }
						max={ 12 }
						value={ numberposts }
						onChange={ value => setAttributes( { numberposts: value } ) }
					/>
					<ToggleControl
						label={ __( 'Show Images' ) }
						help={ showImages ? 'Featured images are shown.' : 'No images are shown.' }
						checked={ showImages }
						onChange={ this.toggleAttribute( 'showImages' ) }
					/>
					<ToggleControl
						label={ __( 'Show Image Border' ) }
						help={ showBorder ? 'Image border is now displayed.' : 'No border is shown.' }
						checked={ showBorder }
						onChange={ this.toggleAttribute( 'showBorder' ) }
					/>
				</PanelBody>
			</InspectorControls>
		);

		return (
			<Fragment>
				{ inspectorControls }
				<div className={ this.props.className }>
					<div className="webinars-upcoming-wrapper">
						{ elements.map(
							( element, index ) => {
								return (
									<article className="webinars-upcoming-box" key={ index } test={ element }>
										<div className="webinars-upcoming-text-wrapper">
											<span className="skew-box secondary">Example Webinar</span>
											<span className="skew-box">Tuesday 12th January 2022</span>
											<h5 className="webinar-title">This is an example Webinar title Lorem ipsum dolor sit amet consectetuer</h5>
											<span className="presented-by">Presented by Google</span>
										</div>
									</article>
								);
							}
						)
						}
					</div>
				</div>
			</Fragment>
		);
	}
}

export default UpcomingWebinars;
