"use strict";
jQuery(function($){
    
    /*********************************
    *       WPR Form Design JS       *
    **********************************/

    /**
        get last field number 
    **/
    var field_no = $('#field_index').val();
    
    
    // select2 control for wpr settings
    $('.wpr-selecters').select2({
        placeholder: 'Select',
        width:"52%",
    });

    /**
        wp color picker
    **/
    $('.wp-color').wpColorPicker();

    /**
        prevent page refresh after click on icon model button
    **/
    $(document).on('click', '.wpr_add_icon_btn', function(event) {
        event.preventDefault();
    });

    /**
        wp core field data_name chose from select core fields options
    **/
    $('[data-table-id="wp_field"] [data-meta-id="data_name"] input').prop('readonly', true);
    $(document).on('click', '[data-meta-id="wp_fields"] select', function(event) {
        event.preventDefault();

        var $this = $(this);
        var wp_core_field = $this.closest('.wpr-slider');
        var wp_val = $(this).val();
        wp_core_field.find('table [data-meta-id="data_name"] input').val(wp_val);
    });

    /**
        password of wp fields
    **/
    $('table [data-meta-id="confirm_pass"]').hide();
    $('table [data-meta-id="accpt_weak_pass"]').hide();
    $(document).on('click', '[data-meta-id="wp_fields"] select', function(event) {
        event.preventDefault();

        var $this = $(this);
        var wp_core_field = $this.closest('.wpr-slider');
        var wp_val = $(this).val();
        wp_core_field.find('[data-meta-id="privacy"] select').each(function(i, meta_field){
            if (wp_val == 'password') {
               wp_core_field.find('[data-meta-id="confirm_pass"]').show();
               wp_core_field.find('[data-meta-id="accpt_weak_pass"]').show();
            }else {
               wp_core_field.find('[data-meta-id="confirm_pass"]').hide();
               wp_core_field.find('[data-meta-id="accpt_weak_pass"]').hide();
            }
        });
    });

    /**
        wpr check privacy role
    **/
    $('table [data-meta-id="privacy_role"]').hide();
    $(document).on('click', '[data-meta-id="privacy"] select', function(event) {
        event.preventDefault();

        var $this = $(this);
        var $this_privacy = $this.closest('.wpr-slider');
        var role_value = $(this).val();
        $this_privacy.find('[data-meta-id="privacy"] select').each(function(i, meta_field){
            
                if (role_value == 'specific_role_1' || role_value == 'specific_role_2') {
                   $this_privacy.find('[data-meta-id="privacy_role"]').show();
                }else if(role_value == 'everyone_view' || role_value == 'member_view' || role_value=='only_owner_admin'){
                   $this_privacy.find('[data-meta-id="privacy_role"]').hide();
                }
        });
        $this_privacy.find('select.privacy_check').select2({
            placeholder: 'Select Role',
        });
    });

    /**
        remove all fields which not add and saved
    **/
    $(document).on('click', '.wpr-close-fields', function(event) {
        event.preventDefault();

        $(this).closest('.wpr-slider').addClass('wpr-unsave-data');
    });
    $(document).on('click', '#publish', function(event) {
        
        $('.wpr-unsave-data').remove();
    });

    /**
        checkall and uncheckall fields
    **/
    $('.wpr-main-field-wrapper').on('click', '.wpr-check-all-field input', function(event) {
        if($(this).prop('checked')){
            $('.wpr_field_table input[type="checkbox"]').prop('checked',true);
        }
        else{
            $('.wpr_field_table input[type="checkbox"]').prop('checked',false);
        }
    });
    $('.wpr-main-field-wrapper').on('click', '.wpr_field_table tbody input[type="checkbox"]', function(event) {
        if($('.wpr_field_table tbody input[type="checkbox"]:checked').length == $('.wpr_field_table tbody input[type="checkbox"]').length){
             $('.wpr-check-all-field input').prop('checked',true);
        }
        else{
             $('.wpr-check-all-field input').prop('checked',false);
        }
    });
    
    /**
        wpr remove fields
    **/
    $('.wpr-main-field-wrapper').on('click', '.wpr_remove_field', function(e){
        e.preventDefault();
        
        var check_field = $('.wpr-check-one-field input[type="checkbox"]:checked');


        if (check_field.length > 0 ) {
            swal({
                title: "Are you sure?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55 ",
                cancelButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: true
                }, function (isConfirm) {
                    if (!isConfirm) return;


                    $('.wpr_field_table').find('.wpr-check-one-field input').each(function(i, meta_field){

                        if (this.checked) {


                            var field_id = $(meta_field).val();
                            var data_op = $(meta_field).attr('data-io');
                            // console.log(data_op);
                            // if (data_op == "user_email" && data_op == 'user_login') {
                            //     $('.erro').html('Error For email');
                            // }
                            $(meta_field).parent().parent('.row_no_'+field_id+'').remove();
                            
                        }
                        $('.wpr_save_fields_model').find('#wpr_field_model_'+field_id+'').remove();
                    });
            });
        }else{
            swal("Please at least check one field!", "", "error");
        }
    });

    /**
        Edit all fields
    **/
    $(document).on('click', '.wpr-edit-field', function(event) {
        event.preventDefault();

        var the_id = $(this).attr('id');
        $('#wpr_field_model_'+the_id+'').modal('show');
        $('#wpr_field_model_'+the_id+'').find('.wpr-close-checker').removeClass('wpr-close-fields');
    });

    /**
        Add New fields
    **/
    $(document).on('click', '.wpr-add-field', function(event) {
        event.preventDefault();

        var $this = $(this);
        var ui = wpr_required_data_name($this);
        if (ui == false) {
            return;
        }

        var id = $(this).attr('data-field-index');
            id = Number(id);

        var field_title = $('#wpr_field_model_'+id+'').find('.modal-body table').attr('data-table-id'); 
        var data_name   = $('#wpr_field_model_'+id+'').find('[data-meta-id="data_name"] input').val();
        var title       = $('#wpr_field_model_'+id+'').find('[data-meta-id="title"] input').val();
        var placeholder = $('#wpr_field_model_'+id+'').find('[data-meta-id="placeholder"] input').val();
        var required    = $('#wpr_field_model_'+id+'').find('[data-meta-id="required"] input').prop('checked');
        var email_req    = $('#wpr_field_model_'+id+'').find('[data-meta-id="email_req"] input').prop('checked');
        var type        = $(this).attr('data-field-type');
        if (required == true) {
            var _ok = 'Yes';
        }else{
            _ok = 'No';
        }
        if (email_req == true) {
            var _oks = 'Yes';
        }else{
            _oks = 'No';
        }
        if (placeholder == null) {
            placeholder = '';
        }

        var html  = '<tr class="row_no_'+id+'" id="wpr_sort_id_'+id+'">';
                html += '<td class="wpr-sortable-handle"><i class="fa fa-arrows" aria-hidden="true"></i></td>';
                html += '<td class="wpr-check-one-field"><input type="checkbox" value="'+id+'"></td>';
                html += '<td class="wpr_meta_field_id">'+data_name+'</td>';
                html += '<td class="wpr_meta_field_type">'+type+'</td>';
                html += '<td class="wpr_meta_field_title">'+title+'</td>';
                html += '<td class="wpr_meta_field_plchlder">'+placeholder+'</td>';
                html += '<td class="wpr_meta_field_req">'+_ok+'</td>';
                html += '<td class="wpr_meta_email_field_req">'+_oks+'</td>';
                html += '<td>';
                    html += '<button class="wpr_copy_field button" data-field-type="'+field_title+'"><i class="fa fa-clone" aria-hidden="true"></i></button>';
                    html += '<button class="wpr-edit-field button" id="'+id+'"><i class="fa fa-pencil" aria-hidden="true"></i></button>';
                html += '</td>';
            html += '</tr>';

         $(html).appendTo('.wpr_field_table tbody');

         $(this).removeClass('wpr-add-field').addClass('wpr-update-field');
         $(this).html('Update Field');
         $('#wpr_field_model_'+id+'').modal('hide');
    });

    /**
        Update exiting fields
    **/
    $(document).on('click', '.wpr-update-field', function(event) {
        event.preventDefault();

        var $this = $(this);
        var ui = wpr_required_data_name($this);
        
        if (ui == false) {
            return;
        }

        var id = $(this).attr('data-field-index');
            id = Number(id);

        var data_name   = $('#wpr_field_model_'+id+'').find('[data-meta-id="data_name"] input').val();
        var title       = $('#wpr_field_model_'+id+'').find('[data-meta-id="title"] input').val();
        var placeholder = $('#wpr_field_model_'+id+'').find('[data-meta-id="placeholder"] input').val();
        var required    = $('#wpr_field_model_'+id+'').find('[data-meta-id="required"] input').prop('checked');
        var email_req    = $('#wpr_field_model_'+id+'').find('[data-meta-id="email_req"] input').prop('checked');
        var type        = $(this).attr('data-field-type');
        
        if (required == true) {
            var _ok = 'Yes';
        }else{
            _ok = 'No';
        }


        if (email_req == true) {
            var _oks = 'Yes';
        }else{
            _oks = 'No';
        }

        var row = $('.wpr_field_table tbody').find('.row_no_'+id);

        row.find(".wpr_meta_field_title").html(title);
        row.find(".wpr_meta_field_id").html(data_name);
        row.find(".wpr_meta_field_type").html(type);
        row.find(".wpr_meta_field_plchlder").html(placeholder);
        row.find(".wpr_meta_field_req").html(_ok);
        row.find(".wpr_meta_email_field_req").html(_oks);

        $('#wpr_field_model_'+id+'').modal('hide');
    });

    /**
        Clone new fields model
    **/
    var md_field_click = 0;
    $(document).on('click', '.wpr_select_field', function(event) {
        event.preventDefault();
        
        var field_type      = $(this).data('field-type');
        var clone_new_field = $(".wpr-field-"+ field_type+":last").clone();
        
        // field attr name apply on all fields meta with wpr-meta-field class 
        clone_new_field.find('.wpr-meta-field').each(function(i, meta_field){
            var field_name = 'wpr['+field_no+']['+field_type+']['+$(meta_field).attr('data-metatype')+']';
            $(meta_field).attr('name', field_name);
        });

        // field name attr apply on privacy roles
        clone_new_field.find('.wpr-meta-pr-role').each(function(i, meta_field){
            var field_name = 'wpr['+field_no+']['+field_type+']['+$(meta_field).attr('data-metatype')+'][]';
            $(meta_field).attr('name', field_name);
        });

        // apply model number on icon button
        clone_new_field.find('.wpr_add_icon_btn').each(function(i, meta_field){
            $(meta_field).attr('data-target','#model_no_'+field_no);
        });

        // apply icon model number for popup
        clone_new_field.find('.wpr_icon_model_index').each(function(i, meta_field){
            $(meta_field).attr('id','model_no_'+field_no);
        });        

        var field_model_id = 'wpr_field_model_'+field_no+'';

        clone_new_field.find('.wpr_save_fields_model').end().appendTo('.wpr_save_fields_model').attr('id', field_model_id);
        clone_new_field.find('.wpr-field-checker').attr('data-field-index', field_no);
        clone_new_field.find('.wpr_icon_model_index').find('.close-icon-model').attr('id', field_no);
        clone_new_field.addClass('wpr_sort_id_'+field_no+'');
        var new_ind = field_no;

        // handle multiple options
        clone_new_field.find('.wpr_multi_option_area').attr('data-opt-ex', field_no);
        var add_opt_selector = clone_new_field.find('.wpr-meta-field-opt');  
        wpr_add_option_set_index(add_opt_selector, new_ind, field_type , md_field_click );
        
        // handle icons
        var add_icon_selector = clone_new_field.find('.wpr_icon_handle');
        wpr_add_icons(add_icon_selector, field_no, field_type);
        
        // popup fields on model
        $('#wpr_field_model_'+field_no+'').modal('show');

        field_no++;
    });

    /**
        copy existing saved fields
    **/
    var copy_no = 0;
    $(document).on('click', '.wpr_copy_field', function(e) {
        e.preventDefault();

        var field_type = $(this).data('field-type');
    
        var clone_exist_field = $(".wpr-field-"+field_type+":last")
                    .clone();
        
        clone_exist_field.find('.wpr_save_fields_model').end().appendTo('.wpr_save_fields_model').attr('id','wpr_field_model_'+field_no+'');
        clone_exist_field.find('.wpr-field-checker').attr('data-field-index', field_no);
        clone_exist_field.find('.wpr-close-fields').attr('data-field-index', field_no);
        clone_exist_field.addClass('wpr_sort_id_'+field_no+'');
        clone_exist_field.find('.wpr_icon_model_index').find('.close-icon-model').attr('id', field_no);
        
        // field attr name apply on all fields meta with wpr-meta-field class 
        clone_exist_field.find('.wpr-meta-field').each(function(i, meta_field){
            var field_name = 'wpr['+field_no+']['+field_type+']['+$(meta_field).attr('data-metatype')+']';
            $(meta_field).attr('name', field_name);
        });

        // field attr name apply only privacy roles
        clone_exist_field.find('.wpr-meta-pr-role').each(function(i, meta_field){
            var field_name = 'wpr['+field_no+']['+field_type+']['+$(meta_field).attr('data-metatype')+'][]';
            $(meta_field).attr('name', field_name);
        });

        // getting model button no
        clone_exist_field.find('.wpr_add_icon_btn').each(function(i, meta_field){
            $(meta_field).attr('data-target','#model_no_'+field_no);
        });

        // getting model no to match model button no for popup
        clone_exist_field.find('.wpr_icon_model_index').each(function(i, meta_field){
            $(meta_field).attr('id','model_no_'+field_no);
        });

        // handle multiple options
        clone_exist_field.find('.wpr_multi_option_area').attr('data-opt-ex', field_no);
        var opt_index2 = field_no; 
        var add_opt_selector = clone_exist_field.find('.wpr-meta-field-opt');  
        wpr_add_option_set_index(add_opt_selector, opt_index2, field_type , copy_no );
        
        // handle icons
        var add_icon_selector = clone_exist_field.find('.wpr_icon_handle');
        wpr_add_icons(add_icon_selector, field_no, field_type);

        // popup fields on model
        $('#wpr_field_model_'+field_no+'').modal('show');

        field_no++;
    });

    /**
        create field data name by thier title
    **/
    $(document).on('keyup','[data-meta-id="title"] input[type="text"]', function() {

        var $this = $(this);
        var field_id = $this.val().toLowerCase().replace(/[^A-Za-z\d]/g,'_');
        var selector = $this.closest('.wpr-slider');

        var wp_field = selector.find('table').attr('data-table-id');
        if (wp_field == 'wp_field') {
            return;
        }
        selector.find('[data-meta-id="data_name"] input[type="text"]').val(field_id);
    });

    /**
        sortable fields
    **/
    function insertAt(parent, element, index, dir) {
        var el = parent.children().eq(index);
        
        element[dir == 'top' ? 'insertBefore' : 'insertAfter'](el);
    }
    $(".wpr_field_table tbody").sortable({
        stop: function(evt, ui) {
                
            let parent = $('.wpr_save_fields_model'),
                el = parent.find('.' + ui.item.attr('id')),
                dir = 'top';
            if (ui.offset.top > ui.originalPosition.top) {
                dir = 'bottom';
            }
            insertAt(parent, el, ui.item.index(), dir);
        }
    });
    
    /**
        choose font icon for fields
    **/
    jQuery(document).on('click', '.wpr-admin-icons span', function(e){
        e.preventDefault();

        $('.wpr-icon-add-notice').hide();
        var _icon_closest = jQuery(this).closest('.wpr-slider');
        var icon = jQuery(this).attr('data-code');
        jQuery(this).parent().find('span').removeClass('highlighted');
        jQuery(this).addClass('highlighted');
        _icon_closest.find('button.wpr_attr_add_icon').attr("data-add-icon", icon);
    });

    /**
        append font icon on field
    **/
    $('.wpr-icon-add-notice').hide();
    jQuery(document).on('click', '.wpr_attr_add_icon', function(e){
        e.preventDefault();

        var _icon_closest = jQuery(this).closest('.wpr-slider');
        var icon_selected = jQuery(this).attr('data-add-icon');
        _icon_closest.find('.wpr_admin_icon_clear').show();
        _icon_closest.find('.wpr_icon_append').html('<i class="'+icon_selected+'"></i>');
        _icon_closest.find('.wpr_icon_handle').attr('value', icon_selected);

        if ($('.wpr-admin-icons span').hasClass('highlighted')) {
            var msg = 'Icon Add Successfully';
        }else{
            msg = 'First Select Icon';
        }
        
        $('.wpr-icon-add-notice').html(msg).show();
        setTimeout(function(){ 
            $('.wpr-icon-add-notice').html(msg).hide();
        }, 5000);

    });

    /**
        close icon model
    **/
    $(document).on('click', '.close-icon-model', function(e){
        e.preventDefault();

        var id = $(this).attr('id');
        $('#model_no_'+id+'').modal('toggle');
    });
    $(document).on('hidden.bs.modal', function (event) {
        if ($('.modal:visible').length) {
            $('body').addClass('modal-open');
        }
    });

    /**
        search font icons from fonts list
    **/
    jQuery(document).on('keyup', '.wpr-search-icon-area input[name="_icon_search"]', function(e){
        e.preventDefault();

        var $icon_search = $(this).closest('.wpr-icon-model-scrol');
        // var $icon_val = $icon_search.find('.wpr_icon_find').val().toLowerCase();
        var $icon_val = $(this).val().toLowerCase();
        if ( $icon_val != '' ) {
            $icon_search.find('.wpr-admin-icons span').hide();
            $icon_search.find('.wpr-admin-icons span[data-code*="'+$icon_val+'"]').show();
        } else {
            $icon_search.find('.wpr-admin-icons span:hidden').show();
        }
    });

    /**
        reset fonts icon
    **/
    jQuery(document).on('click', 'span.wpr_admin_icon_clear', function(e){
        e.preventDefault();

        var element = jQuery(this).parents('p');
        jQuery('.wpr_field_icons_wrapper a.um-admin-modal-back').attr('data-code', '');
        element.find('input[type=hidden]').val('');
        element.find('.wpr_icon_append').html('No Icon');
        jQuery(this).hide();
    });

    /**
        handle multiple option
    **/
    $(document).on('click', '.wpr_add_multi_option', function(e){
        e.preventDefault();

        var closest_div  = $(this).closest('.wpr-slider');
        var field_type   = closest_div.find('.modal-body table').attr('data-table-id');
        var controlForm  = $(this).closest('.wpr_multi_option_area');
        var final_ind    = controlForm.data('opt-ex');
        var currentEntry = $('.wpr_copy_field_option:last').clone();

        var opt_no2 = parseInt(closest_div.find('#meta-opt-index').val());
        closest_div.find('#meta-opt-index').val( opt_no2 + 1 ); 
        
        var add_opt_selector = currentEntry.find('.wpr-meta-field-opt');  
        var newEntry = currentEntry.find('.wpr_multi_option_area').end().appendTo(controlForm);
        wpr_add_option_set_index(add_opt_selector, final_ind, field_type , opt_no2 );
        
       newEntry.find('input').val('');
       controlForm.find('.wpr_copy_field_option:not(:last) .wpr_add_multi_option')
           .removeClass('wpr_add_multi_option').addClass('wpr-btn-remove')
           .removeClass('btn-success').addClass('btn-danger')
           .html('<i class="fa fa-minus" aria-hidden="true"></i>');
    }).on('click', '.wpr-btn-remove', function(e){
        $(this).parents('.wpr_copy_field_option:first').remove();
        e.preventDefault();
        return false;
    });

    /**
        data name of fields must be required
    **/
    function wpr_required_data_name($this){
        var selector  = $this.closest('.wpr-slider');
        var data_name = selector.find('[data-meta-id="data_name"] input[type="text"]').val();
        if (data_name == '') {
            var msg = 'Field ID must be required';
            var is_ok = false;    
        }else{
            msg = '';
            is_ok = true;   
        }
        selector.find('.wpr-req-field-id').html(msg);
        return is_ok;
    }

    /**
        handle multiple option index control function
    **/
    function  wpr_add_option_set_index(add_opt_selector, opt_field_no, field_type , opt_no ){
        var field_name = 'wpr['+opt_field_no+']['+field_type+']['+$(add_opt_selector).attr('data-metatype')+']['+opt_no+']';
        $(add_opt_selector).attr('name', field_name);
    }

    /**
        handle fonts icon index control function
    **/
    function  wpr_add_icons(add_icon_selector, field_no, field_type ){
        var field_name = 'wpr['+field_no+']['+field_type+']['+$(add_icon_selector).attr('data-metatype')+']';
        $(add_icon_selector).attr('name', field_name);
    }

    /*********************************
    *        WPR Template JS         *
    **********************************/

    $('.wpr_admin_icon_clear').show();

    /**
        check edit fields yes or no for basic setting
    **/
    if ($('.edit_ok:input[type=radio]:checked')) {
        
        $(".wpr_bs_wrapper, .wpr-pr-setting-wrapper").each(function(index, item) {
            var edit_field = $(item).find('.edit_ok:input[type=radio]:checked');
            if (edit_field && edit_field.val()=='yes') {
                edit_field.parent().addClass('btn-default active');
            }else{
                edit_field.parent().addClass('btn-default active');
            }
        });
    }

    /**
        code editor function for inline css apply on form
    **/
    var editor = CodeMirror.fromTextArea( document.getElementById( 'wpr-css-editor' ), {
        lineNumbers: true,
        lineWrapping: true,
        mode: 'text/css',
        indentUnit: 2,
        tabSize: 2,
        lint: true,
        gutters: [ 'CodeMirror-lint-markers' ]
    });

});