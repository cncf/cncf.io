
//----------------------------------------------------------
//------ JAVASCRIPT HOOK FUNCTIONS FOR GRAVITY FORMS -------
//----------------------------------------------------------

if ( ! gform ) {
	document.addEventListener( 'gform_main_scripts_loaded', function() { gform.scriptsLoaded = true; } );
	window.addEventListener( 'DOMContentLoaded', function() { gform.domLoaded = true; } );

	var gform = {
		domLoaded: false,
		scriptsLoaded: false,
		initializeOnLoaded: function( fn ) {
			if ( gform.domLoaded && gform.scriptsLoaded ) {
				fn();
			} else if( ! gform.domLoaded && gform.scriptsLoaded ) {
				window.addEventListener( 'DOMContentLoaded', fn );
			} else {
				document.addEventListener( 'gform_main_scripts_loaded', fn );
			}
		},
		hooks: { action: {}, filter: {} },
		addAction: function( action, callable, priority, tag ) {
			gform.addHook( 'action', action, callable, priority, tag );
		},
		addFilter: function( action, callable, priority, tag ) {
			gform.addHook( 'filter', action, callable, priority, tag );
		},
		doAction: function( action ) {
			gform.doHook( 'action', action, arguments );
		},
		applyFilters: function( action ) {
			return gform.doHook( 'filter', action, arguments );
		},
		removeAction: function( action, tag ) {
			gform.removeHook( 'action', action, tag );
		},
		removeFilter: function( action, priority, tag ) {
			gform.removeHook( 'filter', action, priority, tag );
		},
		addHook: function( hookType, action, callable, priority, tag ) {
			if ( undefined == gform.hooks[hookType][action] ) {
				gform.hooks[hookType][action] = [];
			}
			var hooks = gform.hooks[hookType][action];
			if ( undefined == tag ) {
				tag = action + '_' + hooks.length;
			}
			if( priority == undefined ){
				priority = 10;
			}

			gform.hooks[hookType][action].push( { tag:tag, callable:callable, priority:priority } );
		},
		doHook: function( hookType, action, args ) {

			// splice args from object into array and remove first index which is the hook name
			args = Array.prototype.slice.call(args, 1);

			if ( undefined != gform.hooks[hookType][action] ) {
				var hooks = gform.hooks[hookType][action], hook;
				//sort by priority
				hooks.sort(function(a,b){return a["priority"]-b["priority"]});
				for( var i=0; i<hooks.length; i++) {
					hook = hooks[i].callable;
					if(typeof hook != 'function')
						hook = window[hook];
					if ( 'action' == hookType ) {
						hook.apply(null, args);
					} else {
						args[0] = hook.apply(null, args);
					}
				}
			}
			if ( 'filter'==hookType ) {
				return args[0];
			}
		},
		removeHook: function( hookType, action, priority, tag ) {
			if ( undefined != gform.hooks[hookType][action] ) {
				var hooks = gform.hooks[hookType][action];
				for( var i=hooks.length-1; i>=0; i--) {
					if ((undefined==tag||tag==hooks[i].tag) && (undefined==priority||priority==hooks[i].priority)){
						hooks.splice(i,1);
					}
				}
			}
		}
	};
}
