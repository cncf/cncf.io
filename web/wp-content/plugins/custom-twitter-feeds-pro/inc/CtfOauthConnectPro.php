<?php

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

class CtfOauthConnectPro extends CtfOauthConnect
{
    /**
     * Sets the complete url for our API endpoint. GET fields will be added later
     */
    public function setUrlBase()
    {
        switch ( $this->feed_type ) {
            case "hometimeline":
                $this->base_url = 'https://api.twitter.com/1.1/statuses/home_timeline.json';
                break;
            case "search":
                $this->base_url = 'https://api.twitter.com/1.1/search/tweets.json';
                break;
	        case "hashtag":
		        $this->base_url = 'https://api.twitter.com/1.1/search/tweets.json';
		        break;
            case "mentionstimeline":
                $this->base_url = 'https://api.twitter.com/1.1/statuses/mentions_timeline.json';
                break;
	        case "lists":
		        $this->base_url = 'https://api.twitter.com/1.1/lists/statuses.json';
		        break;
	        case "listsmeta":
		        $this->base_url = 'https://api.twitter.com/1.1/lists/list.json';
		        break;
	        case "accountlookup":
	        	$this->base_url = 'https://api.twitter.com/1.1/account/verify_credentials.json';
	        	break;
	        case "userslookup":
		        $this->base_url = 'https://api.twitter.com/1.1/users/lookup.json';
		        break;
            default:
                $this->base_url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
        }
    }
}