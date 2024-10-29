<?php
/**
 * Template Name: Annual Survey 2023 JP
 * Template Post Type: lf_report
 *
 * File for the Annual Survey 2023
 *
 * @package WordPress
 * @subpackage cncf-theme
 * @since 1.0.0
 */

// Report folder in images/ folder.
$report_folder = 'reports/annual-survey-23/';

get_template_part( 'components/header' );

get_template_part( 'components/skip-link-target' );

wp_enqueue_style( 'annual-survey-23', get_template_directory_uri() . '/build/annual-survey-2023.min.css', array(), filemtime( get_template_directory() . '/build/annual-survey-2023.min.css' ), 'all' );

wp_enqueue_style( 'wp-block-group' );
wp_enqueue_style( 'wp-block-column' );
wp_enqueue_style( 'wp-block-columns' );

// setup social share icons + data.
$caption      = 'Read the CNCF Annual Survey 2023 ';
$page_url     = rawurlencode( get_permalink() );
$caption      = htmlspecialchars( rawurlencode( html_entity_decode( $caption, ENT_COMPAT, 'UTF-8' ) ), ENT_COMPAT, 'UTF-8' );
$options      = get_option( 'lf-mu' );
$twitter      = $options && $options['social_twitter_handle'] ? $options['social_twitter_handle'] : null;
$twitter_url  = 'https://twitter.com/intent/tweet?text=' . $caption . '&amp;url=' . $page_url . '&amp;hashtags=cncf&amp;via=' . $twitter . '';
$linkedin_url = 'https://www.linkedin.com/shareArticle?mini=true&url=' . $page_url . '&summary=' . $caption;
$mailto_url   = 'mailto:?subject=' . $caption . '&body=' . $caption . '&nbsp;' . $page_url;
?>

<link rel="prefetch"
	href="<?php echo esc_url( get_template_directory_uri() . '/build/annual-survey-2023.min.css' ); ?>"
	as="style" crossorigin="anonymous">

<main class="as23">
	<article class="container wrap">
		<section class="hero alignfull">
			<div class="container wrap hero__container">
				<figure class="hero__container-bg-figure">
					<?php
					LF_Utils::display_responsive_images( 103549, 'full', '1200px', 'hero__container-bg-image', 'eager', 'A graphic of some stacked boxes to symbolise containers.' );
					?>
				</figure>
				<div class="hero__content">

					<picture>
						<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'cncf-annual-survey-2023-logo-mobile.svg', true );
?>
">
						<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'cncf-annual-survey-2023-logo-desktop.svg', true );
?>
">
						<img width="588" height="262" src="
<?php
Lf_Utils::get_svg( $report_folder . 'cncf-annual-survey-2023-logo-desktop.svg', true );
?>
" alt="CNCF Annual Survey 2023" loading="eager" class="hero__title">
					</picture>

					<div class="hero__button-share-align">

						<div class="wp-block-button hero__button"><a
								href="https://data.world/thelinuxfoundation/2023-cncf-annual-survey"
								class="wp-block-button__link"
								title="View the full dataset">
								データセット全体を表示</a>
						</div>

						<?php
						get_template_part( 'components/social-share' );
						?>

					</div>

					<div class="hero__jump">セクションへ移動:</div>
				</div>
			</div>
		</section>

		<section class="nav-section">
			<!-- Navigation  -->
			<div class="nav-el">
				<div class="nav-el__box">
					<a href="#methodology" title="Jump to Methodology section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-methodology.svg', true ); ?>
" alt="Methodology icon">調査方法
				</div>

				<div class="nav-el__box">
					<a href="#demographics" title="Jump to Demographics section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-lanyard.svg', true ); ?>
" alt="Lanyard icon">人口統計
				</div>

				<div class="nav-el__box">
					<a href="#findings" title="Jump to Key Findings section"
						class="box-link"></a>
					<img loading="lazy" width="36" height="36" src="
