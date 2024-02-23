<?php
/**
 * Template Name: Annual Report 2023 JP
 * Template Post Type: lf_report
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

// Report folder in images/ folder.
$report_folder = 'annual-reports/2023/';

get_template_part( 'components/header' );

get_template_part( 'components/skip-link-target' );

wp_enqueue_style( 'ar-2023', get_template_directory_uri() . '/build/annual-report-2023.min.css', array(), filemtime( get_template_directory() . '/build/annual-report-2023.min.css' ), 'all' );

wp_enqueue_style( 'wp-block-group' );
wp_enqueue_style( 'wp-block-column' );
wp_enqueue_style( 'wp-block-columns' );

// setup social share icons + data.
$caption      = 'Read the CNCF Anunal Report 2023 ';
$page_url     = rawurlencode( get_permalink() );
$caption      = htmlspecialchars( rawurlencode( html_entity_decode( $caption, ENT_COMPAT, 'UTF-8' ) ), ENT_COMPAT, 'UTF-8' );
$options      = get_option( 'lf-mu' );
$twitter      = $options && $options['social_twitter_handle'] ? $options['social_twitter_handle'] : null;
$twitter_url  = 'https://twitter.com/intent/tweet?text=' . $caption . '&amp;url=' . $page_url . '&amp;hashtags=cncf&amp;via=' . $twitter . '';
$linkedin_url = 'https://www.linkedin.com/shareArticle?mini=true&url=' . $page_url . '&summary=' . $caption;
$mailto_url   = 'mailto:?subject=' . $caption . '&body=' . $caption . '&nbsp;' . $page_url;
?>

<link rel="prefetch"
	href="<?php echo esc_url( get_template_directory_uri() . '/build/annual-report-2023.min.css' ); ?>"
	as="style" crossorigin="anonymous" />

<main class="ar-2023">
	<article class="container wrap">

		<section class="hero alignfull">
			<div class="container wrap hero__container">
				<figure class="hero__container-bg-figure">
					<?php
					LF_Utils::display_responsive_images( 99525, 'full', '2400px', 'hero__container-bg-image', 'eager', 'City architecture diagram' );
					?>
				</figure>
				<div class="hero__content">

					<picture>
						<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'hero-mobile.svg', true );
?>
">
						<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'hero-desktop.svg', true );
?>
">
						<img width="632" height="262" src="
<?php
Lf_Utils::get_svg( $report_folder . 'hero-desktop.svg', true );
?>
" alt="CNCF Annual Report 2023 - Architect the Future" loading="eager" decoding="async" class="hero__title">
					</picture>
					<div class="hero__button-share-align">
						<?php
						get_template_part( 'components/social-share' );
						?>
					</div>
					<div class="hero__jump">セクションを移動:</div>
				</div>
			</div>
		</section>
		<section>
			<!-- Navigation  -->
			<div class="nav-el">
				<div class="nav-el__box">
					<a href="#momentum" title="Jump to Momentum section"
						class="box-link"></a>
					<img loading="lazy" decoding="async" width="36" height="36" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-upward-chart.svg', true ); ?>
" alt="Upward trend chart icon">活動
				</div>

				<div class="nav-el__box">
					<a href="#events" title="Jump to Events section"
						class="box-link"></a>
					<img loading="lazy" decoding="async" width="36" height="36" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-lanyard.svg', true ); ?>
" alt="Lanyard icon">イベント
				</div>

				<div class="nav-el__box">
					<a href="#training" title="Jump to Training section"
						class="box-link"></a>
					<img loading="lazy" decoding="async" width="36" height="36" src="
<?php
LF_Utils::get_svg( $report_folder . 'icon-teacher.svg', true );
?>
" alt="Teacher icon">トレーニング
				</div>

				<div class="nav-el__box">
					<a href="#projects" title="Jump to Projects section"
						class="box-link"></a>
					<img loading="lazy" decoding="async" width="36" height="36" src="
<?php
LF_Utils::get_svg( $report_folder . 'icon-shape.svg', true );
?>
" alt="chart icon">プロジェクト
				</div>

				<div class="nav-el__box">
					<a href="#community" title="Jump to Community section"
						class="box-link"></a>
					<img loading="lazy" decoding="async" width="36" height="36" src="
<?php
LF_Utils::get_svg( $report_folder . 'icon-relationship.svg', true );
?>
" alt="Relationship icon">コミュニティ
				</div>

				<div class="nav-el__box">
					<a href="#ecosystem" title="Jump to Ecosystem section"
						class="box-link"></a>
					<img loading="lazy" decoding="async" width="36" height="36" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-ecosystem.svg', true ); ?>
" alt="Ecosystem icon">エコシステム
				</div>
			</div>
		</section>
		<section class="section-01">
			<h2 class="section-01__title">ようこそ！ 思い出に残る<br class="show-over-1000">一年でした。</h2>

			<div class="lf-grid section-01__grid">
				<div class="section-01__grid-col1">

					<p><strong>今年はクラウド ネイティブにとって大きな変革をもたらした年でした。 6年前にベルリンで行われたKubeCon + CloudNativeConで、OpenAIが<a href="https://www.youtube.com/watch?v=v4N3Krzb8Eg">AIの未来を推進するインフラストラクチャの構築-その未来が今</a>というタイトルで講演しました。現在、クラウド ネイティブはAIの動作を支えるインフラストラクチャを提供しています。そのため、私にとって<a href="https://www.youtube.com/watch?v=NcLAVtQ5H4A">北米で開かれたKubeCon + CloudNativeConの基調講演</a>でAdobeの Joseph Sandoval氏がパネルディスカッションを進行し、クラウド ネイティブがAIの急速な成長をどのようにサポートできるか、そしてより持続可能で安全なエコ システムを開発しながらどのように実現できるかについての議論は、特に刺激的なものでした。</strong></p>

					<p>Adobeが示すように、クラウド ネイティブの動きにとってエンドユーザーは極めて重要です。これが、CNCFがエンドユーザー テクニカル アドバイザリ ボード(Technical Advisory Board:TAB)を立ち上げた理由です。これは、CNCFプロジェクトの採用と運用化の道筋を明らかにするのに役立ちます。TABは、リファレンス アーキテクチャの開発と承認、およびエンドユーザーのワークフロー パターンの紹介を通じて、重要であるそれらの明確さと導入のガイドを提供します。これらの取り組みは、現在のユースケースをサポートし、クラウド ネイティブ テクノロジーの状況の変化に合わせて進化する、活発で繁栄したエコシステムの基礎を築きます。
					</p>

					<p>CNCFのテクニカル アドバイザリ ボードは、プラットフォーム エンジニアリングが成熟していく過程から持続可能な状態となるまで、影響力のあるクラウド ネイティブ イニシアチブの進化を推進し続けました。 サステナビリティに関しては、第1回Cloud Native Sustainability Weekでは、世界中から#TeamCloudNativeが集まったのは驚きでした。<a href="https://tag-env-sustainability.cncf.io/">TAG Environmental Sustainability</a>の熱心な取り組みに敬意を表します。</p>
					
					<p>#TeamCloudNativeの皆様、今年も素晴らしい一年を迎えられることお祈りしております。2024 年に何を達成できるか楽しみです。</p>

					<div class="section-01__author">
						<img width="210" height="210" loading="lazy" class="" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/priyanka-sharma.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/priyanka-sharma.jpg 210w, https://www.cncf.io/wp-content/uploads/2022/12/priyanka-sharma-150x150.jpg 150w, https://www.cncf.io/wp-content/uploads/2022/12/priyanka-sharma-200x200.jpg 200w" sizes="(max-width: 75px) 100vw, 75px" alt="Priyanka Sharma">						<p><strong>Priyanka Sharma</strong><br>
Executive Director, CNCF</p>
					</div>
				</div>

				<div class="section-01__grid-col2">

					<!-- Icon 1  -->
					<div class="icon-box-1">
						<div class="icon">
							<img loading="lazy" decoding="async" width="71" height="74" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/icon-projects.svg" alt="Projects icon">
						</div>
						<div class="text">
							<span>173 プロジェクト</span><br>
							世界的な変革の<br>推進する
						</div>
					</div>

					<!-- Icon 2  -->
					<div class="icon-box-1">
						<div class="icon">
							<img loading="lazy" decoding="async" width="74" height="43" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/icon-members.svg" alt="Members icon">
						</div>
						<div class="text">
							<span>827 人のメンバー</span><br>
							世界中6大陸から
						</div>
					</div>

					<!-- Icon 3  -->
					<div class="icon-box-1">
						<div class="icon">
							<img loading="lazy" decoding="async" width="60" height="57" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/icon-chapter.svg" alt="Chapter icon">
						</div>
						<div class="text">
							<span>220K+ 人のコントリビューター</span><br>
							抜本的なコンピューティングを<br>変革する
						</div>
					</div>

				</div>
			</div>
		</section>

		<!-- Tweet -->
		<section class="section-tweet">
			<a href="https://twitter.com/furrier/status/1722279020765872363?s=20">
			<picture>
				<source media="(max-width: 499px)" srcset="https://www.cncf.io/wp-content/uploads/2024/01/Screenshot-2024-01-09-at-6.33.48 PM.jpg">
				<source media="(min-width: 500px)" srcset="https://www.cncf.io/wp-content/uploads/2023/12/tweet1.jpg">
				<img width="2332" height="646" loading="lazy" class="" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/tweet1.jpg" srcset="https://www.cncf.io/wp-content/uploads/2023/12/tweet1.jpg 2332w, https://www.cncf.io/wp-content/uploads/2023/12/tweet1-300x83.jpg 300w, https://www.cncf.io/wp-content/uploads/2023/12/tweet1-1024x284.jpg 1024w, https://www.cncf.io/wp-content/uploads/2023/12/tweet1-768x213.jpg 768w, https://www.cncf.io/wp-content/uploads/2023/12/tweet1-900x249.jpg 900w, https://www.cncf.io/wp-content/uploads/2023/12/tweet1-1800x499.jpg 1800w, https://www.cncf.io/wp-content/uploads/2023/12/tweet1-600x166.jpg 600w, https://www.cncf.io/wp-content/uploads/2023/12/tweet1-1200x332.jpg 1200w" sizes="(max-width: 1200px) 100vw, 1200px" alt="Tweet screenshot">			</picture>
			</a>
		</section>


		<!-- Photo Highlights  -->
		<section class="section-02">

			<div class="wp-block-group is-style-no-padding is-style-see-all">
				<div class="wp-block-columns are-vertically-aligned-centered">
					<div class="wp-block-column is-vertically-aligned-centered" style="flex-basis:80%">
						<h3 class="sub-header">2023年 ハイライト写真</h3>
					</div>
					<div class="wp-block-column is-vertically-aligned-bottom" style="flex-basis:20%">
						<p class="has-text-align-right is-style-link-cta"><a href="https://www.flickr.com/photos/143247548@N03/albums/with/72177720303164393" title="View the CNCF Flickr photo feed">続きを見る</a></p>
					</div>
				</div>
				<div class="section-02__slider">
					<div>
						<?php LF_Utils::display_responsive_images( 99515, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 99516, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon North America 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 99517, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 99518, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 99519, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon North America 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 99520, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon North America 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 99521, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon North America 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 99522, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon North America 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 99523, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon North America 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 99524, 'newsroom-post-width', '700px', null, 'lazy', 'Photo from KubeCon + CloudNativeCon North America 2023' ); ?>
					</div>

				</div>
				<div class="section-02__controls">
					<button class="button-reset  section-02__prev"><svg
							width="12" height="19" viewBox="0 0 12 19"
							fill="none" xmlns="http://www.w3.org/2000/svg">
							<path
								d="M10.4131 17.627L2.41309 9.62695L10.4131 1.62695"
								stroke="black" stroke-width="3" />
						</svg>
						<span class="screen-reader-text">Previous
							Photo</span>
					</button>
					<button class="button-reset section-02__next"><svg
							width="12" height="19" viewBox="0 0 12 19"
							fill="none" xmlns="http://www.w3.org/2000/svg">
							<path
								d="M1.41309 1.62695L9.41309 9.62695L1.41309 17.627"
								stroke="black" stroke-width="3" />
						</svg>
						<span class="screen-reader-text">Next Photo</span>
					</button>
				</div>
			</div>
		</section>

		<section id="momentum" class="section-03 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">2023年<br>
						活動</h2>
					<div class="section-number">1/6</div>
				</div>

				<div class="lf-grid">
					<p class="opening-paragraph restrictive-10-col">CNCFは、クラウド ネイティブ コンピューティングのユビキタス化に特化したオープン ソース ソフトウェアの団体です。2015年の設立以来、<strong>クラウド ネイティブ テクノロジー</strong>の先駆者として、Kubernetes、Prometheus、Envoy、ContainerDなど、<a href="https://www.cncf.io/projects/">その他数多く</a>の、世界で<a href="https://docs.google.com/presentation/d/1UGewu4MMYZobunfKr5sOGXsspcLOH_5XeCLyOHKh9LU/edit#slide=id.g39c264972c_182_212">最も成功を収めている</a>オープンソース プロジェクトをホストし、成長させてきました。</p>
				</div>

				<div class="lf-grid">
					<div class="restrictive-10-col">
						<p>現在、私たちは将来有望なプロジェクトと人々を排出する団体となっており、<strong>190か国</strong>を代表する<strong>22万人以上のコントリビューター</strong>によって推進されている<strong>173のプロジェクト</strong>をホストしており、この勢いが衰える兆しはありません。
						</p>
					</div>
				</div>
				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid section-03__intro">
					<div class="section-03__intro-col1">
						<p class="sub-header">コントリビューターの増加</p>

						<div aria-hidden="true" class="report-spacer-40"></div>

						<img loading="lazy" decoding="async" width="561" height="400" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/contributors-chart.svg" alt="Chart showing upward trend of Contributors growth">

					</div>
					<div class="section-03__intro-col2">
						<p class="sub-header">メンバー、エンドユーザー &amp; プロジェクトの増加</p>
						<div aria-hidden="true" class="report-spacer-40"></div>

						<img loading="lazy" decoding="async" width="550" height="400" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/member-end-user-project-growth.svg" alt="Chart showing upward trend of Members, End User and Project growth">

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
						<p>CNCFは、世界最大のパブリックおよびプライベート クラウド企業に加え、革新的なソフトウェア企業やエンドユーザー組織を含む<strong>827の参加組織</strong>によってサポートされています。業界における合併や買収が2022年と比較して平均27.4％減少するなど、市場が低迷しているにもかかわらず、CNCFは一貫して新たな投資を呼び込むだけでなく、業界の主要なプレーヤーとの長期的な関係を維持し続けています。これらの業界を牽引する組織からの投資は、今後何年にもわたってクラウド ネイティブ コンピューティングの進歩と持続性への強い取り組みを示しています。</p>
					</div>
					<div class="section-04__membership-col2">

						<img loading="lazy" decoding="async" width="452" height="227" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/new_members.svg" alt="Members icon">

					</div>
				</div>

			</div>
		</section>

		<section class="section-06">

			<div class="lf-grid section-06__members">
				<div class="section-06__members-col1">
					<p class="sub-header">新たなゴールドメンバー</p>
					<div aria-hidden="true" class="report-spacer-60"></div>
					<div class="logo-grid smaller">

						<div class="logo-grid__box">
							<img loading="lazy" decoding="async" width="169" height="54" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/daocloud_logo.svg" alt="DaoCloud Logo" class="logo-grid__image">
						</div>

						<div class="logo-grid__box">
							<img loading="lazy" decoding="async" width="77" height="77" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/ey_logo_2019.svg" alt="EY Logo" class="logo-grid__image">
						</div>

						<div class="logo-grid__box">
							<img loading="lazy" decoding="async" width="138" height="23" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/hitachi_logo.svg" alt="Hitachi Logo" class="logo-grid__image">
						</div>
					</div>
				</div>
				<div class="section-06__members-col2">
					<p class="sub-header">新たなプラチナメンバー</p>
					<div aria-hidden="true" class="report-spacer-60"></div>

					<div class="logo-grid">

						<div class="logo-grid__box">
							<img loading="lazy" decoding="async" width="133" height="24" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/hcltech-logo.svg" alt="HCLTech Logo" class="logo-grid__image">
						</div>

					</div>

				</div>

			</div>

			<div aria-hidden="true" class="report-spacer-100"></div>
			<a href="https://www.cncf.io/about/join/">
			<img width="2420" height="620" loading="lazy" class="" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/award-banner-desktop-1.jpg" srcset="https://www.cncf.io/wp-content/uploads/2023/12/award-banner-desktop-1.jpg 2420w, https://www.cncf.io/wp-content/uploads/2023/12/award-banner-desktop-1-300x77.jpg 300w, https://www.cncf.io/wp-content/uploads/2023/12/award-banner-desktop-1-1024x262.jpg 1024w, https://www.cncf.io/wp-content/uploads/2023/12/award-banner-desktop-1-768x197.jpg 768w, https://www.cncf.io/wp-content/uploads/2023/12/award-banner-desktop-1-900x231.jpg 900w, https://www.cncf.io/wp-content/uploads/2023/12/award-banner-desktop-1-1800x461.jpg 1800w, https://www.cncf.io/wp-content/uploads/2023/12/award-banner-desktop-1-600x154.jpg 600w, https://www.cncf.io/wp-content/uploads/2023/12/award-banner-desktop-1-1200x307.jpg 1200w" sizes="(max-width: 1200px) 100vw, 1200px" alt="Join as CNCF Member">			</a>

			<div aria-hidden="true" class="report-spacer-60"></div>

		</section>

		<section class="section-08">

			<h2 class="section-header">エンドユーザー コミュニティ</h2>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="quote-with-name-container">
				<p class="quote-with-name-container__quote">このコミュニティの本質はテクノロジーを採用することだけではありません。継続的な学習、共有、改善の文化を発展させることなのです。クラウド ネイティブのツールやその実践に取り組む情熱が、限界を押し広げ、新しい業界のベンチマークを設定し、CNCFのミッションを進めるのに寄与するのです。コミュニティの積極的な参加を通じて、クラウド ネイティブ コンピューティング ファウンデイションの精神を体現する、活気に満ち、協力的なエコシステムに大きく貢献をすることになります。</p>
				<div class="quote-with-name-container__marks">
					<p class="quote-with-name-container__name">Taylor Dolezal</p>
					<p class="quote-with-name-container__position">Head of Ecosystem, CNCF</p>
				</div>
			</div>

			<div aria-hidden="true" class="report-spacer-80"></div>
			<img width="2400" height="960" loading="lazy" class="" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/photo.jpg" srcset="https://www.cncf.io/wp-content/uploads/2023/12/photo.jpg 2400w, https://www.cncf.io/wp-content/uploads/2023/12/photo-300x120.jpg 300w, https://www.cncf.io/wp-content/uploads/2023/12/photo-1024x410.jpg 1024w, https://www.cncf.io/wp-content/uploads/2023/12/photo-768x307.jpg 768w, https://www.cncf.io/wp-content/uploads/2023/12/photo-900x360.jpg 900w, https://www.cncf.io/wp-content/uploads/2023/12/photo-1800x720.jpg 1800w, https://www.cncf.io/wp-content/uploads/2023/12/photo-500x200.jpg 500w, https://www.cncf.io/wp-content/uploads/2023/12/photo-1000x400.jpg 1000w" sizes="(max-width: 1200px) 100vw, 1200px" alt="Panelists on stage at a conference">			<div aria-hidden="true" class="report-spacer-60"></div>


			<div class="lf-grid">
				<div class="restrictive-9-col">
					<p>CNCFのエンドユーザー コミュニティは、クラウド ネイティブ テクノロジーの限界を常に押し上げる先進的な組織からなる、革新的なグループです。これらの組織は業務の推進にクラウド ネイティブ アーキテクチャを利用していますが、その組織はクラウド ネイティブ サービス業界に限定されません。彼らはベンダー、コンサルタント会社、トレーニング パートナー、通信会社とは異なります。なぜならば、その主な目標がクラウド ネイティブ サービスを外部に販売することではなく、<strong>クラウド ネイティブ アーキテクチャの力を利用して現実世界の問題を解決すること</strong>であるためです。</p>
					<p>エンドユーザー企業内でこうした取り組みを主導しているのは、テクノロジーに精通したクラウド ネイティブの愛好家です。 彼らは、クラウド ネイティブ アーキテクチャによってもたらされる課題と機会に熱意を持って立ち向かい、包括的に繰り返し利用できるプロセスを促進するセルフサービス ソリューションを考案します。このセルフサービスの文化は、チームに力を与え、イノベーションを促進し、柔軟で回復力のある運用に不可欠である、反復的なフィードバック ループを加速します。</p>
				</div>
			</div>


		</section>

		<section class="section-09 alignfull">

			<div class="container wrap">

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="sub-header">エンドユーザー TAB</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-09__cto">
					<div class="section-09__cto-col1">
						<p>2023年の<strong>CNCFエンドユーザー テクニカル アドバイザリ ボード</strong>(Technical Advisory Board:TAB)の設立は、<strong>コラボレーション</strong>の重要性を強調し、ユーザーを、<strong>CNCFエコシステム</strong>の中心に据えた重要なマイルストーンでした。エンドユーザーTABは、エンドユーザー コミュニティをCNCF活動の最前線に置くことで、エンドユーザー コミュニティの声と気づきを広く伝えることを目的としています。このアプローチにより、エンドユーザーのニーズを優先し、素早く応答する、高い包括性を持つ環境が可能になり、その結果、活発で繁栄したエコシステムの構築に役立ちます。</p>
						<p><strong>エンドユーザーTABの主な責任には以下が含まれます。</strong></p>

						<ul>
							<li>プロジェクトの使いやすさ、信頼性、パフォーマンスに関するフィードバックを提供</li>
							<li>公開するクラウド ネイティブ テクノロジのリファレンス アーキテクチャのレビューおよび承認</li>
							<li>エンドユーザーの意見をガバニング ボードやテクニカル オーバーサイト コミッティーに提供する</li>
							<li>CNCFプロジェクトにおけるエンドユーザーの採用に関する可視性を向上する</li>
						</ul>
					</div>
					<div class="section-09__cto-col2">
						<img width="636" height="894" loading="lazy" class="" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/Group-13061.png" srcset="https://www.cncf.io/wp-content/uploads/2023/12/Group-13061.png 636w, https://www.cncf.io/wp-content/uploads/2023/12/Group-13061-213x300.png 213w, https://www.cncf.io/wp-content/uploads/2023/12/Group-13061-142x200.png 142w, https://www.cncf.io/wp-content/uploads/2023/12/Group-13061-285x400.png 285w" sizes="(max-width: 500px) 100vw, 500px" alt="Cartoon characters giving thumbs up">					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div>

			</div>
		</section>

		<section class="section-10">
			<p class="sub-header">ZERO TO MERGE</p>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="lf-grid section-10__cto">
				<div class="section-10__cto-col1">
					<p>2023年に、我々は画期的な<strong>Zero to Merge</strong>プログラムを開始しました。これは、エンドユーザーをCNCFプロジェクトの優れたコントリビューターに変えることを目的とした4週間のコースです。 このプログラムは予想を上回り、<strong>23か国</strong>から<strong>850名を超える登録</strong>が集まり、最終的には<strong>363名の参加者</strong>を受け入れました。最初のミーティングだけで<strong>197名の参加者</strong>があり、クラウド ネイティブ エコシステムに参加したいというコミュニティの熱意が示されました。</p>
					<p>このプログラムの成功は、単なる数値で表される結果を超えて、複数のCNCF プロジェクトにまたがる参加者の貢献が具体的な影響を生み出し、優れた機能の強化が波及効果を生み出しました。次のコホートは2024年春に開始される予定です。クラウド ネイティブへの貢献の仕方が変わる、<strong>次のコホートに応募するチャンス</strong>をお見逃しなく。</p>
					<div aria-hidden="true" class="report-spacer-40"></div>

						<div class="lf-grid section-10__groups">
						<div class="section-10__groups-col1">
							<div class="icon-box-3">
								<div class="icon">
									<img loading="lazy" decoding="async" width="80" height="47" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/icon-members-p.svg" alt="Members icon">
								</div>
								<div class="text">
									<span class="number">363</span>
									<span class="description">参加者</span>
								</div>
							</div>
						</div>
						<div class="section-10__groups-col2">
							<div class="icon-box-3">
								<div class="icon">
									<img loading="lazy" decoding="async" width="69" height="69" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/icon-globe-p.svg" alt="Globe icon">
								</div>
								<div class="text">
									<span class="number">23</span>
									<span class="description">カ国</span>
								</div>
							</div>
						</div>
						<div class="section-10__groups-col3">
							<div class="icon-box-3">
								<div class="icon">
									<img loading="lazy" decoding="async" width="56" height="63" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/icon-lanyard-p.svg" alt="Registrations icon">
								</div>
								<div class="text">
									<span class="number">850</span>
									<span class="description">登録者</span>
								</div>
							</div>
						</div>
					</div>
					<div aria-hidden="true" class="report-spacer-60"></div>

					<div class="wp-block-button"><a href="https://project.linuxfoundation.org/cncf-zero-to-merge-application?__hstc=60185074.00c66751e05a3460c5e18666474630cd.1707461272810.1707461272810.1707461272810.1&amp;__hssc=60185074.1.1707461272810&amp;__hsfp=3891499949" title="APPLY TO ZERO TO MERGE" class="wp-block-button__link fit-content">ZERO TO MERGEへの応募</a>
					</div>


				</div>
				<div class="section-10__cto-col2">
					<img width="508" height="508" loading="lazy" class="" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/image-10-1.png" srcset="https://www.cncf.io/wp-content/uploads/2023/12/image-10-1.png 508w, https://www.cncf.io/wp-content/uploads/2023/12/image-10-1-300x300.png 300w, https://www.cncf.io/wp-content/uploads/2023/12/image-10-1-150x150.png 150w, https://www.cncf.io/wp-content/uploads/2023/12/image-10-1-200x200.png 200w, https://www.cncf.io/wp-content/uploads/2023/12/image-10-1-400x400.png 400w" sizes="(max-width: 500px) 100vw, 500px" alt="Zero to Merge badge">				</div>
			</div>

			<div class="shadow-hr"></div>
			<p class="sub-header">エンドユーザー アクティビティ</p>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="lf-grid section-10__cto">
				<div class="section-10__cto-col1">

					<div class="lf-grid">
						<p class="opening-paragraph restrictive-10-col">コミュニティから多くを学び、あなたの声を影響力のあるグループへ届けるため、エンドユーザー コミュニティに参加してください。
					</div>
				</div>
				<div class="section-10__cto-col2">
					<div class="wp-block-button"><a href="https://www.cncf.io/enduser/" title="Join CNCF" class="wp-block-button__link fit-content">CNCFへの参加</a>
					</div>
					<div aria-hidden="true" class="report-spacer-80"></div>
				</div>
			</div>

			<p class="sub-header">エンドユーザー メンバーからの貢献が最も多かったCNCFプロジェクトのトップ10</p>
			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="logo-grid smaller">
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/backstage.svg" alt="Backstage Logo">
					</div>
					<div class="logo-grid__number">
						4,188
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/prometheus.svg" alt="Prometheus Logo">
					</div>
					<div class="logo-grid__number">
						601
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/argo.svg" alt="Argo Logo">
					</div>
					<div class="logo-grid__number">
						548
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/kubernetes.svg" alt="Kubernetes Logo">
					</div>
					<div class="logo-grid__number">
						137
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/telepresence.svg" alt="Telepresence Logo">
					</div>
					<div class="logo-grid__number">
						127
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/buildpacks.svg" alt="buildpacks Logo">
					</div>
					<div class="logo-grid__number">
						77
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/tremor.svg" alt="tremor Logo">
					</div>
					<div class="logo-grid__number">
						71
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/opentelemetry.svg" alt="opentelemetry Logo">
					</div>
					<div class="logo-grid__number">
						70
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/envoy.svg" alt="envoy Logo">
					</div>
					<div class="logo-grid__number">
						48
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/openfeature.svg" alt="openfeature Logo">
					</div>
					<div class="logo-grid__number">
						36
					</div>
				</div>
								
			</div>

			<div aria-hidden="true" class="report-spacer-80"></div>

			<p class="sub-header">最も貢献度の高いCNCFエンドユーザー メンバーのトップ10</p>
			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="logo-grid smaller">
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/spotify.svg" alt="Spotify Logo">
					</div>
					<div class="logo-grid__number green">
						4,125
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/bloomberg.svg" alt="Bloomberg Logo">
					</div>
					<div class="logo-grid__number green">
						534
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/reddit.svg" alt="Reddit Logo">
					</div>
					<div class="logo-grid__number green">
						372
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/intuit.svg" alt="Intuit Logo">
					</div>
					<div class="logo-grid__number green">
						241
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/workday.svg" alt="Workday Logo">
					</div>
					<div class="logo-grid__number green">
						136
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/thought-machine.svg" alt="Thought Machine Logo">
					</div>
					<div class="logo-grid__number green">
						129
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/shopify.svg" alt="Shopify Logo">
					</div>
					<div class="logo-grid__number green">
						107
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/wayfair.svg" alt="Wayfair Logo">
					</div>
					<div class="logo-grid__number green">
						88
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/swiss-post.svg" alt="swiss post Logo">
					</div>
					<div class="logo-grid__number green">
						56
					</div>
				</div>
				<div class="logo-grid__box">
					<div class="logo-grid__image">
						<img loading="lazy" decoding="async" width="160" height="50" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/yahoo.svg" alt="yahoo Logo">
					</div>
					<div class="logo-grid__number green">
						50
					</div>
				</div>
								
			</div>

			<div class="shadow-hr"></div>
			<p class="sub-header">エンドユーザー アワード</p>
			<div aria-hidden="true" class="report-spacer-60"></div>
			<div class="lf-grid">
				<p class="opening-paragraph restrictive-10-col">クラウド ネイティブ エコシステムへの素晴らしい貢献が認められた、Mercedes Benz Tech InnovationとSpotifyに本年のトップエンドユーザー アワードを授与できたことを大変うれしく思います。</p>
			</div>

			<div class="lf-grid section-10__vid">
				<div class="section-10__vid-col1">
				<a href="https://www.youtube.com/watch?v=ZPZSRFUNhMY">
					<img width="1000" height="560" loading="lazy" class="" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/mercedes.jpg" srcset="https://www.cncf.io/wp-content/uploads/2024/01/mercedes.jpg 1000w, https://www.cncf.io/wp-content/uploads/2024/01/mercedes-300x168.jpg 300w, https://www.cncf.io/wp-content/uploads/2024/01/mercedes-768x430.jpg 768w, https://www.cncf.io/wp-content/uploads/2024/01/mercedes-900x504.jpg 900w, https://www.cncf.io/wp-content/uploads/2024/01/mercedes-357x200.jpg 357w, https://www.cncf.io/wp-content/uploads/2024/01/mercedes-714x400.jpg 714w" sizes="(max-width: 600px) 100vw, 600px" alt="Mercedes store">				</a>
				</div>
				<div class="section-10__vid-col2">
					<p class="sub-header">2023春 受賞者</p>
					<div aria-hidden="true" class="report-spacer-20"></div>

					<img loading="lazy" decoding="async" width="315" height="80" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/mercedes.svg" alt="Merceds Logo">
					<div aria-hidden="true" class="report-spacer-20"></div>
					<p>Mercedes Benz Tech Innovation GmbHは、世界中でKubernetesへの貢献を続けているトップ エンドユーザー企業の1つです。</p>
				</div>
			</div>

			<div class="lf-grid section-10__vid tophr">
				<div class="section-10__vid-col1">
				<a href="https://www.cncf.io/reports/spotify-end-user-journey-report/">
					<img width="1000" height="560" loading="lazy" class="" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/53324016055_88c56e8699_o-1.jpg" srcset="https://www.cncf.io/wp-content/uploads/2023/12/53324016055_88c56e8699_o-1.jpg 1000w, https://www.cncf.io/wp-content/uploads/2023/12/53324016055_88c56e8699_o-1-300x168.jpg 300w, https://www.cncf.io/wp-content/uploads/2023/12/53324016055_88c56e8699_o-1-768x430.jpg 768w, https://www.cncf.io/wp-content/uploads/2023/12/53324016055_88c56e8699_o-1-900x504.jpg 900w, https://www.cncf.io/wp-content/uploads/2023/12/53324016055_88c56e8699_o-1-357x200.jpg 357w, https://www.cncf.io/wp-content/uploads/2023/12/53324016055_88c56e8699_o-1-714x400.jpg 714w" sizes="(max-width: 600px) 100vw, 600px" alt="People cheering on a conference stage">					</a>
				</div>
				<div class="section-10__vid-col2">
					<p class="sub-header">2023秋 受賞者</p>
					<div aria-hidden="true" class="report-spacer-20"></div>
					<img loading="lazy" decoding="async" width="243" height="80" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/spotify.svg" alt="Spotify Logo">
					<div aria-hidden="true" class="report-spacer-20"></div>
					<p>Spotifyにとって二度目の受賞となります。CNCFプロジェクトへの継続的な貢献は大きく、2023年だけでも23,000件を超えています。</p>
				</div>
			</div>

			<div class="lf-grid section-10__vid tophr">
				<div class="section-10__vid-col1">
				<a href="https://www.youtube.com/watch?v=gkZCnpDrjTQ">
					<img width="1000" height="560" loading="lazy" class="" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/intuit.jpg" srcset="https://www.cncf.io/wp-content/uploads/2024/01/intuit.jpg 1000w, https://www.cncf.io/wp-content/uploads/2024/01/intuit-300x168.jpg 300w, https://www.cncf.io/wp-content/uploads/2024/01/intuit-768x430.jpg 768w, https://www.cncf.io/wp-content/uploads/2024/01/intuit-900x504.jpg 900w, https://www.cncf.io/wp-content/uploads/2024/01/intuit-357x200.jpg 357w, https://www.cncf.io/wp-content/uploads/2024/01/intuit-714x400.jpg 714w" sizes="(max-width: 600px) 100vw, 600px" alt="Intuit workplace">				</a>
				</div>
				<div class="section-10__vid-col2">
					<p class="sub-header">2023秋 受賞者</p>
					<div aria-hidden="true" class="report-spacer-20"></div>

					<img loading="lazy" decoding="async" width="209" height="60" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/intuit.svg" alt="intuit Logo">
					<div aria-hidden="true" class="report-spacer-20"></div>
					<p>Intuitは2022年のトップ エンドユーザーに選ばれましたが、その背景となる多大なるオープンソースの取り組みをいくつか詳しく紹介する、この素晴らしいビデオを皆さんと共有する機会を作りたいと思っていました。</p>
				</div>
			</div>

		</section>

		<section id="events" class="section-11 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">イベント</h2>
					<div class="section-number">2/6</div>
				</div>

				<div class="lf-grid">
					<p class="opening-paragraph restrictive-10-col">真にグローバルなコミュニティとして、イベントは常に重要なものです。対面でつながり、仲間から学び、イノベーションを推進し、それらがクラウド ネイティブのエコシステムを強固なものとする。イベントはそんな機会を提供します。</p>
				</div>

				<div class="lf-grid">
					<div class="restrictive-10-col">
						<p>クラウド ネイティブ コミュニティへの取り組みの一環として、私たちは2023年を通じてイベントに多額の投資を行い、セキュリティとWASMに関連するコラボレーションの新たな機会を取り入れました。また、素晴らしいことに、パンデミックのため3年間開催ができなかった中国でのKubeCon + CloudNativeConをホストすることができました。</p>
					</div>
				</div>
				<div aria-hidden="true" class="report-spacer-60"></div>

				<img width="2400" height="1000" loading="lazy" class="" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/img-1.jpg" srcset="https://www.cncf.io/wp-content/uploads/2023/12/img-1.jpg 2400w, https://www.cncf.io/wp-content/uploads/2023/12/img-1-300x125.jpg 300w, https://www.cncf.io/wp-content/uploads/2023/12/img-1-1024x427.jpg 1024w, https://www.cncf.io/wp-content/uploads/2023/12/img-1-768x320.jpg 768w, https://www.cncf.io/wp-content/uploads/2023/12/img-1-900x375.jpg 900w, https://www.cncf.io/wp-content/uploads/2023/12/img-1-1800x750.jpg 1800w, https://www.cncf.io/wp-content/uploads/2023/12/img-1-480x200.jpg 480w, https://www.cncf.io/wp-content/uploads/2023/12/img-1-960x400.jpg 960w" sizes="(max-width: 1200px) 100vw, 1200px" alt="Men cheering at a conference">
				<div class="shadow-hr"></div>

				<h2 class="section-header">Kubernetes <br class="show-over-1000">Community Days</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>


				<div class="lf-grid">
					<p class="opening-paragraph restrictive-10-col">KCDは、世界中で Kubernetesとクラウド ネイティブ テクノロジーの導入と改善を促進することを目的として、利用者と技術者が集まり、学習、共同作業、ネットワークづくりを行うコミュニティ主催のイベントです。さまざまな地域で進化する<a href="https://www.cncf.io/kcds/">KCDコミュニティ</a>のニーズに応えて、CNCFは今年プログラムを強化しました。	</p>
				</div>

				<div class="lf-grid section-11__kcd">
					<div class="section-11__kcd-col1">

						<div class="icon-layout">

							<div class="icon-box-1">
								<div class="icon">
									<img loading="lazy" decoding="async" width="57" height="63" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/icon-lanyard-p2.svg" alt="Lanyard icon">
								</div>
								<div class="text">
									<span>32 KCDs</span><br>
									現地開催、バーチャル、ハイブリッド
									<div class="text-smaller">前年比100%増加
									</div>
								</div>
							</div>
							<div class="icon-box-1">
								<div class="icon">
									<img loading="lazy" decoding="async" width="63" height="63" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/icon-globe-p.svg" alt="Globe icon">
								</div>
								<div class="text">
									<span>24 カ国</span><br>
									世界にまたがる
								</div>
							</div>
							<div class="icon-box-1">
								<div class="icon">
									<img loading="lazy" decoding="async" width="63" height="63" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/icon-non-male.svg" alt="Non-male icon">
								</div>
								<div class="text">
									<span>20% 男性以外</span><br>
									スピーカーの平均
								</div>
							</div>
						</div>
					</div>

					<div class="section-11__kcd-col2">

						<div class="icon-layout">

							<div class="icon-box-1">
								<div class="icon">
									<img loading="lazy" decoding="async" width="74" height="41" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/icon-members-p.svg" alt="Members icon">
								</div>
								<div class="text">
									<span>10,000+ 参加者</span>
									<div class="text-smaller">昨年比43%の増加
									</div>
								</div>
							</div>
							<div class="icon-box-1">
								<div class="icon">
									<img loading="lazy" decoding="async" width="57" height="47" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/icon-megaphone-p.svg" alt="Globe icon">
								</div>
								<div class="text">
									<span>プレゼンテーション</span><br>
									多様な言語による
									<div class="text-smaller">
									(英語、スラブ語、中国語、スペイン語、イタリア語、インドネシア語)
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">Kube days</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="lf-grid section-10__cto">
					<div class="section-10__cto-col1">
						<p>#TeamCloudNativeによって推進されており、アイデアやベスト プラクティスを共有し、コミュニティを強化できるように、クラウド ネイティブの専門家と利用者がつながることのできるローカルのイベントをもっと開催してほしいとの多くの要望に応え、私たちは行動を起こしました！</p>
						<p>2022年後半に、私たちはKubeDayイベント シリーズを立ち上げ、12月の横浜で開催した<a href="https://www.cncf.io/reports/kubeday-japan-2022/">KubeDay Japan</a>を皮切りにスタートしました。</p>
						<p>2023年は以下のイベントを開催していきました。</p>
						<ul>
							<li><strong>6月: テルアビブ、イスラエル</strong></li>
							<li><strong>12月: バンガロール、インド</strong></li>
							<li><strong>12月: シンガポール</strong></li>
						</ul>

					</div>
					<div class="section-10__cto-col2">
						<img width="1024" height="847" loading="lazy" class="" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/g-crpt-1024x847.png" srcset="https://www.cncf.io/wp-content/uploads/2024/01/g-crpt-1024x847.png 1024w, https://www.cncf.io/wp-content/uploads/2024/01/g-crpt-300x248.png 300w, https://www.cncf.io/wp-content/uploads/2024/01/g-crpt-768x635.png 768w, https://www.cncf.io/wp-content/uploads/2024/01/g-crpt-900x744.png 900w, https://www.cncf.io/wp-content/uploads/2024/01/g-crpt-242x200.png 242w, https://www.cncf.io/wp-content/uploads/2024/01/g-crpt-484x400.png 484w, https://www.cncf.io/wp-content/uploads/2024/01/g-crpt.png 1104w" sizes="(max-width: 500px) 100vw, 500px" alt="Man speaking on microphone">					</div>
				</div>
			</div>
		</section>

		<section class="section-12 is-style-down-gradient alignfull">

			<div class="container wrap">

				<p class="sub-header">CloudNativeSecurityCon</p>
				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<p class="restrictive-9-col">KubeCon + CloudNativeConと併催されるイベントとして始まったこのイベントは、2023年には正式に主要なイベントへと成長しました。実際、この種のイベントとしては初のクラウド ネイティブ セキュリティのイベントです。第1回CloudNativeSecurityConには、世界中から約800人の専門家や利用者が集まり、クラウド ネイティブ テクノロジーで直面する独自のセキュリティの問題に関する気づきと経験を共有しました。詳細については、<a href="https://www.cncf.io/reports/cloudnativesecuritycon-north-america-2023-transparency-report/">透明性レポート</a>の完全版をお読みください。</p>
				</div>
				<div aria-hidden="true" class="report-spacer-60"></div>

				<picture>
					<source media="(max-width: 499px)" srcset="https://www.cncf.io/wp-content/uploads/2023/12/m_stats.png">
					<source media="(min-width: 500px)" srcset="https://www.cncf.io/wp-content/uploads/2023/12/cnsc-na-23demographics1.png">
					<img width="2400" height="1498" loading="lazy" class="" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/cnsc-na-23demographics1.png" srcset="https://www.cncf.io/wp-content/uploads/2023/12/cnsc-na-23demographics1.png 2400w, https://www.cncf.io/wp-content/uploads/2023/12/cnsc-na-23demographics1-300x187.png 300w, https://www.cncf.io/wp-content/uploads/2023/12/cnsc-na-23demographics1-1024x639.png 1024w, https://www.cncf.io/wp-content/uploads/2023/12/cnsc-na-23demographics1-768x479.png 768w, https://www.cncf.io/wp-content/uploads/2023/12/cnsc-na-23demographics1-900x562.png 900w, https://www.cncf.io/wp-content/uploads/2023/12/cnsc-na-23demographics1-1800x1124.png 1800w, https://www.cncf.io/wp-content/uploads/2023/12/cnsc-na-23demographics1-320x200.png 320w, https://www.cncf.io/wp-content/uploads/2023/12/cnsc-na-23demographics1-641x400.png 641w" sizes="(max-width: 1200px) 100vw, 1200px" alt="CloudNativeSecurityCon attendee stats.">				</picture>

				<div class="shadow-hr"></div>


				<h2 class="section-header">KubeCon + <br class="show-over-1000">CloudNativeCon ヨーロッパ</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<img width="2400" height="1040" loading="lazy" class="" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/img2.jpg" srcset="https://www.cncf.io/wp-content/uploads/2023/12/img2.jpg 2400w, https://www.cncf.io/wp-content/uploads/2023/12/img2-300x130.jpg 300w, https://www.cncf.io/wp-content/uploads/2023/12/img2-1024x444.jpg 1024w, https://www.cncf.io/wp-content/uploads/2023/12/img2-768x333.jpg 768w, https://www.cncf.io/wp-content/uploads/2023/12/img2-900x390.jpg 900w, https://www.cncf.io/wp-content/uploads/2023/12/img2-1800x780.jpg 1800w, https://www.cncf.io/wp-content/uploads/2023/12/img2-462x200.jpg 462w, https://www.cncf.io/wp-content/uploads/2023/12/img2-923x400.jpg 923w" sizes="(max-width: 1200px) 100vw, 1200px" alt="Welcome to KubeCon + CloudNativeCon Europe 2023">
				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="sub-header">参加者のデモグラフィック</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<picture>
					<source media="(max-width: 599px)" srcset="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/demographics-mobile-1.svg">
					<source media="(min-width: 600px)" srcset="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/demographics-desktop-1.svg">
					<img width="1200" height="584" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/demographics-desktop-1.svg" alt="Showing 16,092 Registered attendees of which 42% were men, 6% women, &lt;1% non-binary/other, and 52% preferred not to answer. Of the attendees 65% were in person, 35% were virtual. 51% of visitors were first timers." loading="lazy" decoding="async">
				</picture>
				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="lf-grid section-12__stats">
					<div class="section-12__stats-col1">
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" decoding="async" width="62" height="62" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/icon-download-pink.svg" alt="Download icon">
							</div>
							<div class="text">
								<span class="number" style="color: #FF1E15;">1,767</span><br>
								<span class="description">CFP 応募数</span>
							</div>
						</div>

					</div>
					<div class="section-12__stats-col2">
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" decoding="async" width="82" height="67" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/icon-megaphone-pink.svg" alt="Megaphone icon">
							</div>
							<div class="text">
								<span class="number" style="color: #FF1E15;">556</span><br>
								<span class="description">スピーカー</span>
							</div>
						</div>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<div class="lf-grid section-12__report">
					<div class="section-12__report-col1">

						<p class="sub-header">詳細については透明性レポートの完全版をご覧ください。</p>

						<div aria-hidden="true" class="report-spacer-40"></div>

						<div class="wp-block-button"><a href="https://www.cncf.io/reports/kubecon-cloudnativecon-europe-2023/" title="Read the KubeCon + CloudNativeCon Europe 2023 Transparency Report" class="wp-block-button__link fit-content">レポートを見る</a>
						</div>

					</div>
					<div class="section-12__report-col2">
						<a href="https://www.cncf.io/reports/kubecon-cloudnativecon-europe-2023/">
							<img width="1024" height="538" loading="lazy" class="ds" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/kccnc-eu-23-share-image-1024x538.jpg" srcset="https://www.cncf.io/wp-content/uploads/2023/06/kccnc-eu-23-share-image-1024x538.jpg 1024w, https://www.cncf.io/wp-content/uploads/2023/06/kccnc-eu-23-share-image-300x158.jpg 300w, https://www.cncf.io/wp-content/uploads/2023/06/kccnc-eu-23-share-image-768x403.jpg 768w, https://www.cncf.io/wp-content/uploads/2023/06/kccnc-eu-23-share-image-194x102.jpg 194w, https://www.cncf.io/wp-content/uploads/2023/06/kccnc-eu-23-share-image-388x204.jpg 388w, https://www.cncf.io/wp-content/uploads/2023/06/kccnc-eu-23-share-image-776x408.jpg 776w, https://www.cncf.io/wp-content/uploads/2023/06/kccnc-eu-23-share-image-1552x816.jpg 1552w, https://www.cncf.io/wp-content/uploads/2023/06/kccnc-eu-23-share-image-900x473.jpg 900w, https://www.cncf.io/wp-content/uploads/2023/06/kccnc-eu-23-share-image-381x200.jpg 381w, https://www.cncf.io/wp-content/uploads/2023/06/kccnc-eu-23-share-image-762x400.jpg 762w, https://www.cncf.io/wp-content/uploads/2023/06/kccnc-eu-23-share-image-590x310.jpg 590w, https://www.cncf.io/wp-content/uploads/2023/06/kccnc-eu-23-share-image-1180x620.jpg 1180w, https://www.cncf.io/wp-content/uploads/2023/06/kccnc-eu-23-share-image.jpg 1800w" sizes="(max-width: 500px) 100vw, 500px" alt="Cover of the KubeCon + CloudNativeCon Europe 2023 Transparency Report">						</a>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">ハイライトビデオ</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="wp-block-lf-youtube-lite">
					<lite-youtube videoid="tBDK_AYGv-k" videotitle="Highlights from KubeCon + CloudNativeCon Europe 2023" webpstatus="1" sdthumbstatus="0" title="Play Highlights from KubeCon + CloudNativeCon Europe 2023"><template shadowrootmode="open">
<style>
	:host {
		contain: content;
		display: block;
		position: relative;
		width: 100%;
		padding-bottom: calc(100% / (16 / 9));
	}

	#frame, #fallbackPlaceholder, iframe {
		position: absolute;
		width: 100%;
		height: 100%;
	}

	#frame {
		cursor: pointer;
	}

	#fallbackPlaceholder {
		object-fit: cover;
	}

	#frame::before {
		content: '';
		display: block;
		position: absolute;
		top: 0;
		background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAADGCAYAAAAT+OqFAAAAdklEQVQoz42QQQ7AIAgEF/T/D+kbq/RWAlnQyyazA4aoAB4FsBSA/bFjuF1EOL7VbrIrBuusmrt4ZZORfb6ehbWdnRHEIiITaEUKa5EJqUakRSaEYBJSCY2dEstQY7AuxahwXFrvZmWl2rh4JZ07z9dLtesfNj5q0FU3A5ObbwAAAABJRU5ErkJggg==);
		background-position: top;
		background-repeat: repeat-x;
		height: 60px;
		padding-bottom: 50px;
		width: 100%;
		transition: all 0.2s cubic-bezier(0, 0, 0.2, 1);
		z-index: 1;
	}
	/* play button */
	.lty-playbtn {
		width: 70px;
		height: 46px;
		background-color: #212121;
		z-index: 1;
		opacity: 0.8;
		border-radius: 14%;
		transition: all 0.2s cubic-bezier(0, 0, 0.2, 1);
		border: 0;
	}
	#frame:hover .lty-playbtn {
		background-color: #f00;
		opacity: 1;
	}
	/* play button triangle */
	.lty-playbtn:before {
		content: '';
		border-style: solid;
		border-width: 11px 0 11px 19px;
		border-color: transparent transparent transparent #fff;
	}
	.lty-playbtn,
	.lty-playbtn:before {
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate3d(-50%, -50%, 0);
	}

	.lty-playbtn:hover {
		cursor: pointer;
	}

	/* Post-click styles */
	.lyt-activated {
		cursor: unset;
	}

	#frame.lyt-activated::before,
	.lyt-activated .lty-playbtn {
		display: none;
	}
