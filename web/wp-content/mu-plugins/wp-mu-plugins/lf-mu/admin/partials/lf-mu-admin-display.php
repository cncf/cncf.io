<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.cncf.io/
 * @since      1.1.0
 *
 * @package    Lf_Mu
 * @subpackage Lf_Mu/admin/partials
 */

 // phpcs:disable Squiz.PHP.EmbeddedPhp.ContentBeforeOpen
 // phpcs:disable Squiz.PHP.EmbeddedPhp.ContentAfterEnd

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
?>

<div class="wrap">
	<h2><?php esc_attr_e( 'Site Options', 'lf-mu' ); ?></h2>
	<form method="post" name="<?php echo esc_html( $this->plugin_name ); ?>"
		action="options.php">
		<?php
		// Grab all options.
		$options = get_option( $this->plugin_name );

		$show_hello_bar = ( isset( $options['show_hello_bar'] ) && ! empty( $options['show_hello_bar'] ) ) ? 1 : 0;

		$hello_bar_content = ( isset( $options['hello_bar_content'] ) && ! empty( $options['hello_bar_content'] ) ) ? $options['hello_bar_content'] : '';

		$hello_bar_bg = ( isset( $options['hello_bar_bg'] ) && ! empty( $options['hello_bar_bg'] ) ) ? esc_attr( $options['hello_bar_bg'] ) : '';

		$hello_bar_text = ( isset( $options['hello_bar_text'] ) && ! empty( $options['hello_bar_text'] ) ) ? esc_attr( $options['hello_bar_text'] ) : '';

		$header_image_id = ( isset( $options['header_image_id'] ) && ! empty( $options['header_image_id'] ) ) ? absint( $options['header_image_id'] ) : '';

		$header_cta_text = ( isset( $options['header_cta_text'] ) && ! empty( $options['header_cta_text'] ) ) ? esc_attr( $options['header_cta_text'] ) : '';

		$header_cta_link = ( isset( $options['header_cta_link'] ) && ! empty( $options['header_cta_link'] ) ) ? absint( $options['header_cta_link'] ) : '';

		$footer_image_id = ( isset( $options['footer_image_id'] ) && ! empty( $options['footer_image_id'] ) ) ? absint( $options['footer_image_id'] ) : '';

		$footer_cta_text = ( isset( $options['footer_cta_text'] ) && ! empty( $options['footer_cta_text'] ) ) ? esc_attr( $options['footer_cta_text'] ) : '';

		$footer_cta_link = ( isset( $options['footer_cta_link'] ) && ! empty( $options['footer_cta_link'] ) ) ? absint( $options['footer_cta_link'] ) : '';

		$accessibility_cta_text = ( isset( $options['accessibility_cta_text'] ) && ! empty( $options['accessibility_cta_text'] ) ) ? esc_attr( $options['accessibility_cta_text'] ) : '';

		$accessibility_cta_link = ( isset( $options['accessibility_cta_link'] ) && ! empty( $options['accessibility_cta_link'] ) ) ? absint( $options['accessibility_cta_link'] ) : '';

		$copyright_textarea = ( isset( $options['copyright_textarea'] ) && ! empty( $options['copyright_textarea'] ) ) ? $options['copyright_textarea'] : '';

		$social_email = ( isset( $options['social_email'] ) && ! empty( $options['social_email'] ) ) ? esc_attr( $options['social_email'] ) : '';

		$social_facebook = ( isset( $options['social_facebook'] ) && ! empty( $options['social_facebook'] ) ) ? esc_attr( $options['social_facebook'] ) : '';

		$social_flickr = ( isset( $options['social_flickr'] ) && ! empty( $options['social_flickr'] ) ) ? esc_attr( $options['social_flickr'] ) : '';

		$social_github = ( isset( $options['social_github'] ) && ! empty( $options['social_github'] ) ) ? esc_attr( $options['social_github'] ) : '';

		$social_instagram = ( isset( $options['social_instagram'] ) && ! empty( $options['social_instagram'] ) ) ? esc_attr( $options['social_instagram'] ) : '';

		$social_linkedin = ( isset( $options['social_linkedin'] ) && ! empty( $options['social_linkedin'] ) ) ? esc_attr( $options['social_linkedin'] ) : '';

		$social_meetup = ( isset( $options['social_meetup'] ) && ! empty( $options['social_meetup'] ) ) ? esc_attr( $options['social_meetup'] ) : '';

		$social_rss = ( isset( $options['social_rss'] ) && ! empty( $options['social_rss'] ) ) ? esc_attr( $options['social_rss'] ) : '';

		$social_slack = ( isset( $options['social_slack'] ) && ! empty( $options['social_slack'] ) ) ? esc_attr( $options['social_slack'] ) : '';

		$social_twitch = ( isset( $options['social_twitch'] ) && ! empty( $options['social_twitch'] ) ) ? esc_attr( $options['social_twitch'] ) : '';

		$social_twitter = ( isset( $options['social_twitter'] ) && ! empty( $options['social_twitter'] ) ) ? esc_attr( $options['social_twitter'] ) : '';

		$social_twitter_handle = ( isset( $options['social_twitter_handle'] ) && ! empty( $options['social_twitter_handle'] ) ) ? esc_html( $options['social_twitter_handle'] ) : '';

		$social_youtube = ( isset( $options['social_youtube'] ) && ! empty( $options['social_youtube'] ) ) ? esc_attr( $options['social_youtube'] ) : '';

		$social_wechat = ( isset( $options['social_wechat'] ) && ! empty( $options['social_wechat'] ) ) ? absint( $options['social_wechat'] ) : '';

		$generic_thumb_id = ( isset( $options['generic_thumb_id'] ) && ! empty( $options['generic_thumb_id'] ) ) ? absint( $options['generic_thumb_id'] ) : '';

		$generic_avatar_id = ( isset( $options['generic_avatar_id'] ) && ! empty( $options['generic_avatar_id'] ) ) ? absint( $options['generic_avatar_id'] ) : '';

		$generic_hero_id = ( isset( $options['generic_hero_id'] ) && ! empty( $options['generic_hero_id'] ) ) ? absint( $options['generic_hero_id'] ) : '';

		$youtube_api_key = ( isset( $options['youtube_api_key'] ) && ! empty( $options['youtube_api_key'] ) ) ? esc_attr( $options['youtube_api_key'] ) : '';

		$gtm_id = ( isset( $options['gtm_id'] ) && ! empty( $options['gtm_id'] ) ) ? esc_attr( $options['gtm_id'] ) : '';

		$promotion_image_id = ( isset( $options['promotion_image_id'] ) && ! empty( $options['promotion_image_id'] ) ) ? absint( $options['promotion_image_id'] ) : '';

		$promotion_title_text = ( isset( $options['promotion_title_text'] ) && ! empty( $options['promotion_title_text'] ) ) ? esc_html( $options['promotion_title_text'] ) : '';

		$promotion_body_text = ( isset( $options['promotion_body_text'] ) && ! empty( $options['promotion_body_text'] ) ) ? esc_html( $options['promotion_body_text'] ) : '';

		$promotion_cta_text = ( isset( $options['promotion_cta_text'] ) && ! empty( $options['promotion_cta_text'] ) ) ? esc_html( $options['promotion_cta_text'] ) : '';

		$promotion_cta_link_id = ( isset( $options['promotion_cta_link_id'] ) && ! empty( $options['promotion_cta_link_id'] ) ) ? absint( $options['promotion_cta_link_id'] ) : '';

		$event_logo_id = ( isset( $options['event_logo_id'] ) && ! empty( $options['event_logo_id'] ) ) ? absint( $options['event_logo_id'] ) : '';

		$event_background_image_id = ( isset( $options['event_background_image_id'] ) && ! empty( $options['event_background_image_id'] ) ) ? absint( $options['event_background_image_id'] ) : '';

		$event_background_color = ( isset( $options['event_background_color'] ) && ! empty( $options['event_background_color'] ) ) ? esc_html( $options['event_background_color'] ) : '';

		$event_text = ( isset( $options['event_text'] ) && ! empty( $options['event_text'] ) ) ? esc_html( $options['event_text'] ) : '';

		$event_cta_text = ( isset( $options['event_cta_text'] ) && ! empty( $options['event_cta_text'] ) ) ? esc_html( $options['event_cta_text'] ) : '';

		$event_cta_color = ( isset( $options['event_cta_color'] ) && ! empty( $options['event_cta_color'] ) ) ? esc_html( $options['event_cta_color'] ) : '';

		$event_cta_text = ( isset( $options['event_cta_text'] ) && ! empty( $options['event_cta_text'] ) ) ? esc_html( $options['event_cta_text'] ) : '';

		$event_cta_link = ( isset( $options['event_cta_link'] ) && ! empty( $options['event_cta_link'] ) ) ? esc_url( $options['event_cta_link'] ) : '';

		settings_fields( $this->plugin_name );

		do_settings_sections( $this->plugin_name );

		?>
		<hr />
		<a href="#hello">Hello Bar</a> | <a href="#header">Header</a> | <a
			href="#footer">Footer</a> | <a href="#social">Social Media</a>
		| <a href="#event">Event</a>
		| <a href="#promotion">Promotion</a>
		| <a href="#other">Other</a>
		<hr />
		<h2 id="hello">Hello Bar</h2>
		<table class="form-table" role="presentation">
			<tbody>
				<tr>
					<th scope="row"><label for="show_hello_bar">Show Hello
							Bar</label>
					</th>
					<td>
						<label
							for="<?php echo esc_html( $this->plugin_name ); ?>-show_hello_bar">
							<input type="checkbox"
								id="<?php echo esc_html( $this->plugin_name ); ?>-show_hello_bar"
								name="<?php echo esc_html( $this->plugin_name ); ?>[show_hello_bar]"
								value="1"
								<?php checked( $show_hello_bar, 1 ); ?> />
						</label>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="hello_bar_content">Hello Bar
							Content</label>
					</th>
					<td colspan="2">
						<?php
							$hello_bar_settings = array(
								'teeny'         => true, // extra options.
								'media_buttons' => false, // media upload.
								'textarea_rows' => 4,
								'tabindex'      => 1,
								'textarea_name' => 'lf-mu[hello_bar_content]',
							);
							wp_editor( $hello_bar_content, 'hello_bar_content', $hello_bar_settings );
							?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="hello_bar_text">Text and Link
							Color</label>
					</th>
					<td>
						<div class="pagebox">
							<input class="color_field" type="hidden"
								name="<?php echo esc_html( $this->plugin_name ); ?>[hello_bar_text]"
								data-default-color="#FFFFFF"
								value="<?php echo esc_attr( $hello_bar_text ); ?>" />
						</div>
					</td>
					<th scope="row"><label for="hello_bar_bg">Background
							Color</label>
					</th>
					<td>
						<div class="pagebox">
							<input class="color_field" type="hidden"
								name="<?php echo esc_html( $this->plugin_name ); ?>[hello_bar_bg]"
								data-default-color="#0088ff"
								value="<?php echo esc_attr( $hello_bar_bg ); ?>" />
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		<hr />
		<h2 id="header">Header</h2>
		<table class="form-table" role="presentation">
			<tbody>
				<tr>
					<th scope="row"><label for="header_image_id">Header Logo
							Image</label>
					</th>
					<td colspan="2">
						<div class='image-preview-wrapper'>
							<img src='<?php echo esc_url( wp_get_attachment_url( $header_image_id ) ); ?>'
								class="image-preview thumbnail-margin-bottom"
								data-id="<?php echo esc_html( $this->plugin_name ); ?>-header_image_id">
						</div>
						<input type="button"
							data-id="<?php echo esc_html( $this->plugin_name ); ?>-header_image_id"
							class="upload_image_button button"
							value="Choose image" />
						<input type="button"
							data-id="<?php echo esc_html( $this->plugin_name ); ?>-header_image_id"
							class="clear_upload_image_button button"
							value="Remove image" />
						<input type="hidden"
							id="<?php echo esc_html( $this->plugin_name ); ?>-header_image_id"
							data-id="<?php echo esc_html( $this->plugin_name ); ?>-header_image_id"
							name="<?php echo esc_html( $this->plugin_name ); ?>[header_image_id]"
							value="<?php echo absint( $header_image_id ); ?>" />
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="header_cta_text">Header
							CTA Text</label>
					</th>
					<td>
						<input type="text"
							class="header_cta_text regular-small-text"
							id="<?php echo esc_html( $this->plugin_name ); ?>-header_cta_text"
							name="<?php echo esc_html( $this->plugin_name ); ?>[header_cta_text]"
							value="<?php echo esc_html( $header_cta_text ); ?>"
							placeholder="Sign up" maxlength="20" />
					</td>
					<th scope="row"><label for="header_cta_link">Header
							CTA Link</label>
					</th>
					<td>
						<?php
						$dropdown_args = array(
							'selected'          => absint( $header_cta_link ), // grab post id if set.
							'id'                => esc_html( $this->plugin_name ) . '-header_cta_link',
							'name'              => esc_html( $this->plugin_name ) . '[header_cta_link]',
							'class'             => 'regular-small-text',
							'show_option_none'  => 'No Link (Remove Button)',
							'option_none_value' => '',
							'echo'              => true,
						);
						wp_dropdown_pages( $dropdown_args ); // phpcs:ignore WordPress.Security.EscapeOutput
						?>
					</td>
				</tr>
			</tbody>
		</table>
		<hr />
		<h2 id="footer">Footer</h2>
		<table class="form-table" role="presentation">
			<tbody>
				<tr>
					<th scope="row"><label for="footer_cta_text">Footer
							CTA Text</label>
					</th>
					<td>
						<input type="text"
							class="footer_cta_text regular-small-text"
							id="<?php echo esc_html( $this->plugin_name ); ?>-footer_cta_text"
							name="<?php echo esc_html( $this->plugin_name ); ?>[footer_cta_text]"
							value="<?php echo esc_html( $footer_cta_text ); ?>"
							placeholder="Sign up" maxlength="20" />
					</td>
					<th scope="row"><label for="footer_cta_link">Footer
							CTA Link</label>
					</th>
					<td>
						<?php
						$dropdown_args = array(
							'selected'          => absint( $footer_cta_link ), // grab post id if set.
							'id'                => esc_html( $this->plugin_name ) . '-footer_cta_link',
							'name'              => esc_html( $this->plugin_name ) . '[footer_cta_link]',
							'class'             => 'regular-small-text',
							'show_option_none'  => 'No Link (Remove Button)',
							'option_none_value' => '',
							'echo'              => true,
						);
						wp_dropdown_pages( $dropdown_args ); // phpcs:ignore WordPress.Security.EscapeOutput
						?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label
							for="accessibility_cta_text">Accessibility
							Text</label>
					</th>
					<td>
						<input type="text"
							class="accessibility_cta_text regular-small-text"
							id="<?php echo esc_html( $this->plugin_name ); ?>-accessibility_cta_text"
							name="<?php echo esc_html( $this->plugin_name ); ?>[accessibility_cta_text]"
							value="<?php echo esc_html( $accessibility_cta_text ); ?>"
							placeholder="Read our accessibility statement"
							maxlength="40" />
					</td>
					<th scope="row"><label
							for="accessibility_cta_link">Accessibility
							Link</label>
					</th>
					<td>
						<?php
						$dropdown_args = array(
							'selected'          => absint( $accessibility_cta_link ), // grab post id if set.
							'id'                => esc_html( $this->plugin_name ) . '-accessibility_cta_link',
							'name'              => esc_html( $this->plugin_name ) . '[accessibility_cta_link]',
							'class'             => 'regular-small-text',
							'show_option_none'  => 'No Link (Remove Button)',
							'option_none_value' => '',
							'echo'              => true,
						);
						wp_dropdown_pages( $dropdown_args ); // phpcs:ignore WordPress.Security.EscapeOutput
						?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="footer_image_id">Footer Logo
							Image</label>
					</th>
					<td colspan="2">
						<div class='image-preview-wrapper'>
							<img src='<?php echo esc_url( wp_get_attachment_url( $footer_image_id ) ); ?>'
								class="image-preview thumbnail-margin-bottom"
								data-id="<?php echo esc_html( $this->plugin_name ); ?>-footer_image_id">
						</div>
						<input type="button"
							data-id="<?php echo esc_html( $this->plugin_name ); ?>-footer_image_id"
							class="upload_image_button button"
							value="Choose image" />
						<input type="button"
							data-id="<?php echo esc_html( $this->plugin_name ); ?>-footer_image_id"
							class="clear_upload_image_button button"
							value="Remove image" />
						<input type="hidden"
							id="<?php echo esc_html( $this->plugin_name ); ?>-footer_image_id"
							data-id="<?php echo esc_html( $this->plugin_name ); ?>-footer_image_id"
							name="<?php echo esc_html( $this->plugin_name ); ?>[footer_image_id]"
							value="<?php echo absint( $footer_image_id ); ?>" />
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="copyright_textarea">Copyright
							Textarea</label>
					</th>
					<td colspan="3">
						<?php
							$copyright_textarea_settings = array(
								'teeny'         => true, // extra options.
								'media_buttons' => false, // media upload.
								'textarea_rows' => 6,
								'tabindex'      => 5,
								'textarea_name' => 'lf-mu[copyright_textarea]',
							);
							wp_editor( $copyright_textarea, 'copyright_textarea', $copyright_textarea_settings );
							?>
						<p class="description">Copyright &copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> is inserted
							automatically before this sentence begins.</p>
					</td>
				</tr>
			</tbody>
		</table>
		<hr />
		<h2 id="social">Company Social Media & Links</h2>
		<table class="form-table" role="presentation">
			<tbody>
				<tr>
					<th scope="row"><label for="social_email">Contact
							Form</label>
					</th>
					<td>
						<input type="text" class="social_email regular-text"
							id="<?php echo esc_html( $this->plugin_name ); ?>-social_email"
							name="<?php echo esc_html( $this->plugin_name ); ?>[social_email]"
							value="<?php echo esc_url( $social_email ); ?>"
							placeholder="https://website.com/contact" />
					</td>
				</tr>
				<tr>
					<th scope="row"><label
							for="social_facebook">Facebook</label>
					</th>
					<td>
						<input type="text" class="social_facebook regular-text"
							id="<?php echo esc_html( $this->plugin_name ); ?>-social_facebook"
							name="<?php echo esc_html( $this->plugin_name ); ?>[social_facebook]"
							value="<?php echo esc_url( $social_facebook ); ?>"
							placeholder="https://facebook.com/handle" />
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="social_flickr">Flickr</label>
					</th>
					<td>
						<input type="text" class="social_flickr regular-text"
							id="<?php echo esc_html( $this->plugin_name ); ?>-social_flickr"
							name="<?php echo esc_html( $this->plugin_name ); ?>[social_flickr]"
							value="<?php echo esc_url( $social_flickr ); ?>"
							placeholder="https://www.flickr.com/photos/" />
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="social_github">Github</label>
					</th>
					<td>
						<input type="text" class="social_github regular-text"
							id="<?php echo esc_html( $this->plugin_name ); ?>-social_github"
							name="<?php echo esc_html( $this->plugin_name ); ?>[social_github]"
							value="<?php echo esc_url( $social_github ); ?>"
							placeholder="https://github.com/handle" />
					</td>
				</tr>
				<tr>
					<th scope="row"><label
							for="social_instagram">Instagram</label>
					</th>
					<td>
						<input type="text" class="social_instagram regular-text"
							id="<?php echo esc_html( $this->plugin_name ); ?>-social_instagram"
							name="<?php echo esc_html( $this->plugin_name ); ?>[social_instagram]"
							value="<?php echo esc_url( $social_instagram ); ?>"
							placeholder="https://www.instagram.com/handle" />
					</td>
				</tr>
				<tr>
					<th scope="row"><label
							for="social_linkedin">LinkedIn</label>
					</th>
					<td>
						<input type="text" class="social_linkedin regular-text"
							id="<?php echo esc_html( $this->plugin_name ); ?>-social_linkedin"
							name="<?php echo esc_html( $this->plugin_name ); ?>[social_linkedin]"
							value="<?php echo esc_url( $social_linkedin ); ?>"
							placeholder="https://www.linkedin.com/company/handle" />
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="social_meetup">Meetup</label>
					</th>
					<td>
						<input type="text" class="social_meetup regular-text"
							id="<?php echo esc_html( $this->plugin_name ); ?>-social_meetup"
							name="<?php echo esc_html( $this->plugin_name ); ?>[social_meetup]"
							value="<?php echo esc_url( $social_meetup ); ?>"
							placeholder="https://www.meetup.com/pro/handle" />
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="social_rss">RSS</label>
					</th>
					<td>
						<input type="text" class="social_rss regular-text"
							id="<?php echo esc_html( $this->plugin_name ); ?>-social_rss"
							name="<?php echo esc_html( $this->plugin_name ); ?>[social_rss]"
							value="<?php echo esc_url( $social_rss ); ?>"
							placeholder="https://website.com/feed" />
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="social_slack">Slack</label>
					</th>
					<td>
						<input type="text" class="social_slack regular-text"
							id="<?php echo esc_html( $this->plugin_name ); ?>-social_slack"
							name="<?php echo esc_html( $this->plugin_name ); ?>[social_slack]"
							value="<?php echo esc_url( $social_slack ); ?>"
							placeholder="https://www.slack.com/join-link" />
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="social_twitch">Twitch</label>
					</th>
					<td>
						<input type="text" class="social_twitch regular-text"
							id="<?php echo esc_html( $this->plugin_name ); ?>-social_twitch"
							name="<?php echo esc_html( $this->plugin_name ); ?>[social_twitch]"
							value="<?php echo esc_url( $social_twitch ); ?>"
							placeholder="https://www.twitch.tv/handle" />
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="social_twitter">Twitter</label>
					</th>
					<td>
						<input type="text" class="social_twitter regular-text"
							id="<?php echo esc_html( $this->plugin_name ); ?>-social_twitter"
							name="<?php echo esc_html( $this->plugin_name ); ?>[social_twitter]"
							value="<?php echo esc_url( $social_twitter ); ?>"
							placeholder="https://twitter.com/handle" />
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="social_twitter_handle">Twitter
							Handle (used for social sharing)</label>
					</th>
					<td>
						<input type="text"
							class="social_twitter_handle regular-text"
							id="<?php echo esc_html( $this->plugin_name ); ?>-social_twitter_handle"
							name="<?php echo esc_html( $this->plugin_name ); ?>[social_twitter_handle]"
							value="<?php echo esc_html( $social_twitter_handle ); ?>"
							placeholder="@handle" />
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="social_youtube">YouTube</label>
					</th>
					<td>
						<input type="text" class="social_youtube regular-text"
							id="<?php echo esc_html( $this->plugin_name ); ?>-social_youtube"
							name="<?php echo esc_html( $this->plugin_name ); ?>[social_youtube]"
							value="<?php echo esc_url( $social_youtube ); ?>"
							placeholder="https://www.youtube.com/c/handle" />
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="social_wechat">WeChat</label>
					</th>
					<td>
						<input type="text" class="social_wechat regular-text"
							id="<?php echo esc_html( $this->plugin_name ); ?>-social_wechat"
							name="<?php echo esc_html( $this->plugin_name ); ?>[social_wechat]"
							value="<?php echo esc_url( $social_wechat ); ?>"
							placeholder="https://www.cncf.io/wechat" />
					</td>
				</tr>
			</tbody>
		</table>
		<hr />
		<h2 id="event">Next Event</h2>
		<table class="form-table" role="presentation">
			<tbody>
				<tr>
					<th scope="row"><label for="event_logo_id">Event Logo</label>
					</th>
					<td colspan="3">
						<div class='image-preview-wrapper'>
							<img src='<?php echo esc_url( wp_get_attachment_url( $event_logo_id ) ); ?>'
								class="image-preview thumbnail-margin-bottom"
								data-id="<?php echo esc_html( $this->plugin_name ); ?>-event_logo_id">
						</div>
						<input type="button"
							data-id="<?php echo esc_html( $this->plugin_name ); ?>-event_logo_id"
							class="upload_image_button button"
							value="Choose image" />
						<input type="button"
							data-id="<?php echo esc_html( $this->plugin_name ); ?>-event_logo_id"
							class="clear_upload_image_button button"
							value="Remove image" />
						<input type="hidden"
							id="<?php echo esc_html( $this->plugin_name ); ?>-event_logo_id"
							data-id="<?php echo esc_html( $this->plugin_name ); ?>-event_logo_id"
							name="<?php echo esc_html( $this->plugin_name ); ?>[event_logo_id]"
							value="<?php echo absint( $event_logo_id ); ?>" />
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="event_background_image_id">Event Background Image</label>
					</th>
					<td colspan="3">
						<div class='image-preview-wrapper'>
							<img src='<?php echo esc_url( wp_get_attachment_url( $event_background_image_id ) ); ?>'
								class="image-preview thumbnail-margin-bottom"
								data-id="<?php echo esc_html( $this->plugin_name ); ?>-event_background_image_id">
						</div>
						<input type="button"
							data-id="<?php echo esc_html( $this->plugin_name ); ?>-event_background_image_id"
							class="upload_image_button button"
							value="Choose image" />
						<input type="button"
							data-id="<?php echo esc_html( $this->plugin_name ); ?>-event_background_image_id"
							class="clear_upload_image_button button"
							value="Remove image" />
						<input type="hidden"
							id="<?php echo esc_html( $this->plugin_name ); ?>-event_background_image_id"
							data-id="<?php echo esc_html( $this->plugin_name ); ?>-event_background_image_id"
							name="<?php echo esc_html( $this->plugin_name ); ?>[event_background_image_id]"
							value="<?php echo absint( $event_background_image_id ); ?>" />
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="event_text">Event Text</label>
					</th>
					<td>
						<input type="text"
							class="event_text regular-text"
							id="<?php echo esc_html( $this->plugin_name ); ?>-event_text"
							name="<?php echo esc_html( $this->plugin_name ); ?>[event_text]"
							value="<?php echo esc_html( $event_text ); ?>" />
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="event_background_color">Event Background Color</label>
					</th>
					<td>
						<input type="text"
							class="event_background_color regular-text"
							id="<?php echo esc_html( $this->plugin_name ); ?>-event_background_color"
							name="<?php echo esc_html( $this->plugin_name ); ?>[event_background_color]"
							value="<?php echo esc_html( $event_background_color ); ?>" />
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="event_cta_color">Event CTA Color</label>
					</th>
					<td>
						<input type="text"
							class="event_cta_color regular-text"
							id="<?php echo esc_html( $this->plugin_name ); ?>-event_cta_color"
							name="<?php echo esc_html( $this->plugin_name ); ?>[event_cta_color]"
							value="<?php echo esc_url( $event_cta_color ); ?>" />
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="event_cta_text">Event
							CTA Text</label>
					</th>
					<td>
						<input type="text"
							class="event_cta_text regular-small-text"
							id="<?php echo esc_html( $this->plugin_name ); ?>-event_cta_text"
							name="<?php echo esc_html( $this->plugin_name ); ?>[event_cta_text]"
							value="<?php echo esc_html( $event_cta_text ); ?>"
							placeholder="Register Now" maxlength="20" />
					</td>
					<th scope="row"><label for="event_cta_link">Event
							CTA Link</label>
					</th>
					<td>
						<input type="text"
							class="event_cta_link regular-small-text"
							id="<?php echo esc_html( $this->plugin_name ); ?>-event_cta_link"
							name="<?php echo esc_html( $this->plugin_name ); ?>[event_cta_link]"
							value="<?php echo esc_html( $event_cta_link ); ?>"
							placeholder="https://domain.com" />
					</td>
				</tr>
				</tbody>
		</table>

		<hr />
		<h2 id="promotion">Promotion Banner</h2>
		<table class="form-table" role="presentation">
			<tbody>
				<tr>
					<th scope="row"><label for="promotion_image_id">Promo
							Image</label>
					</th>
					<td colspan="3">
						<div class='image-preview-wrapper'>
							<img src='<?php echo esc_url( wp_get_attachment_url( $promotion_image_id ) ); ?>'
								class="image-preview thumbnail-margin-bottom"
								data-id="<?php echo esc_html( $this->plugin_name ); ?>-promotion_image_id">
						</div>
						<input type="button"
							data-id="<?php echo esc_html( $this->plugin_name ); ?>-promotion_image_id"
							class="upload_image_button button"
							value="Choose image" />
						<input type="button"
							data-id="<?php echo esc_html( $this->plugin_name ); ?>-promotion_image_id"
							class="clear_upload_image_button button"
							value="Remove image" />
						<input type="hidden"
							id="<?php echo esc_html( $this->plugin_name ); ?>-promotion_image_id"
							data-id="<?php echo esc_html( $this->plugin_name ); ?>-promotion_image_id"
							name="<?php echo esc_html( $this->plugin_name ); ?>[promotion_image_id]"
							value="<?php echo absint( $promotion_image_id ); ?>" />
					</td>
				</tr>

				<tr>
					<th scope="row"><label for="promotion_title_text">Promotion
							Title text</label>
					</th>
					<td>
						<input type="text"
							class="promotion_title_text regular-text"
							id="<?php echo esc_html( $this->plugin_name ); ?>-promotion_title_text"
							name="<?php echo esc_html( $this->plugin_name ); ?>[promotion_title_text]"
							value="<?php echo esc_html( $promotion_title_text ); ?>" />
					</td>
				</tr>

				<tr>
					<th scope="row"><label for="promotion_body_text">Promotion
							Body text</label>
					</th>
					<td colspan="3">
						<input type="text"
							class="promotion_body_text regular-text"
							id="<?php echo esc_html( $this->plugin_name ); ?>-promotion_body_text"
							name="<?php echo esc_html( $this->plugin_name ); ?>[promotion_body_text]"
							value="<?php echo esc_html( $promotion_body_text ); ?>" />
					</td>
				</tr>

				<tr>
					<th scope="row"><label for="promotion_cta_text">Promotion
							CTA Text</label>
					</th>
					<td>
						<input type="text"
							class="promotion_cta_text regular-small-text"
							id="<?php echo esc_html( $this->plugin_name ); ?>-promotion_cta_text"
							name="<?php echo esc_html( $this->plugin_name ); ?>[promotion_cta_text]"
							value="<?php echo esc_html( $promotion_cta_text ); ?>"
							placeholder="Become End User" maxlength="20" />
					</td>
					<th scope="row"><label for="promotion_cta_link_id">Promotion
							CTA Link</label>
					</th>
					<td>
						<?php
						$dropdown_args = array(
							'selected'          => absint( $promotion_cta_link_id ), // grab post id if set.
							'id'                => esc_html( $this->plugin_name ) . '-promotion_cta_link_id',
							'name'              => esc_html( $this->plugin_name ) . '[promotion_cta_link_id]',
							'class'             => 'regular-small-text',
							'show_option_none'  => 'No Link',
							'option_none_value' => '',
							'echo'              => true,
						);
						wp_dropdown_pages( $dropdown_args ); // phpcs:ignore WordPress.Security.EscapeOutput
						?>
					</td>
				</tr>
			</tbody>
		</table>

		<hr />
		<h2 id="other">Other</h2>
		<table class="form-table" role="presentation">
			<tbody>
				<tr>
					<th scope="row"><label for="generic_thumb_id">Generic
							Thumbnail</label>
					</th>
					<td colspan="3">
						<div class='image-preview-wrapper'>
							<img src='<?php echo esc_url( wp_get_attachment_url( $generic_thumb_id ) ); ?>'
								class="image-preview thumbnail-margin-bottom"
								data-id="<?php echo esc_html( $this->plugin_name ); ?>-generic_thumb_id">
						</div>
						<input type="button"
							data-id="<?php echo esc_html( $this->plugin_name ); ?>-generic_thumb_id"
							class="upload_image_button button"
							value="Choose image" />
						<input type="button"
							data-id="<?php echo esc_html( $this->plugin_name ); ?>-generic_thumb_id"
							class="clear_upload_image_button button"
							value="Remove image" />
						<input type="hidden"
							id="<?php echo esc_html( $this->plugin_name ); ?>-generic_thumb_id"
							data-id="<?php echo esc_html( $this->plugin_name ); ?>-generic_thumb_id"
							name="<?php echo esc_html( $this->plugin_name ); ?>[generic_thumb_id]"
							value="<?php echo absint( $generic_thumb_id ); ?>" />
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="generic_avatar_id">Generic
							Avatar (for People)</label>
					</th>
					<td colspan="3">
						<div class='image-preview-wrapper'>
							<img src='<?php echo esc_url( wp_get_attachment_url( $generic_avatar_id ) ); ?>'
								class="image-preview thumbnail-margin-bottom"
								data-id="<?php echo esc_html( $this->plugin_name ); ?>-generic_avatar_id">
						</div>
						<input type="button"
							data-id="<?php echo esc_html( $this->plugin_name ); ?>-generic_avatar_id"
							class="upload_image_button button"
							value="Choose image" />
						<input type="button"
							data-id="<?php echo esc_html( $this->plugin_name ); ?>-generic_avatar_id"
							class="clear_upload_image_button button"
							value="Remove image" />
						<input type="hidden"
							id="<?php echo esc_html( $this->plugin_name ); ?>-generic_avatar_id"
							data-id="<?php echo esc_html( $this->plugin_name ); ?>-generic_avatar_id"
							name="<?php echo esc_html( $this->plugin_name ); ?>[generic_avatar_id]"
							value="<?php echo absint( $generic_avatar_id ); ?>" />
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="generic_hero_id">Generic
							Hero Image</label>
					</th>
					<td colspan="3">
						<div class='image-preview-wrapper'>
							<img src='<?php echo esc_url( wp_get_attachment_url( $generic_hero_id ) ); ?>'
								class="image-preview thumbnail-margin-bottom"
								data-id="<?php echo esc_html( $this->plugin_name ); ?>-generic_hero_id">
						</div>
						<input type="button"
							data-id="<?php echo esc_html( $this->plugin_name ); ?>-generic_hero_id"
							class="upload_image_button button"
							value="Choose image" />
						<input type="button"
							data-id="<?php echo esc_html( $this->plugin_name ); ?>-generic_hero_id"
							class="clear_upload_image_button button"
							value="Remove image" />
						<input type="hidden"
							id="<?php echo esc_html( $this->plugin_name ); ?>-generic_hero_id"
							data-id="<?php echo esc_html( $this->plugin_name ); ?>-generic_hero_id"
							name="<?php echo esc_html( $this->plugin_name ); ?>[generic_hero_id]"
							value="<?php echo absint( $generic_hero_id ); ?>" />
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="youtube_api_key">YouTube API
							key</label>
					</th>
					<td>
						<input type="text" class="youtube_api_key regular-text"
							id="<?php echo esc_html( $this->plugin_name ); ?>-youtube_api_key"
							name="<?php echo esc_html( $this->plugin_name ); ?>[youtube_api_key]"
							value="<?php echo esc_attr( $youtube_api_key ); ?>" />
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="gtm_id">Google Tag Manager
							ID</label>
					</th>
					<td>
						<input type="text" class="gtm_id regular-text"
							id="<?php echo esc_html( $this->plugin_name ); ?>-gtm_id"
							name="<?php echo esc_html( $this->plugin_name ); ?>[gtm_id]"
							value="<?php echo esc_attr( $gtm_id ); ?>"
							placeholder="GTM-KNXFWV" />
					</td>
				</tr>
			</tbody>
		</table>
		<hr />
		<?php submit_button( __( 'Save all changes', 'lf-mu' ), 'primary', 'submit', true ); ?>
	</form>
</div>
