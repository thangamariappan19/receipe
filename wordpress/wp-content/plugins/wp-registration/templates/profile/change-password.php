<?php 
/*
** Template the change password in profile
*/

	// not run if accessed directly
    if( ! defined("ABSPATH" ) )
    	die("Not Allewed");

 ?>
<div class="wpr-tab-pane tab-pane fade in" id="password_change_tab">

 	<div class="wpr-pr-pass-wrapper">
	    <div class="wpr-header">
	        <h2 class="wpr-tab-heading"><?php _e('Change Password' , 'wp-registration'); ?></h2>
	    </div>
	    <div class="modal-body wpr-body">
		   	<div id="div-change-password">
			<input type="hidden" id="wpr_change_pass_nonce" name="wpr_change_pass_nonce" value="<?php echo wp_create_nonce( 'wpr_change_user_password' ) ?>" >
				<div class="form-group wpr-form-group">
					<label for="old_password"><?php _e('Current password', 'wp-registration') ?></label>
                    <div class="wpr-login-inputs">
                        <span><i class="fa fa-key" aria-hidden="true"></i></span>
                            <input type="password" name="old_password" id="old_password" value="" size="20" placeholder="<?php _e('Enter Current Password','wp-registration'); ?>" class="input">
                    </div>
               </div>
               <div class="form-group wpr-form-group">
					<label for="new_password"><?php _e('New password', 'wp-registration') ?></label>
                    <div class="wpr-login-inputs">
                        <span><i class="fa fa-key" aria-hidden="true"></i></span>
                            <input type="password" name="new_password" id="new_password" value="" size="20" placeholder="<?php _e('Enter New Password','wp-registration'); ?>" class="input">
                    </div>
               </div>
               <div class="form-group wpr-form-group">
					<label for="re_new_password"><?php _e('Re Enter New password', 'wp-registration') ?></label>
                    <div class="wpr-login-inputs">
                        <span><i class="fa fa-key" aria-hidden="true"></i></span>
                            <input type="password" name="re_new_password" id="re_new_password" value="" size="20" placeholder="<?php _e('Re Enter Current Password','wp-registration'); ?>" class="input">
                    </div>
               </div>
				<br/>
			</div>
		</div>
	    <div class="modal-footer wpr-footer">
	    	<span>
				<input type="button" value="Change password?" class="btn-success wpr-change-pass btn" style="float: right;">
				<span id="wpr-doing-change" class="wpr-pass-alert"></span>
	    	</span>
	    </div>
	</div>
</div>