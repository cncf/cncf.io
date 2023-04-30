<?php

namespace ShortPixel\Controller;

use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;

class ApiController
{
    const STATUS_ENQUEUED = 10;
		const STATUS_PARTIAL_SUCCESS = 3;
		const STATUS_SUCCESS = 2;
		const STATUS_WAITING = 1;
    const STATUS_UNCHANGED = 0;
    const STATUS_ERROR = -1;
    const STATUS_FAIL = -2;
    const STATUS_QUOTA_EXCEEDED = -3;
    const STATUS_SKIP = -4;
    const STATUS_NOT_FOUND = -5;
    const STATUS_NO_KEY = -6;
   // const STATUS_RETRY = -7;
   // const STATUS_SEARCHING = -8; // when the Queue is looping over images, but in batch none were   found.
	 const STATUS_OPTIMIZED_BIGGER = -9;
	 const STATUS_CONVERTED = -10;


    const STATUS_QUEUE_FULL = -404;
    const STATUS_MAINTENANCE = -500;
		const STATUS_CONNECTION_ERROR = -503; // Not official, error connection in WP.
    const STATUS_NOT_API = -1000; // Not an API process, i.e restore / migrate. Don't handle as optimized

		// Moved these numbers higher to prevent conflict with STATUS
    const ERR_FILE_NOT_FOUND = -902;
    const ERR_TIMEOUT = -903;
    const ERR_SAVE = -904;
    const ERR_SAVE_BKP = -905;
    const ERR_INCORRECT_FILE_SIZE = -906;
    const ERR_DOWNLOAD = -907;
    const ERR_PNG2JPG_MEMORY = -908;
    const ERR_POSTMETA_CORRUPT = -909;
    const ERR_UNKNOWN = -999;

    const DOWNLOAD_ARCHIVE = 7;

    private static $instance;

    private $apiEndPoint;
    private $apiDumpEndPoint;

    protected static $temporaryFiles = array();
    protected static $temporaryDirs = array();

    public function __construct()
    {
      $settings = \wpSPIO()->settings();
      $this->apiEndPoint = $settings->httpProto . '://' . SHORTPIXEL_API . '/v2/reducer.php';
      $this->apiDumpEndPoint = $settings->httpProto . '://' . SHORTPIXEL_API . '/v2/cleanup.php';
    }


  public static function getInstance()
  {
     if (is_null(self::$instance))
       self::$instance = new ApiController();

      return self::$instance;
  }

  /*
  * @param Object $item Item of stdClass
  * @return Returns same Item with Result of request
  */
  public function processMediaItem($item, $imageObj)
  {
		 	if (! is_object($imageObj))
			{
				$item->result = $this->returnFailure(self::STATUS_FAIL, __('Item seems invalid, removed or corrupted.', 'shortpixel-image-optimiser'));
				return $item;
			}
		 	elseif (! $imageObj->isProcessable() || $imageObj->isOptimizePrevented() == true)
			{
					if ($imageObj->isOptimized())
					{
						 $item->result = $this->returnFailure(self::STATUS_FAIL, __('Item is already optimized', 'shortpixel-image-optimiser'));
						 return $item;
					}
					else {
						 $item->result = $this->returnFailure(self::STATUS_FAIL, __('Item is not processable and not optimized', 'shortpixel-image-optimiser'));
						 return $item;
					}
			}

      if (! is_array($item->urls) || count($item->urls) == 0)
      {
          $item->result = $this->returnFailure(self::STATUS_FAIL, __('No Urls given for this Item', 'shortpixel-image-optimiser'));
          return $item;
      }
			else { // if ok, urlencode them.
					$list = array();
				  foreach($item->urls as $url)
					{
							$parsed_url = parse_url($url);
							if (false !== $parsed_url)
							{
								  $url = str_replace($parsed_url['path'], urlencode($parsed_url['path']), $url);
							}
							$list[] = $url;
					}
					$item->urls = $list;
			}

      $requestArgs = array('urls' => $item->urls); // obligatory
      if (property_exists($item, 'compressionType'))
        $requestArgs['compressionType'] = $item->compressionType;
      $requestArgs['blocking'] =  ($item->tries == 0) ? false : true;
      $requestArgs['item_id'] = $item->item_id;
      $requestArgs['refresh'] = (property_exists($item, 'refresh') && $item->refresh) || $item->tries == 0 ? true : false;
      $requestArgs['flags'] = (property_exists($item, 'flags')) ? $item->flags : array();

			$requestArgs['paramlist']  = property_exists($item, 'paramlist') ? $item->paramlist : null;
			$requestArgs['returndatalist']  = property_exists($item, 'returndatalist') ? $item->returndatalist : null;

      $request = $this->getRequest($requestArgs);
      $item = $this->doRequest($item, $request);

			ResponseController::addData($item->item_id, 'images_total', count($item->urls));

			// If error has occured, but it's not related to connection.
			if ($item->result->is_error === true && $item->result->is_done === true)
			{
				 $this->dumpMediaItem($item); // item failed, directly dump anything from server.
			}

      return $item;
  }

