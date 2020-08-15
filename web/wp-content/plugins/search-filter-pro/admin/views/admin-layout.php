<?php
/**
 * Search & Filter Pro
 * 
 * @package   Search_Filter
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<div class="wrap">
	
	<h2><?php echo esc_html( get_admin_page_title() ); ?><a href="#" class="add-new-h2">Add New</a></h2>
	<ul class="subsubsub">
		<li class=""><a href="#">All <span class="count">(15)</span></a> |</li>
		<li class=""><a href="#" class="current">Active <span class="count">(4)</span></a> |</li>
		<li class=""><a href="#">Inactive <span class="count">(11)</span></a></li>
	</ul>
	<form method="get" action="">
		<p class="search-box">
			<label class="screen-reader-text" for="plugin-search-input">Search Installed Plugins:</label>
			<input type="search" id="plugin-search-input" name="s" value="">
			<input type="submit" name="" id="search-submit" class="button" value="Search Something">
		</p>
	</form>
	<div class="clear"></div>
	
	<!-- Messages -->
	<h3>Messages</h3>
	<div id="message" class="updated"><p>Message <strong>updated</strong>.</p></div>
	<div id="message" class="error"><p>Message <strong>error</strong>.</p></div>
	<hr />
	
	<!-- Layout -->
	<h3>Layout</h3>
	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">
			<div id="post-body-content">
				<div class="postbox opened">
                    <h3>Post Body</h3>
                    <div class="inside">
						Desc
						
						<div class="clear"></div>
						
                    </div>
					<ul class="subsubsub">
						<li class="all"><a href="edit-comments.php?comment_status=all">All</a> |</li>
						<li class="moderated"><a href="edit-comments.php?comment_status=moderated">Pending <span class="count">(<span class="pending-count">0</span>)</span></a> |</li>
						<li class="approved"><a href="edit-comments.php?comment_status=approved">Approved</a> |</li>
						<li class="spam"><a href="edit-comments.php?comment_status=spam">Spam <span class="count">(<span class="spam-count">0</span>)</span></a> |</li>
						<li class="trash"><a href="edit-comments.php?comment_status=trash">Trash <span class="count">(<span class="trash-count">0</span>)</span></a></li>
					</ul>
				</div>
			</div>
			<div id="postbox-container-1" class="postbox-container">
				
				<div class="postbox opened">
                    <h3>Postbox Container 1</h3>
                    <div class="inside">
						Desc
                    </div>
				</div>
			</div>
			<div id="postbox-container-2" class="postbox-container">
				<div class="postbox opened">
                    <h3>Postbox Container 2</h3>
                    <div class="inside">
						Desc
                    </div>
				</div>
			</div>
		</div>
	</div>
	<div class="clear"></div>
	<hr />
	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-3">
			
			<div id="postbox-container-1" class="postbox-container">
				<div class="postbox opened">
                    <h3>Postbox Container 1</h3>
                    <div class="inside">
						Desc
                    </div>
				</div>
			</div>
			
			<div id="postbox-container-2" class="postbox-container">
				<div class="postbox opened">
                    <h3>Postbox Container 2</h3>
                    <div class="inside">
						Desc
                    </div>
				</div>
			</div>
			
			<div id="postbox-container-3" class="postbox-container">
				<div class="postbox opened">
                    <h3>Postbox Container 2</h3>
                    <div class="inside">
						Desc
                    </div>
				</div>
			</div>
		</div>
	</div>
	<div class="clear"></div>
	<hr />
	<!-- Buttons -->
	<h3>Buttons</h3>
	<p class="submit">
		<input type="submit" name="submit" id="submit" class="button button-primary" value="Primary Button">
		<input type="submit" name="submit" id="submit" class="button button-secondary" value="Secondary Button">
	</p>
</div>
