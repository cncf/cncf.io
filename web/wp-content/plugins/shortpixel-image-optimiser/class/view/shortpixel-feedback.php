<?php
namespace ShortPixel;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;
use ShortPixel\Controller\ApiKeyController as ApiKeyController;

/**
 * User: simon
 * Date: 11.04.2018
 * @todo This whole thing needs redoing.
 */
class ShortPixelFeedback {

    private $key;
    private $ctrl;
    private $plugin_file = '';
    private $plugin_name = '';

    function __construct( $_plugin_file, $slug) {

        $this->plugin_file = $_plugin_file;
        $this->plugin_name = $slug; //for translations

				$apiControl = ApiKeyController::getInstance();
				$this->key = $apiControl->forceGetApiKey();

        // Deactivation
        add_filter( 'plugin_action_links_' . plugin_basename( $this->plugin_file ), array( $this, 'filterActionLinks') );
				add_filter('network_admin_plugin_action_links_' . plugin_basename( $this->plugin_file ), array( $this, 'filterActionLinks'));
        add_action( 'admin_footer-plugins.php', array( $this, 'goodbyeAjax') );
        add_action( 'wp_ajax_shortpixel_deactivate_plugin', array( $this, 'deactivatePluginCallback') );

    }

    /**
     * Filter the deactivation link to allow us to present a form when the user deactivates the plugin
     * @since 1.0.0
     */
    public function filterActionLinks( $links ) {

        if( isset( $links['deactivate'] ) ) {

            $deactivation_link = $links['deactivate'];
            // Insert an onClick action to allow form before deactivating
            $deactivation_link = str_replace( '<a ',
                '<div class="shortpixel-deactivate-form-wrapper">
                     <span class="shortpixel-deactivate-form" id="shortpixel-deactivate-form-' . esc_attr( $this->plugin_name ) . '"></span>
                 </div><a id="shortpixel-deactivate-link-' . esc_attr( $this->plugin_name ) . '" ', $deactivation_link );
            $links['deactivate'] = $deactivation_link;
        }
        return $links;
    }

    /**
     * Form text strings
     * These can be filtered
     * @since 1.0.0
     */
    public function goodbyeAjax() {
        // Get our strings for the form
        $form = $this->getFormInfo();

        // Build the HTML to go in the form
        $html = '<div class="shortpixel-deactivate-form-head"><strong>' . esc_html( $form['heading'] ) . '</strong></div>';
        $html .= '<div class="shortpixel-deactivate-form-body">';
        if( is_array( $form['options'] ) ) {
            $html .= '<div class="shortpixel-deactivate-options">';
            $html .= '<p><strong>' . esc_html( $form['body'] ) . '</strong></p><p>';
            foreach( $form['options'] as $key => $option ) {
                $html .= '<input type="radio" name="shortpixel-deactivate-reason" id="' . esc_attr( $key ) . '" value="' . esc_attr( $key ) . '"> <label for="' . esc_attr( $key ) . '">' . esc_attr( $option ) . '</label><br>';
            }
            $html .= '</p><label id="shortpixel-deactivate-details-label" for="shortpixel-deactivate-reasons"><strong>' . esc_html( $form['details'] ) .'</strong></label><textarea name="shortpixel-deactivate-details" id="shortpixel-deactivate-details" rows="2" style="width:100%"></textarea>';
            $html .= '</div><!-- .shortpixel-deactivate-options -->';
        }
        $html .= '<hr/>';
        $html .= '<span title="' . __( 'Un-check this if you don\\\'t plan to use ShortPixel in the future on this website. You might also want to run a Bulk Delete SP Metadata before removing the plugin (Media Library -> Bulk ShortPixel).', 'shortpixel-image-optimiser' )
            . '">'
            . sprintf(__(  'If you want to completely uninstall ShortPIxel from your site, please go to %s Settings → ShortPixel → Tools %s.', 'shortpixel-image-optimiser' ),'<a href="' . esc_url(admin_url('/options-general.php?page=wp-shortpixel-settings&part=tools'))  . '">', '</a>') . '</span><br>';
        $html .= '<hr/>';
        $html .= '</div><!-- .shortpixel-deactivate-form-body -->';
        $html .= '<p class="deactivating-spinner"><span class="spinner"></span> ' . __( 'Submitting form', 'shortpixel-image-optimiser' ) . '</p>';
        $html .= '<div class="shortpixel-deactivate-form-footer"><p>';
        $html .= '<label for="anonymous" title="'
            . __("If you UNCHECK this then your email address will be sent along with your feedback. This can be used by ShortPixel to get back to you for more info or a solution.",'shortpixel-image-optimiser')
            . '"><input type="checkbox" name="shortpixel-deactivate-tracking" checked="checked" id="anonymous" value="1"> ' . esc_html__( 'Send anonymous', 'shortpixel-image-optimiser' ) . '</label><br>';
        $html .= '<a id="shortpixel-deactivate-submit-form" class="button button-primary" href="#">'
            . __( '<span>Submit&nbsp;and&nbsp;</span>Deactivate', 'shortpixel-image-optimiser' )
            . '</a>';
        $html .= '</p></div>';
        ?>
        <div class="shortpixel-deactivate-form-bg"></div>
        <style type="text/css">
            .shortpixel-deactivate-form-active .shortpixel-deactivate-form-bg {
                background: rgba( 0, 0, 0, .5 );
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
            }
            .shortpixel-deactivate-form-wrapper {
                position: relative;
                z-index: 999;
                display: none;
            }
            .shortpixel-deactivate-form-active .shortpixel-deactivate-form-wrapper {
                display: block;
            }
            .shortpixel-deactivate-form {
                display: none;
            }
            .shortpixel-deactivate-form-active .shortpixel-deactivate-form {
                position: absolute;
                bottom: 30px;
                left: 0;
                max-width: 500px;
                min-width: 360px;
                background: #fff;
                white-space: normal;
            }
            .shortpixel-deactivate-form-head {
                background: #4bbfcc;
                color: #fff;
                padding: 8px 18px;
            }
            .shortpixel-deactivate-form-body {
                padding: 8px 18px 0;
                color: #444;
            }
            .shortpixel-deactivate-form-body label[for="shortpixel-remove-settings"] {
                font-weight: bold;
            }
            .deactivating-spinner {
                display: none;
            }
            .deactivating-spinner .spinner {
                float: none;
                margin: 4px 4px 0 18px;
                vertical-align: bottom;
                visibility: visible;
            }
            .shortpixel-deactivate-form-footer {
                padding: 0 18px 8px;
            }
            .shortpixel-deactivate-form-footer label[for="anonymous"] {
                visibility: hidden;
            }
            .shortpixel-deactivate-form-footer p {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin: 0;
            }
            #shortpixel-deactivate-submit-form span {
                display: none;
            }
            .shortpixel-deactivate-form.process-response .shortpixel-deactivate-form-body,
            .shortpixel-deactivate-form.process-response .shortpixel-deactivate-form-footer {
                position: relative;
            }
            .shortpixel-deactivate-form.process-response .shortpixel-deactivate-form-body:after,
            .shortpixel-deactivate-form.process-response .shortpixel-deactivate-form-footer:after {
                content: "";
                display: block;
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba( 255, 255, 255, .5 );
            }
        </style>
        <script>
            jQuery(document).ready(function($){
                var deactivateURL = $("#shortpixel-deactivate-link-<?php echo esc_attr( $this->plugin_name ); ?>"),
                    formID = '#shortpixel-deactivate-form-<?php echo esc_attr( $this->plugin_name ); ?>',
                    formContainer = $(formID),
                    deactivated = true,
                    detailsStrings = {
                        'setup' : '<?php esc_html_e( 'What was the dificult part ?', 'shortpixel-image-optimiser') ?>',
                        'docs' : '<?php esc_html_e( 'What can we describe more ?', 'shortpixel-image-optimiser' ) ?>',
                        'features' : '<?php esc_html_e( 'How could we improve ?', 'shortpixel-image-optimiser' ) ?>',
                        'better-plugin' : '<?php esc_html_e( 'Can you mention it ?', 'shortpixel-image-optimiser' ) ?>',
                        'incompatibility' : '<?php esc_html_e( 'With what plugin or theme is incompatible ?', 'shortpixel-image-optimiser' ) ?>',
                        'maintenance' : '<?php esc_html_e( 'Please specify', 'shortpixel-image-optimiser') ?>',
												'temporary' : '',
                    };

                $( deactivateURL).attr('onclick', "javascript:event.preventDefault();");
                $( deactivateURL ).on("click", function(){

                    var SubmitFeedback = function(data, formContainer){
                        data['action']          = 'shortpixel_deactivate_plugin';
                        data['security']        = '<?php echo sanitize_key(wp_create_nonce("shortpixel_deactivate_plugin" )); ?>';
                        data['dataType']        = 'json';
                        data['keep-settings']   = formContainer.find('#shortpixel-keep-settings:checked').length;

                        // As soon as we click, the body of the form should disappear
                        formContainer.addClass( 'process-response' );

                        // Fade in spinner
                        formContainer.find(".deactivating-spinner").fadeIn();

                        $.post(
                            ajaxurl,
                            data,
                            function(response){
                                // Redirect to original deactivation URL
                                window.location.href = url;
                            }
                        );
                    }

                    // We'll send the user to this deactivation link when they've completed or dismissed the form
                    var url = deactivateURL.attr( 'href' );

                    $('body').toggleClass('shortpixel-deactivate-form-active');
                    formContainer.fadeIn({complete: function(){
                        var offset = formContainer.offset();
                        if( offset.top < 50) {
                            $(this).parent().css('top', (50 - offset.top) + 'px')
                        }
                        $('html,body').animate({ scrollTop: Math.max(0, offset.top - 50) });
                    }});
                    formContainer.html( '<?php echo $html; ?>');

                    formContainer.on( 'change', 'input[type=radio]', function(){

                        var detailsLabel = formContainer.find( '#shortpixel-deactivate-details-label strong' ),
                            anonymousLabel = formContainer.find( 'label[for="anonymous"]' )[0],
                            submitSpan = formContainer.find( '#shortpixel-deactivate-submit-form span' )[0],
                            value = formContainer.find( 'input[name="shortpixel-deactivate-reason"]:checked' ).val();
														commentBox = formContainer.find('textarea[name="shortpixel-deactivate-details"]');

											//	console.log(detailsLabel);
											//	console.log(commentBox);
												var the_detail = detailsStrings[ value ];
											//	console.log(the_detail);
												if (the_detail == '')
												{
													detailsLabel.css('visibility','hidden');
													commentBox.css('visibility','hidden');
												}
												else
												{
													detailsLabel.css('visibility','visible');
													commentBox.css('visibility','visible');

												}

                        detailsLabel.text( the_detail );
                        anonymousLabel.style.visibility = "visible";
                        submitSpan.style.display = "inline-block";
                        if(deactivated) {
                            deactivated = false;
                            $('#shortpixel-deactivate-submit-form').removeAttr("disabled");
                            formContainer.off('click', '#shortpixel-deactivate-submit-form');
                            formContainer.on('click', '#shortpixel-deactivate-submit-form', function(e){
                                e.preventDefault();
                                var data = {
                                    reason: formContainer.find('input[name="shortpixel-deactivate-reason"]:checked').val(),
                                    details: formContainer.find('#shortpixel-deactivate-details').val()
                                    //anonymous: formContainer.find('#anonymous:checked').length,
                                };
																if (formContainer.find('#anonymous').is(':checked'))
																	data['anonymous'] = 1;
																else
																	data['anonymous'] = 0;

                                SubmitFeedback(data, formContainer);
                            });
                        }
                    });

                    formContainer.on('click', '#shortpixel-deactivate-submit-form', function(e){
                        e.preventDefault();
                       // if( formContainer.find('#shortpixel-keep-settings:checked').length ) {
                            window.location.href = url;
                       /* } else {
                            SubmitFeedback({}, formContainer);
                        } */
                    });

                    // If we click outside the form, the form will close
                    $('.shortpixel-deactivate-form-bg').on('click',function(){
                        formContainer.fadeOut();
                        $('body').removeClass('shortpixel-deactivate-form-active');
                    });
                });
            });

        </script>
    <?php }

