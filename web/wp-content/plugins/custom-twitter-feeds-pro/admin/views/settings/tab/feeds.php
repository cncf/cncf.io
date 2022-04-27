<div v-if="selected === 'app-2'">
    <!--
    <div class="sb-tab-box sb-caching-box sb-reset-box-style clearfix">
        <div class="tab-label">
            <h3>{{feedsTab.cachingBox.title}}</h3>
        </div>
        <div class="ctf-tab-form-field">
            <div class="sb-form-field">
                <div class="mb-10 caching-form-fields-group">
                    <input type="number" id="ctf-caching-intervals" class="ctf-input-number size-sm mr-3" v-model="model.feeds.cacheTime" min="1" max="60" />
                    <select id="ctf-caching-cron-time" class="ctf-select size-xs mr-3" v-model="model.feeds.cacheTimeUnit">
                        <option v-for="(unit, unitKey) in feedsTab.cachingBox.cacheTimeUnits" :value="unitKey">{{unit}}</option>
                    </select>
                    <button type="button" class="ctf-btn sb-btn-lg ctf-caching-btn" @click="clearCache" :disabled="clearCacheStatus !== null">
                        <span v-html="clearCacheIcon()" :class="clearCacheStatus"></span>
                        {{feedsTab.cachingBox.clearCache}}
                    </button>
                </div>
                <div class="help-text help-text-green" v-html="cronNextCheck"></div>
            </div>
        </div>
    </div>
    -->
    <div class="sb-tab-box sb-caching-box sb-reset-box-style clearfix">
        <div class="tab-label">
            <h3>{{feedsTab.cachingBox.title}}</h3>
        </div>
        <div class="ctf-tab-form-field">
            <div class="sb-form-field">
                <div class="mb-10 caching-form-fields-group">
					<select id="ctf-caching-type" class="ctf-select size-xs mr-3" v-model="model.feeds.cachingType">
						<option v-for="(unit, unitKey) in feedsTab.cachingBox.cacheTypeOptions" :value="unitKey">{{unit}}</option>
					</select>
					<input type="number" id="ctf-caching-intervals-page" class="ctf-input-number size-sm mr-3" v-model="model.feeds.cacheTime" min="1" max="60"  v-if="model.feeds.cachingType === 'page'"/>
					<select id="ctf-caching-cron-time-page" class="ctf-select size-xs mr-3" v-model="model.feeds.cacheTimeUnit" v-if="model.feeds.cachingType === 'page'">
						<option v-for="(unit, unitKey) in feedsTab.cachingBox.cacheTimeUnits" :value="unitKey">{{unit}}</option>
					</select>
					<select id="ctf-caching-intervals" class="ctf-select size-sm mr-3" v-model="model.feeds.cronInterval" v-if="model.feeds.cachingType === 'background'">
                        <option v-for="(name, key) in feedsTab.cachingBox.inTheBackgroundOptions" :value="key">{{name}}</option>
                    </select>
                    <select id="ctf-caching-cron-time" class="ctf-select size-xs mr-3" v-model="model.feeds.cronTime" v-if="model.feeds.cachingType === 'background' && model.feeds.cronInterval !== '30mins' && model.feeds.cronInterval !== '1hour'">
                        <option v-for="index in 12" :value="index">{{index}}:00</option>
                    </select>
                    <select id="ctf-caching-cron-am-pm" class="ctf-select size-xs mr-3" v-model="model.feeds.cronAmPm" v-if="model.feeds.cachingType === 'background' && model.feeds.cronInterval !== '30mins' && model.feeds.cronInterval !== '1hour'">
                        <option value="am">{{feedsTab.cachingBox.am}}</option>
                        <option value="pm">{{feedsTab.cachingBox.pm}}</option>
                    </select>
                    <button type="button" class="ctf-btn sb-btn-lg ctf-caching-btn" @click="clearCache" :disabled="clearCacheStatus !== null">
                        <span v-html="clearCacheIcon()" :class="clearCacheStatus"></span>
                        {{feedsTab.cachingBox.clearCache}}
                    </button>
                </div>
                <div class="help-text help-text-green" v-html="cronNextCheck" v-if="model.feeds.cachingType === 'background'"></div>
            </div>
        </div>
    </div>
    <div class="sb-tab-box sb-gdpr-box clearfix">
        <div class="tab-label">
            <h3>
                {{feedsTab.gdprBox.title}}
                <span class="sb-tooltip-info gdpr-tooltip" id="ctf-tooltip" v-html="tooltipHelpSvg"   @mouseover.prevent.default="toggleElementTooltip(feedsTab.gdprBox.tooltip, 'show', 'left')" @mouseleave.prevent.default="toggleElementTooltip('', 'hide')"></span>
            </h3>
        </div>
        <div class="ctf-tab-form-field">
            <div class="sb-form-field">
                <div class="d-flex mb-10">
                    <select id="ctf-gdpr-options" class="ctf-select size-md" v-model="model.feeds.gdpr" @change="gdprOptions">
                        <option value="auto">{{feedsTab.gdprBox.automatic}}</option>
                        <option value="yes">{{feedsTab.gdprBox.yes}}</option>
                        <option value="no">{{feedsTab.gdprBox.no}}</option>
                    </select>
                </div>
                <div class="help-text" v-if="model.feeds.gdpr == 'auto'" :class="['gdpr-help-text-' + model.feeds.gdpr, {'sb-gdpr-active': model.feeds.gdprPlugin}]">
                    <span class="gdpr-active-icon" v-if="model.feeds.gdprPlugin">
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.0003 1.66667C5.41699 1.66667 1.66699 5.41667 1.66699 10C1.66699 14.5833 5.41699 18.3333 10.0003 18.3333C14.5837 18.3333 18.3337 14.5833 18.3337 10C18.3337 5.41667 14.5837 1.66667 10.0003 1.66667ZM8.33366 14.1667L4.16699 10L5.34199 8.82501L8.33366 11.8083L14.6587 5.48334L15.8337 6.66667L8.33366 14.1667Z" fill="#59AB46"/>
                        </svg>
                    </span>
                    <div v-html="feedsTab.gdprBox.infoAuto" :class="{'sb-text-bold': model.feeds.gdprPlugin}"></div>
                    <span v-html="feedsTab.gdprBox.someFacebook" v-if="model.feeds.gdprPlugin"></span>
                    <span v-html="feedsTab.gdprBox.whatLimited" @click="gdprLimited" class="sb-text-bold sb-gdpr-bold" v-if="model.feeds.gdprPlugin"></span>
                </div>
                <div class="help-text" v-if="model.feeds.gdpr == 'yes'" :class="'gdpr-help-text-' + model.feeds.gdpr">
                    <span v-html="feedsTab.gdprBox.infoYes"></span>
                    <span v-html="feedsTab.gdprBox.whatLimited" @click="gdprLimited" class="sb-text-bold sb-gdpr-bold"></span>
                </div>
                <div class="help-text" v-html="feedsTab.gdprBox.infoNo" v-if="model.feeds.gdpr == 'no'" :class="'gdpr-help-text-' + model.feeds.gdpr"></div>
                <div class="sb-gdpr-info-tooltip" v-if="gdprInfoTooltip !== null">
                    <span class="sb-gdpr-info-headline">{{feedsTab.gdprBox.gdprTooltipFeatureInfo.headline}}</span>
                    <ul class="sb-gdpr-info-list">
                        <li v-for="feature in feedsTab.gdprBox.gdprTooltipFeatureInfo.features">{{feature}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="sb-tab-box sb-custom-css-box sb-reset-box-style clearfix">
        <div class="tab-label">
            <h3>{{feedsTab.customCSSBox.title}}</h3>
        </div>
        <div class="ctf-tab-form-field">
            <div class="sb-form-field">
                <div class="d-flex mb-15">
                    <textarea name="" class="ctf-textarea" v-model="model.feeds.customCSS" :placeholder="feedsTab.customCSSBox.placeholder"></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="sb-tab-box sb-custom-js-box clearfix">
        <div class="tab-label">
            <h3>{{feedsTab.customJSBox.title}}</h3>
        </div>
        <div class="ctf-tab-form-field">
            <div class="sb-form-field">
                <div class="d-flex mb-15">
                    <textarea name="" class="ctf-textarea" v-model="model.feeds.customJS" :placeholder="feedsTab.customJSBox.placeholder"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- todo: this is just demo content and will be replaced once I work on this -->
