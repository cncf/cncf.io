<?php

add_action( 'ctf_admin_endpoints', 'ctf_add_mentionstimeline_options', 10, 1 );
function ctf_add_mentionstimeline_options( $admin ) {
    $admin->create_settings_field( array(
        'name' => 'mentionstimeline',
        'title' => '<label></label>', // label for the input field
        'callback'  => 'feed_settings_radio', // name of the function that outputs the html
        'page' => 'ctf_options_feed_settings', // matches the section name
        'section' => 'ctf_options_feed_settings', // matches the section name
        'option' => 'ctf_options', // matches the options name
        'class' => 'ctf-radio', // class for the wrapper and input field
        'whatis' => 'Select this option to display tweets that @mention your twitter handle', // what is this? text
        'label' => "Mentions Timeline",
        'has_input' => false,
        'has_replies' => false
    ));
}

add_filter( 'ctf_admin_search_label', 'ctf_pro_admin_search_label' );
function ctf_pro_admin_search_label() {
    return 'Search:';
}

add_filter( 'ctf_admin_search_whatis', 'ctf_pro_admin_search_whatis' );
function ctf_pro_admin_search_whatis() {
    return 'You can create search feeds which contain a large variety of different terms and operators, such as a combination of #hashtags, @mentions, words, or "phrases".  See some examples below which demonstrate how to create a search feed:

<span class="ctf_tooltip_table">
    <span class="ctf_col_1 ctf_table_header">Search Terms</span><span class="ctf_col_2 ctf_table_header">Result</span>
    <span class="ctf_col_1">-filter:retweets</span><span class="ctf_col_2">Exclude retweets</span>
    <span class="ctf_col_1">-filter:replies</span><span class="ctf_col_2">Exclude replies</span>
    <span class="ctf_col_1">#awesome</span><span class="ctf_col_2">Tweets tagged with #awesome</span>
    <span class="ctf_col_1">@smashballoon</span><span class="ctf_col_2">Tweets which mention "@smashballoon"</span>
    <span class="ctf_col_1">purple wristwatches</span><span class="ctf_col_2">Tweets which contain both the words "purple" and "wristwatches"</span>
    <span class="ctf_col_1">"cool beans"</span><span class="ctf_col_2">Tweets which contain the exact phrase "cool beans"</span>
    <span class="ctf_col_1">@smashballoon #awesome</span><span class="ctf_col_2">Tweets which mention "@smashballoon" and are also tagged with "#awesome"</span>
    <span class="ctf_col_1">"I love puppies" #fact</span><span class="ctf_col_2">Tweets which contain both the exact phrase "I love puppies" and the hashtag "#fact"</span>
    <span style="display: block; padding: 10px 1% 0 1%;"><i class="fa fa-life-ring" aria-hidden="true"></i> For more examples of ways to create search feeds see the table <a href="https://smashballoon.com/how-to-build-a-search-feed/" target="_blank">here</a></span>
</span>

<b>Please note</b> that only Tweets from the last 7 days can be shown. This is a limit set by Twitter';
}

add_action( 'ctf_admin_feed_settings_search_extra', 'ctf_pro_search_guide' );
function ctf_pro_search_guide() {

}

add_filter( 'ctf_admin_show_hide_list', 'ctf_show_hide_list', 10, 1 );
function ctf_show_hide_list( $show_hide_list ) {
    $show_hide_list[] = array( 'include_replied_to', 'In reply to text' );
    $show_hide_list[] = array( 'include_media', 'Media (images, videos, gifs)' );
    $show_hide_list[] = array( 'include_twittercards', 'Twitter Cards' );
    return $show_hide_list;
}

add_action( 'ctf_admin_style_option', 'ctf_add_masonry_autoscroll_options', 5, 1 );
function ctf_add_masonry_autoscroll_options( $admin )
{
    // custom in reply to text
    $admin->create_settings_field( array(
        'name' => 'inreplytotext',
        'title' => '<label for="ctf_inreplytotext">Translation for "In reply to"</label><code class="ctf_shortcode">inreplytotext
            Eg: inreplytotext="Als Antwort an"</code>', // label for the input field
        'callback'  => 'default_text', // name of the function that outputs the html
        'page' => 'ctf_options_text', // matches the section name
        'section' => 'ctf_options_text', // matches the section name
        'option' => 'ctf_options', // matches the options name
        'class' => 'default-text', // class for the wrapper and input field
        'whatis' => 'This will replace the default text displayed for "In reply to"',
        'default' => 'In reply to'// "what is this?" text
    ));

    add_settings_section(
        'ctf_options_autoscroll', // matches the section name
        'Autoscroll Load More',
        array( $admin, 'general_section_text' ), // callback function to explain the section
        'ctf_options_autoscroll' // matches the section name
    );

    // autoscroll default
    $admin->create_settings_field( array(
        'name' => 'autoscroll',
        'title' => '<label for="ctf_autoscroll">Set Load More on Scroll as Default</label><code class="ctf_shortcode">autoscroll
            Eg: autoscroll=true</code>', // label for the input field
        'callback'  => 'default_checkbox', // name of the function that outputs the html
        'page' => 'ctf_options_autoscroll', // matches the section name
        'section' => 'ctf_options_autoscroll', // matches the section name
        'option' => 'ctf_options', // matches the options name
        'class' => '',
        'whatis' => "This will make every Twitter feed load more Tweets as the user gets to the bottom of the feed"
    ));

    // autoscroll distance
    $admin->create_settings_field( array(
        'name' => 'autoscrolldistance',
        'title' => '<label for="ctf_autoscrolldistance">Auto Scroll Trigger Distance</label><code class="ctf_shortcode">autoscrolldistance
            Eg: autoscrolldistance=2</code>', // label for the input field
        'callback'  => 'default_text', // name of the function that outputs the html
        'page' => 'ctf_options_autoscroll', // matches the section name
        'section' => 'ctf_options_autoscroll', // matches the section name
        'option' => 'ctf_options', // matches the options name
        'class' => 'default-text', // class for the wrapper and input field
        'whatis' => 'This is the distance in pixels from the bottom of the page the user must scroll to to trigger the loading of more tweets',
        'default' => '200',// "what is this?" text
    ) );
}

add_action( 'ctf_admin_customize_option', 'ctf_add_customize_general_options', 20, 1 );
function ctf_add_customize_general_options( $admin ) {

    // masonry mobile columns
    $admin->create_settings_field( array(
        'name' => 'disablelightbox',
        'title' => '<label for="ctf_disablelightbox">Disable the lightbox</label><code class="ctf_shortcode">disablelightbox
            Eg: disablelightbox=true</code>', // label for the input field
        'callback'  => 'default_checkbox', // name of the function that outputs the html
        'page' => 'ctf_options_general', // matches the section name
        'section' => 'ctf_options_general', // matches the section name
        'option' => 'ctf_options', // matches the options name
        'class' => 'default-text', // class for the wrapper and input field
        'whatis' => 'Disable the lightbox for media in the feed'
    ) );
}


add_action( 'ctf_admin_customize_option', 'ctf_add_filter_options', 10, 1 );
function ctf_add_filter_options( $admin ) {
    
    add_settings_section(
        'ctf_options_filter', // matches the section name
        'Moderation',
        array( $admin, 'general_section_text' ), // callback function to explain the section
        'ctf_options_filter' // matches the section name
    );

    // includewords
    $admin->create_settings_field( array(
        'name' => 'includewords',
        'title' => '<label for="ctf_includewords">Show Tweets containing these words or hashtags</label><code class="ctf_shortcode">includewords
            Eg: includewords="#puppy,#cute"</code>', // label for the input field
        'callback'  => 'default_text', // name of the function that outputs the html
        'page' => 'ctf_options_filter', // matches the section name
        'section' => 'ctf_options_filter', // matches the section name
        'option' => 'ctf_options', // matches the options name
        'class' => 'large-text', // class for the wrapper and input field
        'default' => '',
        'example' => '"includewords" separate words by comma'
    ));

    // excludewords
    $admin->create_settings_field( array(
        'name' => 'excludewords',
        'title' => '<label for="ctf_excludewords">Remove Tweets containing these words or hashtags</label><code class="ctf_shortcode">excludewords
            Eg: excludewords="#ugly,#bad"</code>', // label for the input field
        'callback'  => 'default_text', // name of the function that outputs the html
        'page' => 'ctf_options_filter', // matches the section name
        'section' => 'ctf_options_filter', // matches the section name
        'option' => 'ctf_options', // matches the options name
        'class' => 'large-text', // class for the wrapper and input field
        'default' => '',
        'example' => '"excludewords" separate words by comma'
    ));

    // operator
    $admin->create_settings_field( array(
        'name' => 'filteroperator',
        'title' => '', // label for the input field
        'callback'  => 'ctf_filter_operator', // name of the function that outputs the html
        'page' => 'ctf_options_filter', // matches the section name
        'section' => 'ctf_options_filter', // matches the section name
        'option' => 'ctf_options', // matches the options name
        'class' => '', // class for the wrapper and input field
    ));

    add_settings_field(
        'filteroperator',
        '',
        'ctf_filter_operator',
        'ctf_options_filter',
        'ctf_options_filter',
        array( 'option' => 'ctf_options' )
    );

    add_settings_field(
        'remove_by_id',
        '<label for="ctf_remove_by_id">Hide Specific Tweets</label>',
        'ctf_remove_by_id',
        'ctf_options_filter',
        'ctf_options_filter',
        array(
            'option' => 'ctf_options',
            'extra' => 'separate IDs by comma',
            'name' => 'remove_by_id',
            'whatis' => 'These are the specific ID numbers associated with a tweet. You can find the ID of a Tweet by viewing the Tweet on Twitter and copy/pasting the ID number from the end of the URL'
        )
    );

    add_settings_field(
        'clear_tc_cache_button',
        '<label for="ctf_clear_tc_cache_button">Clear Twitter Card Cache</label>',
        'ctf_clear_tc_cache_button',
        'ctf_options_advanced',
        'ctf_options_advanced'
    );
}

