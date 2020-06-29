"use strict"

jQuery( function($) {
    
    function checkLoginState() {
    	$("#wpr-doing-facebok").html('Checking FB login status');
    	
      FB.getLoginStatus(function(response) {
      	
         if (response.status === 'connected') {
    	   $("#wpr-doing-facebok").html('Connected with FB');
    	    var my_fb_data;
    	    FB.api("/me/?fields=email, first_name, last_name",  function(my) {
    	    
   	    	register_me_with_fb(my);
    	    });
    	  }
      });
    }
    
    function register_me_with_fb(my){
    	
    	$("#wpr-doing-facebok").append('<img src="' + wpr_vars.doing + '">');
    	
    	var data = {action: 'wpr_create_user_fb', fb_data: my};
    	jQuery.post(wpr_vars.ajaxurl, data, function(resp) {
    		
    	
    		if(resp.status == 'error'){
    			//show all sections if hidden
    			$("#wpr-doing-facebok").html(resp.message).css('color', 'red');
    		}else{
    			
    			$("#wpr-doing-facebok").html(resp.message).css('color', 'green');
    			window.location = resp.redirect_uri;
    		}		
    	}, 'json');	
    }
});