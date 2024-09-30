/**
 * Used on CNCF subsites to embed the hello bar on the top of the page.
 *
 * @package WordPress
 * @since 1.0.0
 */

(function() {
	document.addEventListener('DOMContentLoaded', function() {

		const cacheKey = 'helloBarCache';
		const cacheDuration = 3600 * 1000; // 1 hour in milliseconds
	
		// Check if we have a cached response and if it's still valid
		const cachedData = localStorage.getItem(cacheKey);
		if (cachedData) {
			const parsedData = JSON.parse(cachedData);
			const now = new Date().getTime();
	
			// If the cache is still valid, use the cached data
			if (now - parsedData.timestamp < cacheDuration) {
				insertHelloBar(parsedData.data);
				return; // Exit since we don't need to fetch the API
			} else {
				// Cache expired, remove it
				localStorage.removeItem(cacheKey);
			}
		}
	
		// Fetch the API if no valid cache is found
		fetch('https://www.cncf.io/wp-json/lf/v1/get_hello')
			.then(response => response.json())
			.then(data => {
				// Cache the response with a timestamp
				localStorage.setItem(cacheKey, JSON.stringify({
					data: data,
					timestamp: new Date().getTime()
				}));
				insertHelloBar(data);
			})
			.catch(error => console.error('Error fetching the API:', error));
	});


	// Function to insert the hello bar
	function insertHelloBar(data) {
		if (data.show_hello_bar !== 1) {
			return;
		}

		const hello_bar_bg = data.hello_bar_bg;
		const hello_bar_text = data.hello_bar_text;

		var hB = document.createElement('div');
		hB.classList.add('cncf-hello-bar');
		hB.style.cssText = `
			position: relative;
			top: 0;
			left: 0;
			width: 100%;
			background-color: ${hello_bar_bg};
			color: ${hello_bar_text};
			text-align: center;
			padding: 6.4px;
			font-family: Clarity City,-apple-system,BlinkMacSystemFont,Segoe UI,Helvetica,Arial,sans-serif,Roboto,Ubuntu,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol;
			font-weight: 400;
			font-size: 14.4px;
			letter-spacing: 0.24px;
			line-height: 1.15;
			opacity: 0;
			z-index: 9999;
			transition: opacity 0.5s ease;
		`;

		// Replace instances of "utm_source=www" with "utm_source=subdomain"
		const subdomain = window.location.hostname.split('.')[0];
		const updatedContent = data.hello_bar_content.replace(/utm_source=www/g, `utm_source=${subdomain}`);
		hB.innerHTML = updatedContent;

		document.body.insertBefore(hB, document.body.firstChild);
		var fixedNav = document.querySelector('.td-navbar');
		var isNavFixed = function() {
			return window.getComputedStyle(fixedNav).position === 'fixed';
		};
		var updateNavPosition = function() {
			if (!fixedNav) return;
			if (isNavFixed()) {
				var hBHeight = hB.offsetHeight;
				if (window.scrollY > 0 && window.scrollY <= hBHeight) {
						fixedNav.style.top = hBHeight - window.scrollY + 'px';
					} else if (window.scrollY > hBHeight) {
						fixedNav.style.top = '0';
					} else {
					fixedNav.style.top = hBHeight + 'px';
				}
			} else {
				fixedNav.style.top = '0';
			}
		};
		var resizeObserver = new ResizeObserver(function() {
			updateNavPosition();
		});
		resizeObserver.observe(hB);
		window.addEventListener('resize', () => updateNavPosition());
		window.addEventListener('scroll', () => updateNavPosition());
		updateNavPosition();
		var style = document.createElement('style');
		style.innerHTML = `
			.cncf-hello-bar a {
				color: inherit;
				font-weight: 400;
				text-decoration: underline;
				text-underline-position: under;
				transition: all 0.1s ease;
			}
			.cncf-hello-bar a:hover, .cncf-hello-bar a:focus {
				text-decoration: none;
				text-underline-position: unset;
			}
		`;
		document.head.appendChild(style);
		setTimeout(function() {
			hB.style.opacity = '1';
		}, 5);
	}

})();