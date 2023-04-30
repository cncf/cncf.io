<?php
namespace ShortPixel\Controller;


use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;

class QuotaController
{
    protected static $instance;
    const CACHE_NAME = 'quotaData';


    protected $quotaData;


    public function __construct()
    {

    }

    public static function getInstance()
    {
      if (is_null(self::$instance))
        self::$instance = new QuotaController();

      return self::$instance;
    }

    public function hasQuota()
    {
      $settings = \wpSPIO()->settings();

      if ($settings->quotaExceeded)
			{
        return false;
			}
      return true;

    }

    protected function getQuotaData()
    {
        if (! is_null($this->quotaData))
          return $this->quotaData;

        $cache = new CacheController();

        $cacheData = $cache->getItem(self::CACHE_NAME);

        if (! $cacheData->exists() )
        {
            $quotaData = $this->getRemoteQuota();
						if (! $this->hasQuota())
							$timeout = MINUTE_IN_SECONDS;
						else {
							$timeout = HOUR_IN_SECONDS;
						}
            $cache->storeItem(self::CACHE_NAME, $quotaData, $timeout);
        }
        else
				{
          $quotaData = $cacheData->getValue();
				}

        return $quotaData;
    }

    public function getQuota()
    {

          $quotaData = $this->getQuotaData();
          $DateNow = time();

          $DateSubscription = strtotime($quotaData['APILastRenewalDate']);
          $DaysToReset =  30 - ( (int) (  ( $DateNow  - $DateSubscription) / 84600) % 30);

          $quota = (object) [
              'unlimited' => isset($quotaData['Unlimited']) ? $quotaData['Unlimited'] : false,
              'monthly' => (object) [
                'text' =>  sprintf(__('%s/month', 'shortpixel-image-optimiser'), $quotaData['APICallsQuota']),
                'total' =>  $quotaData['APICallsQuotaNumeric'],
                'consumed' => $quotaData['APICallsMadeNumeric'],
                'remaining' => max($quotaData['APICallsQuotaNumeric'] - $quotaData['APICallsMadeNumeric'], 0),
                'renew' => $DaysToReset,
              ],
              'onetime' => (object) [
                'text' => $quotaData['APICallsQuotaOneTime'],
                'total' => $quotaData['APICallsQuotaOneTimeNumeric'],
                'consumed' => $quotaData['APICallsMadeOneTimeNumeric'],
                'remaining' => $quotaData['APICallsQuotaOneTimeNumeric'] - $quotaData['APICallsMadeOneTimeNumeric'],
              ],
          ];

          $quota->total = (object) [
              'total' => $quota->monthly->total + $quota->onetime->total,
              'consumed'  => $quota->monthly->consumed + $quota->onetime->consumed,
              'remaining' =>$quota->monthly->remaining + $quota->onetime->remaining,
          ];


          return $quota;
    }

    public function getAvailableQuota()
    {
        $quota = $this->getQuota();

        /*max(0, $quotaData['APICallsQuotaNumeric'] + $quotaData['APICallsQuotaOneTimeNumeric'] - $quotaData['APICallsMadeNumeric'] - $quotaData['APICallsMadeOneTimeNumeric']))); */

        return $quota->total->remaining;
    }

    public function forceCheckRemoteQuota()
    {
        $cache = new CacheController();
        $cacheData = $cache->getItem(self::CACHE_NAME);
        $cacheData->delete();
        $this->quotaData = null;

       //$this->getRemoteQuota();
    }


    public function remoteValidateKey($key)
    {
			  // Remove the cache before checking.
				$this->forceCheckRemoteQuota();
        return $this->getRemoteQuota($key, true);
    }

		/**
		* Function should be called when plugin detects the remote quota has been exceeded
		*/
		public function setQuotaExceeded()
		{
			  $settings = \wpSPIO()->settings();
				$settings->quotaExceeded = 1;
				$this->forceCheckRemoteQuota(); // remove the previous cache.
		}


    private function resetQuotaExceeded()
    {
        $settings = \wpSPIO()->settings();

        AdminNoticesController::resetAPINotices();

				// Only reset after a quotaExceeded situation, otherwise it keeps popping.
				if ($settings->quotaExceeded == 1)
				{
						AdminNoticesController::resetQuotaNotices();
				}
				Log::addDebug('Reset Quota Exceeded and reset Notices');
       	$settings->quotaExceeded = 0;
    }



