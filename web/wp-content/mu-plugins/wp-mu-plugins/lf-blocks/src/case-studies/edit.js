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

class CaseStudies extends Component {
	renderControl = () => {
		const { attributes, setAttributes } = this.props;
		const { numberposts } = attributes;

		return (
			<InspectorControls key="lf-case-studies-block-panel">
				<PanelBody title={ __( 'Settings' ) } initialOpen={ true }>
					<RangeControl
						label={ __( 'Number of Case Studies' ) }
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
			<div className="case-studies-wrapper">
				{ data.map(
					post => (
						<div className="case-study-box" key={ post.id } style={ { backgroundColor: '#2a0552' } }>

							<div className="case-study-content-wrapper">
								<div className="title-stat-date-type">
									<h2 className="case-study-title" dangerouslySetInnerHTML={ { __html: post.title.rendered } } />
									<p className="case-study-stat"><span>{ post.meta.lf_case_study_key_stat }</span>{ post.meta.lf_case_study_key_stat_label }</p>
									<p className="case-study-date date-icon">{ formatDate( post.date ) }</p>
									<div className="case-study-project-type">Project,
										Project</div>
								</div>

								<div className="marketing-title-and-cta">
									<p className="case-study-long-title">{ post.meta.lf_case_study_long_title }</p>
									<span className="case-study-cta hs-button on-image">Read Case Study</span>
								</div>

							</div>
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
			<Placeholder label={ __( 'Case Studies - Loading...' ) }>
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
			posts: getEntityRecords( 'postType', 'lf_case_study', latestPostsQuery ),
		};
	}
)( CaseStudies );
