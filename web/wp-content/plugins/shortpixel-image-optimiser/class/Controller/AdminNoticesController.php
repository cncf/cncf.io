<?php
namespace ShortPixel\Controller;

use ShortPixel\Notices\NoticeController as Notices;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;

use ShortPixel\ViewController as ViewController;

use ShortPixel\Model\AccessModel as AccessModel;

// Use ShortPixel\Model\ApiKeyModel as ApiKeyModel

/**
 * Controller for automatic Notices about status of the plugin.
 * This controller is bound for automatic fire. Regular procedural notices should just be queued using the Notices modules.
 * Called in admin_notices.
 */
class AdminNoticesController extends \ShortPixel\Controller
{
    protected static $instance;

    protected $definedNotices = array( // NoticeModels by Class.  This is not optimal but until solution found, workable.
        'CompatNotice',
        'UnlistedNotice',
        'AvifNotice',
        'QuotaNoticeMonth',
        'QuotaNoticeReached',
        'ApiNotice',
        'ApiNoticeRepeat',
        'ApiNoticeRepeatLong',
        'NextgenNotice',
   //     'SmartcropNotice',
        'LegacyNotice',
        'ListviewNotice',
				'HeicFeatureNotice',
    );
    protected $adminNotices; // Models

    private $remote_message_endpoint = 'https://api.shortpixel.com/v2/notices.php';
    private $remote_readme_endpoint = 'https://plugins.svn.wordpress.org/shortpixel-image-optimiser/trunk/readme.txt';

    public function __construct()
    {
        add_action('admin_notices', array($this, 'displayNotices'), 50); // notices occured before page load
        add_action('admin_footer', array($this, 'displayNotices'));  // called in views.

        add_action('in_plugin_update_message-' . plugin_basename(SHORTPIXEL_PLUGIN_FILE), array($this, 'pluginUpdateMessage') , 50, 2 );

        // no persistent notifications with this flag set.
        if (defined('SHORTPIXEL_SILENT_MODE') && SHORTPIXEL_SILENT_MODE === true)
            return;

        add_action('admin_notices', array($this, 'check_admin_notices'), 5); // run before the plugin admin notices

				$this->initNotices();
    }

    public static function getInstance()
    {
        if (is_null(self::$instance))
            self::$instance = new AdminNoticesController();

        return self::$instance;
    }

    public static function resetAllNotices()
    {
        Notices::resetNotices();
    }

		// Notices no longer in use.
		public static function resetOldNotices()
		{
			Notices::removeNoticeByID('MSG_FEATURE_SMARTCROP');

		}

    /** Triggered when plugin is activated */
    public static function resetCompatNotice()
    {
        Notices::removeNoticeByID('MSG_COMPAT');
    }

    public static function resetAPINotices()
    {
        Notices::removeNoticeByID('MSG_NO_APIKEY');
        Notices::removeNoticeByID('MSG_NO_APIKEY_REPEAT');
        Notices::removeNoticeByID('MSG_NO_APIKEY_REPEAT_LONG');
    }

    public static function resetQuotaNotices()
    {
        Notices::removeNoticeByID('MSG_UPGRADE_MONTH');
        Notices::removeNoticeByID('MSG_UPGRADE_BULK');
        Notices::removeNoticeBYID('MSG_QUOTA_REACHED');
    }

    public static function resetIntegrationNotices()
    {
        Notices::removeNoticeByID('MSG_INTEGRATION_NGGALLERY');
    }

    public static function resetLegacyNotice()
    {
        Notices::removeNoticeByID('MSG_CONVERT_LEGACY');
    }

