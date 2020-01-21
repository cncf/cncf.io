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

<div id="cache-info" class="widgets-search-filter-draggables ui-search-filter-sortable setup" data-allow-expand="0">
	<p class="description-inline notice-building notice-rc-error" style="background-color:#FFDCD6;padding:10px;border:1px solid #F2C7B4;">
		<?php _e("<strong>Notice</strong>: Running background processes is either disabled or has failed in this environment.<br /><br />Therefore you must leave this page open to complete caching.", $this->plugin_slug); ?>			
	</p>
	
	<?php
		global $post;
		
		$cache_view = array(
			"disabled" => array('style'=>''),
			"ready" => array('style'=>''),
			"finished" => array('style'=>''),
			"inprogress" => array('style'=>''),
			"error" => array('style'=>'')
		);
		$values['status'] = "inprogress";
		$values['enabled'] = 1;
		
		/*if($values['enabled']==1)
		{
			$view_key = $values['status'];
			
		}
		else
		{
			$view_key = "disabled";
		}
		
		if($values['status']=="")
		{
			$view_key = "disabled";
		}
		
		$cache_view[$view_key]['style'] = "style='display:block;' ";
		//echo "STATUS: ".$values['status']."<br />";
		*/
	?>
	<div class="cache-metabox status-wait" style="display:block;">
		<p class="description-inline">
			<?php _e("<em>Fetching cache information...</em>", $this->plugin_slug); ?>
		</p>
		
		<?php
		$enabled_style="";
		$disabled_style="";
		
		/*if($values['enabled']==1)
		{
			$enabled_style = " style='display:none;'";
		}
		else
		{
			$disabled_style = " style='display:none;'";
		}*/
		?>
		<!--<p class="description-inline" style="text-align:right;">
			<span name="save" type="submit" class="button button-large toggle-cache" data-sfid="<?php echo $post->ID; ?>" data-enable-cache="1"><?php _e("Enable", $this->plugin_slug); ?></span>
		</p>-->
	</div>
	<div class="cache-metabox status-disabled">
		<p class="description-inline">
			<?php _e("<strong>Notice:</strong> Cache is not enabled, this is required for advanced features.", $this->plugin_slug); ?>
		</p>
		
		<?php
		$enabled_style="";
		$disabled_style="";
		
		/*if($values['enabled']==1)
		{
			$enabled_style = " style='display:none;'";
		}
		else
		{
			$disabled_style = " style='display:none;'";
		}*/
		?>
		<p class="description-inline" style="text-align:right;">
			<span name="save" type="submit" class="button button-large toggle-cache" data-sfid="<?php echo $post->ID; ?>" data-enable-cache="1"><?php _e("Enable", $this->plugin_slug); ?></span>
		</p>
	</div>
	
	<div class="cache-metabox status-inprogress"<?php echo $cache_view['inprogress']['style']; ?>>
		<p class="description-inline">
			
			<strong><?php _e("Current Progress:", $this->plugin_slug); ?> </strong>
			
		</p>
		<p class="description-inline">
			<?php _e("<span class='progress-current'>0</span> / <span class='progress-total'>0</span> posts - <strong><span class='progress-percent'>0</span>%</strong>", $this->plugin_slug); ?>
			
		</p>
		<div class="media-progress-bar"><div style="width: 0%"></div></div>
		<p class="description-inline notice-building">
			<?php _e("Building cache...", $this->plugin_slug); ?>			
		</p>
		<p class="description-inline notice-stalled">
			<?php _e("<strong>Caching paused: </strong> attempting to resume...", $this->plugin_slug); ?>	
		</p>
		<p class="description-inline notice-building notice-alert">
			<?php _e("Search results will only contain posts when caching has completed.", $this->plugin_slug); ?>			
		</p>
		
	</div>
	
	<div class="cache-metabox status-termcache">
		<p class="description-inline">
			
			<strong><?php _e("Current Progress:", $this->plugin_slug); ?> </strong>
			
		</p>
		<p class="description-inline">
			<?php _e("Building the Term Cache", $this->plugin_slug); ?>
			
		</p>
		<div class="media-progress-bar"><div style="width: 0%"></div></div>
		<p class="description-inline notice-building">
			<?php _e("Almost finished...", $this->plugin_slug); ?>			
		</p>
		<p class="description-inline notice-stalled">
			<?php _e("<strong>Caching paused: </strong> attempting to resume...", $this->plugin_slug); ?>	
		</p>
		
		<p class="description-inline notice-building notice-alert">
			<?php _e("Search results will only contain posts when caching has completed.", $this->plugin_slug); ?>			
		</p>
	</div>
	
	<div class="cache-metabox status-error"<?php echo $cache_view['error']['style']; ?>>
		
		
		<p class="description-inline notice-error">
			<?php _e("<strong>Error: </strong>Unable to cache posts.", $this->plugin_slug); ?>	
		</p>
		<p class="description-inline notice-alert">
			<?php _e("Something prevented the caching process from running, you can try again by selecting <strong>Rebuild Cache</strong>.<br /><a href='#' target='_blank'>More info</a>", $this->plugin_slug); ?>			
		</p>
		
	</div>
	
	
	
	<div class="cache-metabox status-finished"<?php echo $cache_view['finished']['style']; ?>>
		<p class="description-inline">
			<?php _e("Cache up to date, all systems go.", $this->plugin_slug); ?>
		</p>
		
	</div>
	
	<div class="cache-metabox status-restart"<?php echo $cache_view['finished']['style']; ?>>
		<p class="description-inline">
			
			<strong><?php _e("Restarting...", $this->plugin_slug); ?> </strong>
			
		</p>
		<p class="description-inline">
			<?php _e("Changes have been made which require the cache to be rebuilt.", $this->plugin_slug); ?>
			
		</p>
		<p class="description-inline notice-building notice-please-wait" style="display:none;">
			<?php _e("Please wait a moment...", $this->plugin_slug); ?>
		</p>
	</div>

	<div class="cache-metabox status-ready"<?php echo $cache_view['finished']['style']; ?>>
		<p class="description-inline">
			
			<strong><?php _e("Ready, waiting for some posts to cache...", $this->plugin_slug); ?> </strong>
			
		</p>
		<p class="description-inline">
			<?php _e("There is no data to cache yet.", $this->plugin_slug); ?>
			
		</p>
	</div>
	
	<p class="description-inline" style="text-align:right;">
		<!--<a class="submitdelete deletion" href="#">Rebuild Cache</a>-->
		
		<span class="spinner rebuild-cache-spinner"></span>
		<span class="button button-large rebuild-cache" data-sfid="<?php echo $post->ID; ?>"><?php _e("Rebuild Cache", $this->plugin_slug); ?></span>

	</p>

</div>
