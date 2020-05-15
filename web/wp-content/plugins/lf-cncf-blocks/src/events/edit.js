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
const { InspectorControls } = wp.blockEditor || wp.editor;
const { RangeControl, PanelBody, SelectControl, Placeholder, Spinner } = wp.components;
const { withSelect } = wp.data;

class Events extends Component {
	renderControl = () => {
		const { attributes, setAttributes, categories } = this.props;
		const { category, numberposts } = attributes;

		// get the list of categories to select.
		const menuOptions = [
			{ value: ' ', label: __( 'Show All' ) },
			...categories.map( x => ( { value: x.id, label: x.name } ) ),
		];

		return (
			<InspectorControls key="lf-upcoming-events-block-panel">
				<PanelBody title={ __( 'Settings' ) } initialOpen={ true }>
					<SelectControl
						label={ __( 'Event Host' ) }
						value={ category }
						options={ menuOptions }
						onChange={ value =>
							setAttributes( { category: '' !== value ? value : '' } ) }
					/>
					<RangeControl
						label={ __( 'Number of Events' ) }
						min={ 1 }
						max={ 100 }
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
		// setup time for now.
		const now = new Date();

		const data = posts
		// filter out old events before today.
			.filter(
				 ( p ) => {
				const eventDate = new Date( p.meta.cncf_event_date_start );
				return eventDate >= now;
			}
				)
		// sort in date order.
			.sort(
				 ( a, b ) => {
				a = new Date( a.meta.cncf_event_date_start );
				b = new Date( b.meta.cncf_event_date_start );
				return a < b ? -1 : a > b ? 1 : 0;
			}
				)
			.slice( 0, numberposts );

		return (
			<div className="events-wrapper">
				{ data.map(
					post => (
						<article className="event-box" key={ post.id } style={ { backgroundColor: '#617EBF' } }>
							<div className="event-content-wrapper-editor">
								<h4 className="event-title" dangerouslySetInnerHTML={ { __html: post.title.rendered } } />
								<span className="event-date">{ post.meta.cncf_event_date_start }</span>
								<span className="event-city">{ post.meta.cncf_event_city }</span>
								<span className="button transparent outline ">Learn More</span>
							</div>
						</article>
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
		const { category, numberposts } = props.attributes;
		const latestPostsQuery = pickBy(
			{
				'cncf-event-host': category,
				per_page: numberposts,
			},
			( value ) => ! isUndefined( value )
		);
		return {
			posts: getEntityRecords( 'postType', 'cncf_event', latestPostsQuery ),
			categories: getEntityRecords( 'taxonomy', 'cncf-event-host' ) || [],
		};
	}
)( Events );
