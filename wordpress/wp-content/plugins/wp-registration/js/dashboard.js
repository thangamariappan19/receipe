"use strict";
jQuery(function($){
    
    // select2 control for wpr settings
    $('.wpr-selecterss').select2({
        placeholder: 'Select',
        width:"100%",
    });

    $('.wpr_migrate_form').find('.wpr-pass-alert').hide();
    $(".wpr_migrate_btn").on('click', function(e) {
		e.preventDefault();
        var form_key  = jQuery('#previous_form_key').val();
		var form_key  = jQuery('#previous_form_key').val();
		var data = {  
                        'action': 'previous_form_array_converted', 
                        // 'wpr_nonce': wpr_nonce, 
                        // 'old_password': oldpassword,
                        'form_key': form_key
                    };

        $.post(ajaxurl, data, function(resp){
            if (resp.status == 'error') {

                $('.wpr_migrate_form').find('.wpr-pass-alert').show().html(resp.message).css({"background-color": '#f4433685',
                                                                                      "border-left" : "4px solid #FF5722"});
            }
            else {
            $('.wpr_migrate_form').find('.wpr-pass-alert').show().html(resp.message).css({"background-color": '#7dcd809c',
                                                                                      "border-left" : "4px solid #4CAF50"});  
            }
            setTimeout(function(){
                $('.wpr-pass-alert').hide();
            }, 3000);
        });
	});


    $(".wpr-custom-btn").on('click', function(e) {
        e.preventDefault();
        $(this).hide();
        $( '.wpr_users_date_query_wrapper').show();
    });

    
    $(".wpr-msg-box").hide();

    $(".wpr_select_role").on('change', function(e) {
        e.preventDefault();
        var value = $(this).val();
        $(".wpr-msg-box").hide();
        $(".wpr-role-"+value+"").show(); 
    });


    $('#wpr_dashboard_analiyzer').find('.wpr-pass-alert').hide();

    // Submitting date form 
    $("#wpr_dashboard_date_form").submit(function(e){
        e.preventDefault();

        var data = $(this).serialize();

        $.post(ajaxurl, data, function(data){
        	
        	$('.wpr-date-query-result').html('User ' + data.user);
    	}, 'json');
    });

    // assign the form of previous user 
    $("#wpr_dashboard_analiyzer").submit(function(e){
        e.preventDefault();
        var data = $(this).serialize();
       
        $.post(ajaxurl, data, function(resp) {
           
            if (resp.status == 'error') {

                $('#wpr_dashboard_analiyzer').find('.wpr-pass-alert').show().html(resp.message).css({"background-color": '#f4433685',
                                                                                      "border-left" : "4px solid #FF5722"});
            }
            else {
            $('#wpr_dashboard_analiyzer').find('.wpr-pass-alert').show().html(resp.message).css({"background-color": '#7dcd809c',
                                                                                      "border-left" : "4px solid #4CAF50"});
                $('.wpr_total_user').html(resp.total_users);
            }
            setTimeout(function(){
                $('.wpr-pass-alert').hide();
            }, 3000);
         
        });
 
    });

    $('#wpr_dashboard_admin_message').find('.wpr-pass-alert').hide();
    //send the admin message from user profile
    $("#wpr_dashboard_admin_message").submit(function(e){
        e.preventDefault();
        var data = $(this).serialize();
       
        $.post(ajaxurl, data, function(resp) {
            
            if (resp.status == 'error') {

                $('#wpr_dashboard_admin_message').find('.wpr-pass-alert').show().html(resp.message).css({"background-color": '#f4433685',
                                                                                      "border-left" : "4px solid #FF5722"});
            }
            else {
            $('#wpr_dashboard_admin_message').find('.wpr-pass-alert').show().html(resp.message).css({"background-color": '#7dcd809c',
                                                                                      "border-left" : "4px solid #4CAF50"});
            }
            setTimeout(function(){
                $('.wpr-pass-alert').hide();
            }, 3000);
         
        });
 
    });
    
    
    $('#wpr_dashboard_send_email').find('.wpr-email-alert').hide();
    // send email to users
     $("#btn_email_send").on('click',function(e){
        e.preventDefault();
        
        $("#send_email").show();
        
         
        var email_subject  = $('#email_subject').val();
        var email_message  = $('#email_msg').val();
    	var user_email     = $('.selected_user_email').val();
	    
	    
        var data = {
    		    'action' : 'wpr_send_email_to_user',
    		    'email_subject': email_subject,
    		    'email_message': email_message,
    		    'user_email'   : user_email,
    		}
         
        
        $.post(ajaxurl, data, function(resp) {
            $("#send_email").hide();   
            if (resp.status == 'error') {

                $('#wpr_dashboard_send_email').find('.wpr-email-alert').show().html(resp.message).css({"background-color": 'rgba(237, 39, 24, 0.47)',
                                                                                      "border-left" : "4px solid rgb(115, 71, 68)"});
            }
            else {
            $('#wpr_dashboard_send_email').find('.wpr-email-alert').show().html(resp.message).css({"background-color": '#7dcd809c',
                                                                                      "border-left" : "4px solid #4CAF50"});
            }
           
            setTimeout(function(){
                $('.wpr-email-alert').hide();
            }, 3000);
         
        });
 
    });
    
});    