/**
 * Helper Functions
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

const { __ } = wp.i18n;

// Format Date.
export const formatDate = date => {
	const monthNames = [
		__( 'January' ), __( 'February' ), __( 'March' ),
		__( 'April' ), __( 'May' ), __( 'June' ), __( 'July' ),
		__( 'August' ), __( 'September' ), __( 'October' ),
		__( 'November' ), __( 'December' ),
	];
	date = new Date( date );
	const day = date.getDate();
	const monthIndex = date.getMonth();
	const year = date.getFullYear();
	return day + ' ' + monthNames[ monthIndex ] + ', ' + year;
};