</style>
<div id="frame">
	<picture>
		<source id="webpPlaceholder" type="image/webp" srcset="https://i.ytimg.com/vi_webp/tBDK_AYGv-k/maxresdefault.webp">
		<source id="jpegPlaceholder" type="image/jpeg" srcset="https://i.ytimg.com/vi/tBDK_AYGv-k/maxresdefault.jpg">
		<img id="fallbackPlaceholder" referrerpolicy="origin" loading="lazy" src="https://i.ytimg.com/vi/tBDK_AYGv-k/maxresdefault.jpg" aria-label="Play Highlights from KubeCon + CloudNativeCon Europe 2023" alt="Play Highlights from KubeCon + CloudNativeCon Europe 2023">
	</picture>
	<button class="lty-playbtn" aria-label="Play Highlights from KubeCon + CloudNativeCon Europe 2023"></button>
</div>
</template>
					</lite-youtube>
				</div>

			</div>
		</section>

				<section class="section-12 is-style-down-gradient alignfull">

			<div class="container wrap">

			<h2 class="section-header">KubeCon + CloudNativeCon <br class="show-over-1000">北米</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<img width="2400" height="1200" loading="lazy" class="" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/img3.jpg" srcset="https://www.cncf.io/wp-content/uploads/2023/12/img3.jpg 2400w, https://www.cncf.io/wp-content/uploads/2023/12/img3-300x150.jpg 300w, https://www.cncf.io/wp-content/uploads/2023/12/img3-1024x512.jpg 1024w, https://www.cncf.io/wp-content/uploads/2023/12/img3-768x384.jpg 768w, https://www.cncf.io/wp-content/uploads/2023/12/img3-900x450.jpg 900w, https://www.cncf.io/wp-content/uploads/2023/12/img3-1800x900.jpg 1800w, https://www.cncf.io/wp-content/uploads/2023/12/img3-400x200.jpg 400w, https://www.cncf.io/wp-content/uploads/2023/12/img3-800x400.jpg 800w" sizes="(max-width: 1200px) 100vw, 1200px" alt="Welcome to KubeCon + CloudNativeCon North America 2023">				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<p class="restrictive-9-col">KubeCon + CloudNativeCon North America は、中西部にこれほど多くの人が集まるのは初めてで、デトロイトは素晴らしい開催都市でした。 私たちは<strong>Sonatype</strong>と提携して、<strong>Security Slam</strong>を含む多くの新しい取り組みを開始しました。また、KubeCon + CloudNativeConでは、ウクライナ軍への勤務から短期休暇を取得したシニア デベロッパー アドボケイトのIhor Dvoretskyi氏を直接お迎えするなど、いくつかの特別なサプライズもありました。</p>
				</div>


				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="sub-header">参加者のデモグラフィック</p>

				<picture>
					<source media="(max-width: 599px)" srcset="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/demographics-mobile2.svg">
					<source media="(min-width: 600px)" srcset="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/demographics-desktop2.svg">
					<img width="1200" height="584" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/demographics-desktop2.svg" alt="Showing 13,666 Registered attendees of which 40% were men, 8% women, &lt;1% non-binary/other, and 52% preferred not to answer. Of the attendees 66% were in person, 34% were virtual. 54% of visitors were first timers." loading="lazy" decoding="async">
				</picture>
				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="lf-grid section-12__stats">
					<div class="section-12__stats-col1">
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" decoding="async" width="62" height="62" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/icon-download-yellow.svg" alt="Download icon">
							</div>
							<div class="text">
								<span class="number" style="color: #C93566;">1,871</span><br>
								<span class="description">CFP 応募数</span>
							</div>
						</div>

					</div>
					<div class="section-12__stats-col2">
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" decoding="async" width="82" height="67" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/icon-megaphone-yellow.svg" alt="Megaphone icon">
							</div>
							<div class="text">
								<span class="number" style="color: #C93566;">554</span><br>
								<span class="description">スピーカー</span>
							</div>
						</div>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<div class="lf-grid section-12__report">
					<div class="section-12__report-col1">

						<p class="sub-header">詳細については透明性レポートの完全版をご覧ください。</p>

						<div aria-hidden="true" class="report-spacer-40"></div>

						<div class="wp-block-button"><a href="https://www.cncf.io/reports/kubecon-cloudnativecon-north-america-2023/" title="Read the KubeCon + CloudNativeCon North America 2023 Transparency Report" class="wp-block-button__link fit-content">レポートを見る</a>
						</div>

					</div>
					<div class="section-12__report-col2">
						<a href="https://www.cncf.io/reports/kubecon-cloudnativecon-north-america-2023/">
							<img width="1024" height="538" loading="lazy" class="ds" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/kubecon-na-23-1024x538.jpg" srcset="https://www.cncf.io/wp-content/uploads/2023/12/kubecon-na-23-1024x538.jpg 1024w, https://www.cncf.io/wp-content/uploads/2023/12/kubecon-na-23-300x158.jpg 300w, https://www.cncf.io/wp-content/uploads/2023/12/kubecon-na-23-768x403.jpg 768w, https://www.cncf.io/wp-content/uploads/2023/12/kubecon-na-23-194x102.jpg 194w, https://www.cncf.io/wp-content/uploads/2023/12/kubecon-na-23-388x204.jpg 388w, https://www.cncf.io/wp-content/uploads/2023/12/kubecon-na-23-776x408.jpg 776w, https://www.cncf.io/wp-content/uploads/2023/12/kubecon-na-23-1552x816.jpg 1552w, https://www.cncf.io/wp-content/uploads/2023/12/kubecon-na-23-900x473.jpg 900w, https://www.cncf.io/wp-content/uploads/2023/12/kubecon-na-23-381x200.jpg 381w, https://www.cncf.io/wp-content/uploads/2023/12/kubecon-na-23-762x400.jpg 762w, https://www.cncf.io/wp-content/uploads/2023/12/kubecon-na-23-590x310.jpg 590w, https://www.cncf.io/wp-content/uploads/2023/12/kubecon-na-23-1180x620.jpg 1180w, https://www.cncf.io/wp-content/uploads/2023/12/kubecon-na-23.jpg 1800w" sizes="(max-width: 500px) 100vw, 500px" alt="Cover of the KubeCon + CloudNativeCon North America 2023 Transparency Report">						</a>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">ハイライトビデオ</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="wp-block-lf-youtube-lite">
					<lite-youtube videoid="SvgfGo-33G4" videotitle="Highlights from KubeCon + CloudNativeCon North America 2023" webpstatus="1" sdthumbstatus="0" title="Play Highlights from KubeCon + CloudNativeCon North America 2023"><template shadowrootmode="open">
