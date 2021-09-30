/**
 * Shadow Dom YouTube script.
 *
 * Forked from https://github.com/justinribeiro/lite-youtube with thanks.
 * Inspired by https://github.com/paulirish/lite-youtube-embed
 *
 * @package
 * @since 1.0
 *
 */

/**
 *
 * Class
 */
 class LiteYTEmbed extends HTMLElement {
	constructor() {
		super();
		this.iframeLoaded = false;
		this.setupDom();
	}
	static get observedAttributes() {
		return [ 'videoid' ];
	}
	connectedCallback() {
		this.addEventListener( 'pointerover', LiteYTEmbed.warmConnections, {
			once: true,
		} );
		this.addEventListener( 'click', () => this.addIframe() );
	}
	get videoId() {
		return encodeURIComponent( this.getAttribute( 'videoid' ) || '' );
	}
	set videoId( id ) {
		this.setAttribute( 'videoid', id );
	}
	get webpStatus() {
		return this.getAttribute( 'webpStatus' );
	}
	set webpStatus( status ) {
		this.setAttribute( 'webpStatus', status );
	}
	get sdthumbStatus() {
		return this.getAttribute( 'sdthumbStatus' );
	}
	set sdthumbStatus( status ) {
		this.setAttribute( 'sdthumbStatus', status );
	}
	get videoTitle() {
		return this.getAttribute( 'videotitle' ) || 'Video';
	}
	set videoTitle( title ) {
		this.setAttribute( 'videotitle', title );
	}
	get videoPlay() {
		return this.getAttribute( 'videoPlay' ) || 'Play';
	}
	set videoPlay( name ) {
		this.setAttribute( 'videoPlay', name );
	}
	get videoStartAt() {
		return Number( this.getAttribute( 'videoStartAt' ) || '0' );
	}
	set videoStartAt( time ) {
		this.setAttribute( 'videoStartAt', String( time ) );
	}
	get autoLoad() {
		return this.hasAttribute( 'autoload' );
	}
	set autoLoad( value ) {
		if ( value ) {
			this.setAttribute( 'autoload', '' );
		} else {
			this.removeAttribute( 'autoload' );
		}
	}
	get params() {
		return `start=${ this.videoStartAt }&${ this.getAttribute(
			'params'
		) }`;
	}

	/**
	 * Define our shadowDOM for the component
	 */
	setupDom() {
		const shadowDom = this.attachShadow( { mode: 'open' } );
		shadowDom.innerHTML = `
<style>
	:host {
		contain: content;
		display: block;
		position: relative;
		width: 100%;
		padding-bottom: calc(100% / (16 / 9));
	}

	#frame, #fallbackPlaceholder, iframe {
		position: absolute;
		width: 100%;
		height: 100%;
	}

	#frame {
		cursor: pointer;
	}

	#fallbackPlaceholder {
		object-fit: cover;
	}

	#frame::before {
		content: '';
		display: block;
		position: absolute;
		top: 0;
		background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAADGCAYAAAAT+OqFAAAAdklEQVQoz42QQQ7AIAgEF/T/D+kbq/RWAlnQyyazA4aoAB4FsBSA/bFjuF1EOL7VbrIrBuusmrt4ZZORfb6ehbWdnRHEIiITaEUKa5EJqUakRSaEYBJSCY2dEstQY7AuxahwXFrvZmWl2rh4JZ07z9dLtesfNj5q0FU3A5ObbwAAAABJRU5ErkJggg==);
		background-position: top;
		background-repeat: repeat-x;
		height: 60px;
		padding-bottom: 50px;
		width: 100%;
		transition: all 0.2s cubic-bezier(0, 0, 0.2, 1);
		z-index: 1;
	}
	/* play button */
	.lty-playbtn {
		width: 70px;
		height: 46px;
		background-color: #212121;
		z-index: 1;
		opacity: 0.8;
		border-radius: 14%;
		transition: all 0.2s cubic-bezier(0, 0, 0.2, 1);
		border: 0;
	}
	#frame:hover .lty-playbtn {
		background-color: #f00;
		opacity: 1;
	}
	/* play button triangle */
	.lty-playbtn:before {
		content: '';
		border-style: solid;
		border-width: 11px 0 11px 19px;
		border-color: transparent transparent transparent #fff;
	}
	.lty-playbtn,
	.lty-playbtn:before {
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate3d(-50%, -50%, 0);
	}

	.lty-playbtn:hover {
		cursor: pointer;
	}

	/* Post-click styles */
	.lyt-activated {
		cursor: unset;
	}

	#frame.lyt-activated::before,
	.lyt-activated .lty-playbtn {
		display: none;
	}
</style>
<div id="frame">
	<picture>
		<source id="webpPlaceholder" type="image/webp">
		<source id="jpegPlaceholder" type="image/jpeg">
		<img id="fallbackPlaceholder" referrerpolicy="origin" loading="lazy">
	</picture>
	<button class="lty-playbtn"></button>
</div>
`;
		this.domRefFrame = this.shadowRoot.querySelector( '#frame' );
		this.domRefImg = {
			fallback: this.shadowRoot.querySelector( '#fallbackPlaceholder' ),
			webp: this.shadowRoot.querySelector( '#webpPlaceholder' ),
			jpeg: this.shadowRoot.querySelector( '#jpegPlaceholder' ),
		};
		this.domRefPlayButton = this.shadowRoot.querySelector( '.lty-playbtn' );
	}

	/**
	 * Parse our attributes and fire up some placeholders
	 */
	setupComponent() {
		this.initImagePlaceholder();
		this.domRefPlayButton.setAttribute(
			'aria-label',
			`${ this.videoPlay } ${ this.videoTitle }`
		);
		this.setAttribute(
			'title',
			`${ this.videoPlay } ${ this.videoTitle }`
		);
		if ( this.autoLoad ) {
			this.initIntersectionObserver();
		}
	}

	/**
	 * Lifecycle method that we use to listen for attribute changes to period
	 * @param {*} name
	 * @param {*} oldVal
	 * @param {*} newVal
	 */
	attributeChangedCallback( name, oldVal, newVal ) {
		switch ( name ) {
			case 'videoid': {
				if ( oldVal !== newVal ) {
					this.setupComponent();
					// if we have a previous iframe, remove it and the activated class
					if (
						this.domRefFrame.classList.contains( 'lyt-activated' )
					) {
						this.domRefFrame.classList.remove( 'lyt-activated' );
						this.shadowRoot.querySelector( 'iframe' ).remove();
						this.iframeLoaded = false;
					}
				}
				break;
			}
			default:
				break;
		}
	}

	/**
	 * Inject the iframe into the component body
	 */
	addIframe() {
		if ( ! this.iframeLoaded ) {
			const iframeHTML = `
<iframe frameborder="0"
allow="accelerometer; autoplay; encrypted-media; gyroscope;" allowfullscreen
src="https://www.youtube-nocookie.com/embed/${ this.videoId }?autoplay=1&${ this.params }"
></iframe>`;
			this.domRefFrame.insertAdjacentHTML( 'beforeend', iframeHTML );
			this.domRefFrame.classList.add( 'lyt-activated' );
			this.iframeLoaded = true;
		}
	}

	/**
	 * Setup the placeholder image for the component
	 */
	initImagePlaceholder() {
		LiteYTEmbed.addPrefetch( 'preconnect', 'https://i.ytimg.com/' );

		let posterUrlJpeg = `https://i.ytimg.com/vi/${ this.videoId }/maxresdefault.jpg`;

		let posterUrlWebp = `https://i.ytimg.com/vi_webp/${ this.videoId }/maxresdefault.webp`;

		if ( this.webpStatus == 0 ) {
			posterUrlWebp = '';
		}

		if ( this.sdthumbStatus == 1 ) {
			posterUrlJpeg = `https://i.ytimg.com/vi/${ this.videoId }/hqdefault.jpg`;
		}

		this.domRefImg.webp.srcset = posterUrlWebp;
		this.domRefImg.jpeg.srcset = posterUrlJpeg;
		this.domRefImg.fallback.src = posterUrlJpeg;
		this.domRefImg.fallback.setAttribute(
			'aria-label',
			`${ this.videoPlay } ${ this.videoTitle }`
		);
		this.domRefImg.fallback.setAttribute(
			'alt',
			`${ this.videoPlay } ${ this.videoTitle }`
		);
	}

	/**
	 * Setup the Intersection Observer to load the iframe when scrolled into view
	 */
	initIntersectionObserver() {
		if (
			'IntersectionObserver' in window &&
			'IntersectionObserverEntry' in window
		) {
			const options = {
				root: null,
				rootMargin: '0px',
				threshold: 0,
			};
			const observer = new IntersectionObserver(
				( entries, observer ) => {
					entries.forEach( ( entry ) => {
						if ( entry.isIntersecting && ! this.iframeLoaded ) {
							LiteYTEmbed.warmConnections();
							this.addIframe();
							observer.unobserve( this );
						}
					} );
				},
				options
			);
			observer.observe( this );
		}
	}

	/**
	 * Add a <link rel={preload | preconnect} ...> to the head
	 * @param {*} kind
	 * @param {*} url
	 * @param {*} as
	 */
	static addPrefetch( kind, url, as ) {
		const linkElem = document.createElement( 'link' );
		linkElem.rel = kind;
		linkElem.href = url;
		if ( as ) {
			linkElem.as = as;
		}
		linkElem.crossOrigin = 'true';
		document.head.append( linkElem );
	}

	/**
	 * Begin preconnecting to warm up the iframe load Since the embed's netwok
	 * requests load within its iframe, preload/prefetch'ing them outside the
	 * iframe will only cause double-downloads. So, the best we can do is warm up
	 * a few connections to origins that are in the critical path.
	 */
	static warmConnections() {
		if ( LiteYTEmbed.preconnected ) return;
		LiteYTEmbed.addPrefetch( 'preconnect', 'https://s.ytimg.com' );
		LiteYTEmbed.addPrefetch(
			'preconnect',
			'https://www.youtube-nocookie.com'
		);
		LiteYTEmbed.preconnected = true;
	}
}
LiteYTEmbed.preconnected = false;
// Register custom element
customElements.define( 'lite-youtube', LiteYTEmbed );
