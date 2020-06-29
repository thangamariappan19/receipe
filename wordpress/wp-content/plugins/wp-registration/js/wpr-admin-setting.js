"use strict";
jQuery(function($){

    // hide wpr setting on load and run loader
    // setInterval(function(){
    //     $('.wpr_refresh_loader').hide();
    //     $('.wpr_setting_page_hide').show();
    // },1000);

    $(window).load(function() {
        // Animate loader off screen
        $(".wpr_refresh_loader").hide();
        $('.wpr_setting_page_hide').show();
    });

    // tabs system for wpr settings
    $('.wp-color').wpColorPicker();
        $( "#tabs" ).tabs();

    // ajax callback function for saved all wpr settings
    $('.wpr_sub_st_control').find('.wpr-spinner').hide(); //@today_work
    $('#wpr_settings_form').on('submit',function(e){
        e.preventDefault();

        $('.wpr_sub_st_control').find('.wpr-spinner').show(); //@today_work
        $(this).find('.wpr_sub_st_control input').prop('disabled', true); //work

        var data = $(this).serialize();
        
        $.post(ajaxurl, data, function(response){
            $('.wpr_sub_st_control').find('.wpr-spinner').hide(); //@today_work
            $('.wpr_save_alert').removeClass('alert_display');
            window.location.reload();
            
        });
    });

    $('[data-hide-url ="set_advance"]').hide();
    $(document).on('click', '[data-show-url ="wpr-url-toggle"]', function(e) {
        e.preventDefault();
        $('[data-hide-url="set_advance"]').slideToggle(500);
    // $('[data-advance="set_advance"]').show();
    });


    // select2 control for wpr settings
    $('.wpr-select2').select2({
        placeholder: 'Select',
        width:"65%",
    });

    $(".gn_roles").select2({
        placeholder: "Select",
        // allowClear: true,
        width:"65%",
        // multiple:true
    });

    $("Select.wpr_op_select").select2({
        placeholder: "Select",
        allowClear: true,
        width:"65%",
    });
});