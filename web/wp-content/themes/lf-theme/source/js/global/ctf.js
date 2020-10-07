/**
 * Add rel to custom twitter feed.
 *
 * @package WordPress
 * @since 1.0.0
 * @author James Hunt
 */

let ctflinks = document.querySelectorAll( '.ctf a' );
for (let i = 0, linksCount = ctflinks.length; i < linksCount;  i++) {
	ctflinks[i].setAttribute( 'rel', 'noopener' );
}
