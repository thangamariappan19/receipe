<?php 
global $current_user;
$current_user=wp_get_current_user();

$email = $current_user->user_email;
?>
<div id="sfsi_plus_jivo_offline_chat" style="display:none">
	<a href="" style="float:right;font-size:20px;margin-right:5px;color:#888;text-decoration: none;"  onclick="sfsi_close_offline_chat(event)">X</a>
	<p style="text-align:center" class="heading-text">No chat agent are available, However we'll still respond quickly.
		<!-- <a target="_blank" href="https://goo.gl/MU6pTN#no-topic-0" >we'll still respond quickly</a> -->
	</p>
	<ul class="tab-changer">
		<li class="tab-link active"><p style="text-align:center"><a href="#sfsi_technical"></a>Technical question<br><span>(for the free plugin)</span></span></p></li>
		<li class="tab-link"><p style="text-align:center"><a href="#sfsi_sales"></a>Pre-sales question<br><span>(for the Premium plugin)</span></p></li>
	</ul>
	<div class="clear"></div>
	<div class="tabs">
		<div id="sfsi_technical" class="tab-content" style="text-align:center;display:block">
			<p>Please ask your question in the...</p>
			<div class="support-forum-green-div">
				<a target="_blank" href="https://goo.gl/MU6pTN#no-topic-0" class="support-forum-green-bg">
	                <img src="<?php echo SFSI_PLUS_PLUGURL ?>images/support.png">
	                <p class="support-forum">Support Forum</p>
	            </a>
	        </div>
	        <p class="sfsi-button-right-side" ><span class="sfsi-button-right-side-icon"></span>Click here</p>
			<p>We‘ll respond <span style="text-decoration: underline;font-weight:500">quickly!</span></p>
		</div>
		<div id="sfsi_sales" class="tab-content" style="display:none">
			
			<div style="display:block" class="before_message_sent">
				<p class="right-message" style="display:none">Please also check the <a href="">FAQ</a></p>	
				<form action="#" method="POST" >
					<div>
						<label for="question">Your question: </label>
						<textarea id="question" name="question"></textarea>
					</div>
					<div>
						<div style="width:60%;float:left">
							<label for="email">Your email:</label>
							<input type="email" name="email" value="<?php echo $email; ?>">
						</div>
						<div style="width:35%;float:right">
							<input type="submit" value="Send message">
						</div>
						<div class="clear"></div>
					</div>
				</form>
			</div>
			<div style="display:none" class="after_message_sent">
				<h2>Thank you!</h2>
				<h3>We‘ll get back to you ASAP.</h3>
				<button class="chat_btn" onclick="sfsi_close_offline_chat(event)">Close window</button>
			</div>
		</div>
	</div>

</div>
<!-- Start jivo chat code -->

<script>
var sfsi_plus_jivo_init=function(){
	var widget_id =window.sfsi_plus_jivo_widget_id= 'heGfAHWfsn';
	var d=document;
	var w=window;
	function l(){
		var s = document.createElement('script'); 
		s.type = 'text/javascript'; 
		s.async = false;
		s.src = '//code.jivosite.com/script/widget/'+widget_id; 
		var ss = document.getElementsByTagName('script')[0]; 
		ss.parentNode.insertBefore(s, ss);
		SFSI(".sfsi_plus_wait_container").hide();
	}
	if(d.readyState=='complete'){
		l();
		// console.log('already loaded');
	}else{
		if(w.attachEvent){
			w.attachEvent('onload',l);
			// console.log('attachEvent');
		}else{
			// console.log('addEventListener');
			w.addEventListener('load',l,false);
		}
	}
};
var sfsi_dummy_chat_icon={};
sfsi_dummy_chat_icon.element=document.createElement('div');
sfsi_dummy_chat_icon.element.id="sfsi_dummy_chat_icon";
sfsi_dummy_chat_icon.element.style="position:fixed; bottom:0;right:10px;width:350px;height:74px;cursor:pointer;background-image:url('<?php echo SFSI_PLUS_PLUGURL.'images/Chat_with_us_bar_light_green.png' ?>');background-position: -12.5px -11.5px;background-size: 374px 101px;border-top-left-radius: 8px;border-top-right-radius: 8px;";
sfsi_dummy_chat_icon.element.onclick=function(){
	SFSI(".sfsi_plus_wait_container").show();
}
function sfsi_plus_open_chat(){
	// console.log('window.jivo_api',window.jivo_api);
	if(window.jivo_api){
		// console.log('window.jivo_api.chatMode',window.jivo_api.chatMode());
		if( window.jivo_api.chatMode()==='online'){

			// console.log('window.jivo_api.showProactiveInvitation',window.jivo_api.showProactiveInvitation('How can I help you?'));
			window.jivo_api.open();
			jQuery(".sfsi_plus_wait_container").hide();
		}else{
			jQuery('#jivo-iframe-container').remove();
			jQuery('script[src="//code.jivosite.com/script/widget/'+sfsi_plus_jivo_widget_id+'"]').remove();
			jQuery('#sfsi_plus_jivo_offline_chat').show();
			jQuery(".sfsi_plus_wait_container").hide()
		}
		jQuery(sfsi_dummy_chat_icon.element).hide();
	}else{
		sfsi_plus_jivo_init();
		// console.log('hey');
		jQuery(sfsi_dummy_chat_icon.element).hide();
	}
	// jQuery(sfsi_dummy_chat_icon.element).html("<p style='text-align: center;font-size: 18px;'>Loading...</p>");
	// jQuery(sfsi_dummy_chat_icon.element).hide();
}
sfsi_dummy_chat_icon.element.onclick=sfsi_plus_open_chat;
var jivo_onLoadCallback = function(){
	if(jivo_api && jivo_api.chatMode()==='online'){
		jQuery(".sfsi_plus_wait_container").hide();
		jivo_api.showProactiveInvitation('How can I help you?');
	}else{
		jQuery('#jivo-iframe-container').remove();
		jQuery('script[src="//code.jivosite.com/script/widget/'+sfsi_plus_jivo_widget_id+'"]').remove();
		jQuery('#sfsi_plus_jivo_offline_chat').show();
		jQuery(".sfsi_plus_wait_container").hide();
	}
	jQuery(sfsi_dummy_chat_icon.element).hide();
};
// sfsi_dummy_chat_icon.heading= document.createElement('p');
// sfsi_dummy_chat_icon.warning= document.createElement('p');
// sfsi_dummy_chat_icon.heading.style="margin: 0;text-align: center;font-size: 18px;margin-top: 5px;"
// sfsi_dummy_chat_icon.warning.style="font-size:11px;text-align: center;margin-bottom: 0;margin-top: 4px;"
// sfsi_dummy_chat_icon.heading.appendChild(document.createTextNode("Questions? Chat with us!"));
// sfsi_dummy_chat_icon.warning.appendChild(document.createTextNode("This will establish connection to the chat servers."));
// sfsi_dummy_chat_icon.element.appendChild(sfsi_dummy_chat_icon.heading);
// sfsi_dummy_chat_icon.element.appendChild(sfsi_dummy_chat_icon.warning);
sfsi_dummy_chat_icon.body=document.getElementsByTagName('body');
if(sfsi_dummy_chat_icon.body.length>0){
	sfsi_dummy_chat_icon.body[0].appendChild(sfsi_dummy_chat_icon.element);
}else{
	document.appendChild(sfsi_dummy_chat_icon.element);
}
</script>

<!-- End jivo chat code -->
