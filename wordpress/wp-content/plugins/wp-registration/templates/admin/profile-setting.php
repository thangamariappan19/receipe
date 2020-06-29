<?php
/*
**Setting of profile design meta
*/

	// not run if accessed directly
    if( ! defined("ABSPATH" ) )
    	die("Not Allewed");

    global $post;

    $form_setting 	= new WPR_Form($post->ID);
    $profile 		= WPRPROFILE();
    $label_size   	= wpr_design_label_size();
    $profile_layout = $profile->profile_photo_layout();

    $lable_val 		= $form_setting->get_option('wpr_pr_label_size');
    $photo_adjust  	= $form_setting->get_option('wpr_pr_photo_layout');

    
    $allow_banner 	= $form_setting->get_option('wpr_allow_banner') != false ? $form_setting->get_option('wpr_allow_banner') : 'no';

    $allow_password = $form_setting->get_option('wpr_allow_pass') != false? $form_setting->get_option('wpr_allow_pass') :
    	'no';
    
?>
<div class="wrap wpr-pr-setting-wrapper">
	<label><?php _e('Show Banner & Profile Photo' , 'wp-registration'); ?>
		<span class="wpr-label-color" title="<?php _e('Allow user to show the banner or profile photo area.','wp-registration'); ?>">
			<i class="dashicons dashicons-editor-help"></i>
		</span>
	</label>
	<br>
	<div class="btn-group wpr-pr-switch" data-toggle="buttons">
		<label class="btn btn-default btn-on btn-sm">
			<input type="radio" value="yes" name="wpr_allow_banner" class="edit_ok"
			<?php checked( $allow_banner , 'yes'); ?>><?php _e('Yes' , 'wp-registration'); ?>
		</label>
		<label class="btn btn-default btn-off btn-sm">
			<input type="radio" value="no" name="wpr_allow_banner" class="edit_ok"
			<?php checked( $allow_banner , 'no'); ?>><?php _e('No' , 'wp-registration'); ?>
		</label>
    </div>

    <label><?php _e('Allow User To Change Password' , 'wp-registration'); ?>
		<span class="wpr-label-color" title="<?php _e('Allow user to change password.','wp-registration'); ?>">
			<i class="dashicons dashicons-editor-help"></i>
		</span>
	</label>
	<br>
	<div class="btn-group wpr-pr-switch" data-toggle="buttons">
		<label class="btn btn-default btn-on btn-sm">
			<input type="radio" value="yes" name="wpr_allow_pass" class="edit_ok"
			<?php checked( $allow_password , 'yes'); ?>><?php _e('Yes' , 'wp-registration'); ?>
		</label>
		<label class="btn btn-default btn-off btn-sm">
			<input type="radio" value="no" name="wpr_allow_pass" class="edit_ok"
			<?php checked( $allow_password , 'no'); ?>><?php _e('No' , 'wp-registration'); ?>
		</label>
    </div>
<br>
	<label><?php _e('Top Banner Color' , 'wp-registration'); ?></label>
	<span class="wpr-label-color" title="<?php _e('If user not upload cover photo, select the color to show on cover photo area.','wp-registration'); ?>">
		<i class="dashicons dashicons-editor-help"></i>
	</span>
	<input  name="wpr_pr_bnr_clr" class="wp-color" value="<?php echo esc_attr($form_setting->get_option('wpr_profile_bnr_clr')); ?>">

	<label><?php _e('Menu BG Color' , 'wp-registration'); ?></label>
	<span class="wpr-label-color" title="<?php _e('Select profile menu background color.','wp-registration'); ?>">
		<i class="dashicons dashicons-editor-help"></i>
	</span>
	<input  name="wpr_tab_bg_clr" class="wp-color" value="<?php echo esc_attr($form_setting->get_option('wpr_menu_bg_clr')); ?>">

	<label><?php _e('Menu Label Color' , 'wp-registration'); ?></label>
	<span class="wpr-label-color" title="<?php _e('Select profile menu label color.','wp-registration'); ?>">
		<i class="dashicons dashicons-editor-help"></i>
	</span>
	<input  name="wpr_pr_label_clr" class="wp-color" value="<?php echo esc_attr($form_setting->get_option('wpr_pr_label_clr')); ?>">

	<label><?php _e('Label Size' , 'wp-registration'); ?></label>
	<span class="wpr-label-color" title="<?php _e('Select the profile menu label font size.','wp-registration'); ?>">
		<i class="dashicons dashicons-editor-help"></i>
	</span>
	<select class="wpr-select" name="wpr_pr_label_size">
		<?php 
			foreach ($label_size as $size => $val) {
		?>
			<option value="<?php echo esc_attr($size); ?>" <?php selected( $lable_val, $size) ?> ><?php echo $val; ?></option>
		<?php 
			}
	 	?>
	</select>

	<label><?php _e('Photo Layout' , 'wp-registration'); ?></label>
	<span class="wpr-label-color" title="<?php _e('Select user profile photo layout, cicle and square.','wp-registration'); ?>">
		<i class="dashicons dashicons-editor-help"></i>
	</span>
	<select class="wpr-select" name="wpr_pr_photo_layout">
		<?php 
			foreach ($profile_layout as $layout => $val) {
		?>
			<option value="<?php echo esc_attr($layout); ?>" <?php selected( $photo_adjust, $layout) ?> ><?php echo $val; ?></option>
		<?php 
			}
	 	?>
	</select>

	<label><?php _e('Cover Photo Width' , 'wp-registration'); ?></label>
	<span class="wpr-label-color" title="<?php _e('Enter the cover photo width.','wp-registration'); ?>">
		<i class="dashicons dashicons-editor-help"></i>
	</span>
	<input type="text" name="wpr_cover_photo_width" value="<?php echo esc_attr($form_setting->get_option('wpr_cover_photo_width')); ?>" placeholder="<?php _e('e.g,800','wp-registration'); ?>" class="form-control">

	<label><?php _e('Cover Photo Height' , 'wp-registration'); ?></label>
	<span class="wpr-label-color" title="<?php _e('Enter the cover photo height.','wp-registration'); ?>">
		<i class="dashicons dashicons-editor-help"></i>
	</span>
	<input type="text" name="wpr_cover_photo_height" value="<?php echo esc_attr($form_setting->get_option('wpr_cover_photo_height')); ?>" placeholder="<?php _e('e.g,175','wp-registration'); ?>" class="form-control">

	<label><?php _e('Profile Photo Width' , 'wp-registration'); ?></label>
	<span class="wpr-label-color" title="<?php _e('Enter the profile photo width.','wp-registration'); ?>">
		<i class="dashicons dashicons-editor-help"></i>
	</span>
	<input type="text" name="wpr_profile_photo_width" value="<?php echo esc_attr($form_setting->get_option('wpr_profile_photo_width')); ?>" placeholder="<?php _e('e.g,200','wp-registration'); ?>" class="form-control">
	
	<label><?php _e('Profile Photo Height' , 'wp-registration'); ?></label>
	<span class="wpr-label-color" title="<?php _e('Enter the profile photo height.','wp-registration'); ?>">
		<i class="dashicons dashicons-editor-help"></i>
	</span>
	<input type="text" name="wpr_profile_photo_height" value="<?php echo esc_attr($form_setting->get_option('wpr_profile_photo_height')); ?>" placeholder="<?php _e('e.g,70','wp-registration'); ?>" class="form-control">
</div>