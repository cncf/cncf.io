/**
 * plugin ftp browser javascript
 */
(function($){$(function () {

    // Capture Enter key presses when working with the FTP form.
    $('.wpallimport-download-resource.wpallimport-download-resource-step-two-ftp').on('keypress',function(e) {
        if(e.which === 13) {
            e.preventDefault();
        }
    });

    let preloader = '<span class="ftp-easing-spinner">\n' +
        '        <span class="ftp-double-bounce1"></span>\n' +
        '        <span class="ftp-double-bounce2"></span>\n' +
        '    </span>';

    // Dismiss error notice
    $('.dismiss-wpai-ftp-connection-error').click(function(){
        $(this).parent().hide();
    });

    // Do not execute any code if we are not on plugin page.
    if (!$('body.wpallimport-plugin').length) return;

    let path;

    function jstr(str){
        return JSON.stringify(str);
    }

    function render(data){
        let list = '';

        // If a new protocol host string was returned update the form with it.
        if(data['host']){
            $('input[name="ftp_host"]').val(data['host']);
        }

        // If a new port was returned update the form with it.
        if(data['port']){
            $('input[name="ftp_port"]').val(data['port']);
        }

        // If a new root is returned update the form with it.
        if(data['root']){
            $('input[name="ftp_root"]').val(data['root']);
        }

        list += '<div class="wpai-ftp-browser-grid">';

        // Up One Level row
        list += '<div class="row col1">';
        list += '</div>';

        list += '<div class="row col2">';
        list += '</div>';

        list += '<div class="row col3">';
        list += '</div>';

        // Header row

        list += '<div class="row col1">';
        list += 'Name';
        list += '</div>';

        list += '<div class="row col2">';
        list += '</div>';

        list += '<div class="row col3">';
        list += 'Modified';
        list += '</div>';

        if( Object.keys(data['data']).length === 0){
            list += '<span class="wpai-ftp-no-files-found">No folders or valid files returned.</span>'
        }

        $.each(data['data'], function( i, val){

            let add_class = 'wpai-ftp-browser-link ';

            list += '<div class="row col2">';
            if(val['type'] === 'dir') {
                list += '<span class="wpai-ftp-browser-folder dashicons dashicons-category"/> ';
                add_class += 'wpai-ftp-browser-dir ';
            }else {
                list += '<span class="wpai-ftp-browser-document dashicons dashicons-media-text"/> ';
                add_class += 'wpai-ftp-browser-file '
            }
            list += '<a class="'+add_class+'"data-type="'+val['type']+'" data-dirname="'+val['dirname']+'" data-path="'+val['path']+'" href="javascript:void(0);" >'+val['basename']+'</a>';
            list += '</div>';

            list += '<div class="row col3">';
            list += '</div>';

            list += '<div class="row col4">';
            if(typeof val['timestamp'] !== 'undefined') {
                // Timestamp must be in milliseconds.
                list += new Date(val['timestamp'] * 1000).toLocaleString("en-US");
            }
            list += '</div>';


        });

        list += '</div>';
        return list;
    }

    $('.wpallimport-ftp-builder').on('click', function () {

        // Remove Step 2 buttons and import type options when clicked.
        $('.wpallimport-upload-resource-step-two').hide();
        $('.wpallimport-choose-file').find('.wpallimport-submit-buttons').hide();

        // Load list of files. Start with the last used path if set.
        loadFiles($('input[name="ftp_path"]').val(), true);

    });

    function bindLinks(){

        $('div.row a').off().on('click', function(){

            path = $(this).data('path');
            if (!path) {
                path = $('.wpai-ftp-browser-file-selected').html();
            }

            if ($(this).data('type') === 'dir') {
                $('.wpai-ftp-browser-file-selected').html(path);
                //$('input[name="ftp_path"]').val(path);
                loadFiles(path);
                bindLinks();
            }

            if ($(this).data('type') === 'file') {

                $('.wpai-ftp-browser-file-selected').html(path);
                $('input[name="ftp_path"]').val(path);
                //$('.ftp-connection-builder-dialog').find('.ui-dialog-buttonset .ui-button:nth-child(4)').show();
                $('#wpallimport-ftp-connection-builder').dialog("close");
                $('.wpallimport-upload-resource-step-two').show();
                $('.wpallimport-choose-file').find('.wpallimport-submit-buttons').show();
            }

        });
    }

    function buildConnection(dir = ''){
        let host = $('input[name="ftp_host"]').val();
        let user = $('input[name="ftp_username"]').val();
        let pass = $('input[name="ftp_password"]').val();
        let port = $('input[name="ftp_port"]').val();
        let root = $('input[name="ftp_root"]').val();
        let key = $('textarea[name="ftp_private_key"]').val();

        return {conn_details:{host: host, user: user, pass: pass, port: port, key: key, root:root}, dir:dir};
    }

    function loadFiles(dir = '', firstRun = false){

        $(".wpai-ftp-connection-error").hide();

        let nonce = $('#wpai-ftp-browser-nonce').val();
        let target = location.origin + '/wp-load.php?_nonce=' + nonce;
        target += '&action=wpai_public_api&q=ftpbrowser/load';

        // Format path for display.
        dir = formatPath( dir );

        let conn = buildConnection(dir);

        // Add preloader image if it's not the first run.
        if( firstRun === false ) {
            $("#wpallimport-ftp-connection-builder").append(preloader);
            $(".wpallimport-ftp-connection-builder.ui-dialog-content.ui-widget-content").addClass('ftp-mute-all');
        }else{
            $(".wpai-ftp-select-file-button .easing-spinner").show();
        }

        $.ajax({
            type: 'POST',
            url: target,
            data: jstr(conn),
            success: function(data) {
                $("#wpallimport-ftp-connection-builder").html(render(data));
                bindLinks();
                if(firstRun){
                    displayDialog();
                    $(".wpai-ftp-select-file-button .easing-spinner").hide();

                    /**
                     * Modify the dialog for our purposes.
                     */
                    $('#wpallimport-ftp-connection-builder').prev('.ui-dialog-titlebar').hide();

                    if(!$('.wpai-ftp-browser-file-selected').length) {
                        $('<div><span  class="wpai-ftp-browser-file-selected"/></div>').insertBefore('.ui-dialog-buttonpane');
                    }

                    // Get previously selected path and format it.
                    let dir = formatPath($('input[name="ftp_path"]').val());

                    // Display previously selected path
                    $('.wpai-ftp-browser-file-selected').html(dir);
                }else{
                    $(".wpallimport-ftp-connection-builder.ui-dialog-content.ui-widget-content").removeClass('ftp-mute-all');
                }

                let path = $('.wpai-ftp-browser-file-selected').html();

                // Disable back button for root directory.
                if(path === '' || path === ' ' || path === '/' || path === '\\'){
                    $(".ftp-connection-builder-dialog").parent().find(":button:contains('Back')").button("disable");
                }else{
                    $(".ftp-connection-builder-dialog").parent().find(":button:contains('Back')").button("enable");
                }

                // Enable refresh button.
                $(".ftp-connection-builder-dialog").parent().find(":button:contains('Refresh')").button("enable");

                // Ensure returned links work.
                bindLinks();
            },
            error: function( jqXHR, textStatus, errorThrown ){
                $("#wpai-ftp-connection-error-message").html(jqXHR.responseText);
                $(".wpai-ftp-connection-error").show();
                $(".wpai-ftp-select-file-button .easing-spinner").hide();
                $("#wpallimport-ftp-connection-builder").dialog("close");

            },
            contentType: "application/json",
            dataType: 'json'
        });

        // Display currently requested path.
        $('.wpai-ftp-browser-file-selected').html(dir);


    }

    function displayDialog(){
        $("#wpallimport-ftp-connection-builder").dialog({
            resizable: true,
            height: 600,
            width: 800,
            modal: true,
            draggable: false,
            dialogClass: "ftp-connection-builder-dialog",
            open: function () {
                /*if ($('input[name="ftp_path"]').val()) {
                    $('.ftp-connection-builder-dialog').find('.ui-dialog-buttonset .ui-button:nth-child(4)').show();
                }*/
            },
            buttons: {
                'Back': function () {
                    // Only allow one click at a time.
                    $(".ftp-connection-builder-dialog").parent().find(":button:contains('Back')").button("disable");

                    path =  $('.wpai-ftp-browser-file-selected').html();
                    // Remove trailing slash if needed.
                    if( path.endsWith("/") ) {
                        path = path.substr(0, path.length-1);
                    }
                    // Move path up one level.
                    path = path.substr(0, path.lastIndexOf("/"));
                    //$('input[name="ftp_path"]').val(path);
                    loadFiles(path);
                },
                'Refresh': function () {
                    // Only allow one click at a time.
                    $(".ftp-connection-builder-dialog").parent().find(":button:contains('Refresh')").button("disable");

                    path =  $('.wpai-ftp-browser-file-selected').html();
                    loadFiles(path);
                },
                'Cancel': function () {
                    //$('input[name="ftp_path"]').val('');
                    $(this).dialog("close");
                },
                'Select File': function () {

                        $(this).dialog("close");
                        $('.wpallimport-upload-resource-step-two').show();
                        $('.wpallimport-choose-file').find('.wpallimport-submit-buttons').show();

                }
            }
        });

        // Leaving this button for now in case we decide to use it again.
        $('.ftp-connection-builder-dialog').find('.ui-dialog-buttonset .ui-button:nth-child(4)').hide();
    }

    function formatPath( dir ){
        // Remove filename from previously selected path to avoid no files being shown in the dialog.
        if(/\W(xml|gzip|zip|csv|tsv|gz|json|txt|dat|psv|sql|xls|xlsx)$/.test(dir)){
            dir = dir.substr(0, dir.lastIndexOf("/"));
        }

        // Add trailing slash if needed and we aren't viewing the root path
        if(dir !== '') {
            dir += dir.endsWith("/") ? "" : "/";
        }

        return dir;
    }

})})( jQuery );