"use strict";

(function () {
    var _wp = wp,
        _wp$serverSideRender = _wp.serverSideRender,
        createElement = wp.element.createElement,
        ServerSideRender = _wp$serverSideRender === void 0 ? wp.components.ServerSideRender : _wp$serverSideRender,
        _ref = wp.blockEditor || wp.editor,
        InspectorControls = _ref.InspectorControls,
        _wp$components = wp.components,
        TextareaControl = _wp$components.TextareaControl,
        Button = _wp$components.Button,
        PanelBody = _wp$components.PanelBody,
        Placeholder = _wp$components.Placeholder,
        registerBlockType = wp.blocks.registerBlockType;

    var ctfIcon = createElement('svg', {
        width: 20,
        height: 20,
        viewBox: '0 0 448 512',
        className: 'dashicon'
    }, createElement('path', {
        fill: 'currentColor',
        d: 'M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z'
    }));

    registerBlockType('ctf/ctf-feed-block', {
        title: 'Twitter Feed',
        icon: ctfIcon,
        category: 'widgets',
        attributes: {
            noNewChanges: {
                type: 'boolean',
            },
            shortcodeSettings: {
                type: 'string',
            },
            executed: {
                type: 'boolean'
            }
        },
        edit: function edit(props) {
            var _props = props,
                setAttributes = _props.setAttributes,
                _props$attributes = _props.attributes,
                _props$attributes$sho = _props$attributes.shortcodeSettings,
                shortcodeSettings = _props$attributes$sho === void 0 ? ctf_block_editor.shortcodeSettings : _props$attributes$sho,
                _props$attributes$cli = _props$attributes.noNewChanges,
                noNewChanges = _props$attributes$cli === void 0 ? true : _props$attributes$cli,
                _props$attributes$exe = _props$attributes.executed,
                executed = _props$attributes$exe === void 0 ? false : _props$attributes$exe;

            function setState(shortcodeSettingsContent) {
                setAttributes({
                    noNewChanges: false,
                    shortcodeSettings: shortcodeSettingsContent
                });
            }

            function previewClick(content) {
                setAttributes({
                    noNewChanges: true,
                    executed: false,
                });
            }
            function afterRender() {
                // no way to run a script after AJAX call to get feed so we just try to execute it on a few intervals
                if (! executed
                    || typeof window.ctfGB === 'undefined') {
                    window.ctfGB = true;
                    setTimeout(function() { if (typeof ctf_init !== 'undefined') {ctf_init();}},1000);
                    setTimeout(function() { if (typeof ctf_init !== 'undefined') {ctf_init();}},2000);
                    setTimeout(function() { if (typeof ctf_init !== 'undefined') {ctf_init();}},3000);
                    setTimeout(function() { if (typeof ctf_init !== 'undefined') {ctf_init();}},5000);
                    setTimeout(function() { if (typeof ctf_init !== 'undefined') {ctf_init();}},10000);
                }
                setAttributes({
                    executed: true,
                });
            }

            var jsx = [React.createElement(InspectorControls, {
                key: "ctf-gutenberg-setting-selector-inspector-controls"
            }, React.createElement(PanelBody, {
                title: ctf_block_editor.i18n.addSettings
            }, React.createElement(TextareaControl, {
                key: "ctf-gutenberg-settings",
                className: "ctf-gutenberg-settings",
                label: ctf_block_editor.i18n.shortcodeSettings,
                help: ctf_block_editor.i18n.example + ": 'screenname=\"smashballoon\" showbutton=\"true\"'",
                value: shortcodeSettings,
                onChange: setState
            }), React.createElement(Button, {
                key: "ctf-gutenberg-preview",
                className: "ctf-gutenberg-preview",
                onClick: previewClick,
                isDefault: true
            }, ctf_block_editor.i18n.preview)))];

            if (noNewChanges) {
                afterRender();
                jsx.push(React.createElement(ServerSideRender, {
                    key: "custom-twitter-feeds/custom-twitter-feeds",
                    block: "ctf/ctf-feed-block",
                    attributes: props.attributes,
                }));
            } else {
                props.attributes.noNewChanges = false;
                jsx.push(React.createElement(Placeholder, {
                    key: "ctf-gutenberg-setting-selector-select-wrap",
                    className: "ctf-gutenberg-setting-selector-select-wrap"
                }, React.createElement(Button, {
                    key: "ctf-gutenberg-preview",
                    className: "ctf-gutenberg-preview",
                    onClick: previewClick,
                    isDefault: true
                }, ctf_block_editor.i18n.preview)));
            }

            return jsx;
        },
        save: function save() {
            return null;
        }
    });
})();