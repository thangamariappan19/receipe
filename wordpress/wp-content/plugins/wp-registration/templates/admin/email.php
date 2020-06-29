<?php
/*
**Setting of email template meta
*/
    // not run if accessed directly
    if( ! defined("ABSPATH" ) )
        die("Not Allewed");
    
    global $post;
    $form_setting = new WPR_Form($post->ID);
?>
<div class="container-fluid wpr-email-wrapper">	
	<div class="row">
		<div class="col-md-6">
			<label><?php _e('Email Header BG Color' , 'wp-registration'); ?></label>
			<span class="wpr-label-color" title="<?php _e('Choose email template header background color','wp-registration','wp-registration'); ?>">
				<i class="dashicons dashicons-editor-help"></i>
			</span>
			<input  name="wpr_email_hd_bg_clr" class="wp-color" value="<?php echo esc_attr($form_setting->get_option('wpr_email_hd_bg_clr')); ?>">
		</div>
		<div class="col-md-6">
			<label><?php _e('Email Body BG Color' , 'wp-registration'); ?></label>
			<span class="wpr-label-color" title="<?php _e('Choose email template body background color','wp-registration'); ?>">
				<i class="dashicons dashicons-editor-help"></i>
			</span>
			<input  name="wpr_email_bofy_bg_clr" class="wp-color" value="<?php echo esc_attr($form_setting->get_option('wpr_email_bofy_bg_clr')); ?>">	
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<label><?php _e('Email Footer BG Color' , 'wp-registration'); ?></label>
			<span class="wpr-label-color" title="<?php _e('Choose email template footer background color','wp-registration'); ?>">
				<i class="dashicons dashicons-editor-help"></i>
			</span>
			<input  name="wpr_email_ft_bg_clr" class="wp-color" value="<?php echo esc_attr($form_setting->get_option('wpr_email_ft_bg_clr')); ?>">
		</div>
		<div class="col-md-6">
			<label><?php _e('Email Fonts Color' , 'wp-registration'); ?></label>
			<span class="wpr-label-color" title="<?php _e('Choose text color for email contents','wp-registration'); ?>">
				<i class="dashicons dashicons-editor-help"></i>
			</span>
			<input  name="wpr_email_font_clr" class="wp-color" value="<?php echo esc_attr($form_setting->get_option('wpr_email_font_clr')); ?>">
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<label><?php _e('Email Font Family/Style' , 'wp-registration'); ?></label>
			<input type="text" name="wpr_email_font_family" class="form-control" value="<?php echo esc_attr($form_setting->get_option('wpr_email_font_family')); ?>">
		</div>
		<div class="col-md-6">
			<p class="wpr-email-p"><?php _e('Font names separated by commas, eg: Verdana,Arial,sans-serif','wp-registration'); ?></p>
		</div>
	</div>
	
	<label><?php _e('Email Template Header' , 'wp-registration'); ?></label>
	<div class="row">
		<div class="col-md-6">
			<textarea name="wpr_email_header" class="form-control wpr-box-length" ><?php echo $form_setting->get_option('wpr_email_header') ?></textarea>
		</div>
		<div class="col-md-6">	
			<p><?php _e('Text that will be displayed in header of email template', 'wp-registration'); ?></p>
		</div>
	</div>
	
	<label><?php _e('New User Email' , 'wp-registration'); ?></label>
	<div class="row">
		<div class="col-md-6">
			<textarea name="wpr_new_user_email" class="form-control wpr-box-length"><?php echo $form_setting->get_option('wpr_new_user_email') ?></textarea>	
		</div>
		<div class="col-md-6">
			<p><?php _e('Provide template for new user. It will be sent to user along with login details. You can use these Vars in message: %USERNAME%, %PASSWORD%, %FIRSTNAME%, %PASSWORD_RESET%, %USER_META%, %LASTTNAME%, %SITE_NAME%, %SITE_URL%, %LOGIN_URL%, %ADMIN_EMAIL%' , 'wp-registration'); ?></p>	
		</div>
	</div>
	
	<label><?php _e('Message Change Password' , 'wp-registration'); ?></label>
	<div class="row">
		<div class="col-md-6">
			<textarea name="wpr_change_password_email" class="form-control wpr-box-length"><?php echo $form_setting->get_option('wpr_change_password_email') ?></textarea>	
		</div>
		<div class="col-md-6">
			<p><?php _e('Send Message on email after change password' , 'wp-registration'); ?></p>
		</div>
	</div>
	<label><?php _e('Email Template Footer' , 'wp-registration'); ?></label>
	<div class="row">
		<div class="col-md-6">
			<textarea name="wpr_email_footer" class="form-control wpr-box-length"><?php echo $form_setting->get_option('wpr_email_footer') ?></textarea>	
		</div>
		<div class="col-md-6">
			<p><?php _e('Text that will be display on footer of email template' , 'wp-registration'); ?></p>
		</div>
	</div>
</div>