<style>
	:host {
		contain: content;
		display: block;
		position: relative;
		width: 100%;
		padding-bottom: calc(100% / (16 / 9));
	}

	#frame, #fallbackPlaceholder, iframe {
		position: absolute;
		width: 100%;
		height: 100%;
	}

	#frame {
		cursor: pointer;
	}

	#fallbackPlaceholder {
		object-fit: cover;
	}

	#frame::before {
		content: '';
		display: block;
		position: absolute;
		top: 0;
		background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAADGCAYAAAAT+OqFAAAAdklEQVQoz42QQQ7AIAgEF/T/D+kbq/RWAlnQyyazA4aoAB4FsBSA/bFjuF1EOL7VbrIrBuusmrt4ZZORfb6ehbWdnRHEIiITaEUKa5EJqUakRSaEYBJSCY2dEstQY7AuxahwXFrvZmWl2rh4JZ07z9dLtesfNj5q0FU3A5ObbwAAAABJRU5ErkJggg==);
		background-position: top;
		background-repeat: repeat-x;
		height: 60px;
		padding-bottom: 50px;
		width: 100%;
		transition: all 0.2s cubic-bezier(0, 0, 0.2, 1);
		z-index: 1;
	}
	/* play button */
	.lty-playbtn {
		width: 70px;
		height: 46px;
		background-color: #212121;
		z-index: 1;
		opacity: 0.8;
		border-radius: 14%;
		transition: all 0.2s cubic-bezier(0, 0, 0.2, 1);
		border: 0;
	}
	#frame:hover .lty-playbtn {
		background-color: #f00;
		opacity: 1;
	}
	/* play button triangle */
	.lty-playbtn:before {
		content: '';
		border-style: solid;
		border-width: 11px 0 11px 19px;
		border-color: transparent transparent transparent #fff;
	}
	.lty-playbtn,
	.lty-playbtn:before {
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate3d(-50%, -50%, 0);
	}

	.lty-playbtn:hover {
		cursor: pointer;
	}

	/* Post-click styles */
	.lyt-activated {
		cursor: unset;
	}

	#frame.lyt-activated::before,
	.lyt-activated .lty-playbtn {
		display: none;
	}
