<div class="ctf-empty-state ctf-fb-fs"  v-if="(feedsList == null || feedsList.length == 0 ) && (legacyFeedsList == null || legacyFeedsList.length == 0)">
	<div class="ctf-fb-wlcm-content ctf-fb-fs">
		<div class="ctf-fb-wlcm-inf-1 ctf-fb-fs">
			<div class="ctf-fb-inf-svg">
                <svg class="sb-head" width="13" height="7" viewBox="0 0 13 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 6L5.5 1L11.5 6" stroke="#141B38" stroke-width="2" stroke-linejoin="round"/>
                </svg>

                <svg class="sb-shaft" width="85" height="62" viewBox="0 0 85 62" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M84.5 59C63.5 66 4.5 54 1.5 0.5" stroke="#141B38" stroke-width="2" stroke-linejoin="round"/>
                </svg>
			</div>
			<div class="ctf-fb-inf-cnt">
				<div class="ctf-fb-inf-num"><span>1</span></div>
				<div class="ctf-fb-inf-txt">
					<h4>{{welcomeScreen.createFeed}}</h4>
					<p class="sb-small-p">{{welcomeScreen.createFeedDescription}}</p>
				</div>
			</div>
		</div>

		<div class="ctf-fb-wlcm-inf-2 ctf-fb-fs">
			<div class="ctf-fb-inf-cnt">
				<div class="ctf-fb-inf-num"><span>2</span></div>
				<div class="ctf-fb-inf-txt">
                    <h4>{{welcomeScreen.customizeFeed}}</h4>
                    <p class="sb-small-p">{{welcomeScreen.customizeFeedDescription}}</p>
				</div>
				<div class="ctf-fb-inf-img">
                    <svg width="125" height="119" viewBox="0 0 125 119" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="7.72339" width="116.775" height="110.72" rx="2" transform="rotate(4 7.72339 0)" fill="#D0D1D7"/>
                        <g filter="url(#filter0_dd_512:1750)">
                            <rect x="28.8455" y="33.635" width="38" height="34" rx="1.12121" transform="rotate(1 28.8455 33.635)" fill="white"/>
                        </g>
                        <path d="M38.7173 42.0584C38.7197 41.9204 38.8336 41.8104 38.9716 41.8128L56.469 42.1182C56.607 42.1206 56.717 42.2345 56.7146 42.3725L56.4092 59.8699C56.4067 60.0079 56.2929 60.1179 56.1548 60.1155L38.6575 59.8101C38.5194 59.8077 38.4095 59.6938 38.4119 59.5557L38.7173 42.0584Z" fill="#434960"/>
                        <path d="M28.7234 41.6339L35.4724 41.7517C35.6104 41.7541 35.7204 41.868 35.718 42.006L35.4125 59.5034C35.4101 59.6414 35.2963 59.7514 35.1582 59.749L28.4092 59.6312L28.7234 41.6339Z" fill="#8C8F9A"/>
                        <path d="M59.7141 42.4249C59.7166 42.2868 59.8304 42.1769 59.9685 42.1793L66.7174 42.2971L66.4033 60.2944L59.6543 60.1765C59.5163 60.1741 59.4063 60.0603 59.4087 59.9222L59.7141 42.4249Z" fill="#8C8F9A"/>
                        <g filter="url(#filter1_dd_512:1750)">
                            <rect x="61.4363" y="49.0666" width="34.5032" height="36.7292" rx="1.11301" transform="rotate(8 61.4363 49.0666)" fill="white"/>
                            <rect x="60.5852" y="47.9371" width="36.5032" height="38.7292" rx="2.11301" transform="rotate(8 60.5852 47.9371)" stroke="#D0D1D7" stroke-width="2"/>
                        </g>
                        <rect x="66.2253" y="57.0946" width="9" height="9" rx="0.5" transform="rotate(8 66.2253 57.0946)" fill="#434960"/>
                        <rect x="64.0569" y="70.5251" width="9" height="9" rx="0.5" transform="rotate(8 64.0569 70.5251)" fill="#434960"/>
                        <rect x="79.5535" y="59.1083" width="9" height="9" rx="0.5" transform="rotate(8 79.5535 59.1083)" fill="#434960"/>
                        <rect x="77.385" y="72.539" width="9" height="9" rx="0.5" transform="rotate(8 77.385 72.539)" fill="#434960"/>
                        <defs>
                            <filter id="filter0_dd_512:1750" x="23.2715" y="32.6544" width="48.5488" height="44.6192" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                <feOffset dy="4"/>
                                <feGaussianBlur stdDeviation="2.5"/>
                                <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/>
                                <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_512:1750"/>
                                <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                <feOffset dy="1"/>
                                <feGaussianBlur stdDeviation="1"/>
                                <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/>
                                <feBlend mode="normal" in2="effect1_dropShadow_512:1750" result="effect2_dropShadow_512:1750"/>
                                <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_512:1750" result="shape"/>
                            </filter>
                            <filter id="filter1_dd_512:1750" x="49.4683" y="46.2102" width="52.9917" height="54.8863" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                <feOffset dy="4"/>
                                <feGaussianBlur stdDeviation="2.5"/>
                                <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/>
                                <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_512:1750"/>
                                <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                <feOffset dy="1"/>
                                <feGaussianBlur stdDeviation="1"/>
                                <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/>
                                <feBlend mode="normal" in2="effect1_dropShadow_512:1750" result="effect2_dropShadow_512:1750"/>
                                <feBlend mode="normal" in="SourceGraphic" in2="effect2_dropShadow_512:1750" result="shape"/>
                            </filter>
                        </defs>
                    </svg>

				</div>
			</div>
		</div>

		<div class="ctf-fb-wlcm-inf-3 ctf-fb-fs">
			<div class="ctf-fb-inf-cnt">
				<div class="ctf-fb-inf-img">
                    <svg width="121" height="134" viewBox="0 0 121 134" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0.00878906" y="8.56641" width="111.967" height="125.336" rx="2" transform="rotate(-4 0.00878906 8.56641)" fill="#D0D1D7"/>
                        <g filter="url(#filter0_d_503:1671)">
                            <rect x="15.0002" y="54.0273" width="86.4064" height="27.65" rx="1.15209" transform="rotate(-4 15.0002 54.0273)" fill="white"/>
                        </g>
                        <g filter="url(#filter1_d_503:1671)">
                            <rect x="15.0002" y="54.0273" width="86.4064" height="27.65" rx="1.15209" transform="rotate(-4 15.0002 54.0273)" fill="white"/>
                            <g clip-path="url(#clip0_503:1671)">
                                <g clip-path="url(#clip1_503:1671)">
                                    <path d="M39.6404 66.166L36.8185 69.4122L36.0071 68.7069L38.1236 66.2721L35.6888 64.1556L36.3942 63.3442L39.6404 66.166ZM28.2852 66.9601L30.72 69.0766L30.0146 69.888L26.7684 67.0661L29.5903 63.82L30.4012 64.5253L28.2852 66.9601ZM32.3556 71.526L31.2143 71.6058L34.0532 61.7062L35.1945 61.6264L32.3556 71.526Z" fill="#141B38"/>
                                </g>
                            </g>
                            <path d="M48.258 69.3531L53.4994 68.9866L53.4142 67.7688L49.6207 68.0341L49.4586 65.7165L53.0445 65.4657L52.9641 64.3153L49.3782 64.5661L49.2247 62.3719L53.0183 62.1066L52.9331 60.8889L47.6918 61.2554L48.258 69.3531ZM55.1492 68.8712L56.5465 68.7735L56.2856 65.0417C56.2322 64.2785 56.6964 63.6596 57.3867 63.6113C58.0713 63.5634 58.5216 63.9549 58.5691 64.6339L58.8473 68.6126L60.2446 68.5149L59.9766 64.6821C59.9276 63.9806 60.3609 63.4033 61.0904 63.3523C61.8368 63.3001 62.2298 63.6787 62.2855 64.4755L62.5567 68.3532L63.954 68.2555L63.6589 64.0355C63.5698 62.7616 62.7761 62.0559 61.5415 62.1422C60.6885 62.2018 60.0121 62.689 59.7613 63.3776L59.6659 63.3843C59.3547 62.7237 58.7188 62.3396 57.8883 62.3976C57.0858 62.4538 56.4956 62.8841 56.2797 63.5872L56.1843 63.5939L56.1176 62.6399L54.7203 62.7376L55.1492 68.8712ZM69.0284 68.0022C70.566 67.8947 71.4629 66.6082 71.3272 64.6666L71.3264 64.6554C71.1898 62.7025 70.1398 61.5578 68.5854 61.6665C67.7436 61.7254 67.0712 62.1897 66.7976 62.8743L66.7022 62.8809L66.468 59.5308L65.0707 59.6285L65.6655 68.1358L67.0629 68.0381L66.9958 67.0785L67.0912 67.0718C67.4746 67.7161 68.1698 68.0622 69.0284 68.0022ZM68.5083 66.8543C67.5599 66.9206 66.9181 66.2099 66.8322 64.9809L66.8314 64.9697C66.7454 63.7407 67.2817 62.9419 68.2301 62.8756C69.1841 62.8089 69.8147 63.5205 69.901 64.755L69.9018 64.7663C69.9881 66.0008 69.4623 66.7876 68.5083 66.8543ZM75.5732 67.5671C77.2399 67.4505 77.9921 66.4336 78.1332 65.6286L78.1465 65.577L76.8165 65.67L76.8025 65.7104C76.6874 66.0004 76.282 66.4122 75.5244 66.4652C74.576 66.5315 73.9364 65.9334 73.8427 64.8347L78.13 64.5349L78.0979 64.0747C77.9684 62.2228 76.8054 61.0748 75.0601 61.1969C73.3149 61.3189 72.2864 62.6596 72.4214 64.5901L72.4218 64.5957C72.5584 66.5486 73.7494 67.6946 75.5732 67.5671ZM75.1535 62.29C75.9335 62.2354 76.5352 62.6952 76.7009 63.6931L73.7884 63.8967C73.8267 62.9128 74.3735 62.3445 75.1535 62.29ZM81.9354 67.0996C82.7996 67.0392 83.4343 66.6001 83.7243 65.9087L83.8197 65.9021L83.8868 66.8617L85.2897 66.7636L84.6948 58.2562L83.2919 58.3543L83.5262 61.7045L83.4308 61.7112C83.0646 61.0714 82.3341 60.7051 81.4923 60.764C79.9379 60.8727 79.063 62.1519 79.1996 64.1048L79.2004 64.116C79.3362 66.0577 80.3977 67.2071 81.9354 67.0996ZM82.2907 65.8906C81.3367 65.9573 80.7065 65.2513 80.6201 64.0168L80.6194 64.0055C80.533 62.771 81.0641 61.9782 82.0124 61.9119C82.9608 61.8455 83.6086 62.5615 83.6946 63.7905L83.6954 63.8017C83.7813 65.0307 83.2447 65.8239 82.2907 65.8906Z" fill="#141B38"/>
                        </g>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M87.7455 71.7873L89.5443 71.6616L89.4814 70.7621L87.6826 70.8879L87.7455 71.7873ZM90.4438 71.5984L89.5443 71.6613L90.1733 80.6557L91.0727 80.5928L90.4438 71.5984ZM87.7454 71.7875L86.846 71.8504L87.6636 83.543L88.563 83.4801L87.7454 71.7875ZM93.5824 77.7058L95.3811 77.5801L95.3182 76.6806L93.5194 76.8064L93.5194 76.8065L92.62 76.8694L92.9031 80.9168L93.8025 80.8539L93.5824 77.7058ZM89.4216 89.2949L88.5222 89.3578L88.648 91.1566L88.6794 91.6063L98.1235 90.9459L98.1235 90.9457L98.1235 90.9457L97.9349 88.2477L98.8342 88.1848L98.6455 85.4865L97.7461 85.5494L97.9347 88.2474L97.0354 88.3103L97.1612 90.1093L89.516 90.6439L89.4216 89.2949ZM95.3811 77.5804L96.2806 77.5175L96.5636 81.565L95.6642 81.6279L95.3811 77.5804ZM98.2052 79.1905L97.3059 79.2534L97.243 78.354L98.1424 78.2911L98.2053 79.1904L99.1047 79.1275L99.5449 85.4236L98.6455 85.4864L98.2052 79.1905ZM90.8212 76.9954L92.62 76.8696L92.5571 75.9701L90.7583 76.0959L90.8212 76.9954ZM96.3435 78.4169L97.2429 78.354L97.18 77.4546L96.2806 77.5175L96.3435 78.4169ZM87.6227 89.4208L88.5221 89.3579L88.4592 88.4585L87.5599 88.5213L87.4341 86.7225L86.5347 86.7854L86.6605 88.5843L87.5598 88.5214L87.6227 89.4208ZM85.6761 80.9704L84.7767 81.0333L84.7138 80.1338L85.6132 80.071L85.6761 80.9704ZM86.6384 81.8069L85.739 81.8698L85.6761 80.9703L86.5756 80.9075L86.6385 81.8068L87.5378 81.744L87.6007 82.6434L86.7012 82.7063L86.6384 81.8069ZM86.9843 86.7539L86.0848 86.8168L85.9591 85.0179L86.8585 84.955L86.9843 86.7539ZM85.0596 85.0808L85.959 85.0179L85.8333 83.219L84.9338 83.2819L85.0596 85.0808ZM84.9338 83.2819L84.0344 83.3448L83.8142 80.1967L84.7137 80.1338L84.9338 83.2819Z" fill="#141B38"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M87.7455 71.7875L89.5443 71.6617L90.1733 80.656L91.0727 80.5931L90.8212 76.9955L92.62 76.8697L92.903 80.917L93.8025 80.8541L93.5824 77.706L95.3813 77.5802L95.6643 81.6275L96.5636 81.5647L96.3435 78.4171L97.2429 78.3542L97.3058 79.2531L98.2054 79.1902L98.6456 85.4863L97.7462 85.5492L97.9034 87.7981L97.9034 87.7981L97.9348 88.2474L97.0354 88.3103L97.0669 88.7603L97.0669 88.7603L97.1612 90.1095L89.516 90.6441L89.4217 89.295L88.5222 89.3579L88.4908 88.9078L88.4907 88.9078L88.4593 88.4585L87.5599 88.5213L87.4341 86.7225L86.9844 86.7539L86.7014 82.7064L87.6008 82.6436L87.6637 83.543L88.5631 83.4801L87.7455 71.7875ZM85.6761 80.9706L84.7767 81.0334L84.9339 83.282L85.8333 83.2191L85.6761 80.9706ZM85.739 81.8699L86.6385 81.8071L86.8586 84.9551L85.9592 85.018L85.739 81.8699Z" fill="white"/>
                        <defs>
                            <filter id="filter0_d_503:1671" x="9.23982" y="44.5437" width="99.6456" height="45.131" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                <feOffset dy="2.30417"/>
                                <feGaussianBlur stdDeviation="2.88021"/>
                                <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/>
                                <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_503:1671"/>
                                <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_503:1671" result="shape"/>
                            </filter>
                            <filter id="filter1_d_503:1671" x="9.23982" y="44.5437" width="99.6456" height="45.131" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                <feOffset dy="2.30417"/>
                                <feGaussianBlur stdDeviation="2.88021"/>
                                <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0"/>
                                <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_503:1671"/>
                                <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_503:1671" result="shape"/>
                            </filter>
                            <clipPath id="clip0_503:1671">
                                <rect width="16.1292" height="16.1292" fill="white" transform="translate(24.5962 59.1308) rotate(-4)"/>
                            </clipPath>
                            <clipPath id="clip1_503:1671">
                                <rect width="12.9034" height="12.9034" fill="white" transform="translate(26.3176 60.6294) rotate(-4)"/>
                            </clipPath>
                        </defs>
                    </svg>

				</div>
				<div class="ctf-fb-inf-num"><span>3</span></div>
				<div class="ctf-fb-inf-txt">
                    <h4>{{welcomeScreen.embedFeed}}</h4>
                    <p class="sb-small-p">{{welcomeScreen.embedFeedDescription}}</p>
				</div>
			</div>
		</div>


	</div>
</div>