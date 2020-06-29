<?php
/**
** Core Password Reset Template
**/

    // not run if accessed directly
    if( ! defined("ABSPATH" ) )
        die("Not Allewed");

    $error_types = array('invalidcombo', 'empty_username');
    
?>
<div class="modal-dialog wpr-pass-reset-wrapper">
    <?php 
        wpr_show_errors( $error_types );
     ?>
    <div class="modal-content">
        <div class="modal-heading">
            <h2 class="text-center"><?php _e('Password Reset' , 'wp-registration'); ?></h2>
        </div>
        <hr />
        <div class="modal-body">
            <form name="lostpasswordform" id="lostpasswordform" action="<?php echo esc_url(wp_lostpassword_url()); ?>" method="post">
                <div class="row wpr-pass-reset-area">
                    <div class="col-md-10 col-sm-12 col-md-offset-1">
                        <div class="form-group">
                            <div class="wpr-login-inputs">
                                <span><i class="fa fa-key" aria-hidden="true"></i></span>
                                <input type="text" name="user_login" id="user_login" value="" size="20" placeholder="<?php _e('Username or Email Address','wp-registration'); ?>">
                            </div>
                        </div>
                        <input type="hidden" name="redirect_to" value="">
                        <div class="form-group">
                            <input type="submit" name="wp-submit" id="wp-submit" class="btn btn-lg"
                             value="Get New Password">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>