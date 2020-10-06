/**
 * Add rel to custom twitter feed.
 *
 * @package WordPress
 * @since 1.0.0
 * @author James Hunt
 */

let ctflinks = document.querySelectorAll('.ctf a');
for (let i = 0; i < ctflinks.length;  i++) {
  ctflinks[i].setAttribute('rel', 'noopener');
}