    public function displayNotices()
    {
        if (! \wpSPIO()->env()->is_screen_to_use)
        {
            if(get_current_screen()->base !== 'dashboard') // ugly exception for dashboard.
                return; // suppress all when not our screen.
        }

        $access = AccessModel::getInstance();
        $screen = get_current_screen();
        $screen_id = \wpSPIO()->env()->screen_id;

        $noticeControl = Notices::getInstance();
        $noticeControl->loadIcons(array(
            'normal' => '<img class="short-pixel-notice-icon" src="' . plugins_url('res/img/slider.png', SHORTPIXEL_PLUGIN_FILE) . '">',
            'success' => '<img class="short-pixel-notice-icon" src="' . plugins_url('res/img/robo-cool.png', SHORTPIXEL_PLUGIN_FILE) . '">',
            'warning' => '<img class="short-pixel-notice-icon" src="' . plugins_url('res/img/robo-scared.png', SHORTPIXEL_PLUGIN_FILE) . '">',
            'error' => '<img class="short-pixel-notice-icon" src="' . plugins_url('res/img/robo-scared.png', SHORTPIXEL_PLUGIN_FILE) . '">',
        ));

        if ($noticeControl->countNotices() > 0)
        {

            $notices = $noticeControl->getNoticesForDisplay();
            if (count($notices) > 0)
            {
                \wpSPIO()->load_style('shortpixel-notices');
								\wpSPIO()->load_style('notices-module');


                foreach($notices as $notice)
                {

                    if ($notice->checkScreen($screen_id) === false)
                    {
                        continue;
                    }
                    elseif ($access->noticeIsAllowed($notice))
                    {
                        echo $notice->getForDisplay();
                    }
                    else
                    {
                        continue;
                    }

                    // Todo change this to new keys
                    if ($notice->getID() == 'MSG_QUOTA_REACHED' || $notice->getID() == 'MSG_UPGRADE_MONTH') //|| $notice->getID() == AdminNoticesController::MSG_UPGRADE_BULK
                    {
                        wp_enqueue_script('jquery.knob.min.js');
                        wp_enqueue_script('shortpixel');
                    }
                }
            }
        }
        $noticeControl->update(); // puts views, and updates
    }

    /* General function to check on Hook for admin notices if there is something to show globally */
    public function check_admin_notices()
    {
        if (! \wpSPIO()->env()->is_screen_to_use)
        {
            if(get_current_screen()->base !== 'dashboard') // ugly exception for dashboard.
                return; // suppress all when not our screen.
        }

       $this->loadNotices();
    }

    protected function initNotices()
    {
        foreach($this->definedNotices as $className)
        {
            $ns = '\ShortPixel\Model\AdminNotices\\' . $className;
            $class = new $ns();
            $this->adminNotices[$class->getKey()] = $class;
        }
    }

		protected function loadNotices()
		{
			 foreach($this->adminNotices as $key => $class)
			 {
				  $class->load();
					$this->doRemoteNotices();
			 }
		}

    public function getNoticeByKey($key)
    {
        if (isset($this->adminNotices[$key]))
        {
            return $this->adminNotices[$key];
        }
        else {
            return false;
        }
    }

    public function getAllNotices()
    {
        return $this->adminNotices;
    }


    // Called by MediaLibraryModel
    public function invokeLegacyNotice()
    {
        $noticeModel = $this->getNoticeByKey('MSG_CONVERT_LEGACY');
        if (! $noticeModel->isDismissed())
        {
            $noticeModel->addManual();
        }

    }


    protected function doRemoteNotices()
    {
        $notices = $this->get_remote_notices();

        if ($notices == false)
            return;

        foreach($notices as $remoteNotice)
        {
            if (! isset($remoteNotice->id) && ! isset($remoteNotice->message))
                return;

            if (! isset($remoteNotice->type))
                $remoteNotice->type = 'notice';

            $message = esc_html($remoteNotice->message);
            $id = sanitize_text_field($remoteNotice->id);

            $noticeController = Notices::getInstance();
            $noticeObj = $noticeController->getNoticeByID($id);

            // not added to system yet
            if ($noticeObj === false)
            {
                switch ($remoteNotice->type)
                {
                    case 'warning':
                        $new_notice = Notices::addWarning($message);
                        break;
                    case 'error':
                        $new_notice = Notices::addError($message);
                        break;
                    case 'notice':
                    default:
                        $new_notice = Notices::addNormal($message);
                        break;
                }

                Notices::makePersistent($new_notice, $id, MONTH_IN_SECONDS);
            }


        }

    }

