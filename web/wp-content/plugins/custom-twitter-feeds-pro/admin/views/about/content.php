<div class="ctf-fb-full-wrapper ctf-fb-fs">
    <div class="ctf-sb-container">
    <?php
        /**
         * SBI Admin Notices
         *
         * @since 2.0
         */
        do_action('ctf_admin_notices');
    ?>
        <div class="ctf-section-header">
            <h2>{{genericText.title}}</h2>
        </div>

        <div class="ctf-about-box">
            <div class="sb-team-avatar">
                <img :src="aboutBox.teamAvatar" :alt="aboutBox.teamImgAlt">
            </div>
            <div class="sb-team-info">
                <div class="sb-team-left">
                    <h2>{{aboutBox.atSmashBalloon}}</h2>
                </div>
                <div class="sb-team-right">
                    <p>{{aboutBox.weAreOn}}</p>
                    <p>{{aboutBox.ourPlugins}}</p>
                </div>
            </div>
        </div>

        <div class="ctf-section-second-header">
            <h3>{{genericText.title2}}</h3>
            <p>{{genericText.description2}}</p>
        </div>

        <div class="ctf-plugins-boxes-container">
            <div class="sb-plugins-box" v-for="(plugin, name, index) in plugins">
                <div class="icon"><img :src="plugin.icon" :alt="plugin.title"></div>
                <div class="plugin-box-content">
                    <h4 class="sb-box-title">{{plugin.title}}</h4>
                    <p class="sb-box-description">{{plugin.description}}</p>
                    <div class="sb-action-buttons">
                        <button class="ctf-btn sb-btn-add" v-if="!plugin.installed" @click="installPlugin(plugin.download_plugin, name, index, 'plugin')">
                            <span v-html="buttonIcon()" v-if="btnClicked == index + 1 && btnName == name"></span>
                            {{buttons.install}}
                        </button>
                        <button class="ctf-btn sb-btn-installed" v-if="plugin.installed">
                            <span v-html="icons.checkmarkSVG"></span>
                            {{buttons.installed}}
                        </button>
                        <button class="ctf-btn sb-btn-activate" v-if="plugin.installed && ! plugin.activated" @click="activatePlugin(plugin.plugin, name, index, 'plugin')" :class="btnStatus">
                            <span v-html="buttonIcon()" v-if="btnClicked == index + 1 && btnName == name"></span>
                            {{buttons.activate}}
                        </button>
                        <button class="ctf-btn sb-btn-deactivate" v-if="plugin.installed && plugin.activated && name != 'facebook'" @click="deactivatePlugin(plugin.plugin, name, index, 'plugin')" :class="btnStatus">
                            <span v-html="buttonIcon()" v-if="btnClicked == index + 1 && btnName == name"></span>
                            {{buttons.deactivate}}
                        </button>
                    </div>
                </div>
            </div>

            <div class="sb-plugins-box ctf-social-wall-plugin-box">
                <span class="sb-box-bg-image">
                    <img :src="social_wall.graphic">
                </span>
                <div class="plugin-box-content">
                    <h4 class="sb-box-title">{{social_wall.title}}</h4>
                    <p class="sb-box-description">{{social_wall.description}}</p>
                    <div class="sb-action-buttons">
                        <a class="ctf-btn sb-btn-add" v-if="!social_wall.installed" :href="social_wall.permalink" target="_blank">
                            {{buttons.viewDemo}}
                            <span v-html="icons.link"></span>
                        </a>
                        <button class="ctf-btn sb-btn-installed" v-if="social_wall.installed">
                            <span v-html="icons.checkmarkSVG"></span>
                            {{buttons.installed}}
                        </button>
                        <button class="ctf-btn sb-btn-activate" v-if="social_wall.installed && ! social_wall.activated" @click="activatePlugin(social_wall.plugin, 'social_wall', 1, 'plugin')" :class="btnStatus">
                            <span v-html="buttonIcon()" v-if="btnClicked == 2 && btnName == 'social_wall'"></span>
                            {{buttons.activate}}
                        </button>
                        <button class="ctf-btn sb-btn-deactivate" v-if="social_wall.installed && social_wall.activated" @click="deactivatePlugin(social_wall.plugin, 'social_wall', 1, 'plugin')" :class="btnStatus">
                            <span v-html="buttonIcon()" v-if="btnClicked == 2 && btnName == 'social_wall'"></span>
                            {{buttons.deactivate}}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="ctf-section-second-header">
            <h3>{{genericText.title3}}</h3>
        </div>

        <div class="ctf-plugins-boxes-container sb-recommended-plugins">
            <div class="sb-plugins-box" v-for="(plugin, name, index) in recommendedPlugins">
                <div class="icon"><img :src="plugin.icon" :alt="plugin.title"></div>
                <div class="plugin-box-content">
                    <h4 class="sb-box-title">{{plugin.title}}</h4>
                    <p class="sb-box-description">{{plugin.description}}</p>
                    <div class="sb-action-buttons">
                        <button class="ctf-btn sb-btn-add" v-if="!plugin.installed" @click="installPlugin(plugin.download_plugin, name, index, 'recommended_plugin')">
                            <span v-html="buttonIcon()" v-if="btnClicked == index + 1 && btnName == name"></span>
                            {{buttons.install}}
                        </button>
                        <button class="ctf-btn sb-btn-installed" v-if="plugin.installed">
                            <span v-html="icons.checkmarkSVG"></span>
                            {{buttons.installed}}
                        </button>
                        <button class="ctf-btn sb-btn-activate" v-if="plugin.installed && ! plugin.activated" @click="activatePlugin(plugin.plugin, name, index, 'recommended_plugin')" :class="btnStatus">
                            <span v-html="buttonIcon()" v-if="btnClicked == index + 1 && btnName == name"></span>
                            {{buttons.activate}}
                        </button>
                        <button class="ctf-btn sb-btn-deactivate" v-if="plugin.installed && plugin.activated && name != 'facebook'" @click="deactivatePlugin(plugin.plugin, name, index, 'recommended_plugin')" :class="btnStatus">
                            <span v-html="buttonIcon()" v-if="btnClicked == index + 1 && btnName == name"></span>
                            {{buttons.deactivate}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="sb-notification-ctn" :data-active="notificationElement.shown" :data-type="notificationElement.type">
	<div class="sb-notification-icon" v-html="svgIcons[notificationElement.type+'Notification']"></div>
	<span class="sb-notification-text" v-html="notificationElement.text"></span>
</div>