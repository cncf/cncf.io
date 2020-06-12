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
const { InspectorControls } = wp.blockEditor || wp.editor;
const { Component, Fragment } = wp.element;
const { RangeControl, PanelBody } = wp.components;

class UpcomingWebinars extends Component {
	render() {
		const { attributes, setAttributes } = this.props;
		const { numberposts } = attributes;

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
									<article className="webinars-upcoming-box" key={ index }>
										<div className="webinars-upcoming-text-wrapper">
											<span className="skew-box secondary">CNCF Project Webinar</span>
											<span className="skew-box">Tuesday 12th January 2021</span>
											<h5 className="webinar-title">This is the Webinar title Lorem ipsum dolor sit amet consectetuer</h5>
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
