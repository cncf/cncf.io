<?php
/**
 * Salesforce Plugin Settings Connected App
 * 
 * @since  0.1
 *
 * @author Naomi C. Bush for gravity+ <support@gravityplus.pro>
 */
?>
<div id="salesforce-create-connected-app-instructions" style="margin-bottom:50px;">

	<ol type="a">
		<li><p>In Salesforce, from <pre>Setup > App Setup > Create > Apps</pre>under <em>Connected Apps</em>, click <strong>New</strong> to start defining a connected app.</p></li>
		<li><p>Enter the name of your application and contact email information.</p></li>
		<li><p>Select Enable OAuth Settings.</p></li>
		<li><p>Enter the Callback URL below. <strong>If it does *not* begin with https</strong>, contact your host to have your site default to SSL
			<br/>
					<pre><?php echo $this->get_callback_url() ?></pre></p>
		</li>
		<li><p>Add the following Available OAuth scopes to Selected OAuth Scopes:
			<br/>
			<pre>full, refresh_token</pre></p>
		</li>
		<li><p>Click Save. The Consumer Key is created and displayed, and the Consumer Secret is created (click the link to reveal it).</p></li>
		<li><p>Copy and paste the Consumer Key and Consumer Secret below.</p></li>
	</ol>

</div>