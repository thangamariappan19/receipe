<?php
/**
 * WPR_User class will handle Member Registration
 **/
 if( ! defined("ABSPATH" ) )
        die("Not Allewed");

class WPR_User {
    
    // class properties
    protected static $wp_user;

    var $extra_fields;

    
    function __construct( $userid ) {

        // add_action('user_register' , array($this, 'wpr_set_user_password'));
        self::$wp_user = get_userdata( $userid );
        // wpr_pa(self::$wp_user);
        $this->extra_fields = array();


        if( !self::$wp_user ) return null;
       
        //Now we are creating properties agains each methods in our Alpha class.
        $methods = get_class_methods( $this );
        $excluded_methods = array('__construct', 
                                    'get_meta',
                                    'set_meta',
                                    'update_profile',
                                    'set_profile_visibility',
                                    'profile_permalink',
                                    'update_user_password',
                                    'overview_fields',
                                    'verify_user_email');
        foreach ( $methods as $method ) {
            if ( ! in_array($method, $excluded_methods) ) {
                $this->$method = $this->$method();
            }
        }

        // Now getting all extra fields in propety of this class
        $form = new WPR_Form( $this->form_id());
        if ($form->form_fields) {
            
            foreach ($form->form_fields as $field) {
                
                foreach ($field as $type => $meta) {

                    
                    if( $type == 'wp_field' ) continue;

                    if( isset( $meta['data_name']) ){

                        $meta_name =$meta['data_name'] ;
                    }
                    $privacy = isset($meta['privacy']) ? $meta['privacy'] : '';
                    $privacy_role = isset($meta['privacy_role']) ? $meta['privacy_role'] : '';
                    
                    // if( isset( $this->extra_fields[$meta_name]) )


                    $this->extra_fields[$meta_name] = array('data_name' =>  $meta['data_name'],
                                                            'title' => $meta['title'],
                                                            'type'  => $type,
                                                            'value' => $this->get_meta($meta_name),
                                                            'privacy' => $privacy,
                                                            'profile_view'   => $this->set_profile_visibility($meta),
                                                            'privacy_role' => $privacy_role);
                }
            }

        }
    }

    // This function is to return fields for overview
    function overview_fields() {

        $overview_fields = array(
            'username'  =>  array('label'   => __('Username', 'wpr'),
                                    'value' => $this->username()),
            'email'     =>  array('label'   => __('Email', 'wpr'),
                                    'value' => $this->email()),
            'first_name'  =>  array('label'   => __('First Name', 'wpr'),
                                    'value' => $this->first_name()),
            'last_name'  =>  array('label'   => __('Last Name', 'wpr'),
                                    'value' => $this->last_name()),
        );

        // wpr_pa($this);

        return apply_filters('wpr_overview_fields', $overview_fields, $this);

    }
    
    function get_meta( $key ) {
        
        $val =  get_user_meta( $this->id(), $key, true );
        return apply_filters('wpr_user_meta', $val, $key);
    }

    function set_meta( $key, $value ) {
        
        update_user_meta( $this->id(), $key, $value );
    }
    
    function id() {
        return self::$wp_user->ID;
    }
    
    function username() {
        return self::$wp_user->user_login;
    }
    
    function password() {
        return self::$wp_user->user_pass;
    }
    
    function email() {
        return self::$wp_user->user_email;
    }
    
    function url() {
        return self::$wp_user->user_url;
    }
    
    function display_name() {
        return self::$wp_user->display_name;
    }
    
    function registered_on() {
        return self::$wp_user->user_registered;
    }
    
    function first_name() {
        return self::$wp_user->first_name;
    }
    
    function last_name() {
        return self::$wp_user->last_name;
    }
    
    function role() {

        $role = ( array ) self::$wp_user->roles;
        return $role[0];
    }

    function description() {
        return self::$wp_user->description;
    }
    
    function profile_url() {
        
        //@ Get permalink base settings (user_login, user_id)
        // $permalink_base = WPR_Settings()->get_option('wpr_profile_link_base');

        $permalink_base = WPR_Settings()->get_option('wpr_profile_link_base') == '' ? 'user_login' : WPR_Settings()->get_option('wpr_profile_link_base') ;
     
	    // $permalink_base = 'user_login';
		$user_in_url    = '';

		// Get user slug
		$profile_slug = get_user_meta( $this->id, "wpr_user_profile_url_{$permalink_base}", true );
		
		// Username
		if ( $permalink_base == 'user_login' ) {
			
			$user_in_url = $this->username;
            $user_in_url = str_replace(' ', '_', $user_in_url);

			if ( is_email( $user_in_url ) ) {
				$user_email = $user_in_url;
				$user_in_url = str_replace('@','',$user_in_url);
				
				if( ( $pos = strrpos( $user_in_url , '.' ) ) !== false ) {
					$search_length  = strlen( '.' );
					$user_in_url    = substr_replace( $user_in_url , '-' , $pos , $search_length );
				}
				update_user_meta( $this->id , "wpr_email_as_username_{$user_in_url}" , $user_email );

			} else {

				$user_in_url = sanitize_title( $user_in_url );

			}

		}
		
		// User ID
		if ( $permalink_base == 'user_id' ) {
			$user_in_url = $this->id;
		}
		
		update_user_meta( $this->id, "wpr_user_profile_url_{$permalink_base}", $user_in_url  );
        
		$profile_url = $this->profile_permalink( $user_in_url );

		return $profile_url;
    }
    
