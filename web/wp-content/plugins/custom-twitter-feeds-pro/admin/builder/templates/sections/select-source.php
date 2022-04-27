<div class="ctf-fb-slctsrc-ctn ctf-fb-fs sb-box-shadow" v-if="viewsActive.selectedFeedSection == 'selectSource'">
    <?php
        include_once CTF_BUILDER_DIR . 'templates/sections/create-feed/multiple-sources-list.php';
    ?>
    <div v-if="! maxTypesAdded()" class="ctf-addsource-type-btn ctf-fb-fs" @click.prevent.default="activateView('feedtypesPopup')">
        <svg width="14" height="14" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M9.66634 5.66634H5.66634V9.66634H4.33301V5.66634H0.333008V4.33301H4.33301V0.333008H5.66634V4.33301H9.66634V5.66634Z"/>
        </svg>
        <span>{{genericText.addSourceType}}</span>
    </div>
</div>