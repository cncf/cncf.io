const { Fragment } = wp.element;

export default ( { attributes } ) => {
	const getItemMarkup = ( fields, index ) => {
		return (
			<div key={ index } className={ `count-up-item lf-count-up-columns-${ index }` } style={ { textAlign: 'center' } }>
				<img src={ fields[ `icon${ index }` ] } alt="" />
				<div className="lf-counter"
					style={ { fontSize: '35px' } }
				>
					<span className="lf-counter-number">{ fields[ `countUpNumber${ index }` ] }</span>
				</div>
				<p className="lf-count-up-desc">
					{ fields[ `descText${ index }` ] }
				</p>
			</div>
		);
	};

	return (
		<Fragment>
			<div>
				{ attributes.sectionText }
			</div>
			<div className="lf-count-up" style={ { display: 'flex' } }>
				{ Array.from( { length: attributes.columns }, ( _, i ) => i + 1 ).map( index => {
					return getItemMarkup( attributes, index );
				} ) }
			</div>
		</Fragment>
	);
};
