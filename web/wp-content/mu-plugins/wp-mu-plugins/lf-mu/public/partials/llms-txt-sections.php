<?php
/**
 * Curated page list for /llms.txt
 *
 * Paths are relative to the site root and resolved with home_url() at runtime.
 *
 * @link       https://www.cncf.io/
 * @since      1.2.0
 *
 * @package    Lf_Mu
 * @subpackage Lf_Mu/public/partials
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

return array(
	'About'                      => array(
		array(
			'path'        => '/about/who-we-are/',
			'title'       => 'Who We Are',
			'description' => 'CNCF mission, charter and its role within the Linux Foundation.',
		),
		array(
			'path'        => '/about/faq/',
			'title'       => 'FAQ',
			'description' => 'Frequently asked questions about CNCF.',
		),
		array(
			'path'        => '/about/members/',
			'title'       => 'Members',
			'description' => 'Directory of Platinum, Gold, Silver, End User and nonprofit members.',
		),
		array(
			'path'        => '/about/join/',
			'title'       => 'Join CNCF',
			'description' => 'Membership tiers, benefits and how to become a member.',
		),
		array(
			'path'        => '/about/contact/',
			'title'       => 'Contact',
			'description' => 'How to reach CNCF staff and teams.',
		),
		array(
			'path'        => '/people/staff/',
			'title'       => 'Staff',
			'description' => 'CNCF staff directory.',
		),
		array(
			'path'        => '/people/governing-board/',
			'title'       => 'Governing Board',
			'description' => 'Members of the CNCF Governing Board.',
		),
		array(
			'path'        => '/people/technical-oversight-committee/',
			'title'       => 'Technical Oversight Committee (TOC)',
			'description' => 'The TOC oversees project acceptance, graduation and technical direction.',
		),
		array(
			'path'        => '/people/end-user-technical-advisory-board/',
			'title'       => 'End User Technical Advisory Board (TAB)',
			'description' => 'Advisory board representing end user organizations.',
		),
		array(
			'path'        => '/all-cncf/',
			'title'       => 'All CNCF Sites',
			'description' => 'Index of every CNCF web property.',
		),
	),
	'Projects'                   => array(
		array(
			'path'        => '/projects/',
			'title'       => 'Graduated and Incubating Projects',
			'description' => 'All graduated and incubating CNCF projects; each project has a page at /projects/{slug}/.',
		),
		array(
			'path'        => '/sandbox-projects/',
			'title'       => 'Sandbox Projects',
			'description' => 'Early-stage projects in the CNCF Sandbox.',
		),
		array(
			'path'        => '/archived-projects/',
			'title'       => 'Archived Projects',
			'description' => 'Projects that are no longer actively maintained under CNCF.',
		),
		array(
			'path'        => '/project-metrics/',
			'title'       => 'Project Metrics',
			'description' => 'Contributor and velocity statistics across CNCF projects.',
		),
		array(
			'path'        => '/project-tools/',
			'title'       => 'Project Tools',
			'description' => 'Services and tooling CNCF provides to hosted projects.',
		),
	),
	'End Users and Case Studies' => array(
		array(
			'path'        => '/case-studies/',
			'title'       => 'Case Studies',
			'description' => 'Real-world adoption stories from organizations using cloud native technologies; each at /case-studies/{slug}/.',
		),
		array(
			'path'        => '/case-studies-cn/',
			'title'       => 'Case Studies (Chinese)',
			'description' => 'Case studies translated into Chinese.',
		),
		array(
			'path'        => '/enduser/',
			'title'       => 'End User Community',
			'description' => 'Programs and resources for organizations that use, but do not sell, cloud native technology.',
		),
	),
	'Training and Certification' => array(
		array(
			'path'        => '/training/',
			'title'       => 'Training Overview',
			'description' => 'Courses, certifications and training programs.',
		),
		array(
			'path'        => '/training/certification/',
			'title'       => 'Certifications',
			'description' => 'All CNCF certification exams.',
		),
		array(
			'path'        => '/training/courses/',
			'title'       => 'Courses',
			'description' => 'Free and paid cloud native courses.',
		),
		array(
			'path'        => '/training/kubestronaut/',
			'title'       => 'Kubestronaut Program',
			'description' => 'Recognition for individuals who hold all Kubernetes certifications.',
		),
		array(
			'path'        => '/training/kubernetes-cloud-native-training-partners/',
			'title'       => 'Kubernetes Training Partners (KTP)',
			'description' => 'Vetted training providers for Kubernetes and cloud native.',
		),
		array(
			'path'        => '/training/certification/software-conformance/',
			'title'       => 'Certified Kubernetes Software Conformance',
			'description' => 'The Certified Kubernetes program and conformance requirements.',
		),
		array(
			'path'        => '/training/certification/kcsp/',
			'title'       => 'Kubernetes Certified Service Providers (KCSP)',
			'description' => 'Vetted service providers with deep Kubernetes experience.',
		),
		array(
			'path'        => '/training/certification/cka/',
			'title'       => 'Certified Kubernetes Administrator (CKA)',
			'description' => 'Exam details for the CKA certification.',
		),
		array(
			'path'        => '/training/certification/ckad/',
			'title'       => 'Certified Kubernetes Application Developer (CKAD)',
			'description' => 'Exam details for the CKAD certification.',
		),
		array(
			'path'        => '/training/certification/cks/',
			'title'       => 'Certified Kubernetes Security Specialist (CKS)',
			'description' => 'Exam details for the CKS certification.',
		),
		array(
			'path'        => '/training/certification/kcna/',
			'title'       => 'Kubernetes and Cloud Native Associate (KCNA)',
			'description' => 'Exam details for the KCNA certification.',
		),
		array(
			'path'        => '/training/certification/kcsa/',
			'title'       => 'Kubernetes and Cloud Native Security Associate (KCSA)',
			'description' => 'Exam details for the KCSA certification.',
		),
	),
	'Events'                     => array(
		array(
			'path'        => '/events/',
			'title'       => 'Events',
			'description' => 'Upcoming CNCF-hosted events.',
		),
		array(
			'path'        => '/kubecon-cloudnativecon-events/',
			'title'       => 'KubeCon + CloudNativeCon',
			'description' => 'The flagship CNCF conference series held in multiple regions each year.',
		),
		array(
			'path'        => '/kcds/',
			'title'       => 'Kubernetes Community Days (KCD)',
			'description' => 'Community-organized local events.',
		),
		array(
			'path'        => '/calendar/',
			'title'       => 'Community Calendar',
			'description' => 'Calendar of project and community meetings.',
		),
		array(
			'path'        => '/online-programs/',
			'title'       => 'Online Programs',
			'description' => 'Webinars and livestreams, including Cloud Native Live and on-demand sessions.',
		),
	),
	'Community'                  => array(
		array(
			'path'        => '/people/ambassadors/',
			'title'       => 'CNCF Ambassadors',
			'description' => 'Community advocates who help spread cloud native knowledge.',
		),
		array(
			'path'        => '/people/mentorship/',
			'title'       => 'Mentorship',
			'description' => 'Mentoring programs including LFX Mentorship and Google Summer of Code.',
		),
		array(
			'path'        => '/humans-of-cloud-native/',
			'title'       => 'Humans of Cloud Native',
			'description' => 'Profiles of community members.',
		),
		array(
			'path'        => '/heroes/',
			'title'       => 'Cloud Native Heroes Challenge',
			'description' => 'Community challenge program.',
		),
		array(
			'path'        => '/phippy/',
			'title'       => 'Phippy and Friends',
			'description' => 'Illustrated children\'s guides to Kubernetes and cloud native concepts.',
		),
		array(
			'path'        => '/conduct/',
			'title'       => 'Code of Conduct',
			'description' => 'CNCF community Code of Conduct and how to report incidents.',
		),
	),
	'Blog and News'              => array(
		array(
			'path'        => '/blog/',
			'title'       => 'Blog',
			'description' => 'Community and staff blog posts; permalinks follow /blog/YYYY/MM/DD/{slug}/.',
		),
		array(
			'path'        => '/announcements/',
			'title'       => 'Announcements',
			'description' => 'Official press releases; permalinks follow /announcements/YYYY/MM/DD/{slug}/.',
		),
		array(
			'path'        => '/newsletter/',
			'title'       => 'Newsletter',
			'description' => 'Subscribe to the CNCF newsletter.',
		),
		array(
			'path'        => '/kubeweekly/',
			'title'       => 'KubeWeekly',
			'description' => 'Weekly Kubernetes and cloud native newsletter archive.',
		),
	),
	'Reports and Research'       => array(
		array(
			'path'        => '/reports/',
			'title'       => 'Reports',
			'description' => 'Annual reports, surveys, whitepapers, project journey reports and event transparency reports; each at /reports/{slug}/.',
		),
		array(
			'path'        => '/reports/the-cncf-annual-cloud-native-survey/',
			'title'       => 'CNCF Annual Cloud Native Survey',
			'description' => 'Yearly survey of cloud native adoption.',
		),
		array(
			'path'        => '/reports/state-of-cloud-native-development/',
			'title'       => 'State of Cloud Native Development',
			'description' => 'Developer population research produced with SlashData.',
		),
		array(
			'path'        => '/reports/cncf-technology-landscape-radar/',
			'title'       => 'CNCF Technology Landscape Radar',
			'description' => 'End user perspectives on cloud native technology adoption.',
		),
	),
	'Policies and Brand'         => array(
		array(
			'path'        => '/policies/',
			'title'       => 'Policies',
			'description' => 'CNCF policies index.',
		),
		array(
			'path'        => '/brand-guidelines/',
			'title'       => 'Brand Guidelines',
			'description' => 'CNCF logo and brand usage guidelines.',
		),
		array(
			'path'        => '/kubecon-cloudnativecon-branding-guidelines/',
			'title'       => 'KubeCon + CloudNativeCon Branding Guidelines',
			'description' => 'Brand usage guidelines for KubeCon + CloudNativeCon.',
		),
		array(
			'path'        => '/political-neutrality-policy/',
			'title'       => 'Political Neutrality Policy',
			'description' => 'CNCF policy on political neutrality.',
		),
		array(
			'path'        => '/accessibility-statement/',
			'title'       => 'Accessibility Statement',
			'description' => 'Accessibility commitments for cncf.io.',
		),
	),
	'Optional'                   => array(
		array(
			'path'        => '/sitemap.xml',
			'title'       => 'XML Sitemap',
			'description' => 'Full sitemap of all indexable pages.',
		),
		array(
			'path'        => '/feed/',
			'title'       => 'RSS Feed',
			'description' => 'RSS feed of the latest blog posts.',
		),
	),
);
