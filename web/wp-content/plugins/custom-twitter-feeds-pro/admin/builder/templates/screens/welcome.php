<div class="ctf-fb-full-wrapper ctf-fb-fs" v-if="viewsActive.pageScreen == 'welcome' && !iscustomizerScreen">
    <?php
        /**
         * CFF Admin Notices
         *
         * @since 2.0
         */
        do_action('ctf_admin_notices');
    ?>

	<div class="ctf-fb-wlcm-header ctf-fb-fs">
		<h2>{{welcomeScreen.mainHeading}}</h2>
        <div class="sb-positioning-wrap" v-bind:class="{ 'sb-onboarding-highlight' : viewsActive.onboardingStep === 1 }">
            <div class="ctf-fb-btn ctf-fb-btn-new ctf-btn-orange" @click.prevent.default="! viewsActive.onboardingPopup ? switchScreen('pageScreen', 'selectFeed') : switchScreen('welcome')">
                <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.66537 5.66659H5.66536V9.66659H4.33203V5.66659H0.332031V4.33325H4.33203V0.333252H5.66536V4.33325H9.66537V5.66659Z" fill="white"/>
                </svg>
                <span>{{genericText.addNew}}</span>
            </div>
        </div>
	</div>
	<?php
		include_once CTF_BUILDER_DIR . 'templates/sections/empty-state.php';
		include_once CTF_BUILDER_DIR . 'templates/sections/feeds-list.php';
	?>
</div>