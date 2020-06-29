<?php
/*
**Setting of general form meta
*/

    // not run if accessed directly
    if( ! defined("ABSPATH" ) )
        die("Not Allewed");
    
    global $post;
    $form_setting = new WPR_Form($post->ID);
    
?>
<div class="container-fluid wpr-wrap wpr_bs_wrapper">
	<label><?php _e('Form Heading:' , 'wp-registration'); ?>
		<span class="wpr-label-color" title="<?php _e('Enter form heading text.','wp-registration'); ?>">
			<i class="dashicons dashicons-editor-help"></i>
		</span>
	</label>
	<input type="text" name="wpr_form_heading" class="form-control wpr-bs-setting" 
		value="<?php echo esc_attr($form_setting->get_option('wpr_form_heading')); ?>">

	<label><?php _e('Button Label' , 'wp-registration'); ?>
		<span class="wpr-label-color" title="<?php _e('Change the submit form button text.','wp-registration'); ?>">
			<i class="dashicons dashicons-editor-help"></i>
		</span>
	</label>
	<input type="text" name="wpr_button_label" class="form-control wpr-bs-setting" 
		value="<?php echo esc_attr($form_setting->get_option('wpr_button_label')); ?>">

	<label><?php _e('Message On Registration' , 'wp-registration'); ?>
		<span class="wpr-label-color" title="<?php _e('It will be shown to user after successful registration.','wp-registration'); ?>">
			<i class="dashicons dashicons-editor-help"></i>
		</span>
	</label>
	<textarea name="wpr_msg_on_reg" class="form-control wpr-bs-setting" style="min-height: 100px;"><?php echo $form_setting->get_option('wpr_msg_on_reg') ?></textarea>

    <?php do_action('wpr_general_settings_options' , $form_setting); ?> 
</div>