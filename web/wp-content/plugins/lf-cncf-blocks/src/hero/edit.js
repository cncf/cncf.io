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

class Hero extends Component {
	render() {
		const { attributes, setAttributes } = this.props;
		const { className } = attributes;

		const heroTemplate = [
			[ 'core/heading', { placeholder: 'Your custom page title', level: 1, className: 'is-style-center-width-800', textColor: 'white' } ],
		];

		return (
			<div className="alignfull">
				<section className="hero background-image-wrapper">

					<figure className="background-image-figure">
						<img src="/wp-content/uploads/2020/02/welcome.jpg" alt="welcome" />
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