function ctf_remove_by_id( $args ) {
    $options = get_option( $args['option'] );
    $option_string = ( isset( $options[ $args['name'] ] ) ) ? esc_attr( $options[ $args['name'] ] ) : '';
    ?>
    <textarea name="<?php echo $args['option'].'['.$args['name'].']'; ?>" id="ctf_<?php echo $args['name']; ?>" style="width: 70%;" rows="3"><?php esc_attr_e( stripslashes( $option_string ) ); ?></textarea>
    <?php if ( isset( $args['extra'] ) ) : ?><p><?php _e( $args['extra'], 'custom-twitter-feeds' ); ?>
        <a class="ctf-tooltip-link" href="JavaScript:void(0);"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
        <span class="ctf-tooltip ctf-more-info"><?php _e( $args['whatis'], 'custom-twitter-feeds' ); ?>.</span>
        </p> <?php endif; ?>
    <?php
}

function ctf_clear_tc_cache_button() {
    ?>
    <input id="ctf-clear-tc-cache" class="button-secondary" style="margin-top: 1px;" type="submit" value="<?php esc_attr_e( 'Clear Twitter Cards' ); ?>" />
    <a class="ctf-tooltip-link" href="JavaScript:void(0);"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
    <p class="ctf-tooltip ctf-more-info"><?php _e( 'Clicking this button will clear all cached data for your links that have Twitter Cards', 'custom-twitter-feeds' ); ?>.</p>
    <?php
}

function ctf_filter_operator( $args ) {
    $options = get_option( $args['option'] );
    $include_any_all = ( isset( $options['includeanyall'] ) ) ? esc_attr( $options['includeanyall'] ) : 'any';
    $filter_and_or = ( isset( $options['filterandor'] ) ) ? esc_attr( $options['filterandor'] ) : 'and';
    $exclude_any_all = ( isset( $options['excludeanyall'] ) ) ? esc_attr( $options['excludeanyall'] ) : 'any';

    ?>
    <p>Show Tweets that contain
        <select name="<?php echo $args['option'].'[includeanyall]'; ?>" id="ctf_includeanyall">
            <option value="any" <?php if ( $include_any_all == "any" ) echo 'selected="selected"'; ?> ><?php _e('any'); ?></option>
            <option value="all" <?php if ( $include_any_all == "all" ) echo 'selected="selected"'; ?> ><?php _e('all'); ?></option>
        </select>
        of the "includewords"
        <select name="<?php echo $args['option'].'[filterandor]'; ?>" id="ctf_filterandor">
            <option value="and" <?php if ( $filter_and_or == "and" ) echo 'selected="selected"'; ?> ><?php _e('and'); ?></option>
            <option value="or" <?php if ( $filter_and_or == "or" ) echo 'selected="selected"'; ?> ><?php _e('or'); ?></option>
        </select>
        do not contain
        <select name="<?php echo $args['option'].'[excludeanyall]'; ?>" id="ctf_excludeanyall">
            <option value="any" <?php if ( $exclude_any_all == "any" ) echo 'selected="selected"'; ?> ><?php _e('any'); ?></option>
            <option value="all" <?php if ( $exclude_any_all == "all" ) echo 'selected="selected"'; ?> ><?php _e('all'); ?></option>
        </select>
        of the "excludewords"
    </p>
    <?php if ( isset( $args['whatis'] ) ) : ?>
        <a class="ctf-tooltip-link" href="JavaScript:void(0);"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
        <p class="ctf-tooltip ctf-more-info"><?php _e( $args['whatis'], 'custom-twitter-feeds' ); ?>.</p>
    <?php endif; ?>
    <?php
}

add_action( 'ctf_admin_add_settings_sections_to_customize', 'ctf_add_masonry_autoload_section_to_customize' );
function ctf_add_masonry_autoload_section_to_customize() {
    ?>
    <a id="autoscroll"></a>
    <?php do_settings_sections( 'ctf_options_autoscroll' ); ?>
    <p class="submit"><input class="button-primary" type="submit" name="save" value="<?php esc_attr_e( 'Save Changes' ); ?>" /></p>
    <hr>
    <?php
}

add_action( 'ctf_admin_add_settings_sections_to_customize', 'ctf_add_filter_section_to_customize' );
function ctf_add_filter_section_to_customize() {
    echo '<a id="moderation"></a>';
    do_settings_sections( 'ctf_options_filter' ); // matches the section name
    echo '<hr>';
}

add_filter( 'ctf_admin_validate_search_text', 'ctf_validate_search_text', 10, 1 );
function ctf_validate_search_text( $val ) {
    $new_val = trim( $val );

    return $new_val;
}

add_filter( 'ctf_admin_validate_hashtag_text', 'ctf_validate_hashtag_text', 10, 1 );
function ctf_validate_hashtag_text( $val ) {

    $hashtags = preg_replace( "/#{2,}/", '', trim( $val ) );
    $hashtags = str_replace( "OR", ',', $hashtags );
    $hashtags = str_replace( ' ', '', $hashtags );

    $hashtags = explode( ',', $hashtags );

    $new_val = array();

    if ( ! empty( $hashtags ) ) {
        foreach ( $hashtags as $hashtag ) {
            if ( substr( $hashtag, 0, 1 ) != '#' && $hashtag != '' ) {
                $new_val[] .= '#' . $hashtag;
            } else {
                $new_val[] .= $hashtag;
            }
        }
    }

    $new_val = implode( ',', $new_val );

    return $new_val;
}

add_filter( 'ctf_admin_validate_usertimeline_text', 'ctf_validate_usertimeline_text', 10, 1 );
function ctf_validate_usertimeline_text( $val ) {
    $new_val = str_replace( array( '@', ' ' ), '', trim( $val ) );

    return $new_val;
}

add_filter( 'ctf_admin_feed_type_list', 'ctf_pro_admin_feed_type_list' );
function ctf_pro_admin_feed_type_list() {
    return array( 'hometimeline_includereplies', 'usertimeline_includereplies', 'mentionstimeline_includereplies' );
}

add_filter( 'ctf_admin_validate_include_replies', 'ctf_validate_include_replies', 10, 1 );
function ctf_validate_include_replies( $val, $type ) {
    if ( $val == 'on' ) {
        return true;
    } else {
        return false;
    }
}

add_filter( 'ctf_admin_set_include_replies', 'ctf_set_include_replies', 10, 1 );
function ctf_set_include_replies( $new_input ) {
	if ( isset( $new_input ) && isset( $new_input['type'] ) ) {
	    if ( isset( $new_input[$new_input['type'] . '_includereplies'] ) && $new_input[$new_input['type'] . '_includereplies'] == 'on' ) {
	        return true;
	    } else {
	        return false;
	    }
	}
}

add_filter( 'ctf_admin_set_include_retweets', 'ctf_set_include_retweets', 10, 1 );
function ctf_set_include_retweets( $new_input ) {
    if ( isset( $new_input ) && isset( $new_input['type'] ) ) {
        if ( isset( $new_input[$new_input['type'] . '_includeretweets'] ) && $new_input[$new_input['type'] . '_includeretweets'] == 'on' ) {
            return true;
        } else {
            return false;
        }
    }
}

add_filter( 'ctf_admin_customize_checkbox_settings', 'ctf_customize_checkbox_settings' );
function ctf_customize_checkbox_settings( $checkbox_settings ) {
    $new_settings = array( 'disablelightbox', 'include_media', 'include_twittercards', 'include_replied_to', 'masonry', 'carousel', 'carouselpag', 'carouselautoplay', 'autoscroll' );
    $merged = array_merge( $checkbox_settings, $new_settings );

    return $merged;
}

add_filter( 'ctf_admin_customize_quick_links', 'ctf_return_customize_quick_links' );
function ctf_return_customize_quick_links() {
    return array(
        array( 'general', 'General' ),
	    array( 'layout', 'Layout' ),
	    array( 'showhide', 'Show/Hide' ),
        array( 'autoscroll', 'Auto Scroll' ),
        array( 'media', 'Media Layout' ),
        array( 'moderation', 'Moderation' ),
        array( 'misc', 'Misc' ),
	    array( 'gdpr', 'GDPR' ),
        array( 'advanced', 'Advanced' )
    );
}

add_filter( 'ctf_admin_style_quick_links', 'ctf_return_style_quick_links' );
function ctf_return_style_quick_links() {
    return array(
        0 => array( 'general', 'General' ),
        1 => array( 'header', 'Header' ),
        2 => array( 'date', 'Date' ),
        3 => array( 'author', 'Author' ),
        4 => array( 'text', 'Tweet Text' ),
        5 => array( 'links', 'Links' ),
        6 => array( 'quoted', 'Retweet Boxes' ),
        7 => array( 'actions', 'Tweet Actions' ),
        8 => array( 'load', 'Load More' )
    );
}


