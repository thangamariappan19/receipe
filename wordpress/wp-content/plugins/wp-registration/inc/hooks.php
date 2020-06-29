<?php
/**
** will handle all wp hooks callbacks
** actions & filters
**/

    // not run if accessed directly
    if( ! defined('ABSPATH' ) ){
  	    die("Not Allowed");
    }


function wpr_hooks_submit_form(){
	
    // check nonce for scurity
    if( ! wpr_is_nonce_clear( 'wpr_register_user') )
        die('sorry for security reason');

    // if captcha is enable
     $recaptcha_enable = wpr_recaptcha_enable_setting();

    if ($recaptcha_enable == true) {

        $recaptcha_response = wpr_verify_recaptcha();
        if( $recaptcha_response['status'] == 'error' ) {

            wp_send_json ( $recaptcha_response ) ;
        }
    }


    $fields     = isset($_POST['wpr']) ? $_POST['wpr'] : null;
    $formd_id   = isset($_POST['wpr_form_id']) ? $_POST['wpr_form_id'] : null;
	$form       = new WPR_Form($formd_id);

    $success_msg = $form->get_option('wpr_msg_on_reg') == '' ? 'Registration Done !' :
                    $form->get_option('wpr_msg_on_reg');

    $wpr_register = new WPR_Register( $formd_id, $fields );
    $user_id = $wpr_register->create_user();
    
    if( is_wp_error( $user_id) ) {
        
        if( $user_id->get_error_code() == 'existing_user_login' ||
        $user_id->get_error_code() == 'existing_user_email' ) {
            
            $response = array('status'=>'error', 'message'=>sprintf(__("%s", "wpr"), $user_id->get_error_message()) );
            wp_send_json( $response );
        }
    }

    // If any errors found during registration like email
    if( apply_filters('wpr_show_signup_error_message', true, $form_id) ) {
        if( $wpr_register->errors ) {
            foreach($wpr_register->errors as $error) {
                $success_msg .= "\r\n".$error;
            }
        }
    }
    
    $user = new WPR_User ($user_id);
   
    $response = array(  'user_id'  => $user_id, 
                        'status'   => 'success',
                        'signup'   => 'signup',
                        'message'  => $success_msg,
                        'redirect_url_signup'  => $user->redirect_url_signup(), 
                    );
    if($user_id){
        $wpr_register->send_registration_fields_in_email();
    }
    wp_send_json( $response );

}

// Setting user password via hook
function wpr_hook_set_password( $signup_data, $wpr_register ) {
	
    // generating wp password by default
	$wpr_password = wp_generate_password( 10, false );

    // Checking if password is set via form
    if( !empty($signup_data['password']) ) {
        $wpr_password = $signup_data['password'];
    }    

	$signup_data['user_pass'] = $wpr_password;
	
	return $signup_data;
}