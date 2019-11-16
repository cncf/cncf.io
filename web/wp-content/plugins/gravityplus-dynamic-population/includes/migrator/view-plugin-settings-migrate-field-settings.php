<?php
/**
 * Migrate Field Settings
 * 
 * @since 2.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
?>
<div class="hr-divider"></div>

<h3><span><i class="fa fa-suitcase"></i> <?php esc_html_e( 'Migrate Field Settings', 'gravityplus-dynamic-population' ) ?></span></h3>

<div>

	<?php if ( ! empty( $button_url ) && ! empty( $button_label) ) { ?>

		<a href="<?php echo $button_url ?>">
			<input type="button" class="button-secondary gfbutton" value="<?php echo $button_label ?>"/>
		</a>

	<?php }
	else if ( ! empty( $migration_completed_message ) ) { ?>

		<p><?php echo $migration_completed_message; ?></p>

	<?php } ?>

</div>

