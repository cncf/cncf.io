<?php
namespace ShortPixel;
use ShortPixel\ShortPixelLogger\ShortPixelLogger as Log;
use ShortPixel\Notices\NoticeController as Notices;

// @todo Clean up unused lines in this file. (cloudflare)
class CloudFlareAPI {
    private $email; // $_cloudflareEmail
    private $authkey; // $_cloudflareAuthKey
    private $zone_id; // $_cloudflareZoneID
    private $token;

    private $setup_done = false;
    private $config_ok = false;
    private $use_token = false;

    private $cf_exists = true;

    private $api_url = 'https://api.cloudflare.com/client/v4/zones/';

    /*public function __construct($cloudflareEmail, $cloudflareAuthKey, $cloudflareZoneID) {
        $this->set_up($cloudflareEmail, $cloudflareAuthKey, $cloudflareZoneID);
        $this->set_up_required_hooks();
    } */

    public function __construct()
    {
        add_action('shortpixel/image/optimised', array( $this, 'check_cloudflare' ), 10 );
				add_action('shortpixel/image/before_restore', array($this, 'check_cloudflare'), 10);
    }


    public function setup()
    {
        $this->email =   \wpSPIO()->settings()->cloudflareEmail;
        $this->authkey = \wpSPIO()->settings()->cloudflareAuthKey;
        $this->zone_id =  (defined('SHORTPIXEL_CFZONE') ) ? SHORTPIXEL_CFZONE : \wpSPIO()->settings()->cloudflareZoneID;

        $this->token = (defined('SHORTPIXEL_CFTOKEN') ) ? SHORTPIXEL_CFTOKEN : \wpSPIO()->settings()->cloudflareToken;

        if (! empty($this->token) && ! empty($this->zone_id))
        {
          $this->use_token = true;
          $this->config_ok = true;
        }
        elseif(! empty($this->email) && ! empty($this->authkey) && ! empty($this->zone_id))
        {
          $this->config_ok = true;
        }

        if (empty($this->zone_id))
        {
          //Log::addWarn('CF - ZoneID setting is obligatory');
        }

        $this->setup_done = true;
    }

    public function check_cloudflare($imageObj)
    {
      if (! $this->setup_done)
        $this->setup();

      if ($this->config_ok)
      {
        if (! function_exists('curl_init'))
        {
          Log::addWarn('Cloudflare Config OK, but no CURL to request');
        }
        else
          $this->start_cloudflare_cache_purge_process($imageObj);
      }

    }

    /**
     * @desc Start the process of purging all cache for image URL (includes all the image sizes/thumbnails)f1
     *
     * @param $image_id - WordPress image media ID
     */
    private function start_cloudflare_cache_purge_process( $imageItem ) {


        // Fetch CloudFlare API credentials
        /*$cloudflare_auth_email = $this->_cloudflareEmail;
        $cloudflare_auth_key   = $this->_cloudflareAuthKey;
        $cloudflare_zone_id    = $this->_cloudflareZoneID; */

            // Fetch all WordPress install possible thumbnail sizes ( this will not return the full size option )
            $fetch_images_sizes   = get_intermediate_image_sizes();
            $purge_array  = array();
            $prepare_request_info = array();

            // if full image size tag is missing, we need to add it
            if ( ! in_array( 'full', $fetch_images_sizes ) ) {
                $fetch_images_sizes[] = 'full';
            }

/*
            if ( $imageItem->getType() == 'media' ) {
                // The item is a Media Library item, fetch the URL for each image size
                foreach ( $fetch_images_sizes as $size ) {
                    // 0 - url; 1 - width; 2 - height
                    $image_attributes = wp_get_attachment_image_src( $image_id, $size );
                    // Append to the list
                    array_push( $purge_array, $image_attributes[0] );
                }
            } else {
                // The item is a Custom Media item
                $fs = \wpSPIO()->filesystem();
                $item = $fs->getImage( $image_id, 'custom' );
                $item_url = $fs->pathToUrl( $item );
                array_push( $purge_array, $item_url );
            }
			*/
						$fs = \wpSPIO()->filesystem();

						$image_paths[] = $imageItem->getURL();
						if ($imageItem->getWebp() !== false)
							 $image_paths[] = $fs->pathToUrl($imageItem->getWebp());

						if ($imageItem->getAvif() !== false)
 								 $image_paths[] = $fs->pathToUrl($imageItem->getAvif());

					  if ($imageItem->get('type') == 'media')
						{
								if ($imageItem->hasOriginal())
								{
									 $originalFile = $imageItem->getOriginalFile();
									 $image_paths[] = $originalFile->getURL();

									 if ($originalFile->getWebp() !== false)
		 								 $image_paths[] = $fs->pathToUrl($originalFile->getWebp());

		 							if ($originalFile->getAvif() !== false)
			 								 $image_paths[] = $fs->pathToUrl($originalFile->getAvif());
								}

								if (count($imageItem->get('thumbnails')) > 0)
								{
									 foreach($imageItem->get('thumbnails') as $thumbObj)
									 {
											 $image_paths[] = $thumbObj->getURL();

											 if ($thumbObj->getWebp() !== false)
												 $image_paths[] = $fs->pathToUrl($thumbObj->getWebp());

											if ($thumbObj->getAvif() !== false)
													 $image_paths[] = $fs->pathToUrl($thumbObj->getAvif());
									 }
								}
						}

            if ( ! empty( $image_paths ) ) {
              //$prepare_request_info['files'] = $image_url_for_purge;
                // Encode the data into JSON before send
                $dispatch_purge_info = function_exists('wp_json_encode') ? wp_json_encode( $prepare_request_info ) : json_encode( $prepare_request_info );

                // Set headers for remote API to authenticate for the request
      /*          $dispatch_header = array(
                    'X-Auth-Email: ' . $cloudflare_auth_email,
                    'X-Auth-Key: ' . $cloudflare_auth_key,
                    'Content-Type: application/json'
                ); */

                $response = $this->delete_url_cache_request_action($image_paths);

                // Start the process of cache purge
            /*    $request_response = $this->delete_url_cache_request_action( "https://api.cloudflare.com/client/v4/zones/" . $cloudflare_zone_id . "/purge_cache", $dispatch_purge_info, $dispatch_header ); */


            } else {
                // No use in running the process
            }
    }

