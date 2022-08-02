<script type="text/x-template" id="ctf-dummy-lightbox-component">
		<div id="ctf_lightbox" class="ctf-lightbox-dummy-ctn  ctf_lightbox ctf-lightbox-transitioning" :data-visibility="dummyLightBoxScreen" :class="[(!$parent.valueIsEnabled(customizerFeedData.settings.disablelightbox) ? 'ctf_lightbox-active' : 'ctf_lightbox-disabled')]">
	  <div class="ctf-lightbox-dummy-overlay"></div>
	  <div class="ctf_lb-outerContainer" style="width: 705px;height: 589px;top: 50px;">
	    <div class="ctf_lb-container" style="touch-action: pan-y; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
	      <video class="ctf_video" src="" poster="" controls="" autoplay="" style="display: none;"></video>
	      <iframe title="Placeholder for videos in the lightbox" type="text/html" src="" allowfullscreen="" webkitallowfullscreen="" mozallowfullscreen="" style="display: none;"></iframe>
	      <img class="ctf_lb-image" alt="Lightbox image placeholder" src="https://pbs.twimg.com/media/FMLDgvbXMAAZ8YR.jpg" style="width: 705px; height: 529px;">
	      <div class="ctf_lb-nav" style="">
	        <a class="ctf_lb-prev" href="#" style="display: none;">
	          <p class="ctf-screenreader">Previous Slide</p>
	        </a>
	        <a class="ctf_lb-next" href="#" style="">
	          <p class="ctf-screenreader">Next Slide</p>
	        </a>
	      </div>
	      <div class="ctf_lb-loader" style="display: none;">
	        <a class="ctf_lb-cancel"></a>
	      </div>
	    </div>
	  </div>
	  <div class="ctf_lb-dataContainer" style="width: 705px;">
	    <div class="ctf_lb-data">
	      <div class="ctf_lb-details">
	        <div class="ctf_lb-caption" style="">
	          <div class="ctf-author-box">
	            <div class="ctf-author-box-link" target="_blank">
	              <a href="https://twitter.com/smashballoon" class="ctf-author-avatar" target="_blank" rel="nofollow noopener" style="">
	                <img src="https://pbs.twimg.com/profile_images/1493660641638424579/e4k4qWGS_normal.jpg" width="48" height="48">
	              </a>
	              <a href="https://twitter.com/smashballoon" target="_blank" class="ctf-author-name" rel="nofollow noopener">Smash Balloon</a>
	              <a href="https://twitter.com/smashballoon" class="ctf-author-screenname" target="_blank" rel="nofollow noopener">@smashballoon</a>
	              <span class="ctf-screename-sep">·</span>
	              <div class="ctf-tweet-meta">
	                <a href="https://twitter.com/statuses/1496105743489007616" class="ctf-tweet-date" target="_blank" rel="nofollow noopener">22 Feb</a>
	              </div>
	            </div>
	          </div>
	          <div class="ctf-caption-text">We have a new balloon to smash! After 9 years it was time for a refresh! Our new logo is clean and simple, just like our plugins. </div>
	        </div>
	        <div class="ctf_lb-info">
	          <div class="ctf_lb-number">1 / 3</div>
	          <div class="ctf_lightbox_action ctf_share">
	            <a href="JavaScript:void(0);">
	              <svg class="svg-inline--fa fa-share fa-w-16" aria-hidden="true" data-fa-processed="" data-prefix="fa" data-icon="share" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
	                <path fill="currentColor" d="M503.691 189.836L327.687 37.851C312.281 24.546 288 35.347 288 56.015v80.053C127.371 137.907 0 170.1 0 322.326c0 61.441 39.581 122.309 83.333 154.132 13.653 9.931 33.111-2.533 28.077-18.631C66.066 312.814 132.917 274.316 288 272.085V360c0 20.7 24.3 31.453 39.687 18.164l176.004-152c11.071-9.562 11.086-26.753 0-36.328z"></path>
	              </svg>Share </a>
	            <p class="ctf_lightbox_tooltip ctf_tooltip_social" style="display: none;">
	              <a href="https://www.facebook.com/sharer/sharer.php?u=https://twitter.com/smashballoon/status/1496105743489007616&amp;t=Text" target="_blank" rel="nofollow noopener" id="ctf_facebook_icon">
	                <span class="ctf-screenreader">Facebook Share</span>
	                <svg class="svg-inline--fa fa-facebook-square fa-w-14" aria-hidden="true" data-fa-processed="" data-prefix="fab" data-icon="facebook-square" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
	                  <path fill="currentColor" d="M448 80v352c0 26.5-21.5 48-48 48h-85.3V302.8h60.6l8.7-67.6h-69.3V192c0-19.6 5.4-32.9 33.5-32.9H384V98.7c-6.2-.8-27.4-2.7-52.2-2.7-51.6 0-87 31.5-87 89.4v49.9H184v67.6h60.9V480H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h352c26.5 0 48 21.5 48 48z"></path>
	                </svg>
	              </a>
	              <a href="https://twitter.com/home?status=https://twitter.com/smashballoon/status/1496105743489007616 We have a new balloon to smash!

