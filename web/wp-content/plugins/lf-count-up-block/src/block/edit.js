const { __ } = wp.i18n;
const { Component, Fragment } = wp.element;
const { InspectorControls, PanelColorSettings, RichText, MediaUpload } = wp.blockEditor || wp.editor;
const { RangeControl, PanelBody, TextControl } = wp.components;

class Edit extends Component {
	constructor() {
		super( ...arguments );

		this.state = {
			currentEdit: '',
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
			setAttributes( { [ `icon${ index }` ]: handleBetterImageSize( value ) } );
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
						placeholder={ __( 'Number...' ) }
						className="lf-counter-number"
					/>
				</div>
				<RichText
					tagName="p"
					value={ attributes[ `descText${ index }` ] }
					onChange={ ( value ) => setAttributes( { [ `descText${ index }` ]: value } ) }
					isSelected={ isSelected && currentEdit === `desc${ index }` }
					unstableOnFocus={ () => this.setState( { currentEdit: `desc${ index }` } ) }
					placeholder={ __( 'Enter description text…' ) }
					className="lf-count-up-desc"
				/>
			</div>
		);
	}

	render() {
		const { currentEdit } = this.state;
		const { attributes, setAttributes } = this.props;
		const { columns, sectionText, isSelected, color1, color2, textColor } = attributes;

		return (
			<Fragment>
				<InspectorControls>
					<PanelColorSettings
						title="Color Settings"
						initialOpen={ true }
						colorSettings={ [
							{
								value: color1,
								onChange: colorValue =>
									setAttributes( {
										color1: colorValue,
									} ),
								label: 'Background Color 1',
							},
							{
								value: color2,
								onChange: colorValue =>
									setAttributes( {
										color2: colorValue,
									} ),
								label: 'Background Color 2',
							},
							{
								value: textColor,
								onChange: colorValue =>
									setAttributes( {
										textColor: colorValue,
									} ),
								label: 'Text Color',
							},
						] }
					>
					</PanelColorSettings>
					<PanelBody title={ __( 'General Settings' ) }>
						<RangeControl
							label={ __( 'Columns' ) }
							min={ 1 }
							max={ 4 }
							value={ columns }
							onChange={ ( value ) => setAttributes( { columns: value } ) }
						/>
						{ Array.from( { length: columns }, ( _, i ) => i + 1 ).map( index => {
							return <TextControl
								label={ `Link ${ index }` }
								key={ `link${ index }` }
								value={ attributes[ `link${ index }` ] }
								onChange={ ( value ) => setAttributes( { [ `link${ index }` ]: value } ) }
							/>;
						} ) }
					</PanelBody>
				</InspectorControls>
				<div className="section-text">
					<RichText
						tagName="div"
						value={ sectionText }
						onChange={ ( value ) => setAttributes( { sectionText: value } ) }
						isSelected={ isSelected && currentEdit === 'sectionText' }
						unstableOnFocus={ () => this.setState( { currentEdit: 'sectionText' } ) }
						placeholder={ __( 'Enter section text...' ) }
						className="lf-section-text"
					/>
				</div>
				<div className="lf-count-up" style={ { display: 'flex' } }>
					{ Array.from( { length: columns }, ( _, i ) => i + 1 ).map( index => {
						return this.getItem( index );
					} ) }
				</div>
			</Fragment>
		);
	}
}

export default Edit;
