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
   if (is_user_logged_in()) {  $view_width = 9; } else { $view_width = 12; }	
?>

<div class="wpr-container">
	<div class="wpr-profile-header">
		<input type="hidden" id="cover_width" value="<?php echo esc_attr($profile->cover_photo_width); ?>">
		<input type="hidden" id="cover_height" value="<?php echo esc_attr($profile->cover_photo_height); ?>">
		<input type="hidden" id="profile_width" value="<?php echo esc_attr($profile->profile_photo_width); ?>">
		<input type="hidden" id="profile_height" value="<?php echo esc_attr($profile->profile_photo_height); ?>">

		<?php if ($profile->enable_photo_area == 'yes') { 
			$cover_width = $profile->cover_photo_width + 50;
			if ($cover_width > 1030) {
				$cover_width = 	'width:1030px;';
			}else{
				$cover_width = 	'width:'. $cover_width . 'px;';
			}

			$profile_style  = 'background-color:#fffff';
			$profile_style .= 	'height:'. $profile->profile_photo_height . 'px;';

			?>
			
        <div class="wpr-pr-panel panel-default wpr-pr-mr">
            		<?php 
            		 	$user_id = $profile->user->id;
            		 	$profile_photo = wpr_files_setup_get_directory($user_id).'wpr_profile_photo.png';
            		 	$cover_photo = wpr_files_setup_get_directory($user_id).'wpr_cover_photo.png';
            		 	$first_letter =  ucfirst(substr($profile->user->first_name, 0, 1));

            		 	$img_url = wpr_upload_dir_url($user_id);
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
            	<?php 
            		if (is_user_logged_in()) {
            	?>
			            <div class="wpr-pr-coverupload wpr-photo-click" data-toggle="modal" data-target="#wpr-profile-uploader" data-photo-type="cover_photo">
			            	<span class="wpr-pr-camera">
			            		<i class="fa fa-camera" aria-hidden="true"></i>
			            	</span>
			            	<span class="wpr-pr-hidden">
			            		<?php _e('Upload Cover Photo' , 'wp-registration'); ?>
			            	</span>
			            </div>
            	<?php
            		}
            	?>
            </div>
            <div class="wpr-pr-userphotp wpr-profile-photo-render"> 

            	<div class="wpr-userphoto-render" style="<?php echo esc_attr($profile_style); ?>">
            		<?php echo $html; ?>
            	</div>
            	<?php 
            		$wp_user = new WPR_User( $user_id );
            		if (is_user_logged_in()) {
            	?>
	            	<div class="wpr-pr-change-photo text-center wpr-photo-click" data-toggle="modal" data-target="#wpr-profile-uploader" data-photo-type="user_photo">

	            		<span class="wpr-pr-camera">
		            		<i class="fa fa-camera" aria-hidden="true"></i>
	            		</span>
	            		<span class="wpr-pr-hidden">
	            			<?php _e('Upload Photo' , 'wp-registration'); ?>
	            		</span>
		            </div>
	            <?php
            		}
            	?>
            </div>
            
        	<div class="wpr-display-name">
               <h3 class="wpr-pr-username"><?php echo $profile->user->display_name; ?></h3>
               <?php if (wpr_previous_user_enable_profile() ) { ?>
                    <a style="text-decoration: none;" href="<?php echo esc_url($wp_user->profile_url); ?>">
                        <h6><?php _e('View Profile' , 'wp-registration'); ?></h6>
                    </a>
                <?php } ?>
           </div>
	    </div>
		<?php } ?>

	</div>
	<div class="wpr-profile-body" style="background-color: <?php echo esc_attr($profile->tab_bg_clr); ?>">
		<div class="row wpr-pr-body-layout">
			<?php 
        		if (is_user_logged_in()) {

        	?>
			<div class="col-md-3 col-sm-4 wpr-profile-adjust">
		        <div class="navbar-header navbar-inverse">
		            <button type="button" id="nav-toggle" class="navbar-toggle" 
		            		data-toggle="collapse" data-target="#main-nav">
		                <span class="sr-only">
		                	<?php _e('Toggle navigation' , 'wp-registration'); ?>
		                </span>

		                <span class="icon-bar"></span>
		                <span class="icon-bar"></span>
		                <span class="icon-bar"></span>
		            </button>
		        </div>
	            <div id="main-nav" class="collapse navbar-collapse wpr-home-collaspe">
					<ul class="nav wpr-pr-tab" id="mainNav">
				<?php 
					foreach ($tab_control as $tab_id => $tab_val) {
				?>

						<li class="wpr_li_check">
							<a href="#<?php echo esc_attr($tab_id); ?>" data-toggle="tab" 
								 class="scroll-link"
								 style="color:<?php echo esc_attr($profile->tab_lb_clr); ?>;
								 		font-size: <?php echo esc_attr($profile->label_size); ?> ">
								 
									<i class="fa <?php echo esc_attr($tab_val['icon']); ?>" aria-hidden="true"></i>
								<?php echo $tab_val['menu']; ?>
							</a>
						</li>
				<?php
					}
				?>	
						<li class="wpr_li_check">
							<a href="<?php echo wp_logout_url() ?>" class="scroll-link"
								style = "color:<?php echo esc_attr($profile->tab_lb_clr); ?>;
								 		font-size: <?php echo esc_attr($profile->label_size); ?> ">
			   					 <i class="fa fa-sign-out"></i>
			   					 <?php _e('Sign Out' , 'wp-registration'); ?>
							</a>
						</li>
					</ul>
			 	</div>
			</div>
			<?php
        		}
        	?>
			<div class="col-md-<?php echo esc_attr($view_width); ?> col-sm-8 wpr-tab-body">
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

	   <!-- Modal -->
  <div class="modal fade" id="wpr-profile-uploader" role="dialog" style="overflow: auto;">
    <div class="modal-dialog" style="<?php echo esc_attr($cover_width); ?>">
    
      <!-- Modal content-->
      <div class="modal-content">

      	<!-- <div>
      		<span> <?php echo esc_attr($profile->cover_photo_width); ?></span>
      	</div> -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php _e('Chose Photo' , 'wp-registration'); ?></h4>
        </div>
        <div class="modal-body">
        	<span class="wpr-photo-size-show"></span>

	      	<div class="wpr-upload-actions"> 
			    <button class="wpr-file-btn"> 
			    	<i class="fa fa-upload" aria-hidden="true"></i>
			        <span><?php _e('Upload' , 'wp-registration'); ?></span> 
			        <input type="file" id="wpr-upload-pic" value="Select" class="btn btn-primary" /> 
			    </button> 
			    <div class="crop"> 
			        <div id="wpr-upload-img"></div> 
			       
			        <button class="wpr-upload-result"><?php _e('saved' , 'wp-registration'); ?></button> 
			         <div id="wpr-profile-demo" style="margin-left: 24pc; margin-top: 1pc; margin-bottom: 1pc;" ></div> 
			    </div> 
			</div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close' , 'wp-registration'); ?></button>
        </div>
      </div>
    </div>
  </div>
</div>