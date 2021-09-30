/**
 * Register Pre Publish Checklists
 *
 * @package WordPress
 * @since 1.0.0
 */

/*
 * @phpcs:disable WordPress.WhiteSpace.OperatorSpacing.NoSpaceAfter
 * @phpcs:disable WordPress.WhiteSpace.OperatorSpacing.NoSpaceBefore
 * @phpcs:disable Generic.WhiteSpace.ScopeIndent.IncorrectExact
 * @phpcs:disable Generic.WhiteSpace.ScopeIndent.Incorrect
 * @phpcs:disable PEAR.Functions.FunctionCallSignature.Indent
 */

const { registerPlugin } = wp.plugins;
const { PluginPrePublishPanel } = wp.editPost;
const { select, dispatch } = wp.data;
const { count } = wp.wordcount;
const { serialize } = wp.blocks;
const { Fragment, useEffect } = wp.element;
const { getMedia } = select( 'core' );

const iconError = (
	<svg
		xmlns="http://www.w3.org/2000/svg"
		width="24"
		height="24"
		viewBox="0 0 24 24"
	>
		<path
			fill="#cc0000"
			d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm4.151 17.943l-4.143-4.102-4.117 4.159-1.833-1.833 4.104-4.157-4.162-4.119 1.833-1.833 4.155 4.102 4.106-4.16 1.849 1.849-4.1 4.141 4.157 4.104-1.849 1.849z"
		/>
	</svg>
);

const iconWarning = (
	<svg
		xmlns="http://www.w3.org/2000/svg"
		width="24"
		height="24"
		viewBox="0 0 24 24"
	>
		<path
			fill="#F17E28"
			d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1 5h2v10h-2v-10zm1 14.25c-.69 0-1.25-.56-1.25-1.25s.56-1.25 1.25-1.25 1.25.56 1.25 1.25-.56 1.25-1.25 1.25z"
		/>
	</svg>
);

const iconSuccess = (
	<svg
		xmlns="http://www.w3.org/2000/svg"
		width="24"
		height="24"
		viewBox="0 0 24 24"
	>
		<path
			fill="#4CA76A"
			d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.959 17l-4.5-4.319 1.395-1.435 3.08 2.937 7.021-7.183 1.422 1.409-8.418 8.591z"
		/>
	</svg>
);

/**
 * CSS in JS styles.
 */
const ppcHeader = {
	fontSize: '20px',
	fontWeight: '700',
	marginLeft: '10px',
};

const lockPost = false;

/**
 * Results component for displaying feedback.
 *
 * @param {*} props Props.
 * @return {string} Result component.
 */
const Result = ( props ) => {
	return (
		<Fragment>
			<div style={ { display: 'flex', alignItems: 'center' } }>
				{ props.icon } <span style={ ppcHeader }>{ props.title }</span>
			</div>
			<p>{ props.message }</p>
		</Fragment>
	);
};

/**
 * Count words in posts.
 *
 * @return {string} Result.
 */
function countWords() {
	const blocks = select( 'core/block-editor' ).getBlocks();
	// Get the word count.
	const wordCount = count( serialize( blocks ), 'words' );
	let wordCountResult;
	const resultTitle = 'Word Count - ';

	if ( wordCount <= 300 ) {
		wordCountResult = (
			<Result
				icon={ iconWarning }
				title={ resultTitle + wordCount }
				message="Posts under 300 words will likely not rank on Google."
			/>
		);
	}

	if ( wordCount > 300 && wordCount < 500 ) {
		wordCountResult = (
			<Result
				icon={ iconWarning }
				title={ resultTitle + wordCount }
				message="Posts should have over 500 words to improve chances of Google ranking."
			/>
		);
	}

	if ( wordCount >= 500 && wordCount < 1500 ) {
		wordCountResult = (
			<Result
				icon={ iconSuccess }
				title={ resultTitle + wordCount }
				message="The length of this post is great!"
			/>
		);
	}

	if ( wordCount >= 1500 ) {
		wordCountResult = (
			<Result
				icon={ iconSuccess }
				title={ resultTitle + wordCount }
				message="Perfect! This is long form content that Google will love."
			/>
		);
	}

	return wordCountResult;
}

