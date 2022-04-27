/**
 * Confirm Dialog Box Popup
 *
 * @since 2.0
 */
Vue.component('sb-confirm-dialog-component', {
    name: 'sb-confirm-dialog-component',
    template: '#sb-confirm-dialog-component',
    props: [
    	'dialogBox',
    	'sourceToDelete',
    	'genericText',
    	'svgIcons',
    	'parentType',
    	'parent'
    ],
    computed : {
    	dialogBoxElement :function(){
    		return this.dialogBox;
    	}
    },
    methods : {

    	/**
		 * Confirm Dialog Button text
		 *
		 * @since 2.0
		*/
		getButtonText : function(type, dialogBoxElement){
			if(type == 'confirm'){
				if(dialogBoxElement.customButtons != undefined){
					return dialogBoxElement.customButtons.confirm.text;
				}
				return this.genericText.confirm;
			}
			if(type == 'cancel'){
				if(dialogBoxElement.customButtons != undefined){
					return dialogBoxElement.customButtons.cancel.text;
				}
				return this.genericText.cancel;
			}
		},

		/**
		 * Confirm Dialog Box Button Background
		 *
		 * @since 2.0
		*/
		getButtonBackground : function(type, dialogBoxElement){
			var color = '';
			if(type == 'confirm'){
				if(dialogBoxElement.customButtons != undefined){
					color = dialogBoxElement.customButtons.confirm.color;
				}else{
					color = 'red';
				}
			}
			if(type == 'cancel'){
				if(dialogBoxElement.customButtons != undefined){
					color = dialogBoxElement.customButtons.cancel.color;
				}else{
					color = 'grey';
				}
			}
			return 'sb-btn-' + color;
		},

    	/**
		 * Confirm Dialog Box
		 *
		 * @since 2.0
		 */
    	confirmDialogAction : function(){
			var self = this;
			self.$parent.confirmDialogAction();
			self.closeConfirmDialog();
		},

    	/**
		 * Close Dialog Box
		 *
		 * @since 2.0
		 */
    	closeConfirmDialog : function(){
			var self = this;
    		if( self.parentType == 'builder' ){
				self.$parent.sourceToDelete = {};
				self.$parent.feedToDelete = {};
    		}
    		if(self.dialogBoxElement.type == 'unsavedFeedSources'){
    			self.$parent.viewsActive.feedtypesCustomizerPopup = false;
    		}

			var dialogBox = {
				active : false,
				type : null,
				heading : null,
				description : null,
				customButtons : undefined
			};
			self.$emit('update:dialogBox', dialogBox)
		},
    }
});