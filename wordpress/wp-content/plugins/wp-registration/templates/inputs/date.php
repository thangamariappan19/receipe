<?php
/**
** WPR Template to render date input
**/

    // not run if accessed directly
    if( ! defined("ABSPATH" ) )
        die("Not Allewed");

    $fm = new WPR_InputMeta($field_meta, 'date');
    $class = '';
    $html = '';

    if (!empty($fm->icon)) { 
        $class ="input-group";
        $html .= '<span  class="input-group-addon">';
        $html .= '<i class="'.$fm->icon.'" aria-hidden="true"></i>';
        $html .= '</span>';
      } 
 ?>
    <div class="col-md-<?php echo esc_attr($fm->width) ?> wpr_field_wrapper">
        <label class="wpr-field-title"><?php echo esc_attr($fm->title) ?>
            <span class="wpr_field_icon" data-desc="<?php echo esc_attr($fm->desc) ?>"> *</span>
            <span class="wpr-field-desc"><?php echo esc_attr($fm->desc) ?></span>
        </label>
        <div class="form-group <?php echo $class; ?>">
            <?php echo $html; ?>
            <p 
                class="wpr_field_selector" 
                data-key="<?php echo esc_attr($fm->data_name) ?>" 
                data-type="date" 
            >
                <input 
                    type="text" 
                    name="<?php echo esc_attr($fm->input_name) ?>" 
                    id="<?php echo esc_attr($fm->data_name) ?>" 
                    class="<?php echo esc_attr($fm->classes_fm);?>" 
                    placeholder="<?php echo esc_attr($fm->placeholder) ?>" 
                    data-req="<?php echo esc_attr($fm->required) ?>" 
                    data-message="<?php echo esc_attr($fm->error_msg) ?>" 
                    data-format="<?php echo esc_attr($fm->format) ?>" 
                    data-yearRange="<?php echo esc_attr($fm->year_range) ?>"
                    value="<?php echo esc_attr($fm->value);?>"
                >  
            </p>
        </div>
        <span class="wpr_field_error"></span>
    </div>
   
<script>
    jQuery(document).ready(function($) {

        var date_format  = $('#<?php echo $fm->data_name; ?>').attr('data-format');
        var date_range  = $('#<?php echo $fm->data_name; ?>').attr('data-yearRange');
    
        if( "<?php echo $fm->default_value?>" === '' ) {
            var default_date = new Date();
        } else {
            var default_date = new Date("<?php echo $fm->default_value?>");
            // setting deftault date
            $('#<?php echo $fm->data_name; ?>').val($.datepicker.formatDate(date_format, default_date));
        }
        
        var date = new Date();
        $('#<?php echo $fm->data_name; ?>').datepicker({
            dateFormat : date_format,
            changeMonth: true,
            changeYear: true,
            defaultDate: default_date,
            yearRange: date_range
        });
    });
</script>