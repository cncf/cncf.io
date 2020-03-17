<style>

.activation_window{
	min-width: 255px;
    border: 1px solid #e5e5e5;
    width: 70%;
    box-shadow: 0 1px 1px rgba(0,0,0,.04);
    background: #fff;
    margin-bottom: 20px;
    padding: 0px;
    line-height: 1;
}
.aw-title {
    font-size: 14px;
    padding: 8px 12px;
    margin: 0;
    line-height: 1.4;
    border-bottom: 1px solid #eee;
}
.aw-contents-container{
	width: 100%;
}
.content-row{
	overflow: hidden;
}
.aw-cell{
	float:left;
	overflow:hidden;
	padding: 10px;
}
.aw-note-cell{
	float:left;
	overflow:hidden;
	padding-left: 10px;
}
.aw-label{
	text-align: left;
	display: block;
	line-height: 21px;
}
.aw.textbox{
	width: 200px;
	margin: 0;
    display: block;
    font-size: 14px;
    padding: 4px;
    color: #555;
}
.aw-button{
	display: inline-block;
	text-decoration: none;
	background: #f7f7f7;
	font-size: 13px;
	line-height: 26px;
	height: 28px;
	margin: 0;
	padding: 0 10px 1px;
	cursor: pointer;
	border-width: 1px;
	border-style: solid;
	border-radius: 3px;
	white-space: nowrap;
	-moz-box-sizing: border-box;
	box-sizing: border-box
}
.aw-button:not(.deactive):hover{
    background: #fafafa;
    border-color: #999;
    color: #23282d;
}
.aw-result-box{
    display: none;
}
.aw-deactivation-info{
	line-height: 26px;
	font-weight: 700;
	padding: 10px;
}
.deacvation-button{
	margin-left: 10px;
}
.hidden{
	display: none;
}
.deactive{
	opacity: 0.5;
	cursor: default;
}
.aw-textbox{
	width: 200px;
}
.txt-api-key{
	width: 300px;
}
</style>

<?php
	$mail = get_option( $plugin_name.'_email' );
	$licence_key = get_option( $plugin_name.'_licence_key' );
	$instance = get_option( $plugin_name.'_instance_id' );
	$status = get_option( $plugin_name.'_activation_status' );

	$show_activation = ( !empty($status) && $status!='inactive' ) ? 'hidden' : '';
	$show_deactivation = ( empty($status) || $status=='inactive' ) ? 'hidden' : '';
?>
<div id="result" class="aw-result-box">sample msg</div>
<div class="activation_window">
	<h2 class="aw-title"><span>Licence Activation</span></h2>
	<div class="aw-contents-container">
		<div id="aw-activation" class="content-row <?php echo $show_activation?>">
			<div class="aw-cell">
				<label class="aw-label">API Licence Key:</label>
				<input type="text" class="txt-api-key aw-textbox" placeholder="Licence Key" value="" id="txt_licence_key">
			</div>
			<div class="aw-cell">
				<label class="aw-label">Email:</label>
				<input type="text" id="txt_email" class="aw-textbox" placeholder="Licence Email" value="">
			</div>
			<div class="aw-cell">
				<label class="aw-label">&nbsp;</label>
				<input type="button" id="btn_licence_activate" class="aw-button aw-main-button" value="Activate">
			</div>
			<div class="content-row" style="float: left;">
				<p class="aw-note-cell">Check <a href="http://www.webtoffee.com/my-account" target="_blank">My Account</a> for API Keys and API Downloads.</p>
			</div>
		</div>
		<div id="aw-deactivation" class="content-row <?php echo $show_deactivation?>">
			<input type="hidden" id="hid_licence_key" value="<?php echo $licence_key?>">
			<input type="hidden" id="hid_email" value="<?php echo $mail?>">
			<div class="aw-deactivation-info">
				Licence: <span id="info-licence-key"><?php echo $licence_key?></span> &nbsp;|&nbsp;
				Mail: <span id="info-licence-mail"><?php echo $mail?></span> &nbsp;|&nbsp;
				Status: <span id="info-status"><?php echo $status?></span>
				<input type="button" id="btn_licence_deactivate" class="aw-button deacvation-button" value="Deactive">
			</div>
		</div>
	</div>
