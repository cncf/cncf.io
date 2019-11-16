/**
 * BLOCK: sponsors-block
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */


const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks
const { MediaUpload, InspectorControls } = wp.editor; //Import MediaUpload from wp.editor
const { Button, TextControl, SelectControl, PanelBody, PanelRow } = wp.components; //Import Button from wp.components


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

registerBlockType( 'cgb/sponsors-block', {
  title: __( 'Sponsors' ), // Block title.
  icon: 'editor-kitchensink', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
  category: 'common', // Block category
  keywords: [ //Keywords
    __('sponsors'),
  ],
  attributes: { //Attributes
    images : { //Images array
      type: 'array',
    },
    tierName: {
      type: 'string',
      default: '',
    },
    tierSize: {
      type: 'string',
      default: 'medium',
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
  edit({ attributes, className, setAttributes, focus }) {

    //Destructuring the images array attribute
    const { images = [], tierName, tierSize } = attributes;

    // This removes an image from the gallery
    const removeImage = (removeImage) => {
      //filter the images
      const newImages = images.filter( (image) => {
        //If the current image is equal to removeImage the image will be returnd
        if(image.id != removeImage.id) {
          return image;
        }
      });

      //Saves the new state
      setAttributes({
        images:newImages,
      })
    }

    //Displays the images
    const displayImages = (images) => {
      return (
        //Loops through the images
        images.sort(function (a, b) {
          return a.filename.toLowerCase().localeCompare(b.filename.toLowerCase());
        }).map( (image) => {
          return (
            <div class="sponsors-logo-item">
              <img className='logo admin-preview' src={image.url} key={ images.id } />
              <span className='remove-item' onClick={() => removeImage(image)}><span class="dashicons dashicons-trash"></span></span>
            </div>
          )
        })
      )
    }

    function onTierNameChange(changes) {
      setAttributes({
        tierName: changes
      })
    }

    function onTierSizeChange(changes) {
      setAttributes({
        tierSize: changes
      })
    }

    //JSX to return
    return [
      <InspectorControls>
      <PanelBody>
        <TextControl
          label='Sponsor Tier Name:'
          value={ tierName }
          onChange={ onTierNameChange }
          placeholder='DIAMOND'
        />
        <SelectControl
          label={ __( 'Logo Size:' ) }
          value={ tierSize }
          onChange={ onTierSizeChange }
          options={ [
            { value: 'jumbo', label: 'Jumbo' },
            { value: 'largest', label: 'Largest' },
            { value: 'larger', label: 'Larger' },
            { value: 'large', label: 'Large' },
            { value: 'medium', label: 'Medium' },
            { value: 'small', label: 'Small' },
            { value: 'smaller', label: 'Smaller' },
            { value: 'smallest', label: 'Smallest' },
          ] }
        />
      </PanelBody>
      </InspectorControls>,
      <div>
        <h3 className={ `sponsors-logos--header` }>{ tierName }</h3>
        <div
          className={ `sponsors-logos ${tierSize} ${((images.length % 2 == 0) ? 'even' : 'odd')} ${((images.length % 3 == 1) ? 'orphan-by-3' : '')} ${((images.length % 4 == 1) ? 'orphan-by-4' : '')} ${((images.length % 5 == 1) ? 'orphan-by-5' : '')} ${((images.length % 6 == 1) ? 'orphan-by-6' : '')} ${((images.length % 7 == 1) ? 'orphan-by-7' : '')} ${((images.length % 8 == 1) ? 'orphan-by-8' : '')}` }
          style={ { marginBottom: '2rem' } }
        >
          {displayImages(images)}
        </div>
        <MediaUpload
          onSelect={(media) => {setAttributes({images: [...images, ...media].sort((a,b) => (a.title > b.title) ? 1 : ((b.title > a.title) ? -1 : 0) )}) }}
          type="image"
          multiple={true}
          value={images}
          render={({open}) => (
            <Button className="select-images-button is-button is-default is-large" onClick={open}>
              Add images
            </Button>
          )}
        />
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
  save({attributes}) {
    //Destructuring the images array attribute
    const { images = [], tierName, tierSize } = attributes;

    // Displays the images
    const displayImages = (images) => {
      return (
        images.sort(function (a, b) {
          return a.filename.toLowerCase().localeCompare(b.filename.toLowerCase());
        }).map( (image,index) => {
          if ( image.description ) {
            return (
              <div class="sponsors-logo-item">
                <a href={image.description} target="_blank" rel="noopener noreferrer">
                  <img
                    src={image.url}
                    alt={image.alt}
                    data-id={image.id}
                    data-link={image.url}
                    className={'logo wp-image-' + image.id}
                  />
                </a>
              </div>
            )
          } else {
            return (
              <div class="sponsors-logo-item">
                <img
                  src={image.url}
                  alt={image.alt}
                  data-id={image.id}
                  data-link={image.url}
                  className={'logo wp-image-' + image.id}
                />
              </div>
            )
          }
        })
      )
    }

    //JSX to return
    return (
      <div>
        <h3 className={ `sponsors-logos--header` }>{ tierName }</h3>
        <div className={ `sponsors-logos ${tierSize} ${((images.length % 2 == 0) ? 'even' : 'odd')} ${((images.length % 3 == 1) ? 'orphan-by-3' : '')} ${((images.length % 4 == 1) ? 'orphan-by-4' : '')} ${((images.length % 5 == 1) ? 'orphan-by-5' : '')} ${((images.length % 6 == 1) ? 'orphan-by-6' : '')} ${((images.length % 7 == 1) ? 'orphan-by-7' : '')} ${((images.length % 8 == 1) ? 'orphan-by-8' : '')}` }>
          { displayImages(images) }
        </div>
      </div>
    );

  },
} );
