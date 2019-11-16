;(function($, window, document, undefined) {
    var wprss = window.wprss = window.wprss || {};
    var f2p = wprss.f2p = wprss.f2p || {};
    var userAjax = f2p.userAjax = f2p.userAjax || {};
    
    $.extend(userAjax, {
        options:        {},
        elements:       $(),
        namespace:      'wprss.f2p.userAjax',
        
        init:                   function(args) {
            var me = this;
            args = args || {};
            this.trigger('beforeInit', args);
            
            this.setOptions($.extend({}, this.options, {
                'is_enabled':               true, // Can very well be off, if needed
                'min_term_length':          3, // Minimal amount of characters in search term needed to send request
                'after_type_delay':         500, // How many milliseconds have to pass after user stops typing before the request is sent
                'request_var_name':         's', // Name of the query variable, which is to contain the request data
                'is_debug':                 false, // Whether or not debug mode is on
                'response_callback':        $.proxy(me._generateOptions, me), // Function
                'data':                     {}, // Additional data to pass to server
                'messages':                 {
                    'keep_typing':              'Keep typing...',
                    'looking_for':              'Looking for'
                },

                'chosen_width_modifier':    20 // How many pixels to add to Chosen controls' width
            }, args));
            
            this._initChosenWidthFix();
            this.trigger('afterInit');
            return this;
        },
        
        run:                   function() {
            var me = this;
            var options = this.getOptions();
            
            if( !options['is_enabled'] ) return this;
            
            var pluginOptions = {
                'url':                      ajaxurl,
                'type':                     'POST',
                'dataType':                 'json',
                
                'minTermLength':            options['min_term_length'],
                'afterTypeDelay':           options['after_type_delay'],
                'jsonTermKey':              options['request_var_name'],
                'data':                     $.extend({}, options.data),
                'keepTypingMsg':            options['keep_typing'],
                'lookingForMsg':            options['looking_for']
            };
            this.trigger('beforeRun', pluginOptions);
            
            this.getElements().each(function(idx) {
                if( !me._initField(this, pluginOptions, $.proxy(me._onAjaxResponse, me) ) )
                    me.log('Could not initialize field. Perhaps, the ajaxChosen plugin is not loaded?');
            });
            
            this.trigger('afterRun');
            return this;
        },
        
        _initField:             function(field, options, callback) {
            if( !$.fn.ajaxChosen ) return false;
            var data = $(field).data() || {};
            options.data = $.extend({}, options.data, data);
            var eArgs = {'field': field, 'options': options, 'callback': callback};
            this.trigger('beforeInitField', eArgs);
            $(field).ajaxChosen(options, callback);
            
            this.trigger('afterInitField', eArgs);
            return this;
        },
        
        _onAjaxResponse:        function(data, callback) {
            var callback = this.getOptions('response_callback');
            if( !callback ) return [];
            var eArgs = {'data': data, 'callback': callback};
            this.trigger('beforeProcessAjaxResponse', eArgs);
            
            eArgs.result = callback(data);
            this.trigger('afterProcessAjaxResponse', eArgs);
            
            return eArgs.result;
        },
        
        _generateOptions:       function(data) {
            var items = data['items'];

            var makeOptions = function(items) {
                var func = arguments.callee;
                var results = [];
                $.each(items, function(idx, item) {
                    var option = $.isPlainObject(item)
                        ? {'text': idx, 'group': true, 'items': func(item)}
                        : {'text': item, 'value': idx};
                    results.push(option);
                });
                
                return results;
            }

            return items ? makeOptions(items) : [];
        },
        
        _initChosenWidthFix:    function() {
            var me = this;
            this.on('beforeInitField', function(e, args) {
                var $field = $(args.field);
                $field.width($field.width() + me.getOptions('chosen_width_modifier'));
            });
        },
        
        getOptions:             function(key, def) {
            if( undefined === key ) return this.options;
            return this.options[key] === undefined ? def : this.options[key];
        },
        
        setOptions:             function(key, value) {
            if( $.isPlainObject(key) ) {
                var me = this;
                $.each(key, function(_key, _value) {
                    me.setOptions(_key, _value);
                });
                return this;
            }
            
            this.options[key] = value;
            return this;
        },
        
        addElement:             function(el, data) {
            data = data || {};
            $(el).data(data);
            var eArgs = {'el': el};
            this.trigger('beforeAddElement', eArgs); 
            this.elements = this.getElements().add(el);
            this.trigger('afterAddElement', eArgs);
            return this;
        },
        
        getElements:            function(selector) {
            if( !selector ) return this.elements;
            return this.elements.find(selector);
        },

        log:                    function(obj, level) {
            if( !console ) return this;
            level = level || 'log';
            obj = $.type(obj) === 'string' && this.namespace
                    ? (this.namespace + ': ' + obj)
                    : obj;
            try {
                if( level === 'warn' ) console.warn(obj);
                if( level === 'error' ) console.error(obj);
                if( level === 'log' && this.getOptions('is_debug') ) console.log(obj);
                if( level === 'info' && this.getOptions('is_debug') ) console.info(obj);
            } catch (e) {}
            return this;
        },
        
        trigger:                function(name, params) {
            params = params || {};
            if( !$.isPlainObject(params) ) params = {'params': params};
            params = $.extend({}, params);
            params._m = this;
            $(this).triggerHandler(name+(this.namespace ? '.'+this.namespace : ''), [params]);
            return this;
        },
        
        on:                     function(name, handler, data) {
            data = data || {};
            $(this).on(name+(this.namespace ? '.'+this.namespace : ''), data, handler);
            return this;
        }
        
    });
    
})(jQuery, top, document);
