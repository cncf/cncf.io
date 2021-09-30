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
import Inspector from './inspector';

const { __ } = wp.i18n;
const { Fragment } = wp.element;
const { Placeholder } = wp.components;
const { registerBlockType, createBlock } = wp.blocks;

const youtubeIcon = {
	src: <svg width="797" height="713" viewBox="0 0 797 713" xmlns="http://www.w3.org/2000/svg"><path fill="none" d="M-1 -1H798V714H-1z" /><g><rect x="138.333" y="11.667" fill="red" rx="15%" height="512" width="512" /><path fill="#fff" d="M565.333 180.667c-4-15-17-27-32-31-34-9-239-10-278 0-15 4-28 16-32 31-9 38-10 135 0 174 4 15 17 27 32 31 36 10 241 10 278 0 15-4 28-16 32-31 9-36 9-137 0-174" /><path fill="red" d="M358.333 214.667v106l93-53" /><text fontFamily="Helvetica, Arial, sans-serif" fontSize="207" y="693.667" x="177.667" stroke="null">LITE</text></g></svg>,
};

registerBlockType(
	'lf/youtube-lite',
	{
		title: __( 'LF | YouTube Lite' ),
		description: __( 'A YouTube embed without the performance drag and GDPR tracking nonsense' ),
		icon: youtubeIcon,
		category: 'lf',
		keywords: [
			__( 'youtube' ),
			__( 'you tube' ),
			__( 'video' ),
			__( 'embed' ),
			__( 'lf' ),
		],
		example: {},
		attributes: {
			youtubeUrl: {
				type: 'string',
			},
			youtubeId: {
				type: 'string',
			},
			youtubeTitle: {
				type: 'string',
			},
			youtubeWebPStatus: {
				type: 'boolean',
				default: true,
			},
			youtubeSdStatus: {
						type: 'boolean',
						default: false,
					},
				},

				edit: function( props ) {
									const { attributes, icon, className } = props;

									const blockContent = attributes.youtubeId ? (
										<div className={ className }>
								<div className="stop-video-click"></div>
								<iframe
									width="560"
									height="349"
									src={ `https://www.youtube-nocookie.com/embed/${ attributes.youtubeId }?autoplay=0` }
									allowFullScreen
									title="YouTube Embed"
								></iframe></div> ) :
										<Placeholder
								icon={ icon }
								label={ __( 'Enter the YouTube URL or ID in the sidebar' ) }
										/>;

									return (
										<Fragment>
								<Inspector { ...props } />
								{ blockContent }
										</Fragment>
									);
				},

				save: function( props ) {
										const { attributes } = props;

										const {
									youtubeId,
									youtubeTitle,
									youtubeWebPStatus,
									youtubeSdStatus,
													} = attributes;

										function returnWebpStatus() {
						return youtubeWebPStatus ? '1' : '0';
										}

										function returnSdStatus() {
					return youtubeSdStatus ? '1' : '0';
										}

										return (
										<Fragment>
								{ youtubeId && (
									<div className={ 'wp-block-lf-youtube-lite' }>
										<lite-youtube
											videoid={ youtubeId }
											videotitle={ youtubeTitle }
											webpStatus={ returnWebpStatus() }
											sdthumbStatus={ returnSdStatus() }
											autoload
										></lite-youtube>
									</div>
								) }
										</Fragment>
										);
				},
				deprecated: [
					{
								attributes: {
									youtubeUrl: {
										type: 'string',
									},
									youtubeId: {
										type: 'string',
									},
										},
								save: ( props ) => {
									const { attributes } = props;
									return (
										<Fragment>
									<div className={ 'wp-block-lf-youtube-lite' }>
										<lite-youtube
									videoid={ attributes.youtubeId }
									autoload
										></lite-youtube>
									</div>
										</Fragment>
									);
								},
					},
				],
			}
		);
