<?php
/**
 * Email Manager Class
 **/

if( ! defined("ABSPATH" ) )
        die("Not Allewed");
        
class WPR_Email {
    
    var $user;
    var $context;
    
    function __construct( $user_id, $context, $email_notify, $form_field ='') {
        
        $this -> user           = new WPR_User( $user_id );
        $this -> context 		= $context;
    	$this -> field          = $form_field;
        $form_id                = $this->user->get_meta( 'wpr_form_id' );
        $this -> form           = new WPR_Form( $form_id ); 
        $this -> email_notify   = $email_notify;
        $this-> user_id         = $user_id;
    }
    
    // allow user notify 
    function receiver(){ 
    	
    	
        if($this -> email_notify == 'user') {
            
            $the_email = $this->user->email;
          
        }else if($this -> email_notify == 'admin') {
            
            $the_email = get_bloginfo('admin_email');
          
        }else if($this -> email_notify == 'both'){
        	$the_email = array();
        	$the_email[] = $this->user->email;
        	$the_email[] = get_bloginfo('admin_email');
        }else {
        	$the_email = '';
        }
        
        return $the_email;
    }
    
    function send() {
    	
        $user_email = $this->receiver();
        $subject    = $this->subject();
        $message    = $this->get_email_template_html();
        $headers    = $this->get_mail_header();
        
        if( empty($user_email) ) return '';
        
        return wp_mail( $user_email, $subject, $message, $headers);
    }

    function subject() {
        
        $site_title = get_bloginfo('name');
        
        switch( $this->context ) {
        	
        	case 'signup':
        		$suject = "Welcome " . $this->user->username.'-'.$site_title;
        		break;
        		
        	case 'change_password':
        		$suject = __("Password Changed - {$site_title}", 'wpr');
        		break;
        		
        	case 'email_verify':
        		$suject = __("Verify your Email - {$site_title}");
        		break;
        		
        	case 'form_field':
        		$suject = __("WPR Form Field - {$site_title}");
        		break;	
        }
        
        return apply_filters( "wpr_email_subject", sprintf(__("%s", "wpr"), $suject, $this) );
    }
    
    function message() {
        
        $email_message = '';
        $site_title = get_bloginfo('name');

		switch( $this->context ) {
		
			case 'signup':
							if ($this->form->get_option('wpr_new_user_email') && $this->form->get_option('wpr_new_user_email') != '') {
								   	$email_message =$this->form->get_option('wpr_new_user_email');
							}
							else {
								   $email_message = "Thanks, for registration with us";
							}
		        break;
		        
		    case 'change_password':
    						if ($this->form->get_option('wpr_change_password_email') && $this->form->get_option('wpr_change_password_email') != '') {
						   	$email_message =$this->form->get_option('wpr_change_password_email');
							}
							else {
								   $email_message = "Your password has been changed";
							}
		    	break;
		    	
		    case 'email_verify':
		    	$email_message	= $this->verification_message();
		    	break;
		    	
		}
        
        $email_message = nl2br($email_message);
        return apply_filters( 'wpr_email_message', $email_message, $this->user);  
    }
    
    /**
	 * this function returns the proper header
	 * with wp site title and admin email
	 */
	
	function get_mail_header(){
	 	
	 	$site_title = get_bloginfo('name');
		$admin_email = get_bloginfo('admin_email');
		
		$headers[] = "From: {$site_title} <{$admin_email}>";
		$headers[] = "Content-Type: text/html";
		$headers[] = "MIME-Version: 1.0\r\n";
		
		return apply_filters('wpr_email_header', $headers);
	}
	 
	function get_email_template_html( ){
		
		if ($this -> field != '') {
			
			ob_start();
			$email_template = "email/email.field.template.php";
        	$email_vars     = array("message" => $this -> field );
			wpr_load_templates( $email_template, $email_vars);
		
			$email_string = ob_get_clean();

			return apply_filters('wpr_email_field_html', $email_string, $this -> field);
		
		}else {

			ob_start();
			
			$message = $this->message();
								
			$email_template = "email/template.email.php";
			$email_vars = array('form'=>$this->form);
			wpr_load_templates( $email_template, $email_vars);
			
			$email_string = ob_get_clean();
			
			
			$email_vars = $this->get_email_vars();
		
			// Adding message to template
			$email_string = str_replace("%WPR_EMAIL_CONTENT%", $message, $email_string);
			
			foreach( $email_vars as $var => $value ) {
			    
			    $email_string = str_replace( $var, $value, $email_string);
			}
			
			
			return apply_filters('wpr_email_html', $email_string, $message);
		}
	}
	 
	 // This will return email vars
	function get_email_vars() {
	     
	     
	     //$user_data = get_user_by( 'email', trim( wp_unslash($this->user->email)) );
	     
	     $password_reset_url = $this->get_password_reset_link();
	     
	     
	     //$password_reset = network_site_url( "wp-login.php?action=rp&key=$reset_key&login=" . rawurlencode( $this->user->username ), 'login' );
	     //$password_reset = network_site_url( "wp-login.php?action=rp&key=$reset_key&login=" . rawurlencode($this->user->username));
	     
	     $admin_emails = implode(',', $this->form->get_form_admins());
	     $email_vars = array(
	                        "%USERNAME%"    => $this->user->username,
	                        "%FIRSTNAME%"   => $this->user->first_name,
	                        "%LASTTNAME%"   => $this->user->last_name,
	                        "%PASSWORD%"    => get_user_meta($this->user_id, 'wpr_password', true),
	                        "%PASSWORD_RESET%"	=>$password_reset_url,
	                        "%LOGIN_URL%"   => $this->form->get_login_page_url(),
	                        "%SITE_URL%"    => get_bloginfo('url'),
	                        "%SITE_NAME%"   => get_bloginfo('name'),
	                        "%ADMIN_EMAIL%" => $admin_emails,
	                        "%USER_META%"   => $this->form->get_user_meta(),
	                        );
	                        
	     return apply_filters('wpr_email_vars', $email_vars, $this);
	}
	
	
	function get_password_reset_link() {
		
		// global $wpdb;
		
	 
		$wp_user = new WP_User($this->user->id);
		$key = get_password_reset_key( $wp_user );
	    
	    $password_reset = network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($this->user->username), 'login');
	    
	    return esc_url_raw( $password_reset );
	}
	
	// Verfication message
	function verification_message() {
		
		$verification_url = get_bloginfo('url');
		$verification_url = add_query_arg(array('action'=>'wpr_verify_email',
											'userid'	=> $this->user->id,
											'verification_key'	=> $this->user->get_meta('wpr_email_key')), $verification_url);
											
		$message = '<h2>Email Verfication</h2>';
		$message .= 'Please click below link to verify your account';
		$message .= '<p><a href="'.esc_url($verification_url).'">Click Here</a></p>';
		
		return apply_filters('wpr_verification_message', $message, $verification_url);
		
	}
}