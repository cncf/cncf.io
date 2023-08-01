<?php
/**
 * Template Name: KCCNC EU 23 Transparency JP
 * Template Post Type: lf_report
 *
 * File for the KCCNC EU 2023 Transparency Report
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

wp_enqueue_style( 'wp-block-column' );
wp_enqueue_style( 'wp-block-columns' );
wp_enqueue_style( 'wp-block-group' );

get_template_part( 'components/header' );

get_template_part( 'components/skip-link-target' );

// Report folder in images/ folder.
$report_folder = 'reports/kccnc-eu-23/'

?>

<link rel="prefetch"
	href="<?php echo esc_url( get_template_directory_uri() . '/build/kccnc-eu-23-transparency.min.css' ); ?>"
	as="style" crossorigin="anonymous" />

<?php wp_enqueue_style( 'kccnc-eu-23', get_template_directory_uri() . '/build/kccnc-eu-23-transparency.min.css', array(), filemtime( get_template_directory() . '/build/kccnc-eu-23-transparency.min.css' ), 'all' ); ?>

<main class="kccnc-eu-23">
	<article class="container wrap">

		<section class="hero alignfull">
			<div class="container wrap hero__wrap">
				<div class="hero__text-overlay">
					<div class="container hero__container">
						<div class="hero__wrapper">
							<img class="hero__logo"
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-kccnc-eu-23.svg', true ); ?>"
								width="295" height="128"
								alt="KubeCon + CloudNativeCon Europe 2023 Logo"
								loading="eager">
							<h1 class="hero__title uppercase">透明性レポート
							</h1>

							<div class="hero__hr"></div>

							<p align-text="left" vertical-align=""><font size ="4" color="#003B63"><b>日本語版翻訳協力：富田 明男（Akio Tomita）、富田 佑実（Yumi Tomita）</b></font></p>

							<div class="hero__button-share-align">

								<?php
								get_template_part( 'components/social-share' );
								?>
							</div>

							<div class="hero__jump">各セクションへジャンプ：</div>
						</div>
					</div>
				</div>
				<figure class="hero__bg-shape">
					<?php LF_Utils::display_responsive_images( 90407, 'full', '1000px', null, 'lazy', 'Hero' ); ?>
				</figure>
				<figure class="hero__bg-gradient"></figure>
			</div>
		</section>

		<!-- Navigation  -->
		<section style="position: relative;">
			<div class="nav-el">

				<div class="nav-el__box">
					<a href="#attendees"
						title="Jump to Attendee Overview section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
<?php LF_Utils::get_svg( $report_folder . 'nav-icon-graph-up.svg', true ); ?>
" alt="Bar chart icon">参加者の概要
				</div>

				<div class="nav-el__box">
					<a href="#content" title="Jump to Content section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
<?php LF_Utils::get_svg( $report_folder . 'nav-icon-movie.svg', true ); ?>
" alt="Movie icon">コンテンツ
				</div>

				<div class="nav-el__box">
					<a href="#colocated" title="Jump to Co-located Events"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
<?php LF_Utils::get_svg( $report_folder . 'nav-icon-location.svg', true ); ?>
" alt="Map pin icon">同時開催のイベント
				</div>

				<div class="nav-el__box">
					<a href="#security" title="Jump to Security section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
<?php LF_Utils::get_svg( $report_folder . 'nav-icon-lock.svg', true ); ?>
" alt="Lock icon">
					セキュリティ
				</div>

				<div class="nav-el__box">
					<a href="#sustainability"
						title="Jump to Sustainability section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
<?php LF_Utils::get_svg( $report_folder . 'nav-icon-leaf.svg', true ); ?>
" alt="Leaf icon">
					持続可能性
				</div>

				<div class="nav-el__box">
					<a href="#media" title="Jump to Media Coverage section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36"
						src="<?php LF_Utils::get_svg( $report_folder . 'nav-icon-megaphone.svg', true ); ?>"
						alt="Megaphone icon">
					メディア掲載
				</div>
			</div>
		</section>

		<!-- Intro  -->
		<section class="section-01">

			<div class="lf-grid">
				<h2 class="section-01__title">アムステルダムでの素晴らしい1週間でした！
				</h2>
			</div>

			<div class="lf-grid section-01__grid">
				<div class="section-01__grid-col1">
					<p><strong>今回のKubeCon + CloudNativeConは、10,500人以上、バーチャルでは6,000人以上の方にご参加いただき、ヨーロッパ最大のベンダー ニュートラルなオープンソース カンファレンスとなりました。DataCenter-InsiderのUlrike Ostler記者は「<a href="https://www.datacenter-insider.de/neue-aufgaben-fuer-die-cncf-community-a-09b9e28ca42f08cb2414a304c4e91a5e/">クラウドネイティブの人気は衰えることを知らない</a>」と書きましたが、#TeamCloudNativeも同意見で、皆さんはこのイベントを5点満点中4点と評価しました！</strong></p>

					<p>数はさておき、現地開催イベントは私たちのコミュニティとクラウドネイティブ エコシステムにとって非常に重要です。KubeCon + CloudNativeConが巻き起こすリアルタイムのインタラクティブは、一貫して私たちのプロジェクトをレベルアップし、ソフトウェアを構築して提供する方法を変え続けるコラボレーションを呼び起こします。実際、参加者は、アムステルダムで私たちに参加した理由の上位2つはネットワークとブレイクアウト セッションだったと述べています。私たちがベンダー ニュートラルなエンゲージメントのための歓迎の場を提供することで、誰もが恩恵を受けることができます。私たちは、<a href="https://www.lfasiallc.com/kubecon-cloudnativecon-open-source-summit-china/">KubeCon + CloudNativeCon China</a>や<a href="https://events.linuxfoundation.org/kubecon-cloudnativecon-north-america-2023/">North America</a>、大人気の<a href="https://community.cncf.io/events/#/list">Kubernetes Community Days</a>や地域の<a href="https://events.linuxfoundation.org/kubeday-israel/">KubeDays</a>などのイベントで、年間を通じてこれを続けていきます。</p>

					<p>アムステルダムでは、クラウドネイティブ テクノロジーをベースとしたビジネスの構築方法を示す新しいスタートアップ トラックの追加など、初めての試みなくしてKubeCon + CloudNativeConはあり得ませんでした。また、エコシステムのセキュリティ態勢に関するコラボレーションを強化するため、TAG Securityと共同でSecuirty Villageを開催しました。</p>

					<p>直接お会いできなかったのは残念でしたが、私自身の進化を皆さんと共有できたことは光栄でした。産休に入るにあたり、皆さんからの温かいサポートとお祝いの言葉に心が温かくなりました。近いうちに上海とシカゴでコミュニティと再会できることを楽しみにしています。また、私の小さな子供にも初めてのKubeCon + CloudNativeConを紹介できることを願っています。</p>

					<p>この驚異的な出来事から解き明かされることはたくさんあり、この透明性レポートをまとめるにあたり、振り返ることをとても楽しみました。この情報を貴重なものと感じていただければ幸いです。</p>

					<div class="author">
						<?php LF_Utils::display_responsive_images( 90396, 'full', '75px', '', 'lazy', 'Priyanka Sharma' ); ?>
						<p><strong>Priyanka Sharma</strong><br>
Executive Director, CNCF</p>
					</div>
				</div>

				<div class="section-01__grid-col2">

					<!-- Icon 1  -->
					<div class="icon-box-1">
						<div class="icon">
							<img loading="lazy" width="52" height="52" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-badge-p.svg', true ); ?>
" alt="Badge icon">
						</div>
						<div class="text">
							<span>51%</span><br />
							初参加者
						</div>
					</div>

					<!-- Icon 2  -->
					<div class="icon-box-1">
						<div class="icon">
							<img loading="lazy" width="45" height="40" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-heart-p.svg', true ); ?>
" alt="Heart icon">
						</div>
						<div class="text">
							<span>1,767</span><br />
							提出されたCFP
						</div>
					</div>

					<!-- Icon 3  -->
					<div class="icon-box-1">
						<div class="icon">
							<img loading="lazy" width="45" height="33" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-megaphone-p.svg', true ); ?>
" alt="Megaphone icon">
						</div>
						<div class="text">
							<span>4,202</span><br />
							メディア掲載の一部
						</div>
					</div>

					<!-- Icon 4  -->
					<div class="icon-box-1">
						<div class="icon">
							<img loading="lazy" width="34" height="45" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-person-p.svg', true ); ?>
" alt="People icon">
						</div>
						<div class="text">
							<span>1,622</span><br />
							Dan Kohn Scholarship Fundに<br class="show-over-1000">
							感謝の意を表する参加者
						</div>
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
						<h3 class="sub-header">アムステルダム ハイライト写真</h3>
					</div>
					<div class="wp-block-column is-vertically-aligned-bottom"
						style="flex-basis:20%">
						<p
							class="has-text-align-right is-style-link-cta"><a href="https://www.flickr.com/photos/143247548@N03/albums/72177720307596641" title="KubeCon + CloudNativeCon Europe 2023 Photo Gallery">続きを見る</a></p>
					</div>
				</div>

				<div class="section-02__slider">
					<div>
						<?php LF_Utils::display_responsive_images( 90399, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 90380, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 90381, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 90382, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 90383, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 90384, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 90385, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 90386, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 90387, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 90388, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 90389, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 90390, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 90391, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 90392, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 90393, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 90394, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 90400, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 90402, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 90403, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 90404, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon Europe 2023' ); ?>
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
						<span class="screen-reader-text">Previous Photo</span>
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

		<section id="attendees"
			class="section-03 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">参加者概要 
					</h2>
					<div class="section-number">1/8</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p
							class="opening-paragraph">私たちはこれまでで最大のEuropean KubeCon + CouldNativeConをアムステルダムで楽しみ、10,500人以上が参加しました。これは、私たちの2022年のヨーロッパのイベントから<strong>48%</strong>の現地参加者の増加です。</p>
					</div>
				</div>

				<p class="sub-header">人口統計</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<picture>
					<source media="(max-width: 499px)"
						srcset="<?php echo esc_url( wp_get_attachment_image_url( 90874, 'full', false ) ); ?>">
					<source media="(min-width: 500px)"
						srcset="<?php echo esc_url( wp_get_attachment_image_url( 90873, 'full', false ) ); ?>">
					<?php
					LF_Utils::display_responsive_images(
						90873,
						'full',
						'1200px',
						'svg-image',
						'lazy',
						'16,092 total registered attendees'
					);
					?>
				</picture>

				<div aria-hidden="true" class="report-spacer-120"></div>

				<p class="sub-header">参加者の地理分布</p>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<picture style="margin: auto;">
					<source media="(max-width: 499px)"
						srcset="<?php echo esc_url( wp_get_attachment_image_url( 90444, 'full', false ) ); ?>">
					<source media="(min-width: 500px)"
						srcset="<?php echo esc_url( wp_get_attachment_image_url( 90443, 'full', false ) ); ?>">
					<?php
					LF_Utils::display_responsive_images(
						90443,
						'full',
						'1200px',
						'svg-image section-03__map',
						'lazy',
						'Map of attendee geography'
					);
					?>
				</picture>

				<div class="section-03__no-answer">
					現地参加者の<strong>2％</strong>が無回答
				</div>
				<div class="section-03__attendees">
					<div class="legend__wrapper"><i
							class="legend__key legend__purple-700"></i>
						現地参加 ％
					</div>

					<div class="legend__wrapper"><i
							class="legend__key legend__pink-200"></i> バーチャル ％
					</div>

				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">参加国トップ</p>

				<div class="lf-grid section-03__top-countries">
					<div class="section-03__top-countries-col1">
						<p class="table-header">合計</p>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="52" height="52" src="<?php LF_Utils::get_svg( $report_folder . 'flag-germany.svg', true ); ?>
" alt="German Flag">
							</div>
							<div class="text">
								<span class="country">ドイツ</span><br />
								<span class="number">2,874</span>
							</div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="52" height="52" src="<?php LF_Utils::get_svg( $report_folder . 'flag-usa.svg', true ); ?>
" alt="USA Flag">
							</div>
							<div class="text">
								<span class="country">米国</span><br />
								<span class="number">1,955</span>
							</div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="52" height="52" src="<?php LF_Utils::get_svg( $report_folder . 'flag-netherlands.svg', true ); ?>
" alt="Netherlands Flag">
							</div>
							<div class="text">
								<span class="country">オランダ

								</span><br />
								<span class="number">1,673</span>
							</div>
						</div>

					</div>
					<div class="section-03__top-countries-col2">
						<p class="table-header">現地参加</p>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="52" height="52" src="<?php LF_Utils::get_svg( $report_folder . 'flag-germany.svg', true ); ?>
" alt="German Flag">
							</div>
							<div class="text">
								<span class="country">ドイツ</span><br />
								<span class="number">2,008</span>
							</div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="52" height="52" src="<?php LF_Utils::get_svg( $report_folder . 'flag-netherlands.svg', true ); ?>
" alt="Netherlands Flag">
							</div>
							<div class="text">
								<span class="country">オランダ</span><br />
								<span class="number">1,378&nbsp;</span>
							</div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="52" height="52" src="<?php LF_Utils::get_svg( $report_folder . 'flag-usa.svg', true ); ?>
" alt="USA Flag">
							</div>
							<div class="text">
								<span class="country">米国</span><br />
								<span class="number">1,377&nbsp;</span>
							</div>
						</div>

					</div>
					<div class="section-03__top-countries-col3">
						<p class="table-header">バーチャル</p>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="52" height="52" src="<?php LF_Utils::get_svg( $report_folder . 'flag-india.svg', true ); ?>
" alt="India Flag">
							</div>
							<div class="text">
								<span class="country">インド</span><br />
								<span class="number">925</span>
							</div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="52" height="52" src="<?php LF_Utils::get_svg( $report_folder . 'flag-germany.svg', true ); ?>
" alt="German Flag">
							</div>
							<div class="text">
								<span class="country">ドイツ</span><br />
								<span class="number">866</span>
							</div>
						</div>

						<!-- Icon 2 Start  -->
						<div class="icon-box-2">
							<div class="icon">
								<img loading="lazy" width="52" height="52" src="<?php LF_Utils::get_svg( $report_folder . 'flag-usa.svg', true ); ?>
" alt="USA Flag">
							</div>
							<div class="text">
								<span class="country">米国</span><br />
								<span class="number">578</span>
							</div>
						</div>

					</div>

				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

				<p class="sub-header is-centered">職務トップ3</p>

				<div class="lf-grid section-03__top-jobs">
					<div class="section-03__top-jobs-col1">
						<p class="table-header">DevOps / SRE / システム管理者</p>
						<span class="large">6,392</span>
					</div>
					<div class="section-03__top-jobs-col2">
						<p class="table-header">開発者</p>
						<span class="large">2,971</span>
					</div>
					<div class="section-03__top-jobs-col3">
						<p class="table-header">アーキテクト</p>

						<span class="large">2,419</span>
					</div>

				</div>

				<button class="button-reset section-03__button"
					data-id="js-hidden-section-trigger-open">
					全てのリストを見る
					<?php LF_Utils::get_svg( $report_folder . 'arrow-down.svg' ); ?>
				</button>

				<div class="section-03__hidden-section"
					data-id="js-hidden-section">

					<div class="section-03__hidden-section-content">
						<div class="lf-grid section-03__jobs">

							<div class="section-03__jobs-col1">

								<div class="kccnc-table-container">
									<table class="kccnc-table">
										<thead>
											<tr>
												<th>参加者の職務
												</th>
												<th>合計</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>アーキテクト</td>
												<td>2,419</td>
											</tr>
											<tr>
												<td>事業運営</td>
												<td>169</td>
											</tr>
											<tr>
												<td>開発者</td>
												<td>2,971</td>
											</tr>
											<tr>
												<td> - データ サイエンティスト</td>
												<td>136</td>
											</tr>
											<tr>
												<td> - フルスタック開発者</td>
												<td>2,306</td>
											</tr>
											<tr>
												<td> - 機械学習スペシャリスト</td>
												<td>86</td>
											</tr>
											<tr>
												<td> - ウェブ開発者</td>
												<td>418</td>
											</tr>
											<tr>
												<td> - モバイル開発者</td>
												<td>25</td>
											</tr>
											<tr>
												<td>DevOps / SRE / システム管理者</td>
												<td>6,392</td>
											</tr>
											<tr>
												<td>執行役員</td>
												<td>670</td>
											</tr>
											<tr>
												<td>IT運用</td>
												<td>493</td>
											</tr>
											<tr>
												<td> - DevOps</td>
												<td>205</td>
											</tr>
											<tr>
												<td> - システム管理者</td>
												<td>213</td>
											</tr>
											<tr>
												<td> - サイト信頼性エンジニア
												</td>
												<td>63</td>
											</tr>
											<tr>
												<td> - 品質保証エンジニア</td>
												<td>12</td>
											</tr>
											<tr>
												<td>営業 / マーケティング</td>
												<td>845</td>
											</tr>
											<tr>
												<td>メディア / アナリスト</td>
												<td>161</td>
											</tr>
											<tr>
												<td>学生</td>
												<td>482</td>
											</tr>
											<tr>
												<td>プロダクト マネージャー</td>
												<td>486</td>
											</tr>
											<tr>
												<td>教授 / アカデミック</td>
												<td>68</td>
											</tr>
											<tr>
												<td>その他</td>
												<td>911</td>
											</tr>
										</tbody>
									</table>
								</div>


							</div>
							<div class="section-03__jobs-col2">

								<div class="kccnc-table-container">
									<table class="kccnc-table">
										<thead>
											<tr>
												<th>参加者の業界
												</th>
												<th>合計</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>自動車</td>
												<td>468</td>
											</tr>
											<tr>
												<td>消費者製品</td>
												<td>481</td>
											</tr>
											<tr>
												<td>エネルギー</td>
												<td>242</td>
											</tr>
											<tr>
												<td>金融</td>
												<td>1,521</td>
											</tr>
											<tr>
												<td>ヘルスケア</td>
												<td>203</td>
											</tr>
											<tr>
												<td>工業</td>
												<td>253</td>
											</tr>
											<tr>
												<td>情報技術</td>
												<td>10,789</td>
											</tr>
											<tr>
												<td>資材</td>
												<td>44</td>
											</tr>
											<tr>
												<td>非営利組織</td>
												<td>382</td>
											</tr>
											<tr>
												<td>プロフェッショナル サービス</td>
												<td>698</td>
											</tr>
											<tr>
												<td>電気通信事業</td>
												<td>595</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>

						</div>
					</div>

				</div>

				<button
					class="button-reset section-03__button section-03__button-close"
					style="display: none;"
					data-id="js-hidden-section-trigger-close">
					<?php LF_Utils::get_svg( $report_folder . 'arrow-up.svg' ); ?>
					リストを閉じる
				</button>

				<div aria-hidden="true" class="report-spacer-120"></div>

			</div>
		</section>

		<section class="section-04 alignfull background-image-wrapper">

			<figure class="background-image-figure darken-on-mobile">
				<?php LF_Utils::display_responsive_images( 90395, 'full', '1200px', null, 'lazy', 'Audience at Kubecon + CloudNativeCon Europe 2023' ); ?>
			</figure>

			<div class="background-image-text-overlay">
				<div class="container wrap">

					<div class="quote-with-name-container">
						<p
							class="quote-with-name-container__quote">Cloud Nativeの人気はとどまるところを知らず、昨年開催されたバレンシアでは約7,000人の来場者があったのに対し、今年は10,000人を超える来場者で賑わいました。</p>
						<div class="quote-with-name-container__marks">
							<p
								class="quote-with-name-container__name">Ulrike Ostler</p>
							<p
								class="quote-with-name-container__position">DataCenter-Insider</p>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="section-05">

			<p class="sub-header">前年比成長率 - ヨーロッパのイベント</p>

			<div class="section-05__yoy">
				<div class="legend__wrapper"><i
						class="legend__key legend__blue-700"></i>
					現地参加
				</div>

				<div class="legend__wrapper"><i
						class="legend__key legend__blue-200"></i>
					バーチャル
				</div>
			</div>

			<div aria-hidden="true" class="report-spacer-40"></div>

			<div class="lf-grid section-05__chart">
				<div class="section-05__chart-col1">
					<img loading="lazy" width="800" height="480" src="
			<?php LF_Utils::get_svg( $report_folder . 'yoy-growth-european-events.svg', true ); ?>
			" alt="Chart showing year on year attendee growth">
				</div>

				<div class="section-05__chart-col2">
					<div class="section-05__chart-key">
						<img loading="lazy" width="290" height="90"
							src="
						<?php LF_Utils::get_svg( $report_folder . 'yoy-growth-increase.svg', true ); ?>"
							class="section-05__chart-key-image"
							alt="48% increase">

						<div class="thin-hr section-05__chart-key-hr"></div>

						<p
							class="section-05__chart-key-text">バレンシアで開催されたKubeCon + CloudNativeCon 2022と比較すると、アムステルダムで開催されたイベントでは現地参加者は48%増加しました。</p>

						<div class="wp-block-button"><a
								href="https://www.kubecon.io"
								class="wp-block-button__link">次回のKUBECON + CLOUDNATIVE CONに参加</a>
						</div>

					</div>

				</div>
			</div>

			<div class="shadow-hr"></div>

			<div class="kccnc-table-container">
				<table class="kccnc-table growth-table">
					<thead>
						<tr>
							<th>チケットの種類
							</th>
							<th>2017
								<span>ベルリン</span>
							</th>
							<th>2018
								<span>コペンハーゲン</span>
							</th>
							<th>2019
								<span>バルセロナ</span>
							</th>
							<th>2020
								<span>バーチャル</span>
							</th>
							<th>2021
								<span>バーチャル</span>
							</th>
							<th>2022
								<span>バレンシア</span>
							</th>
							<th>2023
								<span>アムステルダム</span>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>合計</td>
							<td>1,535</td>
							<td>4,300</td>
							<td>7,700</td>
							<td>18,682</td>
							<td>26,648</td>
							<td>18,550</td>
							<td>16,092</td>
						</tr>
						<tr>
							<td class="nowrap">企業での現地参加</td>
							<td>58%</td>
							<td>62%</td>
							<td>63%</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>19%</td>
							<td>33%</td>
						</tr>
						<tr>
							<td class="nowrap">個人での現地参加
							</td>
							<td>12%</td>
							<td>10%</td>
							<td>13%</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>7%</td>
							<td>13%</td>
						</tr>
						<tr>
							<td>全てのバーチャル参加</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>71%</td>
							<td>67%</td>
							<td>50%</td>
							<td>27%</td>
						</tr>
						<tr>
							<td>バーチャル基調講演＋Solusions Showcaseのみ参加</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>20%</td>
							<td>27%</td>
							<td>8%</td>
							<td>8%</td>
						</tr>
						<tr>
							<td>スピーカー</td>
							<td>9%</td>
							<td>8%</td>
							<td>6%</td>
							<td>2%</td>
							<td>1%</td>
							<td>3%</td>
							<td>4%</td>
						</tr>
						<tr>
							<td>スポンサー</td>
							<td>17%</td>
							<td>16%</td>
							<td>14%</td>
							<td>6%</td>
							<td>5%</td>
							<td>12%</td>
							<td>13%</td>
						</tr>
						<tr>
							<td>メディア</td>
							<td>2%</td>
							<td>2%</td>
							<td>1%</td>
							<td>&lt;1%</td>
							<td>0.6%</td>
							<td>1%</td>
							<td>1%</td>
						</tr>
						<tr>
							<td>アカデミック</td>
							<td>2%</td>
							<td>3%</td>
							<td>3%</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>1%</td>
							<td>2%</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="shadow-hr"></div>

			<p class="sub-header">多様性、公平性、包括性</p>
			<div aria-hidden="true" class="report-spacer-60"></div>
			<div class="lf-grid">
				<div class="dei__intro">
					<p>CNCFは、性別、性自認、性的指向、障害、人種、民族、年齢、宗教、または経済的ステータスに関係なく、KubeCon + CloudNativeConに参加するすべての人が歓迎されていると感じられるように努めています。<br><br>友好的、歓迎的、包括的な環境を育成するためのコミットメントは、イベントで提供する施設やリソースにも及びます。アムステルダムでは、以下のようなものがありました：</p>
				</div>
			</div>
			<div aria-hidden="true" class="report-spacer-60"></div>
			<div class="lf-grid dei__commitments">
				<div class="dei__commitments-col1">
					<div class="icon-box-5">
						<div class="icon-box-5__icon"><img loading="lazy"
								width="100" height="100"
								src="<?php LF_Utils::get_svg( $report_folder . 'icon-prayer.svg', true ); ?>"
								alt="Prayer icon">
						</div>
						<div class="icon-box-5__text">祈りの部屋</div>
					</div>
					<div class="icon-box-5">
						<div class="icon-box-5__icon"><img loading="lazy"
								width="100" height="100"
								src="<?php LF_Utils::get_svg( $report_folder . 'icon-sticky-note.svg', true ); ?>"
								alt="Sticky note icon">
						</div>
						<div class="icon-box-5__text">代名詞＆コミュニケーション ステッカー</div>
					</div>
					<div class="icon-box-5">
						<div class="icon-box-5__icon"><img loading="lazy"
								width="100" height="100"
								src="<?php LF_Utils::get_svg( $report_folder . 'icon-child-care.svg', true ); ?>"
								alt="Child Care icon">
						</div>
						<div class="icon-box-5__text">会場での無料託児所</div>
					</div>
				</div>
				<div class="dei__commitments-col2">
					<div class="icon-box-5">
						<div class="icon-box-5__icon"><img loading="lazy"
								width="100" height="100"
								src="<?php LF_Utils::get_svg( $report_folder . 'icon-mixed-gender.svg', true ); ?>"
								alt="Mixed gender icon">
						</div>
						<div class="icon-box-5__text">オール ジェンダー トイレ</div>
					</div>
					<div class="icon-box-5">
						<div class="icon-box-5__icon"><img loading="lazy"
								width="100" height="100"
								src="<?php LF_Utils::get_svg( $report_folder . 'icon-pacifier.svg', true ); ?>"
								alt="Pacifier icon">
						</div>
						<div class="icon-box-5__text">ベビーケア＆授乳室
						</div>
					</div>
				</div>
				<div class="dei__commitments-col3">
					<div class="icon-box-5">
						<div class="icon-box-5__icon"><img loading="lazy"
								width="100" height="100"
								src="<?php LF_Utils::get_svg( $report_folder . 'icon-mute.svg', true ); ?>"
								alt="Mute icon">
						</div>
						<div class="icon-box-5__text">静かな部屋</div>
					</div>
					<div class="icon-box-5">
						<div class="icon-box-5__icon"><img loading="lazy"
								width="100" height="100"
								src="<?php LF_Utils::get_svg( $report_folder . 'icon-closed-captions.svg', true ); ?>"
								alt="Closed Captions icon">
						</div>
						<div class="icon-box-5__text">Wordlyを利用した20以上の言語による全出席者への字幕サービス
						</div>
					</div>
				</div>
			</div>

			<div aria-hidden="true" class="report-spacer-60"></div>

			<div class="lf-grid">
				<div class="dei__intro">
					<p>多様性、公平性、包括性に対する当社の深いコミットメントの一環として、当社では、テック業界におけるビジネス チャンスに個人をつなげるために、以下のような人気の高い会場でのイベントを数多く開催しました：</p>
					<ul>
						<li>EmpowerUs Breakfast</li>
						<li>Diversity Lunch</li>
						<li>Peer Group Networking</li>
					</ul>
				</div>
			</div>

			<div class="shadow-hr"></div>

			<div class="lf-grid">
				<div class="dei__col-1">
					<p class="sub-header">Gold CHAOSS D&I イベント バッジ</p>
					<div aria-hidden="true" class="report-spacer-40"></div>
					<?php LF_Utils::display_responsive_images( 90434, 'full', '320px', 'svg-image badge', 'lazy', 'Gold CHAOSS D&I Event Badge' ); ?>
					<div aria-hidden="true" class="report-spacer-40"></div>
					<p>オープンソース コミュニティにおける健全なD&Iの実践を促進するイベントに授与されます。</p>
				</div>
				<div class="dei__col-2">
					<div class="kccnc-table-container">
						<table class="kccnc-table dei__table">
							<thead>
								<tr>
									<th>多様性、公平性、包摂性に関するイベントとメンタリング
									</th>
									<th>合計</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Diversity Lunch参加者</td>
									<td>125</td>
								</tr>
								<tr>
									<td>EmpowerUs参加者</td>
									<td>50</td>
								</tr>
								<tr>
									<td>Peer Group Mentoring + Career Networking
										<strong>メンター</strong>
									</td>
									<td>8</td>
								</tr>
								<tr>
									<td>Peer Group Mentoring + Career Networking
										<strong>メンティー</strong>
									</td>
									<td>42</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div aria-hidden="true" class="report-spacer-120"></div>

			<p
				class="sub-header has-lines">次回のKubecon + CloudNativeCon</p>

			<div aria-hidden="true" class="report-spacer-80"></div>

			<?php
			echo do_shortcode( '[event_banner hide_title=true]' );
			?>
		</section>

		<section id="content"
			class="section-06 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">目次</h2>
					<div class="section-number">2/8</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p
							class="opening-paragraph">KubeCon + CloudNativeCon Europeでは、300を超えるセッションが行われ、入門的なセッションから技術的な深掘りまで、多様なトピックがラインナップされました。講演の模様は<a href="https://www.youtube.com/playlist?list=PLj6h78yzYM2PyrvCoOii4rAopBswfz1p7">YouTubeのプレイリスト</a>で視聴可能です。</p>
					</div>
				</div>

				<div class="kccnc-table-container">
					<table class="kccnc-table">
						<thead>
							<tr>
								<th>セッション</th>
								<th>合計</th>
								<th><span class="nowrap">現地参加</span></th>
								<th>バーチャル</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>基調講演（スポンサー基調講演を含む）</td>
								<td>22</td>
								<td>22</td>
								<td>0</td>
							</tr>
							<tr>
								<td>全セッション（CFP＆メンテナー）</td>
								<td>308</td>
								<td>287</td>
								<td>21</td>
							</tr>
							<tr>
								<td> - ブレイクアウト セッション</td>
								<td>210</td>
								<td>198</td>
								<td>12</td>
							</tr>
							<tr>
								<td> - メンテナー セッション</td>
								<td>98</td>
								<td>89</td>
								<td>9</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<p
					class="sub-header">KubeCon + CloudNativeCon Europe 2023 co-chairsの皆様、ありがとうございました。</p>

				<div class="lf-grid chairs">
					<div class="chairs__col1">
						<?php LF_Utils::display_responsive_images( 90376, 'full', '200px', 'chairs__image', 'lazy', 'Aparna Subramanian' ); ?>
						<p>
<span class="chairs__name">Aparna Subramanian
</span><span
	class="chairs__title">Shopify <br/>
Director of Production Engineering</span>
</p>
					</div>
					<div class="chairs__col2">
						<?php LF_Utils::display_responsive_images( 90378, 'full', '200px', 'chairs__image', 'lazy', 'Emily Fox' ); ?>
						<p>
<span class="chairs__name">Emily Fox</span><span
class="chairs__title">Apple <br/>
Security Engineer</span></p>
					</div>
					<div class="chairs__col3">
						<?php LF_Utils::display_responsive_images( 90379, 'full', '200px', 'chairs__image', 'lazy', 'Frederick Kautz' ); ?>
						<p>
<span class="chairs__name">Frederick Kautz</span><span
class="chairs__title"></span>Computing Engineer Infra and <br/>
Security Enterprise Architect</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-40"></div>
			</div>
		</section>
		<div class="shadow-hr"></div>

		<section class="section-07 alignfull">
			<div class="container wrap">

				<div aria-hidden="true" class="report-spacer-40"></div>

				<h2 class="section-header">コンテンツの<br />内訳</h2>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<div class="lf-grid">
					<div class="restrictive-10-col">
						<p>カンファレンスのスケジュールは、ShopifyのAparna Subramanian氏、AppleのEmily Fox氏、独立系コンサルタントのFrederick Kautz氏がco-chairを務め、プロジェクト メンテナー、アクティブ コミュニティ メンバー、過去のイベントで評価の高かったプレゼンターなど、専門家やトラック チェアからなるプログラム委員会を率いて作成されました。<br><br>
講演は、プログラム委員会により厳正かつ偏りのないプロセスで選出されます。プログラム委員会は、それぞれの専門分野で審査する講演をランダムに割り当てます。詳細は、<a href="https://events.linuxfoundation.org/kubecon-cloudnativecon-europe/program/scoring-guidelines/#general-info">CFP採点ガイドライン</a>、特に<a href="https://www.cncf.io/blog/2021/03/08/a-look-inside-the-kubecon-cloudnativecon-schedule-selection-process/">ヨーロッパ選考プロセス</a>をご覧ください。<br><br>
KubeCon + CloudNativeCon Europeでは、632社、2672名の講演者から1767件の応募がありました。そのうち186件、347名の講演を受け入れることができました。詳しくは<a href="https://www.cncf.io/blog/2023/02/08/inside-the-numbers-the-kubecon-cloudnativecon-selection-process-for-europe-2023/">こちらの発表ブログ</a>をご覧ください。<br><br>
さらに、CFPのプロセスにはなかったメンテナー セッションを運営する209人のメンテナー スピーカーから話を聞きました。</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="sub-header">主な統計</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-07__content-breakdown">

					<div class="section-07__content-breakdown-col1">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="64" height="64" src="<?php LF_Utils::get_svg( $report_folder . 'icon-inbox-b.svg', true ); ?>
" alt="Bell icon">
							</div>
							<div class="text">
								<span class="number">1,767</span><br />
								<span class="description">CFP提出書類</span>
							</div>
						</div>
						<!-- End of Icon Box 3 -->
					</div>
					<div class="section-07__content-breakdown-col2">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="64" height="64" src="<?php LF_Utils::get_svg( $report_folder . 'icon-microphone-b.svg', true ); ?>
" alt="Bell icon">
							</div>
							<div class="text">
								<span class="number">556</span><br />
								<span class="description">スピーカー</span>

							</div>
						</div>
						<!-- End of Icon Box 3 -->
					</div>
					<div class="section-07__content-breakdown-col3">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="64" height="64" src="<?php LF_Utils::get_svg( $report_folder . 'icon-person-b.svg', true ); ?>
" alt="Bell icon">
							</div>
							<div class="text">
								<span class="number">273</span><br />
								<span class="description">今回が初回となるスピーカー</span>
							</div>
						</div>
						<!-- End of Icon Box 3 -->
					</div>
				</div>
				<div aria-hidden="true" class="report-spacer-40"></div>
			</div>
		</section>
		<div class="shadow-hr"></div>

		<section class="section-08 alignfull">
			<div class="container wrap">

				<div aria-hidden="true" class="report-spacer-40"></div>

				<h2 class="section-header">スピーカーの多様性</h2>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<p>CNCFは、講演者の性別と多様性の平等に関するガイドラインを実施しています。</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="kccnc-table-container">
					<table class="kccnc-table">
						<thead>
							<tr>
								<th>多様性
								</th>
								<th>総合</th>
								<th>パーセント</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>スピーカー - 女性＋ジェンダー ノンコンフォーミング（基調講演）</td>
								<td>9</td>
								<td>41%</td>
							</tr>
							<tr>
								<td>スピーカー - 男性（ブレイクアウト セッション）</td>
								<td>245</td>
								<td>73%</td>
							</tr>
							<tr>
								<td>スピーカー：女性＋ジェンダー ノンコンフォーミング（ブレイクアウト セッション）</td>
								<td>90</td>
								<td>27%</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="section-header">Startup Track</h2>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>今年のKubeCon + CloudNativeCon Europeの新企画は、Startup Trackです。<a href="https://www.cncf.io/people/governing-board/?p=liz-rice">Liz Rice</a>のアイデアにインスパイアされたStartup Trackは、<a href="https://www.linkedin.com/feed/hashtag/teamcloudnative">#TeamCloudNative</a>の一員として、オープンソースとクラウドネイティブ テクノロジーをベースにしたビジネスの構築方法を紹介します。<br><br><strong>クラウドネイティブのベテランによる2つの講演が行われました：</strong></p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="shadow-outline-box">
					<div>
						<p class="sub-header">地域社会からお客様へ</p>

						<p
							class="shadow-outline-box__by">Google Cloud社Distinguished Engineer Kelsey Hightower氏</p>

						<p>オープンソース プロジェクトを中心としたビジネス構築に関するオープン ディスカッションにおいて、Kelsey氏は、Puppet Labs、CoreOS、Google、そしてクラウドネイティブ分野で最も成功したオープンソース プロジェクトの背後にあるスタートアップ企業への助言から学んだことを共有した。</p>
					</div>

					<div class="shadow-outline-box__video">
						<div class="wp-block-lf-youtube-lite">
							<lite-youtube videoid="eb0442K_zmY"
								videotitle="From Community to Customers"
								webpStatus="1" sdthumbStatus="0" title="Play">
							</lite-youtube>
						</div>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<div class="shadow-outline-box">
					<div>
						<p
							class="sub-header">クラウドネイティブで<br class="show-over-1000">ビジネスを成功させるために</p>

						<p
							class="shadow-outline-box__by">Isovalent社Chief Open Source Officer Liz Rice氏; Google Cloud社Distinguished Engineer Kelsey Hightower氏; Vercel社CEO and Founder Guillermo Rauch氏; Acorn Labs社Cofounder and CEO Sheng Liang氏;Kasten by Veeam社VP Engineering Tom Manville氏</p>

						<p>このパネル ディスカッションでは、スタートアップ企業や小規模ベンダーがクラウドネイティブ エコシステムで成功するために、オープンソース プロジェクトにコントリビュートすることがビジネスにどのように役立つか、ベンダーがオープンソースを中心としたコミュニティに自社製品をアピールする方法、クラウドネイティブ ビジネス環境が従来の市場とどのように異なるか、などについて議論しました。</p>
					</div>

					<div class="shadow-outline-box__video">
						<div class="wp-block-lf-youtube-lite">
							<lite-youtube videoid="XFtrxLiUjKw"
								videotitle="Building a Successful Business in Cloud Native"
								webpStatus="1" sdthumbStatus="0" title="Play">
							</lite-youtube>
						</div>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<div class="quote-with-name-container">
					<p
						class="quote-with-name-container__quote">52,000人以上のコミュニティ グループ メンバー、406のグループ チャプター、24のKubernetesコミュニティ デーがあり、関心が高いことは明らかです。また、私がCIOと交わした会話によると、クラウドネイティブの近代化は、多くの組織にとって最優先事項とは言わないまでも、最重要課題となっています。</p>
					<div class="quote-with-name-container__marks">
						<p
							class="quote-with-name-container__name">Paul Nashawaty</p>
						<p
							class="quote-with-name-container__position">TechTarget</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>
			</div>
		</section>

		<section id="colocated"
			class="section-09 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">共同開催イベント</h2>
					<div class="section-number">3/8</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-10-col">
						<p
							class="opening-paragraph">CNCFが主催する併催イベントには、観測可能性、ウェブアセンブリ、通信、エッジなどのトピックを扱う業界のエキスパートが参加します。今年は新たなアプローチとして、参加者がCNCF主催のどの併催イベントにも参加でき、複数のイベントを行き来することもできるオールアクセス パスを提供しました。</p>
					</div>
				</div>

				<h2 class="section-header">人口統計</h2>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<div class="lf-grid section-09__demographics">
					<div class="section-09__demographics-col1">
						<p class="sub-header">ジェンダー別参加者数</p>
						<div aria-hidden="true" class="report-spacer-60"></div>
						<div class="lf-grid sub-grid">
							<div class="sub-grid__col1">
								<p>男性</p>
								<img src="<?php LF_Utils::get_svg( $report_folder . 'icon-male.svg', true ); ?>"
									width="60" height="70" alt="Icon Male"
									loading="lazy">
								<h3 class="large">50%</h3>
							</div>
							<div class="sub-grid__col2">
								<p>女性</p>
								<img src="<?php LF_Utils::get_svg( $report_folder . 'icon-female.svg', true ); ?>"
									width="60" height="70" alt="Icon Woman"
									loading="lazy">
								<h3 class="large">8%</h3>
							</div>
							<div class="sub-grid__col3">
								<p>ノンバイナリー<br>/ その他</p>
								<img src="<?php LF_Utils::get_svg( $report_folder . 'icon-non-binary.svg', true ); ?>"
									width="60" height="70"
									alt="Icon Non-Gender Specific"
									loading="lazy">
								<h3 class="large">1%</h3>
							</div>
						</div>
						<p
							class="section-09__demographics-note"><span style="color: #EA62A5;">41％</span>回答なし</p>
					</div>
					<div class="section-09__demographics-col2">
						<p
							class="sub-header">上位3カ国</p>
						<div aria-hidden="true" class="report-spacer-60"></div>
						<div class="lf-grid sub-grid">
							<div class="sub-grid__col1">
								<p>ドイツ<br>&nbsp;</p>
								<img src="<?php LF_Utils::get_svg( $report_folder . 'flag-germany.svg', true ); ?>"
									width="70" height="70" alt="Icon Germany"
									loading="lazy">
								<h3 class="large">19%</h3>
							</div>
							<div class="sub-grid__col2">
								<p>米国<br>&nbsp;</p>
								<img src="<?php LF_Utils::get_svg( $report_folder . 'flag-usa.svg', true ); ?>"
									width="70" height="70" alt="Icon USA"
									loading="lazy">
								<h3 class="large">15%</h3>
							</div>
							<div class="sub-grid__col3">
								<p>オランダ<br>&nbsp;</p>
								<img src="<?php LF_Utils::get_svg( $report_folder . 'flag-netherlands.svg', true ); ?>"
									width="70" height="70"
									alt="Icon Netherlands" loading="lazy">
								<h3 class="large">9%</h3>
							</div>
						</div>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<div class="lf-grid section-09__demographics">
					<div class="section-09__demographics-col1">
						<p class="sub-header">役職トップ3</p>
						<div aria-hidden="true" class="report-spacer-60"></div>
						<div class="lf-grid sub-grid">
							<div class="sub-grid__col1">
								<p>DevOps / SRE /<br> システム管理者</p>
								<h3 class="large purple">41%</h3>
							</div>
							<div class="sub-grid__col2">
								<p>開発者<br>&nbsp;</p>
								<h3 class="large purple">19%</h3>
							</div>
							<div class="sub-grid__col3">
								<p>アーキテクト<br>&nbsp;</p>
								<h3 class="large purple">16%</h3>
							</div>
						</div>
					</div>
					<div class="section-09__demographics-col2">
						<p class="sub-header">スポンサー</p>
						<div aria-hidden="true" class="report-spacer-60"></div>
						<div class="lf-grid sub-grid">
							<div class="sub-grid__col1 two-cols">
								<p>オンサイト リード合計<br>&nbsp;</p>
								<h3 class="large purple">2,315</h3>
							</div>
							<div class="sub-grid__col2 two-cols">
								<p>スポンサーごとの<br>平均オンサイト リード数</p>
								<h3 class="large purple">178</h3>
								<p
									class="note">2022年比<span style="color: #763FAB;">119％</span>増</p>
							</div>
						</div>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<?php LF_Utils::display_responsive_images( 90487, 'full', '600px', 'section-09__banner', 'lazy', '3,650 people Registered for Co-Located Events - the largest audience ever' ); ?>

				<div class="shadow-hr"></div>

				<h2 class="section-header">レポート</h2>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<p>セッションの録画は、<a href="https://www.youtube.com/@cncf/playlists">共催イベントのウェブページ</a>からご覧いただけます。</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="masonry-grid">
					<?php LF_Utils::display_responsive_images( 90895, 'full', '400px', 'masonry-item', 'lazy', 'Stats for Argo co-located event' ); ?>

					<?php LF_Utils::display_responsive_images( 90896, 'full', '400px', 'masonry-item', 'lazy', 'Stats for CiliumCon co-located event' ); ?>

					<?php LF_Utils::display_responsive_images( 90897, 'full', '400px', 'masonry-item', 'lazy', 'Stats for Cloud Native Telco Day co-located event' ); ?>

					<?php LF_Utils::display_responsive_images( 90898, 'full', '400px', 'masonry-item', 'lazy', 'Stats for Cloud Native WASM Day  co-located event' ); ?>

					<?php LF_Utils::display_responsive_images( 90899, 'full', '400px', 'masonry-item', 'lazy', 'Stats for ISTIO Day Europe co-located event' ); ?>

					<?php LF_Utils::display_responsive_images( 90900, 'full', '400px', 'masonry-item', 'lazy', 'Stats for Kubernetes Batch + HPC Day Europe co-located event' ); ?>

					<?php LF_Utils::display_responsive_images( 90901, 'full', '400px', 'masonry-item', 'lazy', 'Stats for Observability Day co-located event' ); ?>

					<?php LF_Utils::display_responsive_images( 90902, 'full', '400px', 'masonry-item', 'lazy', 'Stats for Kubernetes on Edge Day co-located event' ); ?>

					<?php LF_Utils::display_responsive_images( 90903, 'full', '400px', 'masonry-item', 'lazy', 'Stats for Linkerd Day Europe co-located event' ); ?>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

			</div>
		</section>

		<section class="section-10 alignfull background-image-wrapper">

			<figure class="background-image-figure">
				<?php LF_Utils::display_responsive_images( 90377, 'full', '1200px', 'section-10__image', 'lazy', 'Speaker at a colocated event' ); ?>
			</figure>

			<div class="background-image-text-overlay">
				<div class="container wrap">

					<div aria-hidden="true" class="report-spacer-120"></div>

					<div class="section-10__container">

						<h2 class="section-10__title">今後のKubeCon + CloudNativeConsとの併催イベントの開催についてご興味がおありですか？6月末に利用可能なパッケージを始動します。</h2>
					</div>

					<div aria-hidden="true" class="report-spacer-120"></div>

				</div>
			</div>
		</section>

		<section id="security"
			class="section-11 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">セキュリティ</h2>
					<div class="section-number">4/8</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-10-col">
						<p
							class="opening-paragraph">セキュリティは人の力であり、知識豊富でベンダーに依存しないコミュニティとしてコラボレートし、セキュリティ態勢を向上させるツールやプロセスを開発することは、私たち全員にメリットがあります。</p>
					</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-8-col">
						<p>KubeCon + CloudNativeCon Europeでは、セキュリティが重要な焦点となり、セキュリティ問題に取り組むためのコラボレーションを促進する新しいイニシアチブが数多く開催されました。</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<div class="quote-with-name-container">
					<p
						class="quote-with-name-container__quote">クラウドネイティブ テクノロジーの標準化、ロックダウン、セキュア化、そしてますます包括的なスタンダードとプロトコルの構築へと私たちが本当に進んでいるのであれば、ソフトウェア アプリケーション開発においてより持続可能であること、そしてソフトウェアが使用する地球のリソースの量という点においてもより持続可能であることに、私たちは目を向けることができるはずです。</p>
					<div class="quote-with-name-container__marks">
						<p
							class="quote-with-name-container__name">Adrian Bridgwater</p>
						<p
							class="quote-with-name-container__position">Forbes</p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">SECURITY VILLAGE</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-8-col">
						<p>Kubernetesとクラウドネイティブのエコシステムにおける最新のセキュリティ プラクティスとツールについて、参加者が学び、共有し、コラボレーションするための専用スペースである<a href="https://tag-security.cncf.io/blog/security-village-at-kubecon-eu/">Security Village</a>では、<a href="https://kccnceu2023.sched.com/type/Security+%2B+Identity/TAG+Security+Recommended">一連の講演</a>、セキュリティ関連のディスカッションのためのオープンスペース、午後のアンカンファレンスが毎日開催されました。</p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">SECURITY TAGアンカンファレンス</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-8-col">
						<p>Security TAG(Technical Advisory Group)は<a href="https://en.wikipedia.org/wiki/Unconference">毎日午後にアンカンファレンス</a>を開催し、ソフトウェア サプライチェーンのセキュア化からゼロトラスト セキュリティの実装、クラウドネイティブ インフラやアプリケーションのセキュリティ マネージャー、セキュリティ ファースト文化の構築まで、セキュリティに関する様々なトピックを取り上げました。<br><br>毎朝、参加者はその日の午後のアンカンファレンス セッションのトピックを提出し、業界の専門家、実務家、参加者仲間から回答を得ることができます。</p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">セキュリティ監査の発表</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>KubeCon + CloudNativeCon Europeで、1.24リリースに基づく<a href="https://research.nccgroup.com/2023/04/17/public-report-kubernetes-1-24-security-audit/">最新のKubernetesサードパーティ監査</a>を発表することができました。<br><br>このセキュリティレビューのゴールは、プロジェクトのアーキテクチャとコードベースにおいて、Kubernetesユーザーのセキュリティに悪影響を及ぼす可能性のある問題を特定することでした。<br><br>この監査はCNCFがスポンサーとなり、<a href="https://github.com/kubernetes/sig-security/issues/13">Kubernetes SIG Security Third Party Audit Working Group</a>の協力を得て、<a href="https://www.nccgroup.com/">NCC Group</a>が2022年の夏に実施しました。</p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">GRADUATEDプロジェクトのためのSLSA</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>CNCFのGraduatedプロジェクトとIncubatingプロジェクトのセキュリティを改善する取り組みを継続するために、私たちは<a href="https://www.chainguard.dev/">Chainguard</a>と協力して、2つの卒業プロジェクトのソフトウェア サプライチェーン セキュリティの実践を評価しました：ArgoとPrometheusです。</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<div class="lf-grid slsa">
					<div class="slsa__box">
						<a
							href="https://github.com/argoproj/argoproj/blob/master/docs/software_supply_chain_slsa_assessment_chainguard_2023.pdf">
							<p
								class="slsa__title">ARGO SLSA<br>評価レポート</p>
							<div class="slsa__image-wrapper">
								<?php LF_Utils::display_responsive_images( 90441, 'full', '600px', 'slsa__image svg-image', 'lazy', 'Logo of Argo' ); ?>
							</div>
						</a>
					</div>

					<div class="slsa__box">
						<a
							href="https://prometheus.io/docs/operating/security/#external-audits">
							<p
								class="slsa__title">PROMETHEUS SLSA<br>評価レポート</p>
							<div class="slsa__image-wrapper">
								<?php LF_Utils::display_responsive_images( 90442, 'full', '600px', 'slsa__image svg-image', 'lazy', 'Logo of Prometheus' ); ?>
							</div>
						</a>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>この評価は、ソフトウェア サプライチェーンの完全性のフレームワークを提供する <a href="https://slsa.dev/">Supply-chain Levels for Software Artifacts</a> (SLSA) に基づいています。SLSA は<a href="https://openssf.org/">Open Source Security Foundation</a>（OpenSSF）に統合されており、アーティファクトの完全性を向上させ、弾力性のあるシステムを構築するために採用できるスタンダードと技術的コントロールについて詳述しています。<br><br>これらの取り組みは、CNCFが<a href="https://www.cncf.io/blog/2022/08/08/improving-cncf-security-posture-with-independent-security-audits/">OSTIFとの独立したセキュリティ監査</a>や<a href="https://www.cncf.io/blog/2022/06/28/improving-security-by-fuzzing-the-cncf-landscape/">ADA Logicsとのファジング監査</a>で行ってきたセキュリティの取り組みに基づいており、ソフトウェアのサプライチェーンにおけるセキュリティの健全性の重要な側面に取り組んでいます。</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<div class="quote-with-name-container">
					<p
						class="quote-with-name-container__quote">ソフトウェア サプライチェーン全体における攻撃の頻度と重要度が増加し続けているため、SLSA を利用して、プロジェクトが継続的にセキュリティ対策を改善することがこれまで以上に重要だと感じています。</p>
					<div class="quote-with-name-container__marks">
						<p
							class="quote-with-name-container__name">Chris Anisczyck</p>
						<p
							class="quote-with-name-container__position">CNCF社CTO</p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<div class="lf-grid kids-day">
					<div class="kids-day-col1">
						<?php LF_Utils::display_responsive_images( 90419, 'full', '470px', null, 'lazy', 'Phippy at Kids Day' ); ?>
					</div>
					<div class="kids-day-col2">
						<p
							class="opening-paragraph">4月16日（日）、アムステルダムで3つのワークショップを行う無料のキッズ デイを開催しました：</p>

						<ol>
							<li>Minecraftの改造</li>
							<li>Phippy and Friends Raspberry Pi Zoo Rescue</li>
							<li>Scratchを使ったストーリーとゲーム</li>
						</ol>

						<p>MinecraftとScratchのワークショップは主にオランダ語で、Raspberry Piのワークショップは主に英語で行われました。各ワークショップには、英語とオランダ語を話すボランティアが参加しました。<br><br>今年11月にシカゴで開催されるKubeCon + CloudNativeCon North Americaで、テクノロジー、コード、STEAM分野に関心のあるすべての子供たち（8～14歳）を対象に、キッズ デイを再び開催します。</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

			</div>
		</section>

		<section id="sustainability"
			class="section-12 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">持続可能性</h2>
					<div class="section-number">5/8</div>
				</div>

				<div class="lf-grid section-12__intro">
					<div class="section-12__intro-col1">
						<p
							class="opening-paragraph">私たちはイベントでの持続可能性にコミットしており、KubeCon + CloudNativeCon Europeも例外ではありませんでした。</p>

						<p>私たちは、イベントを開催する都市や国のさまざまな規則や規制（特にフードサービスに関するもの）と持続可能性のバランスをとるために最善を尽くしています。より持続可能なイベントを実現し、環境への影響を最小限に抑えるために、ベンダーやコミュニティと協力している方法については、以下をご覧ください。</p>

						<ul>
							<li>過去のデータから参加者数を綿密に計画し、最初から無駄を省きます。</li>
							<li>フード＆ドリンクは地元業者から提供</li>
							<li>残った食料は地元のフードバンクに寄付
							</li>
							<li>すべての使い捨てカップは生分解性</li>
							<li>ランチバッグは再生紙を使用</li>
							<li>CNCFとスポンサーは、アパレル、ナプキン、コーヒーカップ、おもちゃ＆ゲーム、事務用品、清掃/消毒用品、その他雑多な品々など、余った品々を<a href="https://hvoquerido.nl/">HVO Querido Amsterdam</a>に寄付しました。
							</li>
							<li>カンファレンス用ストラップは100％リサイクル素材を使用</li>
							<li><a href="https://www.rai.nl/en/corporate-social-responsibility">
									RAIのCSRイニシアチブ
								</a>の詳細をご覧ください。</li>
							<li><a href="https://acsaudiovisual.com/about/social-responsibility/">ACS</a>（オーディオ ビジュアル プロバイダー）の企業の社会的責任に関するイニシアチブの詳細をご覧ください。
								</li>
						</ul>

						<p></p>
					</div>
					<div class="section-12__intro-col2">

						<?php LF_Utils::display_responsive_images( 90397, 'full', '470px', null, 'lazy', 'Sustainability at Kubecon + CloudNativeCon Europe 2023' ); ?>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<?php LF_Utils::display_responsive_images( 90398, 'full', '470px', null, 'lazy', 'Sustainability at Kubecon + CloudNativeCon Europe 2023' ); ?>

					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

			</div>
		</section>

		<section id="health"
			class="section-13 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">現場の安全と<br>衛生の概要</h2>
					<div class="section-number">6/8</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p
							class="opening-paragraph">KubeCon + CloudNativeConでは、以下の安全衛生対策を実施しました：</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<p class="sub-header">COVID-19の安全対策</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid covid">
					<div class="covid-col1">
						<div class="icon-box-5">
							<div class="icon-box-5__icon"><img loading="lazy"
									width="100" height="100"
									src="<?php LF_Utils::get_svg( $report_folder . 'icon-sanitisation.svg', true ); ?>"
									alt="Sanitisation icon">
							</div>
							<div class="icon-box-5__text">会場内に手指消毒可能な場所を多数設置
							</div>
						</div>
						<div class="icon-box-5">
							<div class="icon-box-5__icon"><img loading="lazy"
									width="100" height="100"
									src="<?php LF_Utils::get_svg( $report_folder . 'icon-health-mask.svg', true ); ?>"
									alt="Health mask icon">
							</div>
							<div class="icon-box-5__text">マスク着用の推奨
							</div>
						</div>

					</div>
					<div class="covid-col2">
						<div class="icon-box-5">
							<div class="icon-box-5__icon"><img loading="lazy"
									width="100" height="100"
									src="<?php LF_Utils::get_svg( $report_folder . 'icon-health-test.svg', true ); ?>"
									alt="Health test icon">
							</div>
							<div class="icon-box-5__text">オンサイトでのCOVID-19無料検査</div>
						</div>
						<div class="icon-box-5">
							<div class="icon-box-5__icon"><img loading="lazy"
									width="100" height="100"
									src="<?php LF_Utils::get_svg( $report_folder . 'icon-health-band.svg', true ); ?>"
									alt="Health band icon">
							</div>
							<div class="icon-box-5__text">社会的距離の快適さを示すウェアラブル指標</div>
						</div>
					</div>
					<div class="covid-col3">
						<div class="icon-box-5">
							<div class="icon-box-5__icon"><img loading="lazy"
									width="100" height="100"
									src="<?php LF_Utils::get_svg( $report_folder . 'icon-clean.svg', true ); ?>"
									alt="Clean icon">
							</div>
							<div class="icon-box-5__text">現場での頻繁な清掃
							</div>
						</div>

						<div class="icon-box-5">
							<div class="icon-box-5__icon"><img loading="lazy"
									width="100" height="100"
									src="<?php LF_Utils::get_svg( $report_folder . 'icon-microphone.svg', true ); ?>"
									alt="Microphone icon">
							</div>
							<div class="icon-box-5__text">各スピーカーの使用時にマイクを消毒
							</div>
						</div>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">COVID-19に関する数値</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>KubeCon + CloudNativeCon Europe直後の2週間で、10件の陽性反応が認知されました。幸いなことに、深刻な事例は報告されていません。</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid tests">
					<div class="tests__col1">
						<span class="tests__large">10</span>
						<span class="tests__text">現地参加者の<br>陽性反応
							</span>
					</div>
					<div class="tests__col2">
						<span class="tests__large">0</span>
						<span class="tests__text">深刻な事例のレポート</span>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">インシデント透明性レポート</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid incidents">
					<div class="incidents__col1">
						<span class="incidents__large">0</span>
						<span class="incidents__text">現地で受領した<br>行動規範レポート
							</span>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

			</div>
		</section>

		<!-- MEDIA 7/8  -->
		<section id="media" class="section-14 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">メディア＆アナリストによる<br>掲載</h2>
					<div class="section-number">7/8</div>
				</div>

				<p class="sub-header">主な統計</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-14__coverage">

					<div class="section-14__coverage-col1">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="64" height="64" src="<?php LF_Utils::get_svg( $report_folder . 'icon-share-b.svg', true ); ?>
" alt="Share icon">
							</div>
							<div class="text">
								<span class="number">176</span><br />
								<span class="description">メディア＆業界アナリストの<br>参加
									</span>
							</div>
						</div>
						<!-- End of Icon Box 3 -->
					</div>
					<div class="section-14__coverage-col2">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="64" height="64" src="<?php LF_Utils::get_svg( $report_folder . 'icon-bell-b.svg', true ); ?>
" alt="Bell icon">
							</div>
							<div class="text">
								<span class="number">4,202</span><br />
								<span class="description">Kubecon + Cloudnativeconに<br>関する言及</span>

							</div>
						</div>
						<!-- End of Icon Box 3 -->
					</div>
					<div class="section-14__coverage-col3">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="64" height="64" src="<?php LF_Utils::get_svg( $report_folder . 'icon-graph-b.svg', true ); ?>
" alt="Graph up icon">
							</div>
							<div class="text">
								<span class="number">69%</span><br />
								<span class="description">2022年のヨーロッパ<br>イベントからの増加</span>
							</div>
						</div>
						<!-- End of Icon Box 3 -->
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">オンライン リーチ＋トラフィック</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-14__reach">

					<div class="section-14__reach-col1">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="64" height="64" src="<?php LF_Utils::get_svg( $report_folder . 'icon-heart-b.svg', true ); ?>
" alt="Heart icon">
							</div>
							<div class="text">
								<span class="number">547,000</span><br />
								<span class="description">ソーシャル インプレッション</span>
							</div>
						</div>
						<!-- End of Icon Box 3 -->
					</div>
					<div class="section-14__reach-col2">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="64" height="64" src="<?php LF_Utils::get_svg( $report_folder . 'icon-click-b.svg', true ); ?>
" alt="Click icon">
							</div>
							<div class="text">
								<span class="number">11,000以上</span><br />
								<span class="description">ソーシャル エンゲージメント</span>
							</div>
						</div>
						<!-- End of Icon Box 3 -->
					</div>
					<div class="section-14__reach-col3">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" width="64" height="64" src="<?php LF_Utils::get_svg( $report_folder . 'icon-youtube-b.svg', true ); ?>
" alt="Youtube icon">
							</div>
							<div class="text">
								<span class="number">3,400以上</span><br />
								<span class="description">イベント セッション ビュー</span>
								<span class="addendum">5月11日現在、イベントセッション動画の再生回数は<strong>3,400</strong>回を超えました。</span>
							</div>
						</div>
						<!-- End of Icon Box 3 -->
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">メディア＋アナリストの結果</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-14__analyst">

					<div class="section-14__analyst-col1">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<?php LF_Utils::display_responsive_images( 90433, 'full', '200px', 'svg-image', 'lazy', 'Logo' ); ?>
							<div class="text">
								<span class="number">3,301</span><br />
								<span class="addendum">メディア記事、プレスリリース、ブログで言及され、ツイッターで<strong>664</strong>回共有されました。</span>
							</div>
						</div>
						<!-- End of Icon Box 3 -->
					</div>
					<div class="section-14__analyst-col2">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<?php LF_Utils::display_responsive_images( 90436, 'full', '200px', 'svg-image', 'lazy', 'Kubernetes Logo' ); ?>
							<div class="text">
								<span class="number">3,152</span><br />
								<span class="addendum">メディア記事、プレスリリース、ブログで言及され、ソーシャル プラットフォームで<strong>622</strong>回共有されました。</span>
							</div>
						</div>
						<!-- End of Icon Box 3 -->
					</div>
					<div class="section-14__analyst-col3">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<?php LF_Utils::display_responsive_images( 90435, 'full', '200px', 'svg-image', 'lazy', 'KubeCon + CloudNativeCon Logo' ); ?>
							<div class="text">
								<span class="number">4,202</span><br />
								<span class="addendum">メディア記事、プレスリリース、ブログで言及され、ソーシャル プラットフォームで<strong>731</strong>回共有されました。</span>
							</div>
						</div>
						<!-- End of Icon Box 3 -->
					</div>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="section-header">メディア掲載概要</h2>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p><strong>176名のメディアおよび業界アナリスト</strong>が、直接またはバーチャルで参加しました。今年のヨーロッパのイベントでは、膨大な量の報道が行われ、<strong>4,200以上の記事とプレスリリース</strong>が掲載され、昨年のヨーロッパのイベントから<strong>69%増加</strong>しました。CNCFのPRおよびARチームは、プレスおよびアナリスト カンファレンスでのエンドユーザー パネルに加え、プラットフォーム エンジニアリングとクラウドネイティブの次に来るものに焦点を当てた2つのメディアおよびアナリスト ラウンドテーブル会議を開催しました。</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="quote-with-name-container">
					<p
						class="quote-with-name-container__quote">DevOpsが運用と開発のワークフローを統合することだとすれば、プラットフォーム エンジニアリングは発生する問題の解決を目指しています。KubeConとCloudNativeCon EUがメディア向けに開催したパネルで、プラットフォーム エンジニアリングはDevOpsムーブメントの進化形であると述べました。</p>
					<div class="quote-with-name-container__marks">
						<p
							class="quote-with-name-container__name">Loraine Lawson</p>
						<p
							class="quote-with-name-container__position">The New Stack</p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">メディア掲載</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<p><strong>176名のジャーナリストとアナリスト</strong>が現地とオンラインで参加。<br>出版物のリストは以下にあります：</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-14__publications">
					<div class="section-14__publications-col1">
						<ul>
							<li>Amazic</li>
							<li>Cloud Security Podcast</li>
							<li>Computable</li>
							<li>Computerweekly.de</li>
							<li>DataCenter-Insider</li>
							<li>De Nederlandse Kubernetes Podcast</li>
							<li>Freelance</li>
							<li>Heise c't</li>
							<li>Heise Developer</li>
							<li>Heise iX</li>
							<li>ICT Magazine</li>
							<li>InfoQ</li>
							<li>IT Daily</li>
							<li>ITmedia Inc.</li>
							<li>ITPro</li>
							<li>L'informaticien</li>
							<li>Le Mag IT</li>
						</ul>

					</div>
					<div class="section-14__publications-col2">
						<ul>
							<li>Le Monde Informatique</li>
							<li>Linux Magazin</li>
							<li>NetMedia Group</li>
							<li>opensource.com</li>
							<li>Programmez</li>
							<li>Radio Tux</li>
							<li>Reshift</li>
							<li>SDxCentral</li>
							<li>Sigs Datacom</li>
							<li>SiliconANGLE</li>
							<li>Silverlinings</li>
							<li>Software Defined Podcast</li>
							<li>Software Defined Talk</li>
							<li>Software Engineering Daily</li>
							<li>Software Guru</li>
							<li>Springer Nature</li>
							<li>Storage Newsletter</li>
						</ul>

					</div>
					<div class="section-14__publications-col3">
						<ul>
							<li>Tech.eu</li>
							<li>Techstrong Group</li>
							<li>TechTarget</li>
							<li>Techzine</li>
							<li>TFIR</li>
							<li>The Cloudcast</li>
							<li>theCUBE</li>
							<li>The New Stack</li>
							<li>The Stack</li>
							<li>ThinkIT</li>
							<li>Toolinux</li>
							<li>VMblog</li>
							<li>Vogel IT</li>
							<li>ZDNet</li>
							<li>ZeCloud</li>
							<li>Zona Movilidad</li>
						</ul>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">報道ハイライト</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<p>KubeCon + CloudNativeCon Europeのオリジナル記事<strong>210本以上</strong>が、以下の主要媒体で掲載されました：</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="logo-grid">

					<div class="logo-grid__box">
						<?php LF_Utils::display_responsive_images( 90420, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'ComputerWeekly Logo' ); ?>
					</div>
					<div class="logo-grid__box">
						<?php LF_Utils::display_responsive_images( 90421, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'DevOps Logo' ); ?>
					</div>
					<div class="logo-grid__box">
						<?php LF_Utils::display_responsive_images( 90437, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'Forbes Logo' ); ?>
					</div>
					<div class="logo-grid__box">
						<?php LF_Utils::display_responsive_images( 90438, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'Heise Online Logo' ); ?>
					</div>
					<div class="logo-grid__box">
						<?php LF_Utils::display_responsive_images( 90422, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'LeMagIT Logo' ); ?>
					</div>
					<div class="logo-grid__box">
						<?php LF_Utils::display_responsive_images( 90423, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'Lemonde Logo' ); ?>
					</div>
					<div class="logo-grid__box">
						<?php LF_Utils::display_responsive_images( 90424, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'Linformatien Logo' ); ?>
					</div>
					<div class="logo-grid__box">
						<?php LF_Utils::display_responsive_images( 90425, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'Linux Magzin Logo' ); ?>
					</div>
					<div class="logo-grid__box">
						<?php LF_Utils::display_responsive_images( 90426, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'Programmez Logo' ); ?>
					</div>
					<div class="logo-grid__box">
						<?php LF_Utils::display_responsive_images( 90439, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'SDX Central Logo' ); ?>
					</div>
					<div class="logo-grid__box">
						<?php LF_Utils::display_responsive_images( 90427, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'SiliconAngle Logo' ); ?>
					</div>
					<div class="logo-grid__box">
						<?php LF_Utils::display_responsive_images( 90428, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'TechTarget Logo' ); ?>
					</div>
					<div class="logo-grid__box">
						<?php LF_Utils::display_responsive_images( 90429, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'Techzine Logo' ); ?>
					</div>
					<div class="logo-grid__box">
						<?php LF_Utils::display_responsive_images( 90430, 'full', '600px', 'svg-image logo-grid__image', 'lazy', 'TFIR Logo' ); ?>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">業界アナリストの取材ハイライト</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="quote-with-name-container">
					<p
						class="quote-with-name-container__quote">#kubecon2023 Omdiaは2日間にわたる素晴らしいノン ベンダー イベントからの帰り道です。クラウドネイティブの未来は今、その期待に応えており、エコシステムは成熟し、聴衆は今、本番でK8sを実行するためのより多くの側面に注目しています。その結果、プラットフォーム エンジニアリングがホットなトピックになったということです。</p>
					<div class="quote-with-name-container__marks">
						<p
							class="quote-with-name-container__name">Roy Illsley</p>
						<p class="quote-with-name-container__position">Omdia</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<div class="quote-with-name-container">
					<p
						class="quote-with-name-container__quote">このカンファレンスについて言いたいことはまだたくさんありますが、メーカーにとって重要なことは、KubernetesとそのエコシステムはもはやITだけの問題ではないということです。それはOTに関するものでもあります。</p>
					<div class="quote-with-name-container__marks">
						<p
							class="quote-with-name-container__name">Harry Forbes</p>
						<p
							class="quote-with-name-container__position">ARC Advisory Group</p>
					</div>
				</div>

				<div class="shadow-hr"></div>
				<div class="section-14__links">
					<p>Michael Azoff, Omdia - <a href="https://omdia.tech.informa.com/OM030310/Kubernetes-maturity-and-other-highlights-at-KubeCon-Amsterdam-2023">Kubernetes maturity and other highlights at KubeCon Amsterdam 2023</a></p>
					<p>Charlotte Dunlap, Global Data - <a href="https://itconnection.wordpress.com/2023/05/02/kubecon-eu-modernizing-it-operations-through-genai/">KubeCon EU: Modernizing IT Operations Through GenAI</a></p>
					<p>William Fellows, 451 Research - <a href="https://clients.451research.com/reports/202306?searchTerms=kubecon">Solo.io's Gloo Fabric aims to offer a holistic approach to application networking</a></p>
					<p>William Fellows, 451 Research - <a href="https://clients.451research.com/reports/202305?searchTerms=kubecon">Isovalent aggregates components, extends from Kubernetes to multicloud, bare metal</a></p>
					<p>Al Gillen, IDC - <a href="https://www.idc.com/getdoc.jsp?containerId=lcUS50602023&pageType=PRINTFRIENDLY">KubeCon Europe 2023 Highlights Linux Foundation's Expansion into Europe</a></p>
					<p>Krista Macomber, Futurum - <a href="https://futurumresearch.com/research-notes/open-versus-closed-source-what-is-the-state-of-kubernetes-protection">Open Versus Closed Source: What is the State of Kubernetes Protection?</a></p>
				</div>

				<button class="button-reset section-14__button"
					data-id="js-hidden-section-trigger-open">
					全てのリストを見る
					<?php LF_Utils::get_svg( $report_folder . 'arrow-down.svg' ); ?>
				</button>

				<div class="section-14__hidden-section"
					data-id="js-hidden-section">

					<div class="section-14__hidden-section-content">

						<p>Steven Dickens, Futurum - <a href="https://futurumresearch.com/research-notes/gitlab-and-oracle-partner-to-accelerate-ai-ml-development/">GitLab and Oracle Partner to Accelerate AI/ML Development</a></p>
						<p>Steven Dickens, Futurum - <a href="https://futurumresearch.com/research-notes/vmware-doubles-down-on-cross-cloud-services/">VMware Doubles Down on Cross-Cloud Services</a></p>
						<p>Camberley Bates, Futurum - <a href="https://d2iq.com/blog/kubecon-europe-2023-platform-engineering">KubeCon Europe 2023 Highlights Kubernetes Explosion and Need for Instant Platform Engineering</a></p>
						<p>Steven Dickens, Futurum - <a href="https://futurumresearch.com/research-notes/kubecon-2023-suse-launches-rancher-2-7-2-latest-version-of-rancher/">KubeCon 2023: SUSE Launches Rancher 2.7.2, Latest Version of Rancher</a></p>
						<p>Jon Collins, GigaOm - <a href="https://gigaom.com/2023/05/03/touchpoints-coalescence-and-multi-platform-engineering-thoughts-from-kubecon-2023/">Touchpoints, coalescence and multi-platform engineering — thoughts from Kubecon 2023</a></p>
						<p>Torsten Volk, EMA - <a href="https://faun.pub/opentelemetry-the-star-of-kubecon-2023-c1e2b504850d">OpenTelemetry: The Star of KubeCon 2023</a></p>
						<p>Larry Carvalho, Robustcloud - <a href="https://robustcloud.com/embracing-the-future-generative-ai-and-wasm/">Embracing the Future: Generative AI and Web Assembly (Wasm) Innovations at KubeCon CloudNativeCon EU 2023</a></p>
						<p>Sanjeev Mohan, SanjMo - <a href="https://www.youtube.com/watch?v=_txmAX5mTxA">It Depends: Gabriele Bartolini, EDB demystifies data on Kubernetes concepts</a></p>
						<p>Sanjeev Mohan, SanjMo - <a href="https://www.youtube.com/watch?v=N1CHs7E6dkY">Sanjeev Mohan, Matt Butcher, Fermyon and Justin Cormack | KubeCon CloudNativeCon EU 2023</a></p>
						<p>Jon Brown, ESG - <a href="https://www.techtarget.com/searchitoperations/opinion/At-KubeCon-2023-observability-and-FinOps-high-on-the-agenda">At KubeCon 2023, observability and FinOps high on the agenda</a></p>
						<p>Paul Nashawaty, ESG - <a href="https://www.techtarget.com/searchitoperations/opinion/Takeaways-and-emerging-trends-from-KubeCon-Europe-2023">Takeaways and emerging trends from KubeCon Europe 2023</a></p>
						<p>Brent Ellis, Andrew Cornwall, Forrester - <a href="https://www.forrester.com/blogs/what-is-wasm-and-why-it-matters-to-the-enterprise-part-1-2/?ref_search=0_1683585373775">What Is WASM, And Why Does It Matter To The Enterprise? (Part 1 Of 2)</a></p>
						<p>Brent Ellis, Andrew Cornwall, Forrester - <a href="https://www.forrester.com/blogs/what-is-wasm-and-why-it-matters-to-the-enterprise-part-2-2/?ref_search=0_1683585373775">What Is WASM, And Why Does It Matter To The Enterprise? (Part 2 Of 2)</a></p>
						<p>Brent Ellis,  Forrester - <a href="https://www.forrester.com/blogs/taking-webassembly-wasm-to-the-enterprise-and-beyond/?ref_search=0_1683585422060">Taking WebAssembly/WASM To The Enterprise And Beyond</a></p>
						<p>Lee Sustar, Forrester - <a href="https://www.forrester.com/report/selecting-your-kubernetes-strategy/RES179211?ref_search=0_1683669328173">Selecting Your Kubernetes Strategy</a></p>
						<p>Rob Strechay ESG - <a href="https://siliconangle.com/2023/05/02/reflections-kubecon-cloudnativecon-eu/">Reflections on Kubecon + CloudNativeCon EU</a></p>
						<p>Ameer Gaili, Analysys Mason - <a href="https://www.analysysmason.com/research/content/articles/kubecon-cloud-automation-rma16-rma14-rma21/">KubeCon 2023: telcos increasingly turn to open-source solutions to unlock cloud-native network benefits</a></p>
						<p>Jason Bloomberg, Intellyx - <a href="https://www.youtube.com/watch?v=QqXKC9-T6s8">KubeCon CloudNativeCon EU 2023 - Jason Bloomberg - YouTube</a></p>
						<p>Jason Bloomberg, Intellyx - <a href="https://siliconangle.com/2023/04/22/plenty-gas-innovations-continue-apace-first-post-pandemic-kubecon/">Plenty of gas: Innovations continue apace at the first post-pandemic KubeCon</a></p>
						<p>Jason Bloomberg, Intellyx - <a href="https://intellyx.com/2023/04/22/cloudfabrix-adding-an-observability-data-modernization-service/">CloudFabrix: Adding an Observability Data Modernization Service</a></p>
						<p>Jason Bloomberg, Intellyx - <a href="https://intellyx.com/2023/04/22/direktiv-automating-infrastructure-integration-processes-with-knative/">Direktiv: Automating Infrastructure Integration Processes with Knative</a></p>
						<p>Jason Bloomberg, Intellyx - <a href="https://intellyx.com/2023/04/22/observiq-observability-pipeline-built-for-opentelemetry-now-in-the-cloud/">ObservIQ: Observability Pipeline Built for OpenTelemetry, Now in the Cloud</a></p>
						<p>Jason Bloomberg, Intellyx - <a href="https://intellyx.com/2023/04/22/perfectscale-right-sizing-kubernetes-clusters-for-governance-and-cost-savings/">PerfectScale: Right-Sizing Kubernetes Clusters for Governance and Cost Savings</a></p>
						<p>Jason Bloomberg, Intellyx - <a href="https://intellyx.com/2023/04/22/traefik-cloud-native-api-management-and-service-mesh/">Traefik: Cloud Native API Management and Service Mesh</a></p>
						<p>Jason Bloomberg, Intellyx - <a href="https://intellyx.com/2023/04/22/netris-virtual-private-cloud-across-multiple-clouds-on-prem-and-edge/">Netris: Virtual Private Cloud across Multiple Clouds, On-Prem, and Edge</a></p>
						<p>Jason Bloomberg, Intellyx - <a href="https://intellyx.com/2023/04/22/ksoc-real-time-kubernetes-security-operations-center/">KSOC: Real-Time Kubernetes Security Operations Center</a></p>
						<p>Jason Bloomberg, Intellyx - <a href="https://intellyx.com/2023/04/22/slim-ai-generating-sboms-when-slimming-containers/">Slim.ai: Generating SBOMs when Slimming Containers</a></p>

					</div>
				</div>

				<button
					class="button-reset section-14__button section-14__button-close"
					style="display: none;"
					data-id="js-hidden-section-trigger-close">
					<?php LF_Utils::get_svg( $report_folder . 'arrow-up.svg' ); ?>
					リストを閉じる
				</button>

				<div aria-hidden="true" class="report-spacer-120"></div>

			</div>
		</section>

		<!-- SPONSORS 8/8  -->
		<section id="sponsors"
			class="section-15 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">スポンサー情報</h2>
					<div class="section-number">8/8</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p
							class="opening-paragraph">KubeCon + CloudNativeConは、素晴らしいスポンサーのサポートなしでは実現できませんでした。参加者の89%がイベント期間中にソリューション ショーケースを訪れました。</p>
					</div>
				</div>

				<div class="kccnc-table-container">
					<table class="kccnc-table booth">
						<thead>
							<tr>
								<th>ブース トラフィック</th>
								<th>合計</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>オンサイト リード合計</td>
								<td>94,587</td>
							</tr>
							<tr>
								<td>オンサイト リード平均/ブース</td>
								<td>446</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

				<div class="kccnc-table-container">
					<table class="kccnc-table yoy-table">
						<thead>
							<tr>
								<th>前年からのスポンサー
								</th>
								<th>2017
									<span>Berlin</span>
								</th>
								<th>2018
									<span>Copenhagen</span>
								</th>
								<th>2019
									<span>Barcelona</span>
								</th>
								<th>2020
									<span>Virtual</span>
								</th>
								<th>2021
									<span>Virtual</span>
								</th>
								<th>2022
									<span>Valencia</span>
								</th>
								<th>2023
									<span>Amsterdam</span>
								</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>ダイヤモンド</td>
								<td>5</td>
								<td>6*</td>
								<td>6*</td>
								<td>6*</td>
								<td>6*</td>
								<td>6*</td>
								<td>7*</td>
							</tr>
							<tr>
								<td>プラチナ</td>
								<td>4</td>
								<td>7</td>
								<td>15</td>
								<td>7</td>
								<td>8</td>
								<td>17</td>
								<td>18</td>
							</tr>
							<tr>
								<td>ゴールド</td>
								<td>7</td>
								<td>7</td>
								<td>14</td>
								<td>8</td>
								<td>12</td>
								<td>18</td>
								<td>18</td>
							</tr>
							<tr>
								<td>シルバー</td>
								<td>15</td>
								<td>51</td>
								<td>55</td>
								<td>35</td>
								<td>46</td>
								<td>95</td>
								<td>111</td>
							</tr>
							<tr>
								<td class="nowrap">スタートアップ</td>
								<td>13</td>
								<td>25</td>
								<td>53</td>
								<td>26</td>
								<td>28</td>
								<td>49</td>
								<td>63</td>
							</tr>
							<tr>
								<td class="nowrap">エンドユーザー</td>
								<td>N/A</td>
								<td>N/A</td>
								<td>3</td>
								<td>3</td>
								<td>2</td>
								<td>2</td>
								<td>1</td>
							</tr>
							<tr>
								<td>マーケティング機会</td>
								<td>8</td>
								<td>19</td>
								<td>27</td>
								<td>17</td>
								<td>25</td>
								<td>44</td>
								<td>45</td>
							</tr>
							<tr>
								<td>合計ユニーク数</td>
								<td>47</td>
								<td>96</td>
								<td>146</td>
								<td>87</td>
								<td>102</td>
								<td>189</td>
								<td>221</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div aria-hidden="true" class="report-spacer-20"></div>

				<span>* 上限</span>

				<div class="shadow-hr"></div>

				<p class="sub-header"
					style="margin:auto; text-align:center">ダイヤモンド スポンサー</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="sponsors-logos largest odd orphan-by-3 orphan-by-6">
					<div class="sponsors-logo-item"><a
							href="https://aws-kubecon-eu.splashthat.com/"
							title="Go to aws-kceu23" target="_blank"
							rel="noopener" data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="400" height="245"
								src="https://events.linuxfoundation.org/wp-content/uploads/amazon-web-services-spn.svg"
								class="logo wp-post-image" alt="aws-kceu23 logo"
								decoding="async" loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.huawei.com/" title="Go to Huawei"
							target="_blank" rel="noopener"
							data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="241" height="245"
								src="https://events.linuxfoundation.org/wp-content/uploads/2020/02/Huawei.svg"
								class="logo wp-post-image" alt="Huawei logo"
								decoding="async" loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://azure.microsoft.com/en-us/overview/kubernetes-on-azure/"
							title="Go to Microsoft_Azure_KubeCon"
							target="_blank" rel="noopener"
							data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="400" height="245"
								src="https://events.linuxfoundation.org/wp-content/uploads/microsoft-azure-spn.svg"
								class="logo wp-post-image"
								alt="Microsoft_Azure_KubeCon logo"
								decoding="async" loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://outshift.com/"
							title="Go to Outshift by Cisco"
							style="-webkit-transform: scale(1.1); -ms-transform: scale(1.1); transform: scale(1.1);"
							target="_blank" rel="noopener"
							data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="765" height="332"
								src="https://events.linuxfoundation.org/wp-content/uploads/2022/07/outshift_bycisco.svg"
								class="logo wp-post-image"
								alt="Outshift by Cisco logo" decoding="async"
								loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.suse.com/products/suse-rancher/"
							title="Go to rancher by suse"
							style="-webkit-transform: scale(0.99); -ms-transform: scale(0.99); transform: scale(0.99);"
							target="_blank" rel="noopener"
							data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="146" height="35"
								src="https://events.linuxfoundation.org/wp-content/uploads/2020/01/rancher-suse-logo-horizontal_horizontal-color.svg"
								class="logo wp-post-image"
								alt="rancher by suse logo" decoding="async"
								loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.redhat.com/"
							title="Go to Red Hat Logo" target="_blank"
							rel="noopener" data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="400" height="245"
								src="https://events.linuxfoundation.org/wp-content/uploads/RedHat-new.svg"
								class="logo wp-post-image"
								alt="Red Hat Logo logo" decoding="async"
								loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.veritas.com/"
							title="Go to Veritas" target="_blank" rel="noopener"
							data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="408" height="92"
								src="https://events.linuxfoundation.org/wp-content/uploads/2020/09/Veritas-01.svg"
								class="logo wp-post-image" alt="Veritas logo"
								decoding="async" loading="lazy"></a></div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header"
					style="margin:auto; text-align:center">プラチナ スポンサー</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="sponsors-logos larger even">
					<div class="sponsors-logo-item"><a href="https://ubuntu.com"
							title="Go to canonical" target="_blank"
							rel="noopener" data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="400" height="245"
								src="https://events.linuxfoundation.org/wp-content/uploads/canonical-spn.svg"
								class="logo wp-post-image" alt="canonical logo"
								decoding="async" loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.datadoghq.com/"
							title="Go to datadog" target="_blank" rel="noopener"
							data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="400" height="245"
								src="https://events.linuxfoundation.org/wp-content/uploads/datadog-spn.svg"
								class="logo wp-post-image" alt="datadog logo"
								decoding="async" loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.delltechnologies.com/"
							title="Go to dell"
							style="-webkit-transform: scale(1.3); -ms-transform: scale(1.3); transform: scale(1.3);"
							target="_blank" rel="noopener"
							data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="400" height="245"
								src="https://events.linuxfoundation.org/wp-content/uploads/dell-spn.svg"
								class="logo wp-post-image" alt="dell logo"
								decoding="async" loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://about.gitlab.com/"
							title="Go to gitlab" target="_blank" rel="noopener"
							data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="721" height="177"
								src="https://events.linuxfoundation.org/wp-content/uploads/2020/01/gitlab-logo-rgb.svg"
								class="logo wp-post-image" alt="gitlab logo"
								decoding="async" loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://cloud.google.com/"
							title="Go to Google Cloud"
							style="-webkit-transform: scale(1.1); -ms-transform: scale(1.1); transform: scale(1.1);"
							target="_blank" rel="noopener"
							data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="3016" height="626"
								src="https://events.linuxfoundation.org/wp-content/uploads/2020/06/lockup_GoogleCloud_FullColor_rgb_2900x512px.svg"
								class="logo wp-post-image"
								alt="Google Cloud logo" decoding="async"
								loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.ibm.com/us-en/"
							title="Go to ibm-horizontal-color"
							style="-webkit-transform: scale(0.7); -ms-transform: scale(0.7); transform: scale(0.7);"
							target="_blank" rel="noopener"
							data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="441" height="175"
								src="https://events.linuxfoundation.org/wp-content/uploads/2020/01/IBM_logo┬_pos_blue60_CMYK.svg"
								class="logo wp-post-image"
								alt="ibm-horizontal-color logo" decoding="async"
								loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://incident.io/" title="Go to incident"
							target="_blank" rel="noopener"
							data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="1038" height="293"
								src="https://events.linuxfoundation.org/wp-content/uploads/2023/01/logo-colour-dark.svg"
								class="logo wp-post-image" alt="incident logo"
								decoding="async" loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.intel.com/content/www/us/en/developer/topic-technology/open/overview.html"
							title="Go to intel"
							style="-webkit-transform: scale(0.6); -ms-transform: scale(0.6); transform: scale(0.6);"
							target="_blank" rel="noopener"
							data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="338" height="139"
								src="https://events.linuxfoundation.org/wp-content/uploads/2020/01/intel-01.svg"
								class="logo wp-post-image" alt="intel logo"
								decoding="async" loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a href="https://jfrog.com/"
							title="Go to jfrog" target="_blank" rel="noopener"
							data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="400" height="245"
								src="https://events.linuxfoundation.org/wp-content/uploads/jfrog-spn.svg"
								class="logo wp-post-image" alt="jfrog logo"
								decoding="async" loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.kasten.io/"
							title="Go to Kasten by Veeam - KubeCon"
							style="-webkit-transform: scale(0.9); -ms-transform: scale(0.9); transform: scale(0.9);"
							target="_blank" rel="noopener"
							data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="254" height="101"
								src="https://events.linuxfoundation.org/wp-content/uploads/2021/03/Kasten-logo-2022.svg"
								class="logo wp-post-image"
								alt="Kasten by Veeam - KubeCon logo"
								decoding="async" loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://opensource.mercedes-benz.com/"
							title="Go to Mercedes-Benz" target="_blank"
							rel="noopener" data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="382" height="77"
								src="https://events.linuxfoundation.org/wp-content/uploads/2023/02/Mercedes-Benz-Logo.svg"
								class="logo wp-post-image"
								alt="Mercedes-Benz logo" decoding="async"
								loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://opensearch.org/"
							title="Go to OpenSearch" target="_blank"
							rel="noopener" data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="386" height="85"
								src="https://events.linuxfoundation.org/wp-content/uploads/2022/03/SVG-Logo.svg"
								class="logo wp-post-image" alt="OpenSearch logo"
								decoding="async" loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://portworx.com/"
							title="Go to Portworx by Pure Storage"
							target="_blank" rel="noopener"
							data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="406" height="158"
								src="https://events.linuxfoundation.org/wp-content/uploads/2020/10/portworx-by-purestorage-01.svg"
								class="logo wp-post-image"
								alt="Portworx by Pure Storage logo"
								decoding="async" loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://www.paloaltonetworks.com/prisma/cloud"
							title="Go to Prisma Cloud by Palo Alto Networks"
							style="-webkit-transform: scale(1.25); -ms-transform: scale(1.25); transform: scale(1.25);"
							target="_blank" rel="noopener"
							data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="1626" height="262"
								src="https://events.linuxfoundation.org/wp-content/uploads/2021/12/Palo_Alto_Prisma_Cloud_logo_RGB_Horizontal.svg"
								class="logo wp-post-image"
								alt="Prisma Cloud by Palo Alto Networks logo"
								decoding="async" loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a href="https://snyk.io/"
							title="Go to snyk" target="_blank" rel="noopener"
							data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="400" height="245"
								src="https://events.linuxfoundation.org/wp-content/uploads/Snyk-spn.svg"
								class="logo wp-post-image" alt="snyk logo"
								decoding="async" loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://sysdig.com/" title="Go to sysdig"
							target="_blank" rel="noopener"
							data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="400" height="245"
								src="https://events.linuxfoundation.org/wp-content/uploads/sysdig-spn.svg"
								class="logo wp-post-image" alt="sysdig logo"
								decoding="async" loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://goteleport.com/"
							title="Go to Teleport" target="_blank"
							rel="noopener" data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="187" height="45"
								src="https://events.linuxfoundation.org/wp-content/uploads/2021/03/teleport-kcsp.svg"
								class="logo wp-post-image" alt="Teleport logo"
								decoding="async" loading="lazy"></a></div>
					<div class="sponsors-logo-item"><a
							href="https://tanzu.vmware.com/"
							title="Go to vmware" target="_blank" rel="noopener"
							data-feathr-click-track="true"
							data-feathr-link-aids="[&quot;5e59d3cf27f56a08159cd952&quot;]"><img
								width="400" height="245"
								src="https://events.linuxfoundation.org/wp-content/uploads/vmware-spn.svg"
								class="logo wp-post-image" alt="vmware logo"
								decoding="async" loading="lazy"></a></div>
				</div>

				<div class="shadow-hr"></div>

				<div class="wp-block-button"><a
						href="https://events.linuxfoundation.org/kubecon-cloudnativecon-europe/sponsor-list/"
						title="See all Sponsors and Partners of KubeCon + CloudNativeCon Europe 2023"
						class="wp-block-button__link">すべてのスポンサーとパートナーを見る</a>
				</div>

				<div class="shadow-hr"></div>

				<div class="video">
					<h2 class="video__title">ビデオ ハイライト</h2>

					<div aria-hidden="true" class="report-spacer-60">
					</div>

					<div class="wp-block-lf-youtube-lite">
						<lite-youtube videoid="tBDK_AYGv-k"
							videotitle="Highlights from KubeCon + CloudNativeCon Europe 2023"
							webpStatus="1" sdthumbStatus="0"
							title="Play Highlights">
						</lite-youtube>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

			</div>
		</section>

		<section class="section-16 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="lf-grid thanks">
					<div class="thanks__col1">
						<h2 class="section-header">ありがとうございました</h2>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<p
							class="thanks__opening">アムステルダムでの素晴らしいイベントを振り返って楽しんでいただけたなら幸いです。また近いうちにやりましょう！</p>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<p
							class="thanks__comments">ご意見・ご感想は<a href="mailto:events@cncf.io">events@cncf.io</a>までお寄せください（英語となります）。</p>

						<div aria-hidden="true" class="report-spacer-80"></div>

						<p><a href="https://community.cncf.io/">お近くのコミュニティ イベントのカレンダー</a>をご確認ください。2023年9月26日～28日に上海で開催される<a href="https://www.lfasiallc.com/kubecon-cloudnativecon-open-source-summit-china/">KubeCon + CloudNativeCon + Open Source Summit China</a>と、2023年11月6日～9日にシカゴで開催される<a href="https://events.linuxfoundation.org/kubecon-cloudnativecon-north-america/">KubeCon + CloudNativeCon North America</a>への登録をお忘れなく。</p>
					</div>
					<div class="thanks__col2">
						<?php
							LF_Utils::display_responsive_images( 90431, 'full', '400px', null, 'lazy', 'CNCF Mascot' );
						?>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<?php
				get_template_part( 'components/social-share' );
				?>
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

// load masonry.
wp_enqueue_script( 'masonry', get_template_directory_uri() . '/source/js/libraries/masonry.min.js', array( 'jquery' ), filemtime( get_template_directory() . '/source/js/libraries/masonry.min.js' ), true );

// custom scripts.
wp_enqueue_script(
	'kccnc-eu-23-report',
	get_template_directory_uri() . '/source/js/on-demand/kccnc-eu-23-report.js',
	array( 'jquery', 'slick' ),
	filemtime( get_template_directory() . '/source/js/on-demand/kccnc-eu-23-report.js' ),
	true
);

get_template_part( 'components/footer' );
