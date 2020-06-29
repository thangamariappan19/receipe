<?php
/*
**Setting of GDPR settings meta
*/
    // not run if accessed directly
    if( ! defined("ABSPATH" ) )
        die("Not Allewed");
    
    global $post;
    $form_setting = new WPR_Form($post->ID);

    $enable_consent =$form_setting->get_option('wpr_consent') != false ? $form_setting->get_option('wpr_consent') : 'no';

    $delete_account = $form_setting->get_option('wpr_delete_account') != false ? $form_setting->get_option('wpr_delete_account') : 'no';

?>
<div class="container-fluid wpr-wrap wpr_bs_wrapper">
	<div class="row">
		<div class="col-md-6">
			<label><?php _e(' Enable consent' , 'wp-registration'); ?>
				<span class="wpr-label-color" title="<?php _e('Allow to user enable consent on registration page.','wp-registration'); ?>">
					<i class="dashicons dashicons-editor-help"></i>
				</span>
			</label>
		</div>
		<div class="col-md-6">
			<div class="btn-group wpr-switch" data-toggle="buttons">
				<label class="btn btn-default btn-on btn-sm">
					<input type="radio" value="yes" name="wpr_consent" class="edit_ok" <?php checked( $enable_consent , 'yes'); ?> > <?php _e('Yes' , 'wp-registration'); ?>
				</label>
				<label class="btn btn-default btn-off col-md-6 btn-sm">
					<input type="radio" value="no" name="wpr_consent" class="edit_ok" <?php checked( $enable_consent , 'no'); ?> > <?php _e('NO' , 'wp-registration'); ?>
				</label>
		    </div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<label><?php _e('Delete Account' , 'wp-registration'); ?>
				<span class="wpr-label-color" title="<?php _e('Allow users to delete their user account.','wp-registration'); ?>">
					<i class="dashicons dashicons-editor-help"></i>
				</span>
			</label>
		</div>
		<div class="col-md-6">
			<div class="btn-group wpr-switch" data-toggle="buttons">
				<label class="btn btn-default btn-on btn-sm">
					<input type="radio" value="yes" name="wpr_delete_account" class="edit_ok" <?php checked( $delete_account , 'yes'); ?> > <?php _e('Yes' , 'wp-registration'); ?>
				</label>
				<label class="btn btn-default btn-off col-md-6 btn-sm">
					<input type="radio" value="no" name="wpr_delete_account" class="edit_ok" <?php checked( $delete_account , 'no'); ?> > <?php _e('NO' , 'wp-registration'); ?>
				</label>
		    </div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<label>
			    <?php _e('Text for user consent' , 'wp-registration'); ?>
				<span class="wpr-label-color" title="<?php _e('Enter the text for consent.','wp-registration'); ?>">
					<i class="dashicons dashicons-editor-help"></i>
				</span>
			</label>
		</div>
		<div class="col-md-6" style="margin-top: 10px;">
			<input type="text" name="wpr_consent_msg" class="form-control" value="<?php echo esc_attr($form_setting->get_option('wpr_consent_msg')); ?>" >
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
	    	<label>
	    		<?php _e('URL to user consent' , 'wp-registration'); ?>
				<span class="wpr-label-color" title="<?php _e('Enter the url for consent.','wp-registration'); ?>">
					<i class="dashicons dashicons-editor-help"></i>
				</span>
			</label>
		</div>
		<div class="col-md-6" style="margin-top: 10px;">
			<input type="url" name="wpr_consent_url" class="form-control" value="<?php echo esc_attr($form_setting->get_option('wpr_consent_url')); ?>" >
		</div>
	</div>
</div>