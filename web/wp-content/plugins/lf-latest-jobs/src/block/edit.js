const { __ } = wp.i18n;
const { InspectorControls } = wp.blockEditor || wp.editor;
const { RangeControl, PanelBody } = wp.components;

export default ( props ) => {
	const { attributes, setAttributes } = props;
	const { quantity } = attributes;

	return [
		<InspectorControls key="lf-latest-block-panel">
			<PanelBody title={ __( 'Settings' ) }>
				<RangeControl
					label={ __( 'Quantity' ) }
					min={ 1 }
					max={ 10 }
					value={ quantity }
					onChange={ ( value ) => setAttributes( { quantity: value } ) }
				/>
			</PanelBody>
		</InspectorControls>,
		<div className="description" key="lf-latest-jobs">
			<i>This block will add the latest jobs section.</i>
		</div>,
	];
};