<?php
LF_Utils::get_svg( $report_folder . 'icon-inspect.svg', true );
?>
" alt="Inspect icon">主な調査結果
				</div>
			</div>
		</section>

		<section class="section-01">
			<h2 class="section-01__title">Cloud Native 2023：グローバル テクノロジーの <br
					class="show-over-1000">議論の余地のないインフラストラクチャ</h2>

			<div class="lf-grid">
				<div class="restrictive-9-col">
					<p>2015年以来、Cloud Native Computing Foundationは、クラウドネイティブ コミュニティにおける独自の立場を利用して、状況を調査し、ダイナミクスを理解し、オープンソースのクラウドネイティブ テクノロジーのユーザーにより良いサービスを提供してきました。CNCF年次調査の第11回目となる今回は、クラウドネイティブ コミュニティの多様な経験を反映した包括的で詳細なレポートの作成に着手しました。</p>
					<p>いつものように<a href="https://data.world/thelinuxfoundation/2023-cncf-annual-survey">data.world/thelinuxfoundation</a>で入手可能な年次調査の完全なデータセットを喜んで共有します。</p>
				</div>
			</div>
		</section>

		<section id="methodology"
			class="section-02 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">調査方法</h2>
					<div class="section-number">1/3</div>
				</div>

				<div class="lf-grid section-02__grid">
					<div class="section-02__grid-col1">
						<p><strong>このレポートは、Linux Foundation Researchとそのパートナーが2023年8月から12月にかけて実施したWeb調査に基づいています。この調査は、クラウドネイティブ コンピューティング、コンテナ、Kubernetes、サイバーセキュリティ、およびWebAssemblyのトピックを扱った59の質問で構成されています。この調査の構成をより深く理解するために、レポートの最後にある詳細な方法論と人口統計を読むことをお勧めします。</strong><br><br>
						回答者は多くの業界産業とあらゆる規模の企業にまたがっており、南北アメリカ、ヨーロッパ、アジア太平洋地域を含む地域からデータを収集しました。次に、企業の規模、地理的地域、組織の種類によってデータ収集を層別化しました。データは主に地理的地域、企業の規模、クラウドネイティブ技術の採用によってセグメント化されました。
						<br><br>
						調査を開始した3,735人の候補者のうち、988件の記録が分析に使用されました。2,700人以上の候補者が、広範な事前スクリーニング、調査スクリーニングの質問、および回答者が所属する組織に代わって質問に正確に回答するのに十分なクラウドネイティブの知識と専門的経験を持っていることを確認するためのデータ品質チェックのために失格となりました。その結果、90%の信頼水準で±2.6%の誤差範囲が得られました。
						<br><br>
						実世界での採用に焦点を当てた調査を行うために、クラウド コンピューティング、コンテナ、Kubernetesの採用に関する質問に回答した回答者のうち、主な収入源がクラウドネイティブな製品とサービスの提供にある回答者も除外しました。
						<br><br>
						今年は、回答者が自分の役割や経験の範囲外であるために回答できなかった場合を説明するために、ほぼすべての質問に対する回答リストに”わからない、または確かでない”（DKNS）の回答を追加しました。
						<br><br>
						四捨五入の関係上、合計が100%にならない場合がある点についてもご注意ください。
					</p>
					</div>
					<div class="section-02__grid-col2">
						<p class="sub-header">レポートの作成者</p>

						<a href="https://www.cncf.io"
							title="Visit CNCF.io website">
							<img loading="lazy" width="317" height="50" src="
							<?php LF_Utils::get_svg( $report_folder . 'logo-cncf.svg', true ); ?>
							" alt="CNCF Logo">
						</a>

						<a href="https://www.linuxfoundation.org/research"
							title="Visit LF Research website">
							<img loading="lazy" width="317" height="56" src="
							<?php LF_Utils::get_svg( $report_folder . 'logo-lf-research.svg', true ); ?>
							" alt="Linux Foundation Research Logo">
						</a>
					</div>
				</div>
			</div>
		</section>

		<section id="demographics"
			class="section-03 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">人口統計</h2>
					<div class="section-number">2/3</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-8-col">
						2023年の報告書は対象範囲が世界的であり、6つの大陸から、また、公的機関、民間機関、NGOから、新興企業、企業部門に至るまで、様々な業種から回答を得ています。
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<p class="sub-header">組織の本部の地域</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<picture>
					<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'attendee-geography-map-mobile.svg', true );
