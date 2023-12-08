<?php
/**
 * Template Name: KCCNC OSS 23 Transparency CN
 * Template Post Type: lf_report
 *
 * File for the KCCNC OSS CN 2023 Transparency Report in Chinese
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
$report_folder = 'reports/kccnc-oss-23/'

?>

<link rel="prefetch"
	href="<?php echo esc_url( get_template_directory_uri() . '/build/kccnc-oss-23-transparency.min.css' ); ?>"
	as="style" crossorigin="anonymous" />

<?php wp_enqueue_style( 'kccnc-oss-23', get_template_directory_uri() . '/build/kccnc-oss-23-transparency.min.css', array(), filemtime( get_template_directory() . '/build/kccnc-oss-23-transparency.min.css' ), 'all' ); ?>

<main class="kccnc-oss-23">
	<article class="container wrap">

		<section class="hero alignfull background-image-wrapper">
			<figure class="background-image-figure swirl">
				<?php
					LF_Utils::display_responsive_images( 98536, 'full', '1200px', null, 'eager', 'Swirl illustration' );
				?>
			</figure>
			<figure class="background-image-figure skyline">
				<picture>
					<source media="(max-width: 599px)"
						srcset="<?php echo esc_url( wp_get_attachment_image_url( 98535, 'full', false ) ); ?>">
					<source media="(min-width: 600px)"
						srcset="<?php echo esc_url( wp_get_attachment_image_url( 98534, 'full', false ) ); ?>">
					<?php
							LF_Utils::display_responsive_images(
								98534,
								'full',
								'1200px',
								null,
								'eager',
								'An illustration of the Shangahi city skyline.'
							);
							?>
				</picture>
			</figure>

			<div class="background-image-text-overlay">
				<div class="container wrap hero__container">
					<div class="hero__wrapper">
						<img class="hero__logo"
							src="<?php LF_Utils::get_svg( $report_folder . 'logo-kccnc-oss-23.svg', true ); ?>"
							width="204" height="132"
							alt="KubeCon + CloudNativeCon + Open Source Summit China 2023 Logo"
							loading="eager"
							decoding="async"
							>
						<h1 class="hero__title uppercase">透明度报告</h1>

						<div class="hero__button-share-align">
							<?php
							get_template_part( 'components/social-share' );
							?>

							<div class="wp-block-button hero__button"><a
									href="https://www.cncf.io/reports/kubecon-cloudnativecon-open-source-summit-china-2023/" class="nowrap wp-block-button__link"
									title="Read the report in English">English Version</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- Intro  -->
		<section class="section-01">

			<div class="lf-grid">
				<h2 class="section-01__title">您好，上海！</h2>
			</div>

			<div class="lf-grid section-01__grid">
				<div class="section-01__grid-col1">

				<p>我们花了比预期多几年的时间，但最终我们的中国社区齐聚上海参加 KubeCon + CloudNativeCon + Open Source Summit China 2023，真是太棒了。能够实现这一目标对我们来说很重要，因为中国是云原生生态系统的关键参与者。</p>

				<p>自 2015 年云原生计算基金会 (CNCF) 成立以来，中国对 CNCF 项目的贡献超过了除美国以外的任何其他国家/地区，占所有贡献的 9%，令人难以置信。事实上，今年对 CNCF 的云原生开源贡献中有 12% 来自中国的维护者和组织。此外，还有 32 个 CNCF 项目源自中国，其中包括 Harbour 和 TiKV 等分级项目。</p>

				<p>对我个人而言，这是一次与正在塑造云原生技术未来的维护者和贡献者重新建立联系的机会。了解中国的云原生以及您正在推动的举措如何改变软件构建方式（从为人工智能工作负载提供动力和加速人工智能应用，到大规模的金融级工程实践），这很令人鼓舞。</p>

				<p>这次有深刻见解的的活动有很多信息值得挖掘，当我们为您整理这份透明度报告时，我很高兴回顾这一过程。希望您觉得这些信息很有价值。</p>

					<div class="author">
						<?php LF_Utils::display_responsive_images( 98512, 'full', '75px', null, 'lazy', 'Chris Aniszczyk' ); ?>
						<p><strong>Chris Aniszczyk</strong><br>
						首席技术官 – CNCF</p>
					</div>
				</div>

				<div class="section-01__grid-col2">
					<h3 class="sub-header">KubeCon + CloudNativeCon + Open
						Source Summit China—览</h3>
					<!-- Icon 1  -->
					<div class="icon-box-1">
						<div class="icon">
							<img
							loading="lazy"
							decoding="async"
							width="65"
							height="65"
							src="<?php LF_Utils::get_svg( $report_folder . 'icon-badge.svg', true ); ?>"
							alt="Badge icon"
>
						</div>
						<div class="text">
							<span>61%</span><br />
							 为首次参会者
						</div>
					</div>

					<!-- Icon 2  -->
					<div class="icon-box-1">
						<div class="icon">
							<img loading="lazy" decoding="async" width="65" height="65" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-heart.svg', true ); ?>
" alt="Heart icon">
						</div>
						<div class="text">
							<span>589</span><br />
							议题投稿
						</div>
					</div>

					<!-- Icon 3  -->
					<div class="icon-box-1">
						<div class="icon">
							<img loading="lazy" decoding="async" width="65" height="65" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-person.svg', true ); ?>
" alt="Person icon">
						</div>
						<div class="text">
							<span>86</span><br />
							名参会者获取Dan Kohn 奖学金基金
						</div>
					</div>

					<!-- Icon 4  -->
					<div class="icon-box-1">
						<div class="icon">
							<img loading="lazy" decoding="async" width="65" height="65" src="
<?php LF_Utils::get_svg( $report_folder . 'icon-megaphone.svg', true ); ?>
" alt="Megaphone icon">
						</div>
						<div class="text">
							<span>184</span><br />
							条媒体报道
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
						<h3 class="sub-header">照片精选</h3>
					</div>
					<div class="wp-block-column is-vertically-aligned-bottom"
						style="flex-basis:20%">
						<p
							class="has-text-align-right is-style-link-cta"><a href="https://www.flickr.com/photos/143247548@N03/albums/72177720311405294/" title="KubeCon + CloudNativeCon + Open Source Summit China 2023 Photo Gallery">查看更多</a></p>
					</div>
				</div>

				<div class="section-02__slider">
					<div>
						<?php LF_Utils::display_responsive_images( 98516, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon + Open Source Summit China 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 98517, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon + Open Source Summit China 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 98518, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon + Open Source Summit China 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 98519, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon + Open Source Summit China 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 98520, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon + Open Source Summit China 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 98521, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon + Open Source Summit China 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 98522, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon + Open Source Summit China 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 98523, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon + Open Source Summit China 2023' ); ?>
					</div>
					<div>
						<?php LF_Utils::display_responsive_images( 98524, 'newsroom-post-width', '700px', null, 'lazy', 'Photos from Kubecon + CloudNativeCon + Open Source Summit China 2023' ); ?>
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
					<h2 class="section-header">参会者概述</h2>
					<div class="section-number">1/6</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-10-col">
						<p
							class="opening-paragraph">能够亲自让我们的中国社区聚集在一起，真是太棒了，有超过 <strong>1900</strong> 人到上海参加了我们的会议，另有 <strong>139</strong> 人在线登录观看了主题演讲直播。</p>
					</div>
				</div>

				<p class="sub-header">人口统计资料</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<picture>
					<source media="(max-width: 599px)"
						srcset="<?php LF_Utils::get_svg( $report_folder . 'demographics-mobile-cn.svg', true ); ?>">
					<source media="(min-width: 600px)"
						srcset="<?php LF_Utils::get_svg( $report_folder . 'demographics-desktop-cn.svg', true ); ?>">
					<img loading="lazy" decoding="async" width="1200" height="404"
						src="<?php LF_Utils::get_svg( $report_folder . 'demographics-desktop-cn.svg', true ); ?>"
						alt="Total Registered attendees 1910, 84% in person, 61% first timers.">
				</picture>

				<div class="shadow-hr"></div>

				<p class="sub-header">与会者地区分布</p>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<img loading="lazy" decoding="async" width="1200" height="404" src="<?php LF_Utils::get_svg( $report_folder . 'attendee-geography-map-desktop-cn.svg', true ); ?>
" alt="Map of attendee geography, 89% of attendees were from China.">

				<div class="shadow-hr"></div>

				<p class="sub-header is-centered">前3个工作职能</p>

				<div class="lf-grid section-03__top-jobs">
					<div class="section-03__top-jobs-col1">
						<p class="table-header">开发人员</p>
						<span class="large">607</span>
					</div>
					<div class="section-03__top-jobs-col2">
						<p class="table-header">架构师</p>
						<span class="large">345</span>
					</div>
					<div class="section-03__top-jobs-col3">
						<p class="table-header">开发人员/SRE/系统管理员</p>
						<span class="large">258</span>
					</div>
				</div>

				<button class="button-reset section-03__button"
					data-id="js-hidden-section-trigger-open">
					查看完整列表
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
												<th>参会者的工作职能情况
												</th>
												<th>总人数</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>架构师</td>
												<td>345</td>
											</tr>
											<tr>
												<td>业务运营</td>
												<td>84</td>
											</tr>
											<tr>
												<td>开发人员后援</td>
												<td>607</td>
											</tr>
											<tr>
												<td> - 数据科学家</td>
												<td>31</td>
											</tr>
											<tr>
												<td> - 全栈开发人员</td>
												<td>185</td>
											</tr>
											<tr>
												<td> - 机器学习专家</td>
												<td>25</td>
											</tr>
											<tr>
												<td> - 网络开发人员</td>
												<td>7</td>
											</tr>
											<tr>
												<td> - 移动开发人员</td>
												<td>42</td>
											</tr>
											<tr>
												<td>开发运营/SRE/系统管理员</td>
												<td>258</td>
											</tr>
											<tr>
												<td>经理</td>
												<td>149</td>
											</tr>
											<tr>
												<td>IT 运营</td>
												<td>46</td>
											</tr>
											<tr>
												<td> - 开发运营</td>
												<td>9</td>
											</tr>
											<tr>
												<td> - 系统管理员</td>
												<td>6</td>
											</tr>
											<tr>
												<td> - 网站可靠性工程师
												</td>
												<td>2</td>
											</tr>
											<tr>
												<td> - 质量保证工程师</td>
												<td>2</td>
											</tr>
											<tr>
												<td>销售/营销</td>
												<td>80</td>
											</tr>
											<tr>
												<td>媒体/分析师</td>
												<td>60</td>
											</tr>
											<tr>
												<td>学生</td>
												<td>69</td>
											</tr>
											<tr>
												<td>产品经理</td>
												<td>93</td>
											</tr>
											<tr>
												<td>教授/学者</td>
												<td>31</td>
											</tr>
											<tr>
												<td>其他</td>
												<td>88</td>
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
												<th>参会者所在行业
												</th>
												<th>总人数</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>汽车</td>
												<td>85</td>
											</tr>
											<tr>
												<td>消费品</td>
												<td>31</td>
											</tr>
											<tr>
												<td>能源</td>
												<td>23</td>
											</tr>
											<tr>
												<td>金融</td>
												<td>104</td>
											</tr>
											<tr>
												<td>医疗保健</td>
												<td>26</td>
											</tr>
											<tr>
												<td>工业</td>
												<td>46</td>
											</tr>
											<tr>
												<td>信息技术</td>
												<td>1,338</td>
											</tr>
											<tr>
												<td>材料</td>
												<td>9</td>
											</tr>
											<tr>
												<td>非营利组织</td>
												<td>64</td>
											</tr>
											<tr>
												<td>专业服务</td>
												<td>110</td>
											</tr>
											<tr>
												<td>电信</td>
												<td>74</td>
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
					隐藏完整列表
				</button>

				<div class="shadow-hr"></div>

				<p class="sub-header">年度同比注册</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<img loading="lazy" decoding="async" width="1200" height="604" src="
			<?php LF_Utils::get_svg( $report_folder . 'yoy-growth-chart-cn.svg', true ); ?>
			" alt="Chart showing year over year attendee growth">
			</div>
		</section>

		<section class="section-05">
			<div class="kccnc-table-container">
				<table class="kccnc-table growth-table">
					<thead>
						<tr>
							<th>类型</th>
							<th>2018</th>
							<th>2019</th>
							<th>2021</th>
							<th>2023</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>总参会人数</td>
							<td>2,500</td>
							<td>3,500</td>
							<td>7,160</td>
							<td>1,910</td>
						</tr>
						<tr>
							<td class="nowrap">全场通行票</td>
							<td>63%</td>
							<td>46%</td>
							<td>78%</td>
							<td>54%</td>
						</tr>
						<tr>
							<td class="nowrap">全场通行贵宾票</td>
							<td>5%</td>
							<td>5%</td>
							<td>N/A</td>
							<td>3%</td>
						</tr>
						<tr>
							<td class="nowrap">个人或学术全场通行票
							</td>
							<td>5%</td>
							<td>8%</td>
							<td>N/A</td>
							<td>10%</td>
						</tr>
						<tr>
							<td>演讲者</td>
							<td>8%</td>
							<td>9%</td>
							<td>2%</td>
							<td>13%</td>
						</tr>
						<tr>
							<td>赞助商</td>
							<td>3%</td>
							<td>22%</td>
							<td>5%</td>
							<td>11%</td>
						</tr>
						<tr>
							<td>媒体</td>
							<td>10%</td>
							<td>2%</td>
							<td>&gt;1%</td>
							<td>2%</td>
						</tr>
						<tr>
							<td>主论坛演讲虚拟参与者</td>
							<td>N/A</td>
							<td>N/A</td>
							<td>17%</td>
							<td>7%</td>
						</tr>
					</tbody>
				</table>
			</div>

		</section>

		<section id="content"
			class="section-06 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">投稿內容</h2>
					<div class="section-number">2/6</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p
							class="opening-paragraph">KubeCon + CloudNativeCon + Open Source Summit China 共有 115 场会议，从介绍性会议到技术深入探讨，主题多样。演讲现可在我们的 <a href="https://www.youtube.com/playlist?list=PLj6h78yzYM2OJcjIuAsbbhXAaDrAnuKRB" title="Talks from KubeCon + CloudNativeCon + Open Source Summit China 2023 on YouTube">YouTube 播放列表中找到</a>。</p>
					</div>
				</div>

				<div class="kccnc-table-container">
					<table class="kccnc-table">
						<thead>
							<tr>
								<th>投稿內容</th>
								<th><span class="nowrap">总人数</span></th>
								<th><span class="nowrap">亲自参会人数</span></th>
								<th><span class="nowrap">虚拟参会人数</span></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>议题投稿提交数量</td>
								<td>589</td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>议题投稿接受率</td>
								<td>14%</td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>主论坛演讲场数（包括赞助商主题演讲）</td>
								<td>13</td>
								<td>13</td>
								<td></td>
							</tr>
							<tr>
								<td>分组会议场数</td>
								<td>85</td>
								<td>85</td>
								<td>0</td>
							</tr>
							<tr>
								<td>维护者专场场数</td>
								<td>30</td>
								<td>26</td>
								<td>4</td>
							</tr>
							<tr>
								<td>会议总场数 (分会和维护者专场)</td>
								<td>115</td>
								<td>111</td>
								<td>4</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<p
					class="sub-header">感谢 KUBECON + CLOUDNATIVECON + OPEN SOURCE SUMMIT CHINA 2023 联合主席</p>

				<div class="lf-grid chairs">
					<div class="chairs__col1">
						<?php LF_Utils::display_responsive_images( 98513, 'full', '200px', 'chairs__image', 'lazy', 'Fog Dong' ); ?>
						<p>
<span class="chairs__name">Fog Dong
</span><strong>BentoML</strong><br/>
<span class="chairs__title">高级工程师</span>
</p>
					</div>
					<div class="chairs__col2">
						<?php LF_Utils::display_responsive_images( 98514, 'full', '200px', 'chairs__image', 'lazy', 'Kevin Wang' ); ?>
						<p>
<span class="chairs__name">Kevin Wang</span>
<strong>Huawei</strong><br/>
<span class="chairs__title">王泽峰</span>
</p>
					</div>

					<div class="chairs__col3">
						<?php LF_Utils::display_responsive_images( 98515, 'news-image', '482px', null, 'lazy', 'Our KubeCon + CloudNativeCon + Open Source Summit China 2023 co-chairs' ); ?>
					</div>
				</div>
			</div>
		</section>

		<div class="shadow-hr"></div>

		<section class="section-07 alignfull">
			<div class="container wrap">

				<div aria-hidden="true" class="report-spacer-40"></div>

				<h2 class="section-header-small">投稿内容细分</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-10-col">
					<p>会议联合主席 Fog Dong（BentoML 高级工程师）以及华为云原生开源负责人 Kevin Wang（王泽峰）负责会议日程安排，他们领导了一个由 69 名专家组成的项目委员会，其中包括项目维护者和 CNCF 大使。
					<br>
					<br>
					演讲由项目委员会通过严格、无偏见的流程选出，并随机分配提交的材料以供其专业领域内的审查。您可以阅读我们的 <a href="https://www.lfasiallc.com/kubecon-cloudnativecon-open-source-summit-china/program/submission-reviewer-guidelines/">议题投稿评分指南</a>，特别是有关 <a href="https://www.cncf.io/blog/2021/03/08/a-look-inside-the-kubecon-cloudnativecon-schedule-selection-process/">挑选流程的详细信息</a>。
					<br>
					<br>
					KubeCon + CloudNativeCon + Open Source Summit China 2023 共收到 568 份提交材料。其中，在共 206 名发言者中，我们接受了 115 场演讲，接受率为 14%。
					</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<p class="sub-header">关键数据</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-07__content-breakdown">

					<div class="section-07__content-breakdown-col1">

						<div class="icon-box-6">
							<div class="text">
								<span class="number">589</span><br />
								<span class="description">议题投稿提交数量</span>
							</div>
						</div>
					</div>
					<div class="section-07__content-breakdown-col2">

						<div class="icon-box-6">
							<div class="text">
								<span class="number">206</span><br />
								<span class="description">位发言者</span>
							</div>
						</div>
					</div>
					<div class="section-07__content-breakdown-col3">

						<div class="icon-box-6">
							<div class="text">
								<span class="number">24</span><br />
								<span class="description">终端用户发言人数
									<br>（总计）</span>
							</div>
						</div>
					</div>
					<div class="section-07__content-breakdown-col4">

						<div class="icon-box-6">
							<div class="text">
								<span class="number">160</span><br />
								<span class="description">供应商发言人数<br>（分组会议）
									</span>
							</div>
						</div>
					</div>
					<div class="section-07__content-breakdown-col5">

						<div class="icon-box-6">
							<div class="text">
								<span class="number">41</span><br />
								<span class="description">终端用户发言人数 <br>（分组会议）
									</span>
							</div>
						</div>
					</div>
					<div class="section-07__content-breakdown-col6">

						<div class="icon-box-6">
							<div class="text">
								<span class="number">9.1</span><br />
								<span class="description">SCHED.COM 会话评分（满分 10 分）</span>
							</div>
						</div>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div>


				<p class="sub-header">字幕使用数据</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-07__captioning">
					<div class="section-07__captioning-col1"><span
							class="large">200</span> 小时使 <br> 用现场字幕
					</div>
					<div class="section-07__captioning-col2"><span
							class="large">214</span> 参会者在其移动设备上使用室内 AI 字幕</div>
					<div class="section-07__captioning-col3"><span
							class="large">356</span> 在会议室使用移动AI字幕的小时数
					</div>
					<div class="section-07__captioning-col4"><span
							class="large">2</span> 语言：中文和英文
					</div>
				</div>
			</div>
		</section>

		<div class="shadow-hr"></div>

		<section class="section-08 alignfull">
			<div class="container wrap">

				<h2 class="section-header-small">演讲者多样性</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<p>CNCF 在演讲者中执行性别和多样化平等准则，包括不接受全男性专题讨论小组。</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="kccnc-table-container">
					<table class="kccnc-table">
						<thead>
							<tr>
								<th>演讲者多样性
								</th>
								<th>总人数</th>
								<th>总百分比</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>女性 + 非常规性别者（主题演讲）</td>
								<td>5</td>
								<td>35%</td>
							</tr>
							<tr>
								<td>男性（主题演讲）</td>
								<td>9</td>
								<td>65%</td>
							</tr>
							<tr>
								<td>女性 + 非常规性别者（分组会议）</td>
	
								<td>40</td>
								<td>21%</td>
							</tr>
							<tr>
								<td>男性（分组会议）</td>
								<td>153</td>
								<td>79%</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="section-header-small"> Dan Kohn 奖学金基金</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<p>Dan Kohn 奖学金基金为 <strong>86</strong> 名申请人提供了亲自参会的机会，其中包括多元化、基于需求的维护者和演讲者。</p>

				<div class="lf-grid section-08__scholarships">
					<div class="section-08__scholarships-col1">
						<p
							class="table-header">出行资助奖学金人数</p>
						<span class="large">27</span>
					</div>
					<div class="section-08__scholarships-col2">
						<p
							class="table-header">注册奖学金人数</p>
						<span class="large">39</span>
					</div>
					<div class="section-08__scholarships-col3">
						<p class="table-header">演讲者奖学金人数</p>
						<span class="large">20</span>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<p><a href="https://events.linuxfoundation.org/kubecon-cloudnativecon-europe/attend/scholarships/">申请奖学金</a> ，参加我们的 KubeCon + CloudNativeCon Europe 2024。</p>

				<div aria-hidden="true" class="report-spacer-120"></div>
			</div>
		</section>

		<section id="colocated"
			class="section-09 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">CNCF主办的同場活动</h2>
					<div class="section-number">3/6</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-10-col">
						<p
							class="opening-paragraph">9 月 26 日，CNCF 与 KubeCon + CloudNativeCon + Open Source Summit China 2023 共同举办了 <a href="https://www.lfasiallc.com/kubecon-cloudnativecon-open-source-summit-china/co-located-events/istiocon/">IstioCon</a> ，这是一场致力于行业领先服务网格的活动，提供了一个平台，从而探索从真实世界 Istio 部署、交互式实践活动中获得的见解，以及与整个 Istio 生态系统的维护者建立联系的机会。</p>
					</div>
				</div>

				<div class="lf-grid section-09__colo">
					<div class="section-09__colo-col1">
						<p>此外，赞助商还举办了四场同期活动：</p>

						<ul>
							<li>云原生开放日，阿里云主办
							</li>
							<li>GOSIM: 全球开源创新交流会
							</li>
							<li>ONE 峰会区域服务日，由 LF Networking 和 LF Edge 主办</li>
							<li>OpenJS World，由 OpenJS 基金会主办
							</li>
						</ul>
					</div>
					<div class="section-09__colo-col2">
						<p class="sub-header">关键数据</p>
						<div class="icon-box-6">
							<div class="text">
								<span class="number">1</span><br />
								<span class="description">CNCF主办的同場活动</span>
							</div>
						</div>
					</div>
					<div class="section-09__colo-col3">
						<p class="sub-header">&nbsp;</p>
						<div class="icon-box-6">
							<div class="text">
								<span class="number">4</span><br />
								<span class="description">家赞助商主办的同場活动</span>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div aria-hidden="true" class="report-spacer-120"></div>

		</section>

		<section id="dei" class="section-11 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">多样性、公平性和包容性
					</h2>
					<div class="section-number">4/6</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p
							class="opening-paragraph">CNCF 努力确保参加 KubeCon + CloudNativeCon 的每位参会者都感到受欢迎，无论性别、性别认同、性取向、残障、种族、族裔、年龄、宗教或经济状况如何。</p>
					</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>我们致力于营造一个友好、热情且包容的环境，这也体现在我们为活动提供的设施和资源上。在上海，这些设施和资源包括：</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid incl">
					<div class="incl-col1">
						<div class="icon-box-5">
							<div class="icon-box-5__icon"><img loading="lazy" decoding="async"
									width="100" height="100"
									src="<?php LF_Utils::get_svg( $report_folder . 'icon-mute.svg', true ); ?>"
									alt="Mute icon">
							</div>
							<div class="icon-box-5__text">宁静室
							</div>
						</div>
						<div class="icon-box-5">
							<div class="icon-box-5__icon"><img loading="lazy" decoding="async"
									width="100" height="100"
									src="<?php LF_Utils::get_svg( $report_folder . 'icon-mixed-gender.svg', true ); ?>"
									alt="Mixed gender icon">
							</div>
							<div class="icon-box-5__text">全性别洗手间
							</div>
						</div>
					</div>
					<div class="incl-col2">
						<div class="icon-box-5">
							<div class="icon-box-5__icon"><img loading="lazy"
									width="100" height="100"
									src="<?php LF_Utils::get_svg( $report_folder . 'icon-pacifier.svg', true ); ?>"
									alt="Pacifier icon">
							</div>
							<div class="icon-box-5__text">婴儿护理 + 哺乳室
							</div>
						</div>

						<div class="icon-box-5">
							<div class="icon-box-5__icon"><img loading="lazy" decoding="async"
									width="100" height="100"
									src="<?php LF_Utils::get_svg( $report_folder . 'icon-sticky-note.svg', true ); ?>"
									alt="Sticky note icon">
							</div>
							<div class="icon-box-5__text">代词和沟通贴纸
							</div>
						</div>
					</div>
					<div class="incl-col3">
						<div class="icon-box-5">
							<div class="icon-box-5__icon"><img loading="lazy" decoding="async"
									width="100" height="100"
									src="<?php LF_Utils::get_svg( $report_folder . 'icon-child-blocks.svg', true ); ?>"
									alt="Toy blocks icon">
							</div>
							<div class="icon-box-5__text">免费会议现场托儿服务
							</div>
						</div>

						<div class="icon-box-5">
							<div class="icon-box-5__icon"><img loading="lazy" decoding="async"
									width="100" height="100"
									src="<?php LF_Utils::get_svg( $report_folder . 'icon-closed-captions.svg', true ); ?>"
									alt="Closed caption icon">
							</div>
							<div class="icon-box-5__text">主题演讲和分会场次提供字幕服务
							</div>
						</div>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>作为我们对多样性、公平性和包容性的坚定承诺的一部分，我们还举办了 EmpowerUs 活动 – 这是为身份识别为女性、非二元性别者或同盟者举办的一次交流活动，与其他与会者就我们快速增长的生态系统中的挑战、领导力创新和赋权进行公开讨论。</p>
					</div>
				</div>

				<div class="shadow-hr"></div>

				<div class="lf-grid">
					<div class="dei__col-1">
						<div class="kccnc-table-container">
							<table class="kccnc-table dei__table">
								<thead>
									<tr>
										<th>多样性、公平性和包容性活动与指导
										</th>
										<th>总人数</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>参会者 - 自认为是有色</td>
										<td>1,077</td>
									</tr>
									<tr>
										<td>参会者 - 年龄 0-19 岁</td>
										<td>112</td>
									</tr>
									<tr>
										<td>差旅资助奖学金人数</td>
										<td>27</td>
									</tr>
									<tr>
										<td>注册奖学金</td>
										<td>39</td>
									</tr>
									<tr>
										<td>演讲者奖学金</td>
										<td>20</td>
									</tr>
									<tr>
										<td>EmpowerUs 参与者</td>
										<td>15</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>

					<div class="dei__col-2">
						<p class="sub-header">黄金级 CHAOSS D&I 活动徽章</p>
						<div aria-hidden="true" class="report-spacer-40"></div>
						<?php LF_Utils::display_responsive_images( 90434, 'full', '320px', 'svg-image badge', 'lazy', 'Gold CHAOSS D&I Event Badge' ); ?>
						<div aria-hidden="true" class="report-spacer-40"></div>
						<p>授予开源社区中促进健康 D&I 实践的活动</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

				<p
					class="sub-header has-lines">我们的下一次 KubeCon + CloudNativeCon</p>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<?php echo do_shortcode( '[event_banner hide_title=true]' ); ?>

			</div>
		</section>

		<section id="media" class="section-14 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">媒体 + 分析师报道</h2>
					<div class="section-number">5/6</div>
				</div>


				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-14__coverage">

					<div class="section-14__coverage-col1">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" decoding="async" width="49" height="55" src="<?php LF_Utils::get_svg( $report_folder . 'icon-share.svg', true ); ?>
" alt="Share icon">
							</div>
							<div class="text">
								<span class="number">29</span><br />
								<span class="description">位媒体+行业分析师亲临会议现场</span>
								<span class="addendum">25 家来自中国领先科技刊物的媒体参会。 
中国以外的 4 家英语媒体和分析师参会，代表组织包括 InfoQ、Gartner、The Register 等。</span>
							</div>
						</div>
						<!-- End of Icon Box 3 -->
					</div>
					<div class="section-14__coverage-col2">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" decoding="async" width="54" height="54" src="<?php LF_Utils::get_svg( $report_folder . 'icon-bell.svg', true ); ?>
" alt="Bell icon">
							</div>
							<div class="text">
								<span class="number">184</span><br />
								<span class="description">活动提及</span>
								<span class="addendum">KubeCon + CloudNativeCon + Open Source Summit 在英语媒体文章、新闻稿和博客中被提及</span>
							</div>
						</div>
						<!-- End of Icon Box 3 -->
					</div>
					<div class="section-14__coverage-col3">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<div class="icon">
								<img loading="lazy" decoding="async" width="74" height="52" src="<?php LF_Utils::get_svg( $report_folder . 'icon-youtube.svg', true ); ?>
" alt="Graph up icon">
							</div>
							<div class="text">
								<span class="number">6.3K+</span><br />
								<span class="description">活动会议浏览</span>
								<span class="addendum">截至12月7日，活动会议视频已累积超过 <strong>6,300</strong> 次观看
									</span>
							</div>
						</div>
						<!-- End of Icon Box 3 -->
					</div>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header">媒体 + 分析师结果</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-14__analyst">

					<div class="section-14__analyst-col1">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<?php LF_Utils::display_responsive_images( 90433, 'full', '200px', 'svg-image', 'lazy', 'Logo' ); ?>
							<div class="text">
								<span class="number">145</span><br />
								<span class="addendum">媒体文章、新闻稿和博客中对CNCF的提及</span>
							</div>
						</div>
						<!-- End of Icon Box 3 -->
					</div>
					<div class="section-14__analyst-col2">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<?php LF_Utils::display_responsive_images( 90436, 'full', '200px', 'svg-image', 'lazy', 'Kubernetes Logo' ); ?>
							<div class="text">
								<span class="number">152</span><br />
								<span class="addendum">媒体文章、新闻稿和博客中对Kubernetes的提及</span>
							</div>
						</div>
						<!-- End of Icon Box 3 -->
					</div>
					<div class="section-14__analyst-col3">
						<!-- Icon Box 3  -->
						<div class="icon-box-3">
							<?php LF_Utils::display_responsive_images( 90435, 'full', '200px', 'svg-image', 'lazy', 'KubeCon + CloudNativeCon Logo' ); ?>
							<div class="text">
								<span class="number">184</span><br />
								<span class="addendum">媒体文章、新闻稿和博客中对KubeCon + CloudNativeCon的提及</span>
							</div>
						</div>
						<!-- End of Icon Box 3 -->
					</div>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="sub-header">中文报道纵览</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>CSDN，作为本次活动的市场推广和公关合作伙伴，提供了以下的中文报道快照：</p>
						<ul>
							<li>发表与会议主题相关的帖子共 22 篇</li>
							<li>覆盖 60 余个社区</li>
							<li>制作了 26 条微博</li>
							<li>CSDN 账号浏览量超过 900,000 万次</li>
							<li>外部媒体网站浏览量超过 1,145,000 次</li>
						</ul>

					</div>
				</div>

				<div class="shadow-hr"></div>

				<h2 class="sub-header">报道亮点</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="logo-grid">

					<div class="logo-grid__box">
						<a href="https://www.infoq.com/news/2023/09/kubecon-oss-china-2023/"
							class="logo-grid__link">
							<img class="logo-grid__image" width="224"
								height="55"
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-infoq.svg', true ); ?>"
								alt="InfoQ Logo" loading="lazy" decoding="async">
						</a>
					</div>
					<div class="logo-grid__box">
						<a href="https://www.theregister.com/2023/09/29/cncf_cto_chris_aniszczyk_talks/"
							class="logo-grid__link">
							<img class="logo-grid__image" width="224"
								height="55"
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-the-register.svg', true ); ?>"
								alt="The Register Logo" loading="lazy" decoding="async">
						</a>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-100"></div>

				<h2 class="sub-header">行业分析师报道亮点</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="logo-grid">

					<div class="logo-grid__box">
							<img class="logo-grid__image" width="224"
								height="55"
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-gartner.svg', true ); ?>"
								alt="Gartner Logo" loading="lazy" decoding="async">
					</div>

					<div class="logo-grid__box">
							<img class="logo-grid__image" width="224"
								height="55"
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-forrester.svg', true ); ?>"
								alt="Forrester Logo" loading="lazy" decoding="async">
					</div>

				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

			</div>
		</section>

		<section id="sponsors"
			class="section-15 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="section-title-wrapper">
					<h2 class="section-header">赞助商信息</h2>
					<div class="section-number">6/6</div>
				</div>

				<div class="lf-grid">
					<div class="restrictive-9-col">
						<p>KubeCon + CloudNativeCon + Open Source Summit China 的成功举办离不开优秀赞助商的支持。参会者一致认为 – 81% 的人在活动期间参观了解决方案展示会。</p>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<h2 class="sub-header">活动总体评价</h2>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="lf-grid section-15__rating">
					<div class="section-15__rating-col1">

						<div class="icon-box-7">
							<div class="image-container">
								<img width="45" height="45"
									src="<?php LF_Utils::get_svg( $report_folder . 'icon-growth.svg', true ); ?>"
									alt="Growth icon" loading="lazy" decoding="async">
							</div>
							<span class="large">#1</span>
							<span class="text">出于职业发展、晋升或培训目的</span>
						</div>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<div class="icon-box-7">
							<div class="image-container">
								<img width="45" height="45"
									src="<?php LF_Utils::get_svg( $report_folder . 'icon-networking.svg', true ); ?>"
									alt="Networking icon" loading="lazy" decoding="async">
							</div>
							<span class="large">#2</span>
							<span class="text">进行社交 + 结识行业内其他人士</span>
						</div>

					</div>
					<div class="section-15__rating-col2">

						<div class="icon-box-7">
							<div class="image-container">
								<img width="45" height="45"
									src="<?php LF_Utils::get_svg( $report_folder . 'icon-showcase.svg', true ); ?>"
									alt="Showcase icon" loading="lazy" decoding="async">
							</div>
							<span class="large">81%</span>
							<span class="text">的参会者参观了赞助商展示会</span>
						</div>
					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<div class="kccnc-table-container">
					<table class="kccnc-table booth">
						<thead>
							<tr>
								<th>展位客流量</th>
								<th>总人数</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>现场销售线索总数</td>
								<td>4,595</td>
							</tr>
							<tr>
								<td>每个展位现场销售线索平均数</td>
								<td>287</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="shadow-hr"></div>

				<div class="kccnc-table-container">
					<table class="kccnc-table yoy-table">
						<thead>
							<tr>
								<th>年度同比赞助
									<span>&nbsp;</span></th>
								<th>2018
									<span>&nbsp;</span>
								</th>
								<th>2019
									<span>&nbsp;</span>
								</th>
								<th>2021
									<span class="nowrap">虚拟会议</span>
								</th>
								<th>2023
									<span>&nbsp;</span>
								</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>战略级</td>
								<td>N/A</td>
								<td>1</td>
								<td>1</td>
								<td>1</td>

							</tr>
							<tr>
								<td class="nowrap">双钻级</td>
								<td>N/A</td>
								<td>1</td>
								<td>N/A</td>
								<td>N/A</td>

							</tr>
							<tr>
								<td>钻石级</td>
								<td>4</td>
								<td>2</td>
								<td>2</td>
								<td>2</td>
							</tr>
							<tr>
								<td>铂金级</td>
								<td>8</td>
								<td>2</td>
								<td>0</td>
								<td>0</td>
							</tr>
							<tr>
								<td>黄金级</td>
								<td>1</td>
								<td>10</td>
								<td>3</td>
								<td>1</td>

							</tr>
							<tr>
								<td>白银级</td>
								<td>12</td>
								<td>14</td>
								<td>3</td>
								<td>10</td>

							</tr>
							<tr>
								<td class="nowrap">初创企业</td>
								<td>13</td>
								<td>12</td>
								<td>5</td>
								<td>3</td>

							</tr>
							<tr>
								<td class="nowrap">终端用户</td>
								<td>N/A</td>
								<td>0</td>
								<td>0</td>
								<td>0</td>
							</tr>
							<tr>
								<td class="nowrap">营销机会</td>
								<td>4</td>
								<td>12</td>
								<td>2</td>
								<td>1</td>
							</tr>
							<tr>
								<td class="nowrap">唯一身份赞助商总数</td>
								<td>38</td>
								<td>42</td>
								<td>14</td>
								<td>18</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="shadow-hr"></div>

				<p class="sub-header"
					style="margin:auto; text-align:center">战略赞助商</p>

				<div aria-hidden="true" class="report-spacer-60"></div>

				<div class="sponsors-logos jumbo odd orphan-by-3 orphan-by-6">

					<div class="sponsors-logo-item"><a
							href="https://www.huawei.com/" title="Go to Huawei"
							target="_blank" rel="noopener">
							<img width="241" height="245"
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-huawei.svg', true ); ?>"
								class="logo wp-post-image" alt="Huawei logo"
								decoding="async" loading="lazy"></a>

					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

				<p class="sub-header"
					style="margin:auto; text-align:center">钻石赞助商</p>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="sponsors-logos largest odd">
					<div class="sponsors-logo-item"><a
							href="https://developer.aliyun.com/cloudnative/"
							title="Go to Alibaba Cloud"
							style="-webkit-transform: scale(1.2); -ms-transform: scale(1.2); transform: scale(1.2);"
							target="_blank" rel="noopener">
							<img decoding="async" width="399" height="63"
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-alibaba-cloud.svg', true ); ?>"
								class="logo wp-post-image"
								alt="Alibaba Cloud logo" loading="lazy"></a>
					</div>
					<div class="sponsors-logo-item"><a
							href="https://aws.amazon.com/" title="Go to AWS"
							target="_blank" rel="noopener">
							<img decoding="async" width="165" height="53"
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-amazon-cloud-technologies-china.svg', true ); ?>"
								class="logo wp-post-image" alt="AWS logo"
								loading="lazy"></a></div>

					<div class="sponsors-logo-item"><a
							href="https://www.intel.cn/content/www/cn/zh/developer/topic-technology/cloud/overview.html"
							title="Go to Intel"
							style="-webkit-transform: scale(0.75); -ms-transform: scale(0.75); transform: scale(0.75);"
							target="_blank" rel="noopener">
							<img decoding="async" width="338" height="139"
								src="<?php LF_Utils::get_svg( $report_folder . 'logo-intel.svg', true ); ?>"
								class="logo wp-post-image" alt="Intel logo"
								loading="lazy"></a></div>
				</div>

				<div aria-hidden="true" class="report-spacer-40"></div>

				<div class="wp-block-button"><a
						href="https://www.lfasiallc.com/kubecon-cloudnativecon-open-source-summit-china/sponsor-list/"
						title="See all Sponsors of KubeCon + CloudNativeCon + Open Source Summit China 2023"
						class="wp-block-button__link">查看所有赞助商</a>
				</div>

				<div aria-hidden="true" class="report-spacer-120"></div>

			</div>
		</section>

		<section class="section-16 is-style-down-gradient alignfull">

			<div class="container wrap">

				<div class="lf-grid thanks">
					<div class="thanks__col1">
						<h2 class="section-header">致谢</h2>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<p
							class="thanks__opening">我们希望您能够喜欢回顾这一次上海举办的盛事 – 让我们在巴黎再次相聚！</p>

						<div aria-hidden="true" class="report-spacer-60"></div>

						<p
							class="thanks__comments">欢迎您提出意见和反馈，可发送至 <a href="mailto:events@cncf.io">events@cncf.io</a></p>

						<div aria-hidden="true" class="report-spacer-80"></div>

						<p>查看我们的<a href="https://community.cncf.io/">社区活动日程表</a>，了解您附近的社区活动，不要忘记注册参加 2024 年 3 月 19 日至 22 日将在巴黎举行的 <a href="https://events.linuxfoundation.org/kubecon-cloudnativecon-europe/register/">KubeCon + CloudNativeCon Europe</a>。</p>
					</div>
					<div class="thanks__col2">

					</div>
				</div>

				<div aria-hidden="true" class="report-spacer-80"></div>

				<?php echo do_shortcode( '[event_banner hide_title=true]' ); ?>

				<?php
				get_template_part( 'components/social-share' );
				?>
			</div>
		</section>
	</article>
</main>

<?php

// load slick css.
wp_enqueue_style( 'slick-css', get_template_directory_uri() . '/build/slick.min.css', array(), filemtime( get_template_directory() . '/build/slick.min.css' ), 'all' );

// load main slick.
wp_enqueue_script( 'slick', get_template_directory_uri() . '/source/js/libraries/slick.min.js', array( 'jquery' ), filemtime( get_template_directory() . '/source/js/libraries/slick.min.js' ), true );

// custom scripts.
wp_enqueue_script(
	'kccnc-oss-23-report',
	get_template_directory_uri() . '/source/js/on-demand/kccnc-oss-23-report.js',
	array( 'jquery', 'slick' ),
	filemtime( get_template_directory() . '/source/js/on-demand/kccnc-oss-23-report.js' ),
	true
);

get_template_part( 'components/footer' );
