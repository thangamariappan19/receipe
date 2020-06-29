"use strict";
jQuery(function($){


	$('.wpr_model_selector').find('.error').hide();
	$('.wpr_model_selector').find('.wpr-spinner').hide();
	$('.wpr_field_icon').hide();


	var LoginId = $('.wpr-get-login-class').attr('data-login-menu');
	
		var LoginUrl = $('.wpr-get-login-url').attr('data-login-url');
		if (LoginUrl) {
			
			var last_url = LoginUrl.split('/');
			var lastSegmenturl = last_url.pop() || last_url.pop(); 
			$(document).ready(function () {
			    if(window.location.href.indexOf(lastSegmenturl) > -1) {
			       $('#menuclass_id').modal('show'); 
			    }
			});
		}
		
	
	var RegId   = $('.wpr-get-account-class').attr('data-account-menu');



	//login model show
	$('.'+LoginId).on('click', function(e) {
		  e.preventDefault();
 
    	$('#menuclass_id').modal('show'); 
    }); 

    $('.'+RegId).on('click', function(e) {
		  e.preventDefault();
 
    	$('#menuclass_id').modal('show'); 
    }); 

	// registration form check confirm password 
	$('.wpr-pr-pass-wrapper').find('.wpr-pass-confirm-alert').hide();
   
    
    // // Submitting rgistration form 
    $(".wpr-forms").submit(function(e){
        e.preventDefault();
        var is_validated =   wpr_validate_data_form();
 		
 		var password	= jQuery('#password').val();
 		var password	= jQuery('#password').val();
    	var confirm_password 	= jQuery('#wpr_confirm_password').val();

			if(password != confirm_password && confirm_password != undefined ){
				var check_pass = '_ok_pass';
			is_validated = false;
			}


        if (is_validated) {
	        $(this).find('.error').hide();
	        $(this).find('.wpr-spinner').show();
	        $(this).find('.wpr_sub_form input').prop('disabled', true);
	        $(this).find('.wpr-pr-spinner-wrapper input').prop('disabled', true);

        	var data = $(this).serialize();
	        $.post(wpr_vars.ajax_url, data, function(data){

        		$('.wpr_model_selector').find('.wpr-spinner').hide();
	        	$('.wpr_model_selector').find('.wpr_sub_form input').prop('disabled', false);

	        	if (data.signup == 'signup') {
	        		WPR.alert(data.message, data.status, function(){
	        			if (data.status == 'error') return;
		        		
		        		var signup_url = data.redirect_url_signup;
	        			if (signup_url != null) {
	                    	window.location.href = signup_url;   
		                }else{
		                	$('.wpr_model_selector').hide();
		                	$('.wpr-form-title').html(data.message);
		                }
	        		});
        		}else{
        			WPR.alert(data.message, data.status);
        		}

	    	}, 'json');
    	}else{
    		// if (confirm_password == null) continue;
    		if (check_pass == '_ok_pass') {
			$(this).find(".error").html('Password did not match').show();
    			
    		}else{

			$(this).find(".error").html(wpr_vars.error_msg).show();
    		}
    	}
    });


    $('#password').keyup(function() {
		$('#password_result').html(checkStrength($('#password').val()))
	});

	/*Password Strenght Module*/

function checkStrength(password) {
		var strength = 0
		if (password.length < 6) {
			jQuery('#password_result').removeClass()
			jQuery('#password_result').addClass('short')
			return 'Too short'
		}
		if (password.length > 7) strength += 1
		// If password contains both lower and uppercase characters, increase strength value.
		if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 1
		// If it has numbers and characters, increase strength value.
		if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) strength += 1
		// If it has one special character, increase strength value.
		if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
		// If it has two special characters, increase strength value.
		if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
		// Calculated strength value, we can return messages
		// If value is less than 2
		if (strength < 2) {
			jQuery('#password_result').removeClass()
			jQuery('#password_result').addClass('weak')
			return 'Weak'
		} else if (strength == 2) {
			jQuery('#password_result').removeClass()
			jQuery('#password_result').addClass('good')
			return 'Good'
		} else {
			jQuery('#password_result').removeClass()
			jQuery('#password_result').addClass('strong')
			return 'Strong'
		}
	}


    function wpr_validate_data_form(){
			
		var has_error = true;
	    $('.wpr_field_selector').each(function(i, meta_field){

	        var data_name = $(meta_field).attr('data-key');
	        var type = $(meta_field).attr('data-type');
	        var input_control = $("#"+ data_name);
	    	var required = $(meta_field).find('.wpr_field_data').attr('data-req');
	    	var msg = $(meta_field).find('.wpr_field_data').attr('data-message');
	    	var max_checked = $(meta_field).find('.wpr_field_data').attr('data-max');
	    	var min_checked = $(meta_field).find('.wpr_field_data').attr('data-min');

	    	var accept_pass = $(meta_field).find('.wpr_field_data').attr('data-pass');
	    	

	    	// password check confirm
	    	

	    	
	    	if (msg == '') {
	    		msg = 'It is required!';
	    	}

	    	

			if(type === 'text' || type === 'textarea' || type === 'color' || type === 'select' || type === 'email' || type === 'date' || (type === "wp" && data_name1 !== "password") ){
		        if (required === 'on' && jQuery(input_control).val() === '') {
			
					jQuery(input_control).closest('.wpr_field_wrapper').find('span.wpr_field_error').html(msg).css('color', 'red');
					 has_error = false;
		        }else{
					jQuery(input_control).closest('.wpr_field_wrapper').find('span.wpr_field_error').html('').css({'border' : '','padding' : '0'});
				}

			}else if(type === 'radio'){
				if(required === "on" && jQuery('input:radio[name="wpr[radio]['+data_name+']"]:checked').length === 0){
					jQuery('input:radio[name="wpr[radio]['+data_name+']"]').closest('.wpr_field_wrapper').find('span.wpr_field_error').html(msg).css('color', 'red');
					has_error = false;
				}else{
					jQuery('input:radio[name="wpr[radio]['+data_name+']"]').closest('.wpr_field_wrapper').find('span.wpr_field_error').html('').css({'border' : '','padding' : '0'});
				}

			}else if(type === 'checkbox'){
			
				if(required === "on" && jQuery('input:checkbox[name="wpr[checkbox]['+data_name+'][]"]:checked').length === 0){
					
					jQuery('input:checkbox[name="wpr[checkbox]['+data_name+'][]"]').closest('.wpr_field_wrapper').find('span.wpr_field_error').html(msg).css('color', 'red');
					has_error = false;
				}else if(min_checked != '' && jQuery('input:checkbox[name="wpr[checkbox]['+data_name+'][]"]:checked').length < min_checked){
					jQuery('input:checkbox[name="wpr[checkbox]['+data_name+'][]"]').closest('.wpr_field_wrapper').find('span.wpr_field_error').html(msg).css('color', 'red');
					has_error = false;
				}else if(max_checked != '' && jQuery('input:checkbox[name="wpr[checkbox]['+data_name+'][]"]:checked').length > max_checked){
					jQuery('input:checkbox[name="wpr[checkbox]['+data_name+'][]"]').closest('.wpr_field_wrapper').find('span.wpr_field_error').html(msg).css('color', 'red');
					has_error = false;
				}else{
					
					jQuery('input:checkbox[name="wpr[checkbox]['+data_name+'][]"]').closest('.wpr_field_wrapper').find('span.wpr_field_error').html('').css({'border' : '','padding' : '0'});
					
					}
			}else if(type === 'masked'){
						
				if(required === "on" && (jQuery(input_control).val() === '' )){
					jQuery(input_control).closest('.wpr_field_wrapper').find('span.wpr_field_error').html(msg).css('color', 'red');
					has_error = false;
				}else{
					jQuery(input_control).closest('.wpr_field_wrapper').find('span.wpr_field_error').html('').css({'border' : '','padding' : '0'});
				}
			}else if(type === 'autocomplete'){
						
				if (required == 'on' && jQuery(input_control).val() == null) {
					jQuery(input_control).closest('.wpr_field_wrapper').find('span.wpr_field_error').html(msg).css('color', 'red');
					 has_error = false;
		        }else{
					jQuery(input_control).closest('.wpr_field_wrapper').find('span.wpr_field_error').html('').css({'border' : '','padding' : '0'});
				}
			}else if (type === 'password') {
				// var input_control = jQuery('#'+meta['data_name']);
			
				if(accept_pass === "on" && (checkStrength(jQuery('#password').val()) == 'Weak' || checkStrength(jQuery('#password').val()) == 'Too short') ){
					jQuery(input_control).closest('p').find('span.errors').html('Set Strong Password').css('color', 'red');
					has_error = true;
					// error_in = meta['data_name'];
				}

			}


        });
	    return has_error;
    }


    $('.wpr_field_selector').each(function(i, meta_field){
        var data_name = $(meta_field).attr('data-key');
        var input_control = $('#'+data_name);
        var type = $(meta_field).attr('data-type');

		if (type === 'select') {

			$("#"+data_name).select2({
			    placeholder: "Select",
			    allowClear: true,
			    width:"100%"
			});	
		}
	});

	$('.wpr_field_wrapper').each(function(i, meta_field){
		var required = $(meta_field).find('.wpr_field_data').attr('data-req');
		
	   	if (required == 'on') {
	    	$(meta_field).find('.wpr_field_icon').show();
	    }
	});

});