After 9 years it was time for a refresh! Our new logo is clean and simple, just like our plugins. " target="_blank" rel="nofollow noopener" id="ctf_twitter_icon">
	                <span class="ctf-screenreader">Twitter Share</span>
	                <svg class="svg-inline--fa fa-twitter fa-w-16" aria-hidden="true" data-fa-processed="" data-prefix="fab" data-icon="twitter" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
	                  <path fill="currentColor" d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path>
	                </svg>
	              </a>
	              <a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=https://twitter.com/smashballoon/status/1496105743489007616&amp;title=We have a new balloon to smash!

After 9 years it was time for a refresh! Our new logo is clean and simple, just like our plugins. " target="_blank" rel="nofollow noopener" id="ctf_linkedin_icon">
	                <span class="ctf-screenreader">Linkedin Share</span>
	                <svg class="svg-inline--fa fa-linkedin fa-w-14" aria-hidden="true" data-fa-processed="" data-prefix="fab" data-icon="linkedin" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
	                  <path fill="currentColor" d="M416 32H31.9C14.3 32 0 46.5 0 64.3v383.4C0 465.5 14.3 480 31.9 480H416c17.6 0 32-14.5 32-32.3V64.3c0-17.8-14.4-32.3-32-32.3zM135.4 416H69V202.2h66.5V416zm-33.2-243c-21.3 0-38.5-17.3-38.5-38.5S80.9 96 102.2 96c21.2 0 38.5 17.3 38.5 38.5 0 21.3-17.2 38.5-38.5 38.5zm282.1 243h-66.4V312c0-24.8-.5-56.7-34.5-56.7-34.6 0-39.9 27-39.9 54.9V416h-66.4V202.2h63.7v29.2h.9c8.9-16.8 30.6-34.5 62.9-34.5 67.2 0 79.7 44.3 79.7 101.9V416z"></path>
	                </svg>
	              </a>
	              <a href="https://pinterest.com/pin/create/button/?url=https://twitter.com/smashballoon/status/1496105743489007616&amp;media=https://pbs.twimg.com/media/FMLDgvbXMAAZ8YR.jpg&amp;description=We have a new balloon to smash!

After 9 years it was time for a refresh! Our new logo is clean and simple, just like our plugins. " id="ctf_pinterest_icon" target="_blank" rel="nofollow noopener">
	                <span class="ctf-screenreader">Pinterest Share</span>
	                <svg class="svg-inline--fa fa-pinterest fa-w-16" aria-hidden="true" data-fa-processed="" data-prefix="fab" data-icon="pinterest" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512">
	                  <path fill="currentColor" d="M496 256c0 137-111 248-248 248-25.6 0-50.2-3.9-73.4-11.1 10.1-16.5 25.2-43.5 30.8-65 3-11.6 15.4-59 15.4-59 8.1 15.4 31.7 28.5 56.8 28.5 74.8 0 128.7-68.8 128.7-154.3 0-81.9-66.9-143.2-152.9-143.2-107 0-163.9 71.8-163.9 150.1 0 36.4 19.4 81.7 50.3 96.1 4.7 2.2 7.2 1.2 8.3-3.3.8-3.4 5-20.3 6.9-28.1.6-2.5.3-4.7-1.7-7.1-10.1-12.5-18.3-35.3-18.3-56.6 0-54.7 41.4-107.6 112-107.6 60.9 0 103.6 41.5 103.6 100.9 0 67.1-33.9 113.6-78 113.6-24.3 0-42.6-20.1-36.7-44.8 7-29.5 20.5-61.3 20.5-82.6 0-19-10.2-34.9-31.4-34.9-24.9 0-44.9 25.7-44.9 60.2 0 22 7.4 36.8 7.4 36.8s-24.5 103.8-29 123.2c-5 21.4-3 51.6-.9 71.2C65.4 450.9 0 361.1 0 256 0 119 111 8 248 8s248 111 248 248z"></path>
	                </svg>
	              </a>
	              <a href="mailto:?subject=Instagram&amp;body=We have a new balloon to smash!