</style>
<div id="frame">
	<picture>
		<source id="webpPlaceholder" type="image/webp" srcset="https://i.ytimg.com/vi_webp/SvgfGo-33G4/maxresdefault.webp">
		<source id="jpegPlaceholder" type="image/jpeg" srcset="https://i.ytimg.com/vi/SvgfGo-33G4/maxresdefault.jpg">
		<img id="fallbackPlaceholder" referrerpolicy="origin" loading="lazy" src="https://i.ytimg.com/vi/SvgfGo-33G4/maxresdefault.jpg" aria-label="Play Highlights from KubeCon + CloudNativeCon North America 2023" alt="Play Highlights from KubeCon + CloudNativeCon North America 2023">
	</picture>
	<button class="lty-playbtn" aria-label="Play Highlights from KubeCon + CloudNativeCon North America 2023"></button>
</div>
</template>
					</lite-youtube>
				</div>

			</div>
		</section>

		<section id="training" class="section-14 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">トレーニング &amp; <br class="show-over-1000">認定</h2>
					<div class="section-number">3/6</div>
				</div>

				<div class="lf-grid">
					<p class="opening-paragraph restrictive-10-col">教育は常にCNCFの柱の1つです。コミュニティのニーズに確実に応えられるよう、今年はトレーニングと認定に関する課題と難しさの大枠を掴むための小規模なアンケートを実施しました。</p>
				</div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p><strong>新しいトレーニングと認定を取得することのメリットは明らかでした。</strong></p>
					</div>
				</div>
				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="lf-grid section-14__courses">
					<div class="course-box">
						<span class="course-box__number2">~ 55%</span>
						<p class="course-box__description">トレーニングと認定資格の取得が新しい仕事を見つけるのに役立ったと答えました</p>
					</div>
					<div class="course-box">
						<span class="course-box__number2">67%</span>
						<p class="course-box__description">仕事において、より一層深めることができ、充実感を感じられるようになった</p>
					</div>
					<div class="course-box">
						<span class="course-box__number2">36%</span>
						<p class="course-box__description">新しいトレーニングまたは認定資格を取得した結果、より高い給与を取得できた</p>
					</div>
				</div>
				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>コミュニティへのより良いサービスを提供するために、CNCFは2023年に<strong>7つ</strong>の新しいトレーニングを開始しました。認定資格の数も劇的に改良が進み、2023年に<strong>5つ</strong>の新しい認定資格が追加されました。</p>
					</div>
				</div>
				<div aria-hidden="true" class="report-spacer-60"></div>
				<p class="sub-header">受験可能なCNCF認定の数</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<picture>
					<source media="(max-width: 599px)" srcset="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/certifications-mobile.svg">
					<source media="(min-width: 600px)" srcset="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/certifications-desktop.svg">
					<img width="1200" height="445" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/certifications-desktop.svg" alt="Shows growing number of certifications each year." loading="lazy" decoding="async">
				</picture>
				<div class="shadow-hr"></div>

				<h2 class="section-header">2023 トレーニング<br class="show-over-1000">コース</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-14__intro">
					<div class="section-14__intro-col1">
						<p>進化はトレーニングや認定の参加者数にも表れています</p>
					</div>
					<div class="section-14__intro-col2">
						<img width="582" height="124" loading="lazy" decoding="async" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/training-logos.svg" alt="Cloud native training courses from LF">

					</div>

				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid section-14__courses">

					<div class="course-box">
						<span class="course-box__number">13%</span>
						<span class="course-box__text">増加</span>
						<div class="thin-hr course-box__hr"></div>
						<p class="course-box__description">Kubernetes Massively Open Online Course (MOOC)の<a href="https://www.cncf.io/certification/training/">登録数が345,000件</a>に到達</p>
					</div>

					<div class="course-box">
						<span class="course-box__number">33%</span>
						<span class="course-box__text">増加</span>
						<div class="thin-hr course-box__hr"></div>
						<p class="course-box__description">Certified Kubernetes Administrator (CKA)試験の<a href="https://www.cncf.io/certification/expert/">認定数は176,000件</a>に到達</p>
					</div>

					<div class="course-box">
						<span class="course-box__number">31%</span>
						<span class="course-box__text">増加</span>
						<div class="thin-hr course-box__hr"></div>
						<p class="course-box__description">						<p class="course-box__description">Certified Kubernetes Application Developer(CKAD)の<a href="https://www.cncf.io/certification/ckad/">試験認定が79,000件</a>に到達</p>
					</div>

					<div class="course-box">
						<span class="course-box__number">38%</span>
						<span class="course-box__text">増加</span>
						<div class="thin-hr course-box__hr"></div>
						<p class="course-box__description">Certified Kubernetes Security Specialist (CKS)試験の<a href="https://www.cncf.io/certification/cks/">認定数が36,000件</a>に到達</p>
					</div>
					<div class="course-box">
						<span class="course-box__number">43%</span>
						<span class="course-box__text">増加</span>
						<div class="thin-hr course-box__hr"></div>
						<p class="course-box__description">Kubernetes and Cloud Native Associate (KCNA)試験の<a href="https://www.cncf.io/certification/kcna/">認定数が8,800件</a>に到達(2021年11月の開始以来)</p>
					</div>
					<div class="course-box">
						<span class="course-box__number">1,500以上</span>
						<span class="course-box__text">認定数</span>
						<div class="thin-hr course-box__hr"></div>
						<p class="course-box__description">Prometheus Certified Associate (PCA)試験の<a href="https://www.cncf.io/certification/pca/">認定数が1,500件以上</a>に到達(2022年9月の開始以来)</p>
					</div>
					<div class="course-box">
						<span class="course-box__number">60以上</span>
						<span class="course-box__text">認定数</span>
						<div class="thin-hr course-box__hr"></div>
						<p class="course-box__description">Istio Certified Associate (ICA)試験の認定数が60件以上に到達(2023年9月の開始以来)</p>
					</div>
				</div>
			</div>
		</section>

		<section id="projects" class="section-15 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">プロジェクト アップデート &amp; <br class="show-over-1000">満足度</h2>
					<div class="section-number">4/6</div>
				</div>

				<div class="lf-grid">
					<p class="opening-paragraph restrictive-10-col">CNCFは2023年を通じて、クラウド ネイティブをユビキタスにするという我々の取り組みを強く掲げ、<a href="https://www.cncf.io/projects/">24のグラデュエート プロジェクト</a>、<a href="https://www.cncf.io/projects/">36のインキュベーション プロジェクト</a>、<a href="https://www.cncf.io/sandbox-projects/">109のサンドボックス プロジェクト</a>をホストしました。</p>
				</div>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<?php echo do_shortcode( '[projects-maturity-chart]' ); ?>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<p class="sub-header">新たなプロジェクト</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="lf-grid section-15__projects">
					<div class="section-15__projects-col1">

						<p>2023年、<a href="https://www.cncf.io/people/technical-oversight-committee/">Technical Oversight Committee</a> (TOC)は<strong>17の新しいプロジェクト</strong>を承認しました。</p>

					</div>
					<div class="section-15__projects-col2">
						<div class="icon-box-4">
							<div class="icon">
								<img loading="lazy" decoding="async" width="71" height="74" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/icon-projects.svg" alt="Projects icon">
							</div>
							<div class="text">
								<span>2</span><br>
								インキュベーション
							</div>
						</div>
					</div>
					<div class="section-15__projects-col3">
						<div class="icon-box-4">
							<div class="icon">
								<img loading="lazy" decoding="async" width="61" height="62" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/icon-chapters-g.svg" alt="Sandbox icon">
							</div>
							<div class="text">
								<span>15</span><br>
								サンドボックス
							</div>
						</div>

					</div>
				</div>

			</div>
	</section>
	<section class="section-15 is-style-down-gradient alignfull">

			<div class="container wrap">

				<h2 class="section-header">プロジェクトの動向</h2>
				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>プロジェクトの成熟度は、エンドユーザーやベンダーによる採用を達成したこと、コードのコミットやコードベース変更の健全な割合を確立すること、複数の組織からコミッターの参加が得られたことを<a href="https://www.cncf.io/people/technical-oversight-committee/">TOC</a>に証明することで高められていきます。2023年に4つのプロジェクトがグラデュエート(卒業)になり、5つがインキュベーション レベルに移行しました。</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<p class="sub-header">グラデュエートしたプロジェクト</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="logo-grid smaller">
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/logo-project-cilium.svg" alt="Cilium Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/logo-project-cri-o.svg" alt="cri-o Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/logo-project-istio.svg" alt="Istio Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/logo-project-keda.svg" alt="Keda Logo" class="logo-grid__image">
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="sub-header">CNCF プロジェクトの進行速度</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="lf-grid">
					<p class="restrictive-10-col"><a href="https://www.cncf.io/blog/2023/10/27/october-2023-where-we-are-with-velocity-of-cncf-lf-and-top-30-open-source-projects/">CNCFプロジェクトの進行速度とトップのオープンソース プロジェクト</a>を継続的に調査することで、開発者やエンド ユーザーの共感を呼んでいるトレンドを非常によく知ることができます。その結果、成功する可能性が高いプラットフォームについての知見を得ることができます。このグラフは、2023年に最も大きな成長を遂げた30のプロジェクトを示しています。</p>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid legend-grid">

					<div class="legend-item">
						<div class="legend-box" style="background-color: #4065C5"></div>
						<span><strong>Kubernetes</strong><br>3662人の作成者</span>
					</div>
					<div class="legend-item">
						<div class="legend-box" style="background-color: #CB4727">
						</div><span><strong>OpenTelemetry</strong><br>1419人の作成者</span>
					</div>
					<div class="legend-item">
						<div class="legend-box" style="background-color: #F19E38">
						</div><span><strong>Argo</strong><br>927人の作成者</span>
					</div>
					<div class="legend-item">
						<div class="legend-box" style="background-color: #449431">
						</div><span><strong>Backstage</strong><br>641人の作成者</span>
					</div>
					<div class="legend-item">
						<div class="legend-box" style="background-color: #8C1A94">
						</div><span><strong>Prometheus</strong><br>457人の作成者</span>
					</div>
					<div class="legend-item">
						<div class="legend-box" style="background-color: #4397C2">
						</div><span><strong>Cilium</strong><br>440人の作成者</span>
					</div>
					<div class="legend-item">
						<div class="legend-box" style="background-color: #CC5077">
						</div><span><strong>gRPC</strong><br>439人の作成者</span>
					</div>
					<div class="legend-item">
						<div class="legend-box" style="background-color: #76A832">
						</div><span><strong>Istio</strong><br>399人の作成者</span>
					</div>
					<div class="legend-item">
						<div class="legend-box" style="background-color: #A93A35">
						</div><span><strong>Envoy</strong><br>396人の作成者</span>
					</div>
					<div class="legend-item">
						<div class="legend-box" style="background-color: #3E6291">
						</div><span><strong>Meshery</strong><br>325人の作成者</span>
					</div>
					<div class="legend-item">
						<div class="legend-box" style="background-color: #8E4995">
						</div><span><strong>Keycloak</strong><br>311人の作成者</span>
					</div>
					<div class="legend-item">
						<div class="legend-box" style="background-color: #52A799">
						</div><span><strong>Dapr</strong><br>296人の作成者</span>
					</div>
					<div class="legend-item">
						<div class="legend-box" style="background-color: #AAAA39">
						</div><span><strong>containerd</strong><br>295人の作成者</span>
					</div>
					<div class="legend-item">
						<div class="legend-box" style="background-color: #5F36C4">
						</div><span><strong>Fluentd</strong><br>274人の作成者</span>
					</div>
					<div class="legend-item">
						<div class="legend-box" style="background-color: #D7792D">
						</div><span><strong>NATS</strong><br>261人の作成者</span>
					</div>
					<div class="legend-item">
						<div class="legend-box" style="background-color: #7F1A13">
						</div><span><strong>Fluid</strong><br>252人の作成者</span>
					</div>
					<div class="legend-item">
						<div class="legend-box" style="background-color: #5C1863">
						</div><span><strong>Crossplane</strong><br>251人の作成者</span>
					</div>
					<div class="legend-item">
						<div class="legend-box" style="background-color: #4F9066">
						</div><span><strong>OPA</strong><br>228人の作成者</span>
					</div>
					<div class="legend-item">
						<div class="legend-box" style="background-color: #5B73A2">
						</div><span><strong>Knative</strong><br>210人の作成者</span>
					</div>
					<div class="legend-item">
						<div class="legend-box" style="background-color: #3C3EA6">
						</div><span><strong>KubeVirt</strong><br>208人の作成者</span>
					</div>
					<div class="legend-item">
						<div class="legend-box" style="background-color: #AD7635">
						</div><span><strong>Kubeflow</strong><br>199人の作成者</span>
					</div>
					<div class="legend-item">
						<div class="legend-box" style="background-color: #63D346">
						</div><span><strong>KEDA</strong><br>193人の作成者</span>
					</div>
					<div class="legend-item">
						<div class="legend-box" style="background-color: #AA2980">
						</div><span><strong>Falco</strong><br>190人の作成者</span>
					</div>
					<div class="legend-item">
						<div class="legend-box" style="background-color: #E1489B">
						</div><span><strong>Flux</strong><br>188人の作成者</span>
					</div>
					<div class="legend-item">
						<div class="legend-box" style="background-color: #935C3C">
						</div><span><strong>OpenCost</strong><br>185人の作成者</span>
					</div>
					<div class="legend-item">
						<div class="legend-box" style="background-color: #AEC341">
						</div><span><strong>Kyverno</strong><br>183人の作成者</span>
					</div>
					<div class="legend-item">
						<div class="legend-box" style="background-color: #40758A">
						</div><span><strong>Helm</strong><br>182人の作成者</span>
					</div>
					<div class="legend-item">
						<div class="legend-box" style="background-color: #6E8C32">
						</div><span><strong>etcd</strong><br>171人の作成者</span>
					</div>
					<div class="legend-item">
						<div class="legend-box" style="background-color: #BAA539">
						</div><span><strong>TiKV</strong><br>168人の作成者</span>
					</div>
					<div class="legend-item">
						<div class="legend-box" style="background-color: #285829">
						</div><span><strong>Harbor</strong><br>152人の作成者</span>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<picture>
					<source media="(max-width: 599px)" srcset="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/project-chart-mobile.svg">
					<source media="(min-width: 600px)" srcset="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/project-chart-desktop.svg">
					<img width="1200" height="445" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/project-chart-desktop.svg" alt="CNCF Project Velocity chart" loading="lazy" decoding="async">
				</picture>

				<div class="shadow-hr"></div>

				<p class="sub-header">プロジェクトの進行速度 重要なポイント</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="lf-grid">
					<ul class="restrictive-10-col" style="margin-bottom: 0;">
						<li><strong>Kubernetes</strong>は最大のコントリビューターをベースに成熟し続けています。</li>
						<li><strong>OpenTelemetry</strong>はコントリビューターのベースを拡大し続けており、CNCFエコシステム内で2番目に進行速度の高いプロジェクトとなっています。</li>
						<li><strong>Backstage</strong>は成長を続けており、クラウド ネイティブの開発者が経験した主だった問題点を解決しています。</li>
						<li><strong>GitOps</strong>はクラウド ネイティブ エコシステムにおいて引き続き重要であり、<strong>Argo</strong>や<strong>Flux</strong>などのプロジェクトが大規模なコミュニティを育成し続けています。
						<li>厳しい経済状況におけるコスト管理の重要性により、<strong>OpenCost</strong>がCNCFプロジェクト リストのトップ30に初めてランクインしました。 私は、世界中で<strong>FinOps</strong>のムーブメントが盛り上がるにつれて、OpenCostが成長し続けることを期待しています。
						<li><strong>Kubernetes</strong>が成熟するにつれて、多くの組織がサービス メッシュ テクノロジーに目を向けるようになり、Envoy、Cilium、IstioなどのCNCFプロジェクトは、需要を満たすために大規模なコントリビューター コミュニティを育成し続けています。<strong>Cilium</strong>は最近CNCFをグラデュエートし、CNCFプロジェクト リストのトップ30でいくつか順位を上げました。</li>
						<li>多くの場合、CNCFプロジェクトは<a href="https://www.cncf.io/case-studies/openai/">大規模なAIインフラストラクチャを支えており</a>、<strong>Kubeflow</strong>がCNCFプロジェクト リストのトップ30に初めてランクインしました。</li>
					</ul>
				</div>

				<div class="section-01__author">
					<img width="269" height="271" loading="lazy" class="" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/Chris-Aniszczyk.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/Chris-Aniszczyk.jpg 269w, https://www.cncf.io/wp-content/uploads/2022/12/Chris-Aniszczyk-150x150.jpg 150w, https://www.cncf.io/wp-content/uploads/2022/12/Chris-Aniszczyk-199x200.jpg 199w" sizes="(max-width: 75px) 100vw, 75px" alt="Chris Aniszczyk">					<p><strong>Chris Aniszczyk</strong><br>