</div>
<script>
	jQuery(document).on("click", "#btn_licence_activate",function(){
		me = jQuery(this);
		if(me.hasClass('deactive')){
			return;
		}
		me.addClass('deactive');
		licence_key = jQuery('#txt_licence_key').val();
		email = jQuery('#txt_email').val();
		action = "wf_activate_license_keys_"+"<?php echo $plugin_name;?>";
		var submit_data = {
			action: action,
			licence_key: licence_key,
			email: email
		};
		if ( licence_key.length > 0 ) {
			ajax_url = 'admin-ajax.php?page=wc-settings&tab=shipping';
			jQuery.get( ajax_url, submit_data, function( data ) {
				var formatted_data = jQuery.parseJSON(data);
				console.log( formatted_data );
				var html_msg = '';
				if(typeof formatted_data.error != "undefined"){
					remove_style = 'updated';
					add_style = 'error';
					
					additional_info = '';
					if( typeof formatted_data['additional info'] != "undefined" ){
						additional_info =  formatted_data['additional info'];
					}

					html_msg = "<p><strong>" + formatted_data.error + ": " + additional_info + " </strong></p>";
				}
				else if(formatted_data.activated){
					html_msg = "<p> successfully activated </p>";
					add_style = 'updated';
					remove_style = 'error';

					jQuery("#info-status").html('active');
					jQuery("#info-licence-key").html(licence_key);
					jQuery("#info-licence-mail").html(email);
					
					jQuery('#hid_licence_key').val(licence_key);
					jQuery('#hid_email').val(email);
					
					jQuery("#aw-activation").hide();
					jQuery("#aw-deactivation").show();
				}
				else{
					remove_style = 'updated';
					add_style = 'error';
					html_msg = "<p><strong>" + formatted_data + " </strong></p>";
				}
				me.removeClass('deactive');
				jQuery("#result").html(html_msg)
								.show()
								.removeClass(remove_style)
								.addClass(add_style);
			});
		}

	});
	jQuery(document).on("click", "#btn_licence_deactivate",function(){
		me = jQuery(this);
		if(me.hasClass('deactive')){
			return;
		}
		me.addClass('deactive');

		licence_key = jQuery('#hid_licence_key').val();
		email = jQuery('#hid_email').val();	
		action = "wf_deactivate_license_keys_"+"<?php echo $plugin_name;?>";
		var submit_data = {
			action: action,
			licence_key: licence_key,
			email: email
		};

		if ( licence_key.length > 0 ) {
			ajax_url = 'admin-ajax.php?page=wc-settings&tab=shipping';
			jQuery.get( ajax_url, submit_data, function( data ) {
				console.log( data );
				var formatted_data = jQuery.parseJSON(data);
				var html_msg = '';
				if(typeof formatted_data.error != "undefined"){
					remove_style = 'updated';
					add_style = 'error';

					additional_info = '';
					if( typeof formatted_data['additional info'] != "undefined" ){
						additional_info =  formatted_data['additional info'];
					}

					html_msg = "<p><strong>" + formatted_data.error + ": " + additional_info + " </strong></p>";
				}
				else if(formatted_data.deactivated){
					add_style = 'updated';
					remove_style = 'error';
					html_msg = "<p><strong> The licence has been deactived successfully</strong></p>";
					jQuery("#aw-activation").show();
					jQuery("#aw-deactivation").hide();
				}
				else{
					remove_style = 'updated';
					add_style = 'error';
					html_msg = "<p><strong> " + formatted_data + "</strong></p>";
				}
				me.removeClass('deactive');
				jQuery("#result").html(html_msg)
								.show()
								.removeClass(remove_style)
								.addClass(add_style);
			});
		}

	});
</script>