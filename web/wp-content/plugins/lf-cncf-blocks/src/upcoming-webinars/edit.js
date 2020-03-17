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
					<div className="uw-wrapper">
						{ elements.map(
							( element, index ) => {
								return (
									<article className="uw-box" key={ index }>
										<div className="uw-title-wrapper">
											<div className="uw-date-category-wrapper">
												<span
													className="uw-date skew-box">XX January 2021</span>
												<span className="uw-category skew-box">
													CNCF Project Webinar
												</span>
											</div>
											<h4 className="uw-title">This is the Webinar title
											</h4>
											<span className="uw-time">Join live from
												10:00 - 11:00 PT </span>
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
