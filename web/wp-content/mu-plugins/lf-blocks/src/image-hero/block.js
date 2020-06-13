/**
 * Register block JS
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

// Import CSS.
import './editor.scss';
import './style.scss';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;
const { MediaUpload, InspectorControls } = wp.blockEditor;
const { Fragment } = wp.element;
const { RangeControl, PanelBody } = wp.components;

registerBlockType(
	 'lf/image-hero',
	{
	title: __( 'LF | Image Hero' ),
	description: __( 'Large responsive image, commonly used for page hero. Recommend image size around 1200x400px.' ),
	icon: 'welcome-widgets-menus',
	category: 'lf',
	keywords: [
		__( 'image' ),
		__( 'hero' ),
		__( 'large' ),
		__( 'lf' ),
	],
	example: {},
	attributes: {
			imgUrl: {
				type: 'string',
				default: 'https://via.placeholder.com/1200x400/d9d9d9/000000',
			},
			imgId: {
							type: 'integer',
							default: '0',
				},
				heroHeight: {
										type: 'integer',
										default: '400',
						},
					},
					edit: function( props ) {
												const { attributes, setAttributes } = props;
												const { imgUrl, imgId, heroHeight, className } = attributes;

												function selectImage( value ) {
						setAttributes(
				 {
																	  imgUrl: value.url,
						}
				);
						setAttributes(
				 {
														  imgId: value.id,
						}
				);
										}

											const inspectorControls = (
												<InspectorControls key="lf-image-hero-block-panel">
													<PanelBody title={ __( 'Settings' ) }>
											<RangeControl
												label={ __( 'Height of image' ) }
												min={ 50 }
												max={ 600 }
												step={ 50 }
												value={ heroHeight }
												onChange={ value => setAttributes( { heroHeight: value } ) }
											/>
													</PanelBody>
												</InspectorControls>
												);

												return (
													<Fragment>
													{ inspectorControls }
													<div className={ className }>
												<div className="media">
													<MediaUpload
													onSelect={ selectImage }
													render={ ( { open } ) => {
														return (
															<button onClick={ open }>
														<img
															src={ imgUrl }
															alt="Hero"
															key={ imgId }
														/>
															</button>
														);
													} }
													/>

												</div>
														</div>
													</Fragment>
												);
					},
					save() {
																return null;
					},
				}
			);
