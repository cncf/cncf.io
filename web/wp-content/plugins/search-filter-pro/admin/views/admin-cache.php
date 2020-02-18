<?php
/**
 * Created by PhpStorm.
 * User: DrMorse
 * Date: 07/10/2016
 * Time: 14:03
 */

?>
<div class="wrap">

    <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

    <?php

    if(!$cache_options)
    {
        _e('Cache has not started yet...', $this->plugin_slug);
    }
    else
    {
    ?>

        <p>
            <?php

            $status = $cache_options['status'];
            $current_post = $cache_options['current_post_index'];
            $total_posts = $cache_options['total_post_index'];
            $progress_percent = $cache_options['progress_percent'];
            $last_update = $cache_options['last_update'];
            $error_count = $cache_options['error_count'];
            $locked = $cache_options['locked'];
            $restart = $cache_options['restart'];
            $caching_data = $cache_options['caching_data'];
            $cache_list = $cache_options['cache_list'];

            $connection_status = $cache_options['rc_status'];

            $connection_text = "";

            $run_method = "automatic";
            if(isset($cache_options['run_method']))
            {
                $run_method = $cache_options['run_method'];
            }


            //warn if any duplicates in cache
            $cache_list_duplicates = array_unique( array_diff_assoc( $cache_list, array_unique( $cache_list ) ) );

            if($connection_status=="connect_success")
            {
                //wp reomte get works great
                $connection_text = "Success, `wp_remote_post` works";
            }
            else if($connection_status=="user_bypass")
            {
                //means a user changed this in the settings to use Ajax
                $connection_text = "Success, using Ajax | User disabled `wp_remote_post`";
            }
            else if($connection_status=="connect_error")
            {
                //means a wp_remote_post failed
                $connection_text = "Failed, `wp_remote_post";
                if(($status=="inprogress")||($status=="termcache"))
                {
                    $connection_text .= " | Looks like its resumed via Ajax because status is `$status``";
                }
            }
            else if($connection_status=="routing_error")
            {
                //means a wp_remove_get worked, but didn't contain the data we expected
            }
            /*else if($connection_status=="termcache")
            {
                //historic - used to be the process that ran after the build of the main cache table (when the term table was built separately after the cache table
            }*/




            ?>


        </p>
        <table class="form-table">
            <tbody>

            <tr valign="top">
                <th scope="row" valign="top">
                    <?php _e('Status: ', $this->plugin_slug); ?>
                </th>
                <td>
                    <strong><?php echo $status; ?></strong>
                    <?php
                        if($restart==true)
                        {
                            echo "<br /><em style=\"font-weight:normal;color:#888888;\">".__('Restarting ', $this->plugin_slug)."</em>";

                        }
                    ?>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row" valign="top">
                    <?php _e('Current Progress: ', $this->plugin_slug); ?>
                </th>
                <td>
                    <strong><?php echo $current_post; ?> / <?php echo $total_posts; ?> (<?php echo $progress_percent; ?>%)</strong><br />
                    <em style="font-weight:normal;color:#888888;"><?php echo sprintf(__('Last Updated: %s', $this->plugin_slug), date(DATE_RFC2822, $last_update)); ?></em>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row" valign="top">
                    <?php _e('Run Method: ', $this->plugin_slug); ?>
                </th>
                <td>
                    <span id="search-filter-cache-method-value"><?php echo $run_method; ?></span> <a href="#" id="search-filter-cache-method-switch">(<?php _e('switch', $this->plugin_slug); ?>)</a>
                    <?php
                    if($run_method=="manual")
                    ///if($run_method=="automatic")
                    {
                        ?>
                        <br />
                        <br />

                        <!--<input type="hidden" id="search-filter-cache-manual-url" ="<?php echo esc_url(add_query_arg('action', 'cache_progress', admin_url( 'admin-ajax.php' ))); ?>" />-->
                        <!--PAGE <input type="number" id="sfdc-movies-paged" value="1" step="1" />-->
                        <button style="margin-bottom:10px;" id="search-filter-cache-manual-continue">Continue Cache &gt; &gt;</button> <button id="search-filter-cache-manual-restart">Restart</button><br />
                        <label><input type="checkbox" id="search-filter-cache-auto-load" />Auto Load the Next Posts?</label>
                        <pre style="width:500px;background-color:#dddddd; padding:10px;max-height:250px;overflow-y:scroll;" id="search-filter-cache-manual-output"></pre>
                        <?php
                    }
                    ?>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row" valign="top">
                    <?php _e('Connection Status: ', $this->plugin_slug); ?>
                </th>
                <td>
                    <?php echo $connection_text; ?>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row" valign="top">
                    <?php _e('Locked: ', $this->plugin_slug); ?>
                </th>
                <td>
                    <?php echo ($locked == true) ? "True" : "False"; ?>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row" valign="top">
                    <?php _e('Error Count: ', $this->plugin_slug); ?>
                </th>
                <td>
                    <?php echo $error_count; ?>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row" valign="top">
                    <?php _e('Cache List', $this->plugin_slug); ?>
                </th>
                <td>
                    <?php
                    if(!empty($cache_list_duplicates))
                    {
                        echo '<strong>'.__("Notice: Duplicates Found: ", $this->plugin_slug).'</strong>';
                        ?>
                        <pre style="width:500px;background-color:#dddddd; padding:10px;max-height:250px;overflow-y:scroll;"><?php var_dump($cache_list_duplicates); ?></pre>
                        <?php
                    }

                    ?>
                    <pre style="width:500px;background-color:#dddddd; padding:10px;max-height:250px;overflow-y:scroll;"><?php var_dump($cache_list); ?></pre>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row" valign="top">
                    <?php _e('Cached Data', $this->plugin_slug); ?>
                </th>
                <td>
                    <pre style="width:500px;background-color:#dddddd; padding:10px;max-height:250px;overflow-y:scroll;"><?php var_dump($caching_data); ?></pre>
                </td>
            </tr>

            </tbody>
        </table>

        </p>
        <!--<form method="post" action="options.php">
            <?php submit_button(); ?>
        </form>-->
    <?php
    }
    ?>
</div>
