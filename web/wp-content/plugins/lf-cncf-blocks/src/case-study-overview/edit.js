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
const { InnerBlocks } = wp.blockEditor || wp.editor;
const { Component } = wp.element;

class CaseStudyOverview extends Component {
	render() {
		const { attributes, setAttributes } = this.props;
		const { className } = attributes;

		const overview_template = [
			[ 'core/heading', { content: 'Challenge', level: 3 } ],
			[ 'core/paragraph', { placeholder: 'Challenge paragraph' } ],
			[ 'core/heading', { content: 'Solution', level: 3 } ],
			[ 'core/paragraph', { placeholder: 'Solution paragraph' } ],
			[ 'core/heading', { content: 'Impact', level: 3 } ],
			[ 'core/paragraph', { placeholder: 'Impact paragraph' } ],
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
						<div>
							<p>Company</p>
							<span className="skew-box secondary">Dynamic Data</span>
						</div>
						<div>
							<p>Industry</p>
							<span className="skew-box secondary">Dynamic Data</span>
						</div>
						<div>
							<p>Location</p>
							<span className="skew-box secondary">Dynamic Data</span>
						</div>
						<div>
							<p>Cloud Type</p>
							<span className="skew-box secondary">Dynamic Data</span>
						</div>

						<div>
							<p>Product Type</p>
							<span className="skew-box secondary">Dynamic Data</span>
						</div>
						<div>
							<p>Challenges</p>
							<span className="skew-box secondary">Dynamic Data</span>
						</div>
					</div>
				</div>
			</div>
		);
	}
}

export default CaseStudyOverview;
