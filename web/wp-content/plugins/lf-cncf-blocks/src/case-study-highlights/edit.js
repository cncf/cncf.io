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

class CaseStudyHighlight extends Component {
	render() {
		const { attributes, setAttributes } = this.props;
		const { highlight01, highlight02, highlight03, className } = attributes;

		return (
			<div
				className="case-study-highlights alignwide is-style-blue-pink-gradient ">
				<div className="container case-study-highlights-wrapper">
			<div><h3>CNCF Projects Used</h3>
			<div>
			<img src="https://via.placeholder.com/50x50/d9d9d9/000000" /> & nbsp;
			<img src="https://via.placeholder.com/50x50/d9d9d9/000000" />
			</div>
			</div>
			<div>
				<RichText
					tagName="h3"
					className={ className }
					placeholder={ __( 'Example Text 1', 'cncf-blocks' ) }
					keepPlaceholderOnFocus={ false }
					value={ highlight01 }
					onChange={ value => setAttributes( { highlight01: value } ) }
				/>
			</div>
			<div>
				<RichText
					tagName="h3"
					className={ className }
					placeholder={ __( 'Example Text 2', 'cncf-blocks' ) }
					keepPlaceholderOnFocus={ false }
					value={ highlight02 }
					onChange={ value => setAttributes( { highlight02: value } ) }
				/>
			</div>
			<div>
				<RichText
					tagName="h3"
					className={ className }
					placeholder={ __( 'Example Text 3', 'cncf-blocks' ) }
					keepPlaceholderOnFocus={ false }
					value={ highlight03 }
					onChange={ value => setAttributes( { highlight03: value } ) }
				/>
			</div>
			</div>
			</div>
		);
	}
}

export default CaseStudyHighlight;
