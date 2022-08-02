<div v-if="selected === 'app-4'">
    <div class="sb-tab-box sb-resizing-box sb-reset-box-style clearfix">
        <div class="tab-label">
            <h3>{{advancedTab.optimizeBox.title}}</h3>
        </div>

        <div class="ctf-tab-form-field">
            <div class="sb-form-field">
                <label for="resizing-settings" class="ctf-checkbox">
                    <input type="checkbox" id="resizing-settings" v-model="model.advanced.resizing">
                    <span class="toggle-track">
                        <div class="toggle-indicator"></div>
                    </span>
                    <button type="button" class="ctf-btn ml-10 optimize-image-btn" @click="clearImageResizeCache()">
                        <span v-html="clearImageResizeCacheIcon()" :class="optimizeCacheStatus" v-if="optimizeCacheStatus !== null"></span>
                        {{advancedTab.optimizeBox.reset}}
                    </button>
                </label>
                <span class="help-text">
                    {{advancedTab.optimizeBox.helpText}}
                </span>
            </div>
        </div>
    </div>
    <div class="sb-tab-box sb-persistentCacheBox-box sb-reset-box-style clearfix">
        <div class="tab-label">
            <h3>{{advancedTab.persistentCacheBox.title}}</h3>
        </div>

        <div class="ctf-tab-form-field">
            <div class="sb-form-field">
                <label for="persistentcache-settings" class="ctf-checkbox">
                    <input type="checkbox" id="persistentcache-settings" v-model="model.advanced.persistentcache">
                    <span class="toggle-track">
                        <div class="toggle-indicator"></div>
                    </span>
                     <button type="button" class="ctf-btn ml-10 persistent-cache-btn" @click="clearPersistentCache()">
                        <span v-html="clearPersistentCacheIcon()" :class="persistentCacheStatus" v-if="persistentCacheStatus !== null"></span>
                        {{advancedTab.persistentCacheBox.reset}}
                    </button>
                </label>
                <span class="help-text">
                    {{advancedTab.persistentCacheBox.helpText}}
                </span>
            </div>
        </div>
    </div>
	<div class="sb-tab-box sb-twitterCardCacheBox-box sb-reset-box-style clearfix">
		<div class="tab-label">
			<h3>{{advancedTab.twitterCardCacheBox.title}}</h3>
		</div>

		<div class="ctf-tab-form-field">
			<div class="sb-form-field">
				<label for="twittercardcache-settings" class="ctf-checkbox">
					<button type="button" class="ctf-btn ctf-no-transform-btn twitter-card-cache-btn" @click="clearTwittercardCache()">
						<span v-html="clearTwittercardCacheIcon()" :class="twittercardCacheStatus" v-if="twittercardCacheStatus !== null"></span>
						{{advancedTab.twitterCardCacheBox.reset}}
					</button>
				</label>
				<span class="help-text">
                    {{advancedTab.twitterCardCacheBox.helpText}}
                </span>
			</div>
		</div>
	</div>
    <div class="sb-tab-box sb-ajaxThemeBox-box sb-reset-box-style clearfix">
        <div class="tab-label">
            <h3>{{advancedTab.ajaxThemeBox.title}}</h3>
        </div>

        <div class="ctf-tab-form-field">
            <div class="sb-form-field">
                <label for="ajax_theme-settings" class="ctf-checkbox">
                    <input type="checkbox" id="ajax_theme-settings" v-model="model.advanced.ajax_theme">
                    <span class="toggle-track">
                        <div class="toggle-indicator"></div>
                    </span>
                </label>
                <span class="help-text">
                    {{advancedTab.ajaxThemeBox.helpText}}
                </span>
            </div>
        </div>
    </div>
    <div class="sb-tab-box sb-jsHeaderBox-box sb-reset-box-style clearfix">
        <div class="tab-label">
            <h3>{{advancedTab.jsHeaderBox.title}}</h3>
        </div>

        <div class="ctf-tab-form-field">
            <div class="sb-form-field">
                <label for="headenqueue-settings" class="ctf-checkbox">
                    <input type="checkbox" id="headenqueue-settings" v-model="model.advanced.headenqueue">
                    <span class="toggle-track">
                        <div class="toggle-indicator"></div>
                    </span>
                </label>
                <span class="help-text">
                    {{advancedTab.jsHeaderBox.helpText}}
                </span>
            </div>
        </div>
    </div>
    <div class="sb-tab-box sb-templatesBox-box sb-reset-box-style clearfix">
        <div class="tab-label">
            <h3>{{advancedTab.templatesBox.title}}</h3>
        </div>

        <div class="ctf-tab-form-field">
            <div class="sb-form-field">
                <label for="customtemplates-settings" class="ctf-checkbox">
                    <input type="checkbox" id="customtemplates-settings" v-model="model.advanced.customtemplates">
                    <span class="toggle-track">
                        <div class="toggle-indicator"></div>
                    </span>
                </label>
                <span class="help-text" v-html="advancedTab.templatesBox.helpText">
                </span>
            </div>
        </div>
    </div>
    <div class="sb-tab-box sb-creditbox-box sb-reset-box-style clearfix">
        <div class="tab-label">
            <h3>{{advancedTab.creditbox.title}}</h3>
        </div>

        <div class="ctf-tab-form-field">
            <div class="sb-form-field">
                <label for="creditctf-settings" class="ctf-checkbox">
                    <input type="checkbox" id="creditctf-settings" v-model="model.advanced.creditctf">
                    <span class="toggle-track">
                        <div class="toggle-indicator"></div>
                    </span>
                </label>
                <span class="help-text">
                    {{advancedTab.creditbox.helpText}}
                </span>
            </div>
        </div>
    </div>
    <div class="sb-tab-box sb-resbox-box sb-reset-box-style clearfix">
        <div class="tab-label">
            <h3>{{advancedTab.resbox.title}}</h3>
        </div>

        <div class="ctf-tab-form-field">
            <div class="sb-form-field">
                <label for="autores-settings" class="ctf-checkbox">
                    <input type="checkbox" id="autores-settings" v-model="model.advanced.autores">
                    <span class="toggle-track">
                        <div class="toggle-indicator"></div>
                    </span>
                </label>
                <span class="help-text">
                    {{advancedTab.resbox.helpText}}
                </span>
            </div>
        </div>
    </div>
    <div class="sb-tab-box sb-intentBox-box sb-reset-box-style clearfix">
        <div class="tab-label">
            <h3>{{advancedTab.intentBox.title}}</h3>
        </div>

        <div class="ctf-tab-form-field">
            <div class="sb-form-field">
                <label for="enableintents-settings" class="ctf-checkbox">
                    <input type="checkbox" id="enableintents-settings" v-model="model.advanced.enableintents">
                    <span class="toggle-track">
                        <div class="toggle-indicator"></div>
                    </span>
                </label>
                <span class="help-text">
                    {{advancedTab.intentBox.helpText}}
                </span>
            </div>
        </div>
    </div>
    <div class="sb-tab-box sb-requestMethodBox-box sb-reset-box-style clearfix">
        <div class="tab-label">
            <h3>{{advancedTab.requestMethodBox.title}}</h3>
        </div>

        <div class="ctf-tab-form-field">
            <div class="sb-form-field">
                <div class="d-flex mb-10">
                    <select id="sbi-send-report" class="ctf-select size-md" v-model="model.advanced.request_method">
                        <option v-for="(name, key) in advancedTab.requestMethodBox.options" :value="key">{{name}}</option>
                    </select>
                </div>
                <span class="help-text">
                    {{advancedTab.requestMethodBox.helpText}}
                </span>
            </div>
        </div>
    </div>
    <div class="sb-tab-box sb-clearCacheBox-box clearfix">
        <div class="tab-label">
            <h3>{{advancedTab.clearCacheBox.title}}</h3>
        </div>

        <div class="ctf-tab-form-field">
            <div class="sb-form-field">
                <label for="cron_cache_clear-settings" class="ctf-checkbox">
                    <input type="checkbox" id="cron_cache_clear-settings" v-model="model.advanced.cron_cache_clear">
                    <span class="toggle-track">
                        <div class="toggle-indicator"></div>
                    </span>
                </label>
                <span class="help-text">
                    {{advancedTab.clearCacheBox.helpText}}
                </span>
            </div>
        </div>
    </div>


    <div class="sb-tab-box sb-sslonlyBox-box sb-reset-box-style clearfix">
        <div class="tab-label">
            <h3>{{advancedTab.sslonlyBox.title}}</h3>
        </div>

        <div class="ctf-tab-form-field">
            <div class="sb-form-field">
                <label for="sslonly-settings" class="ctf-checkbox">
                    <input type="checkbox" id="sslonly-settings" v-model="model.advanced.sslonly">
                    <span class="toggle-track">
                        <div class="toggle-indicator"></div>
                    </span>
                </label>
                <span class="help-text">
                    {{advancedTab.sslonlyBox.helpText}}
                </span>
            </div>
        </div>
    </div>
    <div class="sb-tab-box sb-curlcardsBox-box sb-reset-box-style clearfix">
        <div class="tab-label">
            <h3>{{advancedTab.curlcardsBox.title}}</h3>
        </div>

        <div class="ctf-tab-form-field">
            <div class="sb-form-field">
                <label for="curlcards-settings" class="ctf-checkbox">
                    <input type="checkbox" id="curlcards-settings" v-model="model.advanced.curlcards">
                    <span class="toggle-track">
                        <div class="toggle-indicator"></div>
                    </span>
                </label>
                <span class="help-text">
                    {{advancedTab.curlcardsBox.helpText}}
                </span>
            </div>
        </div>
    </div>



</div>