	/* Ask to remove the items from the remote cache.
	  @param $item Must be object, with URLS set as array of urllist. - Secretly not a mediaItem - shame
	*/
	public function dumpMediaItem($item)
	{
     $settings = \wpSPIO()->settings();
     $keyControl = ApiKeyController::getInstance();

		 if (property_exists($item, 'urls') === false || ! is_array($item->urls) || count($item->urls) == 0)
		 {
			  Log::addWarn('Media Item without URLS cannnot be dumped ', $item);
				return false;
		 }

		 $request = $this->getRequest();

		 $request['body'] = json_encode(
			 			array(
                'plugin_version' => SHORTPIXEL_IMAGE_OPTIMISER_VERSION,
                'key' => $keyControl->forceGetApiKey(),
                'urllist' => $item->urls	)	, JSON_UNESCAPED_UNICODE);

		 Log::addDebug('Dumping Media Item ', $item->urls);

		 $ret = wp_remote_post($this->apiDumpEndPoint, $request);

     return $ret;

	}

  /** Former, prepare Request in API */
  private function getRequest($args = array())
  {
    $settings = \wpSPIO()->settings();
    $keyControl = ApiKeyController::getInstance();

    $defaults = array(
          'urls' => null,
					'paramlist' => null,
					'returndatalist' => null,
          'compressionType' => $settings->compressionType,
          'blocking' => true,
          'item_id' => null,
          'refresh' => false,
          'flags' => array(),
    );

    $args = wp_parse_args($args, $defaults);
    $convertTo = implode("|", $args['flags']);

    $requestParameters = array(
        'plugin_version' => SHORTPIXEL_IMAGE_OPTIMISER_VERSION,
        'key' => $keyControl->forceGetApiKey(),
        'lossy' => $args['compressionType'],
        'cmyk2rgb' => $settings->CMYKtoRGBconversion,
        'keep_exif' => ($settings->keepExif ? "1" : "0"),
        'convertto' => $convertTo,
        'resize' => $settings->resizeImages ? 1 + 2 * ($settings->resizeType == 'inner' ? 1 : 0) : 0,
        'resize_width' => $settings->resizeWidth,
        'resize_height' => $settings->resizeHeight,
        'urllist' => $args['urls'],
    );

		if (! is_null($args['paramlist']))
		{
			 $requestParameters['paramlist'] = $args['paramlist'];
		}

		if (! is_null($args['returndatalist']))
		{
			 $requestParameters['returndatalist'] = $args['returndatalist'];
		}


    if(/*false &&*/ $settings->downloadArchive == self::DOWNLOAD_ARCHIVE && class_exists('PharData')) {
        $requestParameters['group'] = $args['item_id'];
    }
    if($args['refresh']) { // @todo if previous status was ShortPixelAPI::ERR_INCORRECT_FILE_SIZE; then refresh.
        $requestParameters['refresh'] = 1;
    }

		$requestParameters = apply_filters('shortpixel/api/request', $requestParameters, $args['item_id']);


    $arguments = array(
        'method' => 'POST',
        'timeout' => 15,
        'redirection' => 3,
        'sslverify' => apply_filters('shortpixel/system/sslverify', true),
        'httpversion' => '1.0',
        'blocking' => $args['blocking'],
        'headers' => array(),
        'body' => json_encode($requestParameters, JSON_UNESCAPED_UNICODE),
        'cookies' => array()
    );
    //add this explicitely only for https, otherwise (for http) it slows down the request
    if($settings->httpProto !== 'https') {
        unset($arguments['sslverify']);
    }

    return $arguments;
  }


