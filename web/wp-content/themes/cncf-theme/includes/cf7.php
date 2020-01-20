<?php

/*
 *
 * Remove additional P tags from Contact Form 7
 */
add_filter( 'wpcf7_autop_or_not', '__return_false' );