After 9 years it was time for a refresh! Our new logo is clean and simple, just like our plugins.  https://twitter.com/smashballoon/status/1496105743489007616" id="ctf_email_icon" target="_blank" rel="nofollow noopener">
	                <span class="ctf-screenreader">Email Share</span>
	                <svg class="svg-inline--fa fa-envelope fa-w-16" aria-hidden="true" data-fa-processed="" data-prefix="fa" data-icon="envelope" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
	                  <path fill="currentColor" d="M502.3 190.8c3.9-3.1 9.7-.2 9.7 4.7V400c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V195.6c0-5 5.7-7.8 9.7-4.7 22.4 17.4 52.1 39.5 154.1 113.6 21.1 15.4 56.7 47.8 92.2 47.6 35.7.3 72-32.8 92.3-47.6 102-74.1 131.6-96.3 154-113.7zM256 320c23.2.4 56.6-29.2 73.4-41.4 132.7-96.3 142.8-104.7 173.4-128.7 5.8-4.5 9.2-11.5 9.2-18.9v-19c0-26.5-21.5-48-48-48H48C21.5 64 0 85.5 0 112v19c0 7.4 3.4 14.3 9.2 18.9 30.6 23.9 40.7 32.4 173.4 128.7 16.8 12.2 50.2 41.8 73.4 41.4z"></path>
	                </svg>
	              </a>
	              <svg class="svg-inline--fa fa-play fa-w-14 sbi_playbtn" aria-hidden="true" data-fa-processed="" data-prefix="fa" data-icon="play" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
	                <path fill="currentColor" d="M424.4 214.7L72.4 6.6C43.8-10.3 0 6.1 0 47.9V464c0 37.5 40.7 60.1 72.4 41.3l352-208c31.4-18.5 31.5-64.1 0-82.6z"></path>
	              </svg>
	            </p>
	          </div>
	          <div class="ctf_lightbox_action ctf_instagram">
	            <a href="https://twitter.com/smashballoon/status/1496105743489007616" target="_blank" rel="nofollow noopener">
	              <span class="ctf-screenreader">Twitter</span>
	              <svg class="svg-inline--fa fa-twitter fa-w-16" aria-hidden="true" data-fa-processed="" data-prefix="fab" data-icon="twitter" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
	                <path fill="currentColor" d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path>
	              </svg>Twitter </a>
	          </div>
	          <div id="ctf_mod_link" class="ctf_lightbox_action">
	            <a href="JavaScript:void(0);">
	              <svg class="svg-inline--fa fa-times fa-w-12" aria-hidden="true" data-fa-processed="" data-prefix="fa" data-icon="times" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
	                <path fill="currentColor" d="M323.1 441l53.9-53.9c9.4-9.4 9.4-24.5 0-33.9L279.8 256l97.2-97.2c9.4-9.4 9.4-24.5 0-33.9L323.1 71c-9.4-9.4-24.5-9.4-33.9 0L192 168.2 94.8 71c-9.4-9.4-24.5-9.4-33.9 0L7 124.9c-9.4 9.4-9.4 24.5 0 33.9l97.2 97.2L7 353.2c-9.4 9.4-9.4 24.5 0 33.9L60.9 441c9.4 9.4 24.5 9.4 33.9 0l97.2-97.2 97.2 97.2c9.3 9.3 24.5 9.3 33.9 0z"></path>
	              </svg>Hide Tweet (admin) </a>
	            <p id="ctf_mod_box" class="ctf_lightbox_tooltip" style="display: none;">Add this ID to the plugin's <strong>Hide Specific Tweets</strong> setting: <span id="ctf_photo_id">1496105743489007616</span>
	              <svg class="svg-inline--fa fa-play fa-w-14 sbi_playbtn" aria-hidden="true" data-fa-processed="" data-prefix="fa" data-icon="play" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
	                <path fill="currentColor" d="M424.4 214.7L72.4 6.6C43.8-10.3 0 6.1 0 47.9V464c0 37.5 40.7 60.1 72.4 41.3l352-208c31.4-18.5 31.5-64.1 0-82.6z"></path>
	              </svg>
	            </p>
	          </div>
	        </div>
	      </div>
	      <div class="ctf_lb-closeContainer">
	        <a class="ctf_lb-close" @click.prevent.default="$parent.dummyLightBoxScreen = false;"></a>
	      </div>
	    </div>
	  </div>
	</div>
</script>