	/** DoRequest : Does a remote_post to the API
	*
	* @param Object $item  The QueueItemObject
	* @param Array $requestParameters  The HTTP parameters for the remote post (arguments in getRequest)
	*/
  protected function doRequest($item, $requestParameters )
  {
    $response = wp_remote_post($this->apiEndPoint, $requestParameters );
    Log::addDebug('ShortPixel API Request sent', $requestParameters['body']);

    //only if $Blocking is true analyze the response
    if ( $requestParameters['blocking'] )
    {
        if ( is_object($response) && get_class($response) == 'WP_Error' )
        {
            $errorMessage = $response->errors['http_request_failed'][0];
            $errorCode = self::STATUS_CONNECTION_ERROR;
            $item->result = $this->returnRetry($errorCode, $errorMessage);
        }
        elseif ( isset($response['response']['code']) && $response['response']['code'] <> 200 )
        {
            $errorMessage = $response['response']['code'] . " - " . $response['response']['message'];
            $errorCode = $response['response']['code'];
            $item->result = $this->returnFailure($errorCode, $errorMessage);
        }
        else
        {
           $item->result = $this->handleResponse($item, $response);
        }

    }
    else // This should be only non-blocking the FIRST time it's send off.
    {
			 if ($item->tries > 0)
			 {
			 		Log::addWarn('DOREQUEST sent item non-blocking with multiple tries!', $item);
			 }

			 $urls = count($item->urls);
			 $flags = property_exists($item, 'flags') ? $item->flags : array();
			 $flags = implode("|", $flags);
			 $text = sprintf(__('New item #%d sent for processing ( %d URLS %s)  ', 'shortpixel-image-optimiser'), $item->item_id, $urls, $flags );

       $item->result = $this->returnOK(self::STATUS_ENQUEUED, $text );
    }

    return $item;
  }

  private function parseResponse($response)
  {
    $data = $response['body'];

    $data = json_decode($data);
    return (array)$data;
  }

