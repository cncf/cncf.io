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
	<div class="widgets-holder-wrap">
		<div id="available-fields" class="widgets-search-filter-draggables ui-search-filter-sortable" data-allow-expand="0">
			<div class="sidebar-name">
				<div class="sidebar-name-arrow"><br></div>
				<h3>Available Fields <span class="spinner"></span></h3>
			</div>
			<div class="sidebar-description"><p class="description">Drag any of these Available Fields in to the Search Form UI to start building your Search Form.</p></div>
			
			<!--<div class="widget-placeholder"></div>-->
			<div class="widget">
				<div class="widget-top">
				<div class="widget-title-action">
					<a class="widget-action hide-if-no-js" href="#available-widgets"></a>
					<a class="widget-control-edit hide-if-js" href="/wpsearchandfilter/wp-admin/widgets.php?editwidget=search-2&amp;sidebar=sidebar-1&amp;key=0">
						<span class="edit">Edit</span>
						<span class="add">Add</span>
						<span class="screen-reader-text">Search</span>
					</a>
				</div>
				<div class="widget-title"><h4>Search<span class="in-widget-title"></span></h4></div>
				</div>

				<div class="widget-inside">
					<form action="" method="post">
						<div class="widget-content">
							<p><label for="widget-search-2-title">Title: <input class="widefat" id="widget-search-2-title" name="widget-search[2][title]" type="text" value=""></label></p>
							<p><label for="widget-recent-posts-2-number">Number of posts to show:</label>
							<input id="widget-recent-posts-2-number" name="widget-recent-posts[2][number]" type="text" value="5" size="3"></p>

							<p><input class="checkbox" type="checkbox" id="widget-recent-posts-2-show_date" name="widget-recent-posts[2][show_date]">
							<label for="widget-recent-posts-2-show_date">Display post date?</label></p>
						</div>
						
						<input type="hidden" name="widget-id" class="widget-id" value="search-2">
						<input type="hidden" name="id_base" class="id_base" value="search">
						<input type="hidden" name="widget-width" class="widget-width" value="250">
						<input type="hidden" name="widget-height" class="widget-height" value="200">
						<input type="hidden" name="widget_number" class="widget_number" value="2">
						<input type="hidden" name="multi_number" class="multi_number" value="">
						<input type="hidden" name="add_new" class="add_new" value="">

						<div class="widget-control-actions">
							<div class="alignleft">
								<a class="widget-control-remove" href="#remove">Delete</a> |
								<a class="widget-control-close" href="#close">Close</a>
							</div>
							<div class="alignright">
								<input type="submit" name="savewidget" id="widget-search-2-savewidget" class="button button-primary widget-control-save right" value="Save">			<span class="spinner"></span>
							</div>
							<br class="clear">
						</div>
					</form>
				</div>
				<div class="widget-description">
					A search form for your site.
				</div>
			</div>
			
			<div class="widget">
				<div class="widget-top">
				<div class="widget-title-action">
					<a class="widget-action hide-if-no-js" href="#available-widgets"></a>
					<a class="widget-control-edit hide-if-js" href="/wpsearchandfilter/wp-admin/widgets.php?editwidget=search-2&amp;sidebar=sidebar-1&amp;key=0">
						<span class="edit">Edit</span>
						<span class="add">Add</span>
						<span class="screen-reader-text">Search</span>
					</a>
				</div>
				<div class="widget-title"><h4>Taxonomy<span class="in-widget-title"></span></h4></div>
				</div>

				<div class="widget-inside">
					<form action="" method="post">
						<div class="widget-content">
							<p><label for="widget-search-2-title">Title: <input class="widefat" id="widget-search-2-title" name="widget-search[2][title]" type="text" value=""></label></p>
							<p><label for="widget-recent-posts-2-number">Number of posts to show:</label>
							<input id="widget-recent-posts-2-number" name="widget-recent-posts[2][number]" type="text" value="5" size="3"></p>

							<p><input class="checkbox" type="checkbox" id="widget-recent-posts-2-show_date" name="widget-recent-posts[2][show_date]">
							<label for="widget-recent-posts-2-show_date">Display post date?</label></p>
						</div>
						
						<input type="hidden" name="widget-id" class="widget-id" value="search-2">
						<input type="hidden" name="id_base" class="id_base" value="search">
						<input type="hidden" name="widget-width" class="widget-width" value="250">
						<input type="hidden" name="widget-height" class="widget-height" value="200">
						<input type="hidden" name="widget_number" class="widget_number" value="2">
						<input type="hidden" name="multi_number" class="multi_number" value="">
						<input type="hidden" name="add_new" class="add_new" value="">

						<div class="widget-control-actions">
							<div class="alignleft">
								<a class="widget-control-remove" href="#remove">Delete</a> |
								<a class="widget-control-close" href="#close">Close</a>
							</div>
							<div class="alignright">
								<input type="submit" name="savewidget" id="widget-search-2-savewidget" class="button button-primary widget-control-save right" value="Save">			<span class="spinner"></span>
							</div>
							<br class="clear">
						</div>
					</form>
				</div>
				<div class="widget-description">
					A search form for your site.
				</div>
			</div>
			<div class="widget">
				<div class="widget-top">
				<div class="widget-title-action">
					<a class="widget-action hide-if-no-js" href="#available-widgets"></a>
					<a class="widget-control-edit hide-if-js" href="/wpsearchandfilter/wp-admin/widgets.php?editwidget=search-2&amp;sidebar=sidebar-1&amp;key=0">
						<span class="edit">Edit</span>
						<span class="add">Add</span>
						<span class="screen-reader-text">Search</span>
					</a>
				</div>
				<div class="widget-title"><h4>Meta<span class="in-widget-title"></span></h4></div>
				</div>

				<div class="widget-inside">
					<form action="" method="post">
						<div class="widget-content">
							<p><label for="widget-search-2-title">Title: <input class="widefat" id="widget-search-2-title" name="widget-search[2][title]" type="text" value=""></label></p>
							<p><label for="widget-recent-posts-2-number">Number of posts to show:</label>
							<input id="widget-recent-posts-2-number" name="widget-recent-posts[2][number]" type="text" value="5" size="3"></p>

							<p><input class="checkbox" type="checkbox" id="widget-recent-posts-2-show_date" name="widget-recent-posts[2][show_date]">
							<label for="widget-recent-posts-2-show_date">Display post date?</label></p>
						</div>
						
						<input type="hidden" name="widget-id" class="widget-id" value="search-2">
						<input type="hidden" name="id_base" class="id_base" value="search">
						<input type="hidden" name="widget-width" class="widget-width" value="250">
						<input type="hidden" name="widget-height" class="widget-height" value="200">
						<input type="hidden" name="widget_number" class="widget_number" value="2">
						<input type="hidden" name="multi_number" class="multi_number" value="">
						<input type="hidden" name="add_new" class="add_new" value="">

						<div class="widget-control-actions">
							<div class="alignleft">
								<a class="widget-control-remove" href="#remove">Delete</a> |
								<a class="widget-control-close" href="#close">Close</a>
							</div>
							<div class="alignright">
								<input type="submit" name="savewidget" id="widget-search-2-savewidget" class="button button-primary widget-control-save right" value="Save">			<span class="spinner"></span>
							</div>
							<br class="clear">
						</div>
					</form>
				</div>
				<div class="widget-description">
					A search form for your site.
				</div>
			</div>
		</div>
	</div>
	<div class="widgets-holder-wrap">
		<div id="sidebar-1" class="widgets-search-filter-sortables ui-search-filter-sortable">
			<div class="sidebar-name">
				<div class="sidebar-name-arrow"><br></div>
				<h3>Search Form UI <span class="spinner"></span></h3>
			</div>
			<div class="sidebar-description"><p class="description">Build your Search Form here.</p></div>
			
			
			
			
		</div>
	</div>
	
</div>