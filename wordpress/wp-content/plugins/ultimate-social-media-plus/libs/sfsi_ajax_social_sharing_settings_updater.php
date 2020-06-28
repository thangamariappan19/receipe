<?php
add_action( 'wp_ajax_plus_update_sharing_settings', 'sfsi_plus_update_sharing_settings' );

function sfsi_plus_update_sharing_settings() {
	if ( !wp_verify_nonce( $_POST['nonce'], "plus_update_sharing_settings")) {
		echo  json_encode(array('res'=>"error")); exit;
	} 
	if(!current_user_can('manage_options')){ echo json_encode(array('res'=>'not allowed'));die(); }
	$option5  = unserialize(get_option('sfsi_plus_section5_options',false));
	$option5['sfsi_plus_custom_social_hide'] = $_POST['sfsi_plus_custom_social_hide'];
	update_option('sfsi_plus_section5_options',serialize($option5));
	echo true;
	wp_die(); // this is required to terminate immediately and return a proper response
}
?>