	/**
	*
	**/
  private function handleResponse($item, $response)
  {

    $APIresponse = $this->parseResponse($response);//get the actual response from API, its an array
    $settings = \wpSPIO()->settings();

		// Don't know if it's this or that.
		$status = false;
		if (isset($APIresponse['Status']))
		{
			$status = $APIresponse['Status'];
		}
		elseif(is_array($APIresponse) && isset($APIresponse[0]) && property_exists($APIresponse[0], 'Status'))
		{
			$status = $APIresponse[0]->Status;
		}
		elseif ( is_array($APIresponse)) // This is a workaround for some obscure PHP 5.6 bug. @todo Remove when dropping support PHP < 7.
		{
			 foreach($APIresponse as $key => $data)
			 {
				 // Running the whole array, because handleSuccess enums on key index as well :/
				 // we are not just looking for status here, but also replacing the whole array, because of obscure bug.
				  if (property_exists($data, 'Status'))
					{
						 if ($status === false)
						 {
						 	$status = $data->Status;
						 }
						 $APIresponse[$key] = $data; // reset it, so it can read the index.  This should be 0.
					}
			 }
		}

			if (isset($APIresponse['returndatalist']))
			{
				$returnDataList = (array) $APIresponse['returndatalist'];
				if (isset($returnDataList['sizes']) && is_object($returnDataList['sizes']))
					$returnDataList['sizes'] = (array) $returnDataList['sizes'];

				if (isset($returnDataList['doubles']) && is_object($returnDataList['doubles']))
						$returnDataList['doubles'] = (array) $returnDataList['doubles'];

				if (isset($returnDataList['duplicates']) && is_object($returnDataList['duplicates']))
							$returnDataList['duplicates'] = (array) $returnDataList['duplicates'];

				if (isset($returnDataList['fileSizes']) && is_object($returnDataList['fileSizes']))
										$returnDataList['fileSizes'] = (array) $returnDataList['fileSizes'];

				unset($APIresponse['returndatalist']);
			}
			else {
				$returnDataList = array();
			}

    // This is only set if something is up, otherwise, ApiResponse returns array
    if (is_object($status))
    {
        // Check for known errors. : https://shortpixel.com/api-docs
				Log::addDebug('Api Response Status :' . $status->Code  );
        switch($status->Code)
        {
              case -102: // Invalid URL
              case -105: // URL missing
              case -106: // Url is inaccessible
              case -113: // Too many inaccessible URLs
              case -201: // Invalid image format
              case -202: // Invalid image or unsupported format
              case -203: // Could not download file
                 return $this->returnFailure( self::STATUS_ERROR, $status->Message);
              break;
              case -403: // Quota Exceeded
              case -301: // The file is larger than remaining quota
									// legacy
                  @delete_option('bulkProcessingStatus');
									QuotaController::getInstance()->setQuotaExceeded();

                  return $this->returnRetry( self::STATUS_QUOTA_EXCEEDED, __('Quota exceeded.','shortpixel-image-optimiser'));
                  break;
							case -306:
									return $this->returnFailure( self::STATUS_FAIL, __('Files need to be from a single domain per request.', 'shortpixel-image-optimiser'));
							break;
              case -401: // Invalid Api Key
							case -402: // Wrong API key
                  return $this->returnFailure( self::STATUS_NO_KEY, $status->Message);
              break;
              case -404: // Maximum number in optimization queue (remote)
                  //return array("Status" => self::STATUS_QUEUE_FULL, "Message" => $APIresponse['Status']->Message);
                  return $this->returnRetry( self::STATUS_QUEUE_FULL, $status->Message);
              case -500: // API in maintenance.
                  //return array("Status" => self::STATUS_MAINTENANCE, "Message" => $APIresponse['Status']->Message);
                  return $this->returnRetry( self::STATUS_MAINTENANCE, $status->Message);
          }
    }

    $neededURLS = $item->urls; // URLS we are waiting for.

    if ( is_array($APIresponse) && isset($APIresponse[0]) ) //API returned image details
    {
				$analyze = array('total' => count($item->urls), 'ready' => 0, 'waiting' => 0);
				$waitingDebug = array();

				$imageList = array();
				$partialSuccess = false;
				$imageNames = array_keys($returnDataList['sizes']);
				$fileNames = array_values($returnDataList['sizes']);

				foreach($APIresponse as $index => $imageObject)
				{
						if (! property_exists($imageObject, 'Status'))
						{
							Log::addWarn('Result without Status', $imageObject);
							continue; // can't do nothing with that, probably not an image.
						}
						elseif ($imageObject->Status->Code == self::STATUS_UNCHANGED || $imageObject->Status->Code == self::STATUS_WAITING)
						{
							 $analyze['waiting']++;
							 $partialSuccess = true; // Not the whole job has been done.
						}
						elseif ($imageObject->Status->Code == self::STATUS_SUCCESS)
						{
							 $analyze['ready']++;
							 $imageName = $imageNames[$index];
							 $fileName = $fileNames[$index];
							 $data = array(
								 'fileName' => $fileName,
								 'imageName' => $imageName,
							 );

							 if (isset($returnDataList['fileSizes']))
							 {
								 $data['fileSize'] = $returnDataList['fileSizes'][$imageName];
							 }

							 if (! isset($item->files[$imageName]))
							 {
							 	$imageList[$imageName] = $this->handleNewSuccess($item, $imageObject, $data);
							 }
							 else {
							 }
						}

				}

				$imageData = array(
						'images_done' => $analyze['ready'],
						'images_waiting' => $analyze['waiting'],
						'images_total' => $analyze['total']
				);
				ResponseController::addData($item->item_id, $imageData);

				if (count($imageList) > 0)
				{
						$data = array(
							'files' => $imageList,
							'data' => $returnDataList,
						);
					  if (false === $partialSuccess)
						{
							return $this->returnSuccess($data, self::STATUS_SUCCESS, false);
						}
						else {
							return $this->returnSuccess($data, self::STATUS_PARTIAL_SUCCESS, false);
						}
				}
				elseif ($analyze['waiting'] > 0) {
					return $this->returnOK(self::STATUS_UNCHANGED, sprintf(__('Item is waiting', 'shortpixel-image-optimiser')));
				}
				else {
					// Theoretically this should not be needed.
					Log::addWarn('ApiController Response not handled before default case');
					if ( isset($APIresponse[0]->Status->Message) ) {

							$err = array("Status" => self::STATUS_FAIL, "Code" => (isset($APIresponse[0]->Status->Code) ? $APIresponse[0]->Status->Code : self::ERR_UNKNOWN),
													 "Message" => __('There was an error and your request was not processed.','shortpixel-image-optimiser')
																				. " (" . wp_basename($APIresponse[0]->OriginalURL) . ": " . $APIresponse[0]->Status->Message . ")");
							return $this->returnRetry($err['Code'], $err['Message']);
					} else {
							$err = array("Status" => self::STATUS_FAIL, "Message" => __('There was an error and your request was not processed.','shortpixel-image-optimiser'),
													 "Code" => (isset($APIresponse[0]->Status->Code) ? $APIresponse[0]->Status->Code : self::ERR_UNKNOWN));
							return $this->returnRetry($err['Code'], $err['Message']);
					}
				}

    } // ApiResponse[0]

    // If this code reaches here, something is wrong.
    if(!isset($APIresponse['Status'])) {

        Log::addError('API returned Unknown Status/Response ', $response);
        return $this->returnFailure(self::STATUS_FAIL,  __('Unrecognized API response. Please contact support.','shortpixel-image-optimiser'));

    } else {

      //sometimes the response array can be different
      if (is_numeric($APIresponse['Status']->Code)) {
          $message = $APIresponse['Status']->Message;
      } else {
          $message = $APIresponse[0]->Status->Message;
      }

			if (! isset($message) || is_null($message) || $message == '')
			{
				 $message = __('Unrecognized API message. Please contact support.','shortpixel-image-optimiser');
			}
      return $this->returnRetry(self::STATUS_FAIL, $message);
    } // else
  }
  // handleResponse function


