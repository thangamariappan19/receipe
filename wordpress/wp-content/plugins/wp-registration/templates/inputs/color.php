<?php
/**
** WPR Template to render color input
**/

    // not run if accessed directly
    if( ! defined("ABSPATH" ) )
        die("Not Allewed");

    $fm = new WPR_InputMeta($field_meta, 'color');
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
        <label class="wpr-field-title"><?php echo $fm->title; ?>
            <span class="wpr_field_icon" data-desc="<?php echo esc_attr($fm->desc) ?>"> *</span>
            <span class="wpr-field-desc"><?php echo $fm->desc; ?></span>
        </label>
        <div class="form-group <?php echo $class; ?>">
            <?php echo $html; ?>
            <p 
                class="wpr_field_selector" 
                data-key="<?php echo esc_attr($fm->data_name) ?>" 
                data-type="color"
            >
                <input 
                    type="text" 
                    name="<?php echo esc_attr($fm->input_name) ?>" 
                    id="<?php echo esc_attr($fm->data_name) ?>" 
                    class="<?php echo esc_attr($fm->classes_fm);?>" 
                    placeholder="<?php echo esc_attr($fm->placeholder) ?>" 
                    data-req="<?php echo esc_attr($fm->required) ?>" 
                    data-message="<?php echo esc_attr($fm->error_msg) ?>"
                    value="<?php echo esc_attr($fm->value);?>"
                >
            </p>
        </div>
        <span class="wpr_field_error"></span>
    </div>

<?php 
    $palletes = ($fm->show_palletes == '') ? 'off' : $fm->show_palletes;
    $show = ($fm->show_color == '') ? 'off' : $fm->show_color;
?>
<script>
     
    jQuery(document).ready(function($){

        var palette = '<?php echo $palletes;?>' == 'on' ? true : false;
        var hide = '<?php echo $show;?>' == 'on' ? false : true;
        
        var options = {
                palettes: palette,
                color: "<?php echo $fm->default_value; ?>",
                hide: hide,
                change: function(event,ui){
                    $("#box-<?php echo $fm->data_name;?>").css( 'color', ui.color.toString());
                }
        };
    
        $("#<?php echo $fm->data_name;?>").iris(options);
    });
</script>