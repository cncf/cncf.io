<?php
/**
 * Silver Member Pricing Table
 *
 * Used on Join and End Users.
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

wp_enqueue_style( 'wp-block-table' );

?>

<!-- Modal -->
<div class="modal-hide" id="modal-silver" aria-hidden="true">
	<div class="modal-content-wrapper">
		<div class="modal__content" id="modal-silver-content">

			<h3>Silver Member Pricing Scale</h3>

			<div style="height:30px" aria-hidden="true" class="wp-block-spacer"></div>
			<p>The Linux Foundation membership is required to participate in CNCF.<br/>
			(CNCF and LF memberships are invoiced separately)</p>

			<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>

			<figure class="wp-block-table is-style-shaded">
				<table class="has-fixed-layout">
					<caption class="screen-reader-text">Silver Member Pricing
						Scale</caption>
					<thead>
						<tr>
							<th>Consolidated employees</th>
							<th>CNCF membership</th>
							<th>CNCF + LF combined membership</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>5,000 employees +</td>
							<td>$50,000</td>
							<td>$70,000</td>
						</tr>
						<tr>
							<td>3,000 – 4,999 employees</td>
							<td>$50,000</td>
							<td>$65,000</td>
						</tr>
						<tr>
							<td>1,000 – 2,999 employees</td>
							<td>$30,000</td>
							<td>$45,000</td>
						</tr>
						<tr>
							<td>500 – 999 employees</td>
							<td>$10,000</td>
							<td>$25,000</td>
						</tr>
						<tr>
							<td>100 – 499 employees</td>
							<td>$5,000</td>
							<td>$15,000</td>
						</tr>
						<tr>
							<td>50 – 99 employees</td>
							<td>$5,000</td>
							<td>$10,000</td>
						</tr>
						<tr>
							<td>Under 50 employees</td>
							<td>$2,000</td>
							<td>$7,000</td>
						</tr>
					</tbody>
				</table>
			</figure>
		</div>
	</div>
</div>
