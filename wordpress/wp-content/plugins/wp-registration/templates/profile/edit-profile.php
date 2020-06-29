<?php 
/*
** Template the edit profile of user information
*/
	// not run if accessed directly
    if( ! defined("ABSPATH" ) )
    	die("Not Allewed");

 ?>
<div class="wpr-tab-pane tab-pane fade in" id="edit_profile_tab">
	<div class="wpr_model_selector">
	<form id="wpr-form-<?php echo esc_attr($profile->form->form_id)?>" class="wpr-forms">
		<input type="hidden" name="action" value="profile_save_field">
		<input type="hidden" name="wpr_form_id" value="<?php echo esc_attr($profile->form->form_id)?>">

		<?php wp_nonce_field( 'wpr_profile_updating', 'wpr_nonce' ) ?>

		<input type="hidden" name="current_user" value="<?php echo $profile->user->id; ?>">

	    <div class=" wpr-pr-header">
	  		<h2 class="wpr-tab-heading"><?php _e('Edit Profile' , 'wp-registration'); ?></h2>
	  	</div>
	    <div class="modal-body wpr-pr-body">
	    	<div class="row">
				<?php 
				    echo $profile->render_profile_fields();
				 ?>
		 	</div>
		</div>
		<div class="wpr-footer row">
			<div class="col-md-12 col-sm-12 wpr-pr-btn">
			<span class="wpr-pr-spinner-wrapper">
	        	<input type="submit" class="btn btn-success" value="Save">
	        	<span class="wpr-spinner" style="float: right;"></span>
	        	<span class="error wpr_alert" style="float: right;"></span>
			</span>
			</div>
	    </div>
	</form>
	</div>
</div>