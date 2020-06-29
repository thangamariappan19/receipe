<?php 
/*
** Overview Tab view show the information
*/

	// not run if accessed directly
    if( ! defined("ABSPATH" ) )
    	die("Not Allewed");

  $last_login     	    = get_user_meta( $profile->user->id,  'wpr_last_login', true );
  $last_page_visit      = get_user_meta( $profile->user->id,  'wpr_last_page_visit', true );
  $user_last_page_visit = get_the_title($last_page_visit);

  	if ( $last_login != '') {
  		$the_login_date      = date_i18n(get_option( 'date_format' ).' '.get_option( 'time_format' ), $last_login );
  	}else {
 
  		$the_login_date = 'user not login';
  	}

  $template_vars   = array();
  $template_vars   = array('profile' => $profile);
  $msg_from_admin  = get_option('wpr_user_msg');

  // wpr_pa($profile);
?>
<div class="wpr-tab-pane tab-pane fade in active" id="overview_tab" style="height: 400px;">
<?php  
    if ($msg_from_admin ) {
  		
	  	foreach ($msg_from_admin as $index => $role_msg) {
	  		foreach ($role_msg as $key => $value) {

	  			 
		  		if ($key == $profile->user->role || $key == 'all' ) { 
		  			if (!empty($role_msg[$key]) && is_user_logged_in() ) {?>
			  			<div class="wpr_msg_box">
					  	 	<P><?php echo $role_msg[$key]; ?></P>
					  	</div>
				  	<?php 
		  			}
		  		}
	  		}
	  	} 
  	}

?>
    <div class="modal-header wpr-view-header">
		<h2 class="wpr-tab-heading"><?php _e('Overview' , 'wp-registration'); ?></h2>
	</div>
	<div class="modal-body wpr-pr-overview">
		<table class="table wpr-data-view">
            <tbody>
            <?php 
            	foreach ($profile->user->overview_fields() as $data_name => $meta) {

            		$profile_title = isset($meta['label']) ? $meta['label'] : '';
            		$profile_value = isset($meta['value']) ? $meta['value'] : '';

			?>
		            	<tr>
		                    <td class="wpr-pr-title"><?php echo $profile_title; ?></td>
		                    <td class="wpr-pr-value"><?php echo $profile_value; ?></td>
		              	</tr>
          	<?php
				}
         	?>
            </tbody>
		</table>
		
	</div>
	<div class="wpr-last-view">
		<span><?php _e('Last Page Visit:' , 'wp-registration'); ?></span>
		<span><?php echo esc_attr($user_last_page_visit); ?></span>
		<div>
			<span><?php _e('Last Login Date:' , 'wp-registration'); ?></span>
			<span><?php echo esc_attr($the_login_date); ?></span>
		</div>
	</div>
</div>