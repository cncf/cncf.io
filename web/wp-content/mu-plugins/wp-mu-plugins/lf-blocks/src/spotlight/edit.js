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

/* eslint-disable no-nested-ternary */

import pickBy from 'lodash/pickBy';
import isUndefined from 'lodash/isUndefined';

const { __ } = wp.i18n;
const { Component, Fragment } = wp.element;
const { InspectorControls } = wp.blockEditor;
const { RangeControl, PanelBody, Placeholder, Spinner } = wp.components;
const { withSelect } = wp.data;

// import helper functions.
import { formatDate } from '../helper-functions.js';

class Spotlights extends Component {
renderControl = () => {
	const { attributes, setAttributes } = this.props;
	const { numberposts } = attributes;

	return (
		<InspectorControls key="lf-spotlights-block-panel">
			<PanelBody title={ __( 'Settings' ) } initialOpen={ true }>
				<RangeControl
					label={ __( 'Number of Spotlights' ) }
					min={ 1 }
					max={ 12 }
					value={ numberposts }
					onChange={ value => setAttributes( { numberposts: value } ) }
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

	const data = posts.slice( 0, numberposts );
	return (
		<div className="spotlights-wrapper">
			{ data.map(
				post => (
					<div className="spotlight-box" key={ post.id }>
						<div className="spotlight-photo">
							<img className="spotlight" src="https://via.placeholder.com/320x170/d9d9d9/000000" alt="Spotlight Thumbnail" />
						</div>
						<h5 className="spotlight-title" dangerouslySetInnerHTML={ { __html: post.title.rendered } } />
						<span className="nr-date">{ formatDate( post.date ) }</span>
					</div>
				)
			)
			}
		</div>
	);
}

render() {
	const { posts, className } = this.props;

	return ! posts ? (
		<Placeholder label={ __( 'Loading...' ) }>
			<Spinner />
		</Placeholder>
	) : (
		<Fragment>
			{ this.renderControl() }
			<div className={ className }>
				<div className={ `${ className }__block` }>
					{ this.renderList() }
				</div>
			</div>
		</Fragment>
	);
}
}

export default withSelect(
	( select, props ) => {
		const { getEntityRecords } = select( 'core' );
		const { numberposts } = props.attributes;
		const latestPostsQuery = pickBy(
			{
				per_page: numberposts,
			},
			( value ) => ! isUndefined( value )
		);
		return {
			posts: getEntityRecords( 'postType', 'lf_spotlight', latestPostsQuery ),
		};
	}
)( Spotlights );
