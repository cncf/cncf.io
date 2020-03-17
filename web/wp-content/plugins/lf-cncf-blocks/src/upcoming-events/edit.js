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

class UpcomingEvents extends Component {
	render() {
		const { attributes, setAttributes } = this.props;
		const { numberposts } = attributes;

		const elements = [ ...Array( numberposts ).keys() ];

		const inspectorControls = (
			<InspectorControls key="lf-upcoming-events-block-panel">
				<PanelBody title={ __( 'Settings' ) } initialOpen={ true }>
					<RangeControl
						label={ __( 'Number of Events' ) }
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
					<div className="ue-wrapper">
						{ elements.map(
							( element, index ) => {
								return (
									<article className="ue-event-box" key={ index } style={ { backgroundColor: '#CFDFE5' } }>
										<div className="ue-content-wrapper background-image-text-overlay">
											<div className="ue-logo">
												Logo
											</div>

											<span className="ue-event-date">
												November XX, 2021
											</span>

											<span className="ue-event-city">San Francisco, United States</span>

											<span className="button transparent outline ue-button">Learn More</span>
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

export default UpcomingEvents;