    public function proposeUpgradePopup() {
        $view = new ViewController();
        $view->loadView('snippets/part-upgrade-options');
    }

    public function proposeUpgradeRemote()
    {
        //$stats = $this->countAllIfNeeded($this->_settings->currentStats, 300);
        $statsController = StatsController::getInstance();
        $apiKeyController = ApiKeyController::getInstance();
        $settings = \wpSPIO()->settings();

        $webpActive = ($settings->createWebp) ? true : false;
        $avifActive =  ($settings->createAvif) ? true : false;

        $args = array(
            'method' => 'POST',
            'timeout' => 10,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array(),
            'body' => array("params" => json_encode(array(
                'plugin_version' => SHORTPIXEL_IMAGE_OPTIMISER_VERSION,
                'key' => $apiKeyController->forceGetApiKey(),
                'm1' => $statsController->find('period', 'months', '1'),
                'm2' => $statsController->find('period', 'months', '2'),
                'm3' => $statsController->find('period', 'months', '3'),
                'm4' => $statsController->find('period', 'months', '4'),
                'filesTodo' => $statsController->totalImagesToOptimize(),
                'estimated' => $settings->optimizeUnlisted || $settings->optimizeRetina ? 'true' : 'false',
                'webp' => $webpActive,
                'avif' => $avifActive,
                /* */
                'iconsUrl' => base64_encode(wpSPIO()->plugin_url('res/img'))
            ))),
            'cookies' => array()

        );


        $proposal = wp_remote_post("https://shortpixel.com/propose-upgrade-frag", $args);

        if(is_wp_error( $proposal )) {
            $proposal = array('body' => __('Error. Could not contact ShortPixel server for proposal', 'shortpixel-image-optimiser'));
        }
        die( $proposal['body'] );

    }

    private function get_remote_notices()
    {
        $transient_name = 'shortpixel_remote_notice';
        $transient_duration = DAY_IN_SECONDS;

        if (\wpSPIO()->env()->is_debug)
            $transient_duration = 30;

        $keyControl = new apiKeyController();
        //$keyControl->loadKey();

        $notices = get_transient($transient_name);
        $url = $this->remote_message_endpoint;
        $url = add_query_arg(array(  // has url
            'key' => $keyControl->forceGetApiKey(),
            'version' => SHORTPIXEL_IMAGE_OPTIMISER_VERSION,
            'target' => 3,
        ), $url);


        if ( $notices === false  ) {
            $notices_response = wp_safe_remote_request( $url );
            $content = false;
            if (! is_wp_error( $notices_response ) )
            {
                $notices = json_decode($notices_response['body']);

                if (! is_array($notices))
                    $notices = false;

                // Save transient anywhere to prevent over-asking when nothing good is there.
                set_transient( $transient_name, $notices, $transient_duration );
            }
            else
            {
                set_transient( $transient_name, false, $transient_duration );
            }
        }

        return $notices;
    }





    public function pluginUpdateMessage($data, $response)
    {
        //    $message = $this->getPluginUpdateMessage($plugin['new_version']);

        $message = $this->get_update_notice($data, $response);

        if( $message !== false && strlen(trim($message)) > 0) {
            $wp_list_table = _get_list_table( 'WP_Plugins_List_Table' );
            printf(
                '<tr class="plugin-update-tr active"><td colspan="%s" class="plugin-update colspanchange"><div class="notice inline notice-warning notice-alt">%s</div></td></tr>',
                $wp_list_table->get_column_count(),
                wpautop( $message )
            );
        }

    }