/**
 * Count Categories and give feedback.
 *
 * @return {string} Result.
 */
function countCategories() {
	const categories = select( 'core/editor' ).getEditedPostAttribute(
		'categories'
	);

	let countCategoriesResult;
	const resultTitle = 'Post Category';

	if ( categories.length === 0 ) {
		countCategoriesResult = (
			<Result
				icon={ iconError }
				title={ resultTitle }
				message="You need to choose a category for the post."
			/>
		);
	}

	if ( categories.length === 1 ) {
		countCategoriesResult = (
			<Result
				icon={ iconSuccess }
				title={ resultTitle }
				message="You have chosen a category for this post."
			/>
		);
	}

	if ( categories.length > 1 ) {
		countCategoriesResult = (
			<Result
				icon={ iconError }
				title={ resultTitle }
				message="You have chosen more than one category. Please only select one category."
			/>
		);
	}

	return countCategoriesResult;
}

/**
 * Check for H1 heading level content in array.
 *
 * @param {*} block Gutenberg block.
 * @return {boolean} True or false match.
 */
function checkH1( block ) {
	return block.attributes.level === 1 && block.name === 'core/heading';
}

/**
 * Count H1 headings in block content.
 *
 * @return {Object} Result
 */
function countH1() {
	const blocks = select( 'core/block-editor' ).getBlocks();

	if ( ! blocks.some( checkH1 ) ) {
		return null;
	}

	const countH1Result = (
		<Result
			icon={ iconError }
			title="H1 Headers"
			message="You shouldn't have H1 header tags in the body content. Consider switching to H2."
		/>
	);

	return countH1Result;
}

/**
 * Check Webinar Date is present.
 *
 * @return {string} result.
 */
function checkWebinarDate() {
	// check for webinar date.
	const date = select( 'core/editor' ).getEditedPostAttribute( 'meta' )
		.lf_webinar_date;

	if ( date ) {
		return null;
	}

	return (
		<Result
			icon={ iconError }
			title="Webinar Date"
			message="A date should be set for the webinar."
		/>
	);
}

/**
 * Check for presence of featured image ID.
 *
 * @return { number } result.
 */
function getFeaturedImageId() {
	// Get the featured image ID.
	const featuredImageId = select( 'core/editor' ).getEditedPostAttribute(
		'featured_media'
	);

	if ( featuredImageId === 0 ) {
		return null;
	}
	return featuredImageId;
}

/**
 * Check presence of Featured Image.
 *
 * @return {string} result.
 */
function checkFeaturedImage() {
	if ( getFeaturedImageId() ) {
		return null;
	}

	return (
		<Result
			icon={ iconError }
			title="Featured Image"
			message="There is no featured image set. Featured images are required for all blog and announcement posts."
		/>
	);
}

/**
 * Check for publishing lock.
 */
function CheckPublishing() {
	useEffect(
		 () => {
		if ( lockPost === true ) {
					dispatch( 'core/editor' ).lockPostSaving();
		} else {
					dispatch( 'core/editor' ).unlockPostSaving();
		}
	}
		);
}

/**
 * Runs the checks on Post featured images.
 *
 * @return {string} result.
 */
function postImages() {
	// Get the featured image.
	const featuredImageID = select( 'core/editor' ).getEditedPostAttribute(
		'featured_media'
	);

	const featuredImageObj = featuredImageID
		? getMedia( featuredImageID )
		: null;
	if ( featuredImageID === 0 ) {
		return null;
	}

	if (
		featuredImageID &&
		typeof featuredImageObj === 'object' &&
		featuredImageObj !== null
	) {
		const featuredWidth = featuredImageObj.media_details.width;

		const featuredHeight = featuredImageObj.media_details.height;

		const imageTitle = 'Featured Image Size';

		if ( featuredWidth < 540 || featuredHeight < 285 ) {
			return (
				<Result
					icon={ iconError }
					title={ imageTitle }
					message="Your featured image size is too small. It needs to be at least 540px width and 285px height. Ideal size for blog posts is 1200x630px."
				/>
			);
		}
		if (
			( featuredWidth >= 540 && featuredWidth < 1200 ) ||
			( featuredHeight >= 285 && featuredHeight < 630 )
		) {
			return (
				<Result
					icon={ iconWarning }
					title={ imageTitle }
					message="Your featured image size meets the minimum requirements, but we would recommend using a size of at least 1200x630px."
				/>
			);
		}
		return (
			<Result
				icon={ iconSuccess }
				title={ imageTitle }
				message="The featured image is a great size!"
			/>
		);
	}
	return null;
}

