<?php 
/**
** Core Login Template
**/

	// not run if accessed directly
    if( ! defined("ABSPATH" ) )
    	die("Not Allewed");

	$error_types = array('invalid_login');

	wpr_get_nav_menus_items();

	$form_id  = WPR_Settings()->get_option('social_form_id');
	$form 	  = new WPR_Form($form_id);

?>

	<!-- Modal -->
<div class="modal-dialog wpr-login-wrapper">
<?php 
	wpr_show_errors( $error_types );
?>
	<div class="modal-content">
		<div class="modal-heading">
			<h2 class="text-center"><?php _e('Login' , 'wp-registration'); ?></h2>
		</div>
		<hr />
		<?php do_action('wpr_after_form_start', $form); ?>
		<div class="modal-body">
			<form id="wpr-login-form" action="<?php echo esc_url(wp_login_url()); ?>" method="post">
				<input type="hidden" name="action" value="wpfm_login">
				<div class="row">
					<div class="col-md-10 col-md-offset-1">
						<div class="form-group">
							<div class="wpr-login-inputs">
								<span><i class="fa fa-user" aria-hidden="true"></i></span>
								<input type="text" name="log" placeholder="<?php _e('Username or Email','wp-registration'); ?>" required/>
							</div>
						</div>
					</div>	
				</div>
				<div class="row wpr-login-pass-area">
					<div class="col-md-10 col-md-offset-1">
						<div class="form-group">
							<div class="wpr-login-inputs">
								<span><i class="fa fa-key" aria-hidden="true"></i></span>
								<input type="password" name="pwd" placeholder="<?php _e('Password','wp-registration'); ?>" required/>
							</div>
						</div>
						<div class="wpr-login-rememberme">
					    	<label for="rememberme">
					    		<input name="rememberme" type="checkbox" id="rememberme" value="forever">
					    		 <?php _e('Remember me' , 'wp-registration'); ?>
					    	</label>
					  	</div>
						<div class="form-group">
							<input type="submit" class="btn btn-lg" value="Login">
						</div>
					  	<?php do_action('wpr_before_form_end', $form); ?>
					</div>
				<?php
					
				
				if( $wpr_reset_password_url = WPRLOGIN()->wpr_get_core_page_for_redirect('password_reset') ):
				?>
					<div class="wpr-login-forgetpass">
						<a href="<?php echo esc_url($wpr_reset_password_url);?>" class="btn btn-link"><?php _e('Forget Password?' , 'wp-registration'); ?></a>
					</div>
				<?php endif;?>
				</div>

				<?php
				
				if( $wpr_register_url = WPRLOGIN()->wpr_get_core_page_for_redirect('register') ):
				?>
	                <div class="form-group">
	                    <div class="wpr-signup-user">
	                        <p><?php _e("Don't have an account!" , "wp-registration"); ?></p>
	                        <a href="<?php echo esc_url($wpr_register_url);?>">
	                        	<input type="button" class="btn" value="Sign Up"></input>
	                        </a>
	                    </div>
	                </div>
                <?php endif;?>
			</form>
		</div>
	</div>
</div>