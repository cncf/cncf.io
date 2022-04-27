<div class="ctf-oembed-modal" v-if="openFacebookInstaller">
    <div class="ctf-modal-content">
        <button type="button" class="cancel-btn ctf-btn" v-html="modal.timesIcon" @click="closeModal"></button>
        <div class="modal-icon">
            <img :src="modal.facebookIcon" :alt="modal.title">
        </div>
        <h2>{{modal.title}}</h2>
        <p>{{modal.description}}</p>
        <div class="sb-action-buttons">
            <button type="button" class="ctf-btn ctf-install-btn" @click="installFacebook()" :class="installerStatus" :disabled="isFacebookActivated">
                <span v-html="installIcon()"></span>
                <span v-html="FacebookInstallBtnText"></span>
            </button>
            <button type="button" class="ctf-btn" @click="closeModal" v-if="!isFacebookActivated">{{modal.cancel}}</button>
        </div>
    </div>
</div>