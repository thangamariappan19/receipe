<?php
/**
** WPR Template to render masked input
**/

    // not run if accessed directly
    if( ! defined("ABSPATH" ) )
        die("Not Allewed");
    
    $class ='';
    $html = '';
    $fm = new WPR_InputMeta($field_meta, 'masked');
    if (!empty($fm->icon)) { 
        $class ="input-group";
        $html .= '<span  class="input-group-addon">';
        $html .= '<i class="'.$fm->icon.'" aria-hidden="true"></i>';
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
                data-type="masked" 
            >
                <input 
                    type="text" 
                    name="<?php echo esc_attr($fm->input_name) ?>" 
                    id="<?php echo esc_attr($fm->data_name) ?>" 
                    class="<?php echo esc_attr($fm->classes_fm);?>" 
                    placeholder="<?php echo esc_attr($fm->placeholder) ?>" 
                    data-req="<?php echo esc_attr($fm->required) ?>" 
                    data-message="<?php echo esc_attr($fm->error_msg) ?>" 
                    data-ismask="no" 
                    data-mask="<?php echo esc_attr($fm->input_mask) ?>"
                    value="<?php echo esc_attr($fm->value);?>"
                >  
            </p>
        </div>
        <span class="wpr_field_error"></span>
    </div>
  
<script type="text/javascript"> 
    jQuery(document).ready(function($) {

        $("#<?php echo $fm->data_name;?>").mask("<?php echo $fm->input_mask;?>",{ completed:function(cep){
            this.attr('data-ismask', 'yes');
            }
        });
    });
</script>