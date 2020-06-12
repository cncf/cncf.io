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

 /* eslint-disable no-undef */
const { __ } = wp.i18n;
const { InspectorControls } = wp.blockEditor || wp.editor;
const { Component, Fragment } = wp.element;
const { RangeControl, PanelBody } = wp.components;

class LatestJobs extends Component {
	render() {
		const { attributes, setAttributes } = this.props;
		const { quantity } = attributes;

		const elements = [ ...Array( quantity ).keys() ];

		const inspectorControls = (
			<InspectorControls key="lf-latest-block-panel">
				<PanelBody title={ __( 'Settings' ) }>
					<RangeControl
						label={ __( 'Number of Jobs' ) }
						min={ 1 }
						max={ 12 }
						value={ quantity }
						onChange={ value => setAttributes( { quantity: value } ) }
					/>
				</PanelBody>
			</InspectorControls>
		);

		return (
			<Fragment>
				{ inspectorControls }
				<div className={ this.props.className }>
					<ul className="jobs-list">
						{ elements.map(
							( value, index ) => {
								return (
									<li key={ index }>
										<img
											className="job-image"
											src={ cgbGlobal.fallback }
											alt="Job"
										/>
										<div className="job-content">
											<span className="job-title">
												Job Title
											</span>
											<span className="job-company">
												<svg viewBox="0 0 448 512">
													<path d="M436 480h-20V24c0-13.255-10.745-24-24-24H56C42.745 0 32 10.745 32 24v456H12c-6.627 0-12 5.373-12 12v20h448v-20c0-6.627-5.373-12-12-12zM128 76c0-6.627 5.373-12 12-12h40c6.627 0 12 5.373 12 12v40c0 6.627-5.373 12-12 12h-40c-6.627 0-12-5.373-12-12V76zm0 96c0-6.627 5.373-12 12-12h40c6.627 0 12 5.373 12 12v40c0 6.627-5.373 12-12 12h-40c-6.627 0-12-5.373-12-12v-40zm52 148h-40c-6.627 0-12-5.373-12-12v-40c0-6.627 5.373-12 12-12h40c6.627 0 12 5.373 12 12v40c0 6.627-5.373 12-12 12zm76 160h-64v-84c0-6.627 5.373-12 12-12h40c6.627 0 12 5.373 12 12v84zm64-172c0 6.627-5.373 12-12 12h-40c-6.627 0-12-5.373-12-12v-40c0-6.627 5.373-12 12-12h40c6.627 0 12 5.373 12 12v40zm0-96c0 6.627-5.373 12-12 12h-40c-6.627 0-12-5.373-12-12v-40c0-6.627 5.373-12 12-12h40c6.627 0 12 5.373 12 12v40zm0-96c0 6.627-5.373 12-12 12h-40c-6.627 0-12-5.373-12-12V76c0-6.627 5.373-12 12-12h40c6.627 0 12 5.373 12 12v40z"></path>
												</svg>
												Company
											</span>
											<span className="job-location">
												<svg viewBox="0 0 384 512">
													<path d="M172.268 501.67C26.97 291.031 0 269.413 0 192 0 85.961 85.961 0 192 0s192 85.961 192 192c0 77.413-26.97 99.031-172.268 309.67-9.535 13.774-29.93 13.773-39.464 0zM192 272c44.183 0 80-35.817 80-80s-35.817-80-80-80-80 35.817-80 80 35.817 80 80 80z"></path>
												</svg>
												Location
											</span>
										</div>
									</li>
								);
							}
						)
						}
					</ul>
				</div>
			</Fragment>
		);
	}
}

export default LatestJobs;
