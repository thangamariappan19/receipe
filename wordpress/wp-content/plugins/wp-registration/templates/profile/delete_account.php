<?php 
/*
** Delete the user acoount
*/
	// not run if accessed directly
    if( ! defined("ABSPATH" ) )
    	die("Not Allewed");

?>
<div class="wpr-tab-pane tab-pane fade in" id="delete_account" style="height: 212px;">
    <div class="wpr_wrapper">
    	<input type="hidden" id="wpr_delete_account" name="wpr_delete_account" value="<?php echo $profile->user->id; ?>" >
        <div class="wpr-delete-sign">
            <h4><?php _e('Warning!','wp-registration'); ?></h4>
            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
        </div>
        <div>
            <div class="text-center">
                <p class="wpr-conform-text">
                    <?php _e('Are you sure, it will delete all of data from this site?' , 'wp-registration'); ?>
                </p>
            </div>
        </div>
        <div class="wpr-delete-btn">
            <a type="button" class="btn btn-danger wpr_user_delete_account"> <?php _e('Delete', 'wp-registration'); ?></a>
        </div>
    </div>
</div>