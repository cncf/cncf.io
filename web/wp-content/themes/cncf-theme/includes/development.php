<?php

/**
 * Debug
 *
 * @param $variable
 *
 * @return output
 */
function r( $var ) {
	echo '<pre>';
	print_r( $var );
	echo '</pre>';
}