    /**
	 * Get Profile Permalink
	 * @param  string $slug
	 * @return string $profile_url
	 */
	function profile_permalink( $slug ){

		$profile_pg_id = WPRLOGIN()->wpr_get_core_page_id('profile');
		$profile_url = get_permalink( $profile_pg_id );

		$profile_url = apply_filters('wpr_localize_permalinks', $profile_url, $profile_pg_id );

        if ( get_option('permalink_structure') ) {

			$profile_url = trailingslashit( untrailingslashit( $profile_url ) );
			$profile_url = $profile_url . strtolower( $slug ). '/';

		} else {

			$profile_url =  add_query_arg( 'wpr_user', $slug, $profile_url );

		}

		return ! empty( $profile_url ) ? strtolower( $profile_url ) : '';

	}
	
	// Getting form id
    function form_id() {
        $form_id = $this->get_meta('wpr_form_id');
        return $form_id;
    }

    // This function setting profile view/visiblity
    function set_profile_visibility( $meta ) {

        $privacy_role = isset($meta['privacy_role']) ? $meta['privacy_role'] : array();
        $privacy = isset($meta['privacy']) ? $meta['privacy'] : '';
        $visiblity = false;

        if( ! isset($privacy) ) {

            $visiblity = true;
        } else {

            switch ( $privacy ) {
                // everyone privacy option set to view fields to all
                case 'everyone_view':
                    $visiblity = true;
                    break;

                // member privacy option set to view fields to only members
                case 'member_view':

                    if( is_user_logged_in() ) {

                        $visiblity = true;
                    }
                    break;

                // Only visible to profile owner and admins
                case 'only_owner_admin':

                    if( $this->id() == get_current_user_id() ||
                    current_user_can('administrator') ) {

                        $visiblity = true;
                    }
                    break;

                // Only visible to profile owner and specific roles
                case 'specific_role_1':

                    // Get logged in user role
                    $curent_user_role = wpr_get_current_user_role();

                    if( ( in_array( $curent_user_role, $privacy_role)) ||
                    $this->id() == get_current_user_id() ) {

                        $visiblity = true;
                    }
                    break;

                // Only visible to specific roles
                case 'specific_role_2':

                    // Get logged in user role
                    $curent_user_role = wpr_get_current_user_role();
                    
                    if( ( in_array( $curent_user_role, $privacy_role)) ) {

                        $visiblity = true;
                    }
                    break;
            }
        }

        return $visiblity;
    }


    // Update profile of current user
    function update_profile( $profile_data ) {

        // Adding extra fields in meta
        $core_fields = array('ID'    => $this->id() );

        foreach( $profile_data as $type => $fields ) {
            
            // Skipp username and email fields
            // if( $type == 'wp_field' ) continue;
            
            foreach( $fields as $key => $value ) {
                // wpr_pa($key);

                if( in_array( $key, wpr_get_wp_user_core_fields()) ) {

                    $core_fields[$key] = $value;
                }
                
                $value = apply_filters('wpr_profile_meta_value', $value, $key, $this);
                $this->set_meta( $key, $value );
            }


            // Updating wp user core fields
        }

        wp_update_user($core_fields);
    }


    function account_status() { 

        $status = $this->get_meta('wpr_account_status');
        return $status;
    }

    function verification_hash() { 

        $key = $this->get_meta('wpr_email_key');
        return $key;
    }

   
    /*
     * changing user password
    */
    function update_user_password( $old_pass, $new_pass ){
        
        $response = array();
          
        if ( wp_check_password( $old_pass, $this->password(), $this -> id()) ){
            // wpr_pa($this-id());
            wp_set_password( $new_pass, $this->id() );

            $change_pass_msg = __('Password changed successfuly', 'wpr');

            $wpr_email = new WPR_Email( $this->id(), 'change_password', 'user');
            $wpr_email -> send();
            
            $response = array( 'user_id' =>$this->id(), 
                                'status'=>'success',
                                'message' => $change_pass_msg
                            );
        }else{
            $response = array('user_id' =>$this->id(),
                             'status'=> 'error', 
                             'message' => sprintf(__('%s', 'nm-wpregistration'), "Old password is incorrect!"));
        }

        wp_send_json($response);    
        die(0);
    }


    // Redirects after sign up
    function redirect_url_signup() {

        $global_signup_url = WPR_Settings()->get_option("wpr_reg_url");

        $redirect_url = !empty($global_signup_url) ? $global_signup_url : null;

        $role_base_key = "wpr_".$this->role()."_reg";
        
        $role_base_url = WPR_Settings()->get_option($role_base_key);
        // wpr_pa($role_sbase_url);
        if( $role_base_url ) {

            $redirect_url = $role_base_url;
        }

        return apply_filters('wpr_redirect_url_signup', $redirect_url, $this);
    }

    // Redirects after login
    function redirect_url_login() {

        $global_login_url = WPR_Settings()->get_option("wpr_login_url");

        $redirect_url = !empty($global_login_url) ? $global_login_url : null;

        $role_base_key = "wpr_".$this->role()."_login";
        $role_base_url = WPR_Settings()->get_option($role_base_key);

        if( $role_base_url ) {

            $redirect_url = $role_base_url;
        }

        if( empty($redirect_url) ) {

            /**
            ** if not redirect url set after login then
            ** redirect user to profile page
            **/
            $redirect_url = $this->profile_url;
        }

        return apply_filters('wpr_redirect_url_login', $redirect_url, $this);
    }
    
    
    // Verify user email
    function verify_user_email($verification_hash) {
        
        $hash_matched = false;
        if( $verification_hash == $this->verification_hash() ) {
            
            $hash_matched = true;
            $this->set_meta('wpr_email_key', NULL);
            
            do_action('wpr_user_verification_success', $this);
        }
        
        return apply_filters('wpr_user_verification_success', $hash_matched, $this);
        
    }
}