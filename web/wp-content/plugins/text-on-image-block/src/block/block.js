/**
 * BLOCK: text-on-image-block
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */

//  Import CSS.
import './style.scss';
import './editor.scss';

const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType, getBlockDefaultClassName } = wp.blocks; // Import registerBlockType() from wp.blocks
const { RichText, MediaUpload } = wp.blockEditor;

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
registerBlockType( 'cgb/block-text-on-image-block', {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __( 'Text on Image Block' ), // Block title.
	icon: 'welcome-widgets-menus', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	keywords: [
		__( 'text-on-image-block' ),
	],
	attributes: {
        bodyContent: {
            source: 'html',
            selector: '.copy-bd'
        },
        imgUrl: {
            type: 'string',
            default: 'https://placehold.it/500'
		}
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
        const { className, setAttributes } = props;
		const { attributes } = props;

		function changeBodyContent(changes) {
            setAttributes({
                bodyContent: changes,
			})
        }

        function selectImage(value) {
            setAttributes({
                imgUrl: value.sizes.full.url,
            })
        }
		return (
			<div className={className}>
				<div className="media">
					<MediaUpload
						onSelect={selectImage}
						render={ ({open}) => {
							return (
								<button onClick={open}>
									<img
										src={attributes.imgUrl}
										/>
								</button>
							);
						}}
					/>
				</div>
				<div className="copy">
					<RichText
						className="copy-bd"
						tagName="div"
						placeholder="Enter text here that will float on top of the image."
						value={attributes.bodyContent}
						onChange={changeBodyContent}
						/>
				</div>
			</div>
		);
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
		const className = getBlockDefaultClassName('cgb/block-text-on-image-block');
		const { attributes } = props;

		return (
			<div class="alignfull lfe-image-and-text pull-right" style={ "background-image:url(" + attributes.imgUrl + ");"}>
				<img src={attributes.imgUrl} />
				<div class="text">
					<blockquote>
					<RichText.Content
					className="copy-bd"
					tagName="div"
					value={attributes.bodyContent}
					/>
					</blockquote>
				</div>
			</div>
		);
	},
} );