    /**
     *   Stolen from SPAI, Thanks.
     */
    private function get_update_notice($data, $response) {
        $transient_name = 'shortpixel_update_notice_' . $response->new_version;

        $transient_duration = DAY_IN_SECONDS;

        if (\wpSPIO()->env()->is_debug)
            $transient_duration = 30;

        $update_notice  = get_transient( $transient_name );
        $url = $this->remote_readme_endpoint;

        if ( $update_notice === false || strlen( $update_notice ) == 0 ) {
            $readme_response = wp_safe_remote_request( $url );
            $content = false;
            if (! is_wp_error( $readme_response ) )
            {
                $content = $readme_response['body'];
            }


            if ( !empty( $readme_response ) ) {
                $update_notice = $this->parse_update_notice( $content, $response );
                set_transient( $transient_name, $update_notice, $transient_duration );
            }
        }

        return $update_notice;
    }



    /**
     * Parse update notice from readme file.
     *
     * @param string $content  ShortPixel AI readme file content
     * @param object $response WordPress response
     *
     * @return string
     */
    private function parse_update_notice( $content, $response ) {

        $new_version = $response->new_version;

        $update_notice = '';

        // foreach ( $check_for_notices as $id => $check_version ) {

        if ( version_compare( SHORTPIXEL_IMAGE_OPTIMISER_VERSION, $new_version, '>' ) ) {
            return '';
        }

        $result = $this->parse_readme_content( $content, $new_version, $response );

        if ( !empty( $result ) ) {
            $update_notice = $result;
        }
        //   }

        return wp_kses_post( $update_notice );
    }


    /*
       *
       * Parses readme file's content to find notice related to passed version
       *
       * @param string $content Readme file content
       * @param string $version Checked version
       * @param object $response WordPress response
       *
       * @return string
       */

    private function parse_readme_content( $content, $new_version, $response ) {

        $notices_pattern = '/==.*Upgrade Notice.*==(.*)$|==/Uis';

        $notice = '';
        $matches = null;

        if ( preg_match( $notices_pattern, $content, $matches ) ) {

            if (! isset($matches[1]))
                return ''; // no update texts.

            $match = str_replace('\n', '', $matches[1]);
            $lines = str_split(trim($match));

            $versions = array();
            $inv = false;
            foreach($lines as $char)
            {
                //if (count($versions) == 0)
                if ($char == '=' && ! $inv) // = and not recording version, start one.
                {
                    $curver = '';
                    $inv = true;
                }
                elseif ($char == ' ' && $inv) // don't record spaces in version
                    continue;
                elseif ($char == '=' && $inv) // end of version line
                {  $versions[trim($curver)] = '';
                    $inv = false;
                }
                elseif($inv) // record the version string
                {
                    $curver .= $char;
                }
                elseif(! $inv)  // record the message
                {
                    $versions[trim($curver)] .= $char;
                }


            }

            foreach($versions as $version => $line)
            {
                if (version_compare(SHORTPIXEL_IMAGE_OPTIMISER_VERSION, $version, '<') && version_compare($version, $new_version, '<='))
                {
                    $notice .= '<span>';
                    $notice .= $this->markdown2html( $line );
                    $notice .= '</span>';

                }
            }

        }

        return $notice;
    }

    /*private function replace_readme_constants( $content, $response ) {
            $constants    = [ '{{ NEW VERSION }}', '{{ CURRENT VERSION }}', '{{ PHP VERSION }}', '{{ REQUIRED PHP VERSION }}' ];
            $replacements = [ $response->new_version, SHORTPIXEL_IMAGE_OPTIMISER_VERSION, PHP_VERSION, $response->requires_php ];

            return str_replace( $constants, $replacements, $content );
    } */

    private function markdown2html( $content ) {
        $patterns = [
            '/\*\*(.+)\*\*/U', // bold
            '/__(.+)__/U', // italic
            '/\[([^\]]*)\]\(([^\)]*)\)/U', // link
        ];

        $replacements = [
            '<strong>${1}</strong>',
            '<em>${1}</em>',
            '<a href="${2}" target="_blank">${1}</a>',
        ];

        $prepared_content = preg_replace( $patterns, $replacements, $content );

        return isset( $prepared_content ) ? $prepared_content : $content;
    }


} // class
