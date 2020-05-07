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
					<div className="events-wrapper">
						{ elements.map(
							( element, index ) => {
								return (
									<article className="event-box" key={ index } style={ { backgroundColor: '#617EBF' } }>
										<div className="event-content-wrapper-editor">

											<h4 className="event-title">Event Name
											</h4>

											<span className="event-date">November XX, 2021
											</span>

											<span className="event-city">San Francisco, United States</span>

											<span className="button transparent outline ">Learn More</span>
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