/**
 * Runs the checks on Page featured images.
 *
 * @return {string} result.
 */
function pageImages() {
	// Get the featured image.
	const featuredImageID = select( 'core/editor' ).getEditedPostAttribute(
		'featured_media'
	);

	const imageTitle = 'Featured Image';

	const featuredImageObj = featuredImageID
		? getMedia( featuredImageID )
		: null;
	if ( featuredImageID === 0 ) {
		return (
			<Result
				icon={ iconWarning }
				title={ imageTitle }
				message="It's recommended to set a featured image so that the page will have a unique heading."
			/>
		);
	}

	if (
		featuredImageID &&
		typeof featuredImageObj === 'object' &&
		featuredImageObj !== null
	) {
		const featuredWidth = featuredImageObj.media_details.width;

		const featuredHeight = featuredImageObj.media_details.height;

		if ( featuredWidth < 1440 || featuredHeight < 260 ) {
			return (
				<Result
					icon={ iconError }
					title={ imageTitle }
					message="The featured image is too small. We recommend a size of 1440x260px."
				/>
			);
		}
		return (
			<Result
				icon={ iconSuccess }
				title={ imageTitle }
				message="The featured image is a great size!"
			/>
		);
	}
	return null;
}

/**
 * Pre Publish Checklist container.
 *
 * @return {string} checklist.
 */
const PrePublishCheckList = () => {
	// specify which post types will display Pre Publish Checklists.
	const displayChecklistsOn = [ 'post', 'page', 'lf_webinar' ];

	// get the post type of whatever post we are.
	const postType = wp.data.select( 'core/editor' ).getCurrentPostType();

	// check if external URL is set on News post.
	const hasNewsExternalLink = select( 'core/editor' ).getEditedPostAttribute(
		'meta'
	).lf_post_external_url;

	// don't load PPC if post is already published, post type not in array, or if post is News.
	if (
		wp.data.select( 'core/editor' ).isCurrentPostPublished() ||
		! displayChecklistsOn.includes( postType ) ||
		hasNewsExternalLink
	) {
	return null;
	}

	/**
	 * To run on Post post type.
	 *
	 * @return {string} content.
	 */
	function runOnPost() {
	if ( 'post' !== postType ) {
		return null;
		}

	return (
	<div>
	{ checkFeaturedImage() }
	{ postImages() }
	{ countCategories() }
	{ countH1() }
	{ countWords() }
	{ CheckPublishing() }
	</div>
);
	}

	/**
	 * To run on Page post type.
	 *
	 * @return {string} content.
	 */
	function runOnPage() {
	if ( 'page' !== postType ) {
		return null;
		}
	return (
	<div>
	{ pageImages() }
	{ countH1() }
	{ countWords() }
	</div>
);
	}

	/**
	 * To run on Webinar post type.
	 *
	 * @return {string} content.
	 */
	function runOnWebinar() {
	if ( 'lf_webinar' !== postType ) {
		return null;
		}
	return <div>{ checkWebinarDate() }</div>;
	}

	return (
		<PluginPrePublishPanel
			title={ 'Pre-Publish Checklist' }
			initialOpen={ true }
			icon="clipboard"
		>
			<span
				style={ {
					fontStyle: 'italic',
					marginBottom: '20px',
					display: 'block',
				} }
			>
				Save draft, or preview post, to run all the below checks.
			</span>

			{ runOnPost() }
			{ runOnPage() }
			{ runOnWebinar() }
		</PluginPrePublishPanel>
	);
};

registerPlugin( 'pre-publish-checklist', { render: PrePublishCheckList } );