	private function handleNewSuccess($item, $fileData, $data)
	{
			$compressionType = property_exists($item, 'compressionType') ? $item->compressionType : $settings->compressionType;
			//$savedSpace =  $originalSpace =  $optimizedSpace = $fileCount  = 0;

			$defaults = array(
					'fileName' => false,
					'imageName' => false,
					'fileSize' => false,
			);

			$data = wp_parse_args($data, $defaults);

			if (false === $data['fileName'] || false === $data['imageName'])
			{
				 Log::addError('Failure! HandleSuccess did not receive filename or imagename! ', $data);
				 Log::addError('Error Item:', $item);

				 return $this->returnFailure(self::STATUS_FAIL, __('Internal error, missing variables'));
			}

			$originalFileSize = (false === $data['fileSize']) ? intval($fileData->OriginalSize) : $data['fileSize'];

		 	$image = array(
				 'image' => array(
				 'url' => false,
				 'originalSize' => $originalFileSize,
				 'optimizedSize' => false,
				 'status' => self::STATUS_SUCCESS,
				  ),
					'webp' => array(
				 'url' => false,
				 'size' => false,
				 'status' => self::STATUS_SKIP,
			 		),
					'avif' => array(
				 'url' => false,
				 'size' => false,
				 'status' => self::STATUS_SKIP,
			 		),
			);

			$fileType = ($compressionType > 0) ? 'LossyURL' : 'LosslessURL';
			$fileSize = ($compressionType > 0) ? 'LossySize' : 'LosslessSize';

			$image['image']['url'] = $fileData->$fileType;
			$image['image']['optimizedSize']  = intval($fileData->$fileSize);

			// Don't download if the originalSize / OptimizedSize is the same ( same image ) . This can be non-opt result or it was not asked to be optimized( webp/avif only job i.e. )
			if ($image['image']['originalSize'] == $image['image']['optimizedSize'])
			{
				$image['image']['status'] = self::STATUS_UNCHANGED;
			}

			$checkFileSize = intval($fileData->$fileSize); // Size of optimized image to check against Avif/Webp

			if (false === $this->checkFileSizeMargin($originalFileSize, $checkFileSize))
			{
				 $image['image']['status'] = self::STATUS_OPTIMIZED_BIGGER;
				 $checkFileSize = $originalFileSize;
			}

			if (property_exists($fileData, "WebP" . $fileType))
			{
				$type = "WebP" . $fileType;
				$size = "WebP" . $fileSize;

				if ($fileData->$type != 'NA')
				{
						$image['webp']['url'] = $fileData->$type;
						$image['webp']['size'] = $fileData->$size;
						if (false === $this->checkFileSizeMargin($checkFileSize, $fileData->$size))
						{
							$image['webp']['status'] = self::STATUS_OPTIMIZED_BIGGER;
						}
						else {
							$image['webp']['status'] = self::STATUS_SUCCESS;
						}
				}
			}

			if (property_exists($fileData, "AVIF" . $fileType))
			{
				$type = "AVIF" . $fileType;
				$size = "AVIF" . $fileSize;

				if ($fileData->$type != 'NA')
				{
						$image['avif']['url'] = $fileData->$type;
						$image['avif']['size'] = $fileData->$size;
						if (false === $this->checkFileSizeMargin($checkFileSize, $fileData->$size))
						{
							$image['avif']['status'] = self::STATUS_OPTIMIZED_BIGGER;
						}
						else {
							$image['avif']['status'] = self::STATUS_SUCCESS;
						}
				}

			}

			return $image;
	}