    private function getRemoteQuota($apiKey = false, $validate = false)
    {
        if (! $apiKey && ! $validate) // validation is done by apikeymodel, might result in a loop.
        {
          $keyControl = ApiKeyController::getInstance();
          $apiKey = $keyControl->forceGetApiKey();
        }


        $settings = \wpSPIO()->settings();

          if($settings->httpProto != 'https' && $settings->httpProto != 'http') {
              $settings->httpProto = 'https';
          }

          $requestURL = $settings->httpProto . '://' . SHORTPIXEL_API . '/v2/api-status.php';
          $args = array(
              'timeout'=> 15, // wait for 15 secs.
              'body' => array('key' => $apiKey)
          );
          $argsStr = "?key=".$apiKey;

					$serverAgent = isset($_SERVER['HTTP_USER_AGENT']) ? urlencode(sanitize_text_field(wp_unslash($_SERVER['HTTP_USER_AGENT']))) : '';
          $args['body']['useragent'] = "Agent" . $serverAgent;
          $argsStr .= "&useragent=Agent".$args['body']['useragent'];

          // Only used for keyValidation
          if($validate) {

              $statsController = StatsController::getInstance();
              $imageCount = $statsController->find('media', 'itemsTotal');
              $thumbsCount = $statsController->find('media', 'thumbsTotal');

              $args['body']['DomainCheck'] = get_site_url();
              $args['body']['Info'] = get_bloginfo('version') . '|' . phpversion();
              $args['body']['ImagesCount'] = $imageCount; //$imageCount['mainFiles'];
              $args['body']['ThumbsCount'] = $thumbsCount; // $imageCount['totalFiles'] - $imageCount['mainFiles'];
              $argsStr .= "&DomainCheck={$args['body']['DomainCheck']}&Info={$args['body']['Info']}&ImagesCount=$imageCount&ThumbsCount=$thumbsCount";


          }

          $args['body']['host'] = parse_url(get_site_url(),PHP_URL_HOST);
          $argsStr .= "&host={$args['body']['host']}";
					if (defined('SHORTPIXEL_HTTP_AUTH_USER') && defined('SHORTPIXEL_HTTP_AUTH_PASSWORD'))
					{
						$args['body']['user'] = stripslashes(SHORTPIXEL_HTTP_AUTH_USER);
						$args['body']['pass'] = stripslashes(SHORTPIXEL_HTTP_AUTH_PASSWORD);
						$argsStr .= '&user=' . urlencode($args['body']['user']) . '&pass=' . urlencode($args['body']['pass']);
					}
          elseif(! is_null($settings->siteAuthUser) && strlen($settings->siteAuthUser)) {

              $args['body']['user'] = stripslashes($settings->siteAuthUser);
              $args['body']['pass'] = stripslashes($settings->siteAuthPass);
              $argsStr .= '&user=' . urlencode($args['body']['user']) . '&pass=' . urlencode($args['body']['pass']);
          }
          if($settings !== false) {
              $args['body']['Settings'] = $settings;
          }

          $time = microtime(true);
          $comm = array();

          //Try first HTTPS post. add the sslverify = false if https
          if($settings->httpProto === 'https') {
              $args['sslverify'] = apply_filters('shortpixel/system/sslverify', true);
          }

          $response = wp_remote_post($requestURL, $args);

          $comm['A: ' . (number_format(microtime(true) - $time, 2))] = array("sent" => "POST: " . $requestURL, "args" => $args, "received" => $response);

          //some hosting providers won't allow https:// POST connections so we try http:// as well
          if(is_wp_error( $response )) {

              $requestURL = $settings->httpProto == 'https' ?
                  str_replace('https://', 'http://', $requestURL) :
                  str_replace('http://', 'https://', $requestURL);
              // add or remove the sslverify
              if($settings->httpProto === 'https') {
                  $args['sslverify'] = apply_filters('shortpixel/system/sslverify', true);
              } else {
                  unset($args['sslverify']);
              }
              $response = wp_remote_post($requestURL, $args);
              $comm['B: ' . (number_format(microtime(true) - $time, 2))] = array("sent" => "POST: " . $requestURL, "args" => $args, "received" => $response);

              if(!is_wp_error( $response )){
                  $settings->httpProto = ($settings->httpProto == 'https' ? 'http' : 'https');
              } else {
              }
          }
          //Second fallback to HTTP get
          if(is_wp_error( $response )){
              $args['body'] = null;
              $requestURL .= $argsStr;
              $response = wp_remote_get($requestURL, $args);
              $comm['C: ' . (number_format(microtime(true) - $time, 2))] = array("sent" => "POST: " . $requestURL, "args" => $args, "received" => $response);
          }
          Log::addInfo("API STATUS COMM: " . json_encode($comm));

          $defaultData = array(
              "APIKeyValid" => false,
              "Message" => __('API Key could not be validated due to a connectivity error.<BR>Your firewall may be blocking us. Please contact your hosting provider and ask them to allow connections from your site to api.shortpixel.com (IP 176.9.21.94).<BR> If you still cannot validate your API Key after this, please <a href="https://shortpixel.com/contact" target="_blank">contact us</a> and we will try to help. ','shortpixel-image-optimiser'),
              "APICallsMade" => __('Information unavailable. Please check your API key.','shortpixel-image-optimiser'),
              "APICallsQuota" => __('Information unavailable. Please check your API key.','shortpixel-image-optimiser'),
              "APICallsMadeOneTime" => 0,
              "APICallsQuotaOneTime" => 0,
              "APICallsMadeNumeric" => 0,
              "APICallsQuotaNumeric" => 0,
              "APICallsMadeOneTimeNumeric" => 0,
              "APICallsQuotaOneTimeNumeric" => 0,
              "APICallsRemaining" => 0,
              "APILastRenewalDate" => 0,
              "DomainCheck" => 'NOT Accessible');
          $defaultData = is_array($settings->currentStats) ? array_merge( $settings->currentStats, $defaultData) : $defaultData;

          if(is_object($response) && get_class($response) == 'WP_Error') {

              $urlElements = parse_url($requestURL);
              $portConnect = @fsockopen($urlElements['host'],8,$errno,$errstr,15);
              if(!$portConnect) {
                  $defaultData['Message'] .= "<BR>Debug info: <i>$errstr</i>";
              }
              return $defaultData;
          }

          if($response['response']['code'] != 200) {
             return $defaultData;
          }

          $data = $response['body'];
          $data = json_decode($data);

          if(empty($data)) { return $defaultData; }

          if($data->Status->Code != 2) {
              $defaultData['Message'] = $data->Status->Message;
              return $defaultData;
          }

          $dataArray = array(
              "APIKeyValid" => true,
              "APICallsMade" => number_format($data->APICallsMade) . __(' credits','shortpixel-image-optimiser'),
              "APICallsQuota" => number_format($data->APICallsQuota) . __(' credits','shortpixel-image-optimiser'),
              "APICallsMadeOneTime" => number_format($data->APICallsMadeOneTime) . __(' credits','shortpixel-image-optimiser'),
              "APICallsQuotaOneTime" => number_format($data->APICallsQuotaOneTime) . __(' credits','shortpixel-image-optimiser'),
              "APICallsMadeNumeric" => (int) max($data->APICallsMade, 0),
              "APICallsQuotaNumeric" => (int) max($data->APICallsQuota, 0),
              "APICallsMadeOneTimeNumeric" =>  (int) max($data->APICallsMadeOneTime, 0),
              "APICallsQuotaOneTimeNumeric" => (int) max($data->APICallsQuotaOneTime, 0),

              "Unlimited" => (property_exists($data, 'Unlimited') && $data->Unlimited == 'true') ? true : false,

              "APILastRenewalDate" => $data->DateSubscription,
              "DomainCheck" => (isset($data->DomainCheck) ? $data->DomainCheck : null)
          );
					 // My Eyes!  Basically :  ApiCalls - ApiCalls used, both for monthly and onetime. Max of each is 0.  Negative quota seems possible, but should not be substracted from one or the other.
					 $dataArray["APICallsRemaining"] = max($dataArray['APICallsQuotaNumeric'] - $dataArray['APICallsMadeNumeric'], 0) + max($dataArray['APICallsQuotaOneTimeNumeric'] - $dataArray['APICallsMadeOneTimeNumeric'],0);

					//reset quota exceeded flag -> user is allowed to process more images.

          if ( $dataArray['APICallsRemaining'] > 0 || $dataArray['Unlimited'])
					{
              $this->resetQuotaExceeded();
					}
          else
					{
							//activate quota limiting
              $this->setQuotaExceeded();
					}

          Log::addDebug('GetQuotaInformation Result ', $dataArray);
          return $dataArray;
    }

}
