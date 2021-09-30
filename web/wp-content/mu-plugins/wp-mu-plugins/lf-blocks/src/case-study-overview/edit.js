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

class CaseStudyOverview extends Component {
	render() {

		const overview_template = [
			[ 'core/heading', { content: 'Challenge', level: 3 } ],
			[ 'core/paragraph', { placeholder: 'Challenge paragraph' } ],
			[ 'core/heading', { content: 'Solution', level: 3 } ],
			[ 'core/paragraph', { placeholder: 'Solution paragraph' } ],
			[ 'core/heading', { content: 'Impact', level: 3 } ],
			[ 'core/paragraph', { placeholder: 'Impact paragraph' } ],
			[ 'lf/youtube-lite' ],
		];

		return (
			<div className="alignwide">
				<div className="case-study-overview">
					<div className="case-study-intro-wrapper">
						<InnerBlocks
							template={ overview_template }
						/>
					</div>

					<div className="case-study-overview-wrapper">
						<Placeholder
							label="Fill in the Settings sidebar for this to be populated ↗️"
						>
						</Placeholder>
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
