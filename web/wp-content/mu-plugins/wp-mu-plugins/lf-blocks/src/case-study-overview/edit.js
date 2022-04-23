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

const { InnerBlocks } = wp.blockEditor;
const { Component } = wp.element;
const { Placeholder } = wp.components;
const { useSelect } = wp.data;

class CaseStudyOverview extends Component {
	render() {

		const overview_template = [
			[ 'core/heading', { content: 'Challenge', level: 3 } ],
			[ 'core/paragraph', { placeholder: 'Challenge paragraph' } ],
			[ 'core/heading', { content: 'Solution', level: 3 } ],
			[ 'core/paragraph', { placeholder: 'Solution paragraph' } ],
			[ 'core/heading', { content: 'Impact', level: 3 } ],
			[ 'core/paragraph', { placeholder: 'Impact paragraph' } ],
		];

		const meta = wp.data.select( 'core/editor' ).getEditedPostAttribute( 'meta' );
		const longTitle = meta['lf_case_study_long_title'];

		return (
			<div className="alignwide">
				<div className="case-study-overview">
					<div className="case-study-intro-wrapper">
						<h2 className="long-title">{ longTitle }</h2>
						<Placeholder
						style={ { minHeight: '40px', backgroundColor: '#dedede' } }
						key="placeholder"
						icon="info-outline"
						label="&nbsp;Fill in the Case Study Settings sidebar to set the long title ↗️"
						instructions="The long title will be displayed on the case study index and at the top of the case study"
						></Placeholder>

						<InnerBlocks
							template={ overview_template }
						/>
					</div>

					<div className="case-study-overview-wrapper">
						<Placeholder
						style={ { minHeight: '40px', backgroundColor: '#dedede' } }
						key="placeholder"
						icon="info-outline"
						label="&nbsp;Fill in the Settings sidebar to add dynamic data ↗️"
						instructions="Choose related projects, country, product type, challenges and industry"
						></Placeholder>
						<p>Company: Dynamic Data</p>
						<p>Industry: Dynamic Data</p>
						<p>Location: Dynamic Data</p>
						<p>Cloud Type: Dynamic Data</p>
						<p>Product Type: Dynamic Data</p>
						<p>Challenges: Dynamic Data</p>
					</div>
				</div>
			</div>
		);
	}
}

export default CaseStudyOverview;