    /**
     * @desc Send a delete cache request to CloudFlare for specified URL(s)
     * Implements -> https://api.cloudflare.com/#zone-purge-files-by-url
     * @return array|mixed|object - Request response as decoded JSON
     */
    private function delete_url_cache_request_action( $files ) {
        $request_url = $this->api_url . $this->zone_id . '/purge_cache';
        $postfields = array('files' => $files);

        return $this->doRequest($request_url, $postfields);
    }

    private function addAuth($headers)
    {
        if ($this->use_token)
        {
          $headers['authorization'] = 'Authorization: Bearer ' . $this->token;
        }
        else
        {
          $headers['x-auth-email'] = 'X-Auth-Email: ' . $this->email;
          $headers['x-auth-key'] = 'X-Auth-Key: ' . $this->authkey;
        }

        return $headers;

    }


    /**
    * @param $url String . Api Url to target with zone_id and acton
    * @param $postfields Array . Fields for POST
    * @param $headers Valid HTTP headers to add.
    */
    private function doRequest($url, $postfields, $headers = array())
    {
      if(!function_exists('curl_init'))
      { return false; }

      $curl_connection = curl_init();

      $default_headers =
        array('content_type' => 'Content-Type: application/json');

      $default_headers = $this->addAuth($default_headers);

      $headers = wp_parse_args($headers, $default_headers);
      $headers = array_filter(array_values($headers));

      $postfields = wp_json_encode($postfields);

      curl_setopt( $curl_connection, CURLOPT_URL, $url );
      curl_setopt( $curl_connection, CURLOPT_CUSTOMREQUEST, "POST" );
      curl_setopt( $curl_connection, CURLOPT_POSTFIELDS, $postfields);
      curl_setopt( $curl_connection, CURLOPT_RETURNTRANSFER, true );
      curl_setopt( $curl_connection, CURLOPT_HTTPHEADER, $headers );
      curl_setopt( $curl_connection, CURLOPT_CONNECTTIMEOUT, 5);  // in seconds!
      curl_setopt( $curl_connection, CURLOPT_TIMEOUT, 10); // in seconds!
      curl_setopt( $curl_connection, CURLOPT_USERAGENT, '"User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.87 Safari/537.36"' );

      $request_response = curl_exec( $curl_connection );
      $result           = json_decode( $request_response, true );
      curl_close( $curl_connection );

      if ( ! is_array( $result ) ) {
          Log::addWarn( 'ShortPixel - CloudFlare: The CloudFlare API is not responding correctly', $result);
      } elseif ( isset( $result['success'] ) && isset( $result['errors'] ) && false === (bool) $result['success'] ) {
          Log::addWarn( 'ShortPixel - CloudFlare, Error messages: '
              . (isset($result['errors']['message']) ? $result['errors']['message'] : json_encode($result['errors'])) );
      } else {
          Log::addInfo('ShortPixel - CloudFlare successfully requested clear cache for: ', array($postfields));
      }

      return $result;
    }
}

$c = new CloudFlareAPI();  // monitor hook.