?>
">
					<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'attendee-geography-map-desktop.svg', true );
?>
">
					<img width="1200" height="604" src="
<?php
Lf_Utils::get_svg( $report_folder . 'attendee-geography-map-desktop.svg', true );
?>
" alt="Of all respondee organizations, 42% are from North America, 30% from Europe, 7% from Asia Pacific."
						loading="lazy">
				</picture>

				<div class="shadow-hr"></div>

				<p class="sub-header text-center">職務上位3</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="section-03__grid lf-grid">
					<div class="section-03__grid-col1">
						<p
							class="jf__title">SRE /<br/>DevOpsエンジニア</p>
						<div class="thin-hr jf__hr"></div>
						<span class="jf__number">39%</span>
					</div>
					<div class="section-03__grid-col2">
						<p class="jf__title">ソフトウェア<br/>アーキテクト</p>
						<div class="thin-hr jf__hr"></div>
						<span class="jf__number">27%</span>
					</div>
					<div class="section-03__grid-col3">
						<p class="jf__title">DEVOPS<br/>マネジメント</p>
						<div class="thin-hr jf__hr"></div>
						<span class="jf__number">20%</span>
					</div>
				</div>
				<div class="shadow-hr"></div>
				<p class="sub-header">組織の従業員数</p>
				<div aria-hidden="true" class="report-spacer-60"></div>
				<picture>
					<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'organizations-employees-mobile.svg', true );
?>
">
					<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'organizations-employees-desktop.svg', true );
?>
">
					<img width="1200" height="481" src="
<?php
Lf_Utils::get_svg( $report_folder . 'organizations-employees-desktop.svg', true );
?>
" alt="Respondents organizations - 1-99 employees was 24%, 100-999 employees was 30%, 1000-4999 employees was 20%, over 5000 was 26%."
						loading="lazy">
				</picture>

				<div class="shadow-hr"></div>

				<p class="sub-header">CNCFエンドユーザーの技術的な経験</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<picture>
					<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'end-users-technical-experience-mobile.svg', true );
?>
">
					<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'end-users-technical-experience-desktop.svg', true );
?>
">
					<img width="1200" height="407" src="
<?php
Lf_Utils::get_svg( $report_folder . 'end-users-technical-experience-desktop.svg', true );
?>
" alt="42% of end user respondents have 6-10 years of technical experience."
						loading="lazy">
				</picture>

			</div>
		</section>

		<section id="findings"
			class="section-04 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">主な調査結果</h2>
					<div class="section-number">3/3</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-10-col">
						<p class="larger-sub-header">KUBERNETESがコア テクノロジーとしての地位を強化</p>
					</div>
				</div>
				<div aria-hidden="true" class="report-spacer-20"></div>

				<div class="lf-grid as23__grid">
					<div class="as23__grid-col1">
						<p>2021年のCNCF年次調査では、Kubernetesが採用の隔たりを越えて主流のグローバル テクノロジーになったと述べました。今日、遅れていた人々がようやく追いつきつつあります。

						<p>今年のクラウドの採用、コンテナ、Kubernetesの分析には、クラウドネイティブな製品とサービスの提供から主な収入源を得ている組織（主にベンダー）は含まれていませんでした。クラウド ビジネスには従事していないが、クラウド サービスを利用する潜在的または実際の理由がある組織に調査を集中させることで、クラウド製品とサービスの採用、メリット、課題について、より正確な見解を得ようとしました。クラウド サービスの消費者とプロバイダの両方が含まれているため、採用率は2022年の指標よりも低くなると予想していました。そのため、2023年とそれ以前の年との直接的な比較は行いませんでした。しかし、2022年には、プロバイダと消費者（サンプル全体）の58%が本番環境でKubernetesを使用しており、23%（合計81%）が積極的に評価していました。2023年には、潜在的/実際の消費者の66%が本番環境でKubernetesを使用しており、18%（合計84%）が評価していました。</p>

						<p>調査結果をまとめると、クラウド コンピューティング サービスを利用している組織のうち、Kubernetesを使用する計画がないのはわずか15%であると回答者は報告しています。クラウドの経済性が改善され続け、急成長するAI運動におけるKubernetesの基本的な役割が、Linuxカーネルのようなグローバルな技術エコシステムに不可欠なコア技術としてのプロジェクトの地位を確固たるものにするにつれて、この数は減少する可能性が高いです。</p>
					</div>
					<div class="as23__grid-col2">
						<p class="sub-header">KUBERNETESの<br/>使用または評価</p>

						<span class="sidebar-number">84%</span>

						2022年の81%から増加
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<p
					class="question">あなたの組織では、どの程度までクラウドネイティブ テクノロジーを採用していますか？</p>
					<img loading="lazy" width="1186" height="531" src="
					<?php LF_Utils::get_svg( $report_folder . 'adoption-chart.svg', true ); ?>
					" alt="To what extent has your organization adopted cloud native technologies?">

				<div class="shadow-hr"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p class="larger-sub-header">インキュベーションおよび卒業プロジェクト全体でプロジェクトの利用が増加傾向にあります</p>
						<p class="larger-sub-sub-header">最大の利用増加（2023年の増加）2022ー2023</p>
					</div>
				</div>
				<picture>
					<source media="(max-width: 599px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'project-usage-trends-mobile.svg', true );