CTO, CNCF</p>
				</div>
			</div>
		</section>

		<section class="section-16 is-style-down-gradient alignfull">

			<div class="container wrap">

				<h2 class="section-header">セキュリティ</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>CNCFは、<strong>Open Source Technology Improvement Fund (OSTIF)</strong>との戦略的提携により、2023年を通じて多数の<a href="https://www.cncf.io/blog/2022/08/08/improving-cncf-security-posture-with-independent-security-audits/">オープンソース セキュリティ監査</a>を実施しました。</p>
						<p>以下のCNCFプロジェクトはセキュリティ監査または関連する作業を完了しています。</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div>
				
				<p class="sub-header">ファジング監査</p>
				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="logo-grid smaller">
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/kyverno.svg" alt="kyverno Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/dapr.svg" alt="dapr Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/knative.svg" alt="knative Logo" class="logo-grid__image">
					</div>
				</div>
				<div aria-hidden="true" class="report-spacer-60"></div>
				<p class="sub-header">セキュリティ監査</p>
				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="logo-grid smaller">
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/crossplane.svg" alt="crossplane Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/dapr.svg" alt="dapr Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/dragonfly.svg" alt="dragonfly Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/kubernetes-stacked.svg" alt="Kubernetes Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/notary.svg" alt="notary Logo" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/vitess.svg" alt="vitess Logo" class="logo-grid__image">
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="quote-with-name-container">
				<p class="quote-with-name-container__quote">私たちが本当にクラウド ネイティブ テクノロジーを標準化し、それらを強固なものとし安全性を高め、さらに包括的で標準的なプロトコルのセットを構築する方向に進んでいるのであれば、そうすることで我々のソフトウェア アプリケーションの開発をより持続可能にすること、そしてソフトウェアが使用する地球資源をどれだけ利用するのかという点においても、より持続可能であることに注意を向けることができるようになります。</p>
				<div class="quote-with-name-container__marks">
					<p class="quote-with-name-container__name">Adrian Bridgwater</p>
					<p class="quote-with-name-container__position">Forbes</p>
				</div>
				</div>
			</div>
		</section>

		<section class="section-17 is-style-down-gradient alignfull">

			<div class="container wrap">

				<h2 class="section-header">フィッピーと仲間たち</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>フィッピーはシンプルなPHPアプリを用いて、何千もの人々が、コンテナ化から自動化まで、クラウド ネイティブ コンピューティングを理解するための最初の一歩を踏み出す支援してきました。現在、フィッピーと仲間たちの使命は、クラウド ネイティブ コンピューティングを解き明かし、そのわかりづらい概念を、納得感があり、おもしろく、そしてわかりやすい形で説明することです。</p>
					</div>
				</div>
				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="sub-header">2023年に2つのプロジェクトがキャラクターを寄贈してくれました。</p>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<div class="lf-grid section-17__characters">
					<img width="2078" height="962" loading="lazy" class="" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/Group-13065.png" srcset="https://www.cncf.io/wp-content/uploads/2024/01/Group-13065.png 2078w, https://www.cncf.io/wp-content/uploads/2024/01/Group-13065-300x139.png 300w, https://www.cncf.io/wp-content/uploads/2024/01/Group-13065-1024x474.png 1024w, https://www.cncf.io/wp-content/uploads/2024/01/Group-13065-768x356.png 768w, https://www.cncf.io/wp-content/uploads/2024/01/Group-13065-900x417.png 900w, https://www.cncf.io/wp-content/uploads/2024/01/Group-13065-1800x833.png 1800w, https://www.cncf.io/wp-content/uploads/2024/01/Group-13065-432x200.png 432w, https://www.cncf.io/wp-content/uploads/2024/01/Group-13065-864x400.png 864w" sizes="(max-width: 1100px) 100vw, 1100px" alt="New Phippy characters, Obee the Cilium Bee and Tai the TUF elephant">				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="sub-header">新しいフィッピーの本</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-10__cto">
					<div class="section-10__cto-col1">
						<p>さらに<strong>Phippy's Field Guide to Wasm</strong>でフィッピーがWASMの新しい冒険に飛び込むのを見ることができるようになりました。<strong>Fermyon</strong>の皆様に感謝します！</p>
					</div>
					<div class="section-10__cto-col2">
						<div class="wp-block-button"><a href="https://drive.google.com/file/d/1M465JPam7rdi5uf5_WOaatayU5RRJ9hm/view" title="Read now" class="wp-block-button__link fit-content">今から読む</a>
						</div>
						<div aria-hidden="true" class="report-spacer-40"></div>

					</div>
				</div>
						
				<a href="https://drive.google.com/file/d/1M465JPam7rdi5uf5_WOaatayU5RRJ9hm/view" title="Read now">
				<img width="2424" height="1381" loading="lazy" class="" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/Booklet.jpg" srcset="https://www.cncf.io/wp-content/uploads/2024/01/Booklet.jpg 2424w, https://www.cncf.io/wp-content/uploads/2024/01/Booklet-300x171.jpg 300w, https://www.cncf.io/wp-content/uploads/2024/01/Booklet-1024x583.jpg 1024w, https://www.cncf.io/wp-content/uploads/2024/01/Booklet-768x438.jpg 768w, https://www.cncf.io/wp-content/uploads/2024/01/Booklet-900x513.jpg 900w, https://www.cncf.io/wp-content/uploads/2024/01/Booklet-1800x1025.jpg 1800w, https://www.cncf.io/wp-content/uploads/2024/01/Booklet-351x200.jpg 351w, https://www.cncf.io/wp-content/uploads/2024/01/Booklet-702x400.jpg 702w" sizes="(max-width: 1100px) 100vw, 1100px" alt="Phippys Field Guide to Wasm book cover">				</a>

				<div class="shadow-hr"></div>

				<p class="sub-header">「フィッピーと仲間たち」ファミリーに参加しましょう！</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="section-17__banner">
					<div class="section-17__banner-wrapper">
						<div class="lf-grid section-10__cto">
							<div class="section-10__cto-col1">
								<h2 class="section-17__banner-title">あなたはグラデュエートしたプロジェクトのメンテナーですか?</h2>
								<p class="section-17__banner-text">多くの人がクラウド ネイティブ コンピューティングのコンセプトを理解できるよう、その手助けをしてみませんか?「フィッピーと仲間たち」ファミリーにキャラクターを寄贈しましょう。</p>

								<div aria-hidden="true" class="report-spacer-40"></div>

								<div class="wp-block-button"><a href="https://github.com/cncf/foundation/blob/master/phippy-guidelines.md" title="Donate a character" class="wp-block-button__link fit-content">キャラクターを寄贈する</a>
								</div>
							</div>
							<div class="section-10__cto-col2">
								<img width="704" height="540" loading="lazy" class="" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/Goldie-Question-Marks.png" srcset="https://www.cncf.io/wp-content/uploads/2024/01/Goldie-Question-Marks.png 704w, https://www.cncf.io/wp-content/uploads/2024/01/Goldie-Question-Marks-300x230.png 300w, https://www.cncf.io/wp-content/uploads/2024/01/Goldie-Question-Marks-261x200.png 261w, https://www.cncf.io/wp-content/uploads/2024/01/Goldie-Question-Marks-521x400.png 521w" sizes="(max-width: 500px) 100vw, 500px" alt="Confused Goldie character">							</div>
						</div>
					</div>
				</div>
				<div aria-hidden="true" class="report-spacer-40"></div>

			</div>
		</section>
		<section id="community" class="section-19 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">コミュニティ &amp; ダイバーシティ<br class="show-over-1000">エンゲージメント</h2>
					<div class="section-number">5/6</div>
				</div>

				<div class="lf-grid">
					<p class="opening-paragraph restrictive-10-col">CNCFコミュニティは世界中に広がり、コントリビューター、メンバー、ミートアップ、アンバサダーが存在します。</p>
				</div>

				<div class="lf-grid">
					<p class="restrictive-9-col">私たちは2023年に#TeamCloudNativeへの取り組みを倍増させ、持続的な活動、拡大、成長、導入を促進するためのコミュニティ主導の取り組みに投資しました。 重要なのは、エコシステムが誰もが成長できる居心地の良い場所であることを保証するために、DEIイニシアチブに重点を置き続けたことです。</p>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<img width="2400" height="960" loading="lazy" class="" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/img.jpg" srcset="https://www.cncf.io/wp-content/uploads/2024/01/img.jpg 2400w, https://www.cncf.io/wp-content/uploads/2024/01/img-300x120.jpg 300w, https://www.cncf.io/wp-content/uploads/2024/01/img-1024x410.jpg 1024w, https://www.cncf.io/wp-content/uploads/2024/01/img-768x307.jpg 768w, https://www.cncf.io/wp-content/uploads/2024/01/img-900x360.jpg 900w, https://www.cncf.io/wp-content/uploads/2024/01/img-1800x720.jpg 1800w, https://www.cncf.io/wp-content/uploads/2024/01/img-500x200.jpg 500w, https://www.cncf.io/wp-content/uploads/2024/01/img-1000x400.jpg 1000w" sizes="(max-width: 1200px) 100vw, 1200px" alt="Diversity group on stage cheering at Kubecon NA">				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid section-12__report">
					<div class="section-12__report-col1">

						<p class="sub-header">Deaf &amp; HOHワーキング グループ</p>

						<div aria-hidden="true" class="report-spacer-40"></div>

						<p>今年は、<a href="https://contribute.cncf.io/about/deaf-and-hard-of-hearing/">CNCF聴覚障がい者</a>(deaf/hoh)ワーキング グループが発足しました。このグループは、クラウド ネイティブおよびオープンソース コミュニティに聴覚障がいの方にも積極的に参加いただけるようにすることを目的としています。このグループの使命は、クラウド ネイティブおよびオープンソース コミュニティ内に<strong>協力的</strong>で<strong>包括的な環境</strong>を構築することです。</p>
					</div>
					<div class="section-12__report-col2">
						<img width="1250" height="814" loading="lazy" class="" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/graphic.jpg" srcset="https://www.cncf.io/wp-content/uploads/2024/01/graphic.jpg 1250w, https://www.cncf.io/wp-content/uploads/2024/01/graphic-300x195.jpg 300w, https://www.cncf.io/wp-content/uploads/2024/01/graphic-1024x667.jpg 1024w, https://www.cncf.io/wp-content/uploads/2024/01/graphic-768x500.jpg 768w, https://www.cncf.io/wp-content/uploads/2024/01/graphic-900x586.jpg 900w, https://www.cncf.io/wp-content/uploads/2024/01/graphic-307x200.jpg 307w, https://www.cncf.io/wp-content/uploads/2024/01/graphic-614x400.jpg 614w" sizes="(max-width: 600px) 100vw, 600px" alt="Laptop with CNBC article showing on it">					</div>
				</div>

				<div class="shadow-hr"></div>


				<p class="sub-header">DEI</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>CNCFは、この素晴らしいクラウド ネイティブ コミュニティの発展をサポートし続けると同時に、性別、性自認、性的指向、障害、人種、民族、年齢、宗教、経済的地位に関係なく、参加するすべての人が歓迎されていると感じられるように努めています。これまでに、<strong>Dan Kohnスカラーシップ ファンド</strong>を通じて、<strong>6,000件を超える多様性</strong>とニーズに基づいた奨学金を提供してきました。</p>
						<p>2023年、私たちは<strong>744人のスピーカー</strong>と奨学金受給者にCNCFイベントに参加するための旅行資金を提供しました。旅行基金の受取人は、伝統的に過小評価されているか疎外されているグループや、経済的理由により参加できなかった可能性のある活発なコミュニティのメンバーも含まれます。さらに、必要としている人たちに1,080枚の無料登録パスを提供しました。</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<p class="sub-header">奨学金は以下のスポンサーによって提供されました。</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="logo-grid smallest">

					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/logo-adevinta.svg" alt="Logo for Adevinta" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/logo-apple.svg" alt="Logo for Apple" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/logo-cncf.svg" alt="Logo for CNCF" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/logo-form3.svg" alt="Logo for Form 3" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/logo-google.svg" alt="Logo for Google" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/logo-honeycomb.svg" alt="Logo for Honeycomb" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/logo-isovalent.svg" alt="Logo for Isovalent" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/logo-orcasio.svg" alt="Logo for Orcasio" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/logo-strongdm.svg" alt="Logo for Strong DM" class="logo-grid__image">
					</div>
					<div class="logo-grid__box">
						<img loading="lazy" decoding="async" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/logo-tailscale.svg" alt="Logo for Tailscale" class="logo-grid__image">
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">Humans of Cloud Native</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<p class="opening-paragraph restrictive-10-col">CNCFの中心となるのは、クラウド ネイティブをユビキタスにするために協力する、誰もが参加できる実践者のコミュニティです。今年、私たちは<a href="https://www.cncf.io/humans-of-cloud-native/">12 Humans of Cloud Native</a>の特集を公開する機会に恵まれ、クラウド ネイティブのチームを活気にあふれ、わくわくする、多様性に富んだ空間へと作り上げてくれる素晴らしい個人とその貢献のストーリーを伝えています。また、KubeCon + CloudNativeCon North Americaでは、Bart Farrelが司会を務め、初となるHumans of Cloud Nativeのパネルを開催しました。</p>
				</div>
				<a href="https://www.cncf.io/humans-of-cloud-native/">
				<picture>
					<source media="(max-width: 499px)" srcset="					https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/hocn-mobile.jpg					">
										<source media="(min-width: 500px)" srcset="					https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/hocn-desktop.jpg					">
										<img width="1200" height="200" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/hocn-desktop.jpg" alt="Collage of multiple HOCN" loading="lazy" decoding="async">
				</picture>
				</a>
				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p><strong>クラウド ネイティブ エコシステムで素晴らしい活動をしている人を知っていますか?</strong>
						<br><a href="mailto:humans@cncf.io">humans@cncf.io</a>宛のメールを作成し、Human of Cloud Nativeに推薦してください。</p>
					</div>
				</div>
			</div>
		</section>
		<section class="section-19 is-style-down-gradient alignfull">

				<div class="container wrap">

				<h2 class="section-header">コミュニティ アワード</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>今年で7年目を迎えた<a href="https://www.cncf.io/announcements/2023/11/08/cloud-native-computing-foundation-announces-2023-community-awards-winners/">CNCFコミュニティ アワード</a>では、すべてのCNCFプロジェクトで最も活動的なアンバサダーとトップ コントリビューターが選ばれました。以下のアワードが授与されました。</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid section-19__ca">
					<div class="section-19__ca-col1">
						<img loading="lazy" decoding="async" width="64" height="66" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/icon-first-place.svg" alt="First place icon">

						<div aria-hidden="true" class="report-spacer-40"></div>

						<p class="sub-header">トップ クラウド ネイティブ コミッター</p>

						<div aria-hidden="true" class="report-spacer-20"></div>

						<p>一つもしくはそれ以上の CNCF プロジェクトにおいて、驚くべき技術スキルを持ち、著しい技術的成果を上げた個人に対して授与されます。</p>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<div class="section-19__person">
							<img width="350" height="350" loading="lazy" class="section-19__person-image" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/img-1(1).jpg" srcset="https://www.cncf.io/wp-content/uploads/2024/01/img-1.jpg 350w, https://www.cncf.io/wp-content/uploads/2024/01/img-1-300x300.jpg 300w, https://www.cncf.io/wp-content/uploads/2024/01/img-1-150x150.jpg 150w, https://www.cncf.io/wp-content/uploads/2024/01/img-1-200x200.jpg 200w" sizes="(max-width: 175px) 100vw, 175px" alt="Akihiro Suda">							<p class="section-19__person-text-wrapper">
							<span class="section-19__person-name">Akihiro Suda</span>
							<span class="section-19__person-title"><a href="https://www.twitter.com/_AkihiroSuda_">@_AkihiroSuda_</a></span></p>
						</div>

					</div>
					<div class="section-19__ca-col2">
						<img loading="lazy" decoding="async" width="54" height="64" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/icon-doc-check.svg" alt="Document with check icon">

						<div aria-hidden="true" class="report-spacer-40"></div>

						<p class="sub-header">トップ ドキュメンタリアン</p>

						<div aria-hidden="true" class="report-spacer-20"></div>

						<p>このアワードは、CNCFやそのプロジェクトに対する卓越した文書化への貢献を称するものです。</p>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<div class="section-19__person-align">

							<div class="section-19__person">
								<img width="342" height="342" loading="lazy" class="section-19__person-image" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/ddd.jpg" srcset="https://www.cncf.io/wp-content/uploads/2024/01/ddd.jpg 342w, https://www.cncf.io/wp-content/uploads/2024/01/ddd-300x300.jpg 300w, https://www.cncf.io/wp-content/uploads/2024/01/ddd-150x150.jpg 150w, https://www.cncf.io/wp-content/uploads/2024/01/ddd-200x200.jpg 200w" sizes="(max-width: 175px) 100vw, 175px" alt="Divya Mohan">								<p class="section-19__person-text-wrapper">
							<span class="section-19__person-name">Divya Mohan</span>
							<span class="section-19__person-title"><a href="https://twitter.com/divya_mohan02">@divya_mohan02</a></span></p>
							</div>

						</div>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<img loading="lazy" decoding="async" width="73" height="73" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/icon-chop.svg" alt="Axe icon">

						<div aria-hidden="true" class="report-spacer-40"></div>

						<p class="sub-header">Chop Wood &amp; Carry Water アワード</p>
						<div aria-hidden="true" class="report-spacer-20"></div>

						<p>CNCFは、日常のありふれたタスクに数え切れないほどの時間をかけて貢献してくれているコントリビューターたちを称えるべく<strong>「木を切り、水を運ぶ (Chop Wood and Carry Water)」</strong>アワードを設けています。CNCFは、2023年にすばらしい貢献をした5人の個人の驚くべき努力に感謝の意をお伝えします。</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="section-19__person-align">

					<div class="section-19__person">
						<img width="350" height="350" loading="lazy" class="section-19__person-image" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/DBFZK6cA_400x400.jpg" srcset="https://www.cncf.io/wp-content/uploads/2024/01/DBFZK6cA_400x400.jpg 350w, https://www.cncf.io/wp-content/uploads/2024/01/DBFZK6cA_400x400-300x300.jpg 300w, https://www.cncf.io/wp-content/uploads/2024/01/DBFZK6cA_400x400-150x150.jpg 150w, https://www.cncf.io/wp-content/uploads/2024/01/DBFZK6cA_400x400-200x200.jpg 200w" sizes="(max-width: 175px) 100vw, 175px" alt="Kaslin Fields">						<p class="section-19__person-text-wrapper">
							<span class="section-19__person-name">Kaslin Fields</span>
							<span class="section-19__person-title"><a href="https://www.twitter.com/kaslinfields">@kaslinfields</a></span></p>
					</div>

					<div class="section-19__person">
						<img width="350" height="350" loading="lazy" class="section-19__person-image" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/fassela.jpg" srcset="https://www.cncf.io/wp-content/uploads/2024/01/fassela.jpg 350w, https://www.cncf.io/wp-content/uploads/2024/01/fassela-300x300.jpg 300w, https://www.cncf.io/wp-content/uploads/2024/01/fassela-150x150.jpg 150w, https://www.cncf.io/wp-content/uploads/2024/01/fassela-200x200.jpg 200w" sizes="(max-width: 175px) 100vw, 175px" alt="Fassela k">						<p class="section-19__person-text-wrapper">
							<span class="section-19__person-name">Fassela k</span>
							<span class="section-19__person-title"><a href="https://www.twitter.com/FaseelaDilshan">@FaseelaDilshan</a></span></p>
					</div>

					<div class="section-19__person">
						<img width="350" height="350" loading="lazy" class="section-19__person-image" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/image-5.jpg" srcset="https://www.cncf.io/wp-content/uploads/2024/01/image-5.jpg 350w, https://www.cncf.io/wp-content/uploads/2024/01/image-5-300x300.jpg 300w, https://www.cncf.io/wp-content/uploads/2024/01/image-5-150x150.jpg 150w, https://www.cncf.io/wp-content/uploads/2024/01/image-5-200x200.jpg 200w" sizes="(max-width: 175px) 100vw, 175px" alt="Arnaud Meukam">						<p class="section-19__person-text-wrapper">
							<span class="section-19__person-name">Arnaud Meukam</span>
							<span class="section-19__person-title"><a href="https://www.twitter.com/ameukam">@ameukam</a></span></p>
					</div>

					<div class="section-19__person">
						<img width="350" height="350" loading="lazy" class="section-19__person-image" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/ddd1.jpg" srcset="https://www.cncf.io/wp-content/uploads/2024/01/ddd1.jpg 350w, https://www.cncf.io/wp-content/uploads/2024/01/ddd1-300x300.jpg 300w, https://www.cncf.io/wp-content/uploads/2024/01/ddd1-150x150.jpg 150w, https://www.cncf.io/wp-content/uploads/2024/01/ddd1-200x200.jpg 200w" sizes="(max-width: 175px) 100vw, 175px" alt="Lin Sun">						<p class="section-19__person-text-wrapper">
							<span class="section-19__person-name">Lin Sun</span>
							<span class="section-19__person-title"><a href="https://www.twitter.com/linsun_unc">@linsun_unc</a></span></p>
					</div>

					<div class="section-19__person">
						<img width="350" height="350" loading="lazy" class="section-19__person-image" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/rajas.jpg" srcset="https://www.cncf.io/wp-content/uploads/2024/01/rajas.jpg 350w, https://www.cncf.io/wp-content/uploads/2024/01/rajas-300x300.jpg 300w, https://www.cncf.io/wp-content/uploads/2024/01/rajas-150x150.jpg 150w, https://www.cncf.io/wp-content/uploads/2024/01/rajas-200x200.jpg 200w" sizes="(max-width: 175px) 100vw, 175px" alt="Rajas Kakodkar">						<p class="section-19__person-text-wrapper">
							<span class="section-19__person-name">Rajas Kakodkar</span>
							<span class="section-19__person-title"><a href="https://www.twitter.com/RajasKakodkar">@RajasKakodkar</a></span></p>
					</div>
				</div>
				<div aria-hidden="true" class="report-spacer-120"></div>


				<div class="lf-grid">
					<p class="opening-paragraph restrictive-10-col">2023年、CNCFはエコシステム全体に良い影響を波及させる素晴らしい活動に焦点を当てる2つの新しい賞を導入しました。</p>
				</div>


				<div class="lf-grid section-19__ca">
					<div class="section-19__ca-col1">
						<img loading="lazy" decoding="async" width="64" height="67" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/icon-first-place.svg" alt="First place icon">

						<div aria-hidden="true" class="report-spacer-40"></div>

						<p class="sub-header">ザ タギー</p>

						<div aria-hidden="true" class="report-spacer-20"></div>

						<p>CNCFの<a href="https://github.com/cncf/toc/tree/main/tags">Technical Advisory Groups (TAGs)</a>の発展に最も貢献した人物に贈られます。TAGは、クラウド ネイティブをユビキタスにするというCNCFの使命をサポートするため、誠実さを保ち、品質を向上させながら、CNCF技術コミュニティおよびユーザー コミュニティによる貢献を拡大します。この賞の最初の受賞者は次のとおりです。</p>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<div class="section-19__person">
							<img width="600" height="600" loading="lazy" class="section-19__person-image" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/uxf8JIRG_400x400.jpg" srcset="https://www.cncf.io/wp-content/uploads/2022/12/uxf8JIRG_400x400.jpg 600w, https://www.cncf.io/wp-content/uploads/2022/12/uxf8JIRG_400x400-300x300.jpg 300w, https://www.cncf.io/wp-content/uploads/2022/12/uxf8JIRG_400x400-150x150.jpg 150w, https://www.cncf.io/wp-content/uploads/2022/12/uxf8JIRG_400x400-200x200.jpg 200w, https://www.cncf.io/wp-content/uploads/2022/12/uxf8JIRG_400x400-400x400.jpg 400w" sizes="(max-width: 175px) 100vw, 175px" alt="Catherine Paganini">							<p class="section-19__person-text-wrapper">
							<span class="section-19__person-name">Catherine Paganini</span>
							<span class="section-19__person-title"><a href="https://www.twitter.com/CathPaga">@CathPaga</a></span></p>
						</div>

					</div>
					<div class="section-19__ca-col2">
						<img loading="lazy" decoding="async" width="67" height="67" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/icon-chapters-g.svg" alt="Document with check icon">

						<div aria-hidden="true" class="report-spacer-40"></div>

						<p class="sub-header">小さくも強力</p>

						<div aria-hidden="true" class="report-spacer-20"></div>

						<p>この賞は、コミュニティ内で最も大きな影響を与えた企業または組織を表彰します。 CNCFは何十万もの個人や組織で構成されており、それぞれが貴重な貢献を行っていますが、この賞はその重みを超えて力を尽くした組織に授与されます。CNCFは、この賞を以下の方々に贈呈できることを嬉しく思います。<br><br></p>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<div class="section-19__person-align">

							<div class="section-19__person">
								<img width="342" height="342" loading="lazy" class="section-19__person-image" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/uxf8JIRG_400x400-1.jpg" srcset="https://www.cncf.io/wp-content/uploads/2024/01/uxf8JIRG_400x400-1.jpg 342w, https://www.cncf.io/wp-content/uploads/2024/01/uxf8JIRG_400x400-1-300x300.jpg 300w, https://www.cncf.io/wp-content/uploads/2024/01/uxf8JIRG_400x400-1-150x150.jpg 150w, https://www.cncf.io/wp-content/uploads/2024/01/uxf8JIRG_400x400-1-200x200.jpg 200w" sizes="(max-width: 175px) 100vw, 175px" alt="Weaveworks">								<p class="section-19__person-text-wrapper">
							<span class="section-19__person-name">Weaveworks</span>
							<span class="section-19__person-title"><a href="https://twitter.com/Weaveworks">@Weaveworks</a></span></p>
							</div>

						</div>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<img width="2400" height="1240" loading="lazy" class="" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/53322717657_27a6ec8875_o-1.jpg" srcset="https://www.cncf.io/wp-content/uploads/2024/01/53322717657_27a6ec8875_o-1.jpg 2400w, https://www.cncf.io/wp-content/uploads/2024/01/53322717657_27a6ec8875_o-1-300x155.jpg 300w, https://www.cncf.io/wp-content/uploads/2024/01/53322717657_27a6ec8875_o-1-1024x529.jpg 1024w, https://www.cncf.io/wp-content/uploads/2024/01/53322717657_27a6ec8875_o-1-768x397.jpg 768w, https://www.cncf.io/wp-content/uploads/2024/01/53322717657_27a6ec8875_o-1-900x465.jpg 900w, https://www.cncf.io/wp-content/uploads/2024/01/53322717657_27a6ec8875_o-1-1800x930.jpg 1800w, https://www.cncf.io/wp-content/uploads/2024/01/53322717657_27a6ec8875_o-1-387x200.jpg 387w, https://www.cncf.io/wp-content/uploads/2024/01/53322717657_27a6ec8875_o-1-774x400.jpg 774w" sizes="(max-width: 1200px) 100vw, 1200px" alt="All award recipients on a stage">
			</div>
		</section>

		<section id="ecosystem" class="section-20 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">メンタリング &amp; <br class="show-over-1000">エコシステム リソース</h2>
					<div class="section-number">6/6</div>
				</div>

				<div class="lf-grid">
					<p class="opening-paragraph restrictive-10-col">CNCFは、2023年を通じて個人のコントリビューターやコミュニティ グループと緊密に<strong>連携</strong>し、クラウド ネイティブ テクノロジーに対する世界的な需要の高まりに応えるために<strong>急成長するエコシステム</strong>をナビゲートおよび管理するためのプログラムを開発しました。</p>
				</div>

				<img width="2400" height="1040" loading="lazy" class="" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/53322717657_27a6ec8875_o-1-1.jpg" srcset="https://www.cncf.io/wp-content/uploads/2024/01/53322717657_27a6ec8875_o-1-1.jpg 2400w, https://www.cncf.io/wp-content/uploads/2024/01/53322717657_27a6ec8875_o-1-1-300x130.jpg 300w, https://www.cncf.io/wp-content/uploads/2024/01/53322717657_27a6ec8875_o-1-1-1024x444.jpg 1024w, https://www.cncf.io/wp-content/uploads/2024/01/53322717657_27a6ec8875_o-1-1-768x333.jpg 768w, https://www.cncf.io/wp-content/uploads/2024/01/53322717657_27a6ec8875_o-1-1-900x390.jpg 900w, https://www.cncf.io/wp-content/uploads/2024/01/53322717657_27a6ec8875_o-1-1-1800x780.jpg 1800w, https://www.cncf.io/wp-content/uploads/2024/01/53322717657_27a6ec8875_o-1-1-462x200.jpg 462w, https://www.cncf.io/wp-content/uploads/2024/01/53322717657_27a6ec8875_o-1-1-923x400.jpg 923w" sizes="(max-width: 1200px) 100vw, 1200px" alt="Conference participants doing a selfie">				<div aria-hidden="true" class="report-spacer-100"></div>

				<h2 class="section-header">コミュニティ メンタリング</h2>
				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<p class="opening-paragraph restrictive-10-col">CNCFは、2023年に、<a href="https://lfx.linuxfoundation.org/?__hstc=60185074.00c66751e05a3460c5e18666474630cd.1707461272810.1707461272810.1707461272810.1&amp;__hssc=60185074.1.1707461272810&amp;__hsfp=3891499949">LFXメンターシップ プラットフォーム</a>、<a href="https://summerofcode.withgoogle.com/">Google Summer of Code (GSoC)</a>、<a href="https://developers.google.com/season-of-docs">Google Summer of Docs (GSoD)</a>プログラム、<a href="https://www.outreachy.org/">Outreachy</a>など、さまざまな<a href="https://github.com/cncf/mentoring">メンタリングやインターンシップ</a>の機会を通じて140名を超える個人をサポートできたことを大変光栄に思っております。これらのプログラムは、インターンシップが私たち全員が関わる将来のテクノロジーに影響を与えるための重要な触媒になります。
				</div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>TAG Contributor Strategy Mentoring Working Groupは、Google Summer of Codeのコミュニティ管理者を採用し、ワーキング グループの目標に対するプログラムの有効性の測定を支援するためデータ分析のテクニカル リードを加えました。</p>
					</div>
				</div>


				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid section-20__mentoring">

					<div class="section-20__mentoring-col1">
					<p class="sub-header">私たちは132人の学生が30のCNCFプロジェクトに取り組むようサポートしました。</p>
					<div aria-hidden="true" class="report-spacer-20"></div>
						<img loading="lazy" decoding="async" width="308" height="276" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/lf-mentorship-group.svg" alt="Mentorship metrics">
					</div>
					<div class="section-20__mentoring-col2">
					<p class="sub-header">CNCFプロジェクトが他のオープンソース メンタリングの機会に参加できるように支援しました。</p>
					<div aria-hidden="true" class="report-spacer-20"></div>
					<img loading="lazy" decoding="async" width="458" height="276" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/mentoring-opps-group.svg" alt="Mentoring opportunities metrics">
					</div>

				</div>

			</div>
		</section>

		<section class="section-21 is-style-down-gradient alignfull">

			<div class="container wrap">

				<h2 class="section-header">ファンディング</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<p class="opening-paragraph restrictive-10-col">CNCFの収益は、メンバーシップ、イベント スポンサーシップ、イベント登録、トレーニングを含む4つの主要な資金調達源から得られます。</p>
				</div>

				<p class="sub-header">4つのファンディング ソース</p>

				<div aria-hidden="true" class="report-spacer-60"></div>
				<picture>
						<source media="(max-width: 599px)" srcset="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/funding-mobile.svg">
						<source media="(min-width: 600px)" srcset="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/funding-desktop.svg">
						<img width="1098" height="502" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/funding-desktop.svg" alt="CNCF Funding breakdown pie chart" loading="lazy" decoding="async">
					</picture>

				<div class="shadow-hr"></div>

				<p class="sub-header">支出</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<picture>
						<source media="(max-width: 599px)" srcset="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/expenditures-mobile.svg">
						<source media="(min-width: 600px)" srcset="https://www.cncf.io/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/expenditures-desktop.svg">
						<img width="1200" height="700" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/expenditures-desktop.svg" alt="expenditures breakdown" loading="lazy" decoding="async">
					</picture>

					<div aria-hidden="true" class="report-spacer-100"></div>

					<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>CNCF、私たちのカンファレンス(<a href="https://www.cncf.io/kubecon-cloudnativecon-events/">KubeCon + CloudNativeCon</a>など)、およびオープンソースの背後にある基本的な前提は、インタラクションは総じてポジティブ サムであるということです。投資、マインドシェア、開発へのコントリビューションについて固定的に特定のプロジェクトへ割り当てるということはしません。同様に重要なことは、プロジェクトとコミュニティに対する中立的な立ち位置が、この種のポジティブ サムの思考を促進し、オープンソース プロジェクトを成功させるための重要な要素であると私たちが信じている、成長と多様性を促進することです。</p>
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

						<p class="thanks__opening">2023年に私たちが一緒に達成したすべての素晴らしいことを振り返り、楽しんでいただければ幸いです。</p>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<p class="thanks__comments">コメントやフィードバックは<a href="mailto:info@cncf.io">info@cncf.io</a>でお待ちしております。</p>

						<div aria-hidden="true" class="report-spacer-80"></div>

						<p>2024年にお会いできるのを楽しみにしています!皆さんに身近な<strong>コミュニティ イベントのカレンダー</strong>をチェックし、4月にパリで開催されるKubeCon+CloudNativeCon Europeへの<strong>登録</strong>をお忘れなく。</p>
					</div>
					<div class="thanks__col2">

				<figure class="thanks__col2-bg-figure">
					<img width="1726" height="1356" loading="lazy" class="thanks__col2-bg-image" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/chicago-3d-scene.png" srcset="https://www.cncf.io/wp-content/uploads/2023/12/chicago-3d-scene.png 1726w, https://www.cncf.io/wp-content/uploads/2023/12/chicago-3d-scene-300x236.png 300w, https://www.cncf.io/wp-content/uploads/2023/12/chicago-3d-scene-1024x804.png 1024w, https://www.cncf.io/wp-content/uploads/2023/12/chicago-3d-scene-768x603.png 768w, https://www.cncf.io/wp-content/uploads/2023/12/chicago-3d-scene-900x707.png 900w, https://www.cncf.io/wp-content/uploads/2023/12/chicago-3d-scene-255x200.png 255w, https://www.cncf.io/wp-content/uploads/2023/12/chicago-3d-scene-509x400.png 509w" sizes="(max-width: 2400px) 100vw, 2400px" alt="City architecture diagram">				</figure>
					</div>
				</div>
				<div aria-hidden="true" class="report-spacer-120"></div>

				<div class="event-banner has-animation-scale-2" role="banner">
	<a href="https://events.linuxfoundation.org/kubecon-cloudnativecon-europe/?utm_source=www&amp;utm_medium=all&amp;utm_campaign=kubeconeu24&amp;utm_content=big-banner&amp;__hstc=60185074.00c66751e05a3460c5e18666474630cd.1707461272810.1707461272810.1707461272810.1&amp;__hssc=60185074.1.1707461272810&amp;__hsfp=3891499949" title="KubeCon + CloudNativeCon Europe 2024">
		<picture>
			<source media="(max-width: 499px)" srcset="https://www.cncf.io/wp-content/uploads/2023/05/KCEU24_CNCF_Site_Banner_Mobile_900x1110.png">
			<source media="(min-width: 500px)" srcset="https://www.cncf.io/wp-content/uploads/2023/05/KCEU24_CNCF_Site_Banner_2400x850b.png">
			<img width="2401" height="841" loading="lazy" class="" src="/wp-content/themes/cncf-twenty-two/images/annual-reports/2023/KCEU24_CNCF_Site_Banner_2400x850b.png" srcset="https://www.cncf.io/wp-content/uploads/2023/05/KCEU24_CNCF_Site_Banner_2400x850b.png 2401w, https://www.cncf.io/wp-content/uploads/2023/05/KCEU24_CNCF_Site_Banner_2400x850b-300x105.png 300w, https://www.cncf.io/wp-content/uploads/2023/05/KCEU24_CNCF_Site_Banner_2400x850b-1024x359.png 1024w, https://www.cncf.io/wp-content/uploads/2023/05/KCEU24_CNCF_Site_Banner_2400x850b-768x269.png 768w, https://www.cncf.io/wp-content/uploads/2023/05/KCEU24_CNCF_Site_Banner_2400x850b-900x315.png 900w, https://www.cncf.io/wp-content/uploads/2023/05/KCEU24_CNCF_Site_Banner_2400x850b-1800x630.png 1800w, https://www.cncf.io/wp-content/uploads/2023/05/KCEU24_CNCF_Site_Banner_2400x850b-571x200.png 571w, https://www.cncf.io/wp-content/uploads/2023/05/KCEU24_CNCF_Site_Banner_2400x850b-1142x400.png 1142w" sizes="(max-width: 1200px) 100vw, 1200px" alt="KubeCon + CloudNativeCon Europe 2024">		</picture>
	</a>
</div>
<div style="height:100px" aria-hidden="true" class="wp-block-spacer is-style-60-100"></div>

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
	'annual-report-23',
	get_template_directory_uri() . '/source/js/on-demand/annual-report-23.js',
	array( 'jquery', 'slick' ),
	filemtime( get_template_directory() . '/source/js/on-demand/annual-report-23.js' ),
	true
);

get_template_part( 'components/footer' );
