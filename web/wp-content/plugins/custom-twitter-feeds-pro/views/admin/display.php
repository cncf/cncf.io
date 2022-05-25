<?php ?>

<h3><?php _e( 'Display your Feed', 'custom-twitter-feeds' ); ?></h3>
<p><?php _e( "Copy and paste the following shortcode directly into the page, post or widget where you'd like the feed to show up:", 'custom-twitter-feeds' ); ?></p>
<input type="text" value="[custom-twitter-feeds]" size="20" readonly="readonly" style="text-align: center;" onclick="this.focus();this.select()" title="<?php _e( 'To copy, click the field then press Ctrl + C (PC) or Cmd + C (Mac).', 'custom-twitter-feeds' ); ?>" />

<h3 style="padding-top: 10px;"><?php _e( 'Multiple Feeds', 'custom-twitter-feeds' ); ?></h3>
<p><?php _e( "If you'd like to display multiple feeds then you can set different settings directly in the shortcode like so:", 'custom-twitter-feeds' ); ?>
    </br><code>[custom-twitter-feeds screenname=gopro num=9]</code></p>
<p><?php _e( "You can display as many different feeds as you like, on either the same page or on different pages, by just using the shortcode options below. For example:", 'custom-twitter-feeds' ); ?><br />
    <code>[custom-twitter-feeds]</code><br />
    <code>[custom-twitter-feeds screenname="ANOTHER_SCREEN_NAME"]</code><br />
    <code>[custom-twitter-feeds hashtag="#YOUR_HASHTAG" num=4 showheader=false]</code>
</p>
<p><?php _e( "See the table below for a full list of available shortcode options:", 'custom-twitter-feeds' ); ?></p>

<!-- <p><span class="ctf_table_key"></span><?php _e( 'Pro version only', 'custom-twitter-feeds' ); ?></p> -->

