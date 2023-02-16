<div class="ctf-license-learn-more ctf-fb-extensions-pp-ctn sb-fs-boss ctf-fb-center-boss" v-if="viewsActive.licenseLearnMore != null && viewsActive.licenseLearnMore != false">
	<div class="ctf-fb-extensions-popup ctf-fb-popup-inside ctf-license-popup" v-if="viewsActive.licenseLearnMore != null && viewsActive.licenseLearnMore != false">
        <div class="ctf-fb-popup-cls" @click.prevent.default="activateView('licenseLearnMore')">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M14 1.41L12.59 0L7 5.59L1.41 0L0 1.41L5.59 7L0 12.59L1.41 14L7 8.41L12.59 14L14 12.59L8.41 7L14 1.41Z" fill="#141B38"/>
            </svg>
        </div>
        <div>
            <div class="sb-llm-header">
                <h2 v-if="ctfLicenseNoticeActive && !ctfLicenseInactiveState">Your Custom Twitter Feeds Pro License is expired</h2>
                <h2 v-if="ctfLicenseInactiveState">Your Custom Twitter Feeds Pro License is inactive</h2>
                <p>No license key detected. With a license key you can: </p>
            </div>
            <div class="sb-llm-upgrade-benefits">
                <div class="sb-benefits-block">
                    <span class="sb-icon">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.1248 16.15L7.7998 15.15C7.46647 15.0167 7.2708 14.775 7.2128 14.425C7.15414 14.075 7.2498 13.775 7.4998 13.525L10.6498 10.375C10.8831 10.1417 11.1581 9.97503 11.4748 9.87503C11.7915 9.77503 12.1165 9.75836 12.4498 9.82503L13.7498 10.1C12.8665 11.15 12.1625 12.1044 11.6378 12.963C11.1125 13.821 10.6081 14.8834 10.1248 16.15ZM24.8248 6.40003C24.9581 6.40003 25.0915 6.43336 25.2248 6.50003C25.3581 6.56669 25.4748 6.65003 25.5748 6.75003C25.6748 6.85003 25.7581 6.96669 25.8248 7.10003C25.8915 7.23336 25.9248 7.36669 25.9248 7.50003C25.9915 9.05003 25.6625 10.6584 24.9378 12.325C24.2125 13.9917 23.1915 15.4834 21.8748 16.8C20.9748 17.7 20.1081 18.4207 19.2748 18.962C18.4415 19.504 17.4581 20.0167 16.3248 20.5C16.1081 20.5834 15.8875 20.625 15.6628 20.625C15.4375 20.625 15.2415 20.5417 15.0748 20.375L11.9498 17.25C11.7831 17.0834 11.6998 16.8874 11.6998 16.662C11.6998 16.4374 11.7415 16.2167 11.8248 16C12.3081 14.8834 12.8208 13.904 13.3628 13.062C13.9041 12.2207 14.6248 11.35 15.5248 10.45C16.8415 9.13336 18.3331 8.11236 19.9998 7.38703C21.6665 6.66236 23.2748 6.33336 24.8248 6.40003ZM18.4748 13.85C18.8581 14.2334 19.3291 14.425 19.8878 14.425C20.4458 14.425 20.9165 14.2334 21.2998 13.85C21.6831 13.4667 21.8748 12.9957 21.8748 12.437C21.8748 11.879 21.6831 11.4084 21.2998 11.025C20.9165 10.6417 20.4458 10.45 19.8878 10.45C19.3291 10.45 18.8581 10.6417 18.4748 11.025C18.0915 11.4084 17.8998 11.879 17.8998 12.437C17.8998 12.9957 18.0915 13.4667 18.4748 13.85ZM16.1748 22.2C17.4415 21.7167 18.5081 21.2127 19.3748 20.688C20.2415 20.1627 21.1998 19.4584 22.2498 18.575L22.4998 19.875C22.5665 20.2084 22.5498 20.5377 22.4498 20.863C22.3498 21.1877 22.1831 21.4667 21.9498 21.7L18.7998 24.85C18.5498 25.1 18.2498 25.1917 17.8998 25.125C17.5498 25.0584 17.3081 24.8584 17.1748 24.525L16.1748 22.2ZM8.0498 20.05C8.63314 19.4667 9.34147 19.1707 10.1748 19.162C11.0081 19.154 11.7165 19.4417 12.2998 20.025C12.8831 20.6084 13.1748 21.3167 13.1748 22.15C13.1748 22.9834 12.8831 23.6917 12.2998 24.275C11.8831 24.6917 11.1875 25.05 10.2128 25.35C9.23747 25.65 7.89147 25.9167 6.1748 26.15C6.40814 24.4334 6.6748 23.0917 6.9748 22.125C7.2748 21.1584 7.63314 20.4667 8.0498 20.05Z" fill="#0068A0"/></svg>
                    </span>
                    <h4>Use any Pro features</h4>
                    <p>New and existing feeds will not yet allow the use of the premium feed types and enhanced display settings available in pro.</p>
                </div>

                <div class="sb-benefits-block">
                    <span class="sb-icon">
                        <svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.3335 25V23L11.3335 22H8.3335C7.7835 22 7.31283 21.8043 6.9215 21.413C6.5295 21.021 6.3335 20.55 6.3335 20V9C6.3335 8.45 6.5295 7.979 6.9215 7.587C7.31283 7.19567 7.7835 7 8.3335 7H16.3335V9H8.3335V20H24.3335V17H26.3335V20C26.3335 20.55 26.1378 21.021 25.7465 21.413C25.3545 21.8043 24.8835 22 24.3335 22H21.3335L22.3335 23V25H10.3335ZM19.3335 19L14.3335 14L15.7335 12.6L18.3335 15.175V7H20.3335V15.175L22.9335 12.6L24.3335 14L19.3335 19Z" fill="#0068A0"/></svg>
                    </span>
                    <h4>Receive Critical Updates</h4>
                    <p>With changes to Twitter and WordPress it's critical to keep your plugin up to date. We regularly provide fixes and enhancements in new releases</p>
                </div>

                <div class="sb-benefits-block">
                    <span class="sb-icon">
                        <svg width="33" height="32" viewBox="0 0 33 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M24.1165 13.1C23.7165 12.05 23.1208 11.129 22.3295 10.337C21.5375 9.54567 20.6165 8.95 19.5665 8.55L18.4165 11.35C19.0998 11.6 19.6915 11.979 20.1915 12.487C20.6915 12.9957 21.0832 13.5833 21.3665 14.25L24.1165 13.1ZM13.8165 8.55C12.7498 8.95 11.8165 9.55 11.0165 10.35C10.2165 11.15 9.6165 12.0833 9.2165 13.15L11.9665 14.3C12.2498 13.6 12.6458 12.9877 13.1545 12.463C13.6625 11.9377 14.2665 11.55 14.9665 11.3L13.8165 8.55ZM9.2165 18.85C9.59984 19.9167 10.1915 20.85 10.9915 21.65C11.7915 22.45 12.7165 23.05 13.7665 23.45L14.9665 20.7C14.2665 20.45 13.6625 20.0623 13.1545 19.537C12.6458 19.0123 12.2498 18.4 11.9665 17.7L9.2165 18.85ZM19.5665 23.45C20.6165 23.05 21.5375 22.4543 22.3295 21.663C23.1208 20.871 23.7165 19.95 24.1165 18.9L21.3665 17.7C21.1165 18.4 20.7332 19.004 20.2165 19.512C19.6998 20.0207 19.0998 20.4167 18.4165 20.7L19.5665 23.45ZM16.6665 26C15.2832 26 13.9832 25.7373 12.7665 25.212C11.5498 24.6873 10.4915 23.975 9.5915 23.075C8.6915 22.175 7.97917 21.1167 7.4545 19.9C6.92917 18.6833 6.6665 17.3833 6.6665 16C6.6665 14.6167 6.92917 13.3167 7.4545 12.1C7.97917 10.8833 8.6915 9.825 9.5915 8.925C10.4915 8.025 11.5498 7.31233 12.7665 6.787C13.9832 6.26233 15.2832 6 16.6665 6C18.0498 6 19.3498 6.26233 20.5665 6.787C21.7832 7.31233 22.8415 8.025 23.7415 8.925C24.6415 9.825 25.3538 10.8833 25.8785 12.1C26.4038 13.3167 26.6665 14.6167 26.6665 16C26.6665 17.3833 26.4038 18.6833 25.8785 19.9C25.3538 21.1167 24.6415 22.175 23.7415 23.075C22.8415 23.975 21.7832 24.6873 20.5665 25.212C19.3498 25.7373 18.0498 26 16.6665 26ZM16.6665 19C17.4998 19 18.2082 18.7083 18.7915 18.125C19.3748 17.5417 19.6665 16.8333 19.6665 16C19.6665 15.1667 19.3748 14.4583 18.7915 13.875C18.2082 13.2917 17.4998 13 16.6665 13C15.8332 13 15.1248 13.2917 14.5415 13.875C13.9582 14.4583 13.6665 15.1667 13.6665 16C13.6665 16.8333 13.9582 17.5417 14.5415 18.125C15.1248 18.7083 15.8332 19 16.6665 19Z" fill="#0068A0"/></svg>
                    </span>
                    <h4>Receive technical support</h4>
                    <p>We have a team of WordPress experts ready to help you if anything goes wrong. Keep your feeds up and running just how you need.</p>
                </div>
            </div>
            <div class="sb-llm-license-key-block">
                <div class="sb-license-checker-form">
                    <div class="sb-left">
                        <h3>Have a license key?</h3>
                        <p>You can activate it by adding it here</p>
                    </div>
                    <div class="sb-right">
                        <div class="sb-modal-license-key-form">
                            <input type="password" placeholder="Paste license key here" class="sb-input" v-model="licenseKey">
                            <button @click="activateLicense()" class="sb-btn-default sb-btn-blue sb-btn-license-activate">
                                <span v-html="svgIcons.loaderSVG" v-if="licenseBtnClicked"></span>
                                Activate
                            </button>
                        </div>
                    </div>
                </div>
                <div class="sb-llm-lk-footer">
                    <p>
                        <span>Need a New License? </span>
                        <a href="<?php echo "https://smashballoon.com/pricing/facebook-feed/"; ?>" target="_blank">
                            Buy a License
                            <svg width="7" height="10" viewBox="0 0 7 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.8332 0L0.658203 1.175L4.47487 5L0.658203 8.825L1.8332 10L6.8332 5L1.8332 0Z" fill="#0068A0"/></svg>
                        </a>
                    </p>
                </div>
            </div>
        </div>
	</div>
</div>
