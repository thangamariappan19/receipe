<?php
/**
** WPR Template to render number input
**/

    // not run if accessed directly
    if( ! defined("ABSPATH" ) )
        die("Not Allewed");

    $fm = new WPR_InputMeta($field_meta, 'number');
    $class = '';
    $html = '';

    if (!empty($fm->icon)) { 
        $class ="input-group";
        $html .= '<span  class="input-group-addon">';
        $html .= '<i class="'.$fm->icon.'"  aria-hidden="true"></i>';
        $html .= '</span>';
      } 
    
 ?>
    <div class="col-md-<?php echo esc_attr($fm->width) ?> wpr_field_wrapper">
        <label class="wpr-field-title"><?php echo $fm->title; ?>
            <span class="wpr_field_icon" data-desc="<?php echo esc_attr($fm->desc) ?>"> *</span>
            <span class="wpr-field-desc"><?php echo $fm->desc; ?></span>
        </label>
         <div class="form-group <?php echo $class; ?>">
            <?php echo $html; ?>
            <p 
                class="wpr_field_selector" 
                data-key="<?php echo esc_attr($fm->data_name) ?>" 
                data-type="text" 
            >
                <input 
                    type="number" 
                    name="<?php echo esc_attr($fm->input_name) ?>" 
                    id="<?php echo esc_attr($fm->data_name) ?>" 
                    class="<?php echo esc_attr($fm->classes_fm);?>" 
                    placeholder="<?php echo esc_attr($fm->placeholder) ?>" 
                    data-req="<?php echo esc_attr($fm->required) ?>" 
                    data-message="<?php echo esc_attr($fm->error_msg) ?>" 
                    max="<?php echo esc_attr($fm->max_values) ?>" 
                    min="<?php echo esc_attr($fm->min_values) ?>" 
                    step="<?php echo esc_attr($fm->steps) ?>"
                    value="<?php echo esc_attr($fm->value);?>"
                >  
            </p>
        </div>
        <span class="wpr_field_error"></span>
    </div>