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
const { RichText } = wp.blockEditor || wp.editor;
const { Component } = wp.element;

class CaseStudyOverview extends Component {
	render() {
		const { attributes, setAttributes } = this.props;
		const { className } = attributes;

		return (
			<div className="case-study-overview alignwide">
			<div className="container case-study-overview-wrapper">

			<div>
						<span className="skew-box smaller">Industry</span>
						<p>Dynamic Data</p>
					</div>
					<div>
						<span className="skew-box smaller">Location</span>
						<p>Dynamic Data</p>
					</div>
					<div>
						<span className="skew-box smaller">Cloud Type</span>
						<p>Dynamic Data</p>
					</div>

					<div>
						<span className="skew-box smaller">Product Type</span>
						<p>Dynamic Data</p>
					</div>
					<div>
						<span className="skew-box smaller">Challenges</span>
						<p>Dynamic Data</p>
					</div>

			</div>
			</div>
		);
	}
}

export default CaseStudyOverview;
