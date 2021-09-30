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

class Hero extends Component {
	render() {
		const heroTemplate = [
			[ 'core/heading', { placeholder: 'Your custom page title', level: 1, textColor: 'white' } ],
		];

		return (
			<div className="alignfull">
				<section className="hero background-image-wrapper">

					<figure className="background-image-figure">
						<img src="https://via.placeholder.com/1400x300/BADA55/000000" alt="Hero" />
					</figure>

					<div className="container wrap background-image-text-overlay">
						<div>
							<InnerBlocks
								template={ heroTemplate }
							/>
						</div>
					</div>
				</section>
			</div>
		);
	}
}

export default Hero;
