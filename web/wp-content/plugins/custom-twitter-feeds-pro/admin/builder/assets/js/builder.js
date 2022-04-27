var ctfBuilder,
	ctfStorage = window.localStorage,
	sketch = VueColor.Sketch,
	dummyLightBoxComponent = 'ctf-dummy-lightbox-component';



Vue.component( dummyLightBoxComponent , {
	template: '#' + dummyLightBoxComponent,
	props: ['customizerFeedData','parent','dummyLightBoxScreen']
});





/**
 * VueJS Global App Builder
 *
 * @since 2.0
 */
ctfBuilder = new Vue({
	el: '#ctf-builder-app',
	http: {
        emulateJSON: true,
        emulateHTTP: true
    },
    components: {
	    'sketch-picker': sketch,
    },
	mixins: [VueClickaway.mixin],
	data: {
		nonce : ctf_builder.nonce,
		template :  ctf_builder.feedInitOutput,
		templateRender : false,
		updatedTimeStamp : new Date().getTime(),
		feedSettingsDomOptions : null,
		newAccountData : ctf_builder.newAccountData,

		$parent : this,
		plugins: ctf_builder.installPluginsPopup,
		supportPageUrl: ctf_builder.supportPageUrl,
		builderUrl 	: ctf_builder.builderUrl,
		pluginType	: ctf_builder.pluginType,
		genericText	: ctf_builder.genericText,
		ajaxHandler : ctf_builder.ajax_handler,
		adminPostURL : ctf_builder.adminPostURL,
		adminSettingsURL : ctf_builder.adminSettingsURL,
		widgetsPageURL : ctf_builder.widgetsPageURL,
		translatedText : ctf_builder.translatedText,
		socialShareLink : ctf_builder.socialShareLink,

		welcomeScreen	 : ctf_builder.welcomeScreen,
		allFeedsScreen 	 : ctf_builder.allFeedsScreen,
		extensionsPopup  : ctf_builder.extensionsPopup,
		mainFooterScreen : ctf_builder.mainFooterScreen,
		embedPopupScreen : ctf_builder.embedPopupScreen,
		connectAccountScreen : ctf_builder.connectAccountScreen,

		selectSourceScreen 		: ctf_builder.selectSourceScreen,
		customizeScreensText 	: ctf_builder.customizeScreens,
		dialogBoxPopupScreen   	: ctf_builder.dialogBoxPopupScreen,
		selectFeedTypeScreen 	: ctf_builder.selectFeedTypeScreen,
 		selectFeedTemplateScreen 	: ctf_builder.selectFeedTemplateScreen,
		accountDetails : ctf_builder.accountDetails,
		dummyLightBoxData 		: ctf_builder.dummyLightBoxData,

		svgIcons 		: ctf_builder.svgIcons,
		feedsList 	: ctf_builder.feeds,
		feedTypes 	: ctf_builder.feedTypes,
		appCredentials : ctf_builder.appCredentials,
		appOAUTH 		: ctf_builder.appOAUTH,
		socialInfo 	: ctf_builder.socialInfo,

		feedTemplates 	: ctf_builder.feedTemplates,


		links : ctf_builder.links,
		legacyFeedsList   : ctf_builder.legacyFeeds,

   		dummyLightBoxScreen 	: false,

		//Selected Feed type => User Hashtag Tagged
		selectedFeed : ['usertimeline'],
		selectedFeedPopup : [],
		// Selected Feed Template
		selectedFeedTemplate : 'default',

		selectedFeedModelPopup : {
			'usertimeline' : '',
			'hashtag' : '',
			'hometimeline' : '',
			'search' : '',
			'mentionstimeline' : '',
			'lists' : '',
			'listsObject' : []
		},
		selectedFeedModel : {
			'usertimeline' : '',
			'hashtag' : '',
			'hometimeline' : '',
			'search' : '',
			'mentionstimeline' : '',
			'lists' : '',
			'listsObject' : []
		},

		listIdInputModel: '',
		listUserNameInputModel : '',
		listUserNameInputModelSearched : '',
		listUserNameResult : [],
		noListFound : null,

		viewsActive : {
			//Screens where the footer widget is disabled
			footerDiabledScreens : [
				'welcome',
				'selectFeed'
			],
			footerWidget : false,

			// welcome, selectFeed
			pageScreen : 'welcome',

			// feedsType, selectSource, feedsTypeGetProcess
			selectedFeedSection : 'feedsType',

			sourcePopup : false,
			feedtypesPopup : false,
			feedtypesCustomizerPopup : false,
			feedtemplatesPopup : false,
			sourcesListPopup : false,
			connectAccountPopup : false,
			// step_1 [Add New Source] , step_2 [Connect to a user pages/groups], step_3 [Add Manually]
			sourcePopupScreen : 'redirect_1',

			connectAccountStep : 'step_1',

			// creation or customizer
			sourcePopupType : 'creation',
			extensionsPopupElement : false,
			feedTypeElement : null,
			feedTemplateElement : null,
			instanceFeedActive : null,
			clipboardCopiedNotif : false,
			legacyFeedsShown : false,
			editName : false,
			embedPopup : false,
			embedPopupScreen : 'step_1',
			embedPopupSelectedPage : null,

			moderationMode : false,

            // onboarding
			onboardingPopup : ctf_builder.allFeedsScreen.onboarding.active,
            onboardingStep : 1,

			// customizer onboarding
			onboardingCustomizerPopup : ctf_builder.customizeScreens.onboarding.active,

			// plugin install popup
			installPluginPopup : false,
			installPluginModal: 'facebook'
        },

        //Feeds Pagination
        feedPagination : {
        	feedsCount  : ctf_builder.feedsCount != undefined ? ctf_builder.feedsCount : null,
        	pagesNumber : 1,
        	currentPage : 1,
        	itemsPerPage : ctf_builder.itemsPerPage != undefined ? ctf_builder.itemsPerPage : null,
        },



		isCreateProcessGood : false,
		feedCreationInfoUrl : null,
		feedTypeOnSourcePopup : 'user',

		feedsSelected : [],
		selectedBulkAction : false,

		customizerFeedDataInitial : null,
		customizerFeedData 	: ctf_builder.customizerFeedData,
		wordpressPageLists  : ctf_builder.wordpressPageLists,
		iscustomizerScreen  	: (ctf_builder.customizerFeedData != undefined && ctf_builder.customizerFeedData != false),

		customizerSidebarBuilder : ctf_builder.customizerSidebarBuilder,
		customizerScreens : {
			activeTab 		: 'customize',
			printedType 	: {},
			printedTemplate : {},
			activeSection 	: null,
			previewScreen 	: 'desktop',
			sourceExpanded 	: null,
			sourcesChoosed 	: [],
			inputNameWidth 	: '0px',
			activeSectionData 	: null,
			parentActiveSection : null, //For nested Setions
			parentActiveSectionData : null, //For nested Setions
			activeColorPicker : null
		},
		previewScreens: [
			'desktop',
			'tablet',
			'mobile'
		],

		nestedStylingSection : [
			'post_styling_author',
			'post_styling_tweet_text',
			'post_styling_tweet_date',
			'post_styling_tweet_actions',
			'post_styling_quote_tweet',
			'post_styling_media',
			'post_styling_replies',
			'post_styling_retweet',
			'post_styling_twitter_cards',
			'post_styling_logos'
		],
		expandedCaptions : [],
		manualAccountResp : false,
		sourceToDelete : {},
		feedToDelete : {},
		dialogBox : {
			active : false,
			type : null, //deleteSourceCustomizer
			heading : null,
			description : null,
			customButtons : undefined
		},

		feedStyle : '',
		expandedPostText : [],
		showedSocialShareTooltip : null,
		showedCommentSection : [],

		//LightBox Object
		lightBox : {
			visibility 	: 'hidden',
			type 		: null,
			post 		: null,
			activeImage : null,
			albumIndex : 0,
			videoSource : null
		},
		highLightedSection : 'all',

		shoppableFeed : {
			postId : null,
			postMedia : null,
			postCaption : null,
			postShoppableUrl : ''
		},

		moderationSettings : {
			list_type_selected : null,
			allow_list : [],
			block_list : []
		},
		customBlockModerationlistTemp : '',
		tooltip : {
			text : '',
			hover : false,
			hoverType : 'outside'
		},
		//Loading Bar
		fullScreenLoader : false,
		appLoaded : false,
		previewLoaded : false,
		loadingBar : true,
		notificationElement : {
			type : 'success', // success, error, warning, message
			text : '',
			shown : null
		},

		loadingAjax : false,

	},
	watch : {
		feedPreviewOutput : function(){
			return this.feedPreviewMaker()
		},
	},
	computed : {

		feedStyleOutput : function(){
			return this.customizerStyleMaker();
		},
		singleHolderData : function(){
			return this.singleHolderParams();
		},
		getModerationShoppableMode : function(){
			if( this.viewsActive.moderationMode || this.customizerScreens.activeSection == 'settings_shoppable_feed'){
				this.moderationShoppableMode = true;
			}else{
				this.moderationShoppableMode = false;
			}
			return this.moderationShoppableMode;
		}

	},
	updated : function(){
		var self = this;
		if( self.customizerFeedData ){
			self.setShortcodeGlobalSettings(true);
		}
	},
	created: function(){
		var self = this;
		this.$parent = self;
		if( self.customizerFeedData ){
			self.template = String("<div>"+self.template+"</div>");
			self.selectedFeedModel = JSON.parse(JSON.stringify(self.initSelectedFeedTypeModel()));
			self.selectedFeedModelPopup = JSON.parse(JSON.stringify(self.initSelectedFeedTypeModel()));
			self.selectedFeed = self.getCustomizerSelectedFeedsType();
			self.updatedTimeStamp = new Date().getTime();
			self.customizerFeedDataInitial = JSON.parse(JSON.stringify(self.customizerFeedData));
		}

		if(self.customizerFeedData == undefined){
			self.feedPagination.pagesNumber = self.feedPagination.feedsCount != null ? Math.ceil(self.feedPagination.feedsCount / self.feedPagination.itemsPerPage) : 1;
			self.processIFConnectSuccess();
		}
		window.addEventListener('beforeunload', (event) => {
			if( self.customizerFeedData ){
		        self.leaveWindowHandler(event);
			}
      	});


		self.loadingBar = false;
        /* Onboarding - move elements so the position is in context */
		self.positionOnboarding();
		setTimeout(function(){
			self.positionOnboarding();
		}, 500);

		self.appLoaded = true;
	},
	methods: {
		updateColorValue : function(id){
			var self = this;
			self.customizerFeedData.settings[id] = (self.customizerFeedData.settings[id].a == 1) ? self.customizerFeedData.settings[id].hex : self.customizerFeedData.settings[id].hex8;
		},


		/**
		 * Init Selected Feed Type Sources
		 *
		 * @since 2.0
		 */
		initSelectedFeedTypeModel : function(){
			var self = this,
				customizerSettings = self.customizerFeedData.settings,
				selectedFeedModel = self.selectedFeedModel;

			if(customizerSettings.type != undefined && customizerSettings.type == 'mixed' ){
				selectedFeedModel = {
					'usertimeline' 		: customizerSettings.screenname !== undefined ? customizerSettings.screenname : '' ,
					'hashtag' 			: customizerSettings.hashtag !== undefined ? customizerSettings.hashtag : '' ,
					'hometimeline' 		: customizerSettings.home !== undefined && customizerSettings.home == true ? 'true' : '',
					'search' 			: customizerSettings.search !== undefined ? customizerSettings.search : '' ,
					'mentionstimeline' 	: customizerSettings.mentions !== undefined && customizerSettings.mentions == true ? 'true' : false ,
					'lists' 			: customizerSettings.lists !== undefined ? customizerSettings.lists :  '',
					'listsObject' 		: customizerSettings.lists_info !== undefined && self.jsonParse(customizerSettings.lists_info) !== false ? self.jsonParse(customizerSettings.lists_info) : []
				};
			}
			if(customizerSettings.type != undefined && customizerSettings.type != 'mixed' ){
				switch (customizerSettings.type) {
					case 'usertimeline':
						selectedFeedModel.usertimeline = self.checkNotEmpty(customizerSettings.usertimeline_text)  ? customizerSettings.usertimeline_text : (self.checkNotEmpty(customizerSettings.screenname) ? customizerSettings.screenname : '');
					break;
					case 'hashtag':
						selectedFeedModel.hashtag = self.checkNotEmpty(customizerSettings.hashtag_text)  ? customizerSettings.hashtag_text : (self.checkNotEmpty(customizerSettings.hashtag) ? customizerSettings.hashtag : '');
					break;
					case 'search':
						selectedFeedModel.search = self.checkNotEmpty(customizerSettings.search_text)  ? customizerSettings.search_text : (self.checkNotEmpty(customizerSettings.search) ? customizerSettings.search : '') ;
					break;
					case 'hometimeline':
						selectedFeedModel.hometimeline = true;
					break;
					case 'mentionstimeline':
						selectedFeedModel.mentionstimeline = true;
					break;
					case 'lists':
						selectedFeedModel.lists = customizerSettings.lists_id !== undefined ? customizerSettings.lists_id : '' ;
						selectedFeedModel.listsObject = customizerSettings.lists_info !== undefined && self.jsonParse(customizerSettings.lists_info) !== false ? self.jsonParse(customizerSettings.lists_info) : []
					break;
				}
			}
			return selectedFeedModel;
		},

		/**
		 * Apply Feed Popup Changes
		 *
		 * @since 2.0
		 */
		applyFeedTypePopup : function(){
			var self = this,
				feedTypes = Object.entries(self.selectSourceScreen.multipleTypes);
				selectedFeedModel = self.selectedFeedModel;

			feedTypes.forEach( function(element) {
				var feedTypeID = element[0],
					settingName = feedTypeID == 'usertimeline' ? 'screenname' : feedTypeID;
				self.customizerFeedData.settings[settingName] = self.selectedFeedModel[feedTypeID];
			});

			if( self.customizerFeedData ){
				self.customizerFeedData.settings.type = self.selectedFeed.length > 1 ? 'mixed' : self.selectedFeed[0];
				self.cleanUnselectedFeedTypes();
			}

		},

		/**
		 * Clean Unselected Feed Types
		 *
		 * @since 2.0
		 */
		cleanUnselectedFeedTypes : function(){
			var self = this;
			if( !self.selectedFeed.includes('hashtag') ){
				self.customizerFeedData.settings.hashtag_text = '';
				self.customizerFeedData.settings.hashtag = '';
			}

			if( !self.selectedFeed.includes('usertimeline') ){
				self.customizerFeedData.settings.usertimeline_text = '';
				self.customizerFeedData.settings.screenname = '';
			}

			if( !self.selectedFeed.includes('search') ){
				self.customizerFeedData.settings.search_text = '';
				self.customizerFeedData.settings.search = '';
			}

			if( !self.selectedFeed.includes('hometimeline') ){
				self.customizerFeedData.settings.home = '';
			}

			if( !self.selectedFeed.includes('mentionstimeline') ){
				self.customizerFeedData.settings.mentions = '';
			}

			if( !self.selectedFeed.includes('lists') ){
				self.customizerFeedData.settings.lists_id = '';
				self.customizerFeedData.settings.lists = '';
				self.customizerFeedData.settings.lists_info = '';
			}
		},


		/**
		 * Leave Window Handler
		 *
		 * @since 2.0
		 */
		leaveWindowHandler : function(ev){
			var self = this,
			updateFeedData = {
				action : 'ctf_feed_saver_manager_recache_feed',
				feedID : self.customizerFeedData.feed_info.id,
			};
			self.ajaxPost(updateFeedData, function(_ref){
				var data = _ref.data;
			});
		},

		/**
		 * Show & Hide View
		 *
		 * @since 2.0
		 */
		activateView : function(viewName, sourcePopupType = 'creation', ajaxAction = false){
			var self = this;
			self.viewsActive[viewName] = (self.viewsActive[viewName] == false ) ? true : false;

			if(viewName === 'feedtypesPopup'){
				self.viewsActive.feedTypeElement = null;
				self.selectedFeedPopup = JSON.parse(JSON.stringify(self.selectedFeed));
			}
			if(viewName === 'extensionsPopupElement' && self.customizerFeedData !== undefined){
				//self.activateView('feedtypesPopup');
			}
			if(viewName == 'editName'){
				document.getElementById("ctf-csz-hd-input").focus();
			}
			if(viewName == 'embedPopup' && ajaxAction == true){
				self.saveFeedSettings();
			}

			if((viewName == 'sourcePopup' || viewName == 'sourcePopupType') && sourcePopupType == 'creationRedirect'){
				setTimeout(function(){
					self.$refs.addSourceRef.processIFConnect()
				},3500);
			}
			ctfBuilder.$forceUpdate();
			self.movePopUp();
		},

		/**
		 * Show/Hide View or Redirect to plugin dashboard page
		 *
		 * @since 2.0
		 */
		activateViewOrRedirect: function(viewName, pluginName, plugin) {
			var self = this;
			if ( plugin.installed && plugin.activated ) {
				window.location = plugin.dashboard_permalink;
				return;
			}

			self.viewsActive[viewName] = (self.viewsActive[viewName] == false ) ? true : false;

			if(viewName == 'installPluginPopup'){
				self.viewsActive.installPluginModal = pluginName;
			}

			self.movePopUp();
			ctfBuilder.$forceUpdate();
		},

		movePopUp : function(){
			var overlay = document.querySelectorAll("sb-fs-boss");
			if (overlay.length > 0) {
				document.getElementById("wpbody-content").prepend(overlay[0]);
			}
		},

		/**
		 * Check if View is Active
		 *
		 * @since 2.0
		 *
		 * @return boolean
		 */
		checkActiveView : function(viewName){
			return this.viewsActive[viewName];
		},

		/**
		 * Check if Control Is active
		 *
		 * @since 2.0
		 *
		 * @return boolean
		 */
		checkActiveControl : function(controlId, enabled){
			var self = this;
			return self.customizerFeedData.settings[controlId] === enabled || self.customizerFeedData.settings[controlId] === enabled.toString();

		},

		/**
		 * Switch & Change Feed Screens
		 *
		 * @since 2.0
		 */
		switchScreen: function(screenType, screenName){
			this.viewsActive[screenType] = screenName;
			ctfBuilder.$forceUpdate();
		},

		/**
		 * Check if Value is Empty
		 *
		 * @since 2.0
		 *
		 * @return boolean
		 */
		checkNotEmpty : function(value){
			return value != false && value != null && value != undefined && value.replace(/ /gi,'') != '';
		},

		/**
		 * Check if Value exists in Array Object
		 *
		 * @since 2.0
		 *
		 * @return boolean
		 */
		checkObjectArrayElement : function(objectArray, object, byWhat){
			var objectResult = objectArray.filter(function(elem){
				return elem[byWhat] == object[byWhat];
			});
			return (objectResult.length > 0) ? true : false;
		},

		/**
		 * Check if Data Setting is Enabled
		 *
		 * @since 2.0
		 *
		 * @return boolean
		 */
		valueIsEnabled : function(value){
			return value == 1 || value == true || value == 'true' || value == 'on';
		},


		/**
		 * Parse JSON
		 *
		 * @since 2.0
		 *
		 * @return jsonObject / Boolean
		 */
		jsonParse : function(jsonString){
			try {
				return JSON.parse(jsonString);
			} catch(e) {
				return false;
			}
		},


		/**
		 * Ajax Post Action
		 *
		 * @since 2.0
		 */
		ajaxPost : function(data, callback){
			var self = this;
			data['nonce'] = self.nonce;
			self.$http.post(self.ajaxHandler,data).then(callback);
		},

		/**
		 * Check if Object has Nested Property
		 *
		 * @since 2.0
		 *
		 * @return boolean
		 */
		hasOwnNestedProperty : function(obj,propertyPath) {
		  if (!propertyPath){return false;}var properties = propertyPath.split('.');
		  for (var i = 0; i < properties.length; i++) {
		    var prop = properties[i];
		    if (!obj || !obj.hasOwnProperty(prop)) {
		      return false;
		    } else {
		      obj = obj[prop];
		    }
		  }
		  return true;
		},


		/**
		 * Feed List Pagination
		 *
		 * @since 2.0
		 */
		feedListPagination : function(type){
			var self = this,
				currentPage = self.feedPagination.currentPage,
				pagesNumber = self.feedPagination.pagesNumber;
			self.loadingBar = true;
			if((currentPage != 1 && type == 'prev') || (currentPage <  pagesNumber && type == 'next')){
				self.feedPagination.currentPage = (type == 'next') ?
					(currentPage < pagesNumber ? (parseInt(currentPage) + 1) : pagesNumber) :
					(currentPage > 1 ? (parseInt(currentPage) - 1) : 1);

				var postData = {
	                action : 'ctf_feed_saver_manager_get_feed_list_page',
					page : self.feedPagination.currentPage
				};
	            self.ajaxPost(postData, function(_ref){
	                var data = _ref.data;
	                if(data){
	                	self.feedsList = data;
	                }
					self.loadingBar = false;
	            });
				ctfBuilder.$forceUpdate();
			}
		},

		/**
		 * Choose Feed Type
		 *
		 * @since 2.0
		 */
		chooseFeedType : function(feedTypeEl, iscustomizerPopup = false){
			var self = this;
			if(feedTypeEl.type != 'socialwall'){
				if(self.selectedFeed.includes(feedTypeEl.type)){
					if(self.selectedFeed.length != 1){
						self.selectedFeed.splice(self.selectedFeed.indexOf(feedTypeEl.type), 1);
					}
				}else{
					self.selectedFeed.push(feedTypeEl.type);
				}
			}else if(feedTypeEl.type == 'socialwall'){
				self.viewsActive.extensionsPopupElement = 'socialwall';
			}
			ctfBuilder.$forceUpdate();
		},

		/**
		 * Choose Feed Type
		 *
		 * @since 2.0
		 */
		selectFeedTypePopup : function( feedTypeEl ){
			var self = this;
			if(feedTypeEl.type != 'socialwall'){
				if(!self.selectedFeedPopup.includes(feedTypeEl.type)){
					self.selectedFeedPopup.push(feedTypeEl.type);
				}else{
					self.selectedFeedPopup.splice(self.selectedFeedPopup.indexOf(feedTypeEl.type), 1);
				}
			}
		},

		/**
		 * Check Selected Feed Type
		 *
		 * @since 2.0
		 */
		checkFeedTypeSelect : function( feedTypeEl ){
			var self = this;
			if(self.customizerFeedData){
				return self.selectedFeedPopup.includes(feedTypeEl.type) && feedTypeEl.type != 'socialwall'
			}
			return self.selectedFeed.includes(feedTypeEl.type) && feedTypeEl.type != 'socialwall'
		},

		/**
		 * Confirm Add Feed Type Poup
		 *
		 * @since 2.0
		 */
		addFeedTypePopup : function(){
			var self = this;
			self.selectedFeed = self.selectedFeedPopup;
			self.selectedFeed = self.selectedFeed.filter((element, index) => {
			    return self.selectedFeed.indexOf(element) === index;
			});
			self.activateView('feedtypesPopup');
			if( self.customizerFeedData ){
				self.activateView('feedtypesCustomizerPopup');
			}
		},

		/**
		 * Returns The Selected Feeds Type
		 * For Customizer PopUp
		 *
		 * @since 2.0
		 */
		getCustomizerSelectedFeedsType : function(){
			var self = this,
				customizerSettings =  self.customizerFeedData.settings;

			switch (customizerSettings.type) {
				case 'usertimeline':
					return ['usertimeline'];
				break;
				case 'hashtag':
					return ['hashtag'];
				break;
				case 'hometimeline':
					return ['hometimeline'];
				break;
				case 'search':
					return ['search'];
				break;
				case 'mentionstimeline':
					return ['mentionstimeline'];
				break;
				case 'lists':
					return ['lists'];
				break;
				default:
					var feedTypes = [];
						self.feedTypes.forEach( function(feed) {
							if(self.checkNotEmpty( self.selectedFeedModel[feed.type])){
								feedTypes.push( feed.type );
							}

						});
					return feedTypes;
				break;
			}

		},

		/**
		 * Choose Feed Type
		 *
		 * @since 2.0
		 */
		checkMultipleFeedType : function(){
			return this.selectedFeed.length > 1;
		},

		/**
		 * Check if Feed Type Source is Active
		 *
		 * @since 2.0
		 */
		checkMultipleFeedTypeActive : function(feedTypeID){
			var self = this;
			if(self.customizerFeedData){
				return self.selectedFeedPopup.length >= 1 && self.selectedFeedPopup.includes(feedTypeID);
			}
			return self.selectedFeed.length >= 1 && self.selectedFeed.includes(feedTypeID);
		},

		/**
		 * Customizer
		 * Check if Feed Type Source is Active
		 *
		 * @since 2.0
		 */
		checkMultipleFeedTypeActiveCustomizer : function(feedTypeID){
			return this.customizerFeedData.settings.type == feedTypeID || ( this.customizerFeedData.settings.type == 'mixed' && this.checkFeedTypeHasSources(feedTypeID) );
		},

		/**
		 * Customizer
		 * Check if Feed Type Has Sources
		 *
		 * @since 2.0
		 */
		checkFeedTypeHasSources : function(feedTypeID){
			var self = this;
			switch (feedTypeID) {
				case 'usertimeline':
					return self.checkNotEmpty(self.customizerFeedData.settings.screenname) && self.customizerFeedData.settings.screenname !== undefined && self.createSourcesArray(self.customizerFeedData.settings.screenname).length > 0;
				break;
				case 'hashtag':
					return self.checkNotEmpty(self.customizerFeedData.settings.hashtag) && self.customizerFeedData.settings.hashtag !== undefined && self.createSourcesArray(self.customizerFeedData.settings.hashtag).length > 0;
				break;
				case 'hometimeline':
					return self.customizerFeedData.settings.home !== undefined && self.valueIsEnabled(self.customizerFeedData.settings.home);
				break;
				case 'search':
					return self.checkNotEmpty(self.customizerFeedData.settings.search) && self.customizerFeedData.settings.search !== undefined && self.createSourcesArray(self.customizerFeedData.settings.search).length > 0;
				break;
				case 'mentionstimeline':
					return self.customizerFeedData.settings.mentions !== undefined && self.valueIsEnabled(self.customizerFeedData.settings.mentions);
				break;
				case 'lists':
					return self.checkNotEmpty(self.customizerFeedData.settings.lists_info) && self.customizerFeedData.settings.lists_info !== undefined && self.jsonParse(self.customizerFeedData.settings.lists_info) !== false && Object.keys(self.jsonParse(self.customizerFeedData.settings.lists_info)).length  > 0;
				break;
				case 'lists_ids':
					return self.checkNotEmpty(self.customizerFeedData.settings.lists) && self.customizerFeedData.settings.lists !== undefined && self.createSourcesArray(self.customizerFeedData.settings.lists).length > 0;
				break;
			}
			return false;
		},

		/**
		 * Customizer
		 * Toggle the Feed Types in Popup
		 *
		 * @since 2.0
		 */
	    openFeedTypesPopupCustomizer : function(){
			var self = this;
			self.selectedFeedPopup = JSON.parse(JSON.stringify(self.selectedFeed));
			self.selectedFeedModelPopup = JSON.parse(JSON.stringify(self.selectedFeedModel));
	    	self.activateView('feedtypesCustomizerPopup');
	    },

		/**
		 * Customizer
		 * Toggle the Feed Types in Popup
		 *
		 * @since 2.0
		 */
		toggleFeedTypesChooserPopup : function(){
			var self = this;
			self.activateView('feedtypesCustomizerPopup');
			self.activateView('feedtypesPopup');
		},

		/**
		 * Customizer
		 * Toggle the Feed Types With Sources Popup
		 *
		 * @since 2.0
		 */
		toggleFeedTypesSourcesPopup : function(){
			var self = this;

			self.activateView('sourcesListPopup');
			if( self.customizerFeedData ){
				self.activateView('feedtypesCustomizerPopup');
			}
		},

		/**
		 * Customizer
		 * Update Feed Type
		 * & Sources/Hashtags
		 * @since 2.0
		 */
		updateFeedTypeAndSourcesCustomizer : function(){
			var self = this,
				feedTypes = Object.entries(self.selectSourceScreen.multipleTypes);
			self.selectedFeedModel = JSON.parse(JSON.stringify(self.selectedFeedModelPopup));

			feedTypes.forEach( function(element) {
				var feedTypeID = element[0];
				if( !self.selectedFeed.includes(feedTypeID) ){
					var settingName = feedTypeID == 'usertimeline' ? 'screenname' : feedTypeID,
					settingValue = ( feedTypeID !== 'hometimeline' && feedTypeID !== 'mentionstimeline' ) ? '' : 'false';
					self.customizerFeedData.settings[settingName] = '';
					if(feedTypeID == 'lists'){
						self.customizerFeedData.settings['lists_info'] = [];
					}
				}else{
					if(feedTypeID == 'hometimeline'){
						self.customizerFeedData.settings.home = true;
					}
					if(feedTypeID == 'mentionstimeline'){
						self.customizerFeedData.settings.metions = true;
					}
				}
			});
			self.applyFeedTypePopup();
			self.customizerControlAjaxAction('feedFlyPreview');
			self.activateView('feedtypesCustomizerPopup');

		},

		/**
		 * Customizer
		 * Cancel Feed Types
		 * & Sources/Hashtags
		 * @since 2.0
		 */
		cancelFeedTypeAndSourcesCustomizer : function(){
			var self = this;
			if( JSON.stringify(self.selectedFeedModelPopup) === JSON.stringify(self.selectedFeedModel) ){
				self.viewsActive['feedtypesPopup'] = false;
				self.activateView('feedtypesCustomizerPopup');

			}else{
				self.openDialogBox('unsavedFeedSources');
			}

		},




		/**
		 * If max number of source types are added (3)
		 *
		 * @since 2.0
		 */
		maxTypesAdded : function(){
			return this.selectedFeed.length >= 6;
		},

		/**
		 * Check if Feed Type Source is Active
		 *
		 * @since 2.0
		 */
		removeFeedTypeSource : function(feedTypeID){
			var self = this;
			if(self.selectedFeed.length > 1){
				if(self.customizerFeedData){
					var settingName = feedTypeID == 'usertimeline' ? 'screenname' : feedTypeID,
						settingValue = ( feedTypeID !== 'hometimeline' && feedTypeID !== 'mentionstimeline' ) ? '' : false;
					self.selectedFeedModelPopup[feedTypeID] = settingValue;
					if(feedTypeID == 'lists'){
						self.selectedFeedModelPopup['listsObject'] = {};
					}

				}else{
					self.selectedFeedModel[feedTypeID] = ( feedTypeID !== 'hometimeline' && feedTypeID !== 'mentionstimeline' ) ? '' : false;
					if(feedTypeID == 'lists'){
						self.selectedFeedModel['listsObject'] = {};
					}
				}
				self.selectedFeed.splice(self.selectedFeed.indexOf(feedTypeID), 1);
				if(self.customizerFeedData){
					self.selectedFeedPopup = self.selectedFeed;
				}
			}
		},

		/**
		 * Choose Feed Type
		 *
		 * @since 2.0
		 */
		checkSingleFeedType : function(feedType){
			return this.selectedFeed.length == 1 && this.selectedFeed[0] == feedType;
		},


		//Check Feed Creation Process Sources & Hashtags
		creationProcessCheckAppCredentials : function(){
			var self = this;
			return self.checkNotEmpty( self.appCredentials.access_token ) && self.checkNotEmpty( self.appCredentials.access_token_secret );
		},

        processIFConnectSuccess : function(){
        	var self = this;
           if( ctfStorage.selectedFeed !== undefined){
            	self.selectedFeed = ctfStorage.selectedFeed.split(',');
            	self.viewsActive.pageScreen = 'selectFeed';
            	self.viewsActive.selectedFeedSection = 'selectSource';
        	}
            ctfStorage.removeItem("selectedFeed");
        },

		connectAccountLink : function(){
			var self = this;
            ctfStorage.setItem('selectedFeed', self.selectedFeed);
            window.location = self.appOAUTH;
		},

		/*
			Feed Creation Process
		*/
		creationProcessCheckAction : function(){
			var self = this, checkBtnNext = false;
			switch (self.viewsActive.selectedFeedSection) {
				case 'feedsType':
					checkBtnNext = self.selectedFeed != null ? true : false;
					window.ctfSelectedFeed = self.selectedFeed;
				break;
				case 'selectSource':
					checkBtnNext = self.creationProcessCheckAppCredentials();
				break;
				case 'selectTemplate':
					checkBtnNext = self.creationProcessCheckAppCredentials();
				break;
				case 'feedsTypeGetProcess':

				break;
			}
			return checkBtnNext;
		},
		//Next Click in the Creation Process
		creationProcessNext : function(){
			var self = this;
			switch (self.viewsActive.selectedFeedSection) {
				case 'feedsType':
					if(self.selectedFeed !== null){
						if (self.selectedFeed === 'socialwall') {
							window.location.href = ctf_builder.pluginsInfo.social_wall.settingsPage;
							return;
						}
						if( self.creationProcessCheckAppCredentials() ){
							self.switchScreen('selectedFeedSection', 'selectSource');
						}else{
							self.viewsActive['connectAccountPopup'] = true;
						}
					}
				break;
				case 'selectSource':
					if( self.creationProcessCheckAppCredentials() ){
						self.switchScreen('selectedFeedSection', 'selectTemplate');
					}
				break;
				case 'selectTemplate':
					if( self.creationProcessCheckAppCredentials() && self.checkNotEmpty(self.selectedFeedTemplate) ){
						self.isCreateProcessGood = true;
					}
				break;
				case 'feedsTypeGetProcess':
				break;
			}
			if(self.isCreateProcessGood)
				self.submitNewFeed();

		},
		changeVideoSource : function( videoSource ){
			this.videosTypeInfo.type = videoSource;
			ctfBuilder.$forceUpdate();
		},

        //Next Click in the Onboarding Process
        onboardingNext : function(){
            this.viewsActive.onboardingStep ++;
			this.onboardingHideShow();
			ctfBuilder.$forceUpdate();
		},
        //Previous Click in the Onboarding Process
        onboardingPrev : function(){
            this.viewsActive.onboardingStep --;
            this.onboardingHideShow();
			ctfBuilder.$forceUpdate();
        },
		onboardingHideShow : function() {
			var tooltips = document.querySelectorAll(".sb-onboarding-tooltip");
			for (var i = 0; i < tooltips.length; i++){
				tooltips[i].style.display = "none";
			}
			document.querySelectorAll(".sb-onboarding-tooltip-"+this.viewsActive.onboardingStep)[0].style.display = "block";

			if (this.viewsActive.onboardingCustomizerPopup) {
				if (this.viewsActive.onboardingStep === 2) {
					this.switchCustomizerTab('customize');
				} else if (this.viewsActive.onboardingStep === 3) {
					this.switchCustomizerTab('settings');
				}
			}

		},
        //Close Click in the Onboarding Process
        onboardingClose : function(){
            var self = this,
				wasActive = self.viewsActive.onboardingPopup ? 'newuser' : 'customizer';

            document.getElementById("ctf-builder-app").classList.remove('sb-onboarding-active');

			self.viewsActive.onboardingPopup = false;
			self.viewsActive.onboardingCustomizerPopup = false;

			self.viewsActive.onboardingStep = 0;
            var postData = {
                action : 'ctf_dismiss_onboarding',
				was_active : wasActive
			};
            self.ajaxPost(postData, function(_ref){
                var data = _ref.data;
            });
			ctfBuilder.$forceUpdate();
        },
		positionOnboarding : function(){
			var self = this,
				onboardingElem = document.querySelectorAll(".sb-onboarding-overlay")[0],
				wrapElem = document.getElementById("ctf-builder-app");

			if (onboardingElem === null || typeof onboardingElem === 'undefined') {
				return;
			}

			if (self.viewsActive.onboardingCustomizerPopup && self.iscustomizerScreen && self.customizerFeedData) {
				if (document.getElementById("sb-onboarding-tooltip-customizer-1") !== null) {
					wrapElem.classList.add('sb-onboarding-active');

					var step1El = document.querySelectorAll(".ctf-csz-header")[0];
					step1El.appendChild(document.getElementById("sb-onboarding-tooltip-customizer-1"));

					var step2El = document.querySelectorAll(".sb-customizer-sidebar-sec1")[0];
					step2El.appendChild(document.getElementById("sb-onboarding-tooltip-customizer-2"));

					var step3El = document.querySelectorAll(".sb-customizer-sidebar-sec1")[0];
					step3El.appendChild(document.getElementById("sb-onboarding-tooltip-customizer-3"));

					self.onboardingHideShow();
				}
			} else if (self.viewsActive.onboardingPopup && !self.iscustomizerScreen) {
				if (ctf_builder.allFeedsScreen.onboarding.type === 'single') {
					if (document.getElementById("sb-onboarding-tooltip-single-1") !== null) {
						wrapElem.classList.add('sb-onboarding-active');

						var step1El = document.querySelectorAll(".ctf-fb-wlcm-header .sb-positioning-wrap")[0];
						step1El.appendChild(document.getElementById("sb-onboarding-tooltip-single-1"));

						var step2El = document.querySelectorAll(".ctf-table-wrap")[0];
						step2El.appendChild(document.getElementById("sb-onboarding-tooltip-single-2"));
						self.onboardingHideShow();
					}
				} else {
					if (document.getElementById("sb-onboarding-tooltip-multiple-1") !== null) {
						wrapElem.classList.add('sb-onboarding-active');

						var step1El = document.querySelectorAll(".ctf-fb-wlcm-header .sb-positioning-wrap")[0];
						step1El.appendChild(document.getElementById("sb-onboarding-tooltip-multiple-1"));

						var step2El = document.querySelectorAll(".ctf-fb-lgc-ctn")[0];
						step2El.appendChild(document.getElementById("sb-onboarding-tooltip-multiple-2"));

						var step3El = document.querySelectorAll(".ctf-legacy-table-wrap")[0];
						step3El.appendChild(document.getElementById("sb-onboarding-tooltip-multiple-3"));

						self.activateView('legacyFeedsShown');
						self.onboardingHideShow();
					}
				}

			}
		},
		//Back Click in the Creation Process
		creationProcessBack : function(){
			var self = this;
			switch (self.viewsActive.selectedFeedSection) {
				case 'feedsType':
					self.switchScreen('pageScreen', 'welcome');
					break;
				case 'selectSource':
					self.switchScreen('selectedFeedSection', 'feedsType');
					break;
				case 'feedsTypeGetProcess':
					self.switchScreen('selectedFeedSection', 'selectSource');
					break;
			}
			ctfBuilder.$forceUpdate();
		},

		//Return Feed Type
		getFeedTypeSaver : function(){
			var self = this;
			if(self.selectedFeed.length > 1){
				return 'mixed';
			}
			return self.selectedFeed[0];
		},


		//Create & Submit New Feed
		submitNewFeed : function(){
			var self = this,
			newFeedData = {
				action : 'ctf_feed_saver_manager_builder_update',
				selectedFeed : self.selectedFeed,
				selectedFeedModel : self.selectedFeedModel,
				feedtemplate : self.selectedFeedTemplate,
				new_insert : 'true',
			};
			self.fullScreenLoader = true;
			self.ajaxPost(newFeedData, function(_ref){
				var data = _ref.data;
				if(data.feed_id && data.success){
					window.location = self.builderUrl + '&feed_id=' + data.feed_id;
				}
			});
		},


		//Open Add Source List Popup
		openSourceListPopup : function( feedTypeID ){
			var self = this;
			self.feedTypeOnSourcePopup = feedTypeID;
			if( self.feedTypeOnSourcePopup == 'tagged' ){
				self.selectedSourcesPopup = self.createSourcesArray(self.selectedSourcesTagged);
			}else if( self.feedTypeOnSourcePopup == 'user' ){
				self.selectedSourcesPopup = self.createSourcesArray(self.selectedSourcesUser);
			}
			self.activateView('sourcesListPopup');
			if( self.customizerFeedData ){
				self.activateView('feedtypesCustomizerPopup');
			}
		},

		//Check if source is Disabled POPUP
		checkSourceDisabledPopup : function(source){
			var self = this;
			return (source.account_type == 'personal' && self.feedTypeOnSourcePopup == 'tagged');
		},

		//Source Active POPUP
		isSourceSelectActivePopup : function(source){
			var self = this;
			if(self.selectedSourcesPopup.includes(source.account_id)){
				return (source.account_type != 'personal' && self.feedTypeOnSourcePopup == 'tagged') || self.feedTypeOnSourcePopup == 'user';
			}
			return false;
		},

		//Select Sources POPUP
		selectSourcePopup : function( source ){
			var self = this;
			if( (source.account_type != 'personal' && self.feedTypeOnSourcePopup == 'tagged') || self.feedTypeOnSourcePopup == 'user' ){
				if(self.selectedSourcesPopup.includes(source.account_id)){
					self.selectedSourcesPopup.splice(self.selectedSourcesPopup.indexOf(source.account_id), 1);
				}else{
					self.selectedSourcesPopup.push(source.account_id);
				}
			}
		},

		//Return Choosed Feed Type
		returnSelectedSourcesByType : function( feedType ){
			var self = this,
			sourcesListByType = [];
			if( feedType == 'user' ){
				sourcesListByType = self.sourcesList.filter(function(source){
					return ( self.customizerFeedData ) ? self.selectedSourcesUserPopup.includes(source.account_id) : self.selectedSourcesUser.includes(source.account_id);
				});
			}else if( feedType == 'tagged' ){
				sourcesListByType = self.sourcesList.filter(function(source){
					return ( self.customizerFeedData ) ? self.selectedSourcesTaggedPopup.includes(source.account_id) : self.selectedSourcesTagged.includes(source.account_id);
				});
			}
			return sourcesListByType;
		},



		/*
			Return Selected Sources / Hashtags
			on The Customizer Control
		*/
		returnSelectedSourcesByTypeCustomizer : function( feedType ){
			var self = this;
			return feedType == 'lists' ? self.selectedFeedModel.listsObject : self.selectedFeedModel[feedType].split(',');
		},


		//Check if source are Array
		createSourcesArray : function( element ){
			if(Array.isArray(element) && element.length == 1 && !this.checkNotEmpty(element[0]) ){
				return [];
			}
			return Array.isArray(element) ? Array.from(element) : Array.from( element.split(',') );
		},

		// Add Source to Feed Type
		addSourceToFeedType : function(){
			var self = this;
			if( self.feedTypeOnSourcePopup == 'tagged' ){
				if(!self.customizerFeedData){
					self.selectedSourcesTagged = self.createSourcesArray(self.selectedSourcesPopup);
					self.selectedSourcesTaggedPopup = self.createSourcesArray(self.selectedSourcesTagged);
				}else{
					self.selectedSourcesTaggedPopup = self.createSourcesArray(self.selectedSourcesPopup);
				}
			}else if( self.feedTypeOnSourcePopup == 'user' ){
				if(!self.customizerFeedData){
					self.selectedSourcesUser = self.createSourcesArray(self.selectedSourcesPopup);
					self.selectedSourcesUserPopup = self.createSourcesArray(self.selectedSourcesUser);
				}else{
					self.selectedSourcesUserPopup = self.createSourcesArray(self.selectedSourcesPopup);
				}
			}
			self.activateView('sourcesListPopup');
			if( self.customizerFeedData ){
				self.activateView('feedtypesCustomizerPopup');
			}
		},

		//Detect Hashtag Writing
		hashtagWriteDetectPopup : function(isProcess = false){
			var self = this,
				target = window.event;
			if(target.keyCode == 188 || isProcess == true){
				self.hashtagInputText = self.hashtagInputText.replace(',','');
				if(self.checkNotEmpty(self.hashtagInputText)){
					if(self.hashtagInputText[0] !== '#'){
						self.hashtagInputText = '#' + self.hashtagInputText;
					}
					self.selectedHastagsPopup = self.createSourcesArray(self.selectedHastagsPopup);
					self.selectedHastagsPopup.push(self.hashtagInputText);
				}
				self.hashtagInputText = '';
			}
		},

		//Detect Hashtag Writing
		hashtagWriteDetect : function(isProcess = false){
			var self = this,
				target = window.event;
			if(target.keyCode == 188 || isProcess == true){
				self.hashtagInputText = self.hashtagInputText.replace(',','');
				if(self.checkNotEmpty(self.hashtagInputText)){
					if(self.hashtagInputText[0] !== '#'){
						self.hashtagInputText = '#' + self.hashtagInputText;
					}
					self.selectedHastags = self.createSourcesArray(self.selectedHastags);
					self.selectedHastags.push(self.hashtagInputText);
					self.selectedHastagsPopup = self.createSourcesArray(self.selectedHastags);
				}
				self.hashtagInputText = '';
			}
		},

		//Remove Hashtag from List
		removeHashtag : function(hashtag){
			var self = this;
			if( self.customizerFeedData ){
				self.selectedHastagsPopup.splice(self.selectedHastagsPopup.indexOf(hashtag), 1);
			}else{
				self.selectedHastags.splice(self.selectedHastags.indexOf(hashtag), 1);
			}
		},



		processDomList : function(selector, attributes){
			document.querySelectorAll(selector).forEach( function(element) {
				attributes.map( function(attrName) {
					element.setAttribute(attrName[0], attrName[1]);
				});
			});
		},
		openTooltipBig : function(){
			var self = this, elem = window.event.currentTarget;
			self.processDomList('.ctf-fb-onbrd-tltp-elem', [['data-active', 'false']]);
			elem.querySelector('.ctf-fb-onbrd-tltp-elem').setAttribute('data-active', 'true');
			ctfBuilder.$forceUpdate();
		},
		closeTooltipBig : function(){
			var self = this;
			self.processDomList('.ctf-fb-onbrd-tltp-elem', [['data-active', 'false']]);
			window.event.stopPropagation();
			ctfBuilder.$forceUpdate();
		},

		/*
			FEEDS List Actions
		*/

		/**
		 * Switch Bulk Action
		 *
		 * @since 2.0
		 */
		bulkActionClick : function(){
			var self = this;
			switch (self.selectedBulkAction) {
				case 'delete':
					if(self.feedsSelected.length > 0){
						self.openDialogBox('deleteMultipleFeeds')
					}
				break;
			}
			ctfBuilder.$forceUpdate();
		},

		/**
		 * Duplicate Feed
		 *
		 * @since 2.0
		 */
		feedActionDuplicate : function(feed){
			var self = this,
			feedsDuplicateData = {
				action : 'ctf_feed_saver_manager_duplicate_feed',
				feed_id : feed.id
			};
			self.ajaxPost(feedsDuplicateData, function(_ref){
				var data = _ref.data;
				self.feedsList = Object.values(Object.assign({}, data));
				//self.feedsList = data;
			});
			ctfBuilder.$forceUpdate();
		},

		/**
		 * Delete Feed
		 *
		 * @since 2.0
		 */
		feedActionDelete : function(feeds_ids){
			var self = this,
			feedsDeleteData = {
				action : 'ctf_feed_saver_manager_delete_feeds',
				feeds_ids : feeds_ids
			};
			self.ajaxPost(feedsDeleteData, function(_ref){
				var data = _ref.data;
				self.feedsList = Object.values(Object.assign({}, data));
				self.feedsSelected = [];
			});
		},

		/**
		 * View Feed Instances
		 *
		 * @since 2.0
		 */
		viewFeedInstances : function(feed){
			var self = this;
			self.viewsActive.instanceFeedActive = feed;
			self.movePopUp();
			ctfBuilder.$forceUpdate();
		},

		/**
		 * Select All Feeds in List
		 *
		 * @since 2.0
		 */
		selectAllFeedCheckBox : function(){
			var self = this;
			if( !self.checkAllFeedsActive() ){
				self.feedsSelected = [];
				self.feedsList.forEach( function(feed) {
					self.feedsSelected.push(feed.id);
				});
			}else{
				self.feedsSelected = [];
			}

		},

		/**
		 * Select Single Feed in List
		 *
		 * @since 2.0
		 */
		selectFeedCheckBox : function(feedID){
			if(this.feedsSelected.includes(feedID)){
				this.feedsSelected.splice(this.feedsSelected.indexOf(feedID),1);
			}else{
				this.feedsSelected.push(feedID);
			}
			ctfBuilder.$forceUpdate();
		},

		/**
		 * Check if All Feeds are Selected
		 *
		 * @since 2.0
		 */
		checkAllFeedsActive : function(){
			var self = this,
			result = true;
			self.feedsList.forEach( function(feed) {
				if(!self.feedsSelected.includes(feed.id)){
					result = false;
				}
			});

			return result;
		},


		/**
		 * Copy text to clipboard
		 *
		 * @since 2.0
		 */
		copyToClipBoard : function(value){
			var self = this;
			const el = document.createElement('textarea');
			el.className = 'ctf-fb-cp-clpboard';
			el.value = value;
			document.body.appendChild(el);
			el.select();
			document.execCommand('copy');
			document.body.removeChild(el);
			self.notificationElement =  {
				type : 'success',
				text : this.genericText.copiedClipboard,
				shown : "shown"
			};
			setTimeout(function(){
				self.notificationElement.shown =  "hidden";
			}, 3000);
			ctfBuilder.$forceUpdate();
		},

		/*-------------------------------------------
			CUSTOMIZER FUNCTIONS
		-------------------------------------------*/
		/**
		 * HighLight Section
		 *
		 * @since 2.0
		 */
		isSectionHighLighted : function(sectionName){
			var self = this;
			return (self.highLightedSection === sectionName ||  self.highLightedSection === 'all')
 		},

 		/**
		 * Enable HightLight Section
		 *
		 * @since 2.0
		 */
 		enableHighLightSection : function(sectionId){
			var self = this,
				listPostSection = ['customize_feedlayout', 'customize_colorscheme', 'customize_posts','post_style','individual_elements'],
				headerSection = ['customize_header'],
				likeBoxSection = ['customize_likebox'],
				loadeMoreSection = ['customize_loadmorebutton'],
				lightBoxSection = ['customize_lightbox'],
				domBody = document.getElementsByTagName("body")[0];

			self.dummyLightBoxScreen = false;
			domBody.classList.remove("no-overflow");

			if( listPostSection.includes(sectionId) ){
				self.highLightedSection = 'postList';
				self.scrollToHighLightedSection("ctf-tweet-items");
			}else if( headerSection.includes(sectionId) ){
				self.highLightedSection = 'header';
				self.scrollToHighLightedSection("ctf-header");
			}else if( loadeMoreSection.includes(sectionId) ){
				self.highLightedSection = 'loadMore';
				self.scrollToHighLightedSection("ctf-more");
			}else if( lightBoxSection.includes(sectionId) ){
				self.highLightedSection = 'lightBox';
				self.dummyLightBoxScreen = true;
				document.body.scrollTop = 0;
				document.documentElement.scrollTop = 0;
				domBody.classList.add("no-overflow");
			}else{
				self.highLightedSection = 'all';
				self.dummyLightBoxScreen = false;
				domBody.classList.remove("no-overflow");
			}
 		},


 		/**
		 * Scroll to Highlighted Section
		 *
		 * @since 2.0
		 */
 		scrollToHighLightedSection : function(sectionId){
			const element = document.getElementById(sectionId) !== undefined && document.getElementById(sectionId) !== null ?
							document.getElementById(sectionId) :
							( document.getElementsByClassName(sectionId)[0] !== undefined && document.getElementsByClassName(sectionId)[0] !== null ? document.getElementsByClassName(sectionId)[0] : null );


			if(element != undefined && element != null){
				const y = element.getBoundingClientRect().top - 120 + window.pageYOffset - 10;
				window.scrollTo({top: y, behavior: 'smooth'});
			}
 		},

 		/**
		 * Enable & Show Color Picker
		 *
		 * @since 2.0
		 */
 		showColorPickerPospup : function(controlId){
			this.customizerScreens.activeColorPicker = controlId;
 		},

 		/**
		 * Hide Color Picker
		 *
		 * @since 2.0
		 */
 		hideColorPickerPospup : function(){
			this.customizerScreens.activeColorPicker = null;
 		},

		switchCustomizerPreviewDevice : function(previewScreen){
			var self = this;
			self.customizerScreens.previewScreen = previewScreen;
			self.loadingBar = true;
			setTimeout(function(){
				self.setShortcodeGlobalSettings(true);
				self.loadingBar = false;
			},200)
			ctfBuilder.$forceUpdate();
		},
		switchCustomizerTab : function(tabId){
			var self = this,
				domBody = document.getElementsByTagName("body")[0];
			self.customizerScreens.activeTab = tabId;
			self.customizerScreens.activeSection = null;
			self.customizerScreens.activeSectionData = null;
			self.highLightedSection = 'all';
			self.dummyLightBoxScreen = false;
			domBody.classList.remove("no-overflow");
			ctfBuilder.$forceUpdate();
		},
		switchCustomizerSection : function(sectionId, section, isNested = false, isBackElements){
			var self = this;
			self.customizerScreens.parentActiveSection = null;
			self.customizerScreens.parentActiveSectionData = null;
			if(isNested){
				self.customizerScreens.parentActiveSection = self.customizerScreens.activeSection;
				self.customizerScreens.parentActiveSectionData = self.customizerScreens.activeSectionData;
			}
			self.customizerScreens.activeSection = sectionId;
			self.customizerScreens.activeSectionData = section;
			if(!isBackElements){
				self.enableHighLightSection(sectionId);
			}
			ctfBuilder.$forceUpdate();
		},
		switchNestedSection : function(sectionId, section){
			var self = this;
			if(section !== null){
				self.customizerScreens.activeSection = sectionId;
				self.customizerScreens.activeSectionData = section;
			}else{
				var sectionArray = sectionId['sections'];
				var elementSectionData = self.customizerSidebarBuilder;

				sectionArray.map(function(elm, index){
					elementSectionData = (elementSectionData[elm] != undefined && elementSectionData[elm] != null) ? elementSectionData[elm] : null;
				});
				if(elementSectionData != null){
					self.customizerScreens.activeSection = sectionId['id'];
					self.customizerScreens.activeSectionData = elementSectionData;
				}
			}
			ctfBuilder.$forceUpdate();
		},
		backToPostElements : function(){
			var self = this,
				individual_elements = self.customizerSidebarBuilder['customize'].sections.customize_posts.nested_sections.individual_elements;
				self.customizerScreens.activeSection = 'customize_posts';
				self.customizerScreens.activeSectionData= self.customizerSidebarBuilder['customize'].sections.customize_posts;
				self.switchCustomizerSection('individual_elements', individual_elements, true, true);
				ctfBuilder.$forceUpdate();

		},

		changeSettingValue : function(settingID, value, doProcess = true, ajaxAction = false) {
			var self = this;
			if(doProcess){
				self.customizerFeedData.settings[settingID] = value;
			}
			if(ajaxAction !== false){
				self.customizerControlAjaxAction(ajaxAction, settingID);
			}
			if(settingID === 'num' && !self.checkNotEmpty(self.customizerFeedData.settings[settingID])){
				self.customizerFeedData.settings[settingID] = 1;
			}
			self.regenerateLayout(settingID);

		},

		//Shortcode Global Layout Settings
		regenerateLayout : function(settingID) {
			var self = this,
				regenerateFeedHTML = 	[
					'layout'
				],
				relayoutFeed = [
					'layout',
					'masonrycols',
					'masonrytabletcols',
					'masonrymobilecols',
				];
			if( relayoutFeed.includes( settingID ) ){
				setTimeout(function(){
					self.setShortcodeGlobalSettings(true);
				}, 10)
			}

		},


		//Get Customizer Additional CSS Classes
		getAdditionalCustomizerClasses : function(){
			var self = this,
				additionalCssClasses = '';
			return additionalCssClasses;
		},

		//Shortcode Global Layout Settings
		setShortcodeGlobalSettings : function(flyPreview = false){
			var self = this,
				customizerSettings = self.customizerFeedData.settings;
				if( flyPreview === true ){
					window.ctf_init()
				}
				jQuery('body').find('.ctf-tweet-media').click(function(event){
					if( !self.valueIsEnabled( self.customizerFeedData.settings.disablelightbox ) ){
						self.dummyLightBoxScreen = true;
						event.preventDefault();
					}
				})
				jQuery('body').find('.ctf-more').unbind('click')
		},

		detroyCarousel : function(){
			var self = this,
				customizerSettings = self.customizerFeedData.settings;
		},


		//Get feed Containes Classes
		getFeedClasses : function(){
			var self = this,
				customizerSettings = self.customizerFeedData.settings,
				feedClasses = 'ctf';
			feedClasses += ' ctf-type-' + customizerSettings.type;
			feedClasses += ' ctf-' + customizerSettings.layout;
			feedClasses += ' ctf-styles ' + customizerSettings.class;
			feedClasses += ' ctf-feed-' + self.customizerFeedData.feed_info.id;
			feedClasses += (customizerSettings.tweetpoststyle != undefined) ? ' ctf-' + customizerSettings.tweetpoststyle + '-style' : '';
			feedClasses +=  self.checkNotEmpty( customizerSettings.height ) && customizerSettings.height != 0 ? ' ctf-fixed-height' : '';
			feedClasses +=  self.valueIsEnabled( customizerSettings.autoscroll ) ? ' ctf-autoscroll' : '';
			feedClasses +=  self.valueIsEnabled( customizerSettings.persistentcache ) ? ' ctf-persistent' : '';
			feedClasses +=  customizerSettings.font_method === 'fontfile' ? ' ctf-fontfile' : '';
			if(customizerSettings.layout === 'masonry'){
				feedClasses +=  ' masonry-' + customizerSettings.masonrycols + '-desktop';
				feedClasses +=  ' masonry-' + customizerSettings.masonrytabletcols + '-tablet';
				feedClasses +=  ' masonry-' + customizerSettings.masonrymobilecols + '-mobile';
			}
			feedClasses +=  self.getPaletteClass();

			return feedClasses;
		},

		/**
		 * Get Feed Preview Global CSS Class
		 *
		 * @since 2.0
		 * @return String
		 */
		getPaletteClass : function(context = ''){
			var self = this,
				colorPalette = self.customizerFeedData.settings.colorpalette;

			if(self.checkNotEmpty( colorPalette )){
				var feedID = colorPalette === 'custom'  ? ('_' + self.customizerFeedData.feed_info.id)  : '';
				return colorPalette !== 'inherit' ? ' ctf' + context + '_palette_' + colorPalette + feedID : '';
			}
			return '';
		},
		//Get Number of Columns depending on the Preview Screen
		getColsPreviewScreen : function(){
			var self = this,
				customizerSettings = self.customizerFeedData.settings;

			if(customizerSettings.layout === 'masonry' || customizerSettings.layout === 'carousel'){
				switch (self.customizerScreens.previewScreen) {
					case 'mobile':
							return customizerSettings.layout === 'masonry' ? customizerSettings.masonrymobilecols : customizerSettings.carouselmobilecols;
						break;
					case 'tablet':
							return customizerSettings.layout === 'masonry' ? customizerSettings.masonrytabletcols : customizerSettings.carouseltabletcols;
						break;
					default:
							return customizerSettings.layout === 'masonry' ? customizerSettings.masonrycols : customizerSettings.carouselcols;
						break;
				}
			}
			return false;
		},

		//Tablet Cols Classes
		getTabletColsClass : function(){
			var self = this,
				customizerSettings = self.customizerFeedData.settings;

			return ' ctf_tab_col_' + parseInt( customizerSettings.colstablet );
		},

		//Mobile Cols Classes
		getMobileColsClass : function(){
			var self = this,
				customizerSettings = self.customizerFeedData.settings,
				disableMobile = self.valueIsEnabled( customizerSettings.disablemobile );

			if(disableMobile === 'false') disableMobile = '';

			if ( disableMobile !== ' ctf_disable_mobile' && customizerSettings.colsmobile !== 'same' ) {
				var colsmobile = parseInt( customizerSettings.colsmobile ) > 0 ? parseInt( customizerSettings.colsmobile ) : 'auto';
				return ' ctf_mob_col_' + colsmobile;
			}else{
				var colsmobile = parseInt( customizerSettings.cols ) > 0 ? parseInt( customizerSettings.cols ) : 4;
				return ' ctf_disable_mobile ctf_mob_col_' + parseInt( customizerSettings.cols );

			}
		},

		//Header Classes
		getHeaderClass : function( headerType ){
			var self = this,
				customizerSettings = self.customizerFeedData.settings,
				headerClasses = 'sb_instagram_header ';

			headerClasses += 'ctf_feed_type_'+ customizerSettings['type'];
			headerClasses += customizerSettings['headerstyle'] === 'centered' && headerType === 'normal' ? ' ctf_centered' : '';
			headerClasses += ['medium', 'large'].includes(customizerSettings['headersize']) ? ' ctf_' + customizerSettings['headersize'] : '';
			headerClasses += headerType === 'boxed' ? ' ctf_header_style_boxed' : '';
			headerClasses += self.getHeaderAvatar() === false ? ' ctf_no_avatar' : '';
			headerClasses += self.getPaletteClass('_header');
			return headerClasses;
		},

		//Header Name
		getHeaderName : function(){
			var self = this,
				headerData 			= self.customizerFeedData.headerData;
			if( self.hasOwnNestedProperty(headerData, 'name') && self.checkNotEmpty( headerData['name'] ) ){
				return headerData['name'];
			}else if( self.hasOwnNestedProperty(headerData, 'data.full_name')  ){
				return headerData['data']['full_name'];
			}
			return self.getHeaderUserName();
		},

		//Header User Name
		getHeaderUserName : function(){
			var self = this,
				headerData 			= self.customizerFeedData.headerData;
			if( self.hasOwnNestedProperty(headerData, 'username') && self.checkNotEmpty( headerData['username'] ) ){
				return headerData['username'];
			}else if( self.hasOwnNestedProperty(headerData, 'user.username')  ){
				return headerData['user']['username'];
			}else if( self.hasOwnNestedProperty(headerData, 'data.username')  ){
				return headerData['data']['username'];
			}
			return '';
		},

		//Header Media Count
		getHeaderMediaCount : function(){
			var self = this,
				headerData 			= self.customizerFeedData.headerData;
			if( self.hasOwnNestedProperty(headerData, 'data.counts.media')  ){
				return headerData['data']['counts']['media'];
			}else if( self.hasOwnNestedProperty(headerData, 'counts.media')  ){
				return headerData['counts']['media'];
			}else if( self.hasOwnNestedProperty(headerData, 'media_count')  ){
				return headerData['media_count'];
			}
			return '';
		},

		//Header Followers Count
		getHeaderFollowersCount : function(){
			var self = this,
				headerData 			= self.customizerFeedData.headerData;
			if( self.hasOwnNestedProperty(headerData, 'data.counts.followed_by')  ){
				return headerData['data']['counts']['followed_by'];
			}else if( self.hasOwnNestedProperty(headerData, 'counts.followed_by')  ){
				return headerData['counts']['followed_by'];
			}else if( self.hasOwnNestedProperty(headerData, 'followers_count')  ){
				return headerData['followers_count'];
			}
			return '';
		},

		//Header Avatar
		getHeaderAvatar : function(){
			var self = this,
				customizerSettings 	= self.customizerFeedData.settings,
				headerData 			= self.customizerFeedData.headerData,
				header 				= self.customizerFeedData.header;
			if( self.checkNotEmpty( customizerSettings['customavatar'] ) ){
				return customizerSettings['customavatar'];
			}else if( headerData['local_avatar'] != false && self.checkNotEmpty( headerData['local_avatar'] ) ){
				return headerData['local_avatar'];
			}else if( header['local_avatar_url'] != false && self.checkNotEmpty( header['local_avatar_url'] ) ){
				return header['local_avatar_url'];
			}else{
				if( self.hasOwnNestedProperty(headerData, 'profile_picture') ){
					return headerData['profile_picture'];
				}else if( self.hasOwnNestedProperty(headerData, 'profile_picture_url') ){
					return headerData['profile_picture_url'];
				}else if( self.hasOwnNestedProperty(headerData, 'user.profile_picture') ){
					return headerData['user']['profile_picture'];
				}else if( self.hasOwnNestedProperty(headerData, 'data.profile_picture') ){
					return headerData['data']['profile_picture'];
				}
			}
			return false;
		},

		//Header Bio
		getHeaderBio : function(){
			var self = this,
				customizerSettings 	= self.customizerFeedData.settings,
				headerData 			= self.customizerFeedData.headerData;

			if( self.checkNotEmpty( customizerSettings['custombio'] ) ){
				return customizerSettings['custombio'];
			}else if(  self.hasOwnNestedProperty(headerData, 'data.bio')  ){
					return headerData['data']['bio'];
			}else if(  self.hasOwnNestedProperty(headerData, 'bio')  ){
					return headerData['bio'];
			}else if(  self.hasOwnNestedProperty(headerData, 'biography')  ){
					return headerData['biography'];
			}
			return '';
		},


		//Header Text Class
		getTextHeaderClass : function(){
			var self = this,
				customizerSettings 	= self.customizerFeedData.settings,
				headerData 			= self.customizerFeedData.headerData,
				headerClass 		= 'ctf_header_text ',
				shouldShowBio 		= self.checkNotEmpty( self.getHeaderBio() ) ? self.valueIsEnabled( customizerSettings['showbio'] ) : false,
				shouldShowInfo 		= shouldShowBio || self.valueIsEnabled( customizerSettings['showfollowers'] );
				headerClass 		+= !shouldShowBio ? 'ctf_no_bio ' : '',
				headerClass 		+= !shouldShowInfo ? 'ctf_no_info' : '';

			return headerClass;
		},

		//Get Story Delays
		getStoryDelays : function(){
			var self = this,
				customizerSettings 	= self.customizerFeedData.settings;
			return self.checkNotEmpty( customizerSettings['storiestime'] ) ? Math.max( 500, parseInt( customizerSettings['storiestime']) ) : 5000;
		},

		//Get Story Data
		getStoryData : function(){
			var self = this,
				customizerSettings 	= self.customizerFeedData.settings,
				headerData 			= self.customizerFeedData.headerData;
			if( self.hasOwnNestedProperty(headerData, 'stories') && headerData.stories.length > 0 && self.valueIsEnabled( customizerSettings['stories'] ) ){
				return headerData['stories'];
			}
			return false;
		},


		//Image Chooser
		imageChooser : function( settingID ){
			var self = this;
            var uploader = wp.media({
            	frame : 'post',
            	title : 'Media Uploader',
            	button:{text : 'Choose Media'},
            	library: {type: 'image'},
            	multiple: false
            	}).on('close',function() {
                	var selection = uploader.state().get('selection');
                	if(selection.length != 0){
	                    attachment = selection.first().toJSON();
	                    self.customizerFeedData.settings[settingID] = attachment.url;
	                }
            }).open();
		},

		//Change Switcher Settings
		changeSwitcherSettingValue : function(settingID, onValue, offValue, ajaxAction = false) {
			var self = this;
			self.customizerFeedData.settings[settingID] = self.customizerFeedData.settings[settingID] == onValue ? offValue : onValue;
			if(ajaxAction !== false){
				self.customizerControlAjaxAction(ajaxAction);
			}
			self.regenerateLayout(settingID);
		},

		//Checkbox List
		changeCheckboxListValue : function(settingID, value, ajaxAction = false){
			var self = this,
			 	settingValue = self.customizerFeedData.settings[settingID].split(',');
			if(!Array.isArray(settingValue)){
				settingValue = [settingValue];
			}
			if(settingValue.includes(value)){
				settingValue.splice(settingValue.indexOf(value),1);
			}else{
				settingValue.push(value);
			}
			self.customizerFeedData.settings[settingID] = settingValue.join(',');
		},


		//Section Checkbox
		changeCheckboxSectionValue : function(settingID, value, ajaxAction = false, checkBoxAction = false){
			var self = this;
			if(checkBoxAction !== false){
				self.customizerFeedData.settings[settingID] = self.customizerFeedData.settings[settingID] == checkBoxAction.options.enabled ? checkBoxAction.options.disabled : checkBoxAction.options.enabled;
			}else{
				var settingValue = self.customizerFeedData.settings[settingID];
				if(!Array.isArray(settingValue) && settingID == 'type'){
					settingValue = [settingValue];
				}
				if(settingValue.includes(value)){
					settingValue.splice(settingValue.indexOf(value),1);
				}else{
					settingValue.push(value);
				}
				if(settingID == 'type'){
					self.processFeedTypesSources( settingValue );
				}
				//settingValue = (settingValue.length == 1 && settingID == 'type') ? settingValue[0] : settingValue;
				self.customizerFeedData.settings[settingID] = settingValue;
			}

			if(ajaxAction !== false){
				self.customizerControlAjaxAction(ajaxAction);
			}
			event.stopPropagation()

		},
		checkboxSectionValueExists : function(settingID, value){
			var self = this;
			var settingValue = self.customizerFeedData.settings[settingID];
			return settingValue.includes(value) ? true : false;
		},

		/**
		 * Check Control Condition
		 *
		 * @since 2.0
		*/
		checkControlCondition : function(conditionsArray = [], checkExtensionActive = false, checkExtensionActiveDimmed = false){
			var self = this,
			isConditionTrue = 0;
			Object.keys(conditionsArray).map(function(condition, index){
				if(conditionsArray[condition].indexOf(self.customizerFeedData.settings[condition]) !== -1)
					isConditionTrue += 1
			});
			var extensionCondition = checkExtensionActive != undefined && checkExtensionActive != false ? self.checkExtensionActive(checkExtensionActive) : true,
				extensionCondition = checkExtensionActiveDimmed != undefined && checkExtensionActiveDimmed != false && !self.checkExtensionActive(checkExtensionActiveDimmed) ? false : extensionCondition;

			return (isConditionTrue == Object.keys(conditionsArray).length) ? ( extensionCondition ) : false;
		},

		/**
		 * Check Color Override Condition
		 *
		 * @since 2.0
		*/
		checkControlOverrideColor : function(overrideConditionsArray = []){
			var self = this,
			isConditionTrue = 0;
			overrideConditionsArray.map(function(condition, index){
				if(self.checkNotEmpty(self.customizerFeedData.settings[condition]) && self.customizerFeedData.settings[condition].replace(/ /gi,'') != '#'){
					isConditionTrue += 1
				}
			});
			return (isConditionTrue >= 1) ? true : false;
		},

		/**
		 * Show Control
		 *
		 * @since 2.0
		*/
		isControlShown : function( control ){
			var self = this;
			if( control.checkViewDisabled != undefined ){
				return !self.viewsActive[control.checkViewDisabled];
			}
			if( control.checkView != undefined ){
				return !self.viewsActive[control.checkView];
			}

			if(control.checkExtension != undefined && control.checkExtension != false && !self.checkExtensionActive(control.checkExtension)){
				return self.checkExtensionActive(control.checkExtension);
			}

			if(control.conditionDimmed != undefined && self.checkControlCondition(control.conditionDimmed) )
				return self.checkControlCondition(control.conditionDimmed);
			if(control.overrideColorCondition != undefined){
				return self.checkControlOverrideColor( control.overrideColorCondition );
			}

			return ( control.conditionHide != undefined && control.condition != undefined || control.checkExtension != undefined )
				? self.checkControlCondition(control.condition, control.checkExtension)
				: true;
		},

		checkExtensionActive : function(extension){
			var self = this;
			return self.activeExtensions[extension];
		},

		expandSourceInfo : function(sourceId){
			var self = this;
			self.customizerScreens.sourceExpanded = (self.customizerScreens.sourceExpanded === sourceId) ? null : sourceId;
			window.event.stopPropagation()
		},

		resetColor: function(controlId){
			this.customizerFeedData.settings[controlId] = '';
		},

		//Source Active Customizer
		isSourceActiveCustomizer : function(source){
			var self = this;
			return (
						Array.isArray(self.customizerFeedData.settings.sources.map) ||
						self.customizerFeedData.settings.sources instanceof Object
					) &&
				self.customizerScreens.sourcesChoosed.map(s => s.account_id).includes(source.account_id);
				//self.customizerFeedData.settings.sources.map(s => s.account_id).includes(source.account_id);
		},
		//Choose Source From Customizer
		selectSourceCustomizer : function(source, isRemove = false){
			var self = this,
			isMultifeed = (self.activeExtensions['multifeed'] !== undefined  && self.activeExtensions['multifeed'] == true),
			sourcesListMap = Array.isArray(self.customizerFeedData.settings.sources) || self.customizerFeedData.settings.sources instanceof Object ? self.customizerFeedData.settings.sources.map(s => s.account_id) : [];
			if(isMultifeed){
				if(self.customizerScreens.sourcesChoosed.map(s => s.account_id).includes(source.account_id)){
					var indexToRemove = self.customizerScreens.sourcesChoosed.findIndex(src => src.account_id === source.account_id);
					self.customizerScreens.sourcesChoosed.splice(indexToRemove, 1);
					if(isRemove){
						self.customizerFeedData.settings.sources.splice(indexToRemove, 1);
					}
				}else{
					self.customizerScreens.sourcesChoosed.push(source);
				}
			}else{
				self.customizerScreens.sourcesChoosed = (sourcesListMap.includes(source)) ? [] : [source];
			}
			ctfBuilder.$forceUpdate();
		},
		closeSourceCustomizer : function(){
			var self = this;
			self.viewsActive['sourcePopup'] = false;
			//self.customizerFeedData.settings.sources = self.customizerScreens.sourcesChoosed;
			ctfBuilder.$forceUpdate();
		},
		customizerFeedTypePrint : function(){
			var self = this,
			combinedTypes = self.feedTypes.concat(self.advancedFeedTypes);
			result = combinedTypes.filter(function(tp){
				return tp.type === self.customizerFeedData.settings.feedtype
			});
			self.customizerScreens.printedType = result.length > 0 ? result[0] : [];
			return result.length > 0 ? true : false;
		},
		choosedFeedTypeCustomizer : function(feedType){
			var self = this, result = false;
			if(
				(self.viewsActive.feedTypeElement === null && self.customizerFeedData.settings.feedtype === feedType) ||
				(self.viewsActive.feedTypeElement !== null && self.viewsActive.feedTypeElement == feedType)
			){
				result = true;
			}
			return result;
		},
		choosedFeedTemplateCustomizer : function(feedtemplate){
			var self = this, result = false;
			if(
				(self.viewsActive.feedTemplateElement === null && self.customizerFeedData.settings.feedtemplate === feedtemplate) ||
				(self.viewsActive.feedTemplateElement !== null && self.viewsActive.feedTemplateElement == feedtemplate)
			){
				result = true;
			}
			return result;
		},
		updateFeedTypeCustomizer : function(){
			var self = this;
			if (self.viewsActive.feedTypeElement === 'socialwall') {
				window.location.href = ctf_builder.pluginsInfo.social_wall.settingsPage;
				return;
			}
			self.setType( self.viewsActive.feedTypeElement );

			self.customizerFeedData.settings.feedtype = self.viewsActive.feedTypeElement;
			self.viewsActive.feedTypeElement = null;
			self.viewsActive.feedtypesPopup = false;
			self.customizerControlAjaxAction('feedFlyPreview');
			ctfBuilder.$forceUpdate();
		},
		updateInputWidth : function(){
			this.customizerScreens.inputNameWidth = ((document.getElementById("ctf-csz-hd-input").value.length + 6) * 8) + 'px';
		},

		updateFeedTemplateCustomizer : function(){
			var self = this;
			self.customizerFeedData.settings.feedtemplate = self.viewsActive.feedTemplateElement != null ? self.viewsActive.feedTemplateElement : self.customizerFeedData.settings.feedtemplate;
			self.viewsActive.feedTemplateElement = null;
			self.viewsActive.feedtemplatesPopup = false;
			self.customizerControlAjaxAction('feedTemplateFlyPreview');
			ctfBuilder.$forceUpdate();
		},

		customizerFeedTemplatePrint : function(){
			var self = this;
			result = self.feedTemplates.filter(function(tp){
				return tp.type === self.customizerFeedData.settings.feedtemplate
			});
			self.customizerScreens.printedTemplate = result.length > 0 ? result[0] : [];
			return result.length > 0 ? true : false;
		},


		feedPreviewMaker : function(){
			var self = this;
			return self.template;
			//return self.template == null ? null : "<div>" + self.template + "</div>";
		},

		customizerStyleMaker : function(){
			var self = this;
			if(self.customizerSidebarBuilder){
				self.feedStyle = '';
				 Object.values(self.customizerSidebarBuilder).map( function(tab) {
				 	self.customizerSectionStyle(tab.sections);
				});
				return '<style type="text/css">' + self.feedStyle + '</style>';
			}
			return false;
		},

		customizerSectionStyle : function(sections){
			var self = this;
			Object.values(sections).map(function(section){
				if(section.controls){
					Object.values(section.controls).map(function(control){
						self.returnControlStyle(control);
					});
				}
				if(section.nested_sections){
			 		self.customizerSectionStyle(section.nested_sections);
			 		Object.values(section.nested_sections).map(function(nestedSections){
			 			Object.values(nestedSections.controls).map(function(nestedControl){
				 			if(nestedControl.section){
			 					self.customizerSectionStyle(nestedControl);
				 			}
						});
			 		});
				}
			});
		},
		returnControlStyle : function( control ){
			var self = this;
			if(control.style){
				Object.entries(control.style).map( function(css) {
					var condition = control.condition != undefined || control.checkExtension != undefined ? self.checkControlCondition(control.condition, control.checkExtension) : true;
					if( condition ){
						self.feedStyle +=
							css[0] + '{' +
								css[1].replace("{{value}}", self.customizerFeedData.settings[control.id]) +
							'}';
					}
				});
			}
		},




		/**
		 * Customizer Control Ajax
		 * Some of the customizer controls need to perform Ajax
		 * Calls in order to update the preview
		 *
		 * @since 2.0
		 */
		customizerControlAjaxAction : function( actionType, settingID = false ){
			var self = this;
			switch (actionType) {
				case 'feedFlyPreview':
					self.loadingBar = true;
					self.templateRender = false;
					var previewFeedData = {
						action : 'ctf_feed_saver_manager_fly_preview',
						feedID : self.customizerFeedData.feed_info.id,
						previewSettings : self.customizerFeedData.settings,
						feedName : self.customizerFeedData.feed_info.feed_name,
					};
					self.ajaxPost(previewFeedData, function(_ref){
						var data = _ref.data;
						if( data !== false ){
							self.updatedTimeStamp = new Date().getTime();
							self.template = String("<div>"+data.feed_html+"</div>");
							self.processNotification("previewUpdated");
						}else{
							self.processNotification("unkownError");
						}
						jQuery('body').find('.ctf-more').unbind('click')
					});
				break;
				case 'feedTemplateFlyPreview':
					self.loadingBar = true;
					self.templateRender = false;
					var previewFeedData = {
						action : 'ctf_feed_saver_manager_fly_preview',
						feedID : self.customizerFeedData.feed_info.id,
						previewSettings : self.customizerFeedData.settings,
						feedName : self.customizerFeedData.feed_info.feed_name,
						isFeedTemplatesPopup : true,
					};
					self.ajaxPost(previewFeedData, function(_ref){
						var data = _ref.data;
						if( data !== false ){
							self.customizerFeedData.settings = data.customizerDataSettings;
							self.updatedTimeStamp = new Date().getTime();
							self.template = String("<div>"+data.feed_html+"</div>");
							self.processNotification("previewUpdated");
							setTimeout(function(){
								self.setShortcodeGlobalSettings(true)
							}, 500)
						}else{
							self.processNotification("unkownError");
						}
					});
				break;
				case 'feedPreviewRender':
					setTimeout(function(){
					}, 150);
				break;
			}
		},


		/**
		 * Ajax Action : Save Feed Settings
		 *
		 * @since 2.0
		 */
		saveFeedSettings : function(){
			var self = this,
				sources = [],
				updateFeedData = {
					action : 'ctf_feed_saver_manager_builder_update',
					update_feed	: 'true',
					feed_id : self.customizerFeedData.feed_info.id,
					feed_name : self.customizerFeedData.feed_info.feed_name,
					settings : self.customizerFeedData.settings,
					selectedFeed : self.selectedFeed,
					selectedFeedModel : self.selectedFeedModel,
					type : self.getFeedTypeSaver(),

				};
			self.loadingBar = true;
			self.ajaxPost(updateFeedData, function(_ref){
				var data = _ref.data;
				if(data && data.success === true){
					self.processNotification('feedSaved');
					self.customizerFeedDataInitial = self.customizerFeedData;
				}else{
					self.processNotification('feedSavedError');
				}
			});
			ctfBuilder.$forceUpdate();
		},

		/**
		 * Ajax Action : Clear Single Feed Cache
		 * Update Feed Preview Too
		 * @since 2.0
		 */
		clearSingleFeedCache  : function(){
			var self = this,
				sources = [],
				clearFeedData = {
					action : 'ctf_feed_saver_manager_clear_single_feed_cache',
					feedID : self.customizerFeedData.feed_info.id,
					previewSettings : self.customizerFeedData.settings,
				};
			self.loadingBar = true;
			self.ajaxPost(clearFeedData, function(_ref){
				var data = _ref.data;
				if( data !== false ){

					self.processNotification('cacheCleared');
				}else{
					self.processNotification("unkownError");
				}
			})
			ctfBuilder.$forceUpdate();
		},

		/**
		 * Clear & Reset Color Override
		 *
		 * @since 2.0
		*/
		resetColorOverride : function(settingID){
			this.customizerFeedData.settings[settingID] = '';
		},

		/**
		 * Moderation & Shoppable Mode Pagination
		 *
		 * @since 2.0
		*/
		moderationModePagination : function( type ){
			var self = this;
			if( type == 'next'){
				self.moderationShoppableModeOffset = self.moderationShoppableModeOffset + 1;
			}
			if( type == 'previous'){
				self.moderationShoppableModeOffset = self.moderationShoppableModeOffset > 0 ? ( self.moderationShoppableModeOffset - 1 ) : 0;
			}

			self.customizerControlAjaxAction('feedFlyPreview');
		},


		/**
		 * Remove Source Form List Multifeed
		 *
		 * @since 2.0
		 */
		removeSourceCustomizer : function(type, args = []){
			var self = this;
			Object.assign(self.customizerScreens.sourcesChoosed,self.customizerFeedData.settings.sources);
			self.selectSourceCustomizer(args, true);
			ctfBuilder.$forceUpdate();
			window.event.stopPropagation();
		},

		/**
		 * Custom Flied CLick
		 * Action
		 * @since 2.0
		 */
		fieldCustomClickAction : function( clickAction ){
			var self = this;
			switch (clickAction) {
				case 'clearCommentCache':
					self.clearCommentCache();
				break;
			}
		},

		/**
		 * Clear Comment Cache
		 * Action
		 * @since 2.0
		 */
		 clearCommentCache : function(){
			var self = this;
		 	self.loadingBar = true;
		 	var clearCommentCacheData = {
		 		action : 'ctf_feed_saver_manager_clear_comments_cache',
		 	};
		 	self.ajaxPost(clearCommentCacheData, function(_ref){
		 		var data = _ref.data;
		 		if( data === 'success' ){
		 			self.processNotification("commentCacheCleared");
		 		}else{
		 			self.processNotification("unkownError");
		 		}
		 	});
		 },


		/**
		 * Open Dialog Box
		 *
		 * @since 2.0
		 */
		openDialogBox : function(type, args = []){
			var self = this,
			heading = self.dialogBoxPopupScreen[type].heading,
			description = self.dialogBoxPopupScreen[type].description,
			customButtons = self.dialogBoxPopupScreen[type].customButtons;
			switch (type) {
				case "deleteSourceCustomizer":
					self.sourceToDelete = args;
					heading = heading.replace("#", self.sourceToDelete.username);
				break;
				case "deleteSingleFeed":
					self.feedToDelete = args;
					heading = heading.replace("#", self.feedToDelete.feed_name);
				break;
			}
			self.dialogBox = {
				active : true,
				type : type,
				heading : heading,
				description : description,
				customButtons : customButtons
			};
			window.event.stopPropagation();
		},

		/**
		 * Confirm Dialog Box Actions
		 *
		 * @since 2.0
		 */
		confirmDialogAction : function(){
			var self = this;
			switch (self.dialogBox.type) {
				case 'deleteSourceCustomizer':
					self.selectSourceCustomizer(self.sourceToDelete, true);
					self.customizerControlAjaxAction('feedFlyPreview');
				break;
				case 'deleteSingleFeed':
					self.feedActionDelete([self.feedToDelete.id]);
				break;
				case 'deleteMultipleFeeds':
					self.feedActionDelete(self.feedsSelected);
				break;
				case 'backAllToFeed':
					window.location = self.builderUrl;
				break;
				case 'unsavedFeedSources':
					self.updateFeedTypeAndSourcesCustomizer();
				break;
			}
		},

		/*
		closeConfirmDialog : function(){
			this.sourceToDelete = {};
			this.feedToDelete = {};
			this.dialogBox = {
				active : false,
				type : null,
				heading : null,
				description : null
			};
		},
		*/

		/**
		 * Show Tooltip on Hover
		 *
		 * @since 2.0
		 */
		toggleElementTooltip : function(tooltipText, type, align = 'center'){
			var self = this,
				target = window.event.currentTarget,
				tooltip = (target != undefined && target != null) ? document.querySelector('.sb-control-elem-tltp-content') : null;
			if(tooltip != null && type == 'show'){
				self.tooltip.text = tooltipText;
				var position = target.getBoundingClientRect(),
					left = position.left + 10,
					top = position.top - 10;
				tooltip.style.left = left + 'px';
				tooltip.style.top = top + 'px';
                tooltip.style.textAlign = align;
				self.tooltip.hover = true;
			}
			if(type == 'hide'){
				setTimeout(function(){
					if(self.tooltip.hoverType != 'inside'){
						self.tooltip.hover = false;
					}
				}, 200)
			}
		},

		/**
		 * Hover Tooltip
		 *
		 * @since 2.0
		 */
		hoverTooltip : function(type, hoverType){
			this.tooltip.hover = type;
			this.tooltip.hoverType = hoverType;
		},

		/**
		 * Print Post Text
		 *
		 * @since 2.0
		 */
		getPostText : function(  postText, postID  ){
			var self = this,
				customizerSettings = self.customizerFeedData.settings;
			postText = postText.replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/&lt;br&gt;|&lt;br \/&gt;/g, '<br>');
			if( self.checkNotEmpty(customizerSettings.textlength) ){
				return ( self.expandedCaptions.includes(postID) ? postText : postText.substring( 0, parseInt(customizerSettings.textlength) ) ) +
				( postText.length > parseInt( customizerSettings.textlength ) ? ('<a href="#" class="ctf_more" onclick="ctfBuilderToggleCaption('+postID+')">...</a>') : '');
			}
			var textLength = !self.checkNotEmpty(customizerSettings.textlength) ? 50 : parseInt(customizerSettings.textlength);
			return postText.substring( 0, textLength);
		},

		/**
		 * Loading Bar & Notification
		 *
		 * @since 2.0
		 */
		processNotification : function( notificationType ){
			var self = this,
				notification = self.genericText.notification[ notificationType ];
			self.loadingBar = false;
			self.notificationElement =  {
				type : notification.type,
				text : notification.text,
				shown : "shown"
			};
			setTimeout(function(){
				self.notificationElement.shown =  "hidden";
			}, 5000);
		},

		checkManualEmpty : function(){
            var self = this;
            return self.checkNotEmpty(self.appCredentials.access_token) && self.checkNotEmpty(self.appCredentials.access_token_secret);
		},

		closeConnectAccountPopup : function(){
            var self = this;
			self.appCredentials = {
				app_name 		: '',
				consumer_key 	: '',
				consumer_secret : '',
				access_token 	: '',
				access_token_secret : ''
			};
			self.viewsActive.connectAccountPopup = false;
		},

		/**
		 * Connect Twitter Account Manually
		 *
		 * @since 2.0
		 */
		connectManualAccount : function(){
            var self = this;
			if( self.checkManualEmpty() ){
				self.loadingAjax = true;
				var connectManualAccountData = {
					action : 'ctf_feed_saver_manager_connect_manual_account',
					app_name : self.appCredentials.app_name,
					consumer_key : self.appCredentials.consumer_key,
					consumer_secret : self.appCredentials.consumer_secret,
					access_token : self.appCredentials.access_token,
					access_token_secret : self.appCredentials.access_token_secret
				};
				self.ajaxPost(connectManualAccountData, function(_ref){
					var data = _ref.data;
					 if(data['error'] === undefined){
                        self.accountDetails = data;
                        self.manualAccountResp = 'success';
                        setTimeout(function(){
                            self.viewsActive['connectAccountPopup'] = false;
                            self.manualAccountResp = false;
                        }, 1000)
                    }else{
                        self.manualAccountResp = 'error';
                        setTimeout(function(){
                            self.manualAccountResp = false;
                        }, 3000)
                    }
					self.loadingAjax = false;
				});
			}
		},

		/**
		 * Add List ID to LISTS
		 * This Will Perform and Ajax Call to see if the List Does Exist
		 *
		 * @since 2.0
		 */
		addListIdtoList  : function(){

		},

		/**
		 * Search Lists By UserName
		 *
		 * @since 2.0
		 */
		searchUserNameList  : function(){
			var self = this,
			searchUserNameListsData = {
				action : 'ctf_feed_saver_manager_search_username_lists',
				listUserNameInputModel : self.listUserNameInputModel,
			};
			self.noListFound = null;
			self.listUserNameInputModelSearched = self.listUserNameInputModel;
			self.ajaxPost(searchUserNameListsData, function(_ref){
				var data = _ref.data;
				if(data !== false && data['error'] === undefined){
					self.listUserNameResult = self.createSourcesArray(data);
				}else{
					self.noListFound = true;
				}
			});
		},

		/**
		 * Check Twitter List By ID
		 *
		 * @since 2.0
		 */
		 checkTwitterListById  : function(){
		 	var self = this,
		 	checkListByIdData = {
		 		action : 'ctf_feed_saver_manager_check_twitter_list_by_id',
		 		listIds : self.listIdInputModel,
		 	};
		 	self.ajaxPost(checkListByIdData, function(_ref){
		 		var data = _ref.data;
				if(data !== false && data['error'] === undefined){
					data.forEach( function(listItem) {
		 				self.addItemtoList(listItem);
					});
					self.listIdInputModel = '';
				}
		 	});
		 },


		/**
		 * Add Item to List ID
		 *
		 * @since 2.0
		 */
		addItemtoList  : function( listItem ){
			var self = this,
				listID = listItem.id,
				selectFeedModelCurrent = self.customizerFeedData ? JSON.parse( JSON.stringify( self.selectedFeedModelPopup ) ) : JSON.parse( JSON.stringify( self.selectedFeedModel ) ),
				listIdsArray = self.checkNotEmpty( selectFeedModelCurrent.lists ) ? selectFeedModelCurrent.lists.split(',') : [];

			if( listIdsArray.includes( listID ) ){
				listIdsArray.splice( listIdsArray.indexOf( listID ) , 1 );
			}else{
				listIdsArray.push( listID );
			}
			selectFeedModelCurrent.lists = listIdsArray.join(',');

			if( self.checkObjectArrayElement(selectFeedModelCurrent.listsObject, listItem, 'id')){
				selectFeedModelCurrent.listsObject.splice(selectFeedModelCurrent.listsObject.findIndex(function(el){
				    return el.id === listItem.id;
				}), 1);
			}else{
				selectFeedModelCurrent.listsObject.push( listItem );
			}



			if( self.customizerFeedData ){
				self.selectedFeedModelPopup = JSON.parse(JSON.stringify(selectFeedModelCurrent));
			}else{
				self.selectedFeedModel = JSON.parse(JSON.stringify(selectFeedModelCurrent));
			}

		},

		/**
		 * Remove Single Item From List
		 *
		 * @since 2.0
		 */
		removeSingleItemFromList : function( listItem ){
			var self = this,
				listID = listItem.id,
				selectFeedModelCurrent = self.customizerFeedData ? JSON.parse( JSON.stringify( self.selectedFeedModelPopup ) ) : JSON.parse( JSON.stringify( self.selectedFeedModel ) ),
				listIdsArray = selectFeedModelCurrent.lists.split(',');

			if( listIdsArray.includes( listID ) ){
				listIdsArray.splice( listIdsArray.indexOf( listID ) , 1 );
			}
			selectFeedModelCurrent.lists = listIdsArray.join(',');

			if( self.checkObjectArrayElement(selectFeedModelCurrent.listsObject, listItem, 'id')){
				selectFeedModelCurrent.listsObject.splice(selectFeedModelCurrent.listsObject.findIndex(function(el){
				    return el.id === listItem.id;
				}), 1);
			}

			if( self.customizerFeedData ){
				self.selectedFeedModelPopup = JSON.parse(JSON.stringify(selectFeedModelCurrent));
			}else{
				self.selectedFeedModel = JSON.parse(JSON.stringify(selectFeedModelCurrent));
			}
		},

		/**
		 * Check if Item List is Included
		 *
		 * @since 2.0
		 */
		checkListItemIncluded : function(listItem){
			var self = this,
				listID = listItem.id,
				selectFeedModelCurrent = self.customizerFeedData ? JSON.parse(JSON.stringify(self.selectedFeedModelPopup)) : JSON.parse(JSON.stringify(self.selectedFeedModel)),
				listIdsArray = selectFeedModelCurrent.lists.split(',');

			if( self.checkObjectArrayElement(selectFeedModelCurrent.listsObject, listItem, 'id')){
				return 'true';
			}
			return 'false';
		},

		/**
		 * Deselect & Remove All Lists
		 *
		 * @since 2.0
		 */
		removeAllLists : function(){
			var self = this;
			if( self.customizerFeedData ){
				self.selectedFeedModelPopup.lists = '';
				self.selectedFeedModelPopup.listsObject = [];
			}else{
				self.selectedFeedModel.lists = '';
				self.selectedFeedModel.listsObject = [];
			}
		},

		chooseFeedTemplate: function( feedTemplate, iscustomizerPopup = false ) {
			var self = this;
			self.selectedFeedTemplate = feedTemplate.type;
			if( iscustomizerPopup ){
				self.viewsActive.feedTemplateElement = feedTemplate.type;
			}
			ctfBuilder.$forceUpdate();
		},

		/**
		 * Print Twitter Handle
		 * Checking If there is @ otherwise we add it
		 *
		 * @since 2.0
		 */
		printUserNameTwitterHandle : function( userName ){
			if( this.checkNotEmpty(userName) ){
				return  userName[0] == '@'  ? userName : '@' + userName;
			}
			return '';
		},

		/**
		 * Notice Control Actions
		 *
		 * @since 2.0
		 */
		noticeClickAction : function( action ){
			var self = this;
			switch (action) {
				case 'navigateToStyle':
					var SectionStyle = self.customizerSidebarBuilder['customize'].sections['customize_posts'];
					self.switchCustomizerSection('customize_posts',SectionStyle);
				break;
				case 'navigateToSettingPage':
					window.open(self.adminSettingsURL, '_blank');
				break;
			}
		},

		/**
		 * Format & Print Date
		 *
		 * @since 4.0
		 *
		 * @return String
		 */
		printDate : function( postDate){
			var self = this,
				originalDate 	= Date.parse(postDate) / 1000,
				dateOffset 		= new Date(),
				offsetTimezone 	= dateOffset.getTimezoneOffset(),
				periods = [
					self.translatedText.secondText,
					self.translatedText.minuteText,
					self.translatedText.hourText,
					self.translatedText.dayText,
					self.translatedText.weekText,
					self.translatedText.monthText,
					self.translatedText.yearText
				],
				periodsPlural = [
					self.translatedText.secondsText,
					self.translatedText.minutesText,
					self.translatedText.hoursText,
					self.translatedText.daysText,
					self.translatedText.weeksText,
					self.translatedText.monthsText,
					self.translatedText.yearsText
				],
				lengths			= ["60","60","24","7","4.35","12","10"],
				now 			= dateOffset.getTime()  / 1000,
				newTime 		= originalDate + offsetTimezone,
				printDate 		= '',
				dateFortmat 	= self.customizerFeedData.settings.dateformat,
				difference 	= null,
				formatsChoices = {
					'2' : 'F j',
					'3' : 'F j, Y',
					'4' : 'm.d',
					'5' : 'm.d.y',
					'6' : 'D M jS, Y',
					'7' : 'l F jS, Y',
					'8' : 'l F jS, Y - g:i a',
					'9' : "l M jS, 'y",
					'10' : 'm.d.y',
					'11' : 'm/d/y',
					'12' : 'd.m.y',
					'13' : 'd/m/y',
					'14' : 'd-m-Y, G:i',
					'15' : 'jS F Y, G:i',
					'16' : 'd M Y, G:i',
					'17' : 'l jS F Y, G:i',
					'18' : 'm.d.y - G:i',
					'19' : 'd.m.y - G:i'
				};

				if(formatsChoices.hasOwnProperty(dateFortmat)){
					printDate = date_i18n( formatsChoices[dateFortmat], newTime );
				}else if(dateFortmat == 'custom'){
					var dateCustom = self.customizerFeedData.settings.datecustom;
					printDate = date_i18n( dateCustom , newTime );
				}
				else{
					if( now > originalDate ) {
	                	difference = now - originalDate;

					}else{
	                	difference = originalDate - now;
					}
					for(var j = 0; difference >= lengths[j] && j < lengths.length-1; j++) {
	              	 	difference /= lengths[j];
	            	}
	            	difference = Math.round(difference);
	            	if(difference != 1) {
		                periods[j] = periodsPlural[j];
		            }
					printDate = difference + " " + periods[j];
				}

			return printDate;
		},

	}

});

function ctfBuilderToggleCaption(postID){
	if( ctfBuilder.expandedCaptions.includes(postID) ){
		ctfBuilder.expandedCaptions.splice(ctfBuilder.expandedCaptions.indexOf( postID ), 1);
	}else{
		ctfBuilder.expandedCaptions.push(postID);
	}
}

jQuery( document ).ready(function() {
	jQuery('body').find('.ctf-more').unbind('click')
})