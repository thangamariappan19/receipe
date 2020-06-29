<?php 
/*
** Main Template Home Page
*/

	// not run if accessed directly
    if( ! defined("ABSPATH" ) )
    	die("Not Allewed");

    $tab_control     = $profile->profile_tabs();
    $template_vars   = array();
    $template_vars   = array('profile' => $profile);
   
?>
<div class="wpr-profile-wrapper container">
		<div class="wpr-profile-header">
			<?php 
				if ($profile->enable_photo_area == 'yes') {
			?>
				
	        <div class="wpr-pr-panel panel-default wpr-pr-mr">
	        	<?php 
        		 	$user_id = $profile->user->id;
        		 	$img_url = wpr_upload_dir_url($user_id);

        		 	$profile_photo = wpr_files_setup_get_directory($user_id).'wpr_profile_photo.png';
        		 	$cover_photo   = wpr_files_setup_get_directory($user_id).'wpr_cover_photo.png';
        		 	$first_letter =  ucfirst(substr($profile->user->first_name, 0, 1));

        		 	if (file_exists($cover_photo)) {
				    	$profile->banner_clr = '#fffff';
					}
        		 	if (file_exists($profile_photo)) {				
					    	$profile_style = 'background-color: transparent ; height: unset';

					    	$html = '';
				            $html .= '<img class="image img-responsive '.esc_attr($profile->img_layout).'" src=" '. $img_url.'wpr_profile_photo.png">';

                           
        			}else {
		                $html = '';
    					$profile_style = 'background-color: #dde4e4f2';
		                $html .= '<span class="img-gird wpr-first-letter" >' .$first_letter. '</span>';
					}
	            ?>
	            <div class="wpr-pr-coverphoto" style="background-color:
	            	<?php echo esc_attr($profile->banner_clr); ?>;">
	            	<div class="wpr-cv-uploader">

	            	<img src="<?php echo $img_url ?>wpr_cover_photo.png" alt="" class="image img-responsive">
	            	</div>
	            </div>
	            <div class="wpr-pr-userphotp wpr-profile-photo-render"> 

	            	<div class="wpr-userphoto-render" style="<?php echo esc_attr($profile_style); ?>">
	            		<?php echo $html; ?>
	            	</div>
	            </div>
	        	<h3 class="wpr-pr-username"><?php echo $profile->user->display_name; ?></h3>
		    </div>
			<?php } ?>
			
		</div>
		<div class="wpr-profile-body" style="background-color: <?php echo esc_attr($profile->tab_bg_clr); ?>">

			<div class="row wpr-pr-body-layout">
				
				<div class="col-md-12 wpr-tab-body">
					<?php if (is_user_logged_in() ): 
					$wpr_account_url = WPRLOGIN()->wpr_get_core_page_for_redirect('account');
			?>
			<div class="dropdown wpr-myaccount">
				<a  class="btn btn-secondary dropdown-toggle" type="button" id="wpr_account_id0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				 	<i class="fa fa-cog" aria-hidden="true" style="font-size: 22px;"></i>
				</a>
				<div class="dropdown-menu wpr-account-2" aria-labelledby="wpr_account_id0">
				  	<a href="<?php echo esc_url($wpr_account_url);?>">
				  		<i class="fa fa-user" aria-hidden="true"></i>
				    	<?php _e('My Account' , 'wp-registration'); ?>
					</a>
					<br>
					<a href="<?php echo wp_logout_url() ?>">
						<i class="fa fa-sign-out" aria-hidden="true"></i>
				    	<?php _e('Log Out' , 'wp-registration'); ?>
				    </a>
				</div>
			</div>
			<?php endif ?>
			  		<div class="tab-content wpr-tab">
					<?php 
						foreach ($tab_control as $tab_id => $tab_val) {


						    wpr_load_templates($tab_val['template'], $template_vars);
						}
					?>
					</div>
				</div>
			</div>
		</div>
</div>