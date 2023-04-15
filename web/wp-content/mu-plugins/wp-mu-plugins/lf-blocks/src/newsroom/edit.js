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
	const { attributes, setAttributes, categories, authorCategories } = this.props;
	const { category, authorCategory, numberposts, order } = attributes;

	// get the list of categories to select.
	const categoryMenuOptions = [
		{ value: ' ', label: __( 'All Posts' ) },
		...categories.map( x => ( { value: x.id, label: x.name } ) ),
	];

	let authorCategoryMenuOptions = [];
	if (authorCategories) {
	authorCategoryMenuOptions = [
			{ value: ' ', label: __( 'All Posts' ) },
			...authorCategories.map( x => ( { value: x.id, label: x.name } ) ),
		];
	}

	return (
		<InspectorControls key="lf-newsroom-block-panel">
			<PanelBody title={ __( 'Settings' ) } initialOpen={ true }>

				<SelectControl
					label={ __( 'Category' ) }
					value={ category }
					options={ categoryMenuOptions }
					onChange={ value =>
						setAttributes( { category: '' !== value ? value : '' } )
					}
				/>
				<SelectControl
					label={ __( 'Author Category' ) }
					value={ authorCategory }
					options={ authorCategoryMenuOptions }
					onChange={ value =>
						setAttributes( { authorCategory: '' !== value ? value : '' } )
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
							<div className="newsroom-image-wrapper">
								<img src={ post.featured_image_src ? post.featured_image_src : 'https://via.placeholder.com/325x171/d9d9d9/000000' } alt="Post Thumbnail" />
							</div>
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

	return ! posts ? (
		<Placeholder label={ __( 'Loading...' ) }>
			<Spinner />
		</Placeholder>
	) : (
		<Fragment>
			{ this.renderControl() }
			<div className={ `${ className }` }>
				{ this.renderList() }
			</div>
		</Fragment>
	);
}
}
export default withSelect(
  ( select, props ) => {
    const { getEntityRecords } = select( 'core' );
    const { category, authorCategory, numberposts, order } = props.attributes;
		return {
        posts: getEntityRecords('postType', 'post', {
					categories: category,
					'lf-author-category': authorCategory,
					per_page: numberposts,
					order,
				}),
        categories: getEntityRecords('taxonomy', 'category') || [],
        authorCategories: getEntityRecords('taxonomy', 'lf-author-category') || [],
      };

  }
)( Newsroom );
