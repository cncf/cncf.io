/**
 * Edit screen code
 *
 * @package WordPress
 * @since 1.0.0
 *
 * @phpcs:disable WordPress.WhiteSpace.OperatorSpacing.NoSpaceAfter
 * @phpcs:disable WordPress.WhiteSpace.OperatorSpacing.NoSpaceBefore
 * @phpcs:disable Generic.WhiteSpace.ScopeIndent.IncorrectExact
 * @phpcs:disable Generic.WhiteSpace.ScopeIndent.Incorrect
 * @phpcs:disable PEAR.Functions.FunctionCallSignature.Indent
 */

import head from 'lodash/head';
import mapValues from 'lodash/mapValues';
import pickBy from 'lodash/pickBy';
import isUndefined from 'lodash/isUndefined';

const { __ } = wp.i18n;
const { Component, Fragment } = wp.element;
const { InspectorControls } = wp.blockEditor;
const { RangeControl, PanelBody, ToggleControl, SelectControl, Placeholder, Spinner } = wp.components;
const { withSelect } = wp.data;

// import helper functions.
import { formatDate } from '../helper-functions.js';

class Newsroom extends Component {
	constructor() {
		super( ...arguments );
		this.toggleAttribute = this.toggleAttribute.bind( this );
	}

	toggleAttribute( attribute ) {
		return ( newValue ) => {
			this.props.setAttributes( { [ attribute ]: newValue } );
		};
	}

renderControl = () => {
	const { attributes, setAttributes, categories } = this.props;
	const { category, numberposts, showImages, showBorder, order } = attributes;

	// get the list of categories to select.
	const menuOptions = [
		{ value: ' ', label: __( 'All Posts' ) },
		...categories.map( x => ( { value: x.id, label: x.name } ) ),
	];

	return (
		<InspectorControls key="lf-newsroom-block-panel">
			<PanelBody title={ __( 'Settings' ) } initialOpen={ true }>

				<SelectControl
					label={ __( 'Category' ) }
					value={ category }
					options={ menuOptions }
					onChange={ value =>
						setAttributes( { category: '' !== value ? value : '' } )
					}
				/>
				<RangeControl
					label={ __( 'Number of Posts' ) }
					min={ 1 }
					max={ 12 }
					value={ numberposts }
					onChange={ value => setAttributes( { numberposts: value } ) }
				/>
				<SelectControl
					label={ __( 'Order' ) }
					value={ order }
					options={ [
						{
							label: __( 'Newest Posts First' ),
							value: 'desc',
						},
						{
							label: __( 'Oldest Posts First' ),
							value: 'asc',
						},
					] }
					onChange={ ( value ) => setAttributes( { order: value } ) }
				/>
				<ToggleControl
					label={ __( 'Show Images' ) }
					help={ showImages ? 'Featured images are shown.' : 'No images are shown.' }
					checked={ showImages }
					onChange={ this.toggleAttribute( 'showImages' ) }
				/>
				<ToggleControl
					label={ __( 'Show Image Border' ) }
					help={ showBorder ? 'Image border is now displayed.' : 'No border is shown.' }
					checked={ showBorder }
					onChange={ this.toggleAttribute( 'showBorder' ) }
				/>
			</PanelBody>
		</InspectorControls>
	);
}

renderList = () => {
	const {
		attributes: { numberposts },
		posts,
	} = this.props;
	const data = posts.map( p => ( { ...p, meta: mapValues( p.meta, head ) } ) ).slice( 0, numberposts );

	return (
		<Fragment>
			{ data.map(
				post => (
					<div key={ post.id } className="newsroom-post-wrapper">
						{ this.props.attributes.showImages &&
							<div className="newsroom-image-wrapper">
								<img src={ post.featured_image_src ? post.featured_image_src : 'https://via.placeholder.com/325x171/d9d9d9/000000' } alt="Post Thumbnail" />
							</div>
						}
						<p
							className="newsroom-title"
							dangerouslySetInnerHTML={ { __html: post.title.rendered } }
						/>
						<span className="newsroom-date">{ formatDate( post.date ) }</span>
					</div>
				)
			)
			}
		</Fragment>
	);
}

render() {
	const { posts, className, attributes } = this.props;
	const { showBorder } = attributes;

	return ! posts ? (
		<Placeholder label={ __( 'Loading...' ) }>
			<Spinner />
		</Placeholder>
	) : (
		<Fragment>
			{ this.renderControl() }
			<div className={ ` ${ className } ${ showBorder ? 'has-images-border' : '' } ` }>
				{ this.renderList() }
			</div>
		</Fragment>
	);
}
}

export default withSelect(
	( select, props ) => {
		const { getEntityRecords } = select( 'core' );
		const { category, order, numberposts } = props.attributes;
		const latestPostsQuery = pickBy(
			{
				categories: category,
				order,
				per_page: numberposts,
			},
			( value ) => ! isUndefined( value )
		);
		return {
			posts: getEntityRecords( 'postType', 'post', latestPostsQuery ),
			categories: getEntityRecords( 'taxonomy', 'category' ) || [],
		};
	}
)( Newsroom );
