/**
 * Inspector
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
const { Component } = wp.element;
const { InspectorControls } = wp.blockEditor;
const { PanelBody, TextControl, Button, ToggleControl } = wp.components;

/**
 * Inspector controls
 */
export default class Inspector extends Component {
	render() {
		const { attributes, setAttributes } = this.props;

		const {
			youtubeId,
			youtubeUrl,
			youtubeTitle,
			youtubeWebPStatus,
			youtubeSdStatus,
		} = attributes;

		function getYouTubeId( url ) {
			// regex to extract YouTube ID.
			const regex = /^.*(?:(?:youtu\.be\/|v\/|vi\/|u\/\w\/|embed\/)|(?:(?:watch)?\?v(?:i)?=|\&v(?:i)?=))([^#\&\?]*).*/;
			const id = url.match( regex );
			return id[ 1 ];
		}

		/**
		 * Get and set the ID
		 *
		 * @param {string} changes Video URL
		 */
		function getAndSetYouTubeId( changes ) {
			setAttributes(
				{
					youtubeUrl: changes,
					youtubeId: getYouTubeId( changes ),
				}
			);
		}

		/**
		 * Get and set the ID
		 */
		function clearVideoId() {
			setAttributes(
				 {
				youtubeUrl: null,
				youtubeId: null,
				youtubeTitle: null,
			}
				);
		}

		return (
			<InspectorControls key="inspector">
				<PanelBody title={ __( 'Settings' ) } >
					<TextControl
						label={ __( 'YouTube URL' ) }
						help="Enter the YouTube URL for the video to embed and we will extract the YouTube video ID."
						value={ youtubeUrl || '' }
						onChange={ getAndSetYouTubeId }
					/>
					<TextControl
						label={ __( 'YouTube ID' ) }
						help="Enter the YouTube video ID here, or paste your URL above and the ID will be extracted automatically."
						value={ youtubeId || '' }
						onChange={ ( value ) => {
							setAttributes( { youtubeId: value } );
						} }
					/>
					<TextControl
						label={ __( 'Video Title' ) }
						help={ __(
							'Enter the video title used for alt text and SEO.'
						) }
						value={ youtubeTitle || '' }
						onChange={ ( value ) => {
							setAttributes( { youtubeTitle: value } );
						} }
					/>
					<Button
						isSecondary
						label={ __( 'Clear' ) }
						onClick={ clearVideoId }
					>
						Clear
					</Button>
				</PanelBody>
				<PanelBody title={ __( 'Advanced Settings' ) } >
					<ToggleControl
						label="Show webP Thumbnail"
						help={
							youtubeWebPStatus ? 'Displays webP' : 'Uses JPEG thumbnail'
						}
						checked={ youtubeWebPStatus }
						onChange={ () =>
							setAttributes(
								 {
								youtubeWebPStatus: ! youtubeWebPStatus,
							}
								)
						}
					/>
					<ToggleControl
						label="Show old JPG thumbnail"
						help={
							youtubeSdStatus ? 'Use newer HQ JPEG thumbnail' : 'Displays classic JPG'
						}
						checked={ youtubeSdStatus }
						onChange={ () =>
							setAttributes(
								 {
								youtubeSdStatus: ! youtubeSdStatus,
							}
								)
						}
					/>
				</PanelBody>
			</InspectorControls>
		);
	}
}
