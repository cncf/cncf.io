<?php
/**
 * Template Name: Annual Report 2022 JP
 * Template Post Type: lf_report
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

// Report folder in images/ folder.
$report_folder = 'annual-reports/2022/';

get_template_part( 'components/header' );

get_template_part( 'components/skip-link-target' );

wp_enqueue_style( 'ar-2022', get_template_directory_uri() . '/build/annual-report-2022.min.css', array(), filemtime( get_template_directory() . '/build/annual-report-2022.min.css' ), 'all' );

wp_enqueue_style( 'wp-block-group' );
wp_enqueue_style( 'wp-block-column' );
wp_enqueue_style( 'wp-block-columns' );

// setup social share icons + data.
$caption      = 'Read the CNCF Anunal Report 2022 ';
$page_url     = rawurlencode( get_permalink() );
$caption      = htmlspecialchars( rawurlencode( html_entity_decode( $caption, ENT_COMPAT, 'UTF-8' ) ), ENT_COMPAT, 'UTF-8' );
$options      = get_option( 'lf-mu' );
$twitter      = $options && $options['social_twitter_handle'] ? $options['social_twitter_handle'] : null;
$twitter_url  = 'https://twitter.com/intent/tweet?text=' . $caption . '&amp;url=' . $page_url . '&amp;hashtags=cncf&amp;via=' . $twitter . '';
$linkedin_url = 'https://www.linkedin.com/shareArticle?mini=true&url=' . $page_url . '&summary=' . $caption;
$mailto_url   = 'mailto:?subject=' . $caption . '&body=' . $caption . '&nbsp;' . $page_url;
?>

<link rel="prefetch"
	href="<?php echo esc_url( get_template_directory_uri() . '/build/annual-report-2022.min.css' ); ?>"
	as="style" crossorigin="anonymous" />

	<main class="ar-2022">
	<article class="container wrap">

		<section class="hero alignfull">
			<div class="container wrap hero__container">
				<figure class="hero__container-bg-figure"><img width="4753" height="2359" loading="eager" class="hero__container-bg-image" src="https://www.cncf.io/wp-content/uploads/2022/12/ar-2022-hero-bg.png" srcset="https://www.cncf.io/wp-content/uploads/2022/12/ar-2022-hero-bg.png 4753w, https://www.cncf.io/wp-content/uploads/2022/12/ar-2022-hero-bg-300x149.png 300w, https://www.cncf.io/wp-content/uploads/2022/12/ar-2022-hero-bg-1024x508.png 1024w, https://www.cncf.io/wp-content/uploads/2022/12/ar-2022-hero-bg-768x381.png 768w, https://www.cncf.io/wp-content/uploads/2022/12/ar-2022-hero-bg-900x447.png 900w, https://www.cncf.io/wp-content/uploads/2022/12/ar-2022-hero-bg-1800x893.png 1800w, https://www.cncf.io/wp-content/uploads/2022/12/ar-2022-hero-bg-403x200.png 403w, https://www.cncf.io/wp-content/uploads/2022/12/ar-2022-hero-bg-806x400.png 806w" sizes="(max-width: 2400px) 100vw, 2400px" alt="A cloud network graphic"></figure>
				<div class="hero__content">

					<picture>
						<source media="(max-width: 599px)" srcset="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/hero-mobile.svg">
						<source media="(min-width: 600px)" srcset="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/hero-desktop.svg"><img width="632" height="262" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/hero-desktop.svg" alt="CNCF Aアニュアルレポート2022 〜 道のむこうへ 築いていく 〜" loading="eager" class="hero__title"></picture>
<p align-text="left" vertical-align=""> <font size ="4" color="#003B63"><b> 翻訳協力：谷口 暢夫（Masao Taniguchi）、稲生 章人（Akihito Inou）</b></font></p> <br>



					<div class="social-share">
						<p class="social-share__title">共有しよう</p>

						<div class="social-share__wrapper">
							<!-- twitter --><a aria-label="Twitterでシェア"
								title="Twitterでシェア"
								href="https://twitter.com/intent/tweet?text=Read%20the%20CNCF%20Anunal%20Report%202022%20&#038;url=https%3A%2F%2Fwww.cncf.io%2Freports%2Fcncf-annual-report-2022%2F&#038;hashtags=cncf&#038;via=CloudNativeFDN"><svg width="38" height="31" viewbox="0 0 38 31" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M37.023 3.988a15.184 15.184 0 0 1-4.364 1.192A7.586 7.586 0 0 0 35.992.99c-1.49.886-3.121 1.51-4.823 1.845a7.627 7.627 0 0 0-9.124-1.484 7.59 7.59 0 0 0-3.336 3.55 7.556 7.556 0 0 0-.484 4.84 21.629 21.629 0 0 1-8.67-2.303 21.559 21.559 0 0 1-6.98-5.621 7.561 7.561 0 0 0-.828 5.515 7.583 7.583 0 0 0 3.18 4.588 7.586 7.586 0 0 1-3.448-.942v.096a7.56 7.56 0 0 0 1.724 4.799 7.606 7.606 0 0 0 4.385 2.623 7.66 7.66 0 0 1-3.43.131 7.577 7.577 0 0 0 2.702 3.763 7.617 7.617 0 0 0 4.394 1.494 15.27 15.27 0 0 1-9.442 3.242c-.605 0-1.21-.036-1.812-.107a21.542 21.542 0 0 0 11.644 3.402c13.972 0 21.611-11.535 21.611-21.541 0-.329 0-.655-.02-.98a15.4 15.4 0 0 0 3.788-3.913z" fill="currentColor"/></svg></a> <!-- linkedin --> <a aria-label="Linkedinでシェア"
								title="Linkedinでシェア"
								href="https://www.linkedin.com/shareArticle?mini=true&#038;url=https%3A%2F%2Fwww.cncf.io%2Freports%2Fcncf-annual-report-2022%2F&#038;summary=Read%20the%20CNCF%20Anunal%20Report%202022%20"><svg width="30" height="31"  viewbox="0 0 30 31" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M27.758.456a2.193 2.193 0 0 1 2.204 1.804c.017.11.026.22.026.332v25.705a2.132 2.132 0 0 1-2.033 2.125H2.243c-1.066 0-1.875-.571-2.154-1.537A2.317 2.317 0 0 1 0 28.253V2.632A2.123 2.123 0 0 1 2.135.465C3.16.453 23.5.472 27.758.455zM15.992 13.62v-1.624c0-.248-.06-.342-.328-.337-1.226.014-2.451.014-3.675 0-.293 0-.361.091-.359.368V25.69c0 .279.07.377.36.372 1.274-.012 2.546-.012 3.817 0 .284 0 .363-.082.361-.367-.01-2.292-.01-4.583 0-6.874-.002-.476.037-.951.117-1.42.171-.968.614-1.755 1.64-2.012.328-.072.663-.103.998-.092 1.033.014 1.713.513 1.945 1.518.128.592.193 1.196.192 1.802.02 2.357.012 4.714 0 7.07 0 .272.07.38.36.375 1.272-.012 2.544-.012 3.817 0 .272 0 .35-.084.347-.354v-7.602a13.258 13.258 0 0 0-.29-3.088c-.326-1.384-.966-2.565-2.33-3.177a6.232 6.232 0 0 0-4.216-.35c-1.16.306-2.053 1.03-2.756 2.129zm-7.075 5.217v-6.843c0-.253-.07-.338-.333-.335-1.288.012-2.578.012-3.87 0-.253 0-.335.065-.333.328V25.73c0 .274.101.33.343.33H8.54c.372 0 .375 0 .375-.375l.002-6.848zm-2.26-9.095A2.603 2.603 0 1 0 4.05 7.165a2.577 2.577 0 0 0 2.605 2.577z" fill="currentColor"/></svg></a> <!-- sendto email --> <a aria-label="メールでシェア"
								title="メールでシェア"
								href="mailto:?subject=Read%20the%20CNCF%20Anunal%20Report%202022%20&#038;body=Read%20the%20CNCF%20Anunal%20Report%202022%20&nbsp;https%3A%2F%2Fwww.cncf.io%2Freports%2Fcncf-annual-report-2022%2F"><svg width="37" height="31" viewbox="0 0 37 31" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.332 2.098H31.99c1.833 0 3.332 1.5 3.332 3.332v19.993c0 1.833-1.5 3.332-3.332 3.332H5.332A3.342 3.342 0 0 1 2 25.423V5.43c0-1.833 1.5-3.332 3.332-3.332z" stroke="currentColor" stroke-width="3.332" stroke-linecap="round" stroke-linejoin="round"/><path d="M35.322 5.43l-16.66 11.662L2 5.43" stroke="currentColor" stroke-width="3.332" stroke-linecap="round" stroke-linejoin="round"/></svg></a></div>
					</div>

					<div class="hero__jump">各セクションへジャンプ：</div>
				</div>
			</div>
		</section>
		<section>
			<!-- Navigation  -->
			<div class="nav-el">
				<div class="nav-el__box"><a href="#momentum" title="Jump to Momentum section"
						class="box-link"></a> <img loading="lazy" width="36" height="36" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-upward-chart.svg" alt="Upward trend chart icon">モーメンタム</div>

				<div class="nav-el__box"><a href="#events" title="Jump to Events section"
						class="box-link"></a> <img loading="lazy" width="36" height="36" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-lanyard.svg" alt="Lanyard icon">イベント</div>

				<div class="nav-el__box"><a href="#training" title="Jump to Training section"
						class="box-link"></a> <img loading="lazy" width="36" height="36" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-teacher.svg" alt="Teacher icon">トレーニング</div>

				<div class="nav-el__box"><a href="#projects" title="Jump to Projects section"
						class="box-link"></a> <img loading="lazy" width="36" height="36" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-smile.svg" alt="Smiling face icon">プロジェクト</div>

				<div class="nav-el__box"><a href="#community" title="Jump to Community section"
						class="box-link"></a> <img loading="lazy" width="36" height="36" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-directions.svg" alt="Multiple directions icon">コミュニティ</div>

				<div class="nav-el__box"><a href="#ecosystem" title="Jump to Ecosystem section"
						class="box-link"></a> <img loading="lazy" width="36" height="36" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-relationship.svg" alt="Relationship icon">エコシステム</div>
			</div>
		</section>

		<section class="section-01">
			<h2 class="section-01__title">ようこそ！記憶に残る一年 <br
					class="show-over-1000">となりました</h2>

			<div class="lf-grid section-01__grid">
				<div class="section-01__grid-col1">

					<p><strong>2022 年を振り返ってみると、私たちが共に乗り越え、達成できたことに深い誇りを感じます。私たちには直面し、取り組み続けている共通的な課題はありますが、一方でクラウドネイティブ エコシステムは躍進しつづけています。私たちは新しい産業やプロジェクトを歓迎し、コミュニティをデンマークの人口を超える 710 万人のクラウドネイティブ デベロッパーにまで拡大しました。</strong></p>

					<p>クラウドネイティブはキャズムを越え、これまで以上に多くの組織がソフトウェア企業になりつつあります。このことは、KubeCon + CloudNativeCon イベントでも反映されていて、メルセデスベンツやボーイングといった顔ぶれが有名なテックブランドたちとともに見出しを飾り、基調講演を行いました。</p>

					<p>もちろん、これは本当にグローバルで迎え入れてくれる、「Doer」たちののコミュニティである #TeamCloudNative なしでは不可能だったことでしょう。17 万 8,000 人を超えるコミットメントとコントリビューションに一個人としてみなさんに感謝します。それらのインパクトが大きくても小さくても、そこが問題ではなく私たちがこの旅路（Journey）を共に歩んでいる、ということに意味があります。</p>

					<p>私たちが歩んできたマイルストーン、今年一緒に達成してきた素晴らしい前進について本レポートを読みながら振り返っていただければと思います。</p>

					<div class="section-01__author"><img width="210" height="210" loading="lazy" class="" src="https://www.cncf.io/wp-content/uploads/2022/12/priyanka-sharma.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/priyanka-sharma.jpg 210w, https://www.cncf.io/wp-content/uploads/2022/12/priyanka-sharma-150x150.jpg 150w, https://www.cncf.io/wp-content/uploads/2022/12/priyanka-sharma-200x200.jpg 200w" sizes="(max-width: 75px) 100vw, 75px" alt="Priyanka Sharma"><p><strong>Priyanka Sharma</strong><br> Executive Director, CNCF</p>
					</div>
				</div>

				<div class="section-01__grid-col2">

					<!-- Icon 1  -->
					<div class="icon-box-1">
						<div class="icon"><img loading="lazy" width="71" height="74" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-projects.svg" alt="Projects icon"></div>
						<div class="text"><span>157 のプロジェクト</span><br /> が世界中のトランスフォーメーションをドライブする</div>
					</div>

					<!-- Icon 2  -->
					<div class="icon-box-1">
						<div class="icon"><img loading="lazy" width="74" height="43" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-members.svg" alt="Members icon"></div>
						<div class="text"><span>853 のメンバー</span><br /> は 6 大陸にまたがる</div>
					</div>

					<!-- Icon 3  -->
					<div class="icon-box-1">
						<div class="icon"><img loading="lazy" width="60" height="57" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-chapter.svg" alt="Chapter icon"></div>
						<div class="text"><span>178K のコントリビューターたち</span><br /> がコンピューティングに根底から変化をもたらす</div>
					</div>

				</div>
			</div>
		</section>

		<!-- Photo Highlights  -->
		<section class="section-02">

			<div class="wp-block-group is-style-no-padding is-style-see-all">
				<div class="wp-block-columns are-vertically-aligned-centered">
					<div class="wp-block-column is-vertically-aligned-centered"
						style="flex-basis:80%">
						<h3 class="sub-header">2022 年ハイライト写真</h3>
					</div>
					<div class="wp-block-column is-vertically-aligned-bottom"
						style="flex-basis:20%">
						<p
							class="has-text-align-right is-style-link-cta"><a href="https://www.flickr.com/photos/143247548@N03/albums/with/72177720303164393" title="CNCF Flickr のフォトフィードを見る">続きを見る</a></p>
					</div>
				</div>

				<div class="section-02__slider">
					<div><img width="900" height="614" loading="lazy" class="" src="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-1-900x614.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-1-900x614.jpg 900w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-1-300x205.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-1-1024x699.jpg 1024w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-1-768x524.jpg 768w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-1-293x200.jpg 293w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-1-586x400.jpg 586w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-1-380x260.jpg 380w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-1.jpg 1494w" sizes="(max-width: 700px) 100vw, 700px" alt="KubeCon + CloudNativeCon Europe 2022 の写真"></div>
					<div><img width="900" height="602" loading="lazy" class="" src="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-2-900x602.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-2-900x602.jpg 900w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-2-300x201.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-2-1024x685.jpg 1024w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-2-768x514.jpg 768w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-2-299x200.jpg 299w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-2-598x400.jpg 598w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-2.jpg 1494w" sizes="(max-width: 700px) 100vw, 700px" alt="KubeCon + CloudNativeCon North America 2022 の写真"></div>
					<div><img width="900" height="599" loading="lazy" class="" src="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-3-900x599.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-3-900x599.jpg 900w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-3-300x200.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-3-1024x682.jpg 1024w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-3-768x511.jpg 768w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-3-601x400.jpg 601w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-3.jpg 1502w" sizes="(max-width: 700px) 100vw, 700px" alt="KubeCon + CloudNativeCon Europe 2022 の写真"></div>
					<div><img width="900" height="491" loading="lazy" class="" src="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-4-900x491.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-4-900x491.jpg 900w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-4-300x164.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-4-1024x558.jpg 1024w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-4-768x419.jpg 768w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-4-1800x981.jpg 1800w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-4-367x200.jpg 367w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-4-734x400.jpg 734w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-4.jpg 1834w" sizes="(max-width: 700px) 100vw, 700px" alt="KubeCon + CloudNativeCon Europe 2022 の写真"></div>
					<div><img width="900" height="599" loading="lazy" class="" src="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-5-900x599.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-5-900x599.jpg 900w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-5-300x200.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-5-1024x682.jpg 1024w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-5-768x511.jpg 768w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-5-601x400.jpg 601w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-5.jpg 1502w" sizes="(max-width: 700px) 100vw, 700px" alt="KubeCon + CloudNativeCon North America 2022 の写真"></div>
					<div><img width="900" height="599" loading="lazy" class="" src="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-6-900x599.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-6-900x599.jpg 900w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-6-300x200.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-6-1024x682.jpg 1024w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-6-768x511.jpg 768w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-6-601x400.jpg 601w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-6.jpg 1502w" sizes="(max-width: 700px) 100vw, 700px" alt="KubeCon + CloudNativeCon North America 2022 の写真"></div>
					<div><img width="900" height="602" loading="lazy" class="" src="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-7-900x602.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-7-900x602.jpg 900w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-7-300x201.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-7-1024x685.jpg 1024w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-7-768x514.jpg 768w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-7-299x200.jpg 299w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-7-598x400.jpg 598w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-7.jpg 1494w" sizes="(max-width: 700px) 100vw, 700px" alt="KubeCon + CloudNativeCon North America 2022 の写真"></div>
					<div><img width="900" height="601" loading="lazy" class="" src="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-8-900x601.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-8-900x601.jpg 900w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-8-300x200.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-8-1024x684.jpg 1024w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-8-768x513.jpg 768w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-8-599x400.jpg 599w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-8.jpg 1498w" sizes="(max-width: 700px) 100vw, 700px" alt="KubeCon + CloudNativeCon North America 2022 の写真"></div>
					<div><img width="900" height="601" loading="lazy" class="" src="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-9-900x601.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-9-900x601.jpg 900w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-9-300x200.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-9-1024x684.jpg 1024w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-9-768x513.jpg 768w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-9-599x400.jpg 599w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-9.jpg 1498w" sizes="(max-width: 700px) 100vw, 700px" alt="KubeCon + CloudNativeCon North America 2022 の写真"></div>
					<div><img width="900" height="602" loading="lazy" class="" src="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-10-900x602.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-10-900x602.jpg 900w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-10-300x201.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-10-1024x685.jpg 1024w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-10-768x514.jpg 768w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-10-299x200.jpg 299w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-10-598x400.jpg 598w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-10.jpg 1495w" sizes="(max-width: 700px) 100vw, 700px" alt="KubeCon + CloudNativeCon North America 2022 の写真"></div>
					<div><img width="900" height="600" loading="lazy" class="" src="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-11-900x600.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-11-900x600.jpg 900w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-11-300x200.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-11-1024x683.jpg 1024w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-11-768x512.jpg 768w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-11-600x400.jpg 600w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-11.jpg 1500w" sizes="(max-width: 700px) 100vw, 700px" alt="KubeCon + CloudNativeCon North America 2022 の写真"></div>
					<div><img width="900" height="600" loading="lazy" class="" src="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-12-900x600.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-12-900x600.jpg 900w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-12-300x200.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-12-1024x682.jpg 1024w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-12-768x512.jpg 768w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-12-600x400.jpg 600w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-12.jpg 1501w" sizes="(max-width: 700px) 100vw, 700px" alt="KubeCon + CloudNativeCon North America 2022 の写真"></div>
					<div><img width="900" height="600" loading="lazy" class="" src="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-13-900x600.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-13-900x600.jpg 900w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-13-300x200.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-13-1024x683.jpg 1024w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-13-768x512.jpg 768w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-13-600x400.jpg 600w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-13.jpg 1499w" sizes="(max-width: 700px) 100vw, 700px" alt="KubeCon + CloudNativeCon Europe 2022 の写真"></div>
					<div><img width="900" height="600" loading="lazy" class="" src="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-14-900x600.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-14-900x600.jpg 900w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-14-300x200.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-14-1024x683.jpg 1024w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-14-768x512.jpg 768w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-14-600x400.jpg 600w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-14.jpg 1500w" sizes="(max-width: 700px) 100vw, 700px" alt="KubeCon + CloudNativeCon Europe 2022 の写真"></div>
					<div><img width="900" height="600" loading="lazy" class="" src="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-15-900x600.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-15-900x600.jpg 900w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-15-300x200.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-15-1024x683.jpg 1024w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-15-768x512.jpg 768w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-15-600x400.jpg 600w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-15.jpg 1500w" sizes="(max-width: 700px) 100vw, 700px" alt="KubeCon + CloudNativeCon North America 2022 の写真"></div>
					<div><img width="900" height="600" loading="lazy" class="" src="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-16-900x600.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-16-900x600.jpg 900w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-16-300x200.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-16-1024x682.jpg 1024w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-16-768x512.jpg 768w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-16-600x400.jpg 600w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-16.jpg 1486w" sizes="(max-width: 700px) 100vw, 700px" alt="KubeCon + CloudNativeCon North America 2022 の写真"></div>
					<div><img width="900" height="600" loading="lazy" class="" src="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-17-900x600.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-17-900x600.jpg 900w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-17-300x200.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-17-1024x683.jpg 1024w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-17-768x512.jpg 768w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-17-600x400.jpg 600w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-17.jpg 1500w" sizes="(max-width: 700px) 100vw, 700px" alt="KubeCon + CloudNativeCon Europe 2022 の写真"></div>
					<div><img width="900" height="600" loading="lazy" class="" src="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-18-900x600.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-18-900x600.jpg 900w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-18-300x200.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-18-1024x683.jpg 1024w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-18-768x512.jpg 768w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-18-600x400.jpg 600w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-18.jpg 1500w" sizes="(max-width: 700px) 100vw, 700px" alt="KubeCon + CloudNativeCon North America 2022 の写真"></div>
					<div><img width="900" height="600" loading="lazy" class="" src="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-19-900x600.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-19-900x600.jpg 900w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-19-300x200.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-19-1024x682.jpg 1024w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-19-768x512.jpg 768w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-19-600x400.jpg 600w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-19.jpg 1501w" sizes="(max-width: 700px) 100vw, 700px" alt="KubeCon + CloudNativeCon North America 2022 の写真"></div>
					<div><img width="900" height="600" loading="lazy" class="" src="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-20-900x600.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-20-900x600.jpg 900w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-20-300x200.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-20-1024x683.jpg 1024w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-20-768x512.jpg 768w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-20-600x400.jpg 600w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-20.jpg 1484w" sizes="(max-width: 700px) 100vw, 700px" alt="KubeCon + CloudNativeCon North America 2022 の写真"></div>
					<div><img width="900" height="616" loading="lazy" class="" src="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-21-900x616.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-21-900x616.jpg 900w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-21-300x205.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-21-1024x700.jpg 1024w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-21-768x525.jpg 768w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-21-292x200.jpg 292w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-21-585x400.jpg 585w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-21-380x260.jpg 380w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-21-760x520.jpg 760w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-21.jpg 1462w" sizes="(max-width: 700px) 100vw, 700px" alt="KubeCon + CloudNativeCon Europe 2022 の写真"></div>
					<div><img width="900" height="600" loading="lazy" class="" src="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-22-900x600.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-22-900x600.jpg 900w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-22-300x200.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-22-1024x683.jpg 1024w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-22-768x512.jpg 768w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-22-600x400.jpg 600w, https://www.cncf.io/wp-content/uploads/2022/12/ar-slider-22.jpg 1499w" sizes="(max-width: 700px) 100vw, 700px" alt="KubeCon + CloudNativeCon North America 2022 の写真"></div>

				</div>
				<div class="section-02__controls"><button class="button-reset  section-02__prev"><svg
							width="12" height="19" viewbox="0 0 12 19"
							fill="none" xmlns="http://www.w3.org/2000/svg">
							<path
								d="M10.4131 17.627L2.41309 9.62695L10.4131 1.62695"
								stroke="black" stroke-width="3" />
						</svg><span class="screen-reader-text">前の写真</span> </button> <button class="button-reset section-02__next"><svg
							width="12" height="19" viewbox="0 0 12 19"
							fill="none" xmlns="http://www.w3.org/2000/svg">
							<path
								d="M1.41309 1.62695L9.41309 9.62695L1.41309 17.627"
								stroke="black" stroke-width="3" />
						</svg><span class="screen-reader-text">次の写真</span> </button></div>
			</div>
		</section>

		<section id="momentum"
			class="section-03 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">2022 年<br /> その勢い（モーメンタム）</h2>
					<div class="section-number">1/6</div>
				</div>

				<div class="quote-with-name-container">
					<p
						class="quote-with-name-container__quote">(KubeCon + CloudNativeCon) 「Hallway track」でされる会話の内容が、エンタープライズ領域の対応する方向へとシフトしてきています。このショーには Ford、Mass Mutual、ING や Home Depot といった企業を迎え入れました。私たちがよく知り、愛着もあるこれらの大企業のすべてがソフトウェア企業になるさまを、目の当たりにしています。</p>
					<div class="quote-with-name-container__marks">
						<p
							class="quote-with-name-container__name">Lisa Martin</p>
						<p
							class="quote-with-name-container__position">SiliconANGLE</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>CNCF は、クラウドネイティブ コンピューティングをユビキタスにすることを目的とした、オープンソース ソフトウェアのファンデーション（財団）です。私たちは、2015 年に設立されて以来、クラウドネイティブ 技術を開拓してきました。Kubernetes、Prometheus、Envoy、ContainerD 、<a href="https://www.cncf.io/projects/" title="すべての Graduated・Incubating プロジェクトを見る">その他多く</a>の <a href="https://docs.google.com/presentation/d/1UGewu4MMYZobunfKr5sOGXsspcLOH_5XeCLyOHKh9LU/edit?usp=sharing" title="CNCF の概要を見る">世界で最も成功しているオープンソース プロジェクトをホストし</a>、育ててきました。<br><br>現時点で <strong>189 か国</strong>、<strong>178,000 人</strong>以上のコントリビューターを含む <strong>157 のプロジェクト</strong>をホストした発電所（Powerhouse）となっています。そしてこの成長が鈍化する兆しはありません。</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid section-03__intro">
					<div class="section-03__intro-col1">
						<p class="sub-header">コントリビューターの伸び</p>

						<div aria-hidden="true" class="report-spacer-40"></div><img loading="lazy" width="561" height="400" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/contributors-chart.svg" alt="コントリビューターの増加傾向チャート"><div class="legend-wrapper">
							<div class="legend-item">
								<div class="legend-box"></div>コントリビューター</div>
						</div>

					</div>
					<div class="section-03__intro-col2">
						<p
							class="sub-header">メンバー、エンドユーザー、プロジェクトの伸び</p>
						<div aria-hidden="true" class="report-spacer-40"></div><img loading="lazy" width="550" height="400" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/member-end-user-project-growth.svg" alt="メンバー、エンドユーザー、プロジェクトの増加傾向チャート"><div class="legend-wrapper">
							<div class="legend-item">
								<div class="legend-box"></div>メンバー</div>
							<div class="legend-item">
								<div class="legend-box"
									style="background-color: #d72190;"></div>エンドユーザー</div>
							<div class="legend-item">
								<div class="legend-box"
									style="background-color: #87dfcf;"></div>プロジェクト</div>
						</div>
					</div>

				</div>
			</div>
		</section>

		<section class="section-04 is-style-down-gradient alignfull">

			<div class="container wrap">

				<h2 class="section-header">メンバーシップ</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-04__membership">
					<div class="section-04__membership-col1">
						<p>CNCF のエコシステムは、CNCF をこれまで最も成功したオープンソースの財団の1つにたらしめながらベンダーやエンドユーザーのメンバーシップといった境界を超えた成長を続けています。 その証左としてこの年 220 を越える新メンバーたちを CNCF に迎え入れました。<br><br>現在、CNCF には、世界最大のパブリックおよびプライベート クラウドの企業、世界最高レベルのイノベーティブなソフトウェア企業およびエンドユーザー組織を含めた 850 を超える組織が参加しています。こういった先進的な組織からの投資は、むこう数年のクラウドネイティブ コンピューティングの進展や持続可能性に対する強力な献身を意味します。</p>
					</div>
					<div class="section-04__membership-col2">

						<div class="icon-box-1">
							<div class="icon"><img loading="lazy" width="74" height="43" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-members.svg" alt="Members icon"></div>
							<div class="text"><span>220 以上の新メンバー</span><br /> うち 19 は中国から</div>
						</div>

						<div class="icon-box-1">
							<div class="icon"><img loading="lazy" width="51" height="64" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-building.svg" alt="Building icon"></div>
							<div class="text"><span>853 のメンバー<br>組織</span><br />2021 年から 15% の伸び</div>
						</div>
					</div>
				</div>

			</div>
		</section>

		<section class="section-05 alignfull">

			<div class="container wrap">

				<div aria-hidden="true" class="report-spacer-120"></div>

				<p class="sub-header">CNCF メンバシップの増加</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-05__growth">
					<div class="section-05__growth-col1"><img loading="lazy" width="800" height="480" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/CNCF-Membership-Growth.svg" alt="CNCF メンバーシップの増加傾向のチャート"></div>
					<div class="section-05__growth-col2">
						<div class="section-05__growth-key"><img loading="lazy" width="255" height="57" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/CNCF-Membership-Growth-increase.svg" class="section-05__growth-key-image"
								alt="2021 年と比較してメンバー数が 15% 増加"><div class="thin-hr section-05__growth-key-hr">
							</div>

							<p
								class="section-05__growth-key-text">CNCFのプロジェクト上で構築、もしくはCNCF プロジェクトをインテグレーションしたクラウドネイティブなテクノロジを販売している組織であれば、一般メンバー（General member）として参加する資格があります。</p>

							<div class="wp-block-button"><a
									href="https://cncf.io/about/join/" title="CNCF メンバーになる" class="wp-block-button__link">CNCF メンバーになる</a></div>

						</div>

					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

			</div>
		</section>

		<section class="section-06">

			<p class="sub-header">立役者となったメンバー</p>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="lf-grid section-06__members">
				<div class="section-06__members-col1">
					<p class="sub-header has-purple-text">新たなゴールドメンバー</p>
					<div aria-hidden="true" class="report-spacer-60"></div>
					<div class="logo-grid smaller">

						<div class="logo-grid__box"><img loading="lazy" width="212" height="50" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/member-logo-cecloud.svg" alt="Cecloud Logo" class="logo-grid__image"></div>

						<div class="logo-grid__box"><img loading="lazy" width="212" height="30" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/member-logo-china-telecom.svg" alt="China Telecom Logo" class="logo-grid__image"></div>

						<div class="logo-grid__box"><img loading="lazy" width="212" height="38" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/member-logo-coinbase.svg" alt="Coinbase Logo" class="logo-grid__image"></div>

						<div class="logo-grid__box"><img loading="lazy" width="210" height="50" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/member-logo-oppo.svg" alt="Oppo Logo" class="logo-grid__image"></div>

						<div class="logo-grid__box"><img loading="lazy" width="212" height="64" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/member-logo-isoftstone.svg" alt="iSoftStone Logo" class="logo-grid__image"></div>

					</div>
				</div>
				<div class="section-06__members-col2">
					<p
						class="sub-header has-purple-text">新たなプラチナメンバー</p>
					<div aria-hidden="true" class="report-spacer-60"></div>

					<div class="logo-grid">

						<div class="logo-grid__box"><img loading="lazy" width="290" height="66" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/member-logo-boeing.svg" alt="Boeing Logo" class="logo-grid__image"></div>

					</div>

				</div>

			</div>

		</section>

		<section class="section-07 alignfull background-image-wrapper">

			<figure class="background-image-figure"><img width="2560" height="1067" loading="lazy" class="" src="https://www.cncf.io/wp-content/uploads/2022/12/crowd-at-kubecon-scaled.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/crowd-at-kubecon-scaled.jpg 2560w, https://www.cncf.io/wp-content/uploads/2022/12/crowd-at-kubecon-300x125.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/12/crowd-at-kubecon-1024x427.jpg 1024w, https://www.cncf.io/wp-content/uploads/2022/12/crowd-at-kubecon-768x320.jpg 768w, https://www.cncf.io/wp-content/uploads/2022/12/crowd-at-kubecon-900x375.jpg 900w, https://www.cncf.io/wp-content/uploads/2022/12/crowd-at-kubecon-1800x750.jpg 1800w, https://www.cncf.io/wp-content/uploads/2022/12/crowd-at-kubecon-480x200.jpg 480w, https://www.cncf.io/wp-content/uploads/2022/12/crowd-at-kubecon-960x400.jpg 960w" sizes="(max-width: 1200px) 100vw, 1200px" alt="KubeCon + CloudNativeCon North America 2022 参加の聴衆のみなさん"></figure>

			<div class="background-image-text-overlay">
				<div class="container wrap">

					<div aria-hidden="true" class="report-spacer-120"></div>

					<div class="quote-with-name-container">
						<p
							class="quote-with-name-container__quote">クラウドネイティブのエコシステムはどんどん大きく、良いものになってきています。オープンソースに対するエンドユーザーの信頼が、それを前進させているのです。</p>
						<div class="quote-with-name-container__marks">
							<p
								class="quote-with-name-container__name">Aparna Subramanian</p>
							<p
								class="quote-with-name-container__position">Director of Production Engineering, Shopify</p>
						</div>
					</div>

					<div aria-hidden="true" class="report-spacer-120"></div>

				</div>
			</div>
		</section>

		<section class="section-08">

			<h2 class="section-header">エンドユーザー コミュニティ</h2>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="lf-grid section-08__grid">
				<div class="section-08__grid-col1">
					<p>Cloud Native Computing Foundation （CNCF） のエンドユーザー企業とは、クラウドネイティブ テクノロジを社内で活用していて、クラウド ネイティブ サービスを外部向けに販売していないメンバー企業のことです。ベンダー、コンサルタント企業、トレーニング パートナー、またはテレコムキャリアといった企業はこれにあたりません。<br><br>エンドユーザー企業では、一人ひとりがクラウドネイティブ アーキテクチャを駆使し問題を解決すること、より包括的で繰り返し活用できるプロセスを生み出す、セルフサービス型のソリューションをチームに提供することに情熱を注いでいるのです。</p>
				</div>
				<div class="section-08__grid-col2">

					<div class="icon-box-1">
						<div class="icon"><img loading="lazy" width="53" height="54" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-like.svg" alt="Like icon"></div>
						<div class="text"><span>100%</span><br /> が CNCF を他社にも勧めたい（<a href="https://github.com/cncf/surveys/tree/main/enduser/2022" title="エンドユーザーサーベイの結果を見る">2022 年エンドユーザーサーベイ</a>）</div>
					</div>

					<div class="icon-box-1">
						<div class="icon"><img loading="lazy" width="74" height="43" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-members.svg" alt="Members icon"></div>
						<div class="text"><span>170</span><br /> のエンドユーザー メンバー</div>
					</div>

				</div>
			</div>

			<div aria-hidden="true" class="report-spacer-120"></div>

			<picture>
				<source media="(max-width: 599px)"
					srcset="https://www.cncf.io/wp-content/uploads/2023/01/award-banner-mobile.png">
				<source media="(min-width: 600px)"
					srcset="https://www.cncf.io/wp-content/uploads/2023/01/award-banner-desktop.png"><img width="2420" height="620" loading="lazy" class="" src="https://www.cncf.io/wp-content/uploads/2023/01/award-banner-desktop.png" srcset="https://www.cncf.io/wp-content/uploads/2023/01/award-banner-desktop.png 2420w, https://www.cncf.io/wp-content/uploads/2023/01/award-banner-desktop-300x77.png 300w, https://www.cncf.io/wp-content/uploads/2023/01/award-banner-desktop-1024x262.png 1024w, https://www.cncf.io/wp-content/uploads/2023/01/award-banner-desktop-768x197.png 768w, https://www.cncf.io/wp-content/uploads/2023/01/award-banner-desktop-900x231.png 900w, https://www.cncf.io/wp-content/uploads/2023/01/award-banner-desktop-1800x461.png 1800w, https://www.cncf.io/wp-content/uploads/2023/01/award-banner-desktop-600x154.png 600w, https://www.cncf.io/wp-content/uploads/2023/01/award-banner-desktop-1200x307.png 1200w" sizes="(max-width: 1200px) 100vw, 1200px" alt="We were thrilled to grant Intuit our Top End User Award this year in recognition of their notable contributions to the cloud native ecosystem."></picture>

			<div aria-hidden="true" class="report-spacer-100"></div>

			<div class="quote-with-name-container">
				<p
					class="quote-with-name-container__quote">CNCF は、<strong>オープンソースの精神、自由と選択可能（Freedom and Choice）の精神</strong>を具現化し、同時に<strong>高品質なクラウドソフトウェア</strong>の同義語にもなりました。クラウドインフラストラクチャ用のソフトウェアを構築する必要に迫られるたびに <strong>私たちが最初に行うのは、「CNCF ランドスケープ（CNCF landscape）」にアクセス</strong>し、利用可能な選択肢を評価することです。</p>
				<div class="quote-with-name-container__marks">
					<p class="quote-with-name-container__name">Madhu CS</p>
					<p class="quote-with-name-container__position">Robinhood</p>
				</div>
			</div>
		</section>

		<section class="section-09 alignfull">

			<div class="container wrap">

				<div aria-hidden="true" class="report-spacer-120"></div>

				<p class="sub-header">CTO サミット</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-09__cto">
					<div class="section-09__cto-col1">
						<p>さまざまなチームがクラウドネイティブの戦略を採用するにつれてわかってくるのは、組織が直面する課題に対する「万能の」ソリューションというものはない、ということです。それが CNCF が 2022 年に CTO サミットを立ち上げた理由です。「チャタムハウスルール」で執り行われるこのサミットでは、エンドユーザー企業の CTO が招集され組織がクラウドネイティブ コンピューティングのレジリエンスを向上していく上で、人、プロセス、テクノロジーをどう活かせるのか、を議論します。</p>

						<div aria-hidden="true" class="report-spacer-40"></div>

						<div class="quote-with-name-container">
							<p
								class="quote-with-name-container__quote">私たちは、Boeing、Fidelity、Intuit などのエンドユーザーが一堂に会し、組織にある技術的な課題にどのように対処しているかについて非公開で対話できる CTO サミットをはじめました。しばしば、インパクトがある教訓というものは仲間たちから得られるものなのです。</p>
							<div class="quote-with-name-container__marks">
								<p
									class="quote-with-name-container__name">Priyanka Sharma</p>
								<p
									class="quote-with-name-container__position">Executive Director, CNCF</p>
							</div>

						</div>
					</div>

					<div class="section-09__cto-col2"><a href="https://www.cncf.io/reports/cto-summit-eu-2022/"
							title="CTO サミット レポートを読む"> <img width="1024" height="538" loading="lazy" class="ds" src="https://www.cncf.io/wp-content/uploads/2022/08/Share_KCCNC-EU_20222_CTO-Summit_1800-1024x538.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/08/Share_KCCNC-EU_20222_CTO-Summit_1800-1024x538.jpg 1024w, https://www.cncf.io/wp-content/uploads/2022/08/Share_KCCNC-EU_20222_CTO-Summit_1800-300x158.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/08/Share_KCCNC-EU_20222_CTO-Summit_1800-768x403.jpg 768w, https://www.cncf.io/wp-content/uploads/2022/08/Share_KCCNC-EU_20222_CTO-Summit_1800-194x102.jpg 194w, https://www.cncf.io/wp-content/uploads/2022/08/Share_KCCNC-EU_20222_CTO-Summit_1800-388x204.jpg 388w, https://www.cncf.io/wp-content/uploads/2022/08/Share_KCCNC-EU_20222_CTO-Summit_1800-776x408.jpg 776w, https://www.cncf.io/wp-content/uploads/2022/08/Share_KCCNC-EU_20222_CTO-Summit_1800-1552x816.jpg 1552w, https://www.cncf.io/wp-content/uploads/2022/08/Share_KCCNC-EU_20222_CTO-Summit_1800-900x473.jpg 900w, https://www.cncf.io/wp-content/uploads/2022/08/Share_KCCNC-EU_20222_CTO-Summit_1800-381x200.jpg 381w, https://www.cncf.io/wp-content/uploads/2022/08/Share_KCCNC-EU_20222_CTO-Summit_1800-762x400.jpg 762w, https://www.cncf.io/wp-content/uploads/2022/08/Share_KCCNC-EU_20222_CTO-Summit_1800-590x310.jpg 590w, https://www.cncf.io/wp-content/uploads/2022/08/Share_KCCNC-EU_20222_CTO-Summit_1800-1180x620.jpg 1180w, https://www.cncf.io/wp-content/uploads/2022/08/Share_KCCNC-EU_20222_CTO-Summit_1800.jpg 1800w" sizes="(max-width: 500px) 100vw, 500px" alt="CTO サミット レポート - KubeCon + CloudNativeCon ヨーロッパ 2022"> </a><div aria-hidden="true" class="report-spacer-40">
						</div>

						<div class="wp-block-button"><a
								href="https://www.cncf.io/reports/cto-summit-eu-2022/"
								title="CTO サミット レポートを読む"
								class="wp-block-button__link fit-content">レポートを読む</a></div>

						<div class="thin-hr section-09__cto-hr"></div>

						<p><strong>2023 年 1 月公開</strong><br>KubeCon + CloudNativeCon North America<br>CTO サミット レポート</p>

					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

			</div>
		</section>

		<section class="section-10">

			<p class="sub-header">新たな CNCF.IO</p>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="lf-grid">
				<div class="restrictive-9-col">
					<p>5 月、デザイン新たに再構築された、<a href="https://www.cncf.io">CNCF.io</a> がローンチされました。新たなサイトでは、より効果的で活気に溢れインタラクティブにコミュニティを表現することにフォーカスしています。さらに共有エリアが追加され、 CNCF やエンドユーザー関連のコンテンツ、イベント、ニュース、ブログ記事を提供しています。また、ダイナミックなメガメニューと簡素化されたナビゲーションのおかげで、UX やナビゲーションが改良されました。重要なことは、私たちがアクセシビリティを強化している ― <a href="https://www.cncf.io/accessibility-statement/">Web コンテンツ アクセシビリティ ガイドライン (WCAG) 2.1</a> に従い、CNCF.io でレベル AA のアクセシビリティを目指している ― ということです。この 1 年を通し <a href="https://contribute.cncf.io">コントリビューターたち（Contributors）</a>を含む CNCF サブサイトに新デザインを展開し、全サイトに WCAG ガイドラインを適用しました。</p>
				</div>
			</div>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="lf-grid">
				<div class="restrictive-9-col"><img width="1788" height="1573" loading="lazy" class="" src="https://www.cncf.io/wp-content/uploads/2022/12/the-new-cncf.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/the-new-cncf.jpg 1788w, https://www.cncf.io/wp-content/uploads/2022/12/the-new-cncf-300x264.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/12/the-new-cncf-1024x901.jpg 1024w, https://www.cncf.io/wp-content/uploads/2022/12/the-new-cncf-768x676.jpg 768w, https://www.cncf.io/wp-content/uploads/2022/12/the-new-cncf-900x792.jpg 900w, https://www.cncf.io/wp-content/uploads/2022/12/the-new-cncf-227x200.jpg 227w, https://www.cncf.io/wp-content/uploads/2022/12/the-new-cncf-455x400.jpg 455w" sizes="(max-width: 920px) 100vw, 920px" alt="さまざまな Web サイト上の CNCF.io Web サイト"></div>
			</div>

			<div class="shadow-hr"></div>

			<p class="sub-header">クラウド ネイティブの「人間」たち（Humans of Cloud Native）</p>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="lf-grid">
				<div class="restrictive-9-col">
					<p>CNCF の中心には、クラウド ネイティブをユビキタスにするべく、 Doer たちが協働する、懐の広いコミュニティがあります。今年、私たちは<a href="https://www.cncf.io/humans-of-cloud-native/" title="クラウド ネイティブの「人間」たち（Humans of Cloud Native）を読む">ヒューマンズ オブ クラウドネイティブ （Humans of Cloud Native）</a> プロジェクトを立ち上げ、ここでチーム クラウド ネイティブを活気溢れ、刺激的で多様な空間にしてくれる素晴らしい人たちや、そのコントリビューションの物語を伝えています。</p>
				</div>
			</div>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="banner"><img width="1381" height="918" loading="lazy" class="banner__image" src="https://www.cncf.io/wp-content/uploads/2022/12/humans-of-cloud-native.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/humans-of-cloud-native.jpg 1381w, https://www.cncf.io/wp-content/uploads/2022/12/humans-of-cloud-native-300x199.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/12/humans-of-cloud-native-1024x681.jpg 1024w, https://www.cncf.io/wp-content/uploads/2022/12/humans-of-cloud-native-768x511.jpg 768w, https://www.cncf.io/wp-content/uploads/2022/12/humans-of-cloud-native-900x598.jpg 900w, https://www.cncf.io/wp-content/uploads/2022/12/humans-of-cloud-native-301x200.jpg 301w, https://www.cncf.io/wp-content/uploads/2022/12/humans-of-cloud-native-602x400.jpg 602w" sizes="(max-width: 800px) 100vw, 800px" alt="KubeCon + CloudNativeCon North America 2022 の参加者たち"><div class="banner__title-wrapper">
					<h2 class="banner__title">「ヒューマンズ オブ クラウドネイティブ」の集まりに参加してみませんか</h2>
				</div>
				<div class="banner__text-wrapper">
					<p class="banner__text">「クラウド ネイティブな」エコシステムでスゴいことやってる人、ご存じですか?<br><br><strong>Humans of Cloud Native にノミネートしましょう</strong></p>
					<div class="wp-block-button"><a href="mailto:humans@cncf.io"
							title="ノミネートをメールで送信"
							class="wp-block-button__link fit-content">ノミネート</a></div>
				</div>
			</div>
		</section>

		<section id="events"
			class="section-11 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">イベント</h2>
					<div class="section-number">2/6</div>
				</div>

				<div class="quote-with-name-container">
					<p
						class="quote-with-name-container__quote">KubeCon で提供されているものを見たら、2015 年 の始まりからの過去の KubeCon すべてを見逃してしまっていたことが残念でなりません。ベテランのクラウド ブロガーにとってこのカンファレンスは、分散型開発の未来が見られる、のぞき窓のような場なのです。</p>
					<div class="quote-with-name-container__marks">
						<p
							class="quote-with-name-container__name">Ofir Nachmani</p>
						<p
							class="quote-with-name-container__position">IamOnDemand</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div><img width="2400" height="1240" loading="lazy" class="" src="https://www.cncf.io/wp-content/uploads/2022/12/detroit-crowd.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/detroit-crowd.jpg 2400w, https://www.cncf.io/wp-content/uploads/2022/12/detroit-crowd-300x155.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/12/detroit-crowd-1024x529.jpg 1024w, https://www.cncf.io/wp-content/uploads/2022/12/detroit-crowd-768x397.jpg 768w, https://www.cncf.io/wp-content/uploads/2022/12/detroit-crowd-900x465.jpg 900w, https://www.cncf.io/wp-content/uploads/2022/12/detroit-crowd-1800x930.jpg 1800w, https://www.cncf.io/wp-content/uploads/2022/12/detroit-crowd-387x200.jpg 387w, https://www.cncf.io/wp-content/uploads/2022/12/detroit-crowd-774x400.jpg 774w" sizes="(max-width: 1200px) 100vw, 1200px" alt="KubeCon + CloudNativeCon North America 2022 の参加者たち"><div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>今年、私たちのコミュニティは対面式のイベントに安全に戻ることができ、私たちはこのことを歓迎しました。それと同時に、CNCF は引き続きデジタル化を強化し、世界中のあらゆる場所からのコラボレーション、学習、ネットワーキングの機会を提供するべく、すべての主要イベントへの仮想のアクセスを可能にしました。</p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="section-header">Kubernetes <br
						class="show-over-1000">Community Days</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>地域ごとに進化するクラウドネイティブ コミュニティのニーズに応えて、今年CNCF は <a href="https://kubernetescommunitydays.org/">Kubernetes Community Days （KCD）</a>プログラムを強化しました。KCD は、世界中で Kubernetes やクラウドネイティブ テクノロジの採用と改善を促進することを目的とした、採用する側と技術者を集めて学び、コラボレートし、ネットワークを構築する、コミュニティ主催のイベントです。</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid section-11__kcd">
					<div class="section-11__kcd-col1">

						<div class="icon-layout">

							<div class="icon-box-1">
								<div class="icon"><img loading="lazy" width="57" height="63"
										src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-lanyard-p.svg" alt="Lanyard icon"></div>
								<div class="text"><span>16 のKCD</span><br /> を対面、バーチャル、およびハイブリッドで開催<div class="text-smaller">2021 年から <strong>33%</strong> の増加</div>
								</div>
							</div>
							<div class="icon-box-1">
								<div class="icon"><img loading="lazy" width="57" height="44"
										src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-megaphone-p.svg" alt="Megaphone icon"></div>
								<div class="text"><span>プレゼンテーション</span><br /> が多言語で<div class="text-smaller">(英語、スラブ語、中国語、スペイン語、イタリア語、 <br
											class="show-over-1000">インドネシア語)</div>
								</div>
							</div>
						</div>
					</div>

					<div class="section-11__kcd-col2">

						<div class="icon-layout">

							<div class="icon-box-1">
								<div class="icon"><img loading="lazy" width="74" height="42"
										src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-members-p.svg" alt="Members icon"></div>
								<div class="text"><span>6,500 人以上の参加者</span><br />2021 年から <strong>85%</strong> の増加<div class="text-smaller"> </div>
								</div>
							</div>
							<div class="icon-box-1">
								<div class="icon"><img loading="lazy" width="71" height="74"
										src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-globe-p.svg" alt="Globe icon"></div>
								<div class="text"><span>14 カ国</span><br /> 世界中で開催<div class="text-smaller"></div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">KCD の進化</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>また、プログラムの成功に向け、KCD コミュニティや主催者をサポートする、さらなる施策を行いました。</p>

						<ul>
							<li>KCD GitHub リポジトリの主催者（オーガナイザー）側の利用規約が更新され、オーガナイザーの既存の要件としての<a
									href="https://training.linuxfoundation.org/training/inclusive-open-source-community-orientation-lfc102/">インクルーシブ オープンソース コミュニティ オリエンテーション</a>の受講に加え、新たな条項が追加されました。新しい条項は次のとおりです。<ul style="margin-left: 20px; margin-top: 20px; margin-bottom: 20px;">
									<li>最終的なプログラムスケジュールが多様なものとなることについて同意すること（たとえば、すべてのスピーカーが 1 つの性別、単一の文化、または年齢層となっていないこと、など)</li>
									<li>多様なラインナップが確保されるよう、プログラムの公開前に <a
											href="mailto:kcd@cncf.io">kcd@cncf.io</a> に送信しレビューの実施と承認を得ること</li>
									<li>主催者側は、スピーカーのラインナップとして企業の代表者が（偏らず）多様であることを確実にすること</li>
								</ul>

							</li>
							<li>私たちはKCD の主催者に対し、コードではなく技術的ではないコントリビューションのセッションを考慮し、含めることを推奨しています</li>
							<li>私たちは7 月、計画段階での主催者へのガイドとなるトピックを含む、毎月 1 時間のオーガナイザーミーティングをはじめました。8 月のテーマは「どのようにして多様なラインナップをキュレーションするか？」でした。このミーティングでは、主催者向けに、限られたスケジュールの中でどう多様性を築き、取り込んでいくか、必要となるリソースや推奨事項について取り上げました。ここで<a href="https://docs.google.com/presentation/d/1fzT_BdavVKh3mnxxU-PBWyJq9JUfasKwHqekkbYVbw8/edit#slide=id.g56245ab439_0_106">私たちはスライドの提供</a>と併せ<a href="https://www.youtube.com/watch?v=E46lH_eJwRM&feature=youtu.be">セッションの録画を実施などで支援しています</a>。</li>
						</ul>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="section-header">Code of Conduct （行動規範）<br
						class="show-over-1000">のプロセス改善</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>私たちが対面イベントに戻ったとき、Code of Conduct 関連のインシデントについて発生数と深刻度の両方が増加しました。Code of Conduct への関心が高まったことで、以前はその全体をファンデーション側で管理していたプロセスを、コミュニティの代表者を含めて透明性を高めることでモダナイズする（今に即した形にする）必要性が浮き彫りになりました。その結果、今年以下のような取り組みが行われました。</p>

						<div aria-hidden="true" class="report-spacer-20"></div>

						<ul>
							<li>一連の手続きと構造のアップデート版を開発するために <a href="https://www.cncf.io/blog/2022/10/13/the-cncf-code-of-conduct-working-group-has-launched/">Code of Conduct ワーキンググループ</a>を立ち上げました。その取り組みは目下進行中であり、コミュニティの誰にでも参加してコントリビューションする機会があります。ワーキング グループへ参加したり、進捗をチェックやその他詳細情報については<a
									href="https://github.com/cncf/wg-coc">リポジトリにアクセスしてみてください</a> 。</li>
							<div aria-hidden="true" class="report-spacer-20">
							</div>
							<li>また、より恒久的な構造についてワーキング グループによって検討が進む一方で、コミュニティメンバーとスタッフの両方で構成される <a href="https://www.cncf.io/blog/2022/06/23/cncfs-interim-cncf-code-of-conduct-committee-has-launched/">Interim Code of Conduct Committee（暫定的な行動規範委員会）</a>を立ち上げることでインシデントに対応するようになりました。委員会が運用している<a
									href="https://www.cncf.io/conduct/procedures/">The Incident Resolution Procedures （インシデント解決手順）</a> は、今年初めに公開され、パブリック コメント期間を経て最終的なものとなりました。</li>
						</ul>
					</div>
				</div>

			</div>
		</section>

		<section class="section-12 is-style-down-gradient alignfull">

			<div class="container wrap">

				<h2 class="section-header">KubeCon + <br
						class="show-over-1000">CloudNativeCon Europe</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>KubeCon + CloudNativeCon Valencia は、ヨーロッパで #TeamCloudNative を集めた3 年ぶりのイベントとなり、刺激的な雰囲気に満ちた場となりました。実際バレンシアでは、いままで経験したことのない初めてのことがたくさんありました。Boeing（ボーイング）社がプラチナメンバーとして参加しました。CNCF でははじめての航空宇宙業界からの参加です。また、通信業界では <a href="https://events.linuxfoundation.org/cloud-native-telco-day-europe/">Cloud Native Telco Day</a> を初めて開催し、業界を進化させている Deutsche Telekom や Orange などの大手が集まりました。加えて最初の <a href="https://www.cncf.io/reports/cto-summit-eu-2022/">CTO サミット</a>を主催し、組織がマルチクラウド戦略レジリエンスを達成できるアプローチについて議論されました。</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div><img width="1200" height="620" loading="lazy" class="" src="https://www.cncf.io/wp-content/uploads/2022/12/KubeCon-CloudNativeCon-Europe.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/KubeCon-CloudNativeCon-Europe.jpg 1200w, https://www.cncf.io/wp-content/uploads/2022/12/KubeCon-CloudNativeCon-Europe-300x155.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/12/KubeCon-CloudNativeCon-Europe-1024x529.jpg 1024w, https://www.cncf.io/wp-content/uploads/2022/12/KubeCon-CloudNativeCon-Europe-768x397.jpg 768w, https://www.cncf.io/wp-content/uploads/2022/12/KubeCon-CloudNativeCon-Europe-900x465.jpg 900w, https://www.cncf.io/wp-content/uploads/2022/12/KubeCon-CloudNativeCon-Europe-387x200.jpg 387w, https://www.cncf.io/wp-content/uploads/2022/12/KubeCon-CloudNativeCon-Europe-774x400.jpg 774w" sizes="(max-width: 1200px) 100vw, 1200px" alt="KubeCon + CloudNativeCon Europe 2022 へようこそ"><div aria-hidden="true" class="report-spacer-100"></div>

				<p class="sub-header">参加者のデモグラフィック</p>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<figure class="section-12__flowers"><img width="708" height="821" loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/motif.png" alt="Background flower"></figure>

				<picture>
					<source media="(max-width: 599px)" srcset="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/eu-attendees-mobile.svg">
					<source media="(min-width: 600px)" srcset="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/eu-attendees-desktop.svg"><img width="1100" height="364" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/eu-attendees-desktop.svg" alt="登録済み参加者 18,550 人のうち 45.2% が男性、6.5% が女性、0.4% がノンバイナリー/その他、47.9% が無回答であったことを示しています。参加者のうち 7,084 人（38%）が対面参加、11,466 人 （62%） がオンライン参加でした。参加者の 65% が初参加でした。"
						loading="lazy"></picture>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="sub-header">コンテンツ</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="lf-grid section-12__stats">
					<div class="section-12__stats-col1">
						<div class="icon-box-3">
							<div class="icon"><img loading="lazy" width="62" height="62" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-download-pink.svg" alt="Download icon"></div>
							<div class="text"><span class="number">1,187</span><br /> <span class="description"> 件の提案</span></div>
						</div>

					</div>
					<div class="section-12__stats-col2">
						<div class="icon-box-3">
							<div class="icon"><img loading="lazy" width="82" height="67" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-megaphone-pink.svg" alt="Megaphone icon"></div>
							<div class="text"><span class="number">243</span><br /> <span class="description"> 人のスピーカー</span></div>
						</div>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">参加人数上位国</p>

				<div class="lf-grid section-12__top-countries">
					<div class="section-12__top-countries-col1">
						<p class="section-12__header">合計</p>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon"><img loading="lazy" width="45" height="45" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-flag-usa.svg" alt="USA Flag"></div>
							<div class="text"><span class="country">米国</span><br /> <span class="number"> 3,035</span></div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon"><img loading="lazy" width="45" height="45" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-flag-germany.svg" alt="German Flag"></div>
							<div class="text"><span class="country">ドイツ</span><br /> <span class="number">2,463</span></div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon"><img loading="lazy" width="45" height="45" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-flag-india.svg" alt="Indian Flag"></div>
							<div class="text"><span class="country">インド</span><br /> <span class="number">1,798</span></div>
						</div>

					</div>
					<div class="section-12__top-countries-col2">
						<p class="section-12__header">対面参加</p>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon"><img loading="lazy" width="45" height="45" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-flag-usa.svg" alt="USA Flag"></div>
							<div class="text"><span class="country">米国</span><br /> <span class="number"> 1,309</span></div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon"><img loading="lazy" width="45" height="45" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-flag-germany.svg" alt="German Flag"></div>
							<div class="text"><span class="country">ドイツ</span><br /> <span class="number">1,060</span></div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon"><img loading="lazy" width="45" height="45" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-flag-uk.svg" alt="UK Flag"></div>
							<div class="text"><span class="country">英国</span><br /> <span class="number"> 725</span></div>
						</div>
					</div>
					<div class="section-12__top-countries-col3">
						<p class="section-12__header">バーチャル</p>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon"><img loading="lazy" width="45" height="45" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-flag-usa.svg" alt="USA Flag"></div>
							<div class="text"><span class="country">米国</span><br /> <span class="number"> 1,309</span></div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon"><img loading="lazy" width="45" height="45" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-flag-india.svg" alt="India Flag"></div>
							<div class="text"><span class="country">インド</span><br /> <span class="number">1,702</span></div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon"><img loading="lazy" width="45" height="45" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-flag-germany.svg" alt="German Flag"></div>
							<div class="text"><span class="country">ドイツ</span><br /> <span class="number">1,403</span></div>
						</div>

					</div>

				</div>

				<div class="shadow-hr"></div>

				<div class="lf-grid section-12__report">
					<div class="section-12__report-col1">

						<p class="sub-header">詳細は透明性レポートをご覧ください</p>

						<div aria-hidden="true" class="report-spacer-40"></div>

						<div class="wp-block-button"><a href="https://www.cncf.io/reports/kubecon-cloudnativecon-europe-2022/"
								title="KubeCon + CloudNativeCon Europe 2022 透明性レポートを読む"
								class="wp-block-button__link fit-content">レポートを読む</a></div>

					</div>
					<div class="section-12__report-col2"><a href="https://www.cncf.io/reports/kubecon-cloudnativecon-europe-2022/"> <img width="1024" height="538" loading="lazy" class="ds" src="https://www.cncf.io/wp-content/uploads/2022/06/kccnc-eu-22-social-share-1024x538.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/06/kccnc-eu-22-social-share-1024x538.jpg 1024w, https://www.cncf.io/wp-content/uploads/2022/06/kccnc-eu-22-social-share-300x158.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/06/kccnc-eu-22-social-share-768x403.jpg 768w, https://www.cncf.io/wp-content/uploads/2022/06/kccnc-eu-22-social-share-194x102.jpg 194w, https://www.cncf.io/wp-content/uploads/2022/06/kccnc-eu-22-social-share-388x204.jpg 388w, https://www.cncf.io/wp-content/uploads/2022/06/kccnc-eu-22-social-share-776x408.jpg 776w, https://www.cncf.io/wp-content/uploads/2022/06/kccnc-eu-22-social-share-1552x816.jpg 1552w, https://www.cncf.io/wp-content/uploads/2022/06/kccnc-eu-22-social-share-900x473.jpg 900w, https://www.cncf.io/wp-content/uploads/2022/06/kccnc-eu-22-social-share-381x200.jpg 381w, https://www.cncf.io/wp-content/uploads/2022/06/kccnc-eu-22-social-share-762x400.jpg 762w, https://www.cncf.io/wp-content/uploads/2022/06/kccnc-eu-22-social-share-590x310.jpg 590w, https://www.cncf.io/wp-content/uploads/2022/06/kccnc-eu-22-social-share-1180x620.jpg 1180w, https://www.cncf.io/wp-content/uploads/2022/06/kccnc-eu-22-social-share.jpg 1800w" sizes="(max-width: 500px) 100vw, 500px" alt="KubeCon + CloudNativeCon Europe 2022 透明性レポートの表紙"> </a></div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">ハイライト ビデオ</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="wp-block-lf-youtube-lite">
					<lite-youtube videoid="SqesB4xcAUY"
						videotitle="Highlights from KubeCon + CloudNativeCon Europe 2022"
						webpstatus="1" sdthumbstatus="0"
						title="Play Highlights">
					</lite-youtube>
				</div>

			</div>
		</section>

				<section class="section-12 is-style-down-gradient alignfull">

			<div class="container wrap">

				<h2 class="section-header">KubeCon + CloudNativeCon <br
						class="show-over-1000">North America</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>KubeCon + CloudNativeCon North America は中西部としてこれほど多くの人が集まった初めてのイベントとなり、デトロイトは素晴らしい開催都市となりました。<a href="https://www.sonatype.com/">Sonatype</a> とのパートナーシップでは <a href="https://community.cncf.io/cloud-native-security-slam/">Security Slam</a> を含め、多くの新たなイニシアチブを立ち上げました。KubeCon + CloudNativeCon では、ウクライナ軍従事から短期間の休暇で参加した「Senior Developer Advocate」の Ihor Dvoretskyi を歓迎するなど、いくつか特別なサプライズもありました。</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div><img width="2392" height="1376" loading="lazy" class="" src="https://www.cncf.io/wp-content/uploads/2022/12/KCCNC-NA-22-on-stage.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/KCCNC-NA-22-on-stage.jpg 2392w, https://www.cncf.io/wp-content/uploads/2022/12/KCCNC-NA-22-on-stage-300x173.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/12/KCCNC-NA-22-on-stage-1024x589.jpg 1024w, https://www.cncf.io/wp-content/uploads/2022/12/KCCNC-NA-22-on-stage-768x442.jpg 768w, https://www.cncf.io/wp-content/uploads/2022/12/KCCNC-NA-22-on-stage-900x518.jpg 900w, https://www.cncf.io/wp-content/uploads/2022/12/KCCNC-NA-22-on-stage-1800x1035.jpg 1800w, https://www.cncf.io/wp-content/uploads/2022/12/KCCNC-NA-22-on-stage-348x200.jpg 348w, https://www.cncf.io/wp-content/uploads/2022/12/KCCNC-NA-22-on-stage-695x400.jpg 695w" sizes="(max-width: 1200px) 100vw, 1200px" alt="KubeCon + CloudNativeCon North America 2022 のステージ上のプレゼンターたち"><div aria-hidden="true" class="report-spacer-100"></div>

				<p class="sub-header">参加者のデモグラフィック</p>

				<picture>
					<source media="(max-width: 499px)"
						srcset="https://www.cncf.io/wp-content/uploads/2022/12/demographics-mobile.png">
					<source media="(min-width: 500px)"
						srcset="https://www.cncf.io/wp-content/uploads/2022/12/demographics-desktop.png"><img width="2337" height="1117" loading="lazy" class="" src="https://www.cncf.io/wp-content/uploads/2022/12/demographics-desktop.png" srcset="https://www.cncf.io/wp-content/uploads/2022/12/demographics-desktop.png 2337w, https://www.cncf.io/wp-content/uploads/2022/12/demographics-desktop-300x143.png 300w, https://www.cncf.io/wp-content/uploads/2022/12/demographics-desktop-1024x489.png 1024w, https://www.cncf.io/wp-content/uploads/2022/12/demographics-desktop-768x367.png 768w, https://www.cncf.io/wp-content/uploads/2022/12/demographics-desktop-900x430.png 900w, https://www.cncf.io/wp-content/uploads/2022/12/demographics-desktop-1800x860.png 1800w, https://www.cncf.io/wp-content/uploads/2022/12/demographics-desktop-418x200.png 418w, https://www.cncf.io/wp-content/uploads/2022/12/demographics-desktop-837x400.png 837w" sizes="(max-width: 1200px) 100vw, 1200px" alt="登録済みの参加者 16,986 人のうち7403 人が対面で参加 64% が初参加だったことを示しています。"></picture>

				<div aria-hidden="true" class="report-spacer-140"></div>

				<p class="sub-header">コンテンツ</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="lf-grid section-12__stats">
					<div class="section-12__stats-col1">
						<div class="icon-box-3">
							<div class="icon"><img loading="lazy" width="62" height="62" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-download-pink.svg" alt="Download icon"></div>
							<div class="text"><span class="number">1,551</span><br /> <span class="description"> 件の提案</span></div>
						</div>

					</div>
					<div class="section-12__stats-col2">
						<div class="icon-box-3">
							<div class="icon"><img loading="lazy" width="82" height="67" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-megaphone-pink.svg" alt="Megaphone icon"></div>
							<div class="text"><span class="number">531</span><br /> <span class="description"> 人のスピーカー</span></div>
						</div>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">参加人数上位国</p>

				<div class="lf-grid section-12__top-countries">
					<div class="section-12__top-countries-col1">
						<p class="section-12__header">合計</p>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon"><img loading="lazy" width="45" height="45" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-flag-usa.svg" alt="USA Flag"></div>
							<div class="text"><span class="country">米国</span><br /> <span class="number"> 10,568</span></div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon"><img loading="lazy" width="45" height="45" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-flag-india.svg" alt="Indian Flag"></div>
							<div class="text"><span class="country">インド</span><br /> <span class="number">1,739</span></div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon"><img loading="lazy" width="45" height="45" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-flag-canada.svg" alt="Canadian Flag"></div>
							<div class="text"><span class="country">カナダ</span><br /> <span class="number">748</span></div>
						</div>

					</div>
					<div class="section-12__top-countries-col2">
						<p class="section-12__header">対面参加</p>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon"><img loading="lazy" width="45" height="45" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-flag-usa.svg" alt="USA Flag"></div>
							<div class="text"><span class="country">米国</span><br /> <span class="number">5,744</span></div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon"><img loading="lazy" width="45" height="45" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-flag-canada.svg" alt="Canadian Flag"></div>
							<div class="text"><span class="country">カナダ</span><br /> <span class="number">291</span></div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon"><img loading="lazy" width="45" height="45" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-flag-israel.svg" alt="Israel Flag"></div>
							<div class="text"><span class="country">イスラエル</span><br /> <span class="number">184</span></div>
						</div>
					</div>
					<div class="section-12__top-countries-col3">
						<p class="section-12__header">バーチャル</p>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon"><img loading="lazy" width="45" height="45" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-flag-usa.svg" alt="USA Flag"></div>
							<div class="text"><span class="country">米国</span><br /> <span class="number"> 4,824</span></div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon"><img loading="lazy" width="45" height="45" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-flag-india.svg" alt="India Flag"></div>
							<div class="text"><span class="country">インド</span><br /> <span class="number">1,664</span></div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon"><img loading="lazy" width="45" height="45" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-flag-canada.svg" alt="Canada Flag"></div>
							<div class="text"><span class="country">カナダ</span><br /> <span class="number">457</span></div>
						</div>

					</div>
				</div>

				<div class="shadow-hr"></div>

				<div class="lf-grid section-12__report">
					<div class="section-12__report-col1">

						<p class="sub-header">詳細は透明性レポートをご覧ください</p>

						<div aria-hidden="true" class="report-spacer-40"></div>

						<div class="wp-block-button"><a href="https://www.cncf.io/reports/kubecon-cloudnativecon-north-america-2022-transparency-report/"
								title="KubeCon + CloudNativeCon North America 2022 の透明性レポートを読む"
								class="wp-block-button__link fit-content">レポートを読む</a></div>

					</div>
					<div class="section-12__report-col2"><a href="https://www.cncf.io/reports/kubecon-cloudnativecon-north-america-2022-transparency-report/"> <img width="1024" height="538" loading="lazy" class="ds" src="https://www.cncf.io/wp-content/uploads/2022/12/KCCNC-NA-22-Report-Cover-1024x538.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/KCCNC-NA-22-Report-Cover-1024x538.jpg 1024w, https://www.cncf.io/wp-content/uploads/2022/12/KCCNC-NA-22-Report-Cover-300x158.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/12/KCCNC-NA-22-Report-Cover-768x403.jpg 768w, https://www.cncf.io/wp-content/uploads/2022/12/KCCNC-NA-22-Report-Cover-194x102.jpg 194w, https://www.cncf.io/wp-content/uploads/2022/12/KCCNC-NA-22-Report-Cover-388x204.jpg 388w, https://www.cncf.io/wp-content/uploads/2022/12/KCCNC-NA-22-Report-Cover-776x408.jpg 776w, https://www.cncf.io/wp-content/uploads/2022/12/KCCNC-NA-22-Report-Cover-1552x816.jpg 1552w, https://www.cncf.io/wp-content/uploads/2022/12/KCCNC-NA-22-Report-Cover-900x473.jpg 900w, https://www.cncf.io/wp-content/uploads/2022/12/KCCNC-NA-22-Report-Cover-1800x945.jpg 1800w, https://www.cncf.io/wp-content/uploads/2022/12/KCCNC-NA-22-Report-Cover-381x200.jpg 381w, https://www.cncf.io/wp-content/uploads/2022/12/KCCNC-NA-22-Report-Cover-762x400.jpg 762w, https://www.cncf.io/wp-content/uploads/2022/12/KCCNC-NA-22-Report-Cover-590x310.jpg 590w, https://www.cncf.io/wp-content/uploads/2022/12/KCCNC-NA-22-Report-Cover-1180x620.jpg 1180w" sizes="(max-width: 500px) 100vw, 500px" alt="KubeCon + CloudNativeCon North America 2022 透明性レポートの表紙"> </a></div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">ハイライト ビデオ</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="wp-block-lf-youtube-lite">
					<lite-youtube videoid="Q1cA0iGw84g"
						videotitle="Highlights from KubeCon + CloudNativeCon North America 2022"
						webpstatus="1" sdthumbstatus="0"
						title="Play Highlights">
					</lite-youtube>
				</div>

			</div>
		</section>

		<section id="training"
			class="section-14 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">トレーニングと<br
							class="show-over-1000">認定</h2>
					<div class="section-number">3/6</div>
				</div>

				<div class="lf-grid">
					<p
						class="opening-paragraph restrictive-10-col">CNCF は、2022 年にクラウドネイティブ エコシステムを成長させるというコミットメントを強化しました。世界的に認められた認定資格を広め、雇用機会を増やし、より多くの人々がクラウド ネイティブ テクノロジーの実践的適用ができるスキルの向上を支援します。</p>
				</div>

				<div class="lf-grid">
					<div class="restrictive-10-col">
						<p>今年、私たちは <a href="https://training.linuxfoundation.org/certification/prometheus-certified-associate/">Prometheus 認定アソシエイト （PCA:Prometheus Certified Associate）</a> を立ち上げしました。これは、エンジニアのオブザーバビリティとスキルに関する基礎知識、および監視およびアラートのオープンソースのツールキットである Prometheus の活用スキルを証明します。<br><br>また新しい一連の資格として <a href="https://training.linuxfoundation.org/blog/skillcreds/">SkillCred</a>.も始まりました。これらにより、学習者は自分の経験に関係している、より具体的なトピックに関するスキル証明資格を取得できるようになります。最初の SkillCred には、<a href="https://training.linuxfoundation.org/certification/helm/">Developing Helm Charts (SC104)</a> と <a href="https://training.linuxfoundation.org/certification/yaml/">Open Data Formats: YAML (SC101)</a> の2つが含まれています。これらの「マイクロクレデンシャル」はトピック固有で、短時間の試験で、コスト的にも安価です。<br><br>トレーニングと認定の重要性、およびCNCFのトレーニングコースが開催されるという話は、今年中国で今年強調されました。外国人は<a href="https://training.linuxfoundation.cn/news/294">CKA認定を取得する場合、北京のビザを申請できるようになりました</a>。</p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="section-header">2022 年トレーニング<br
						class="show-over-1000">コース</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-14__intro">
					<div class="section-14__intro-col1">
						<p>CNCF のトレーニングおよび認定プログラムは成長を続けました。2022 年、これらのトレーニング コースと認定試験は大きな関心を集めました。</p>
					</div>
					<div class="section-14__intro-col2"><img width="582" height="124" loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/training-logos.png" alt="LF のクラウドネイティブ トレーニング コース"></div>

				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid section-14__courses">

					<div class="course-box"><span class="course-box__number">25%</span> <span class="course-box__text">の増加</span><div class="thin-hr course-box__hr"></div>
						<p
							class="course-box__description"><a href="https://www.cncf.io/certification/training/#introduction">Kubernetes Massively Open Online Course （MOOC）</a> の登録数が 290,000 件を突破</p>
					</div>

					<div class="course-box"><span class="course-box__number">49%</span> <span class="course-box__text">の増加</span><div class="thin-hr course-box__hr"></div>
						<p
							class="course-box__description"><a href="https://www.cncf.io/certification/expert/">Certified Kubernetes Administrator （CKA)）</a>試験の登録数が 104,000 件に到達</p>
					</div>

					<div class="course-box"><span class="course-box__number">44%</span> <span class="course-box__text">の増加</span><div class="thin-hr course-box__hr"></div>
						<p
							class="course-box__description"><a href="https://www.cncf.io/certification/ckad/">Certified Kubernetes Application Developer （CKAD）</a>の試験登録数が 49,000 件に到達</p>
					</div>

					<div class="course-box"><span class="course-box__number">113%</span> <span class="course-box__text">の増加</span><div class="thin-hr course-box__hr"></div>
						<p
							class="course-box__description"><a href="https://www.cncf.io/certification/cks/">Certified Kubernetes Security Specialist （CKS）</a>試験の登録数が 18,000 件に到達</p>
					</div>
					<div class="course-box"><span class="course-box__number">4,000 </span> <span class="course-box__text">件の登録</span><div class="thin-hr course-box__hr"></div>
						<p
							class="course-box__description"><a href="https://www.cncf.io/certification/kcna/">Kubernetes and Cloud Native Associate （KCNA）</a>試験の登録数が 4,000 件に到達 （2021 年 11 月の開始以来）</p>
					</div>
					<div class="course-box"><span class="course-box__number">280 </span> <span class="course-box__text">件以上の登録</span><div class="thin-hr course-box__hr"></div>
						<p
							class="course-box__description"><a href="https://www.cncf.io/certification/pca/">Prometheus 認定アソシエイト （PCA）</a>試験は 280 件以上の登録を記録 (2022 年 9 月 8 日の開始以来）</p>
					</div>
					<div class="course-box"><span class="course-box__number">14%</span> <span class="course-box__text">の増加</span><div class="thin-hr course-box__hr"></div>
						<p
							class="course-box__description"><a href="https://cncf.io/certification/kubernetes-training-partners/">Kubernetes トレーニング パートナー（KTP）</a>プログラムは 57 の認定企業に拡大</p>
					</div>
					<div class="course-box"><span class="course-box__number">8.5%</span> <span class="course-box__text">の増加</span><div class="thin-hr course-box__hr"></div>
						<p
							class="course-box__description"><a href="https://www.cncf.io/certification/kcsp/">Kubernetes Certified Service Provider （KCSP）</a>プログラムが 254 社に拡大</p>
					</div>
				</div>
			</div>
		</section>

		<section id="projects"
			class="section-15 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">プロジェクト アップデート<br
							class="show-over-1000">と満足度</h2>
					<div class="section-number">4/6</div>
				</div>

				<div class="lf-grid">
					<p
						class="opening-paragraph restrictive-10-col">CNCF は 2022 年を通じ、クラウド ネイティブをユビキタスにするコミットメントを強調しつづけました。CNCFでは 189 か国を代表する <strong>178,000 人を超えるコントリビューターたち</strong>によって推進された <a href="https://www.cncf.io/projects/">20 の Graduated プロジェクト</a>、<a href="https://www.cncf.io/projects/">35 の Incubating プロジェクト</a>、<a href="https://www.cncf.io/sandbox-projects/">102 の Sandbox プロジェクト</a>をホストしています。</p>
				</div>

				<p class="sub-header">受け入れられたプロジェクトの推移</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="projects-chart-container">
	<canvas id="projctsMaturityChart"></canvas>
</div>
<script>
	const project_months     = ["2016-01-01","2016-02-01","2016-03-01","2016-04-01","2016-05-01","2016-06-01","2016-07-01","2016-08-01","2016-09-01","2016-10-01","2016-11-01","2016-12-01","2017-01-01","2017-02-01","2017-03-01","2017-04-01","2017-05-01","2017-06-01","2017-07-01","2017-08-01","2017-09-01","2017-10-01","2017-11-01","2017-12-01","2018-01-01","2018-02-01","2018-03-01","2018-04-01","2018-05-01","2018-06-01","2018-07-01","2018-08-01","2018-09-01","2018-10-01","2018-11-01","2018-12-01","2019-01-01","2019-02-01","2019-03-01","2019-04-01","2019-05-01","2019-06-01","2019-07-01","2019-08-01","2019-09-01","2019-10-01","2019-11-01","2019-12-01","2020-01-01","2020-02-01","2020-03-01","2020-04-01","2020-05-01","2020-06-01","2020-07-01","2020-08-01","2020-09-01","2020-10-01","2020-11-01","2020-12-01","2021-01-01","2021-02-01","2021-03-01","2021-04-01","2021-05-01","2021-06-01","2021-07-01","2021-08-01","2021-09-01","2021-10-01","2021-11-01","2021-12-01","2022-01-01","2022-02-01","2022-03-01","2022-04-01","2022-05-01","2022-06-01","2022-07-01","2022-08-01","2022-09-01","2022-10-01","2022-11-01","2022-12-01","2023-01-01"];
	const project_sandbox    = [0,0,0,0,0,0,0,0,0,0,0,0,0,1,2,3,3,3,3,3,3,3,3,3,3,4,4,7,6,8,8,9,10,10,12,12,13,13,13,15,15,17,17,19,20,21,21,20,21,20,20,22,22,22,32,34,33,39,39,45,45,51,51,54,61,61,65,69,67,70,71,76,76,76,74,73,76,76,81,82,82,87,86,86,94];
	const project_incubating = [0,0,0,1,1,2,2,2,2,2,3,4,4,4,5,6,6,7,7,7,7,9,11,11,11,11,12,12,13,13,14,14,14,15,15,15,16,15,14,14,15,15,15,15,15,15,15,15,14,15,15,16,17,16,17,19,21,21,20,20,20,19,19,20,21,21,21,20,22,23,23,25,25,26,28,32,32,32,32,35,33,36,36,35,34];
	const project_graduated  = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,1,1,1,2,2,2,3,3,4,5,5,6,6,6,6,6,6,7,8,9,9,9,9,9,10,11,11,11,12,13,14,14,15,15,15,15,15,15,16,16,16,16,16,16,16,16,16,16,16,16,16,18,18,18,19,20];
	const project_archived   = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,2,2,2];
</script>

	
				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="lf-grid">
					<p
						class="restrictive-10-col"><a href="https://www.cncf.io/people/technical-oversight-committee/">Technical Oversight Committee（技術監督委員会）</a>は、2022 年にクラウド ネイティブにおけるセキュリティを強化しました。また、クラウドネイティブ コンピューティングに関する炭素排出量に焦点を当てた新たな技術諮問グループ（Technical Advisory Group）となる、「TAG Environmental Sustainability」 を発足を承認しました。</p>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">CNCF プロジェクトの速度</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="lf-grid">
					<p
						class="restrictive-10-col">CNCF プロジェクトの速度（Velocity）や、上位に位置するオープンソース<a href="https://github.com/cncf/velocity">プロジェクトを定期観測することで</a>、開発者やエンドユーザーが共鳴しているトレンドをとてもよく知ることができます。その結果として、成功に向かうであろうプラットフォームについての洞察を得ることができるのです。</p>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid legend-grid">

					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #feb95a"></div><span><strong>Argo</strong><br>814人の作者</span></div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #68b86a">
						</div><span><strong>Backstage</strong><br>580人の作者</span></div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #853e81">
						</div><span><strong>containerd</strong><br>255人の作者</span></div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #da575f">
						</div><span><strong>CoreDNS</strong><br>69人の作者</span></div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #5fb9d6">
						</div><span><strong>Envoy</strong><br>399人の作者</span></div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #cb7070">
						</div><span><strong>etcd</strong><br>115人の作者</span></div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #e46991">
						</div><span><strong>Fluentd</strong><br>275人の作者</span></div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #b65f5f">
						</div><span><strong>Flux</strong><br>258人の作者</span></div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #a396b7">
						</div><span><strong>Harbor</strong><br>126人の作者</span></div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #35ab9b">
						</div><span><strong>Helm</strong><br>160人の作者</span></div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #bdb844">
						</div><span><strong>Jaeger</strong><br>145人の作者</span></div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #4e22c8">
						</div><span><strong>Kubernetes</strong><br>3619人の作者</span></div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #e0a343">
						</div><span><strong>Linkerd</strong><br>122人の作者</span></div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #be5ab9">
						</div><span><strong>OPA</strong><br>259人の作者</span></div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #e45f40">
						</div><span><strong>OpenTelemetry</strong><br>1133人の作者</span></div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #9fc45a">
						</div><span><strong>Prometheus</strong><br>424人の作者</span></div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #81925c">
						</div><span><strong>Rook</strong><br>99人の作者</span></div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #4dd957">
						</div><span><strong>Spiffe</strong><br>44人の作者</span></div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #e2e898">
						</div><span><strong>Spire</strong><br>54人の作者</span></div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #6181a8">
						</div><span><strong>TiKV</strong><br>257人の作者</span></div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #f2aa90">
						</div><span><strong>TUF</strong><br>51人の作者</span></div>
					<div class="legend-item">
						<div class="legend-box"
							style="background-color: #9e6399">
						</div><span><strong>Vitess</strong><br>101人の作者</span></div>




				</div>

				<div aria-hidden="true" class="report-spacer-60"></div><img loading="lazy" width="1200" height="700" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/cncf-project-velocity.svg" alt="CNCF プロジェクトの速度チャート"><div class="shadow-hr"></div>

				<p class="sub-header">プロジェクト速度に関する重要ポイント（Takeaways）</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="lf-grid">
					<ul class="restrictive-10-col" style="margin-bottom: 0;">
						<li>最大規模のコントリビュータ ベースとともに、<strong>Kubernetes</strong> は成熟し続けている</li>
						<li><strong>OpenTelemetry</strong> は、CNCF エコシステムで 2 番目に速度が高いプロジェクトになり、コントリビューター ベースを増やしている</li>
						<li><strong>Backstage</strong> は今年最も急速な成長軌道を目の当たりにした 1 つで、クラウド ネイティブのデベロッパー エクスペリエンスに関する重要な問題点を解決しようとしている</li>
						<li><strong>GitOps</strong> は、<strong>Argo</strong> や <strong>Flux</strong> などのようなプロジェクトが大きなコミュニティを育て続けており、クラウドネイティブ エコシステムにおいて重要なテクニックであり続けている</li>
					</ul>
				</div>

				<div class="section-01__author"><img width="269" height="271" loading="lazy" class="" src="https://www.cncf.io/wp-content/uploads/2022/12/Chris-Aniszczyk.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/Chris-Aniszczyk.jpg 269w, https://www.cncf.io/wp-content/uploads/2022/12/Chris-Aniszczyk-150x150.jpg 150w, https://www.cncf.io/wp-content/uploads/2022/12/Chris-Aniszczyk-199x200.jpg 199w" sizes="(max-width: 75px) 100vw, 75px" alt="Chris Aniszczyk"><p><strong>Chris Aniszczyk</strong><br> CTO, CNCF</p>
				</div>
			</div>
		</section>

		<section class="section-16 is-style-down-gradient alignfull">

			<div class="container wrap">

				<h2 class="section-header">セキュリティ</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>CNCF は、<a href="https://www.cncf.io/blog/2022/08/08/improving-cncf-security-posture-with-independent-security-audits/">Open Source Technology Improvement Fund （OSTIF） </a>との戦略的パートナーシップにより、2022 年を通じて多数の<strong>オープンソース セキュリティ監査</strong>を実施しました。多くのプロジェクトがセキュリティ監査を完了しました。この結果 132 件のセキュリティ修正や改善、<strong>45 件の CVE 修正</strong>、<strong>51 件のセキュリティ ツールの構築</strong>が行われました。また、2023 年に開始される初の <a href="https://events.linuxfoundation.org/cloud-native-securitycon-north-america/">CloudNative SecurityCon</a> も発表しました。ここではアプリケーション開発者と最新のセキュリティ専門家が、過去のもの漸進的に改善するソリューションを提案するだけでなく、最先端のプロジェクトとモダンなセキュリティ アプローチについての機会を提供します。<br><br>さらに、<a href="https://www.cncf.io/blog/2022/06/28/improving-security-by-fuzzing-the-cncf-landscape/">CNCF はさまざまなプロジェクトのファジング監査</a>に資金を提供し、その結果、何百ものバグ発見につながりました。</p>

					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p
					class="sub-header">以下の CNCF プロジェクトは、セキュリティ監査またそれにかかる作業が完了しています</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="logo-grid smaller">
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-project-argo.svg" alt="Argo Logo" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-project-backstage.svg" alt="Backstage Logo" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-project-cilium.svg" alt="Cilium Logo" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-project-cloudevents.svg" alt="Cloud Events Logo" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-project-containerd.svg" alt="ContainerD Logo" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-project-contour.svg" alt="Contour Logo" class="logo-grid__image"></div>

					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-project-crio.svg" alt="Crio Logo" class="logo-grid__image"></div>

					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-project-envoy.svg" alt="Envoy Logo" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-project-falco.svg" alt="Falco Logo" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-project-flux.svg" alt="Flux Logo" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-project-istio.svg" alt="Istio Logo" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-project-keda.svg" alt="Keda Logo" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-project-kubeedge.svg" alt="Kube Edge Logo" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-project-kubernetes.svg" alt="Kubernetes Logo" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-project-linkerd.svg" alt="Linkerd Logo" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-project-tuf.svg" alt="TUF Logo" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-project-vitess.svg" alt="Vitess Logo" class="logo-grid__image"></div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">改善ポイントの概要</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-16__improvements">

					<div class="section-16__improvements-col1">
						<div class="icon-box-3">
							<div class="icon"><img loading="lazy" width="40" height="50" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-checkmark.svg" alt="Checkmark icon"></div>
							<div class="text"><span class="number">132</span><br /> <span class="description">のセキュリティFIXと改善</span></div>
						</div>
					</div>

					<div class="section-16__improvements-col2">
						<div class="icon-box-3">
							<div class="icon"><img loading="lazy" width="25" height="50" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-flag.svg" alt="Flag icon"></div>
							<div class="text"><span class="number">45</span><br /> <span class="description">の CVE の報告および修正</span> <span class="addendum"> ここには5 件のクリティカル案件 10 件の深刻度の高い発見と修正が含まれる </span></div>
						</div>
					</div>


					<div class="section-16__improvements-col3">
						<div class="icon-box-3">
							<div class="icon"><img loading="lazy" width="51" height="52" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-tools.svg" alt="Tool icon"></div>
							<div class="text"><span class="number">51</span><br /> <span class="description">のセキュリティ ツールの構築</span></div>
						</div>
					</div>

					<div class="section-16__improvements-col4">
						<div class="icon-box-3">
							<div class="icon"><img loading="lazy" width="62" height="62" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-checklist.svg" alt="Checlist icon"></div>
							<div class="text"><span class="number small">DoS、XSS、パストラバーサル、権限昇格、RCE</span><br /> <span class="description">といったタイプの脆弱性のFIX</span></div>
						</div>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="section-header">テレコムの進歩</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>2022 年はテレコム 業界でCNCF のフットプリントが増加した年となりました。5 月に、<a href="https://www.cncf.io/certification/cnf/">クラウドネイティブ ネットワークファンクション認定プログラム（Cloud Native Network Function (CNF) Certification Program） のベータ版</a> が発表されました。これは、通信サービス プロバイダー （CSP） たちが彼らが使うベンダー製品がクラウドネイティブの原則にどの程度準拠しているかを検証し、クラウド ネイティブのベストプラクティスに沿った方でベンダーにアドバイスするのを支援するプログラムです。このプログラムは Vodafone、Deutsche Telekom、DISH Wireless などの CSP によってサポートされており、 <a href="https://github.com/cncf/cnf-wg">クラウドネイティブ ネットワークファンクション (CNF) ワーキンググループ</a>のベスト プラクティスによってガイドされ、<a href="https://github.com/cncf/cnf-testsuite">CNF テストスイート</a>上で認定テストも行います。</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="sub-header">ハイライト</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-16__highlights">

					<div class="section-16__highlights-col1">
						<div class="icon-box-3">
							<div class="icon"><img loading="lazy" width="40" height="50" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-building-pink.svg" alt="Building icon"></div>
							<div class="text"><span class="number">4</span><br /> <span class="description">つの CNF ベンダー</span> <span class="addendum">が、<a
										href="https://www.prnewswire.com/news-releases/cncf-announces-first-products-certified-under-cloud-native-network-function-certification-program-301657188.html">6 プロダクトに対し「CNF 認定」ステータスを獲得</a></span></div>
						</div>
					</div>
					<div class="section-16__highlights-col2">
						<div class="icon-box-3">
							<div class="icon"><img loading="lazy" width="40" height="50" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-calendar-pink.svg" alt="Calendar icon"></div>
							<div class="text"><span class="number">2</span><br /> <span class="description"> つの Cloud Native Telco Days が開催</span></div>
						</div>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="section-header">Kubernetes API <br
						class="show-over-1000">エンドポイント テスト</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>APISnoop によって行われている Kubernetes API の適合テストの 100% カバレッジの目標へ向けて、2022 年に大きな進歩がありました。<a href="https://apisnoop.cncf.io/about">APISnoop</a> はコミュニティ主導のプロジェクトで e2e テストの実行によって作成された監査ログを分析することにより、テストと適合カバレッジを追跡します。このプロジェクトは長年にわたる CNCF のコントリビューターであり、コミュニティ リーダーの <a href="https://twitter.com/hippiehacker">Hippie Hacker</a> が率いています。</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<p>2022 年の初めの段階でテスト未実施のエンドポイントが 85 残っていました。</p>

				<div aria-hidden="true" class="report-spacer-20"></div>

				<p><strong>3 つのリリースにわたって適合性テストが追加されました。</strong><br>1.24 - 16 個のエンドポイントのテスト完了<br>1.25 - 23 個のエンドポイントがテスト完了<br>1.26 - 10 エンドポイントのテスト完了</p>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="sub-header">エンドポイントのテスト結果</p>

				<div aria-hidden="true" class="report-spacer-60"></div><img loading="lazy" width="1200" height="600" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/endpoint-testing-results.svg" alt="エンドポイントのテスト結果チャート"><div aria-hidden="true" class="report-spacer-80"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>これと同時に、適合性テストで 26 のエンドポイントが不適格であると認識され、<a href="https://apisnoop.cncf.io/conformance-progress/ineligible-endpoints">不適格エンドポイント リストに移りました</a>。2022 年末までの段階でテストされていない<a href="https://apisnoop.cncf.io/conformance-progress/endpoints/1.26.0/?filter=untested">エンドポイントは 10</a>（2.5%） となりました。Kubecon + CloudNativeCon Europe 2023 までには、この最後の<a href="https://apisnoop.cncf.io/conformance-progress">技術負債</a>が解消できると期待しています。<br><br>CNCF Kubernetes Conformance Certification リポジトリの自動化がアップデートされ、内部の機能改善が進み、<a href="https://www.cncf.io/blog/2022/10/19/kubernetes-conformance-updates-for-october-2022/">ユーザーエクスペリエンスが強化</a>されました。CNCF-CI ボットは、提出した要求事項が受け入れらなかった場合、より詳細な説明も提供するようになりサポート ドキュメントも改善されました。これらの変更は、Kubernetes 適合申請をレビュー、 承認する際の複雑さを軽減することに役立ちます。</p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="section-header">プロジェクトの動き</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<p class="sub-header">受け入れられたCNCFプロジェクト</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<p>2022 年、<a href="https://github.com/cncf/toc">CNCF TOC</a> は 35 の新しいプロジェクトを Accept しました。</p>

				<div aria-hidden="true" class="report-spacer-40"></div><img loading="lazy" width="1200" height="500" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/projects-accepted-2022.svg" alt="年ごとの Accept されたプロジェクトのチャート - 2022 年には 35 の新たなプロジェクトが受け入れられました"><div aria-hidden="true" class="report-spacer-80"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>プロジェクトは、エンドユーザーやベンダーでの採用を達成したり、コードコミットとコードベースの変更における健全といえる割合を確保したり、複数の組織からのコミッターを引き付けたりしたことを <a href="https://www.cncf.io/people/technical-oversight-committee/">TOC</a> に示すことで、その成熟度を高めていきます。</p>

					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">Graduated プロジェクト</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="logo-grid smaller">
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-project-argo.svg" alt="Argo Logo" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-project-flux.svg" alt="Flux Logo" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-project-spiffe.svg" alt="Spiffe Logo" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-project-spire.svg" alt="Spire Logo" class="logo-grid__image"></div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">Incubation レベル</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<p>インキュベーション レベルで新たに参加、もしくは Sandbox から Incubation に移ってきたもの</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="logo-grid smallest">
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-project-backstage.svg" alt="Backstage Logo" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-project-cert-manager.svg" alt="Cert Manager Logo" class="logo-grid__image"></div>

					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-project-chaosmesh.svg" alt="Chaos Mesh Logo" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-project-cloud-custodian.svg" alt="Cloud Custodian Logo" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-project-cube-fs.svg" alt="Cube FS Logo" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-project-in-toto.svg" alt="In Toto Logo" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-project-istio.svg" alt="Istio Logo" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-project-litmus.svg" alt="Litmus Logo" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-project-knative.svg" alt="Knative Logo" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-project-kube-virt.svg" alt="Kube Virt Logo" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-project-kyverno.svg" alt="Kyverno Logo" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-project-open-metrics.svg" alt="Open Metrics Logo" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-project-volcano.svg" alt="Volcano Logo" class="logo-grid__image"></div>
				</div>
			</div>
		</section>

		<section class="section-17 is-style-down-gradient alignfull">

			<div class="container wrap">

				<h2 class="section-header">Phippy と仲間たちがクラウドネイティブ<br
						class="show-over-1000">コンピューティングを説明するよ</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>ささやかなPHPアプリである Phippy は、コンテナ化から自動化にいたる、クラウドネイティブコンピューティングを理解するために何千もの人たちが踏み出す最初の一歩を助けてくれます。今日、Phippy とその仲間たちの使命は、クラウドネイティブコンピューティングの神秘を解き明かし、そのわかりづらい概念を、納得感があり、おもしろく、そしてわかりやすい形で説明することにあるのです。</p>
					</div>
				</div>
				<div aria-hidden="true" class="report-spacer-100"></div>

				<p
					class="sub-header">2022 年は 2 つのプロジェクトがキャラクターを寄贈してくれました</p>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid section-17__characters"><img width="1845" height="1212" loading="lazy" class="" src="https://www.cncf.io/wp-content/uploads/2022/12/new-phippy-characters.png" srcset="https://www.cncf.io/wp-content/uploads/2022/12/new-phippy-characters.png 1845w, https://www.cncf.io/wp-content/uploads/2022/12/new-phippy-characters-300x197.png 300w, https://www.cncf.io/wp-content/uploads/2022/12/new-phippy-characters-1024x673.png 1024w, https://www.cncf.io/wp-content/uploads/2022/12/new-phippy-characters-768x505.png 768w, https://www.cncf.io/wp-content/uploads/2022/12/new-phippy-characters-900x591.png 900w, https://www.cncf.io/wp-content/uploads/2022/12/new-phippy-characters-1800x1182.png 1800w, https://www.cncf.io/wp-content/uploads/2022/12/new-phippy-characters-304x200.png 304w, https://www.cncf.io/wp-content/uploads/2022/12/new-phippy-characters-609x400.png 609w" sizes="(max-width: 1000px) 100vw, 1000px" alt="新しい Phippy キャラクター、フクロウの Owlina（Open Policy Agentから寄贈）とカメの Cappy"></div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="sub-header">Phippy と仲間たちが が 3D に大変身</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="wp-block-lf-youtube-lite">
					<lite-youtube videoid="-etekNAO2Xc"
						videotitle="Phippy gets a 3D makeover" webpstatus="1"
						sdthumbstatus="0" title="Play Phippy 3D">
					</lite-youtube>
				</div>
				<div class="shadow-hr"></div>

				<p class="sub-header">「Phippy と仲間たち」ファミリーに参加しましょう！</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="section-17__banner">
					<div class="section-17__banner-wrapper">
						<h2 class="section-17__banner-title">あなたは Graduated プロジェクトのメンテナーですか？</h2>
						<p
							class="section-17__banner-text">多くの人がクラウドネイティブ コンピューティングのコンセプトを理解できるよう、その手助けをしてみませんか?「Phippy と仲間たち」ファミリーにキャラクターを寄贈しましょう。</p>
					</div>
					<div class="wp-block-button"><a href="https://github.com/cncf/foundation/blob/master/phippy-guidelines.md"
							title="キャラクターを寄贈する"
							class="wp-block-button__link fit-content">キャラクターを寄贈する</a></div>
				</div>

			</div>
		</section>

		<section class="section-18 is-style-down-gradient alignfull">

			<div class="container wrap">

				<h2 class="section-header">ドキュメンタリー<br
						class="show-over-1000">の紹介</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-10-col">
						<p>今年、CNCF は 2 本のドキュメンタリー映画の立ち上げを支援しました。このドキュメンタリー映画は、このダイナミックなメディアにおける開発ストーリーを伝えることで、開発者たちの人間味を引き出していくという私たちの使命をサポートするものとなりました。2022 年 1 月、「<a href="https://youtu.be/BE77h7dmoQU">The Origins of Kubernetes （Kubernetes の起源）</a>」として YouTube デビューしました。この 2 部構成のドキュメンタリーは、世界中の視聴者を引きつけ続けていて、合わせて 463,000 回の再生回数を獲得しました。</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="wp-block-lf-youtube-lite">
					<lite-youtube videoid="BE77h7dmoQU"
						videotitle="Kubernetes The Documentary" webpstatus="1"
						sdthumbstatus="0"
						title="Kubernetes The Documentary を再生する">
					</lite-youtube>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>「<a href="https://youtu.be/rT4fJNbfe14">Inside Prometheus</a> 」は、2022 年 10 月の Prometheus Day North America で KubeCon + CloudNativeCon NA の一部としてデビューし、これまで YouTube で 59,000 回の再生回数を獲得しました。どちらの映画も、私たちの働き方や今日の生活を変えようと逆境や技術的課題に立ち向かった先見の明のあるエンジニアたちの生の声や顔を捉えることに成功しています。</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="wp-block-lf-youtube-lite">
					<lite-youtube videoid="rT4fJNbfe14"
						videotitle="Inside Prometheus" webpstatus="1"
						sdthumbstatus="0" title="Inside Prometheus を再生する">
					</lite-youtube>
				</div>
			</div>
		</section>


		<section id="community"
			class="section-19 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">コミュニティと多様性<br
							class="show-over-1000">へのエンゲージメント</h2>
					<div class="section-number">5/6</div>
				</div>

				<div class="lf-grid">
					<p
						class="opening-paragraph restrictive-10-col">CNCFのコミュニティは、コントリビューター、メンバー、Meetup やアンバサダーといったさまざまな形で世界中に広がっています。</p>
				</div>

				<div class="lf-grid">
					<p
						class="restrictive-9-col">2022 年、私たちはコミュニティ主導でのイニシアティブに投資し、持続する勢い、広がり、成長、そして活用にさらに燃料を注いでいくべく、#TeamCloudNativeへのコミットメントを強化しました。このエコシステムが誰でも成長できるような、人を受け入れ親しみやすい場所になるように DEI イニシアティブへ焦点を当てつづけていることは重要な意味をもちます。</p>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="sub-header">多様性、公平性、包摂性（Diversity, Equity, and Inclusivity）</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<p
						class="restrictive-9-col">CNCF は、この驚異的なクラウドネイティブコミュニティの発展を引き続き支援するとともに、参加するみなさんすべてが、性別、ジェンダーアイデンティティ、性的指向、障がい、人種、民族、年齢、宗教、経済的地位にかかわらず、受け入れられていると感じられるように努めています。今日まで、私たちは Dan Kohn Scholarship Fund を通じ、<strong>ダイバーシティ奨学金とニーズベース奨学金を5,000 以上提供してきました</strong>。</p>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<p
					class="sub-header">女性、ジェンダーノンコーフィミングなスピーカーたち</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-19__dei">
					<div class="section-19__dei-col1">
						<div class="icon-box-3">
							<div class="icon"><img loading="lazy" width="95" height="61" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-female-non-binary.svg" alt="Female and Non Binary person icon"></div>
							<div class="text"><span class="number">48%</span><br /> <span class="description">のキーノート</span> <span class="addendum"> <a href="https://events.linuxfoundation.org/archive/2022/kubecon-cloudnativecon-europe/">KubeCon + CloudNativeCon Europe</a> </span></div>
						</div>

					</div>
					<div class="section-19__dei-col2">
						<div class="icon-box-3">
							<div class="icon"><img loading="lazy" width="95" height="61" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-female-non-binary.svg" alt="Female and Non Binary person icon"></div>
							<div class="text"><span class="number">44%</span><br /> <span class="description">のキーノート</span> <span class="addendum"> <a href="https://events.linuxfoundation.org/kubecon-cloudnativecon-north-america/">KubeCon + CloudNativeCon North America</a></span></div>
						</div>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="section-header">提供される奨学金</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<p class="sub-header">私たちは以下の人たちに奨学金を提供しました</p>

				<div aria-hidden="true" class="report-spacer-60"></div>


				<div class="lf-grid section-19__dei">
					<div class="section-19__dei-col1">
						<div class="icon-box-3">
							<div class="text"><span class="number">749</span><br /> <span class="description">人のダイバーシティ応募者たち</span><span class="addendum"> 歴史的に少数派かつ/もしくは疎外されたグループから</span></div>
						</div>

					</div>
					<div class="section-19__dei-col2">
						<div class="icon-box-3">
							<div class="text"><span class="number">726</span><br /> <span class="description">人のニーズベース応募者たち</span> <span class="addendum"> がKubeCon + CloudNativeCons および CNCF が主催する併催イベントに参加</span></div>
						</div>
					</div>
				</div>
				<div aria-hidden="true" class="report-spacer-100"></div>

				<p
					class="sub-header">奨学金は以下のスポンサーからファンドされました</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="logo-grid smallest">

					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-apple.svg" alt="Logo for Apple" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-apptio.svg" alt="Logo for Apptio" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-cncf.svg" alt="Logo for CNCF" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-doppler.svg" alt="Logo for Doppler" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-finops-foundation.svg" alt="Logo for Fin Ops Foundation" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-form3.svg" alt="Logo for Form 3" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-golden-solutions.svg" alt="Logo for Golden Solutions" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-grafana-labs.svg" alt="Logo for Grafana Labs" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-isovalent.svg" alt="Logo for Isovalent" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-section.svg" alt="Logo for Section" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-shopify.svg" alt="Logo for Shopify" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-styra.svg" alt="Logo for Styra" class="logo-grid__image"></div>
					<div class="logo-grid__box"><img loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-vmware.svg" alt="Logo for VM Ware" class="logo-grid__image"></div>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="section-header">コミュニティアワード</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-10-col">
						<p>今年で6年目を迎えた <a href="https://www.cncf.io/announcements/2020/11/20/cloud-native-computing-foundation-announces-2020-community-awards-winners/">CNCF コミュニティアワード</a> では、すべての CNCF プロジェクトで最も活動的なアンバサダーとトップコントリビューターが選ばれました。以下を含めたアワードが授与されました。</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid section-19__ca">
					<div class="section-19__ca-col1"><img loading="lazy" width="64" height="66" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-first-place.svg" alt="First place icon"><div aria-hidden="true" class="report-spacer-40"></div>

						<p class="sub-header">トップ Cloud Native コミッター</p>

						<div aria-hidden="true" class="report-spacer-20"></div>

						<p>一つもしくはそれ以上の CNCF プロジェクトにおいて、驚くべき技術スキルを持ち著しい技術的成果を上げた個人に対して授与されます。</p>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<div class="section-19__person"><img width="600" height="600" loading="lazy" class="section-19__person-image" src="https://www.cncf.io/wp-content/uploads/2022/12/qQuFPg2W_400x400.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/qQuFPg2W_400x400.jpg 600w, https://www.cncf.io/wp-content/uploads/2022/12/qQuFPg2W_400x400-300x300.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/12/qQuFPg2W_400x400-150x150.jpg 150w, https://www.cncf.io/wp-content/uploads/2022/12/qQuFPg2W_400x400-200x200.jpg 200w, https://www.cncf.io/wp-content/uploads/2022/12/qQuFPg2W_400x400-400x400.jpg 400w" sizes="(max-width: 175px) 100vw, 175px" alt="Carolyn Van Slyck"><p class="section-19__person-text-wrapper"><span class="section-19__person-name">Carolyn Van Slyck</span> <span
							class="section-19__person-title"><a href="https://www.twitter.com/carolynvs">@carolynvs</a></span></p>
						</div>

					</div>
					<div class="section-19__ca-col2"><img loading="lazy" width="54" height="64" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-doc-check.svg" alt="Document with check icon"><div aria-hidden="true" class="report-spacer-40"></div>

						<p class="sub-header">トップ ドキュメンタリアン</p>

						<div aria-hidden="true" class="report-spacer-20"></div>

						<p>このアワードは、CNCFやそのプロジェクトに対する卓越した文書化への貢献を称するものです。</p>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<div class="section-19__person-align">

							<div class="section-19__person"><img width="600" height="600" loading="lazy" class="section-19__person-image" src="https://www.cncf.io/wp-content/uploads/2022/12/uxf8JIRG_400x400.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/uxf8JIRG_400x400.jpg 600w, https://www.cncf.io/wp-content/uploads/2022/12/uxf8JIRG_400x400-300x300.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/12/uxf8JIRG_400x400-150x150.jpg 150w, https://www.cncf.io/wp-content/uploads/2022/12/uxf8JIRG_400x400-200x200.jpg 200w, https://www.cncf.io/wp-content/uploads/2022/12/uxf8JIRG_400x400-400x400.jpg 400w" sizes="(max-width: 175px) 100vw, 175px" alt="Catherine Paganini"><p class="section-19__person-text-wrapper"><span class="section-19__person-name">Catherine Paganini</span> <span
							class="section-19__person-title"><a href="https://www.twitter.com/CathPaga">@CathPaga</a></span></p>
							</div>

							<div class="section-19__person"><img width="600" height="600" loading="lazy" class="section-19__person-image" src="https://www.cncf.io/wp-content/uploads/2022/12/RLs2x1c1_400x400.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/RLs2x1c1_400x400.jpg 600w, https://www.cncf.io/wp-content/uploads/2022/12/RLs2x1c1_400x400-300x300.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/12/RLs2x1c1_400x400-150x150.jpg 150w, https://www.cncf.io/wp-content/uploads/2022/12/RLs2x1c1_400x400-200x200.jpg 200w, https://www.cncf.io/wp-content/uploads/2022/12/RLs2x1c1_400x400-400x400.jpg 400w" sizes="(max-width: 175px) 100vw, 175px" alt="Rey Lejano"><p class="section-19__person-text-wrapper"><span class="section-19__person-name">Rey Lejano</span> <span
							class="section-19__person-title"><a href="https://www.twitter.com/reylejano">@reylejano</a></span></p>
							</div>

						</div>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col"><img loading="lazy" width="73" height="73" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-chop.svg" alt="Axe icon"><div aria-hidden="true" class="report-spacer-40"></div>

						<p class="sub-header">Chop Wood &amp; Carry Water アワード</p>
						<div aria-hidden="true" class="report-spacer-20"></div>

						<p>CNCF は、日常のありふれたタスクに数え切れないほどの時間をかけて貢献してくれているコントリビューターたちを称えるべく「<strong>木を切り、水を運ぶ（Chop Wood and Carry Water）</strong>」アワードを設けています。 CNCF は、2022 年際立ったコントリビューションを行った5人の、その素晴らしい取り組みに対し感謝の意を伝えました。</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="section-19__person-align">

					<div class="section-19__person"><img width="600" height="600" loading="lazy" class="section-19__person-image" src="https://www.cncf.io/wp-content/uploads/2022/12/1537572546697.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/1537572546697.jpg 600w, https://www.cncf.io/wp-content/uploads/2022/12/1537572546697-300x300.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/12/1537572546697-150x150.jpg 150w, https://www.cncf.io/wp-content/uploads/2022/12/1537572546697-200x200.jpg 200w, https://www.cncf.io/wp-content/uploads/2022/12/1537572546697-400x400.jpg 400w" sizes="(max-width: 175px) 100vw, 175px" alt="Adolfo García Veytia"><p class="section-19__person-text-wrapper"><span class="section-19__person-name">Adolfo García Veytia</span> <span
							class="section-19__person-title"><a href="https://www.twitter.com/puerco">@puerco</a></span></p>
					</div>

					<div class="section-19__person"><img width="600" height="600" loading="lazy" class="section-19__person-image" src="https://www.cncf.io/wp-content/uploads/2022/12/DBFZK6cA_400x400.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/DBFZK6cA_400x400.jpg 600w, https://www.cncf.io/wp-content/uploads/2022/12/DBFZK6cA_400x400-300x300.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/12/DBFZK6cA_400x400-150x150.jpg 150w, https://www.cncf.io/wp-content/uploads/2022/12/DBFZK6cA_400x400-200x200.jpg 200w, https://www.cncf.io/wp-content/uploads/2022/12/DBFZK6cA_400x400-400x400.jpg 400w" sizes="(max-width: 175px) 100vw, 175px" alt="Alex Chircop"><p class="section-19__person-text-wrapper"><span class="section-19__person-name">Alex Chircop</span> <span
							class="section-19__person-title"><a href="https://www.twitter.com/chira001">@chira001</a></span></p>
					</div>

					<div class="section-19__person"><img width="600" height="600" loading="lazy" class="section-19__person-image" src="https://www.cncf.io/wp-content/uploads/2022/12/uxf8JIRG_400x400.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/uxf8JIRG_400x400.jpg 600w, https://www.cncf.io/wp-content/uploads/2022/12/uxf8JIRG_400x400-300x300.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/12/uxf8JIRG_400x400-150x150.jpg 150w, https://www.cncf.io/wp-content/uploads/2022/12/uxf8JIRG_400x400-200x200.jpg 200w, https://www.cncf.io/wp-content/uploads/2022/12/uxf8JIRG_400x400-400x400.jpg 400w" sizes="(max-width: 175px) 100vw, 175px" alt="Catherine Paganini"><p class="section-19__person-text-wrapper"><span class="section-19__person-name">Catherine Paganini</span> <span
							class="section-19__person-title"><a href="https://www.twitter.com/CathPaga">@CathPaga</a></span></p>
					</div>

					<div class="section-19__person"><img width="600" height="600" loading="lazy" class="section-19__person-image" src="https://www.cncf.io/wp-content/uploads/2022/12/1517746405737.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/1517746405737.jpg 600w, https://www.cncf.io/wp-content/uploads/2022/12/1517746405737-300x300.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/12/1517746405737-150x150.jpg 150w, https://www.cncf.io/wp-content/uploads/2022/12/1517746405737-200x200.jpg 200w, https://www.cncf.io/wp-content/uploads/2022/12/1517746405737-400x400.jpg 400w" sizes="(max-width: 175px) 100vw, 175px" alt="Patrick Ohly"><p class="section-19__person-text-wrapper"><span class="section-19__person-name">Patrick Ohly</span></p>
					</div>

					<div class="section-19__person"><img width="600" height="600" loading="lazy" class="section-19__person-image" src="https://www.cncf.io/wp-content/uploads/2022/12/R2pfO3bA_400x400.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/R2pfO3bA_400x400.jpg 600w, https://www.cncf.io/wp-content/uploads/2022/12/R2pfO3bA_400x400-300x300.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/12/R2pfO3bA_400x400-150x150.jpg 150w, https://www.cncf.io/wp-content/uploads/2022/12/R2pfO3bA_400x400-200x200.jpg 200w, https://www.cncf.io/wp-content/uploads/2022/12/R2pfO3bA_400x400-400x400.jpg 400w" sizes="(max-width: 175px) 100vw, 175px" alt="Xing Yang"><p class="section-19__person-text-wrapper"><span class="section-19__person-name">Xing Yang</span> <span
							class="section-19__person-title"><a href="https://www.twitter.com/2000xyang">@2000xyang</a></span></p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="section-header">CNCF Meetupが<br
						class="show-over-1000">Community Groupに</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>2022 年、クラウドネイティブコミュニティは Meetup のプラットフォームから <a href="https://community.cncf.io/">Cloud Native Community Groups</a> に移行し、新たなプラットフォームとして離陸しました。新たなプラットフォームは、Meetup、オンラインプログラム、プロジェクトによる「Office hours」、コミュニティ イベントなどが行われる唯一の場となっています。私たちは、現在 31,500 人以上のメンバーがいるこのプラットフォームの、今後の継続的成長に熱視線を送っています。</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="sub-header">2022 年の Community Groups</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-19__groups">
					<div class="section-19__groups-col1">
						<div class="icon-box-3">
							<div class="icon"><img loading="lazy" width="103" height="57" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-attendees-g.svg" alt="People icon"></div>
							<div class="text"><span class="number">31,500</span><br /> <span class="description">人以上の参加者</span></div>
						</div>
					</div>
					<div class="section-19__groups-col2">
						<div class="icon-box-3">
							<div class="icon"><img loading="lazy" width="62" height="68" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-calendar-g.svg" alt="Calendar icon"></div>
							<div class="text"><span class="number">574</span><br /> <span class="description">のイベント</span></div>
						</div>
					</div>
					<div class="section-19__groups-col3">
						<div class="icon-box-3">
							<div class="icon"><img loading="lazy" width="62" height="62" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/icon-chapters-g.svg" alt="Chapters icon"></div>
							<div class="text"><span class="number">335</span><br /> <span class="description">のチャプター</span></div>
						</div>
					</div>
				</div>

			</div>
		</section>

		<section id="ecosystem"
			class="section-20 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">メンタリング<br
							class="show-over-1000">とエコシステムのリソース</h2>
					<div class="section-number">6/6</div>
				</div>

				<div class="lf-grid">
					<p
						class="opening-paragraph restrictive-10-col">CNCF は 2022 年を通じ、急速に成長するエコシステム ― クラウドネイティブ テクノロジーに対する世界的需要の増大に対応するために大きくなってきている ― をナビゲートし運営するためのプログラムを開発をしながら、個人のコントリビューターやコミュニティグループとの連携を密にしました。</p>
				</div>

				<p class="sub-header">新たなエンドユーザー グループ</p>

				<div aria-hidden="true" class="report-spacer-60"></div><img width="378" height="109" loading="lazy" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/transportation-user-group.png" alt="CNCF Transportation User Group logo"><div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<p class="restrictive-9-col">CNCF Transportation User Group の目的は、輸送および物流を担う組織におけるクラウド ネイティブの議論や進化のための中心的ミーティング ポイントとして機能することにあります。これには、従来型の慣行をリストアップし、ギャップを明確にしワークフローを改善するための取り組みへと方向づけることが含まれます。</p>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="section-header">CNCF Glossary（用語集）</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p><a href="https://glossary.cncf.io/">Cloud Native Glossary</a> は、CNCF Business Value Subcommittee が主導するプロジェクトです。その目標は、事前の技術知識を必要とせずに、クラウド ネイティブの概念を明確で簡単な言葉で説明することです。</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<p
					class="sub-header">今年、新たに7言語の CNCF Glossary 翻訳版が寄贈されました</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<picture>
					<source media="(max-width: 499px)" srcset="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/glossary-banner-mobile.png">
					<source media="(min-width: 500px)" srcset="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/glossary-banner-desktop.png"><img width="1200" height="200" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/glossary-banner-desktop.png" alt="今年、新たに7言語の CNCF Glossary 翻訳版が寄贈されました" loading="lazy"></picture>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="section-20__banner">
					<p
						class="section-20__banner-text">この用語集はコミュニティ主導の取り組みなので、新しい用語や既存の用語の更新を提案してくれたり、他言語への翻訳を手伝ってくれたりする方はどなたでも歓迎します。</p>
					<div class="wp-block-button"><a href="https://glossary.cncf.io/contribute/"
							title="Glossary へコントリビュートする"
							class="wp-block-button__link fit-content"
							style="white-space: nowrap;">コントリビュートする</a></div>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="section-header">コミュニティ メンタリング</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-10-col">
						<p>CNCF は、さまざまな<a href="https://github.com/cncf/mentoring">メンタリング、インターンシップの機会</a>を通じた支援をしています。手前味噌ではありますが、<a href="https://lfx.linuxfoundation.org/tools/mentorship">LFX メンターシップ プラットフォーム</a>、<a href="https://summerofcode.withgoogle.com/">Google Summer of Code (GSoC)</a>、<a href="https://developers.google.com/season-of-docs">Google Summer of Docs (GSoD) プログラム</a>、<a href="https://www.outreachy.org/">Outreachy</a> など、さまざまなメンタリングやインターンシップの機会を通じて、2022 年には 100 人以上の個人に支援を提供することができました。これらのプログラムは、私たちが依存するであろう将来のテクノロジーに対しインターンシップに影響力を与える、重要な触媒なのです。<br><br>8 月、TAG Contributor Strategy は Mentoring Working Group を承認しました。 このワーキング グループの主な目標は、CNCF メンターシップ イニシアチブをコミュニティに管理してもらうこと、そうすることで、新たなメンターシップ プログラムの成長や新たなプログラム開発に必要な能力を供給する支援をすることです。</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p
					class="sub-header">28 の CNCF プロジェクトに取り組めるよう 106 人の学生のスポンサーとなりました。</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-20__mentoring">

					<div class="section-20__mentoring-col1">
						<p class="section-20__mentoring-number">86 人</p><img loading="lazy" width="274" height="41" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-lfx-mentorship.svg" alt="Logo of LFX Mentorship"></div>
					<div class="section-20__mentoring-col2">
						<p class="section-20__mentoring-number">3 人</p><img loading="lazy" width="280" height="72" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-gsod.png" alt="Logo of Google Season of Docs"></div>
					<div class="section-20__mentoring-col3">
						<p class="section-20__mentoring-number">16 人</p><img loading="lazy" width="287" height="80" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-gsoc.svg" alt="Logo of Google Summer of Code"></div>
					<div class="section-20__mentoring-col4">
						<p class="section-20__mentoring-number">1 人</p><img loading="lazy" width="260" height="60" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/logo-outreachy.svg" alt="Logo of Outreachy"></div>

				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="wp-block-button"><a href="https://github.com/cncf/mentoring" title="メンタリングに参加する"
						class="wp-block-button__link fit-content"
						style="white-space: nowrap;">参加する</a></div>

				<div class="shadow-hr"></div>

				<h2 class="section-header">Who we are（私たちについて）</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>内部では、<a href="https://www.cncf.io/people/staff/" title="CNCFスタッフについて見る">さまざまなバックグラウンド、ロケーションから 41 人を雇用しています</a>。61% が女性で 39% が男性です。Governing Board と Technical Oversight Committee で構成される CNCF のガバナンス リーダーシップについては女性 20%、男性 80%となっています。</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid section-20__staff">
					<div class="section-20__staff-col1">
						<p class="sub-header">スタッフ</p>

						<div aria-hidden="true" class="report-spacer-60"></div><img loading="lazy" width="585" height="585" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/staff-chart.svg" alt="エグゼクティブ リーダーシップのチャート - 61% が女性、39% の男性"></div>
					<div class="section-20__staff-col2">

						<p class="sub-header">ガバナンス リーダーシップ</p>

						<div aria-hidden="true" class="report-spacer-40"></div><img loading="lazy" width="389" height="214" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/governance-chart.svg" alt="女性 20%、男性 80% を示すガバナンス リーダーシップのチャート"><div aria-hidden="true" class="report-spacer-80"></div>

						<p class="sub-header">エグゼクティブ リーダーシップ</p>

						<div aria-hidden="true" class="report-spacer-40"></div><img loading="lazy" width="389" height="214" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/executive-leadership-chart.svg" alt="エグゼクティブ リーダーシップのチャート - 62.5% が女性、37.5% が男性"></div>
				</div>
			</div>
		</section>

		<section class="section-21 is-style-down-gradient alignfull">

			<div class="container wrap">

				<h2 class="section-header">ファンディング</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-8-col">
						<p>CNCFの収益は、メンバーシップ、イベントおよびスポンサーシップ、イベント登録、トレーニングの 4 つを主として資金調達をしています。</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="sub-header">4つの資金調達先</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-21__funding">
					<div class="section-21__funding-col1"><img loading="lazy" width="585" height="276" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/funding-1.svg" alt="7.1% トレーニング 26.9% メンバーシップ"></div>
					<div class="section-21__funding-col2"><img loading="lazy" width="585" height="276" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/funding-2.svg" alt="27.9% イベント登録 38% イベント スポンサーシップ"></div>

				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">支出</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="lf-grid section-21__expenses"><img loading="lazy" width="380" height="167" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/expenses-1.svg" alt="6.6% マーケティング、コミュニケーション、ビジネス開発"> <img loading="lazy" width="380" height="167" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/expenses-2.svg" alt="50.5% イベント"> <img loading="lazy" width="380" height="167" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/expenses-3.svg" alt="17.4% 開発者コラボレーションと IT"> <img loading="lazy" width="380" height="167" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/expenses-4.svg" alt="1.9%トレーニングと認定"> <img loading="lazy" width="380" height="167" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/expenses-5.svg" alt="1.2% リーガル"> <img loading="lazy" width="380" height="167" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/expenses-6.svg" alt="10.8％ リーダーシップとコーディネーション"> <img loading="lazy" width="380" height="167" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/expenses-7.svg" alt="1.0% オペレーション"> <img loading="lazy" width="380" height="167" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/expenses-8.svg" alt="5.8% LF の一般管理費"> <img loading="lazy" width="380" height="167" src="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2022/expenses-9.svg" alt="4.8% リザーブ"></div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid">
					<div class="restrictive-8-col">
						<p>CNCF、主催するカンファレンス（<a href="https://www.cncf.io/community/kubecon-cloudnativecon-events/">KubeCon + CloudNativeCon</a> など）、そしてオープンソースの背後には基本的前提にあることは、インタラクションは総じて（「ゼロサム」ではなく）「ポジティブサム」なもの、ということです。投資、マインドシェア、開発へのコントリビューションの数量について固定的に特定のプロジェクトへ割り当てるということはしません。そして同様に重要なことは、プロジェクトとコミュニティに対する「中立な家（Neutral home）」が、この種のポジティブサム思考を育て、オープンソースプロジェクトが成功するためのコアだと私たちが信じる成長と多様性を牽引していく、ということです。</p>
					</div>
				</div>
			</div>
		</section>

		<section class="section-22 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="lf-grid thanks">
					<div class="thanks__col1">
						<h2 class="section-header">ありがとうございました</h2>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<p
							class="thanks__opening">2022 年、みなさんとともに達成したすばらしい成果すべてが、皆さんの脳裏によみがえっていたとしたらうれしくおもいます。</p>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<p
							class="thanks__comments">ご意見・ご感想は <a href="mailto:info@cncf.io">info@cncf.io</a> までお寄せください（英語となります）。</p>

						<div aria-hidden="true" class="report-spacer-80"></div>

						<p>お近くの<a href="https://community.cncf.io" title="コミュニティイベント">コミュニティ イベントのカレンダー</a> をご確認ください。そして2023 年 4 月にアムステルダムで開催される KubeCon + CloudNativeCon Europe に<a href="https://events.linuxfoundation.org/kubecon-cloudnativecon-europe/register/" title="KubeCon+ CloudNativeCon North America に登録する">登録する</a>こともお忘れなく。</p>
					</div>
					<div class="thanks__col2"><img width="902" height="1268" loading="lazy" class="" src="https://www.cncf.io/wp-content/uploads/2022/12/CNCF-Peeps.png" srcset="https://www.cncf.io/wp-content/uploads/2022/12/CNCF-Peeps.png 902w, https://www.cncf.io/wp-content/uploads/2022/12/CNCF-Peeps-213x300.png 213w, https://www.cncf.io/wp-content/uploads/2022/12/CNCF-Peeps-728x1024.png 728w, https://www.cncf.io/wp-content/uploads/2022/12/CNCF-Peeps-768x1080.png 768w, https://www.cncf.io/wp-content/uploads/2022/12/CNCF-Peeps-900x1265.png 900w, https://www.cncf.io/wp-content/uploads/2022/12/CNCF-Peeps-142x200.png 142w, https://www.cncf.io/wp-content/uploads/2022/12/CNCF-Peeps-285x400.png 285w" sizes="(max-width: 450px) 100vw, 450px" alt="CNCF Mascots"></div>
				</div>

				<div class="shadow-hr"></div><a href="https://events.linuxfoundation.org/kubecon-cloudnativecon-europe/register/"
					title="KubeCon+ CloudNativeCon North America に登録する"><picture>
						<source media="(max-width: 499px)"
							srcset="https://www.cncf.io/wp-content/uploads/2022/11/CNCF_Banner-Canvases_02gd_KCCNC-Amsterdam_M_900-x-1100.jpg">
						<source media="(min-width: 500px)"
							srcset="https://www.cncf.io/wp-content/uploads/2022/11/CNCF_Banner-Canvases_02gd_KCCNC-Amsterdam_D_2400-x-840-scaled.jpg"><img width="2560" height="896" loading="lazy" class="" src="https://www.cncf.io/wp-content/uploads/2022/11/CNCF_Banner-Canvases_02gd_KCCNC-Amsterdam_D_2400-x-840-scaled.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/11/CNCF_Banner-Canvases_02gd_KCCNC-Amsterdam_D_2400-x-840-scaled.jpg 2560w, https://www.cncf.io/wp-content/uploads/2022/11/CNCF_Banner-Canvases_02gd_KCCNC-Amsterdam_D_2400-x-840-300x105.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/11/CNCF_Banner-Canvases_02gd_KCCNC-Amsterdam_D_2400-x-840-1024x358.jpg 1024w, https://www.cncf.io/wp-content/uploads/2022/11/CNCF_Banner-Canvases_02gd_KCCNC-Amsterdam_D_2400-x-840-768x269.jpg 768w, https://www.cncf.io/wp-content/uploads/2022/11/CNCF_Banner-Canvases_02gd_KCCNC-Amsterdam_D_2400-x-840-900x315.jpg 900w, https://www.cncf.io/wp-content/uploads/2022/11/CNCF_Banner-Canvases_02gd_KCCNC-Amsterdam_D_2400-x-840-1800x630.jpg 1800w, https://www.cncf.io/wp-content/uploads/2022/11/CNCF_Banner-Canvases_02gd_KCCNC-Amsterdam_D_2400-x-840-571x200.jpg 571w, https://www.cncf.io/wp-content/uploads/2022/11/CNCF_Banner-Canvases_02gd_KCCNC-Amsterdam_D_2400-x-840-1143x400.jpg 1143w" sizes="(max-width: 1200px) 100vw, 1200px" alt="KubeCon+ CloudNativeCon North America に登録する"></picture></a><div class="shadow-hr"></div>

				<div class="social-share">
					<p class="social-share__title">このレポートを共有する</p>

					<div class="social-share__wrapper">
						<!-- linkedin --><a aria-label="Linkedinでシェア"
							title="Linkedinでシェア"
							href="https://www.linkedin.com/shareArticle?mini=true&#038;url=https%3A%2F%2Fwww.cncf.io%2Freports%2Fcncf-annual-report-2022%2F&#038;summary=Read%20the%20CNCF%20Anunal%20Report%202022%20"><svg width="30" height="31"  viewbox="0 0 30 31" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M27.758.456a2.193 2.193 0 0 1 2.204 1.804c.017.11.026.22.026.332v25.705a2.132 2.132 0 0 1-2.033 2.125H2.243c-1.066 0-1.875-.571-2.154-1.537A2.317 2.317 0 0 1 0 28.253V2.632A2.123 2.123 0 0 1 2.135.465C3.16.453 23.5.472 27.758.455zM15.992 13.62v-1.624c0-.248-.06-.342-.328-.337-1.226.014-2.451.014-3.675 0-.293 0-.361.091-.359.368V25.69c0 .279.07.377.36.372 1.274-.012 2.546-.012 3.817 0 .284 0 .363-.082.361-.367-.01-2.292-.01-4.583 0-6.874-.002-.476.037-.951.117-1.42.171-.968.614-1.755 1.64-2.012.328-.072.663-.103.998-.092 1.033.014 1.713.513 1.945 1.518.128.592.193 1.196.192 1.802.02 2.357.012 4.714 0 7.07 0 .272.07.38.36.375 1.272-.012 2.544-.012 3.817 0 .272 0 .35-.084.347-.354v-7.602a13.258 13.258 0 0 0-.29-3.088c-.326-1.384-.966-2.565-2.33-3.177a6.232 6.232 0 0 0-4.216-.35c-1.16.306-2.053 1.03-2.756 2.129zm-7.075 5.217v-6.843c0-.253-.07-.338-.333-.335-1.288.012-2.578.012-3.87 0-.253 0-.335.065-.333.328V25.73c0 .274.101.33.343.33H8.54c.372 0 .375 0 .375-.375l.002-6.848zm-2.26-9.095A2.603 2.603 0 1 0 4.05 7.165a2.577 2.577 0 0 0 2.605 2.577z" fill="currentColor"/></svg></a> <!-- twitter --> <a aria-label="Twitterでシェア"
							title="Twitterでシェア"
							href="https://twitter.com/intent/tweet?text=Read%20the%20CNCF%20Anunal%20Report%202022%20&#038;url=https%3A%2F%2Fwww.cncf.io%2Freports%2Fcncf-annual-report-2022%2F&#038;hashtags=cncf&#038;via=CloudNativeFDN"><svg width="38" height="31" viewbox="0 0 38 31" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M37.023 3.988a15.184 15.184 0 0 1-4.364 1.192A7.586 7.586 0 0 0 35.992.99c-1.49.886-3.121 1.51-4.823 1.845a7.627 7.627 0 0 0-9.124-1.484 7.59 7.59 0 0 0-3.336 3.55 7.556 7.556 0 0 0-.484 4.84 21.629 21.629 0 0 1-8.67-2.303 21.559 21.559 0 0 1-6.98-5.621 7.561 7.561 0 0 0-.828 5.515 7.583 7.583 0 0 0 3.18 4.588 7.586 7.586 0 0 1-3.448-.942v.096a7.56 7.56 0 0 0 1.724 4.799 7.606 7.606 0 0 0 4.385 2.623 7.66 7.66 0 0 1-3.43.131 7.577 7.577 0 0 0 2.702 3.763 7.617 7.617 0 0 0 4.394 1.494 15.27 15.27 0 0 1-9.442 3.242c-.605 0-1.21-.036-1.812-.107a21.542 21.542 0 0 0 11.644 3.402c13.972 0 21.611-11.535 21.611-21.541 0-.329 0-.655-.02-.98a15.4 15.4 0 0 0 3.788-3.913z" fill="currentColor"/></svg></a> <!-- sendto email --> <a aria-label="メールでシェア" title="メールでシェア"
							href="mailto:?subject=Read%20the%20CNCF%20Anunal%20Report%202022%20&#038;body=Read%20the%20CNCF%20Anunal%20Report%202022%20&nbsp;https%3A%2F%2Fwww.cncf.io%2Freports%2Fcncf-annual-report-2022%2F"><svg width="37" height="31" viewbox="0 0 37 31" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.332 2.098H31.99c1.833 0 3.332 1.5 3.332 3.332v19.993c0 1.833-1.5 3.332-3.332 3.332H5.332A3.342 3.342 0 0 1 2 25.423V5.43c0-1.833 1.5-3.332 3.332-3.332z" stroke="currentColor" stroke-width="3.332" stroke-linecap="round" stroke-linejoin="round"/><path d="M35.322 5.43l-16.66 11.662L2 5.43" stroke="currentColor" stroke-width="3.332" stroke-linecap="round" stroke-linejoin="round"/></svg></a></div>
				</div>

			</div>
		</section>
	</article>
</main>
<?php

// youtube lite script.
wp_enqueue_script(
	'youtube-lite-js',
	home_url() . '/wp-content/mu-plugins/wp-mu-plugins/lf-blocks/src/youtube-lite/scripts/lite-youtube.js',
	null,
	filemtime( WPMU_PLUGIN_DIR . '/wp-mu-plugins/lf-blocks/dist/blocks.build.js' ),
	true
);

// load slick css.
wp_enqueue_style( 'slick-css', get_template_directory_uri() . '/build/slick.min.css', array(), filemtime( get_template_directory() . '/build/slick.min.css' ), 'all' );

// load main slick.
wp_enqueue_script( 'slick', get_template_directory_uri() . '/source/js/libraries/slick.min.js', array( 'jquery' ), filemtime( get_template_directory() . '/source/js/libraries/slick.min.js' ), true );

// custom scripts.
wp_enqueue_script(
	'annual-report-22',
	get_template_directory_uri() . '/source/js/on-demand/annual-report-22.js',
	array( 'jquery', 'slick' ),
	filemtime( get_template_directory() . '/source/js/on-demand/annual-report-22.js' ),
	true
);

get_template_part( 'components/footer' );
