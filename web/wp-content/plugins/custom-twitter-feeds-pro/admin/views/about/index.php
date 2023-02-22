<div id="ctf-about" class="ctf-about">
    <?php
        TwitterFeed\Admin\CTF_View::render( 'sections.header' );
        TwitterFeed\Admin\CTF_View::render( 'about.content' );
        TwitterFeed\Admin\CTF_View::render( 'sections.sticky_widget' );

        // Include popup templates
	    include_once CTF_BUILDER_DIR . 'templates/sections/popup/license-learn-more-popup.php';
	    include_once CTF_BUILDER_DIR . 'templates/sections/popup/why-renew-license-popup.php';
    ?>
</div>