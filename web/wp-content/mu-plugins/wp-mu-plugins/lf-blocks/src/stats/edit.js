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

class StatBlock extends Component {
	render() {
		const { attributes, setAttributes } = this.props;
		const { headingStat01, headingStat02, headingStat03, headingStat04, headingStat05, smallerStat01, smallerStat02, smallerStat03, smallerStat04, smallerStat05, className } = attributes;

		return (
			<div
				className="stats-block">
				<div className="container stats-block-wrapper">

					<div>
						<RichText
							tagName="p"
							className="stat-header"
							placeholder={ __( 'Large Stat 1', 'lf-blocks' ) }
							keepPlaceholderOnFocus={ false }
							value={ headingStat01 }
							onChange={ value => setAttributes( { headingStat01: value } ) }
						/>
						<RichText
							tagName="p"
							className={ className }
							placeholder={ __( 'Small Stat 1', 'lf-blocks' ) }
							keepPlaceholderOnFocus={ false }
							value={ smallerStat01 }
							onChange={ value => setAttributes( { smallerStat01: value } ) }
						/>
					</div>

					<div>
						<RichText
							tagName="p"
							className="stat-header"
							placeholder={ __( 'Large Stat 2', 'lf-blocks' ) }
							keepPlaceholderOnFocus={ false }
							value={ headingStat02 }
							onChange={ value => setAttributes( { headingStat02: value } ) }
						/>
						<RichText
							tagName="p"
							className={ className }
							placeholder={ __( 'Small Stat 2', 'lf-blocks' ) }
							keepPlaceholderOnFocus={ false }
							value={ smallerStat02 }
							onChange={ value => setAttributes( { smallerStat02: value } ) }
						/>
					</div>

					<div>
						<RichText
							tagName="p"
							className="stat-header"
							placeholder={ __( 'Large Stat 3', 'lf-blocks' ) }
							keepPlaceholderOnFocus={ false }
							value={ headingStat03 }
							onChange={ value => setAttributes( { headingStat03: value } ) }
						/>
						<RichText
							tagName="p"
							className={ className }
							placeholder={ __( 'Small Stat 3', 'lf-blocks' ) }
							keepPlaceholderOnFocus={ false }
							value={ smallerStat03 }
							onChange={ value => setAttributes( { smallerStat03: value } ) }
						/>
					</div>

					<div>
						<RichText
							tagName="p"
							className="stat-header"
							placeholder={ __( 'Large Stat 4', 'lf-blocks' ) }
							keepPlaceholderOnFocus={ false }
							value={ headingStat04 }
							onChange={ value => setAttributes( { headingStat04: value } ) }
						/>
						<RichText
							tagName="p"
							className={ className }
							placeholder={ __( 'Small Stat 4', 'lf-blocks' ) }
							keepPlaceholderOnFocus={ false }
							value={ smallerStat04 }
							onChange={ value => setAttributes( { smallerStat04: value } ) }
						/>
					</div>

					<div>
						<RichText
							tagName="p"
							className="stat-header"
							placeholder={ __( 'Large Stat 5', 'lf-blocks' ) }
							keepPlaceholderOnFocus={ false }
							value={ headingStat05 }
							onChange={ value => setAttributes( { headingStat05: value } ) }
						/>
						<RichText
							tagName="p"
							className={ className }
							placeholder={ __( 'Small Stat 5', 'lf-blocks' ) }
							keepPlaceholderOnFocus={ false }
							value={ smallerStat05 }
							onChange={ value => setAttributes( { smallerStat05: value } ) }
						/>
					</div>

				</div>
			</div>
		);
	}
}

export default StatBlock;
