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
                        <input type="submit" class="button" value="Save Changes" style="display:inline-block;">

					</td>
				</tr>
				<?php if( $status !== false ) { ?>
                <tr valign="top">
                    <th scope="row" valign="top">
						<?php _e('License Status'); ?>
                    </th>
                    <td>
                        <?php
					        if($status === "invalid") {

                                echo '<span style="color:red;">';//<?php _e('Invalid: ');
						        if ( $error === "expired" ){
							        echo ucwords($error);
                                }
                                else{
						            echo "Invalid License Key";
                                }
						        echo '</span>';
					        }
					        else {
						        ?><span style="color:green;"><?php _e('Active'); ?></span><?php
					        }
                        ?>

                    </td>
                </tr>
				<?php }
                    else {
                        ?>
                        <tr valign="top">
                            <th scope="row" valign="top">
                                <?php _e('License Status'); ?>
                            </th>
                            <td>
                                <em>License Inactive</em>
                            </td>
                        </tr>
	                    <?php
                    }
                ?>
				<?php if( $expires !== false && $expires !== '' ) { ?>
                    <?php
                        if(( $error !== false && $error === 'expired' )||($error === false)) {
                    ?>
                    <tr valign="top">
                        <th scope="row" valign="top">
							<?php _e('License Valid Until'); ?>
                        </th>
                        <td>
                            <?php
                                $time = time();
                                $expires_time = strtotime($expires);
                                //$color = "red";
                                if($time <= $expires_time){
                                    //$color = "green";
                                }
                                echo '<span>'.date('jS F Y', strtotime($expires)).'</span>';

                            ?>
                        </td>
                    </tr>
				    <?php } ?>
				<?php } ?>
				<?php if( false !== $license ) { ?>
					<tr valign="top">	
						<th scope="row" valign="top">
							<?php _e('Activate License'); ?>
						</th>
						<td>
							<?php if( $status !== false && $status == 'valid' ) { ?>
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

	</form>
</div>
