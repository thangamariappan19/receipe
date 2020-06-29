"use strict";
jQuery(function($){
	
	$('.wpr-role-control').hide();
	var role = $('.wpr_role').val();
	if (role === 'user_role') {
		$('.wpr-role-control').show();
	}

	jQuery(document).on('change', '.wpr-member-control select', function(e){
        
        e.preventDefault();
        var role_value = $(this).val();
        
        if (role_value == 'user_role' ) {
           $('.wpr-role-control').show();
        }else if( role_value == 'public' || role_value == 'all_member' ){
           $('.wpr-role-control').hide();
        }
	});

	$('.wpr_select2').select2({
            placeholder: 'Select Option',
            width : '100%',
    });
});