function ctf_admin_hide_unrelated_notices() {

	// Bail if we're not on a ctf screen or page.
	if ( ! isset( $_GET['page'] ) || ($_GET['page'] !== 'custom-twitter-feeds' && $_GET['page'] !== 'custom-twitter-feeds-sw') ) {
		return;
	}

	// Extra banned classes and callbacks from third-party plugins.
	$blacklist = array(
		'classes'   => array(),
		'callbacks' => array(
			'ctfdb_admin_notice', // 'Database for ctf' plugin.
		),
	);

	global $wp_filter;

	foreach ( array( 'user_admin_notices', 'admin_notices', 'all_admin_notices' ) as $notices_type ) {
		if ( empty( $wp_filter[ $notices_type ]->callbacks ) || ! is_array( $wp_filter[ $notices_type ]->callbacks ) ) {
			continue;
		}
		foreach ( $wp_filter[ $notices_type ]->callbacks as $priority => $hooks ) {
			foreach ( $hooks as $name => $arr ) {
				if ( is_object( $arr['function'] ) && $arr['function'] instanceof Closure ) {
					unset( $wp_filter[ $notices_type ]->callbacks[ $priority ][ $name ] );
					continue;
				}
				$class = ! empty( $arr['function'][0] ) && is_object( $arr['function'][0] ) ? strtolower( get_class( $arr['function'][0] ) ) : '';
				if (
					! empty( $class ) &&
					strpos( $class, 'ctf' ) !== false &&
					! in_array( $class, $blacklist['classes'], true )
				) {
					continue;
				}
				if (
					! empty( $name ) && (
						strpos( $name, 'ctf' ) === false ||
						in_array( $class, $blacklist['classes'], true ) ||
						in_array( $name, $blacklist['callbacks'], true )
					)
				) {
					unset( $wp_filter[ $notices_type ]->callbacks[ $priority ][ $name ] );
				}
			}
		}
	}
}
add_action( 'admin_print_scripts', 'ctf_admin_hide_unrelated_notices' );