<table class="ctf_shortcode_table">
    <tbody>
        <tr valign="top">
            <th scope="row"><?php _e( 'Shortcode option', 'custom-twitter-feeds' ); ?></th>
            <th scope="row"><?php _e( 'Description', 'custom-twitter-feeds' ); ?></th>
            <th scope="row"><?php _e( 'Example', 'custom-twitter-feeds' ); ?></th>
        </tr>

        <tr class="ctf_table_header"><td colspan=3><?php _e( "Configure Options", 'custom-twitter-feeds' ); ?></td></tr>
        <tr>
            <td>screenname</td>
            <td><?php _e( 'A user account name/Twitter handle. This will generate a user timeline feed. Separate multiple screennames using commas.', 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds screenname="gopro"]</code></td>
        </tr>
        <tr>
            <td>hashtag</td>
            <td><?php _e( 'Any hashtag. This will generate a hashtag feed. Separate multiple hashtags using commas.', 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds hashtag="#awesome"]</code></td>
        </tr>
        <tr class="ctf_pro">
            <td>search</td>
            <td><?php _e( 'Any search term or terms. Can use "OR" or "AND" for complex feeds.', 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds search="#awesome OR @nba"]</code></td>
        </tr>
        <tr>
            <td>home</td>
            <td><?php _e( 'A home timeline will automatically use the account attached to your access token credentials', 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds home=true]</code></td>
        </tr>
        <tr class="ctf_pro">
            <td>mentions</td>
            <td><?php _e( 'A mentions timeline will automatically use the account attached to your access token credentials', 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds mentions=true]</code></td>
        </tr>
        <tr class="ctf_pro">
            <td>lists</td>
            <td><?php _e( 'Any list ID. Use the tool on the "configure" tab to get a list ID', 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds lists="18480038"]</code></td>
        </tr>
        <tr>
            <td>includereplies</td>
            <td><?php _e( '"In reply to" tweets will be included in your feed', 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds includereplies=true]</code></td>
        </tr>
        <tr>
            <td>includeretweets</td>
            <td><?php _e( 'Retweets will be included in your feed', 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds includeretweets=true]</code></td>
        </tr>
        <tr>
            <td>num</td>
            <td><?php _e( 'Number of Tweets to display', 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds num=20]</code></td>
        </tr>

        <tr class="ctf_table_header"><td colspan=3><?php _e("Customize Options", 'custom-twitter-feeds' ); ?></td></tr>
        <tr>
            <td>layout</td>
            <td><?php _e("How posts are arranged visually in the feed.", 'custom-twitter-feeds' ); ?> 'list', 'carousel', or 'masonry'</td>
            <td><code>[instagram-feed layout=carousel]</code></td>
        </tr>
        <tr>
            <td>class</td>
            <td><?php _e( "A custom CSS class added to the feed", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds class="my-class"]</code></td>
        </tr>
        <tr>
            <td>headertext</td>
            <td><?php _e( "Custom text for the header", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds headertext="My Tweets"]</code></td>
        </tr>
        <tr>
            <td>retweetedtext</td>
            <td><?php _e( "Translation for \"Retweeted\"", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds retweetedtext="retuiteó"]</code></td>
        </tr>
        <tr>
            <td>inreplytotext</td>
            <td><?php _e( "Translation for \"In reply to\"", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds inreplytotext="Als Antwort an"]</code></td>
        </tr>
        <tr>
            <td>disablelightbox</td>
            <td><?php _e( "Disable the pop up lightbox for media in the feed", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds disablelightbox=true]</code></td>
        </tr>
        <tr class="ctf_table_header"><td colspan=3><?php _e("Show/Hide Options", 'custom-twitter-feeds' ); ?></td></tr>
        <tr>
            <td>include</td>
            <td><?php _e( "Parts of the Tweet to include in the feed. <b>Available options:</b><br />retweeter, avatar, author, text, date, actions, twitterlink, linkbox, repliedto, media, twittercards", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds include="author,date,text,avatar,logo"]</code></td>
        </tr>
        <tr>
            <td>exclude</td>
            <td><?php _e( "Parts of the Tweet to exclude in the feed. <b>Available options:</b><br />retweeter, avatar, author, text, date, actions, twitterlink, linkbox, repliedto, media, twittercards", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds exclude="retweeter,actions,linkbox,twitterlink"]</code></td>
        </tr>
        <tr>
            <td>showheader</td>
            <td><?php _e( "Include a header for this feed", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds showheader=true]</code></td>
        </tr>
        <tr>
            <td>creditctf</td>
            <td><?php _e( "Include a credit link to the Custom Twitter Feeds homepage at the bottom of the feed", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds creditctf=true]</code></td>
        </tr>
        <tr>
            <td>showbutton</td>
            <td><?php _e( "Show the button that loads more tweets", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds showbutton=false]</code></td>
        </tr>
        <tr class="ctf_table_header"><td colspan=3><?php _e("Date Options", 'custom-twitter-feeds' ); ?></td></tr>
        <tr>
            <td>dateformat</td>
            <td><?php _e( "Number of one of the default date formats", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds dateformat=3]</code></td>
        </tr>
        <tr>
            <td>datecustom</td>
            <td><?php _e( "Manually entered custom date format", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds datecustom="D M jS, Y"]</code></td>
        </tr>
        <tr>
            <td>mtime</td>
            <td><?php _e( "Translation for \"m\" time unit (English minute)", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds mtime="M"]</code></td>
        </tr>
        <tr>
            <td>htime</td>
            <td><?php _e( "Translation for \"h\" time unit (English hour)", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds htime="S"]</code></td>
        </tr>
        <tr>
            <td>nowtime</td>
            <td><?php _e( "Translation for English \"now\"", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds nowtime="jetzt"]</code></td>
        </tr>
        <tr class="ctf_table_header"><td colspan=3><?php _e("Link Options", 'custom-twitter-feeds' ); ?></td></tr>
        <tr>
            <td>disablelinks</td>
            <td><?php _e( "Disable the links in the text of the tweet", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds disablelinks=false]</code></td>
        </tr>
        <tr>
            <td>linktexttotwitter</td>
            <td><?php _e( "Link the tweet text to Twitter", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds linktexttotwitter=false]</code></td>
        </tr>
        <tr>
            <td>twitterlinktext</td>
            <td><?php _e( "Custom text for the Twitter link", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds twitterlinktext="view on Twitter"]</code></td>
        </tr>

        <tr class="ctf_table_header"><td colspan=3><?php _e("Moderation", 'custom-twitter-feeds' ); ?></td></tr>
        <tr>
            <td>includewords</td>
            <td><?php _e( "Show only tweets that include these words or phrases", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds includewords="cute, puppy"]</code></td>
        </tr>
        <tr>
            <td>excludewords</td>
            <td><?php _e( "Show only Tweets that DON'T contain these words or phrases", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds excludewords="ugly, mean"]</code></td>
        </tr>
        <tr>
            <td>includeanyall</td>
            <td><?php _e( "Whether or not any or all of the includewords need to be in the tweet", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds includeanyall="any"]</code></td>
        </tr>
        <tr>
            <td>excludeanyall</td>
            <td><?php _e( "Whether or not any or all of the excludewords need to be in the tweet", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds excludeanyall="all"]</code></td>
        </tr>
        <tr>
            <td>filterandor</td>
            <td><?php _e( "Tweet needs to contain includewords AND/OR doesn't contain excludewords", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds filterandor="and"]</code></td>
        </tr>
        <tr class="ctf_table_header"><td colspan=3><?php _e("Miscellaneous", 'custom-twitter-feeds' ); ?></td></tr>
        <tr>
            <td>multiplier</td>
            <td><?php _e( 'A multiplying factor 1-3 to help with tweet filtering', 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds multiplier=2.25]</code></td>
        </tr>
        <tr>
            <td>persistentcache</td>
            <td><?php _e( 'Search and hashtag feeds will cache the last 150 tweets persistently', 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds persistentcache=true]</code></td>
        </tr>
        <tr>
            <td>autores</td>
            <td><?php _e( 'Smallest image resolution available is used relative to actual size of the images on the page', 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds autores=true]</code></td>
        </tr>

        <tr class="ctf_table_header"><td colspan=3><?php _e("Style Options", 'custom-twitter-feeds' ); ?></td></tr>
        <tr>
            <td>width</td>
            <td><?php _e( "The width of your feed. Any number with a unit like \"px\" or \"%\".", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds width=400px]</code></td>
        </tr>
        <tr>
            <td>height</td>
            <td><?php _e( "The height of your feed. Any number with a unit like \"px\" or \"em\".", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds height=500px]</code></td>
        </tr>
        <tr>
            <td>bgcolor</td>
            <td><?php _e( "Background color for the feed. Any hex color code", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds bgcolor="eee"]</code></td>
        </tr>
        <tr>
            <td>tweetbgcolor</td>
            <td><?php _e( "Background color for each tweet. Any hex color code", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds tweetbgcolor="ddd"]</code></td>
        </tr>
        <tr class="ctf_table_header"><td colspan=3><?php _e("Typography Options", 'custom-twitter-feeds' ); ?></td></tr>
        <tr>
            <td>authortextsize</td>
            <td><?php _e( "Size of author info font in pixels", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds authortextsize="16"]</code></td>
        </tr>
        <tr>
            <td>authortextweight</td>
            <td><?php _e( "Weight of author info font; inherit, bold, or normal", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds authortextweight="bold"]</code></td>
        </tr>
        <tr>
            <td>logosize</td>
            <td><?php _e( "Size of Twitter logo in pixels", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds logosize="16"]</code></td>
        </tr>
        <tr>
            <td>logocolor</td>
            <td><?php _e( "Color of Twitter logo. Any color hex code.", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds logocolor="0ff"]</code></td>
        </tr>
        <tr>
            <td>datetextsize</td>
            <td><?php _e( "Size of date info font in pixels", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds datetextsize="16"]</code></td>
        </tr>
        <tr>
            <td>datetextweight</td>
            <td><?php _e( "Weight of date info font; inherit, bold, or normal", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds datetextweight="bold"]</code></td>
        </tr>
        <tr>
            <td>quotedtextsize</td>
            <td><?php _e( "Size of quoted author info font in pixels", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds quotedauthorsize="16"]</code></td>
        </tr>
        <tr>
            <td>quotedtextweight</td>
            <td><?php _e( "Weight of quoted author info font; inherit, bold, or normal", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds quotedauthorweight="bold"]</code></td>
        </tr>
        <tr>
            <td>textcolor</td>
            <td><?php _e( "Color of the text. Any color hex code", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds textcolor="333"]</code></td>
        </tr>
        <tr>
            <td>linktextcolor</td>
            <td><?php _e( "Color of the links inside the tweet text. Any color hex code", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds linktextcolor="00f"]</code></td>
        </tr>
        <tr>
            <td>iconsize</td>
            <td><?php _e( "Size of the icons in pixels", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds iconsize="16"]</code></td>
        </tr>
        <tr>
            <td>iconcolor</td>
            <td><?php _e( "Color of the icons. Any color hex code", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds iconcolor="e00"]</code></td>
        </tr>
        <tr class="ctf_table_header"><td colspan=3><?php _e("\"Load More\" Button Options", 'custom-twitter-feeds' ); ?></td></tr>
        <tr>
            <td>buttoncolor</td>
            <td><?php _e( "Color of the background of the button. Any color hex code", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds buttoncolor="00e"]</code></td>
        </tr>
        <tr>
            <td>buttontextcolor</td>
            <td><?php _e( "Color of the text of the button. Any color hex code", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds buttoncolor="333"]</code></td>
        </tr>
        <tr>
            <td>buttontext</td>
            <td><?php _e( "Custom text inside the button", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds buttontext="More..."]</code></td>
        </tr>

        <tr class="ctf_table_header"><td colspan=3><?php _e("Media Layout", 'custom-twitter-feeds' ); ?></td></tr>
        <tr>
            <td>imagecols</td>
            <td><?php _e( "Images wil be displayed in this number of columns, masonry style", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds imagecols=2]</code></td>
        </tr>
        <tr>
            <td>maxmedia</td>
            <td><?php _e( "The maximum number of media that can be displayed in the feed. All media still available in the lightbox", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds maxmedia=2]</code></td>
        </tr>

        <tr class="ctf_table_header"><td colspan=3><?php _e("Carousel", 'custom-twitter-feeds' ); ?></td></tr>
        <tr>
            <td>carouselcols</td>
            <td><?php _e( "Number of columns for the carousel feed for desktop", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds carouselcols=3]</code></td>
        </tr>
        <tr>
            <td>carouselmobilecols</td>
            <td><?php _e( "Number of columns for the carousel feed for mobile screens", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds carouselmobilecols=1]</code></td>
        </tr>
        <tr>
            <td>carouselarrows</td>
            <td><?php _e( "How to display the carousel navigation arrows; onhover, below, hide", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds carouselarrows=below]</code></td>
        </tr>
        <tr>
            <td>carouselpag</td>
            <td><?php _e( "Whether to show the carousel pagination controls", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds carouselpag=false]</code></td>
        </tr>
        <tr>
            <td>carouselheight</td>
            <td><?php _e( "How the height of the carousel is set; tallest, clickexpand, auto", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds carouselheight=clickexpand]</code></td>
        </tr>
        <tr>
            <td>carouselautoplay</td>
            <td><?php _e( "Whether the carousel should automatically start scrolling", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds carouselautoplay=true]</code></td>
        </tr>
        <tr>
            <td>carouseltime</td>
            <td><?php _e( "The time between slides when autoplaying", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds carouseltime=8000]</code></td>
        </tr>
        <tr>
            <td>carouselloop</td>
            <td><?php _e( "How the carousel posts should loop. <b>Available options:</b> none, infinite, rewind", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds carouselloop=infinite]</code></td>
        </tr>

        <tr class="ctf_table_header"><td colspan=3><?php _e("Masonry Columns", 'custom-twitter-feeds' ); ?></td></tr>
        <tr>
            <td>masonrycols</td>
            <td><?php _e( "Number of columns for the masonry feed for desktop", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds masonrycols=4]</code></td>
        </tr>
        <tr>
            <td>masonrymobilecols</td>
            <td><?php _e( "Number of columns for the masonry feed for mobile screens", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds masonrymobilecols=2]</code></td>
        </tr>

        <tr class="ctf_table_header"><td colspan=3><?php _e("Auto Load More on Scroll", 'custom-twitter-feeds' ); ?></td></tr>
        <tr>
            <td>autoscroll</td>
            <td><?php _e( "Load more Tweets as the visitor scrolls to the end of the feed", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds autoscroll=true]</code></td>
        </tr>
        <tr>
            <td>autoscrolldistance</td>
            <td><?php _e( "Distance in pixels from the bottom of the page to trigger the automatic loading of more tweets", 'custom-twitter-feeds' ); ?></td>
            <td><code>[custom-twitter-feeds autoscrolldistance=500]</code></td>
        </tr>

    </tbody>
</table>
<p><i class="fa fa-question-circle" aria-hidden="true"></i>&nbsp; <?php _e('Need help? <a href="?page=custom-twitter-feeds&tab=support">Get Support</a>.'); ?></p>
