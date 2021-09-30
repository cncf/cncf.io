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
const { RichText } = wp.blockEditor;
const { Component } = wp.element;

class CaseStudyHighlight extends Component {
	render() {
		const { attributes, setAttributes } = this.props;
		const { headingText01, headingText02, headingText03, smallerText01, smallerText02, smallerText03, className } = attributes;

		return (
			<div
				className="case-study-highlights alignwide">
				<div className="container case-study-highlights-wrapper">
					<div>
						<RichText
							tagName="h3"
							className={ className }
							placeholder={ __( 'Heading Text 1', 'lf-blocks' ) }
							keepPlaceholderOnFocus={ false }
							value={ headingText01 }
							onChange={ value => setAttributes( { headingText01: value } ) }
						/>
						<RichText
							tagName="p"
							className={ className }
							placeholder={ __( 'Smaller Text 1', 'lf-blocks' ) }
							keepPlaceholderOnFocus={ false }
							value={ smallerText01 }
							onChange={ value => setAttributes( { smallerText01: value } ) }
						/>
					</div>
					<div>
						<RichText
							tagName="h3"
							className={ className }
							placeholder={ __( 'Heading Text 2', 'lf-blocks' ) }
							keepPlaceholderOnFocus={ false }
							value={ headingText02 }
							onChange={ value => setAttributes( { headingText02: value } ) }
						/>
						<RichText
							tagName="p"
							className={ className }
							placeholder={ __( 'Smaller Text 2', 'lf-blocks' ) }
							keepPlaceholderOnFocus={ false }
							value={ smallerText02 }
							onChange={ value => setAttributes( { smallerText02: value } ) }
						/>
					</div>
					<div>
						<RichText
							tagName="h3"
							className={ className }
							placeholder={ __( 'Heading Text 3', 'lf-blocks' ) }
							keepPlaceholderOnFocus={ false }
							value={ headingText03 }
							onChange={ value => setAttributes( { headingText03: value } ) }
						/>
						<RichText
							tagName="p"
							className={ className }
							placeholder={ __( 'Smaller Text 3', 'lf-blocks' ) }
							keepPlaceholderOnFocus={ false }
							value={ smallerText03 }
							onChange={ value => setAttributes( { smallerText03: value } ) }
						/>
					</div>
				</div>
			</div>
		);
	}
}

export default CaseStudyHighlight;
