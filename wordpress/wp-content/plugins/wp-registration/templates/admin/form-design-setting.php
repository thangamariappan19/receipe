<?php
/*
**Setting of registration form design meta
*/
	// not run if accessed directly
    if( ! defined("ABSPATH" ) )
    	die("Not Allewed");

    global $post;

    $form_setting = new WPR_Form($post->ID);
    $label_size   = wpr_design_label_size();
    $lable_val = $form_setting->get_option('wpr_label_size');
?>
<div class="wrap wpr-fm-design-wrapper">
	
	<label><?php _e('Button Label Color' , 'wp-registration'); ?></label>
	<span class="wpr-label-color" title="<?php _e('Change the button text color','wp-registration'); ?>">
		<i class="dashicons dashicons-editor-help"></i>
	</span>
	<input  name="wpr_btn_label_clr" class="wp-color" value="<?php echo esc_attr($form_setting->get_option('wpr_btn_label_clr')); ?>">

	<label><?php _e('Button BG color' , 'wp-registration'); ?></label>
	<span class="wpr-label-color" title="<?php _e('Change the button background color','wp-registration'); ?>">
		<i class="dashicons dashicons-editor-help"></i>
	</span>
	<input  name="wpr_btn_bg_clr" class="wp-color" value="<?php echo esc_attr($form_setting->get_option('wpr_btn_bg_clr')); ?>">

	<label><?php _e('Form Header BG color' , 'wp-registration'); ?></label>
	<span class="wpr-label-color" title="<?php _e('Change the form header color','wp-registration'); ?>">
		<i class="dashicons dashicons-editor-help"></i>
	</span>
	<input  name="wpr_form_header_color" class="wp-color" value="<?php echo esc_attr($form_setting->get_option('wpr_form_header_color')); ?>">

	<label><?php _e('Form BG color' , 'wp-registration'); ?></label>
	<span class="wpr-label-color" title="<?php _e('Change the Registration form background color','wp-registration'); ?>">
		<i class="dashicons dashicons-editor-help"></i>
	</span>
	<input  name="wpr_form_bg_clr" class="wp-color" value="<?php echo esc_attr($form_setting->get_option('wpr_form_bg_clr')); ?>">

	<label><?php _e('Icon Color' , 'wp-registration'); ?></label>
	<span class="wpr-label-color" title="<?php _e('Change the Icon color','wp-registration'); ?>">
		<i class="dashicons dashicons-editor-help"></i>
	</span>
	<input  name="wpr_icon_color" class="wp-color" value="<?php echo esc_attr($form_setting->get_option('wpr_icon_color')); ?>">


	<label><?php _e('Form Width' , 'wp-registration'); ?></label>
	<span class="wpr-label-color" title="<?php _e('Change the width of form model in %','wp-registration'); ?>">
		<i class="dashicons dashicons-editor-help"></i>
	</span>
	<input type="text" name="wpr_form_width" value="<?php echo esc_attr($form_setting->get_option('wpr_form_width')); ?>" placeholder="<?php _e('e.g,50%','wp-registration'); ?>" class="form-control">

	<label><?php _e('Label Size' , 'wp-registration'); ?></label>
	<span class="wpr-label-color" title="<?php _e('Select the button font size','wp-registration'); ?>">
		<i class="dashicons dashicons-editor-help"></i>
	</span>
	<select class="wpr-select" name="wpr_label_size">
		<?php 
			foreach ($label_size as $size => $val) {
		?>
			<option value="<?php echo esc_attr($size); ?>" <?php selected( $lable_val, $size) ?> ><?php echo $val; ?></option>
		<?php 
			}
	 	?>
	</select>

	<label><?php _e('Button Class' , 'wp-registration'); ?></label>
	<span class="wpr-label-color" title="<?php _e('If you need add more styles you can add class to signup button','wp-registration'); ?>">
		<i class="dashicons dashicons-editor-help"></i>
	</span>
	<input type="text" name="wpr_btn_cls" class="form-control" value="<?php echo esc_attr($form_setting->get_option('wpr_btn_cls')); ?>">

	<label><?php _e('Form CSS' , 'wp-registration'); ?></label>	
	<span class="wpr-label-color" title="<?php _e('Enter custom CSS','wp-registration'); ?>">
		<i class="dashicons dashicons-editor-help"></i>
	</span>
	<textarea id="wpr-css-editor" name="wpr_form_css" class="form-control" style="min-height: 185px"><?php echo $form_setting->get_option('wpr_form_css') ?></textarea>
</div>