//Create Social Wall Page
function ctf_social_wall_page() {

	( is_plugin_active( 'social-wall/social-wall.php' ) ) ? $ctf_sw_active = true : $ctf_sw_active = false;

	?>

    <div id="ctf-admin" class="wrap sw-landing-page">

		<?php $plus_svg = '<span class="ctf-sb-plus"><svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="svg-inline--fa fa-plus fa-w-12 fa-2x"><path fill="currentColor" d="M376 232H216V72c0-4.42-3.58-8-8-8h-32c-4.42 0-8 3.58-8 8v160H8c-4.42 0-8 3.58-8 8v32c0 4.42 3.58 8 8 8h160v160c0 4.42 3.58 8 8 8h32c4.42 0 8-3.58 8-8V280h160c4.42 0 8-3.58 8-8v-32c0-4.42-3.58-8-8-8z" class=""></path></svg></span>'; ?>

        <div class="ctf-sw-icons">

            <span style="display: inline-block; padding: 0 0 12px 0; width: 360px; max-width: 100%;">
                <svg viewBox="0 0 9161 1878" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2">
                    <path d="M671.51192 492.98498c-131.56765-59.12206-268.60859-147.41608-396.53319-188.5154 45.4516 108.39585 83.81326 223.88002 123.5099 338.03081-79.17849 59.49897-171.6647 105.68858-260.02357 156.01204C213.65642 872.8361 320.1446 915.85885 404.9893 980.52836c-67.96118 83.8619-201.48512 171.0179-234.02089 247.0198 140.6921-17.62678 304.63665-46.21028 435.53762-52.00414 28.76425 144.58318 43.59867 303.0974 84.5075 435.5368 60.92028-175.2656 116.0013-356.3729 188.5158-520.0447 111.90636 46.28566 248.28994 102.72599 357.52876 130.01178-76.6463-107.53462-146.59336-221.76932-214.51645-338.02878 100.51155-72.83872 202.17166-144.52441 299.02516-221.02077-136.89504-12.61227-278.73407-20.28825-422.53587-25.99863-22.85286-148.332-16.84825-325.5158-52.00496-461.53949-53.19323 111.48812-115.96685 213.3914-175.51405 318.52475m65.00509 1228.60643c-18.07949 77.37581 41.48757 109.11319 32.50294 156.01204-58.81404-20.26799-103.0575-30.6796-182.01552-19.50201 2.47017-60.37032 56.76657-68.90954 45.50428-143.0107-841.40803-95.6632-843.09804-1616.06909-6.50107-1709.64388C1672.04777-111.55711 1704.8713 1694.70523 736.517 1721.5914" fill="#e34f0e"/>
                    <path d="M847.02597 174.46023c35.15671 136.0237 29.1521 313.20749 52.00455 461.53544 143.80221 5.71443 285.63962 13.38636 422.53628 26.00268-96.8531 76.49636-198.51483 148.18205-299.02556 221.01874 67.92349 116.2623 137.87014 230.49416 214.51847 338.03-109.24085-27.2866-245.62443-83.72572-357.5308-130.0126-72.51448 163.67262-127.5955 344.77992-188.51538 520.04553-40.90924-132.4394-55.74325-290.95364-84.5079-435.53681-130.90057 5.79548-294.84472 34.37736-435.53722 52.00415 32.53577-76.0007 166.0589-163.15589 234.02008-247.02021-84.8451-64.67032-191.33207-107.69066-266.52343-182.01472 88.35886-50.32346 180.84346-96.51307 260.02276-156.01609-39.69705-114.14674-78.05668-229.63091-123.50868-338.02675C402.9013 345.5689 539.94427 433.86292 671.51192 492.98498c59.5468-105.13335 122.32082-207.03663 175.51405-318.52475" fill="#fff"/>
                    <path d="M1782.27033 1236.51938c41.18267 21.61921 126.79927 44.31938 214.58338 44.31938 213.49962 0 311.03752-107.01507 311.03752-232.40646 0-101.61027-58.52274-171.87269-189.65702-220.5159-92.11913-33.50977-131.13429-48.6432-131.13429-85.39586 0-32.4288 32.51263-54.04801 92.11913-54.04801 72.61154 0 126.79927 20.53824 158.22814 34.59073l41.18267-155.65828c-47.6852-21.6192-110.54295-37.83361-197.2433-37.83361-184.23826 0-293.69746 99.44834-293.69746 228.08262 0 108.09602 82.36534 176.19652 205.91335 219.43493 82.36533 28.10497 114.87797 48.64321 114.87797 84.3149 0 36.75265-32.51264 59.45282-99.70541 59.45282-73.6953 0-145.2231-22.70017-189.65703-45.40034l-36.84765 161.06308zM3019.37602 1270.02915h189.65702l-36.84765-728.56722h-256.8498l-55.27148 194.57285c-21.67508 76.74818-45.51768 179.4394-66.10902 268.07815h-3.25126c-15.17256-88.63875-36.84765-185.92517-57.43898-266.99719l-47.6852-195.6538h-263.35233l-45.51768 728.56721h179.90323l11.9213-260.51142c3.25127-83.23394 6.50253-191.32997 10.83755-294.0212h2.1675c17.34008 99.44835 39.01517 207.54438 58.52274 286.45448l60.69025 252.9447h152.80938l72.61154-254.02566c23.8426-79.99106 54.18773-189.16805 76.94657-285.37352h3.25126c0 113.50083 1.08376 210.78726 4.33502 294.0212l8.67004 260.51142zM3699.9738 1101.39935l46.60144 168.6298h211.33211l-217.83464-728.56722H3478.8879l-211.33211 728.56722h202.66208l41.18267-168.6298h188.57327zm-162.56317-143.76772l31.42888-130.79619c9.7538-41.07649 20.59134-101.61026 31.42888-143.76771h2.1675c11.9213 42.15745 26.01012 102.69122 36.84766 143.76771l33.59639 130.7962h-135.4693zM4016.4301 1236.51938c41.18266 21.61921 126.79926 44.31938 214.58337 44.31938 213.49962 0 311.03752-107.01507 311.03752-232.40646 0-101.61027-58.52274-171.87269-189.65702-220.5159-92.11913-33.50977-131.1343-48.6432-131.1343-85.39586 0-32.4288 32.51264-54.04801 92.11914-54.04801 72.61154 0 126.79926 20.53824 158.22814 34.59073l41.18267-155.65828c-47.6852-21.6192-110.54295-37.83361-197.2433-37.83361-184.23826 0-293.69746 99.44834-293.69746 228.08262 0 108.09602 82.36534 176.19652 205.91335 219.43493 82.36533 28.10497 114.87797 48.64321 114.87797 84.3149 0 36.75265-32.51264 59.45282-99.70541 59.45282-73.6953 0-145.2231-22.70017-189.65703-45.40034l-36.84765 161.06308zM4623.27688 541.46193v728.56722h196.15955V981.41276h237.34222v288.6164h196.15955V541.46192h-196.15955v269.1591h-237.34222v-269.1591h-196.15955z" fill="#282828" fill-rule="nonzero"/>
                    <g>
                        <path d="M6900.00785 293.7053c5.29-14.371 11.90999-24.77099 19.84998-31.19998 7.94-6.429 16.07-9.644 24.38998-9.644 8.32 0 15.7 2.08 22.12999 6.241 6.43 4.16 10.39999 9.265 11.90999 15.31599 2.27 43.86896 4.16 92.65493 5.67 146.35689 1.51 53.70296 2.65 109.86291 3.4 168.48187.76 58.61796 1.52 118.74891 2.26999 180.39386.76 61.64396 1.33 122.71991 1.71 183.22987.37 60.50695.56 119.1269.56 175.85686 0 56.72996.38 109.28992 1.14 157.69988-3.78 12.1-10.59 20.98999-20.41999 26.65998-9.83999 5.68-19.85998 8.14-30.06997 7.38-10.21-.76-19.28999-4.73-27.22998-11.91-7.94-7.18999-11.91-17.58998-11.91-31.19997l-3.4-983.66226zm173.57987 0c5.3-14.371 11.90999-24.77099 19.85998-31.19998 7.94-6.429 16.06999-9.644 24.38998-9.644 8.32 0 15.69 2.08 22.11999 6.241 6.43 4.16 10.39999 9.265 11.91999 15.31599 2.27 43.86896 4.15 92.65493 5.67 146.35689 1.51 53.70296 2.64 109.86291 3.4 168.48187.76 58.61796 1.51999 118.74891 2.26999 180.39386.76 61.64396 1.33 122.71991 1.7 183.22987.38 60.50695.57 119.1269.57 175.85686 0 56.72996.38 109.28992 1.13 157.69988-3.78 12.1-10.59 20.98999-20.41999 26.65998-9.82999 5.68-19.84998 8.14-30.05998 7.38-10.20999-.76-19.28998-4.73-27.22997-11.91-7.94-7.18999-11.92-17.58998-11.92-31.19997l-3.4-983.66226zm-419.49969 980.25225c-6.81-4.54-13.60999-12.66999-20.41998-24.38998-6.81-11.71999-13.61-24.57998-20.41999-38.57997-6.81-13.98999-13.61999-28.16998-20.41998-42.53997-6.81-14.36999-13.99999-26.84998-21.55998-37.43997-7.56-10.58999-15.51-18.33998-23.82999-23.25998-8.31999-4.92-17.38998-4.73-27.22998.57-15.11998 24.95998-30.43997 49.15996-45.93996 72.60994-15.50999 23.44999-32.52998 43.48997-51.05996 60.12996-18.52999 16.63999-39.70997 28.35998-63.52995 35.16997-23.82999 6.81-51.62997 6.05-83.38994-2.27-31.01998-8.31999-56.16996-24.57998-75.44994-48.77996-19.28999-24.20998-33.65998-52.94996-43.10997-86.22993-9.46-33.27998-14.19-69.77995-14.19-109.48992 0-39.70397 4.35-79.22394 13.05-118.55591 8.7-39.33097 21.36998-77.14894 38.00997-113.45492 16.63999-36.30597 36.67997-67.50595 60.12995-93.60093 23.44999-26.09398 50.10997-45.75996 79.98994-58.99595 29.86998-13.237 62.20996-16.82999 96.99993-10.779 32.51998 6.051 59.36996 19.855 80.54994 41.41198 21.17998 21.55598 38.76997 47.65096 52.75996 78.28394 13.98999 30.63297 24.95998 64.47995 32.89998 101.54192 7.93999 37.06197 15.12998 74.12394 21.55998 111.18692 6.43 37.06197 12.85999 72.42194 19.28999 106.08192 6.41999 33.65997 14.92998 62.58995 25.51998 86.78993 10.58999 24.20998 24.01998 41.97997 40.27997 53.32996 16.25998 11.34 37.62997 12.84999 64.09995 4.53 30.25997-31.00998 54.45996-51.61996 72.60994-61.82996 18.15999-10.20999 31.38998-13.60999 39.70997-10.20999 8.32 3.4 11.91 11.91 10.78 25.52998-1.13 13.61-6.05 28.73998-14.75 45.37997-8.69999 16.63999-20.60998 32.89997-35.73997 48.77996-15.11999 15.88999-32.32997 27.98998-51.61996 36.30997-19.28998 8.32-40.46997 11.16-63.52995 8.51-23.06998-2.65-47.08997-14.56-72.04995-35.73998zm2413.83818 6.81c-2.26-39.32997-5.67-82.25994-10.20999-128.7699-4.53-46.51997-10.58-92.84993-18.14999-138.9899-7.55999-46.13396-16.63998-89.81493-27.22998-131.0369-10.58999-41.22197-23.06998-76.01494-37.43997-104.37892-14.36999-28.36298-30.81997-48.21797-49.34996-59.56396-18.52999-11.34499-39.51997-9.83199-62.96995 4.539-23.44998 14.37099-49.34997 43.30197-77.71994 86.79293-28.35998 43.49097-59.93996 106.08092-94.72993 187.76786-3.03 6.05-7 15.88-11.91 29.49998-4.91999 13.60999-10.20999 28.92998-15.88998 45.94997-5.67 17.01998-11.91 34.97997-18.71999 53.88996-6.8 18.90998-13.03999 37.05997-18.71998 54.45995-5.67 17.4-10.78 32.89998-15.31 46.50997-4.53999 13.61999-7.56999 23.82998-9.07998 30.63998-6.05 15.11998-13.62 23.62998-22.68999 25.52998-9.08 1.89-18.14998.18-27.22998-5.11-9.07999-5.3-17.39998-12.47999-24.95998-21.55998-7.56-9.07-12.09999-17.01999-13.61999-23.81999 6.81-26.47998 12.86-55.96995 18.15999-88.49993 5.29-32.51997 9.45-69.57995 12.47999-111.17991 3.02-41.60397 4.16-88.68794 3.4-141.2559-.76-52.56696-4.54-112.13091-11.35-178.69186 8.32-17.39599 16.65-27.03998 24.96999-28.93098 8.31999-1.891 16.63998.756 24.94998 7.942 8.32 7.18499 16.07999 17.77498 23.25998 31.76697 7.19 13.99299 13.61999 28.17498 19.28999 42.54597 5.67 14.37099 10.20999 27.79698 13.61998 40.27697 3.4 12.47999 5.1 20.61098 5.1 24.39298 16.63999-14.371 31.95998-32.71298 45.94997-55.02596 13.98999-22.31298 28.35997-44.62597 43.10996-66.93895 14.75-22.31298 30.82998-42.16697 48.21997-59.56396 17.39998-17.39598 38.19997-27.98597 62.39995-31.76697 49.91996-9.077 92.27993-3.215 127.0699 17.58499 34.79998 20.79998 63.34996 50.67696 85.65994 89.62993 22.30998 38.95297 39.32997 84.14593 51.05996 135.5789 11.72 51.43296 20.03999 103.05492 24.95998 154.86588 4.91 51.80996 6.99 101.34992 6.24 148.62989-.76 47.26996-2.65 86.02993-5.68 116.2899-8.32 17.39-19.46998 26.08999-33.46997 26.08999-13.99 0-25.13998-8.7-33.46998-26.08998zm-1029.72922-9.08c-43.86997-18.14998-78.46994-41.97996-103.80992-71.46994-25.33998-29.49998-43.10997-61.83995-53.32996-97.00993-10.21-35.16997-13.61-72.03994-10.21-110.61791 3.41-38.57497 12.48-76.20395 27.22999-112.88792 14.74998-36.68397 34.41997-71.28794 58.99995-103.81092 24.57998-32.52398 52.56996-60.32095 83.95994-83.38994 31.38997-23.06898 65.79995-40.08797 103.23992-51.05496 37.43997-10.967 76.20994-13.42599 116.28991-7.375 33.27998 5.295 61.83995 20.99 85.65994 47.08397 23.82998 26.09498 42.73996 58.42996 56.72995 97.00493 13.99 38.57397 22.87999 80.93094 26.65998 127.0699 3.78 46.13797 1.7 91.70893-6.24 136.7079-7.93999 45.00996-21.55997 86.79993-40.83996 125.3699-19.28999 38.57998-44.62997 69.77995-76.01994 93.59993-31.38998 23.82999-69.39995 37.81998-114.01992 41.97997-44.62996 4.16-96.05992-6.24-154.29988-31.19997zm-642.42952 0c-43.86996-18.14998-78.46994-41.97996-103.80992-71.46994-25.33998-29.49998-43.10997-61.83995-53.31996-97.00993-10.20999-35.16997-13.61999-72.03994-10.20999-110.61791 3.4-38.57497 12.48-76.20395 27.21998-112.88792 14.74999-36.68397 34.41997-71.28794 58.99996-103.81092 24.57998-32.52398 52.56996-60.32095 83.95993-83.38994 31.38998-23.06898 65.79995-40.08797 103.23992-51.05496 37.43998-10.967 76.20995-13.42599 116.29992-7.375 33.27997 5.295 61.82995 20.99 85.64993 47.08397 23.82998 26.09498 42.73997 58.42996 56.72996 97.00493 13.98999 38.57397 22.87998 80.93094 26.65998 127.0699 3.79 46.13797 1.71 91.70893-6.24 136.7079-7.94 45.00996-21.54998 86.79993-40.83997 125.3699-19.28998 38.57998-44.62996 69.77995-76.01994 93.59993-31.38997 23.82999-69.38995 37.81998-114.01991 41.97997-44.61997 4.16-96.05993-6.24-154.29989-31.19997zm-1823.64862-14.69998c-5.29-34.31998-9.64-71.39995-13.04999-111.24992-3.4-39.85997-6.24-80.95994-8.5-123.2999-2.27-42.34497-3.79-85.24294-4.54-128.6939-.75999-43.45198-1.13999-86.07294-1.13999-127.86391 0-41.78997.38-81.91994 1.14-120.38991.75-38.46997 1.89-74.30995 3.4-107.52092 2.27-9.41 8.13-15.63699 17.58998-18.68199 9.45-3.044 19.65999-3.736 30.62998-2.075 10.97 1.66 20.98998 5.12 30.06998 10.378 9.07 5.259 13.98999 11.48599 14.73999 18.68198-1.51 31.54998-2.64 62.40896-3.4 92.57593-.76 30.16698-.57 59.91796.57 89.25494 1.13 29.33597 3.4 58.81095 6.81 88.42493 3.4 29.61298 8.12999 59.64095 14.17998 90.08493 35.54998-34.31797 72.03995-55.90596 109.47992-64.76195 37.43997-8.856 72.79995-8.441 106.07992 1.245 33.27998 9.687 63.72995 26.56898 91.32993 50.64796 27.60998 24.07798 49.54996 51.61496 65.80995 82.61194 16.25999 31.00198 25.89998 63.65195 28.92998 97.97192 3.02 34.31998-3.22 66.41995-18.71999 96.30993-15.50998 29.88998-41.40996 55.62996-77.71994 77.21994-36.29997 21.58999-85.46993 35.42998-147.48989 41.50997-27.22998 2.77-50.86996 4.99-70.90994 6.65-20.03999 1.66-38.94997 1.8-56.72996.41-17.76999-1.38-35.91997-5.12-54.45996-11.21-18.52998-6.08999-39.89997-15.49998-64.09995-28.22997zm85.08994-154.42989c-9.83 32.09998-11.34 58.25996-4.53 78.45994 6.8 20.20999 18.89998 35.00998 36.29997 44.41997 17.39999 9.41 38.57997 14.11999 63.53995 14.11999 24.95998 0 50.66997-3.74 77.13995-11.21 26.47998-7.46999 52.37996-18.12998 77.71994-31.96997 25.33998-13.83999 47.08996-30.15997 65.23995-48.97996 13.60999-13.83999 20.79998-30.58998 21.55998-50.23996.75-19.64999-2.84-39.70997-10.78-60.18996-7.94998-20.47998-19.85998-40.13097-35.73996-58.95095-15.88-18.81999-33.65998-34.31798-53.31996-46.49597-19.66999-12.17699-40.65997-19.64998-62.96996-22.41698-22.31998-2.768-44.24996 1.799-65.80995 13.69899-21.54998 11.90099-41.78996 32.10397-60.69995 60.61095-18.90999 28.50398-34.78997 68.22395-47.64996 119.14391zm2380.9882 74.95995c49.15996 31.76997 93.21993 45.00996 132.1799 39.70997 38.94997-5.29 71.65995-21.92999 98.12993-49.91997 26.47998-27.97997 46.32996-63.71995 59.56995-107.20991 13.24-43.48997 18.90999-87.92994 17.01999-133.3119-1.9-45.38197-11.73-87.54994-29.49998-126.5029-17.77999-38.95298-44.81997-68.26196-81.11994-87.92694-20.41998-10.59-44.24997-10.022-71.47994 1.701-27.22998 11.72399-53.88996 30.63297-79.97994 56.72795-26.09998 26.09498-49.73997 57.29496-70.90995 93.60093-21.17999 36.30498-35.54997 73.55695-43.11997 111.75292-7.56 38.19897-6.62 75.06894 2.84 110.61892 9.45 35.54997 31.57998 65.79995 66.36995 90.75993zm-642.42952 0c49.16997 31.76997 93.21993 45.00996 132.1799 39.70997 38.94997-5.29 71.65995-21.92999 98.13993-49.91997 26.46998-27.97997 46.31997-63.71995 59.55996-107.20991 13.23999-43.48997 18.90998-87.92994 17.01998-133.3119-1.89-45.38197-11.71999-87.54994-29.49998-126.5029-17.76998-38.95298-44.80996-68.26196-81.11993-87.92694-20.41999-10.59-44.24997-10.022-71.47995 1.701-27.22998 11.72399-53.88996 30.63297-79.97994 56.72795-26.09998 26.09498-49.72996 57.29496-70.90995 93.60093-21.17998 36.30498-35.54997 73.55695-43.10996 111.75292-7.57 38.19897-6.62 75.06894 2.83 110.61892 9.45999 35.54997 31.57997 65.79995 66.36994 90.75993zm-1159.18912-39.69997c19.65998 30.24997 40.26997 47.64996 61.82995 52.18996 21.55999 4.53 42.53997.56 62.96995-11.92 20.41999-12.47998 39.70997-31.00997 57.85996-55.58995 18.14999-24.57998 33.65998-50.86996 46.51997-78.84994 12.84999-27.98998 22.30998-55.40696 28.35997-82.25794 6.05-26.85098 7.56-48.97496 4.54-66.37095-3.78-18.15299-6.81-34.41497-9.08-48.78596-2.27-14.371-4.72999-27.22898-7.36999-38.57497-2.65-11.345-5.68-21.74599-9.07999-31.19998-3.4-9.455-8.13-19.09799-14.17999-28.93098-30.25998-21.17898-58.42996-29.49898-84.52994-24.95998-26.08998 4.538-49.53996 17.39599-70.33994 38.57397-20.79999 21.17898-38.18997 48.40796-52.18996 81.68794-13.99 33.27997-24.19998 68.07295-30.62998 104.37892-6.43 36.30597-8.51 71.47995-6.24 105.50992 2.27 34.03998 9.45 62.39995 21.55999 85.09994z" fill="#282828" fill-rule="nonzero"/>
                        <path d="M6892.93785 1141.07765l-2.93-847.33736c-.01-1.191.2-2.374.61-3.492 6.06-16.43098 13.87-28.16497 22.94999-35.51497 9.95999-8.065 20.24998-11.87199 30.67997-11.87199 10.37 0 19.54999 2.66 27.55998 7.845 8.86 5.732 14.1 12.94799 16.18 21.28698.16.625.25 1.264.29 1.908 2.26999 43.93997 4.15999 92.80393 5.67999 146.59289 1.51 53.75096 2.65 109.96191 3.4 168.63387.76 58.61996 1.52 118.75391 2.27 180.39986.76 61.66396 1.33 122.76091 1.71 183.28987.37 60.52995.56 119.1699.56 175.91986 0 56.66996.38 109.18992 1.13999 157.54988.01 1.06-.14 2.12-.46 3.13-4.6 14.73-12.99999 25.43998-24.96998 32.34998-11.7 6.75-23.64998 9.58-35.79997 8.68-12.44-.92-23.51999-5.71-33.19998-14.47-9.87-8.93-15.19999-21.69998-15.19999-38.57997l-.25-72.25994c-2.06 5.06-4.48 10.24999-7.27 15.58998-9.08998 17.41-21.52998 34.43998-37.35996 51.04997-16.08 16.88998-34.38998 29.74997-54.89996 38.58997-20.83999 8.98999-43.70997 12.12999-68.62995 9.25999-24.60998-2.82-50.33996-15.20999-76.94994-37.68997-7.62-5.23-15.41999-14.25-23.02998-27.34998-6.92-11.92-13.84-24.98998-20.75999-39.21997-6.83-14.02-13.64999-28.23998-20.46998-42.63997-6.53-13.77999-13.4-25.75998-20.65999-35.90997-6.62-9.27-13.48999-16.15999-20.76998-20.45999-4.67-2.76-9.71-2.7-15.12-.35-14.69998 24.18998-29.57997 47.66997-44.62996 70.42995-16.00999 24.20998-33.58997 44.87997-52.71996 62.05995-19.67998 17.66999-42.16997 30.11998-67.46995 37.34997-25.32998 7.23-54.88996 6.63-88.72993-2.23-33.15997-8.89999-60.03995-26.31997-80.66994-52.20995-20.07998-25.18998-35.06997-55.08996-44.90996-89.72994-9.7-34.10997-14.57-71.50994-14.57-112.21991 0-40.42697 4.43-80.66694 13.29-120.71491 8.84999-40.02697 21.73998-78.51394 38.67997-115.46191 17.08998-37.28898 37.69997-69.31695 61.77995-96.11793 24.43998-27.19398 52.23996-47.66197 83.36994-61.45595 31.65997-14.024 65.90995-17.899 102.88992-11.467 34.67997 6.452 63.26995 21.24799 85.85994 44.23397 21.94998 22.34798 40.20996 49.38096 54.70995 81.13794 14.28 31.25498 25.48998 65.78695 33.58998 103.60192 7.97 37.19097 15.17999 74.38195 21.62998 111.57192 6.42 37.00197 12.84 72.31194 19.25999 105.91192 6.27 32.82997 14.53999 61.05995 24.85998 84.65993 9.73 22.24999 21.89998 38.70997 36.83997 49.12997 13.55 9.45999 31.25998 10.32999 53.02996 3.92 30.31998-30.90998 54.72996-51.40997 73.05995-61.72996 12.16999-6.84 22.40998-10.8 30.62997-12.17 7.06-1.17999 12.97-.53999 17.76999 1.42 3.08 1.26 5.82 2.97 8.15 5.15zm171.26987-850.82935c-.41 1.118-.62 2.301-.62 3.492l3.4 983.65725c0 16.87999 5.34 29.64998 15.21 38.57997 9.67998 8.76 20.75997 13.55 33.19997 14.47 12.14999.9 24.09998-1.93 35.79997-8.68 11.95999-6.91 20.36998-17.61999 24.96998-32.34998.32-1.01.47-2.07.45-3.13-.75-48.35996-1.13-100.87992-1.13-157.54988 0-56.74995-.19-115.3899-.57-175.91986-.38-60.52896-.94-121.62591-1.7-183.28987-.76-61.64595-1.51-121.7799-2.27-180.39986-.76-58.67196-1.89-114.88291-3.41-168.63387-1.51-53.78896-3.4-102.65292-5.67999-146.5929-.03-.644-.13-1.283-.28-1.90799-2.09-8.339-7.32-15.55499-16.17999-21.28698-8.02-5.185-17.18998-7.845-27.55998-7.845-10.43999 0-20.71998 3.807-30.68997 11.872-9.08 7.34999-16.88999 19.08398-22.93999 35.51497zm1588.0788 521.3466c11.02-11.49199 21.36999-24.98198 31.06998-40.44997 14.03-22.37998 28.44998-44.75996 43.23997-67.13995 15.13999-22.89798 31.63998-43.26796 49.48996-61.12095 18.93999-18.93699 41.57997-30.45998 67.67995-34.53497 52.65996-9.574 97.29993-3.098 133.9899 18.84098 36.21997 21.64899 65.98995 52.69896 89.20993 93.24193 22.76999 39.74697 40.15997 85.84694 52.12996 138.3279 11.82 51.85696 20.20999 103.90492 25.15998 156.14788 4.96 52.18996 7.05 102.09992 6.29 149.72989-.77 47.60996-2.68 86.64993-5.73 117.1199-.11 1.16-.43 2.28-.92 3.32-10.40999 21.74999-24.99998 31.77998-42.49996 31.77998-17.48999 0-32.07998-10.03-42.48997-31.77997-.56-1.17-.88-2.44-.96-3.73-2.26-39.21997-5.65-82.00994-10.18-128.3799-4.51999-46.29997-10.53998-92.40994-18.06998-138.3399-7.51-45.82997-16.51999-89.21993-27.03998-130.1689-10.38999-40.41497-22.58998-74.53795-36.67997-102.34693-13.35999-26.36698-28.42998-45.00796-45.64997-55.55495-15.47998-9.474-32.93997-7.465-52.51996 4.536-22.56998 13.82998-47.26996 41.87496-74.56994 83.72993-28.12998 43.12897-59.40996 105.21592-93.90993 186.22486-.08.19-.17.37-.26.55-2.91 5.83-6.71 15.30999-11.45 28.42998-4.88999 13.53999-10.15998 28.77998-15.79998 45.70996-5.7 17.09-11.95999 35.12998-18.79998 54.11996-6.77 18.80999-12.98 36.85997-18.61999 54.16996-5.68 17.41999-10.79 32.93998-15.33999 46.57997-4.39 13.16999-7.33 23.04998-8.8 29.63997-.12.52-.28 1.04-.48 1.54-7.70999 19.27999-18.35998 29.19998-29.92997 31.59998-11.43 2.39-22.87998.41-34.30997-6.25-10.03-5.85-19.24999-13.76999-27.59998-23.78998-8.86-10.63999-13.93-20.08998-15.7-28.05998-.33999-1.54-.30999-3.14.08-4.66 6.74-26.20997 12.73-55.41995 17.97-87.60993 5.25-32.26997 9.36999-69.03995 12.36999-110.30991 3.01-41.34297 4.13-88.13794 3.38-140.3819-.75-52.31096-4.52-111.58291-11.29-177.81786-.19-1.829.13-3.674.92-5.332 10.19-21.30698 21.57999-32.05198 31.76998-34.36797 11.17999-2.541 22.52998.468 33.70997 10.12499 9.13 7.881 17.73999 19.41898 25.61998 34.76697 7.34 14.288 13.9 28.76898 19.68999 43.44197 5.82 14.74199 10.46999 28.51598 13.95999 41.31797.7 2.54 1.32 4.919 1.87 7.135zm-1260.43904 469.29265c-45.43997-18.81999-81.21994-43.59997-107.46992-74.15995-26.30998-30.62997-44.73997-64.20995-55.34996-100.72992-10.55-36.33997-14.07999-74.42994-10.56-114.28691 3.48-39.54797 12.79-78.12894 27.90999-115.73892 15.06999-37.49597 35.16997-72.86794 60.28995-106.11092 25.18998-33.31797 53.85996-61.78595 86.01994-85.41793 32.32997-23.76398 67.77995-41.29597 106.34992-52.59396 38.82997-11.373 79.02994-13.941 120.6799-7.653 35.51998 5.652 66.02996 22.35899 91.46994 50.21697 24.64998 26.99898 44.25996 60.42495 58.73995 100.33692 14.28 39.36297 23.36998 82.58094 27.22998 129.6629 3.85 46.99997 1.73 93.42293-6.36 139.2649-8.10999 45.98996-22.03998 88.68993-41.74996 128.1099-20.00999 40.01997-46.33997 72.36995-78.90994 97.08993-32.80998 24.89998-72.49995 39.61997-119.13991 43.96996-46.01997 4.29-99.08993-6.22-159.14988-31.95997zm642.41951 0c-45.43996-18.81999-81.21994-43.59997-107.46992-74.15995-26.30998-30.62997-44.73996-64.20995-55.33995-100.72992-10.55-36.33997-14.08-74.42994-10.57-114.28691 3.49-39.54797 12.79-78.12894 27.90998-115.73892 15.08-37.49597 35.17998-72.86794 60.29996-106.11092 25.17998-33.31797 53.85996-61.78595 86.00993-85.41793 32.33998-23.76398 67.78995-41.29597 106.35992-52.59396 38.82997-11.373 79.01994-13.941 120.66991-7.653 35.52997 5.652 66.03995 22.35899 91.47993 50.21697 24.64998 26.99898 44.25997 60.42495 58.73996 100.33692 14.27999 39.36297 23.36998 82.58094 27.22998 129.6629 3.85 46.99997 1.73 93.42293-6.36 139.2649-8.12 45.98996-22.03998 88.68993-41.74997 128.1099-20.00998 40.01997-46.33996 72.36995-78.90994 97.08993-32.80997 24.89998-72.49994 39.61997-119.1399 43.96996-46.01997 4.29-99.09993-6.22-159.15989-31.95997zM6968.3578 276.0543c-1.1-3.399-3.7-6.152-7.41999-8.557-4.84-3.135-10.41999-4.636-16.68999-4.636-6.2 0-12.17999 2.622-18.09998 7.417-6.5 5.259-11.73 13.762-16.13999 25.24198l3.4 981.84726c0 10.31 2.6 18.33999 8.62 23.77998 6.20999 5.62 13.27998 8.76 21.25998 9.36 8.26999.61 16.35998-1.47 24.32998-6.07 7.31-4.21 12.36999-10.78 15.39999-19.52998-.75-47.98997-1.12-100.04993-1.12-156.16989 0-56.70995-.19-115.30991-.56-175.79486-.38-60.48896-.95-121.54591-1.7-183.16987-.76-61.64195-1.52-121.7709-2.27-180.38686-.76-58.56596-1.89-114.67491-3.4-168.32887-1.5-53.15996-3.37-101.49493-5.61-145.0029zm173.57988 0c-1.1-3.399-3.69-6.152-7.41-8.557-4.84-3.135-10.42-4.636-16.68999-4.636-6.21 0-12.17999 2.622-18.09998 7.417-6.5 5.259-11.74 13.762-16.14 25.24198l3.39 981.84726c0 10.31 2.61 18.33999 8.63 23.77998 6.2 5.62 13.27999 8.76 21.25998 9.36 8.27.61 16.36-1.47 24.31999-6.07 7.31-4.21 12.36999-10.78 15.39998-19.52998-.74-47.98997-1.11-100.04993-1.11-156.16989 0-56.70995-.19-115.30991-.57-175.79486-.37-60.48896-.94-121.54591-1.7-183.16987-.75-61.64195-1.51-121.7709-2.27-180.38686-.75-58.56596-1.88999-114.67491-3.39999-168.32887-1.49-53.15996-3.36-101.49493-5.61-145.0029zm-1474.8589 611.05154c32.78998-28.61098 66.40996-46.87097 100.71993-54.98596 39.23997-9.282 76.29994-8.777 111.17992 1.375 34.64997 10.08599 66.35995 27.64098 95.10993 52.71196 28.56997 24.91798 51.24996 53.42596 68.07995 85.50393 16.88998 32.18698 26.89997 66.10695 30.03997 101.73693 3.2 36.27997-3.42 70.20994-19.80998 101.79992-16.27999 31.37997-43.34997 58.53995-81.47994 81.19994-37.32997 22.19998-87.83993 36.60997-151.58989 42.86996-27.29998 2.78-50.99996 5-71.08994 6.66-20.60999 1.71-40.05997 1.84-58.32996.42-18.53999-1.44-37.47997-5.33-56.80996-11.68-18.96998-6.22999-40.84997-15.83998-65.62995-28.87997-2.81-1.47-4.75-4.19-5.23-7.32-5.32999-34.52997-9.70999-71.83994-13.12998-111.92991-3.41-39.95997-6.26-81.15994-8.53-123.6199-2.28-42.45897-3.79-85.47694-4.55-129.0499-.76-43.51098-1.14-86.18994-1.14-128.03791 0-41.85797.38-82.05394 1.14-120.58691.76-38.56197 1.89-74.48795 3.41-107.77892.03-.637.12-1.27.27-1.889 3.13-12.99999 11.18-21.65098 24.23999-25.85598 10.86999-3.498 22.58998-4.353 35.19997-2.445 12.24999 1.856 23.43998 5.739 33.57997 11.614 12.52 7.25499 18.62999 16.35998 19.67999 26.28797.05.506.07 1.016.04 1.524-1.51 31.47298-2.64 62.25596-3.39 92.34793-.75 29.95198-.57 59.49096.56 88.61794 1.12 29.08597 3.37 58.30895 6.75 87.66993 2.72 23.63898 6.28 47.54596 10.70999 71.71995zm992.55926 378.53171c-5.84-3.89-11.48-11.03-17.31999-21.08998-6.7-11.53-13.38999-24.16999-20.07998-37.92998-6.79-13.95998-13.58-28.10997-20.37999-42.44996-7.08-14.97-14.57999-27.94998-22.44998-38.97997-8.51-11.9-17.51999-20.51999-26.87998-26.04998-11.32-6.69-23.67998-6.83-37.05997.37-1.57.85-2.88 2.1-3.81 3.62-15.05999 24.84997-30.29998 48.93996-45.73996 72.27994-15 22.68998-31.45998 42.10997-49.38997 58.20995-17.37998 15.61-37.24997 26.60998-59.59995 32.99998-22.31999 6.37-48.34997 5.46-78.10994-2.33-28.79998-7.73-52.21996-22.82998-70.15995-45.34996-18.49999-23.20999-32.24998-50.79997-41.31997-82.71994-9.21-32.44998-13.79999-68.03995-13.79999-106.75992 0-38.98097 4.27-77.78094 12.81-116.39591 8.54998-38.63497 20.98998-75.78495 37.33996-111.44792 16.19-35.32397 35.65998-65.69495 58.47996-91.08393 22.45998-24.99598 47.97996-43.85797 76.59994-56.53696 28.08998-12.44899 58.50996-15.75999 91.23993-10.069 30.24998 5.628 55.35996 18.44 75.12995 38.56698 20.39998 20.76598 37.30997 45.92097 50.78996 75.43094 13.70999 30.00998 24.43998 63.17396 32.21997 99.48293 7.92 36.93297 15.08 73.86594 21.48999 110.79991 6.43 37.12298 12.86999 72.53295 19.30998 106.24292 6.59 34.48998 15.34 64.12996 26.18998 88.92994 11.45 26.16998 26.13998 45.24996 43.71997 57.51995 18.48999 12.9 42.71997 15.33 72.81994 5.87 1.58-.49 3.01-1.37 4.16-2.55 29.34998-30.08998 52.73996-50.19996 70.35995-60.09995 8.15-4.59 15.17999-7.72 21.11998-9.24 4.06-1.05 7.35-1.48 9.9-.44 4.83 1.98 5.26 7.53 4.6 15.45-1.04 12.47998-5.67 26.31997-13.65 41.57996-8.3 15.86999-19.68998 31.36998-34.11997 46.51997-14.17 14.87998-30.26998 26.22998-48.33997 34.01997-17.73998 7.65-37.21997 10.19-58.42995 7.76-21.40999-2.46-43.55997-13.78-66.71995-33.42998l-.92-.7zm2465.44814 12.35c2.91-29.76999 4.72-67.65996 5.46-113.66992.75-46.92997-1.32-96.09993-6.2-147.5199-4.87-51.38895-13.12999-102.58491-24.74998-153.59388-11.49-50.38496-28.12998-94.67092-49.98996-132.8309-21.39999-37.36197-48.73997-66.06595-82.10994-86.01693-32.88998-19.65999-72.95995-24.90898-120.38991-16.28799-22.05998 3.447-41.01997 13.102-56.87996 28.95798-16.93999 16.93999-32.57997 36.27997-46.93996 58.00796-14.71 22.24498-29.03998 44.49096-42.98997 66.73695-14.56999 23.23798-30.54998 42.31396-47.87996 57.28095-2.96 2.557-7.14 3.153-10.7 1.525-3.56-1.628-5.84-5.181-5.84-9.093 0-3.38099-1.70999-10.60698-4.74999-21.76198-3.32-12.15799-7.74-25.23598-13.26999-39.23597-5.55-14.06799-11.84999-27.95098-18.87998-41.64996-6.49-12.637-13.39-22.27799-20.89999-28.76698-5.47-4.718-10.73999-7-16.20999-5.759-2.45.558-4.67 2.587-7.11999 5.432-3.3 3.817-6.54 9.02999-9.82 15.58699 6.66 65.73995 10.36 124.6399 11.11 176.70886.76 52.89196-.39 100.26493-3.43 142.1199-3.05 41.92996-7.25 79.28994-12.57999 112.06991-5.18 31.79998-11.08 60.72995-17.68999 86.79993 1.68 5.13 5.45 10.9 10.96 17.51 6.77 8.11999 14.18999 14.57998 22.31998 19.31998 6.72 3.93 13.41999 5.36 20.14998 3.96 6.46-1.35 10.86-8.16 15.16-18.77 1.62-7.01999 4.65999-17.27998 9.15999-30.76997 4.53-13.58999 9.62999-29.07998 15.29998-46.44996 5.7-17.48999 11.97-35.73998 18.80999-54.74996 6.78-18.82999 12.99999-36.71997 18.63999-53.65996 5.71-17.10999 11.02999-32.49998 15.96998-46.18997 5.02-13.88999 9.11-23.97298 12.22-30.26797 35.04997-82.24394 66.88994-145.2539 95.45992-189.06286 29.42998-45.12797 56.52996-74.94494 80.85994-89.85593 27.31998-16.744 51.82996-17.75999 73.41995-4.541 19.83998 12.144 37.66997 33.21197 53.04996 63.57295 14.64998 28.91898 27.40998 64.38095 38.20997 106.40992 10.65999 41.49597 19.79998 85.46594 27.40998 131.9149 7.6 46.34997 13.67999 92.88993 18.23998 139.6299 4.47 45.84996 7.84 88.22993 10.12 127.1199 6.08999 12 13.56998 18.70999 23.59998 18.70999 10.08999 0 17.58998-6.77 23.68998-18.86999zm-1725.4887-15.54c-42.25997-17.47998-75.64994-40.33997-100.04992-68.74995-24.36999-28.36997-41.48997-59.44995-51.30996-93.27993-9.87-33.99997-13.14-69.64994-9.85-106.94891 3.31-37.60098 12.17-74.27895 26.53998-110.03592 14.43-35.87297 33.65998-69.70795 57.69996-101.51292 23.97998-31.72998 51.27996-58.85496 81.89994-81.36094 30.43997-22.37399 63.81995-38.87897 100.12992-49.51597 36.05997-10.56199 73.38995-12.91099 111.98992-7.084 30.95997 4.925 57.54995 19.607 79.76994 43.93898 22.99998 25.18998 41.19997 56.43395 54.70996 93.67193 13.70999 37.78597 22.38998 79.28094 26.09998 124.4769 3.71 45.27597 1.67 89.99593-6.12 134.1609-7.77 44.01997-21.07998 84.89994-39.94997 122.6299-18.55999 37.11998-42.89997 67.17996-73.10994 90.10994-29.96998 22.74998-66.29995 36.00997-108.90992 39.98997-43.22997 4.03-93.00993-6.26-149.42989-30.43998l-.11-.05zm642.41952 0c-42.24997-17.47998-75.63995-40.33997-100.04993-68.74995-24.35998-28.36997-41.47997-59.44995-51.29996-93.27993-9.87-33.99997-13.14999-69.64994-9.86-106.94891 3.32-37.60098 12.17-74.27895 26.54999-110.03592 14.41999-35.87297 33.65997-69.70795 57.69995-101.51292 23.97999-31.72998 51.27997-58.85496 81.89994-81.36094 30.43998-22.37399 63.81995-38.87897 100.12993-49.51597 36.05997-10.56199 73.38994-12.91099 111.98991-7.084 30.94998 4.925 57.54996 19.607 79.76994 43.93898 22.99999 25.18998 41.19997 56.43395 54.70996 93.67193 13.7 37.78597 22.38998 79.28094 26.08998 124.4769 3.71 45.27597 1.68 89.99593-6.12 134.1609-7.76999 44.01997-21.06998 84.89994-39.93996 122.6299-18.55999 37.11998-42.90997 67.17996-73.10995 90.10994-29.96998 22.74998-66.29995 36.00997-108.90992 39.98997-43.22996 4.03-93.00993-6.26-149.42988-30.43998l-.12-.05zM5632.4288 546.7151c-.72-4.174-4.34-7.351-9.72999-10.47199-8.01-4.642-16.86999-7.678-26.54998-9.144-9.33-1.413-18.01998-.883-26.06998 1.707-5.56 1.792-9.16 5.322-10.71 10.675-1.47999 32.83197-2.59999 68.23495-3.33999 106.20592-.76 38.40597-1.14 78.47094-1.14 120.1929 0 41.73398.38 84.29694 1.14 127.68891.75 43.32997 2.26 86.10694 4.52 128.3289 2.26 42.23997 5.09 83.22994 8.49 122.97991 3.21999 37.68997 7.27999 72.88995 12.20998 105.58992 21.78999 11.26 41.14997 19.67999 58.09996 25.24998 17.72999 5.83 35.09997 9.42 52.10996 10.74 17.26999 1.35 35.64997 1.2 55.11996-.41 19.99998-1.66 43.56997-3.87 70.75994-6.63 60.26996-5.91 108.08992-19.17999 143.3599-40.15997 34.48997-20.49998 59.21995-44.82997 73.94994-73.21994 14.61999-28.18998 20.48999-58.46996 17.63999-90.82994-2.91-32.99997-12.19-64.39995-27.82998-94.20593-15.68999-29.91597-36.86997-56.48395-63.51995-79.72193-26.46998-23.08499-55.63996-39.29498-87.54994-48.58197-31.67997-9.221-65.34995-9.546-100.98992-1.115-35.87997 8.488-70.76995 29.33298-104.83992 62.22396-2.63 2.541-6.44 3.442-9.93 2.349-3.49-1.093-6.10999-4.005-6.81999-7.594-6.11-30.71598-10.88-61.01395-14.30999-90.89293-3.43-29.86598-5.72-59.59296-6.86-89.17993-1.15-29.54598-1.34-59.50996-.58-89.89194.75-29.94797 1.88-60.57595 3.37-91.88193zm15.14 553.17259c13.18998-52.14997 29.57997-92.78993 48.95996-122.00191 19.95998-30.08698 41.44996-51.27696 64.19995-63.83695 23.53998-12.994 47.49996-17.891 71.86994-14.869 23.73999 2.944 46.07997 10.883 66.99995 23.83899 20.53999 12.71799 39.10997 28.89298 55.69996 48.54796 16.63999 19.71899 29.09998 40.32097 37.41997 61.78096 8.47 21.83998 12.25 43.24996 11.45 64.19995-.86 22.23998-9.01 41.18997-24.34999 56.78995-18.82998 19.51999-41.36997 36.46998-67.63995 50.81997-26.01998 14.20999-52.61996 25.13998-79.79994 32.80997-27.39998 7.74-54.02996 11.59-79.85994 11.59-26.84998 0-49.58996-5.2-68.29994-15.32-19.60999-10.60999-33.33998-27.23998-41.01997-50.02996-7.32-21.70998-6.15-49.83996 4.37-84.31993zm19.33998 5.12c12.51999-49.58997 27.86998-88.30994 46.28996-116.06692 17.85999-26.92498 36.82998-46.14197 57.19996-57.38296 19.56999-10.80799 39.46997-15.04399 59.73996-12.52999 20.87998 2.59 40.51996 9.597 58.92995 20.99499 18.78999 11.63699 35.76997 26.45898 50.94996 44.44396 15.12 17.92099 26.48998 36.61097 34.04998 56.11096 7.42 19.12999 10.81999 37.84997 10.10999 56.19996-.65 17.04998-6.87 31.58997-18.68999 43.59996-17.54998 18.2-38.49997 33.89998-62.89995 47.22997-24.65998 13.46999-49.86996 23.83998-75.63994 31.10998-25.53998 7.20999-50.34996 10.83999-74.42995 10.83999-23.07998 0-42.69996-4.21-58.77995-12.91-15.18-8.20999-25.64998-21.19998-31.58998-38.81996-6.28-18.63999-4.44-42.72997 4.63-72.33995l.13-.48zm1723.4387 80.90993c51.62996 33.36998 98.03992 46.77997 138.9499 41.21997 41.29996-5.61 75.97994-23.27998 104.04991-52.95996 27.45998-29.02998 48.13997-66.05995 61.86996-111.16992 13.55999-44.57996 19.37998-90.12293 17.43998-136.6379-1.95-46.72396-12.08999-90.13293-30.38997-130.2379-18.71999-41.02096-47.21997-71.85994-85.45994-92.56893-23.01998-11.93999-49.70996-11.81599-80.18994 1.31-28.27998 12.173-56.00995 31.74398-83.09993 58.84096-26.66998 26.66498-50.83997 58.53395-72.47995 95.63293-21.75998 37.30897-36.50997 75.59694-44.27997 114.84991-7.87999 39.75097-6.86 78.13094 2.98 115.13091 10.02 37.67997 33.31998 69.85995 70.19995 96.31993l.41.27zm642.41951 0c51.62996 33.36998 98.04993 46.77997 138.9499 41.21997 41.30997-5.61 75.98994-23.27998 104.05992-52.95996 27.45998-29.02998 48.12996-66.05995 61.86995-111.16992 13.56-44.57996 19.37999-90.12293 17.43999-136.6379-1.95-46.72396-12.09-90.13293-30.38998-130.2379-18.71998-41.02096-47.22996-71.85994-85.45993-92.56893-23.01998-11.93999-49.70996-11.81599-80.18994 1.31-28.27998 12.173-56.00996 31.74398-83.10994 58.84096-26.65998 26.66498-50.82996 58.53395-72.46994 95.63293-21.76999 37.30897-36.51998 75.59694-44.28997 114.84991-7.87 39.75097-6.86 78.13094 2.98 115.13091 10.02999 37.67997 33.32997 69.85995 70.20994 96.31993l.4.27zm11.07-16.65999c46.60996 30.07998 88.23993 43.08997 125.1899 38.06997 36.59997-4.98 67.34995-20.58998 92.21993-46.88996 25.47998-26.93998 44.51997-61.38995 57.25996-103.24992 12.90999-42.40997 18.43998-85.73594 16.58999-129.9859-1.83-44.03997-11.35-84.96594-28.59998-122.76691-16.82999-36.88497-42.40997-64.66495-76.62995-83.20194-17.97998-9.323-38.93997-8.313-62.91995 2.009-26.17998 11.274-51.76996 29.52098-76.85994 54.61396-25.52998 25.52498-48.62996 56.05596-69.34995 91.56793-20.58998 35.30297-34.57997 71.51695-41.93997 108.65792-7.24999 36.63597-6.38 72.00594 2.69 106.10592 8.87 33.34997 29.74998 61.62995 62.34996 85.06993zm-642.42952 0c46.60996 30.07998 88.24993 43.08997 125.1899 38.06997 36.59998-4.98 67.34995-20.58998 92.21994-46.88996 25.48998-26.93998 44.51996-61.38995 57.25995-103.24992 12.91-42.40997 18.43999-85.73594 16.59999-129.9859-1.84-44.03997-11.36-84.96594-28.60998-122.76691-16.82999-36.88497-42.39997-64.66495-76.61994-83.20194-17.97999-9.323-38.94997-8.313-62.91995 2.009-26.18998 11.274-51.77996 29.52098-76.86995 54.61396-25.52998 25.52498-48.62996 56.05596-69.33994 91.56793-20.59999 35.30297-34.58998 71.51695-41.94997 108.65792-7.25 36.63597-6.37 72.00594 2.7 106.10592 8.86999 33.34997 29.73997 61.62995 62.33995 85.06993zm-1173.21912-25.98998c21.51999 33.09998 44.56997 51.54996 68.15995 56.51996 24.03999 5.06 47.46997.75 70.23995-13.16999 21.39998-13.06999 41.66997-32.41998 60.68995-58.17996 18.56-25.12998 34.41998-52.00996 47.55997-80.61994 13.16999-28.64997 22.83998-56.73495 29.03998-84.22993 6.4-28.42898 7.83-51.86396 4.63-70.28295l-.06-.326c-3.75-17.97399-6.74-34.07597-8.99-48.30596-2.31-14.636-4.82-27.73198-7.52-39.28697-2.74-11.752-5.86999-22.52199-9.39999-32.31498-3.62-10.059-8.64-20.32498-15.06999-30.78498-.72-1.164-1.67-2.168-2.79-2.952-32.86997-23.00798-63.61995-31.54997-91.96992-26.61997-28.08998 4.885-53.36996 18.62598-75.75995 41.41997-21.60998 21.99998-39.73997 50.24796-54.27996 84.81893-14.26999 33.96098-24.69998 69.46395-31.25997 106.51092-6.57 37.13497-8.69 73.11395-6.37 107.92392 2.38 35.65997 10.03 65.34995 22.70999 89.12993l.44.75zm223.31984-388.7207c-26.98998-18.50399-52.01996-26.18998-75.36995-22.12799-24.10998 4.192-45.70996 16.16699-64.91995 35.72898-19.99998 20.35698-36.65997 46.56796-50.10996 78.55694-13.70999 32.59997-23.70998 66.68295-29.99998 102.24692-6.29 35.47697-8.33 69.84595-6.11 103.10592 2.15 32.21998 8.8 59.13996 20.2 80.67994 17.73998 27.17998 35.82996 43.38997 55.26995 47.47996 19.06999 4.02 37.61997.38 55.68996-10.65999 19.44998-11.87999 37.74997-29.59997 55.02996-52.99996 17.74998-24.02998 32.90997-49.72996 45.47996-77.08994 12.55-27.30998 21.78999-54.06896 27.68998-80.27594 5.69-25.21598 7.29-45.98996 4.46-62.34495-3.79-18.24499-6.83-34.59698-9.12-49.05396-2.22-14.106-4.63-26.72698-7.22999-37.86298-2.55-10.93899-5.47-20.96898-8.75-30.08497-2.98-8.28-7.05999-16.709-12.20998-25.29798z" fill="#fff"/>
                    </g>
                </svg>
            </span>
            <br />

            <span style="width: 34px; top: -5px;"><svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="facebook" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-facebook fa-w-16 fa-2x"><path fill="#475e8f" d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z" class=""></path></svg></span>

			<?php echo $plus_svg; ?>

            <span><svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="instagram" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-instagram fa-w-14 fa-2x"><path fill="#e15073" d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z" class=""></path></svg></span>

			<?php echo $plus_svg; ?>

            <span style="top: -4px;"><svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="twitter" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-twitter fa-w-16 fa-2x"><path fill="#1a92dc" d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z" class=""></path></svg></span>

			<?php echo $plus_svg; ?>

            <span style="width: 35px; top: -5px;"><svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="youtube" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" class="svg-inline--fa fa-youtube fa-w-18 fa-2x"><path fill="#f5413d" d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z" class=""></path></svg></span>
        </div>

        <h1>Combine all your social media channels into one single wall.</h1>
        <h2>Maximize your social content and get more followers.</h2>

        <div style="text-align: center;">
            <a href="https://smashballoon.com/social-wall/?utm_source=plugin-pro&utm_campaign=ctf&utm_medium=sw-cta-1" target="_blank" class="cta button button-primary">Get the Social Wall plugin</a>
        </div>

        <div class="ctf-sw-info">
            <div class="ctf-sw-features">
                <p><span>A dash of Instagram</span>Add posts from your profile, public hashtag posts, or posts you're tagged in.</p>
                <p><span>A sprinkle of Facebook</span>Include posts from your page or group timeline, or from your photos, videos, albums, and events pages.</p>
                <p><span>A spoonful of Twitter</span>Add Tweets from any Twitter account, hashtag Tweets, mentions, and more.</p>
                <p><span>And a dollop of YouTube</span>Embed videos from any public YouTube channel, playlists, searches, and more.</p>
                <p><span>All in the same feed</span>Combine feeds from all of our Smash Balloon Pro plugins into one single wall feed, and show off all your social media content in one place.</p>
            </div>
            <a class="ctf-sw-screenshot" href="https://smashballoon.com/social-wall/demo?utm_source=plugin-pro&utm_campaign=ctf&utm_medium=sw-demo" target="_blank">
                <span class="cta">View Demo</span>

                <img src="<?php echo CTF_PLUGIN_URL .  'img/sw-screenshot.png'; ?>" alt="Smash Balloon Social Wall plugin screenshot showing Facebook, Instagram, Twitter, and YouTube posts combined into one wall.">
            </a>
        </div>

        <div class="ctf-sw-footer-cta">
            <a href="https://smashballoon.com/social-wall/?utm_source=plugin-pro&utm_campaign=ctf&utm_medium=sw-cta-2" target="_blank"><span>🚀</span>Get Social Wall and Increase Engagement >></a>
        </div>

    </div>

	<?php
}