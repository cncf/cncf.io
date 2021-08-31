<div id="ctf-admin" class="wrap">
	<?php do_action( 'ctf_admin_overview_before_title' ); ?>

    <h1>Custom Twitter Feeds</h1>
    <?php
    // this controls which view is included based on the selected tab
    if ( ! isset ( $tab ) ) {
        $tab = isset( $_GET["tab"] ) ? $_GET["tab"] : '';
    }
    $active_tab = CtfAdmin::get_active_tab( $tab );
    ?>
    <?php ctf_expiration_notice(); ?>

    <!-- Display the tabs along with styling for the 'active' tab -->
    <h2 class="nav-tab-wrapper">
        <a href="admin.php?page=custom-twitter-feeds&tab=configure" class="nav-tab <?php if ( $active_tab == 'configure' ){ echo 'nav-tab-active'; } ?>"><?php _e( '1. Configure', 'ctf' ); ?></a>
        <a href="admin.php?page=custom-twitter-feeds&tab=customize" class="nav-tab <?php if ( $active_tab == 'customize' ){ echo 'nav-tab-active'; } ?>"><?php _e( '2. Customize', 'ctf' ); ?></a>
        <a href="admin.php?page=custom-twitter-feeds&tab=style" class="nav-tab <?php if ( $active_tab == 'style' ){ echo 'nav-tab-active'; } ?>"><?php _e( '3. Style', 'ctf' ); ?></a>
        <a href="admin.php?page=custom-twitter-feeds&tab=display" class="nav-tab <?php if ( $active_tab == 'display' ){ echo 'nav-tab-active'; } ?>"><?php _e( '4. Display Your Feed', 'ctf' ); ?></a>
        <a href="admin.php?page=custom-twitter-feeds&tab=support" class="nav-tab <?php if ( $active_tab == 'support' ){ echo 'nav-tab-active'; } ?>"><?php _e( 'Support', 'ctf' ); ?></a>
        <a href="admin.php?page=custom-twitter-feeds-license" class="nav-tab <?php if ( $active_tab == 'license' ){ echo 'nav-tab-active'; } ?>"><?php _e( 'License', 'ctf' ); ?></a>
	    <?php if( ! is_plugin_active('social-wall/social-wall.php') ){ ?>
            <a href="admin.php?page=custom-twitter-feeds-sw" class="nav-tab"><?php _e('Create a Social Wall'); ?><span class="ctf-alert-bubble">New</span></a>
	    <?php } ?>
    </h2>
    <?php

    function ctf_expiration_notice(){
        //If the user is re-checking the license key then use the API below to recheck it
        ( isset( $_GET['ctfchecklicense'] ) ) ? $ctf_check_license = true : $ctf_check_license = false;

        $ctf_license = trim( get_option( 'ctf_license_key' ) );

        //If there's no license key then don't do anything
        if( empty($ctf_license) || !isset($ctf_license) && !$ctf_check_license ) return;

        //Is there already license data in the db?
        if( get_option( 'ctf_license_data' ) && !$ctf_check_license ){
            //Yes
            //Get license data from the db and convert the object to an array
            $ctf_license_data = (array) get_option( 'ctf_license_data' );
        } else {
            //No
            // data to send in our API request
            $ctf_api_params = array(
                'edd_action'=> 'check_license',
                'license'   => $ctf_license,
                'item_name' => urlencode( CTF_PRODUCT_NAME ) // the name of our product in EDD
            );

            // Call the custom API.
            $ctf_response = wp_remote_get( add_query_arg( $ctf_api_params, CTF_STORE_URL ), array( 'timeout' => 60, 'sslverify' => false ) );

            // decode the license data
            $ctf_license_data = (array) json_decode( wp_remote_retrieve_body( $ctf_response ) );

            //Store license data in db
            update_option( 'ctf_license_data', $ctf_license_data );
            
        }

        //Number of days until license expires
        $ctf_license_expires_date = isset( $ctf_license_data['expires'] ) ? $ctf_license_data['expires'] : $ctf_license_expires_date = '2036-12-31 23:59:59'; //If expires param isn't set yet then set it to be a date to avoid PHP notice
        if( $ctf_license_expires_date == 'lifetime' ) $ctf_license_expires_date = '2036-12-31 23:59:59';
        $ctf_todays_date = date('Y-m-d');
        $ctf_interval = round(abs(strtotime($ctf_todays_date . ' -1 day')-strtotime($ctf_license_expires_date))/86400); //-1 day to make sure auto-renewal has run before showing expired

        //Is license expired?
        if( $ctf_interval == 0 || strtotime($ctf_license_expires_date) < strtotime($ctf_todays_date) ){

            //If we haven't checked the API again one last time before displaying the expired notice then check it to make sure the license hasn't been renewed
            if( get_option( 'ctf_check_license_api_when_expires' ) == FALSE || get_option( 'ctf_check_license_api_when_expires' ) == 'true' ){

                // Check the API
                $ctf_api_params = array(
                    'edd_action'=> 'check_license',
                    'license'   => $ctf_license,
                    'item_name' => urlencode( CTF_PRODUCT_NAME ) // the name of our product in EDD
                );
                $ctf_response = wp_remote_get( add_query_arg( $ctf_api_params, CTF_STORE_URL ), array( 'timeout' => 60, 'sslverify' => false ) );
                $ctf_license_data = (array) json_decode( wp_remote_retrieve_body( $ctf_response ) );

                //Check whether it's active
                if( $ctf_license_data['license'] !== 'expired' && ( strtotime( $ctf_license_data['expires'] ) > strtotime($ctf_todays_date) ) ){
                    $ctf_license_expired = false;
                } else {
                    $ctf_license_expired = true;
                    //Set a flag so it doesn't check the API again until the next time it expires
                    update_option( 'ctf_check_license_api_when_expires', 'false' );
                }

                //Store license data in db
                update_option( 'ctf_license_data', $ctf_license_data );

            } else {
                //Display the expired notice
                $ctf_license_expired = true;
            }

        } else {
            $ctf_license_expired = false;

            //License is not expired so change the check_api setting to be true so the next time it expires it checks again
            update_option( 'ctf_check_license_api_when_expires', 'true' );
        }

        //If expired date is returned as 1970 (or any other 20th century year) then it means that the correct expired date was not returned and so don't show the renewal notice
        if( $ctf_license_expires_date[0] == '1' ) $ctf_license_expired = false;

        //If there's no expired date then don't show the expired notification
        if( empty($ctf_license_expires_date) || !isset($ctf_license_expires_date) ) $ctf_license_expired = false;

        //Is license missing - ie. on very first check
        if( isset($ctf_license_data['error']) ){
            if( $ctf_license_data['error'] == 'missing' ) $ctf_license_expired = false;
        }

        //If license expires in less than 30 days and it isn't currently expired then show the expire countdown instead of the expiration notice
        if($ctf_interval < 30 && !$ctf_license_expired){
            $ctf_expire_countdown = true;
        } else {
            $ctf_expire_countdown = false;
        }

        //Check whether it was purchased after subscriptions were introduced
        if( isset($ctf_license_data['payment_id']) && intval($ctf_license_data['payment_id']) > 762729 ){
            //Is likely to be renewed on a subscription so don't show countdown
            $ctf_expire_countdown = false;
        }

        //Is the license expired?
        if( ($ctf_license_expired || $ctf_expire_countdown) || $ctf_check_license ) {

            $ctf_expired_box_msg = '<svg style="width:16px;height:16px;" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="exclamation-triangle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="svg-inline--fa fa-exclamation-triangle fa-w-18 fa-2x"><path fill="currentColor" d="M569.517 440.013C587.975 472.007 564.806 512 527.94 512H48.054c-36.937 0-59.999-40.055-41.577-71.987L246.423 23.985c18.467-32.009 64.72-31.951 83.154 0l239.94 416.028zM288 354c-25.405 0-46 20.595-46 46s20.595 46 46 46 46-20.595 46-46-20.595-46-46-46zm-43.673-165.346l7.418 136c.347 6.364 5.609 11.346 11.982 11.346h48.546c6.373 0 11.635-4.982 11.982-11.346l7.418-136c.375-6.874-5.098-12.654-11.982-12.654h-63.383c-6.884 0-12.356 5.78-11.981 12.654z" class=""></path></svg>';

            //If expire countdown then add the countdown class to the notice box
            if($ctf_expire_countdown){
                $ctf_expired_box_classes = "ctf-license-expired ctf-license-countdown";
                $ctf_expired_box_msg .= "Hey ".$ctf_license_data["customer_name"].", your Custom Twitter Feeds Pro license key expires in " . $ctf_interval . " days.";
            } else {
                $ctf_expired_box_classes = "ctf-license-expired";
                $ctf_expired_box_msg .= "<b>Important: Your Custom Twitter Feeds Pro license key has expired.</b><br /><span>You are no longer receiving updates that protect you against upcoming Twitter changes.</span>";
            }

            //Create the re-check link using the existing query string in the URL
            $ctf_url = '?' . $_SERVER["QUERY_STRING"];
            //Determine the separator
            ( !empty($ctf_url) && $ctf_url != '' ) ? $separator = '&' : $separator = '';
            //Add the param to check license if it doesn't already exist in URL
            if( strpos($ctf_url, 'ctfchecklicense') === false ) $ctf_url .= $separator . "ctfchecklicense=true";

            //Create the notice message
            $ctf_expired_box_msg .= " &nbsp;<a href='https://smashballoon.com/checkout/?edd_license_key=".$ctf_license."&download_id=".CTF_PRODUCT_ID."&utm_source=plugin-pro&utm_campaign=ctf&utm_medium=expired-notice-settings' target='_blank' class='button button-primary'>Renew License</a><a href='javascript:void(0);' id='ctf-why-renew-show' onclick='ctfShowReasons()' class='button button-secondary'>Why renew?</a><a href='javascript:void(0);' id='ctf-why-renew-hide' onclick='ctfHideReasons()' class='button button-secondary' style='display: none;'>Hide text</a> <a href='".$ctf_url."' class='button button-secondary'>Re-check License</a></p>
            <div id='ctf-why-renew' style='display: none;'>
                <h4><svg style='width:16px;height:16px;' aria-hidden='true' focusable='false' data-prefix='fas' data-icon='shield-check' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' class='svg-inline--fa fa-shield-check fa-w-16 fa-2x' data-ce-key='470'><path fill='currentColor' d='M466.5 83.7l-192-80a48.15 48.15 0 0 0-36.9 0l-192 80C27.7 91.1 16 108.6 16 128c0 198.5 114.5 335.7 221.5 380.3 11.8 4.9 25.1 4.9 36.9 0C360.1 472.6 496 349.3 496 128c0-19.4-11.7-36.9-29.5-44.3zm-47.2 114.2l-184 184c-6.2 6.2-16.4 6.2-22.6 0l-104-104c-6.2-6.2-6.2-16.4 0-22.6l22.6-22.6c6.2-6.2 16.4-6.2 22.6 0l70.1 70.1 150.1-150.1c6.2-6.2 16.4-6.2 22.6 0l22.6 22.6c6.3 6.3 6.3 16.4 0 22.6z' class='' data-ce-key='471'></path></svg>Protected Against All Upcoming Twitter Platform Updates and API Changes</h4>
                <p>You currently don't need to worry about your Twitter feeds breaking due to constant changes to the Twitter platform. You are currently protected by access to continual plugin updates, giving you peace of mind that the software will always be up to date.</p>

                <h4><svg style='width:16px;height:16px;' aria-hidden='true' focusable='false' data-prefix='fab' data-icon='wordpress' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' class='svg-inline--fa fa-wordpress fa-w-16 fa-2x'><path fill='currentColor' d='M61.7 169.4l101.5 278C92.2 413 43.3 340.2 43.3 256c0-30.9 6.6-60.1 18.4-86.6zm337.9 75.9c0-26.3-9.4-44.5-17.5-58.7-10.8-17.5-20.9-32.4-20.9-49.9 0-19.6 14.8-37.8 35.7-37.8.9 0 1.8.1 2.8.2-37.9-34.7-88.3-55.9-143.7-55.9-74.3 0-139.7 38.1-177.8 95.9 5 .2 9.7.3 13.7.3 22.2 0 56.7-2.7 56.7-2.7 11.5-.7 12.8 16.2 1.4 17.5 0 0-11.5 1.3-24.3 2l77.5 230.4L249.8 247l-33.1-90.8c-11.5-.7-22.3-2-22.3-2-11.5-.7-10.1-18.2 1.3-17.5 0 0 35.1 2.7 56 2.7 22.2 0 56.7-2.7 56.7-2.7 11.5-.7 12.8 16.2 1.4 17.5 0 0-11.5 1.3-24.3 2l76.9 228.7 21.2-70.9c9-29.4 16-50.5 16-68.7zm-139.9 29.3l-63.8 185.5c19.1 5.6 39.2 8.7 60.1 8.7 24.8 0 48.5-4.3 70.6-12.1-.6-.9-1.1-1.9-1.5-2.9l-65.4-179.2zm183-120.7c.9 6.8 1.4 14 1.4 21.9 0 21.6-4 45.8-16.2 76.2l-65 187.9C426.2 403 468.7 334.5 468.7 256c0-37-9.4-71.8-26-102.1zM504 256c0 136.8-111.3 248-248 248C119.2 504 8 392.7 8 256 8 119.2 119.2 8 256 8c136.7 0 248 111.2 248 248zm-11.4 0c0-130.5-106.2-236.6-236.6-236.6C125.5 19.4 19.4 125.5 19.4 256S125.6 492.6 256 492.6c130.5 0 236.6-106.1 236.6-236.6z' class=''></path></svg>WordPress Compatability Updates</h4>
                <p>With WordPress updates being released continually, we make sure the plugin is always compatible with the latest version so you can update WordPress without needing to worry.</p>

                <h4><svg style='width:16px;height:16px;' aria-hidden='true' focusable='false' data-prefix='far' data-icon='life-ring' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' class='svg-inline--fa fa-life-ring fa-w-16 fa-2x' data-ce-key='500'><path fill='currentColor' d='M256 504c136.967 0 248-111.033 248-248S392.967 8 256 8 8 119.033 8 256s111.033 248 248 248zm-103.398-76.72l53.411-53.411c31.806 13.506 68.128 13.522 99.974 0l53.411 53.411c-63.217 38.319-143.579 38.319-206.796 0zM336 256c0 44.112-35.888 80-80 80s-80-35.888-80-80 35.888-80 80-80 80 35.888 80 80zm91.28 103.398l-53.411-53.411c13.505-31.806 13.522-68.128 0-99.974l53.411-53.411c38.319 63.217 38.319 143.579 0 206.796zM359.397 84.72l-53.411 53.411c-31.806-13.505-68.128-13.522-99.973 0L152.602 84.72c63.217-38.319 143.579-38.319 206.795 0zM84.72 152.602l53.411 53.411c-13.506 31.806-13.522 68.128 0 99.974L84.72 359.398c-38.319-63.217-38.319-143.579 0-206.796z' class='' data-ce-key='501'></path></svg>Expert Technical Support</h4>
                <p>Without a valid license key you will no longer be able to receive updates or support for the Custom Twitter Feeds plugin. A renewed license key grants you access to our top-notch, quick and effective support for another full year.</p>

                <h4><svg style='width:16px;height:16px;' aria-hidden='true' focusable='false' data-prefix='fas' data-icon='unlock' role='img' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 448 512' class='svg-inline--fa fa-unlock fa-w-14 fa-2x' data-ce-key='477'><path fill='currentColor' d='M400 256H152V152.9c0-39.6 31.7-72.5 71.3-72.9 40-.4 72.7 32.1 72.7 72v16c0 13.3 10.7 24 24 24h32c13.3 0 24-10.7 24-24v-16C376 68 307.5-.3 223.5 0 139.5.3 72 69.5 72 153.5V256H48c-26.5 0-48 21.5-48 48v160c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V304c0-26.5-21.5-48-48-48z' class='' data-ce-key='478'></path></svg>All Pro Twitter Feed Features</h4>
                <p>Photos &amp; Videos, Popup Lightbox, Mentions Feeds, Moderate Tweets, Carousel/Slideshows, Visual Twitter Link Cards, Multi-user/hashtag feeds, Twitter Lists, Multi-column grid Layout, Display Account Info, Advanced Search Feeds, Autoscroll loading, and more!</p>
            </div>";

            if( $ctf_check_license && !$ctf_license_expired && !$ctf_expire_countdown ){
                $ctf_expired_box_classes = "ctf-license-expired ctf-license-valid";
                $ctf_expired_box_msg = "Thanks ".$ctf_license_data["customer_name"].", your Custom Twitter Feeds Pro license key is valid.";
            }

            _e("
        <div class='".$ctf_expired_box_classes."'>
            <p>".$ctf_expired_box_msg." 
        </div>
        <script type='text/javascript'>
        function ctfShowReasons() {
            document.getElementById('ctf-why-renew').style.display = 'block';
            document.getElementById('ctf-why-renew-show').style.display = 'none';
            document.getElementById('ctf-why-renew-hide').style.display = 'inline-block';
        }
        function ctfHideReasons() {
            document.getElementById('ctf-why-renew').style.display = 'none';
            document.getElementById('ctf-why-renew-show').style.display = 'inline-block';
            document.getElementById('ctf-why-renew-hide').style.display = 'none';
        }
        </script>
        ");
        }

    }

    if ( isset( $active_tab ) ) {
        if ( $active_tab === 'customize' ) {
            require_once CTF_URL . 'views/admin/customize.php';
        } elseif ( $active_tab === 'style' ) {
            require_once CTF_URL . 'views/admin/style.php';
        }  elseif ( $active_tab === 'configure' ) {
            require_once CTF_URL . 'views/admin/configure.php';
        } elseif ( $active_tab === 'display' ) {
            require_once CTF_URL .'views/admin/display.php';
        } elseif ( $active_tab === 'support' ) {
            require_once CTF_URL .'views/admin/support.php';
        } elseif ( $active_tab === 'license' ) {
            require_once CTF_URL .'views/admin/license.php';
        } elseif ( $active_tab === 'allfeeds' ) {
	        require_once CTF_URL .'views/admin/locator-summary.php';
        }
    }
    ?>

    <?php if( $active_tab !== 'license' ){ ?>
    <p><i class="fa fa-life-ring" aria-hidden="true"></i>&nbsp; <?php _e('Need help setting up the plugin? Check out our <a href="https://smashballoon.com/custom-twitter-feeds/docs/" target="_blank">setup directions</a>', 'custom-twitter-feeds'); ?></p>

    <div class="ctf-quick-start">
        <h3><i class="fa fa-rocket" aria-hidden="true"></i>&nbsp; <?php _e( 'Display your feed', 'custom-twitter-feeds'); ?></h3>
        <p><?php _e( "Copy and paste this shortcode directly into the page, post or widget where you'd like to display the feed:", "custom-twitter-feeds" ); ?>
        <input type="text" value="[custom-twitter-feeds]" size="20" readonly="readonly" style="text-align: center;" onclick="this.focus();this.select()" title="<?php _e( 'To copy, click the field then press Ctrl + C (PC) or Cmd + C (Mac).', 'custom-twitter-feeds' ); ?>" /></p>
        <p><?php _e( "Find out how to display <a href='?page=custom-twitter-feeds&tab=display'>multiple feeds</a>.", "custom-twitter-feeds" ); ?></p>
    </div>
    <?php } ?>

    <p class="ctf-footnote dashicons-before dashicons-admin-plugins"> Check out our free plugins: <a href="https://wordpress.org/plugins/custom-facebook-feed/" target="_blank">Facebook</a>, <a href="https://wordpress.org/plugins/instagram-feed/" target="_blank">Instagram</a>, and <a href="https://wordpress.org/plugins/feeds-for-youtube/" target="_blank">YouTube</a>.</p>
    
</div>