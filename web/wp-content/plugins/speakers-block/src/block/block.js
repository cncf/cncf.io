/**
 * BLOCK: speakers-block
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */

//  Import CSS.
import './style.scss';
import './editor.scss';

const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks
const { PlainText, InspectorControls, PanelColorSettings } = wp.blockEditor;
const { RadioControl, PanelBody, PanelRow } = wp.components; //Import Button from wp.components


/**
 * Register: aa Gutenberg Block.
 *
 * Registers a new block provided a unique name and an object defining its
 * behavior. Once registered, the block is made editor as an option to any
 * editor interface where blocks are implemented.
 *
 * @link https://wordpress.org/gutenberg/handbook/block-api/
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */
registerBlockType( 'cgb/block-speakers-block', {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __( 'Speakers' ), // Block title.
	icon: 'groups', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	keywords: [
		__( 'Speakers' ),
	],
	attributes: {
        speakers: {
			type: 'string'
		},
		color1: {
			type: 'string',
		},
		color2: {
			type: 'string',
		},
		text_color: {
			type: 'string',
		},
    },

	/**
	 * The edit function describes the structure of your block in the context of the editor.
	 * This represents what the editor will render when the block is used.
	 *
	 * The "edit" property must be a valid function.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
	 */
	edit: function( props ) {
		const { setAttributes, attributes: { speakers, color1, color2, text_color }} = props;
		
		function onTextColorChange(changes) {
			setAttributes({
				text_color: changes
			})
		}

		return [	
			<InspectorControls>
				<PanelColorSettings
					title='Color Settings'
					initialOpen={true}
					colorSettings={[
						{
							value: color1,
							onChange: colorValue =>
								setAttributes({
									color1: colorValue
								}),
							label: 'Color 1'
						},
						{
							value: color2,
							onChange: colorValue =>
								setAttributes({
									color2: colorValue
								}),
							label: 'Color 2'
						}
					]}
				>
				</PanelColorSettings>
				<PanelBody><PanelRow>
				<div>
					<RadioControl
						label='Text color:'
						selected={text_color}
						onChange={onTextColorChange}
						options={ [
							{ label: 'White', value: 'white' },
							{ label: 'Black', value: 'black' },
						] }
						/>
				</div>
				</PanelRow></PanelBody>
			</InspectorControls>,
			<div className={ props.className }>
				<p><strong>Featured Speakers:</strong>
					<PlainText
						value={ speakers }
						onChange={( value ) => setAttributes({ speakers: value })}
						placeholder="Dan Kohn, Andy Cochran"
					/>
					<em>Enter a comma-separated list of Speaker names or slugs.</em>
				</p>
			</div>
		];
	},

	/**
	 * The save function defines the way in which the different attributes should be combined
	 * into the final markup, which is then serialized by Gutenberg into post_content.
	 *
	 * The "save" property must be specified and must be a valid function.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
	 */
	save: function( props ) {
		const { setAttributes, attributes: { speakers }} = props;
		return null;
	},
} );