  private function getResultObject()
  {
        $result = new \stdClass;
        $result->apiStatus = null;
        $result->message = '';
        $result->is_error = false;
        $result->is_done = false;
        //$result->errors = array();

        return $result;
  }

  private function returnFailure($status, $message)
  {
        $result = $this->getResultObject();
        $result->apiStatus = $status;
        $result->message = $message;
        $result->is_error = true;
        $result->is_done = true;

        return $result;  // fatal.
  }

  // Temporary Error, retry.
  private function returnRetry($status, $message)
  {

    $result = $this->getResultObject();
    $result->apiStatus = $status;
    $result->message = $message;

    //$result->errors[] = array('status' => $status, 'message' => $message);
    $result->is_error = true;

    return $result;
  }

  private function returnOK($status = self::STATUS_UNCHANGED, $message = false)
  {
      $result = $this->getResultObject();
      $result->apiStatus = $status;
      $result->is_error = false;
      $result->message = $message;

      return $result;
  }

  /** Returns a success status. This is succeseption, each file gives it's own status, bundled. */
  private function returnSuccess($file, $status = self::STATUS_SUCCESS, $message = false)
  {
      $result = $this->getResultObject();
      $result->apiStatus = $status;
      $result->message = $message;

			if (self::STATUS_SUCCESS === $status)
      	$result->is_done = true;

			if (is_array($file))
        $result->files = $file;
      else
        $result->file = $file; // this file is being used in imageModel

      return $result;
  }

	// If this returns false, the resultSize is bigger, thus should be oversize.
	private function checkFileSizeMargin($fileSize, $resultSize)
	{
			// This is ok.
			if ($fileSize >= $resultSize)
				return true;

			// Fine suppose, but crashes the increase
			if ($fileSize == 0)
				return true;

		  $percentage = apply_filters('shortpixel/api/filesizeMargin', 5);

			$increase = (($resultSize - $fileSize) / $fileSize) * 100;

			if ($increase <= $percentage)
				return true;

		  return false;
	}

} // class
