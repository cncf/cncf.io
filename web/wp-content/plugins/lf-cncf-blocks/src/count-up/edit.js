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
const { Component, Fragment } = wp.element;
const { InspectorControls, PanelColorSettings, RichText, MediaUpload } = wp.blockEditor || wp.editor;
const { RangeControl, PanelBody, TextControl, ToggleControl } = wp.components;

class Edit extends Component {
	constructor() {
		super( ...arguments );

		this.state = {
			currentEdit: '',
		};

		this.toggleAttribute = this.toggleAttribute.bind( this );
	}

	toggleAttribute( attribute ) {
		return ( newValue ) => {
			this.props.setAttributes( { [ attribute ]: newValue } );
		};
	}

	getItem( index ) {
		const { currentEdit } = this.state;
		const { attributes, setAttributes, isSelected } = this.props;

		const handleBetterImageSize = ( value ) => {
			const { sizes } = value;
			return ( sizes.thumbnail || sizes.full ).url;
		};

		const onSelectImage = ( value ) => {
			setAttributes(
				{
					[ `icon${ index }` ]: handleBetterImageSize( value ),
					[ `iconId${ index }` ]: value.id,
				}
			);
		};

		return (
			<div key={ index } className={ `count-up-item lf-count-up-columns-${ index }` } style={ { textAlign: 'center' } }>
				<div className="media">
					<MediaUpload
						onSelect={ onSelectImage }
						render={ ( { open } ) => {
							return (
								<button onClick={ open }>
									<img src={ attributes[ `icon${ index }` ] } alt="" />
								</button>
							);
						} }
					/>
				</div>
				<div className="lf-counter">
					<RichText
						tagName="div"
						value={ attributes[ `countUpNumber${ index }` ] }
						onChange={ ( value ) => setAttributes( { [ `countUpNumber${ index }` ]: value } ) }
						isSelected={ isSelected && currentEdit === `countUp${ index }` }
						unstableOnFocus={ () => this.setState( { currentEdit: `countUp${ index }` } ) }
						style={ { fontSize: '35px' } }
						placeholder={ __( '000' ) }
						className="lf-counter-number"
					/>
				</div>
				<RichText
					tagName="p"
					value={ attributes[ `descText${ index }` ] }
					onChange={ ( value ) => setAttributes( { [ `descText${ index }` ]: value } ) }
					isSelected={ isSelected && currentEdit === `desc${ index }` }
					unstableOnFocus={ () => this.setState( { currentEdit: `desc${ index }` } ) }
					placeholder={ __( 'Description' ) }
					className="lf-count-up-desc"
				/>
			</div>
		);
	}

	render() {
		const { attributes, setAttributes } = this.props;
		const { columns, textColor } = attributes;

		return (
			<Fragment>
				<InspectorControls>
					<PanelColorSettings
						title="Color Settings"
						initialOpen={ true }
						colorSettings={ [
							{
								value: textColor,
								onChange: colorValue =>
									setAttributes(
										{
											textColor: colorValue,
										}
									),
								label: 'Text Color',
							},
						] }
					>
					</PanelColorSettings>
					<PanelBody title={ __( 'General Settings' ) }>
						<RangeControl
							label={ __( 'Number of countup items' ) }
							min={ 1 }
							max={ 4 }
							value={ columns }
							onChange={ ( value ) => setAttributes( { columns: value } ) }
						/>
						{ Array.from( { length: columns }, ( _, i ) => i + 1 ).map(
							index => {
								return <Fragment key={ `no${ index }` }>
									<TextControl
										label={ `Link ${ index }` }
										key={ `link${ index }` }
										value={ attributes[ `link${ index }` ] }
										onChange={ ( value ) => setAttributes( { [ `link${ index }` ]: value } ) }
									/>
									<ToggleControl
										label={ 'Open link in new window' }
										key={ `target${ index }` }
										help={ `target${ index }` ? 'Opens in new window' : 'Opens normally' }
										checked={ attributes[ `target${ index }` ] }
										onChange={ this.toggleAttribute( `target${ index }` ) }
									/>
								</Fragment>;
							}
						) }
					</PanelBody>
				</InspectorControls>
				<div className="lf-count-up" style={ { display: 'flex', color: 'colorValue' } }>
					{ Array.from( { length: columns }, ( _, i ) => i + 1 ).map(
						index => {
							return this.getItem( index );
						}
					) }
				</div>
			</Fragment>
		);
	}
}
export default Edit;
