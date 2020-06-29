<?php
/**
** WPR Template to render radio input
**/

    // not run if accessed directly
    if( ! defined("ABSPATH" ) )
        die("Not Allewed");

    $fm = new WPR_InputMeta($field_meta, 'radio');
    $value = sanitize_key($fm->value);
    
   
 ?>
    <div class="col-md-<?php echo esc_attr($fm->width) ?> wpr_field_wrapper">
        <div class="form-group input-group wpr-field-header">
            <label class="wpr-field-title">
            <?php echo $fm->title; ?>
                <span class="wpr_field_icon" data-desc="<?php echo esc_attr($fm->desc) ?>"> *</span>
                <span class="wpr-field-desc"><?php echo $fm->desc; ?></span>
            </label>
        </div>
        <div class="wpr-field-body">
            <p 
                class="wpr_field_selector" 
                data-key="<?php echo esc_attr($fm->data_name) ?>" 
                data-type="radio" 
            >
                <?php
                    foreach ($fm->options as $option) {
                        $key = $option['key'];
                        $label = $option['label'];
                        $opt_id = $option['option_id'];
                ?>  
                <label for="<?php echo esc_attr($opt_id);?>" class="wpr-radio-check wpr-checkmarks-style">
                    <input 
                         style = "opacity: 0;"
                        type="radio" 
                        name="<?php echo esc_attr($fm->input_name) ?>" 
                        id="<?php echo esc_attr($opt_id);?>" 
                        class="<?php echo esc_attr($fm->input_classes);?>" 
                        data-req="<?php echo esc_attr($fm->required) ?>" 
                        data-message="<?php echo esc_attr($fm->error_msg) ?>"
                        value="<?php echo esc_attr($key) ?>" 
                        <?php checked( $key, $value); ?>
                    >
                    <span class="wpr-checkmark-span" style="border-radius: 12px;"></span>
                    <?php echo $label ?>
                </label>

                <?php
                    }
                ?>
            </p>
        </div>
        <span class="wpr_field_error"></span>
    </div>