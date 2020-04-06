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

class GuestAuthor extends Component {
	render() {
		const { attributes, setAttributes } = this.props;
		const { content, className } = attributes;

		return (
			<p>
				<span>Guest post by: </span>
				<RichText
					tagName="span"
					className={ className }
					placeholder={ __( 'Dan Kohn', 'cncf-blocks' ) }
					keepPlaceholderOnFocus={ true }
					value={ content }
					onChange={ value => setAttributes( { content: value } ) }
				/>
			</p>
		);
	}
}

export default GuestAuthor;