    /*
     * Form text strings
     * These are non-filterable and used as fallback in case filtered strings aren't set correctly
     * @since 1.0.0
     */
    public function getFormInfo() {
        $form = array();
        $form['heading'] = __( 'Sorry to see you go', 'shortpixel-image-optimiser' );
        $form['body'] = __( 'Before you deactivate the plugin, would you quickly give us your reason for doing so?', 'shortpixel-image-optimiser' );
        $form['options'] = array(
						'temporary' 			=> __('Temporary deactivation', 'shortpixel-image-optimiser'),
            'setup'           => __( 'Set up is too difficult',  'shortpixel-image-optimiser' ),
            'docs'            => __( 'Lack of documentation',  'shortpixel-image-optimiser' ),
            'features'        => __( 'Not the features I wanted',  'shortpixel-image-optimiser' ),
            'better-plugin'   => __( 'Found a better plugin',  'shortpixel-image-optimiser' ),
            'incompatibility' => __( 'Incompatible with theme or plugin',  'shortpixel-image-optimiser' ),
            'maintenance'     => __( 'Other',  'shortpixel-image-optimiser' ),
        );
        $form['details'] = __( 'How could we improve ?',  'shortpixel-image-optimiser');
        return $form;
    }

    public function deactivatePluginCallback() {

        check_ajax_referer( 'shortpixel_deactivate_plugin', 'security' );


				Log::addDebug('Deactive Plugin Callback POST', $_POST);

        if ( isset($_POST['reason']) && isset($_POST['details']) && isset($_POST['anonymous']) ) {
            require_once(\WPSPIO()->plugin_path() . 'class/view/shortpixel-plugin-request.php');
            $anonymous = (intval($_POST['anonymous']) == 1) ? true : false;
            $args = array(
                'key' =>  $this->key,
                'reason' => sanitize_text_field(wp_unslash($_POST['reason'])),
                'details' => sanitize_text_field(wp_unslash($_POST['details'])),
                'anonymous' => $anonymous
            );
            $request = new ShortPixelPluginRequest( $this->plugin_file, 'http://' . SHORTPIXEL_API . '/v2/feedback.php', $args );
            if ( $request->request_successful ) {
                echo json_encode( array(
                    'status' => 'ok',
                ) );
            }else{
                echo json_encode( array(
                    'status' => 'nok',
                ) );
            }
        }else{
            echo json_encode( array(
                'status' => 'OK',
            ) );
        }

        die();

    }

}
