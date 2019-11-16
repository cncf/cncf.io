<?php
/**
 * Salesforce Entry Detail Metabox
 *
 * @since 1.0.0
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
?>
<div id="submitcomment" class="submitbox">
	
	<div id="minor-publishing">
		<?php

		foreach ( $salesforce_meta as $object_key => $object_id ) {
			
			$object = substr( $object_key, 0, strrpos( $object_key, '_' ) );
			?>
			<div class="gfp_salesforce_object">
				<?php echo $object ?>:
                <?php if (! is_array( $object_id ) ) { ?>
				<span class="gfp_salesforce_object_id"><a href="<?php echo "{$instance_url}{$object_id}"; ?>"><?php echo $object_id; ?></a></span>
                <?php } else { ?>
                    <?php foreach( $object_id as $key => $value ) { ?>
                    <span class="gfp_salesforce_object_id"><a href="<?php echo "{$instance_url}{$value}"; ?>"><?php echo $key; ?></a></span>
                <?php } ?>
                <?php } ?>
			</div>
			<br />
				<?php
			}
		?>
	</div>
	
</div>