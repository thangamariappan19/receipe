"use strict";
jQuery(function($){

	if ( $(document).find('.wpr-woocomerce-order-detail').length != 0 ) {
		$('.wpr_li_check').each(function(index, val){
			$(val).find('a').attr("aria-expanded", "false");
		});
		
		$('.wpr-tab-pane:first').removeClass('active');
		
		$('.wpr_li_check:nth-child(2)').addClass('active');
		$('.wpr_li_check:nth-child(2) a').attr("aria-expanded", "true");
		$('#woocommerce').addClass('active');
	}


    $(".u-column1 a").click(function(e){
		e.preventDefault();
		var permalink_account = $(".wpr-edit-url").val();
		var edit_url_billing  = $(".u-column1 a").attr('href');
		var last_bill   	 = edit_url_billing.split('/');
		var lastSegmentBill = last_bill.pop() || last_bill.pop();  // handle potential trailing slash
		
			if(edit_url_billing.indexOf(lastSegmentBill) > -1) {
	       		window.location = permalink_account+'edit-address' +'/'+ lastSegmentBill;
	    	}
    });

	$(".u-column2 a").click(function(e){
		e.preventDefault();
		var permalink_account = $(".wpr-edit-url").val();
		var edit_url_shipping = $(".u-column2 a").attr('href');
		var last_ship   = edit_url_shipping.split('/');
		var lastSegmentShip = last_ship.pop() || last_ship.pop();  // handle potential trailing slash	
	    	if(edit_url_shipping.indexOf(lastSegmentShip) > -1) {
	       		window.location = permalink_account+'edit-address' +'/'+ lastSegmentShip;
	    	}	
    });


	$( '.wpr-pr-change-photo').hide();
	$( '.wpr-pr-coverupload').hide();
	$( ".wpr-pr-userphotp" ).mouseenter(function() {
    	$( '.wpr-pr-change-photo').show();
  	});	
	$( ".wpr-pr-userphotp" ).mouseleave(function() {
		$( '.wpr-pr-change-photo').hide();
  	});
  	
	$( ".wpr-pr-coverphoto" ).mouseenter(function() {
    	$( '.wpr-pr-coverupload').show();
  	});	
	$( ".wpr-pr-coverphoto" ).mouseleave(function() {
		$( '.wpr-pr-coverupload').hide();
  	});

  	// user delete account 

  	$(document).on('click', '.wpr_user_delete_account', function(e) {
  		e.preventDefault();
  		var user_id = jQuery('#wpr_delete_account').val();
  		var data = {	
						'action': 'delete_user_account', 
						// 'wpr_nonce': wpr_nonce, 
						'user_id': user_id
					};
  		$.post(wpr_vars.ajax_url, data, function(resp) {
  		
				WPR.alert(resp.message, resp.status, function(){ 
	                   location.reload();
        		});

			}, 'json');
  	});
	// change password setting
	$('.wpr-pr-pass-wrapper').find('.wpr-pass-alert').hide();
    $(document).on('click', '.wpr-change-pass', function(e) {

    	e.preventDefault();
		jQuery(".wpr-pass-alert").html('<img src="' + wpr_vars.loading + '">').css('border-left','none').show();

		var has_error 		= false;		
		var oldpassword 	= jQuery('#old_password').val();
		var newpassword 	= jQuery('#new_password').val();
		var renewpassword 	= jQuery('#re_new_password').val();
		var wpr_nonce 		= jQuery('#wpr_change_pass_nonce').val();

		if (oldpassword == ''){
			jQuery(".wpr-pass-alert").html( wpr_vars.strings.old_password_empty ).css('border-left','7px solid red').show();
			has_error = true;
		}
		else if(newpassword == ''){
			jQuery(".wpr-pass-alert").html( wpr_vars.strings.new_password_empty ).css('border-left','7px solid red').show();
			has_error = true;
		}
		else if(newpassword != renewpassword){
			jQuery(".wpr-pass-alert").html( wpr_vars.strings.new_password_not_match ).css('border-left','7px solid red').show();
			has_error = true;
		}
		
		if (!has_error){
			var data = {	
						'action': 'profile_change_password', 
						'wpr_nonce': wpr_nonce, 
						'old_password': oldpassword,
						'new_password': newpassword
					   };
					   
			$.post(wpr_vars.ajax_url, data, function(data) {
				

				WPR.alert(data.message, data.status, function(){ 
	                if (data.status == 'error') {
	                    jQuery('.wpr-pr-pass-wrapper').find('.wpr-pass-alert').hide();
	                }else{
	                   location.reload();
	                }
        		});

			}, 'json');
		}
  	});
});