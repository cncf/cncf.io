<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.cncf.io/
 * @since      1.1.0
 *
 * @package    Cncf_Mu
 * @subpackage Cncf_Mu/admin/partials
 */

 // phpcs:disable Squiz.PHP.EmbeddedPhp.ContentBeforeOpen
 // phpcs:disable Squiz.PHP.EmbeddedPhp.ContentAfterEnd

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
?>

<div class="wrap">
	<h2><?php esc_attr_e( 'Global Site Options', 'textdomain' ); ?></h2>

	<form method="post" name="<?php echo esc_html( $this->plugin_name ); ?>"
		action="options.php">
		<?php
		// Grab all options.
		$options = get_option( $this->plugin_name );
		// r( $options );
		$social_email = ( isset( $options['social_email'] ) && ! empty( $options['social_email'] ) ) ? esc_attr( $options['social_email'] ) : '';

		$social_facebook = ( isset( $options['social_facebook'] ) && ! empty( $options['social_facebook'] ) ) ? esc_attr( $options['social_facebook'] ) : '';

		$social_flickr = ( isset( $options['social_flickr'] ) && ! empty( $options['social_flickr'] ) ) ? esc_attr( $options['social_flickr'] ) : '';

		$social_github = ( isset( $options['social_github'] ) && ! empty( $options['social_github'] ) ) ? esc_attr( $options['social_github'] ) : '';

		$social_linkedin = ( isset( $options['social_linkedin'] ) && ! empty( $options['social_linkedin'] ) ) ? esc_attr( $options['social_linkedin'] ) : '';

		$social_rss = ( isset( $options['social_rss'] ) && ! empty( $options['social_rss'] ) ) ? esc_attr( $options['social_rss'] ) : '';

		$social_twitter = ( isset( $options['social_twitter'] ) && ! empty( $options['social_twitter'] ) ) ? esc_attr( $options['social_twitter'] ) : '';

		$social_youtube = ( isset( $options['social_youtube'] ) && ! empty( $options['social_youtube'] ) ) ? esc_attr( $options['social_youtube'] ) : '';

		$social_wechat_id = ( isset( $options['social_wechat_id'] ) && ! empty( $options['social_wechat_id'] ) ) ? absint( $options['social_wechat_id'] ) : '';

		$show_hello_bar = ( isset( $options['show_hello_bar'] ) && ! empty( $options['show_hello_bar'] ) ) ? 1 : 0;

		$hello_bar_content = ( isset( $options['hello_bar_content'] ) && ! empty( $options['hello_bar_content'] ) ) ? $options['hello_bar_content'] : '';

		$hello_bar_bg = ( isset( $options['hello_bar_bg'] ) && ! empty( $options['hello_bar_bg'] ) ) ? esc_attr( $options['hello_bar_bg'] ) : '';

		$header_image_id = ( isset( $options['header_image_id'] ) && ! empty( $options['header_image_id'] ) ) ? absint( $options['header_image_id'] ) : '';

		$header_cta_text = ( isset( $options['header_cta_text'] ) && ! empty( $options['header_cta_text'] ) ) ? esc_attr( $options['header_cta_text'] ) : '';

		$header_cta_link = ( isset( $options['header_cta_link'] ) && ! empty( $options['header_cta_link'] ) ) ? absint( $options['header_cta_link'] ) : '';

		$copyright_textarea = ( isset( $options['copyright_textarea'] ) && ! empty( $options['copyright_textarea'] ) ) ? $options['copyright_textarea'] : '';

		settings_fields( $this->plugin_name );

		do_settings_sections( $this->plugin_name );
		?>
		<hr />

		<a href="#social">Social Media</a> | <a href="#hello">Hello Bar</a> | <a
			href="#header">Header</a> | <a href="#footer">Footer</a>

		<hr />

		<h2 id="social">Company Social Media & Links</h2>
		<table class="form-table" role="presentation">
			<tbody>
				<tr>
					<th scope="row"><label for="social_email">Email</label>
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
					<th scope="row"><label for="header_image_id">WeChat</label>
					</th>
					<td>
						<?php
						// TODO: WeChat upload here.
						?>

					</td>
				</tr>

			</tbody>
		</table>

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
					<th scope="row"><label for="hello_bar_content">Hello Bar
							Content</label>
					</th>
					<td>
						<?php
							$hello_bar_settings = array(
								'teeny'         => true, // extra options.
								'media_buttons' => false, // media upload.
								'textarea_rows' => 4,
								'tabindex'      => 1,
								'textarea_name' => 'cncf-mu[hello_bar_content]',
							);
							wp_editor( $hello_bar_content, 'hello_bar_content', $hello_bar_settings );
							?>


					</td>
				</tr>

				<tr>
					<th scope="row"><label for="hello_bar_bg">Background
							Color</label>
					</th>
					<td>

						<div class="pagebox">
							<input class="color_field" type="hidden"
								name="<?php echo esc_html( $this->plugin_name ); ?>[hello_bar_bg]"
								data-default-color="#DE176C"
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
					<td colspan="3">
						<div class='image-preview-wrapper'>
							<img id='image-preview'
								src='<?php echo esc_url( wp_get_attachment_url( $header_image_id ) ); ?>'
								height='100' class="thumbnail-margin-bottom">

						</div>

						<input id="upload_image_button" type="button"
							class="button" value="Choose image" />

						<input id="clear_upload_image_button" type="button"
							class="button" value="Remove image" />

						<input type="hidden"
							id="<?php echo esc_html( $this->plugin_name ); ?>-header_image_id"
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
							placeholder="Sign up" />
					</td>

					<th scope="row"><label for="header_cta_link">Header
							CTA Link</label>
					</th>
					<td>
						<?php


						$dropdown_args = array(
							'selected'          => absint( $header_cta_link ), // insert the post id here
							'id'                => esc_html( $this->plugin_name ) . '-header_cta_link', // name
							'name'              => esc_html( $this->plugin_name ) . '[header_cta_link]', // name
							'class'             => 'regular-small-text',
							'show_option_none'  => 'No Link (Remove Button)',
							'option_none_value' => '',
							'echo'              => true,
						);

						wp_dropdown_pages( $dropdown_args );

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
					<th scope="row"><label for="copyright_textarea">Copyright
							Textarea</label>
					</th>
					<td>
						<?php
							$copyright_textarea_settings = array(
								'teeny'         => true, // extra options.
								'media_buttons' => false, // media upload.
								'textarea_rows' => 6,
								'tabindex'      => 5,
								'textarea_name' => 'cncf-mu[copyright_textarea]',
							);
							wp_editor( $copyright_textarea, 'copyright_textarea', $copyright_textarea_settings );
							?>
						<p class="description">Copyright © 2020 is inserted
							automatically before this sentence begins.</p>
					</td>
				</tr>
			</tbody>
		</table>

		<hr />

		<?php submit_button( __( 'Save all changes', 'textdomain' ), 'primary', 'submit', true ); ?>
	</form>
</div>