?>
">
					<source media="(min-width: 600px)" srcset="
<?php
Lf_Utils::get_svg( $report_folder . 'project-usage-trends-desktop.svg', true );
?>
">
					<img width="1206" height="444" src="
<?php
Lf_Utils::get_svg( $report_folder . 'cproject-usage-trends-desktop.svg', true );
?>
" alt="Project usage trends upwards across incubating and graduating projects"
						loading="lazy">
				</picture>

				<div class="shadow-hr"></div>

				<div class="lf-grid">
				<div class="restrictive-9-col">
					<p>CNCFプロジェクトの利用は、景気後退期に好調を維持しただけでなく、増加しました。テクノロジー部門は2022年後半から2023年にかけて無数のレイオフで揺れ動きました。実際、Layoffs.fyiがまとめたデータによりますと、2,000社以上のテック企業がこの期間に約428,000人のスタッフをレイオフしました。しかし、CNCFプロジェクトの関与（本番利用と評価を組み合わせたもの）を比較すると、段階的プロジェクトとインキュベーション プロジェクトの間で一方的な増加が見られ、成長リーダーの上位5つの増加は17～35%の範囲でした。</p>

					<p>これらの成果の大部分は、コンテナ オーケストレーション、可観測性、業界標準のコンテナ ランタイム、およびコンテナ ネットワーキングに関連するプロジェクトによって実現されました。Kubernetes、Helm、Prometheusなどのプロジェクトでは、本番利用の成長と浸透を高める余地がまだあります。</p>

					<p>しかし、景気後退によるプロジェクトの犠牲者も出ました。2022年と2023年の回答を比較すると、サービス メッシュ（24%から21%）、サービス プロキシ（34%から21%）、サーバレス アーキテクチャおよび/またはfunctions as a service（22%から13%）など、さまざまなアクティビティと製品の普及率が低下していることがわかりました。</p>

					<p>この時期に組織が裁量的な支出や投資を抑制するのは当然であり、ここで特定された技術の多くは将来の生産性と競争力にとって重要ではありますが、必要な支出ではありません。</p>
				</div>
				</div>
				<div aria-hidden="true" class="report-spacer-100"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p class="larger-sub-header">2022年から2023年にかけて、CNCFプロジェクトを卒業またはインキュベーションにある、本番環境に使用または評価されたCNCFトップ10の浸透</p>
					</div>
				</div>
				<div aria-hidden="true" class="report-spacer-60"></div>

				<img loading="lazy" width="1170" height="835" src="
					<?php LF_Utils::get_svg( $report_folder . 'project-pen.svg', true ); ?>
					" alt="Penetration of CNCF top ten graduated or incubating CNCF projects being used in production or evaluated from 2022 to 2023">

				<div class="shadow-hr"></div>

				<p class="question">これらの卒業したCNCFプロジェクトのうち、あなたの組織が本番環境に使用または評価に使用しているのはどれですか？</p>

				<picture>
					<source media="(max-width: 599px)" srcset="
						<?php
						Lf_Utils::get_svg( $report_folder . 'using-chart-mobile.svg', true );
						?>
						">
											<source media="(min-width: 600px)" srcset="
						<?php
						Lf_Utils::get_svg( $report_folder . 'using-chart-desktop.svg', true );
						?>
						">
											<img width="1200" height="341" src="
						<?php
						Lf_Utils::get_svg( $report_folder . 'using-chart-desktop.svg', true );
						?>
						" alt="Which of these graduated CNCF projects is your organization using in production or evaluating?"
						loading="lazy">
				</picture>

				<div class="shadow-hr"></div>

				<p class="question">これらのインキュベーションCNCFプロジェクトのうち、あなたの組織が本番環境で使用または評価に使用しているのはどれですか?</p>

				<picture>
					<source media="(max-width: 599px)" srcset="
						<?php
						Lf_Utils::get_svg( $report_folder . 'using-chart-incubating-mobile.svg', true );
						?>
						">
											<source media="(min-width: 600px)" srcset="
						<?php
						Lf_Utils::get_svg( $report_folder . 'using-chart-incubating-desktop.svg', true );
						?>
						">
											<img width="1200" height="341" src="
						<?php
						Lf_Utils::get_svg( $report_folder . 'using-chart-incubating-desktop.svg', true );
						?>
						" alt="Which of these incubating CNCF projects is your organization using in production or evaluating?"
						loading="lazy">
				</picture>

				<div class="shadow-hr"></div>

				<div class="lf-grid">
					<div class="restrictive-10-col">
						<p class="larger-sub-header">パブリック クラウドは広く採用されており、大規模な組織はハイブリッド ソリューションに傾いています</p>
					</div>
				</div>
				<div aria-hidden="true" class="report-spacer-20"></div>

				<div class="lf-grid as23__grid">
					<div class="as23__grid-col1">
						<p>パブリック クラウドの使用は、その導入の容易さ、堅牢なセキュリティ、および最小限のベンダー ロックインのおかげで、組織にとって好ましい方法です。実際、データをどのようにセグメント化するかにかかわらず、パブリック クラウドの使用が最も重要です。</p>

						<p>クラウドへの移行を始めたばかりの組織は、パブリック クラウド（58%）を好みますが、ハイブリッド クラウド（29%）は敬遠しています。これは、パブリック クラウドの参入障壁が低く、一度導入されればクラウド戦略の重要な要素であり続ける可能性があるためと考えられます。</p>

						<p>大規模な組織は、すべてのクラウド タイプ（パブリック、プライベート、およびハイブリッド）に魅力を感じていますが、中規模（44%）および小規模（27%）の組織と比較して、ハイブリッド クラウドの主な利用者（56%）です。</p>

						<p>マルチ クラウド ソリューションが一般的になりました。パブリック クラウドのみの使用は、組織の28%で使用されている戦略であり、組織で使用されている一意のパブリック クラウド サービス プロバイダの平均数は2.3です。マルチ クラウド ソリューション（ハイブリッドおよびその他のクラウドの組み合わせ）は、組織の56%で使用されています。マルチ クラウド ソリューションにより、一意のクラウド サービス プロバイダの平均数が1つ、場合によっては2つ増加します。</p>
					</div>
					<div class="as23__grid-col2">
						<span class="sidebar-number">2.8</span>
						ユニークなクラウド サービス プロバイダの平均数
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>


				<p class="question">あなたの組織では、次のデータ センターとクラウド アーキテクチャの組み合わせのうち、どれを使用していますか？</p>
				<p class="larger-sub-sub-header">採用によるセグメント化</p>

				<picture>
					<source media="(max-width: 599px)" srcset="
						<?php
						Lf_Utils::get_svg( $report_folder . 'data-center-sba-mobile.svg', true );
						?>
						">
											<source media="(min-width: 600px)" srcset="
						<?php
						Lf_Utils::get_svg( $report_folder . 'data-center-sba-desktop.svg', true );
						?>
						">
											<img width="1200" height="341" src="
						<?php
						Lf_Utils::get_svg( $report_folder . 'data-center-sba-desktop.svg', true );
						?>
						" alt="Which of the following combinations of data center and cloud architectures does your organization use? Segmented by Adoption."
						loading="lazy">
				</picture>
				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="question">あなたの組織では、次のデータ センターとクラウド アーキテクチャの組み合わせのうち、どれを使用していますか？</p>
				<p class="larger-sub-sub-header">総従業員数でセグメント化</p>

				<picture>
					<source media="(max-width: 599px)" srcset="
						<?php
						Lf_Utils::get_svg( $report_folder . 'data-center-sbe-mobile.svg', true );
						?>
						">
											<source media="(min-width: 600px)" srcset="
						<?php
						Lf_Utils::get_svg( $report_folder . 'data-center-sbe-desktop.svg', true );
						?>
						">
											<img width="1200" height="341" src="
						<?php
						Lf_Utils::get_svg( $report_folder . 'data-center-sbe-desktop.svg', true );
						?>
						" alt="Which of the following combinations of data center and cloud architectures does your organization use? Segmented by Employees."
						loading="lazy">
				</picture>


				<div class="shadow-hr"></div>

				<p class="question">あなたの組織では、次のデータ センターとクラウド アーキテクチャの組み合わせのうち、どれを使用していますか？</p>

				<picture>
					<source media="(max-width: 599px)" srcset="
						<?php
						Lf_Utils::get_svg( $report_folder . 'data-centers-mobile.svg', true );
						?>
						">
											<source media="(min-width: 600px)" srcset="
						<?php
						Lf_Utils::get_svg( $report_folder . 'data-centers-desktop.svg', true );
						?>
						">
											<img width="1200" height="341" src="
						<?php
						Lf_Utils::get_svg( $report_folder . 'data-centers-desktop.svg', true );
						?>
						" alt="Which of the following combinations of data center and cloud architectures does your organization use?"
						loading="lazy">
				</picture>

				<div class="shadow-hr"></div>

				<p class="question">あなたの組織では、次のデータ センターとクラウド アーキテクチャの組み合わせのうち、どれを使用していますか?</p>

				<picture>
					<source media="(max-width: 599px)" srcset="
						<?php
						Lf_Utils::get_svg( $report_folder . 'data-centers-bubble-mobile.svg', true );
						?>
						">
											<source media="(min-width: 600px)" srcset="
						<?php
						Lf_Utils::get_svg( $report_folder . 'data-centers-bubble-desktop.svg', true );
						?>
						">
											<img width="1386" height="670" src="
						<?php
						Lf_Utils::get_svg( $report_folder . 'data-centers-bubble-desktop.svg', true );
						?>
						" alt="Which of the following combinations of data center and cloud architectures does your organization use?"
						loading="lazy">
				</picture>

				<div class="shadow-hr"></div>

				<div class="lf-grid">
				<div class="restrictive-9-col">
					<p
						class="larger-sub-header">APACのクラウド ネイティブ コンピューティングの利用は北米と欧州に後れを取っています</p>

				</div>
				</div>
				<div aria-hidden="true" class="report-spacer-20"></div>

				<div class="lf-grid as23__grid">
					<div class="as23__grid-col1">
						<p>アジア太平洋地域（APAC）は、エンドユーザー組織（主な収益がクラウドネイティブ製品およびサービスの販売から得られない組織）全体でのクラウドネイティブ テクノロジーの採用において、北米およびヨーロッパに大きく遅れをとっています。データをフィルタリングしてベンダーを削除し、エンドユーザー組織に焦点を当てると、アジア太平洋地域の26%がクラウドネイティブ技術を使用し始めていないか、使用し始めたばかりであるのに対し、南北アメリカでは9%、ヨーロッパでは6%です。同様に、アジア太平洋地域のエンドユーザー組織のうち、ほぼすべての開発を行っているのはわずか9%であり、21%がクラウドネイティブ技術を使用して開発の多くを行っています。合計で30%です。南北アメリカでは、この合計（ほぼすべてまたは多くの開発および導入がクラウドネイティブ技術を使用しています）は64%、ヨーロッパでは61%です。</p>
						<p>アジア太平洋地域の国レベルでのセグメント化を見ると、クラウドネイティブ技術の利用を開始していない、または開始したばかりの組織の割合は、どの国でも主要なテーマですが、特に日本ではそうです。クラウドネイティブ技術の利用を開始していない、または開始したばかりの組織の普及率は、日本では18%であり、GDPがほぼ同じ国であるインド（6%）の3倍です。GDPが日本の4倍以上である中国でさえ、未開始/開始したばかりの普及率は13%です。</p>
						<p>アジア太平洋地域では、高速インターネットサービスの不足、システムやスタッフをクラウドコンピューティングパラダイムに移行させるためのコスト、セキュリティ、制御、信頼性に関する懸念、スキル不足、レガシーシステムへの深い依存など、克服すべき多くの課題があります。しかし、デジタル変革への政府の投資はかつてないほど高く、クラウドの採用ペースが急速に変化していることを示唆しています。</p>
					</div>
					<div class="as23__grid-col2">
						”一部”または”ほぼ/全て”の開発および導入がクラウドネイティブ技術
						<span class="sidebar-number-green">82% ヨーロッパ</span>
						<span class="sidebar-number-purple">70% 南北アメリカ</span>
						<span class="sidebar-number-gold">40% アジア太平洋地域</span>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="question">あなたの組織の本部はどこにありますか？</p>
				<p class="larger-sub-sub-header">組織がクラウドネイティブの手法を導入しているセグメント化</p>

				<img loading="lazy" width="1170" height="835" src="
					<?php LF_Utils::get_svg( $report_folder . 'location-sba-desktop.svg', true ); ?>
					" alt="What is the location of your organization's headquarters?">

				<div class="shadow-hr"></div>


				<p class="question">あなたの組織の本部はどこにありますか？</p>
				<p class="larger-sub-sub-header">組織がクラウドネイティブの手法を導入しているセグメント化</p>

				<picture>
					<source media="(max-width: 599px)" srcset="
						<?php
						Lf_Utils::get_svg( $report_folder . 'location-sbe-mobile.svg', true );
						?>
						">
											<source media="(min-width: 600px)" srcset="
						<?php
						Lf_Utils::get_svg( $report_folder . 'location-sbe-desktop.svg', true );
						?>
						">
											<img width="1226" height="885" src="
						<?php
						Lf_Utils::get_svg( $report_folder . 'location-sbe-desktop.svg', true );
						?>
						" alt="What is the location of your organization's headquarters?"
						loading="lazy">
				</picture>

				<div class="shadow-hr"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>ただし、アジア太平洋地域のITベンダーとサービス プロバイダは、北アメリカやヨーロッパよりも新しいテクノロジーに強い親和性を持っていることは注目に値します。WebAssembly、サービス プロキシ、サービス メッシュ、およびサーバレス アーキテクチャーの採用が多いと報告されています。これは特に、WebAssemblyが21%の組織で採用されているのに対し、ヨーロッパでは14%、南北アメリカでは11%であることからも明らかです。</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="question">あなたやあなたの組織は、webAssemblyを使ってアプリケーションをデプロイしたことがありますか？</p>
				<p class="larger-sub-sub-header">組織の本社の場所によってセグメント化</p>

				<img loading="lazy" width="1202" height="815" src="
					<?php LF_Utils::get_svg( $report_folder . 'wasm-desktop.svg', true ); ?>
					" alt="Have you or your organization ever deployed an application using webAssembly?">

				<div class="shadow-hr"></div>

				<div class="lf-grid">
				<div class="restrictive-9-col">
					<p
						class="larger-sub-header">コンテナはクラウドネイティブ ソリューションを提供するための中核ですが、課題がないわけではありません</p>

				</div>
				</div>
				<div aria-hidden="true" class="report-spacer-20"></div>

				<div class="lf-grid as23__grid">
					<div class="as23__grid-col1">
						<p>コンテナの使用（コンテナのパイロットや積極的な評価を行っている組織を含みます）は90%以上であり、アプリの開発とデプロイの多く、あるいはほぼすべてがクラウドネイティブである組織の90%以上がコンテナに依存しています。</p>
						<p>しかし、コンテナを使用することに課題がないわけではありません。セキュリティは、クラウドサービスの潜在的または一般的な利用者である組織の40%が報告しているように、主要な課題です。</p>
						<p>監視と可観測性は、特に多数のコンテナを持つシステムでは、急速に困難になってきています。コンテナを大規模に実行するには、プロアクティブなシステム管理をサポートするために、メトリック、イベント、ログのリアルタイム データ収集が必要であるため、PrometheusやOpen Telemetryのようなプロジェクトが2023年に広く採用されたのは驚くことではありません（参照：プロジェクトの浸透は、インキュベーション プロジェクトと卒業プロジェクトの間で増加傾向にあります）。</p>
					</div>
					<div class="as23__grid-col2">
						<span class="sidebar-number">46%</span>
						クラウドネイティブへの移行を開始していない、または開始したばかりの組織が直面している最大の課題は、トレーニングの不足であると述べています
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="question">組織内でのコンテナの使用方法はなんですか？</p>
				<p class="larger-sub-sub-header">クラウドネイティブ テクノロジーを採用している組織によるセグメント化</p>

				<picture>
					<source media="(max-width: 599px)" srcset="
						<?php
						Lf_Utils::get_svg( $report_folder . 'containers-mobile.svg', true );
						?>
						">
											<source media="(min-width: 600px)" srcset="
						<?php
						Lf_Utils::get_svg( $report_folder . 'containers-desktop.svg', true );
						?>
						">
											<img width="1226" height="885" src="
						<?php
						Lf_Utils::get_svg( $report_folder . 'containers-desktop.svg', true );
						?>
						" alt="How are Containers Used Within your Organization?"
						loading="lazy">
				</picture>

				<div class="shadow-hr"></div>

				<p class="question">コンテナの使用/デプロイにおける課題は何か？</p>
				<p class="larger-sub-sub-header">クラウドネイティブ テクノロジーを採用している組織によるセグメント化</p>

				<picture>
					<source media="(max-width: 599px)" srcset="
						<?php
						Lf_Utils::get_svg( $report_folder . 'challenges-desktop.svg', true );
						?>
						">
											<source media="(min-width: 600px)" srcset="
						<?php
						Lf_Utils::get_svg( $report_folder . 'challenges-desktop.svg', true );
						?>
						">
											<img width="1226" height="885" src="
						<?php
						Lf_Utils::get_svg( $report_folder . 'challenges-desktop.svg', true );
						?>
						" alt="What are your Challenges in Using / Deploying Containers?"
						loading="lazy">
				</picture>








			</div>
		</section>

		<section class="section-07 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="lf-grid thanks">
					<div class="thanks__col1">
						<h2 class="section-header">ありがとうございます</h2>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<p
							class="thanks__opening">アンケートにご参加いただいた皆様に深く感謝いたします。</p>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<div class="wp-block-button hero__button"><a
								href="https://data.world/thelinuxfoundation/2023-cncf-annual-survey"
								class="wp-block-button__link"
								title="View the full dataset">
								データ セット全体を表示する</a>
						</div>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<p>ご質問やご意見がありましたら、<a href="mailto:info@cncf.io">info@cncf.io</a>までご連絡ください。</p>

					</div>
					<div class="thanks__col2">
						<?php
							LF_Utils::display_responsive_images( 103549, 'full', '1200px', '', 'lazy', 'Stacked box-like shapes meant to symbolise containers' );
						?>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p><strong>Copyright © 2024 The Linux Foundation</strong><br>このレポートは、Creative Commons Attribution-NoDerivatives 4.0 International Public Licenseの下でライセンスされています。<br class="show-over-1000">レポートを参考する時は、”Cloud Native Computing Foundation Annual Survey 2023”と記載してください。</p>


			</div>
		</section>


	</article>
</main>
<?php
// 83148

get_template_part( 'components/footer' );
