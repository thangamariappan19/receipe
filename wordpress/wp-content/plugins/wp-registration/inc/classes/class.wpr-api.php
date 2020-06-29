<?php
/**
 * WPR API Class
 **/
 
class WPR_API {
    
    
    function __construct() {
        
        add_action( 'rest_api_init', array($this, 'register_endpoints'));
    }
    
    /**
   * Registering new Endpoings
   * 
   * @since 2.4
   **/
   function register_endpoints() {
   	
   		// handle twitter auth
        register_rest_route( 'wpr/v1', '/twitter/', array(
		    'methods' => 'GET',
		    'callback' => array($this, 'twitter_auth'),
		) );
   }
   
   public function twitter_auth($request) {
	   	
   		$parameters = $request->get_params();
   		
   		
   		$twitter_data = wpr_get_twitter_account_info($parameters['oauth_token'], $parameters['oauth_verifier']);
	   
	    // Registering New User
	    $form_id = $parameters['form_id'];
	    $wp_data = wpr_extract_wp_fields_from_social_network($twitter_data, 'twitter');
	    
   		
	    $redirect_user = $this -> redirect_after_user();

	    if($resp['status'] == 'error') {
	  
	    	$redirect_user = add_query_arg(array('nmerror' => 'twitter' ), wpr_get_signup_page_url());
	    }
	    
	    wp_redirect( $redirect_user );
	    exit();
   }
}
new WPR_API();