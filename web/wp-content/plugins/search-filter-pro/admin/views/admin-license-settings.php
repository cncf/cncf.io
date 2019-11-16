<?php
/**
 * Search & Filter Pro
 * 
 * @package   Search_Filter
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */
?>

<div class="wrap">
	
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
	
	<h3><?php _e('Search &amp; Filter License'); ?></h3>
	<form method="post" action="options.php">
		
		<?php settings_fields('search_filter_license'); ?>
		<?php _e('Enter your license key to enable updates.'); ?>
		<table class="form-table">
			<tbody>
				<tr valign="top">	
					<th scope="row" valign="top">
						<?php _e('License Key'); ?>
					</th>
					<td>
						<input id="search_filter_license_key" name="search_filter_license_key" type="text" class="regular-text" value="<?php esc_attr_e( $license ); ?>" />
						<label class="description" for="search_filter_license_key"><?php _e('Enter your license key'); ?></label>
					</td>
				</tr>
				<?php if( false !== $license ) { ?>
					<tr valign="top">	
						<th scope="row" valign="top">
							<?php _e('Activate License'); ?>
						</th>
						<td>
							<?php if( $status !== false && $status == 'valid' ) { ?>
								<span style="color:green;"><?php _e('active'); ?></span>
								<?php wp_nonce_field( 'search_filter_nonce', 'search_filter_nonce' ); ?>
								<input type="submit" class="button-secondary" name="edd_license_deactivate" value="<?php _e('Deactivate License'); ?>"/>
							<?php } else {
								wp_nonce_field( 'search_filter_nonce', 'search_filter_nonce' ); ?>
								<input type="submit" class="button-secondary" name="search_filter_license_activate" value="<?php _e('Activate License'); ?>"/>
							<?php } ?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>	
		<?php submit_button(); ?>
	
	</form>
</div>
