<?php
/**
 * Latest End Users Case Studies
 *
 * @package WordPress
 * @subpackage lf-theme
 * @since 1.0.0
 */

 /**
  * Add Latest End Users shortcode.
  */
function add_eu_casestudies_shortcode() {
	ob_start();

			$image = new Image();
	?>
<div class="enduser-casestudies-wrapper">


	<div class="eucs-box background-image-wrapper">
		<div class="eucs-box__overlay"></div>
		<figure class="background-image-figure">
	<picture><source srcset="https://www.cncf.io/wp-content/uploads/2020/07/1285-N496-website.1562930302.4235-1600x520.jpg" media="(min-width: 2880px)"><source srcset="https://www.cncf.io/wp-content/uploads/2020/07/1285-N496-website.1562930302.4235-1600x260.jpg" media="(min-width: 1920px)"><source srcset="https://www.cncf.io/wp-content/uploads/2020/07/1285-N496-website.1562930302.4235-1440x260.jpg" media="(min-width: 1440px)"><source srcset="https://www.cncf.io/wp-content/uploads/2020/07/1285-N496-website.1562930302.4235-1200x220.jpg" media="(min-width: 1200px)"><source srcset="https://www.cncf.io/wp-content/uploads/2020/07/1285-N496-website.1562930302.4235-1024x220.jpg" media="(min-width: 1024px)"><source srcset="https://www.cncf.io/wp-content/uploads/2020/07/1285-N496-website.1562930302.4235-768x220.jpg" media="(min-width: 768px)"><source srcset="https://www.cncf.io/wp-content/uploads/2020/07/1285-N496-website.1562930302.4235-600x220.jpg" media="(min-width: 600px)"><source srcset="https://www.cncf.io/wp-content/uploads/2020/07/1285-N496-website.1562930302.4235-414x220.jpg" media="(min-width: 414px)"><source srcset="https://www.cncf.io/wp-content/uploads/2020/07/1285-N496-website.1562930302.4235-375x220.jpg" media="(min-width: 375px)"><source srcset="https://www.cncf.io/wp-content/uploads/2020/07/1285-N496-website.1562930302.4235-320x220.jpg" media="(min-width: 0px)">
		<img src="https://www.cncf.io/wp-content/uploads/2020/07/1285-N496-website.1562930302.4235-320x220.jpg" class="" alt="">
		</picture></figure>

		<div class="eucs-box__text-wrapper background-image-text-overlay">

			<div class="eucs-box__header">
				<div class="eucs-box__logo">
					<a href="/case-studies/zalando/">
					<img loading="lazy" src="<?php $image->get_image( 'wip-home/logo-zalando.png' ); ?>"
				alt="Zalando" width="200" height="75">
					</a>
				</div>
				<p
					class="h3 eucs-box__headline">Cloud native powers radical agility at Europe’s leading online fashion platform</p>
			</div>

			<div class="eucs-box__footer">

				<div class="eucs-box__stat">
					<span class="h2 eucs-box__stat-headline">1000</span>
					<span class="h5">Deployments Weekly</span>
				</div>
				<div class="eucs-box__cta">
					<a href="/case-studies/zalando/" class="arrow-cta has-white-color">Read Zalando
						Case
						Study</a>
				</div>

			</div>
		</div>
	</div>






	<div class="eucs-box background-image-wrapper">
		<div class="eucs-box__overlay"></div>
		<figure class="background-image-figure"><img loading="lazy" width="1024" height="683" src="https://www.cncf.io/wp-content/uploads/2020/07/spotify-london-office-3-1024x683.jpg" alt="" data-id="38882" data-full-url="https://www.cncf.io/wp-content/uploads/2020/07/spotify-london-office-3.jpg" data-link="https://www.cncf.io/case-studies/spotify/attachment/spotify-london-office-3/" class="wp-image-38882" srcset="https://www.cncf.io/wp-content/uploads/2020/07/spotify-london-office-3-1024x683.jpg 1024w, https://www.cncf.io/wp-content/uploads/2020/07/spotify-london-office-3-300x200.jpg 300w, https://www.cncf.io/wp-content/uploads/2020/07/spotify-london-office-3-768x512.jpg 768w, https://www.cncf.io/wp-content/uploads/2020/07/spotify-london-office-3-1536x1024.jpg 1536w, https://www.cncf.io/wp-content/uploads/2020/07/spotify-london-office-3-700x467.jpg 700w, https://www.cncf.io/wp-content/uploads/2020/07/spotify-london-office-3-255x170.jpg 255w, https://www.cncf.io/wp-content/uploads/2020/07/spotify-london-office-3-405x270.jpg 405w, https://www.cncf.io/wp-content/uploads/2020/07/spotify-london-office-3-510x340.jpg 510w, https://www.cncf.io/wp-content/uploads/2020/07/spotify-london-office-3.jpg 1600w" sizes="(max-width: 1024px) 100vw, 1024px"></figure>

		<div class="eucs-box__text-wrapper background-image-text-overlay">

			<div class="eucs-box__header">
				<div class="eucs-box__logo">
					<a href="/case-studies/spotify/">
					<img loading="lazy" src="<?php $image->get_image( 'wip-home/logo-spotify.png' ); ?>"
				alt="Spotify" width="200" height="75">
					</a>
				</div>
				<div class="eucs-box__headline">
				<p
					class="h4">"We saw the amazing community that’s grown up around Kubernetes, and we wanted to be part of that, to benefit from added velocity, reduced cost, and align on best practices."</p>
					<p class="italic">— Jai Chakrabarti, Director of Engineering, Infrastructure and Operations at Spotify</p>
					</div>
			</div>

			<div class="eucs-box__footer">

				<div class="eucs-box__stat">
					<span class="h2 eucs-box__stat-headline">2-3x</span>
					<span class="h5">Improved CPU utilization</span>
				</div>

				<div class="eucs-box__cta">
					<a href="/case-studies/spotify/" class="arrow-cta has-white-color">Read Spotify
						Case
						Study</a>
				</div>

			</div>
		</div>
	</div>





	<div class="eucs-box background-image-wrapper">
		<div class="eucs-box__overlay"></div>
		<figure class="background-image-figure"><img loading="lazy" width="1024" height="683" src="https://www.cncf.io/wp-content/uploads/2020/08/gettyimages-487083320-1024x683.jpg" alt="" data-id="41058" data-full-url="https://www.cncf.io/wp-content/uploads/2020/08/gettyimages-487083320-scaled.jpg" data-link="https://www.cncf.io/?attachment_id=41058" class="wp-image-41058" srcset="https://www.cncf.io/wp-content/uploads/2020/08/gettyimages-487083320-1024x683.jpg 1024w, https://www.cncf.io/wp-content/uploads/2020/08/gettyimages-487083320-300x200.jpg 300w, https://www.cncf.io/wp-content/uploads/2020/08/gettyimages-487083320-768x512.jpg 768w, https://www.cncf.io/wp-content/uploads/2020/08/gettyimages-487083320-1536x1024.jpg 1536w, https://www.cncf.io/wp-content/uploads/2020/08/gettyimages-487083320-2048x1365.jpg 2048w, https://www.cncf.io/wp-content/uploads/2020/08/gettyimages-487083320-700x467.jpg 700w, https://www.cncf.io/wp-content/uploads/2020/08/gettyimages-487083320-255x170.jpg 255w, https://www.cncf.io/wp-content/uploads/2020/08/gettyimages-487083320-405x270.jpg 405w, https://www.cncf.io/wp-content/uploads/2020/08/gettyimages-487083320-510x340.jpg 510w" sizes="(max-width: 1024px) 100vw, 1024px"></figure>

		<div class="eucs-box__text-wrapper background-image-text-overlay">

			<div class="eucs-box__header">
				<div class="eucs-box__logo">
					<a href="/case-studies/jdcom-harbor/">
					<img loading="lazy" src="<?php $image->get_image( 'wip-home/logo-jd.png' ); ?>"
				alt="JD.com" width="200" height="75">
					</a>
				</div>
				<p
					class="h3 eucs-box__headline">How China’s largest retailer leverages Kubernetes for hyperscale e-commerce</p>
			</div>

			<div class="eucs-box__footer">

				<div class="eucs-box__stat">
					<span class="h2 eucs-box__stat-headline">60%</span>
					<span class="h5">Maintenance Time Saved</span>
				</div>

				<div class="eucs-box__cta">
					<a href="/case-studies/jdcom-harbor/" class="arrow-cta has-white-color">Read JD.com
						Case
						Study</a>
				</div>

			</div>
		</div>
	</div>



	<div class="eucs-box background-image-wrapper">
		<div class="eucs-box__overlay"></div>
		<figure class="background-image-figure">
	<img loading="lazy" class="" src="https://www.cncf.io/wp-content/uploads/2020/08/image-1-1-250x250.jpg" srcset="https://www.cncf.io/wp-content/uploads/2020/08/image-1-1-250x250.jpg 250w, https://www.cncf.io/wp-content/uploads/2020/08/image-1-1-300x300.jpg 300w, https://www.cncf.io/wp-content/uploads/2020/08/image-1-1-150x150.jpg 150w, https://www.cncf.io/wp-content/uploads/2020/08/image-1-1-200x200.jpg 200w, https://www.cncf.io/wp-content/uploads/2020/08/image-1-1-170x170.jpg 170w, https://www.cncf.io/wp-content/uploads/2020/08/image-1-1-270x270.jpg 270w, https://www.cncf.io/wp-content/uploads/2020/08/image-1-1-340x340.jpg 340w, https://www.cncf.io/wp-content/uploads/2020/08/image-1-1-500x500.jpg 500w, https://www.cncf.io/wp-content/uploads/2020/08/image-1-1.jpg 690w" sizes="(max-width: 400px) 100vw, 400px" alt="">	</figure>

		<div class="eucs-box__text-wrapper background-image-text-overlay">

			<div class="eucs-box__header">
				<div class="eucs-box__logo">
					<a href="https://www.youtube.com/watch?v=Tx8qXC-U3KM" target="_blank" rel="noopener">			<img loading="lazy" src="<?php $image->get_svg( 'wip-home/logo-apple.svg', true ); ?>"
				alt="Apple" width="200" height="75">
					</a>
				</div>
				<p
					class="h4 eucs-box__headline">The Cloud Native Journey @Apple - Alena Prokharchyk, Software Engineer, Apple</p>
			</div>

			<div class="eucs-box__footer">

				<div class="eucs-box__stat">
					<span class="h2 eucs-box__stat-headline">2000</span>
					<span class="h5">Deployments Weekly</span>
				</div>

				<div class="eucs-box__cta">
					<a href="https://www.youtube.com/watch?v=Tx8qXC-U3KM" target="_blank" rel="noopener" class="arrow-cta has-white-color">Watch Alena's
						Keynote</a>
				</div>

			</div>
		</div>
	</div>


</div>
	<?php
	$block_content = ob_get_clean();
	return $block_content;

}
add_shortcode( 'eu_casestudies', 'add_eu_casestudies_shortcode' );
