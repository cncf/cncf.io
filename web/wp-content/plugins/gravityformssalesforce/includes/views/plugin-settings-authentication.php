<?php
/**
 * Salesforce Plugin Settings Authentication Instructions
 * 
 * @since  0.1
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
?>
<div id="salesforce-authentication-instructions">

	<?php if ( empty( $settings[ 'instance' ] ) || empty( $settings[ 'client_id' ] ) || empty( $settings[ 'client_secret' ] ) ) { ?>

		<?php _e( 'Enter and save your Salesforce instance ID, Client ID, and Client Secret first.', 'gravityformssalesforce' ) ?>

	<?php } else if ( $authenticate ) { ?>

		<?php if ( ! empty( $authorization_url ) ) { ?>

			<a href="<?php echo $authorization_url ?>">
				<input type="button" class="button-secondary gfbutton" value="<?php _e( 'Authorize', 'gravityformssalesforce' ) ?>"/>
			</a>


		<?php } else { ?>

			<?php _e( 'Unable to authorize', 'gravityformssalesforce' ) ?>

		<?php } ?>

	<?php } else { ?>

		<?php _e( 'Authorized!', 'gravityformssalesforce' ) ?>

	<?php } ?>
</div>