<?php
/**
** This will restrict users to access default login and register pages
** if settings are enable
**/

 if( ! defined("ABSPATH" ) )
        die("Not Allewed");


class WPR_login {

	private static $ins = null;

	function __construct() {

		add_filter('query_vars', array(&$this, 'query_vars'), 10, 1 );
		
		add_action('init', array(&$this, 'rewrite_rules'), 100000000);
		
		// Login/Signup restrict if logged in -> myacount
		add_action('template_redirect', array( $this, 'handle_pages_access' ) );

		add_action('init', array( $this, 'wpr_core_pages_access' ) ) ;
	
		add_filter( 'login_redirect', array($this, 'handle_login_redirect'), 10, 3 );
		// if login failed
        add_action('wp_login_failed', array( $this, 'wpr_core_access_login_page' ), 10, 1);
        
	}

	// Add some wpr global vars
	function query_vars($public_query_vars) {
		$public_query_vars[] = 'wpr_user';
		$public_query_vars[] = 'wpr_sniffer';
		// $public_query_vars[] = 'wpr_tab';
		return $public_query_vars;
	}

	public static function get_instance() {
	    // create a new object if it doesn't exist.
		is_null(self::$ins) && self::$ins = new self;
		return self::$ins;
	}


	function wpr_core_pages_access() {

		global $pagenow;

		// Redirect user to WPR Login form instead default login
		if ( isset( $pagenow ) && $pagenow == 'wp-login.php' && !is_user_logged_in() && !isset( $_REQUEST['action'] ) ) {

			$allowed = WPR_Settings()->get_option('wpr_enable_core_login_page');
			
			if ( $allowed == 'on' ) {
				
				$redirect = $this->wpr_get_core_page_for_redirect('login');

				//Add support query string data after user login
				if($_SERVER['QUERY_STRING']) {
					$redirect .= '?'.$_SERVER['QUERY_STRING'];
				}
				
				exit( wp_redirect( $redirect ) );
			}
		}

		// Redirect user to WPR Profile after enter profile.php page
		if ( isset( $pagenow ) && $pagenow == 'profile.php' && is_user_logged_in() && !current_user_can('administrator') && !isset( $_REQUEST['action'] ) ) {

				$user_id = wpr_get_current_user_id();
				$wp_user = new WPR_User( $user_id );
				
				exit( wp_redirect( $wp_user->profile_url ) );
		}

		// Redirect user to WPR Resgiter form instead default Register
		if ( isset( $pagenow ) && $pagenow == 'wp-login.php' && !is_user_logged_in() && isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'register' ) {
			
			$allowed = $allowed = WPR_Settings()->get_option('wpr_enable_core_register_page');
			
			if ( $allowed == 'on') {
				
				$redirect = $this->wpr_get_core_page_for_redirect('register');
				
				exit( wp_redirect( $redirect ) );
			}
		}
	
		// Lost password page
		$wpr_reset_page = $this->wpr_get_core_page_for_redirect('password_reset');
		if ( isset( $pagenow ) && $pagenow == 'wp-login.php' && isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'lostpassword' && !empty($wpr_reset_page) ) {
			
			$errors = retrieve_password();
			
			
			if( is_wp_error($errors) ) {
				$wpr_reset_page = add_query_arg('wpr_error', $errors->get_error_code(), $wpr_reset_page);
			}
			
			exit( wp_redirect( $wpr_reset_page ) );
		}

		// lost account page
		$wpr_account_page = $this->wpr_get_core_page_for_redirect('account');
		if ( isset( $pagenow ) && $pagenow == 'wp-login.php' && isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'account' && !empty($wpr_account_page) ) {
			
			// $errors = retrieve_password();
			
			// if( is_wp_error($errors) ) {
			// 	$wpr_account_page = add_query_arg('wpr_error', $errors->get_error_code(), $wpr_account_page);
			// }
			
			exit( wp_redirect( $wpr_account_page ) );
		}

		//lost profile page
		$wpr_profile_page = $this->wpr_get_core_page_for_redirect('profile');
		if ( isset( $pagenow ) && $pagenow == 'wp-login.php' && isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'profile' && !empty($wpr_profile_page) ) {
			
			// $errors = retrieve_password();
			
			// if( is_wp_error($errors) ) {
			// 	$wpr_profile_page = add_query_arg('wpr_error', $errors->get_error_code(), $wpr_profile_page);
			// }
			
			exit( wp_redirect( $wpr_profile_page ) );
		}

		// lost logout page
		$wpr_account_page = $this->wpr_get_core_page_for_redirect('logout');
		if ( isset( $pagenow ) && $pagenow == 'wp-login.php' && isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'logout' && !empty($wpr_account_page) ) {
			
			// $errors = retrieve_password();
			
			// if( is_wp_error($errors) ) {
			// 	$wpr_account_page = add_query_arg('wpr_error', $errors->get_error_code(), $wpr_account_page);
			// }
			
			exit( wp_redirect( $wpr_account_page ) );
		}

		//lost registration page
		$wpr_register_page = $this->wpr_get_core_page_for_redirect('register');
		if ( isset( $pagenow ) && $pagenow == 'wp-login.php' && isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'register' && !empty($wpr_register_page) ) {
			
			// $errors = retrieve_password();
			
			// if( is_wp_error($errors) ) {
			// 	$wpr_register_page = add_query_arg('wpr_error', $errors->get_error_code(), $wpr_register_page);
			// }
			
			exit( wp_redirect( $wpr_register_page ) );
		}

		//lost registration page
		$wpr_register_page = $this->wpr_get_core_page_for_redirect('login');
		if ( isset( $pagenow ) && $pagenow == 'wp-login.php' && isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'login' && !empty($wpr_register_page) ) {
			
			// $errors = retrieve_password();
			
			// if( is_wp_error($errors) ) {
			// 	$wpr_register_page = add_query_arg('wpr_error', $errors->get_error_code(), $wpr_register_page);
			// }
			
			exit( wp_redirect( $wpr_register_page ) );
		}
		
		// User Verification link clicked
		if( isset($_REQUEST['action']) && $_REQUEST['action'] == 'wpr_verify_email' && isset($_REQUEST['verification_key']) ) {
			
			$user_id  = isset($_REQUEST['userid']) ? $_REQUEST['userid'] : '';
			$wpr_user = new WPR_User( $user_id );
			
			$verification_hash = $_REQUEST['verification_key'];
			if( $wpr_user->verify_user_email( $verification_hash ) ) {
				
				$verify_success_msg = sprintf(__('Congratulations!, you have successfully verify your email. <a href="%s">Login<a/>','wpr'), $this->wpr_get_core_page_for_redirect('login') );
				wp_die( $verify_success_msg );
			} else {
				
				$verify_fail_msg = __("Sorry!, Your account verification link is not valid, please contact admin.",'wpr');
				wp_die( $verify_fail_msg );
			}
		}

	}
	

	// Handling login redirect
	function handle_login_redirect($redirect_to, $request, $user) {

		if( is_wp_error($user) ) return;

		update_user_meta( $user->ID, 'wpr_last_login', time() );
		$wp_user = new WPR_User( $user->ID );
		exit( wp_redirect( $wp_user->redirect_url_login ) );
	}

	// if error in login and login page is being display by WPR
	function wpr_core_access_login_page( $username ) {
		
		$allowed = WPR_Settings()->get_option('wpr_enable_core_login_page');
			

		if ( $allowed == 'on' ) {
		
			$redirect = $this->wpr_get_core_page_for_redirect('login');
	
			$redirect = add_query_arg('wpr_error', 'invalid_login', $redirect);
			
			exit( wp_redirect( $redirect ) );
		}
	}

	// Getting core page permalink
	function wpr_get_core_page_for_redirect($slug){

        $page_url = '';
        $get_core_page = get_option('wpr_core_pages');

        if ( isset( $get_core_page[ $slug ] ) ) {

        	$page_id = $get_core_page[ $slug ];
        	// check if page is published, user may delete it
        	$page_status = get_post_status( $page_id );
        	if( $page_status == 'publish' ) {

            	$page_url = get_permalink( $page_id );
        	}
        }

        if( empty($page_url) ) {

        	/**
        	** if $page_url is not found for any core page
        	** here we generate it again and update wpr_core_pages option as well
        	**/
        	$page_id = $this->wpr_generate_core_page($slug);
        	$page_url = get_permalink( $page_id );
        }

        if ( $page_url ) {
            $page_url = apply_filters('wpr_get_core_page_permailnk', $page_url, $slug);
            return $page_url;
        }
        return '';
    }

    // If any core page is not setup, make it
    function wpr_generate_core_page( $core_slug ) {
    	$core_pages = array();
    	foreach(wpr_set_defualt_pages_array() as $slug => $array ) {

    		if( $core_slug != $slug ) continue;

            // wpr_pa($slug);
                /**
                    If page does not exist
                    Create it
                **/
                $page_exists = wpr_get_post_id_by_meta_key_value('page','_wpr_core', $slug);

                if ( ! $page_exists ) {
                    if ($slug == 'logout') {
                        $content = '';
                    } elseif ( $slug == 'login' ) {
                        $content = '[wpr-login]';
                    } else if ( $slug == 'password_reset' ) {
                        $content = '[wpr-password-reset]';
                    } else if ( $slug == 'account' ) {
                        $content = '[wpr-account]';
                    } else if ( $slug == 'register' ) {
                        $content = wpr_get_default_signup_shortcode();
                    } else if ( $slug == 'profile' ){
                        $content = '[wpr-profile]';
                    }

                    $user_page = array(
                        'post_title'        => $array['title'],
                        'post_content'      => $content,
                        'post_name'         => $slug,
                        'post_type'         => 'post',
                        'post_status'       => 'publish',
                        'post_author'       => wpr_get_current_user_id(),
                        'comment_status'    => 'closed'
                    );

                    $post_id = wp_insert_post( $user_page );
                    // wpr_pa($post_id);
                    wp_update_post( array('ID' => $post_id, 'post_type' => 'page' ) );

                    update_post_meta($post_id, '_wpr_core', $slug);

                    $core_pages[ $slug ] = $post_id;

                }
                /** DONE **/

            }

            if ( isset( $core_pages ) ) {

                $existing_core_pages = get_option('wpr_core_pages', $core_pages);

                foreach( $core_pages as $o_slug => $page_id ) {
                	$existing_core_pages[$o_slug] = $page_id;	
                    $corpage_name = 'wpr_core_page_'.$o_slug;
                    WPR_Settings()->set_option($corpage_name, $page_id);
                }

                update_option('wpr_core_pages', $existing_core_pages);
            }

            // Return core page id
            return $core_pages[ $core_slug ];
    }

    // Getting core page id
	function wpr_get_core_page_id($slug){

        $page_id = '';
        $get_core_page = get_option('wpr_core_pages');
        
        if ( isset( $get_core_page[ $slug ] ) ) {
            $page_id = $get_core_page[ $slug ];
        }

        if ( $page_id ) {
            $page_id = apply_filters('wpr_get_core_page_id', $page_id, $slug);
            return $page_id;
        }
        return '';
    }

	// check if current page is core
	function wpr_is_core_page( $page ) {

		global $post;

		$page_id = $this->wpr_get_core_page_id($page);

		if ( isset($post->ID) && !empty( $page_id ) && $post->ID == $page_id )
			return true;
		if ( isset($post->ID) && get_post_meta( $post->ID, '_wpr_wpml_' . $page, true ) == 1 )
			return true;

		if( isset($post->ID) ){
			$_icl_lang_duplicate_of = get_post_meta( $post->ID, '_icl_lang_duplicate_of', true );

			if (  !empty( $page_id ) && (  (  $_icl_lang_duplicate_of == $page_id && ! empty( $_icl_lang_duplicate_of ) ) || $page_id == $post->ID ) )
				return true;
		}

		return false;
	}


	// WP Logout handling
	// Login/Signup restrict if logged in -> myacount
	function handle_pages_access() {

		global $sitepress, $post;

		$language_code 		= '';
		$current_page_ID    = get_the_ID();
		$logout_page_id 	= $this->wpr_get_core_page_id('logout');
		$has_translation    = false;
		$trid 				= 0;
		$not_default_lang 	= false;

		// Logging use activity for page/post visits
		if( is_singular() && is_user_logged_in() && ! $this->wpr_is_core_page('account')) {

			update_user_meta(wpr_get_current_user_id(), 'wpr_last_page_visit', get_the_ID());
		}
				
		if( is_home() || is_front_page() ){
			return;
		}

		if ( function_exists('icl_object_id') || function_exists('icl_get_current_language')  ) {

				if( function_exists('icl_get_current_language') ){
					$language_code = icl_get_current_language();
				}else if( function_exists('icl_object_id') && defined('ICL_LANGUAGE_CODE') ){ // checks if WPML exists
					$language_code = ICL_LANGUAGE_CODE;
				}

				$has_translation = true;

				if( function_exists('icl_object_id')  && defined('ICL_LANGUAGE_CODE') && isset( $sitepress ) ){ // checks if WPML exists
					$trid = $sitepress->get_element_trid(  $current_page_ID  );
				}

				if( icl_get_default_language() !== $language_code ){
					$not_default_lang = true;
				}else{
					$language_code = '';
				}
		
		}

		// Handling logout redirect when user access logout core page
		if ( $this->wpr_is_core_page('logout') || ( $trid > 0 && $has_translation && $trid == $logout_page_id && $not_default_lang )  ) {
			
			if ( is_user_logged_in() ) {
				
				wp_logout();
				session_unset();
				exit( wp_redirect( wpr_after_logout_redirect_url($language_code) ) );
				
			} else {
				
				exit( wp_redirect( home_url( $language_code ) ) );
			}
			
		} else if( ($this->wpr_is_core_page('login') || $this->wpr_is_core_page('register')) && is_user_logged_in() )
		{
			// If user is logged in and try to access
			// Login, register, redirect him to account page
			exit( wp_redirect( $this->wpr_get_core_page_for_redirect('account') ) );
		} else if( $this->wpr_is_core_page('account') && ! is_user_logged_in() ) {		

			// if user is not logged in and try to access my account
			// redirect to login page
			exit( wp_redirect($this->wpr_get_core_page_for_redirect('login')) ); 
		} else if( $this->wpr_is_core_page('profile') ) {		

			$user_in_query = get_query_var('wpr_user');
			
			$user_id = wpr_get_user_id_by_query( $user_in_query );

			// if not user_id found on profile view then redirect to home
            if( empty($user_id) ) {
                exit( wp_redirect( home_url() ) ); 
            }
		}
	}
    
    
    /***
	***	@setup rewrite rules
	***/
	function rewrite_rules(){
		
		
		if ( $this->wpr_get_core_page_id('profile') != '' ) {

			$profile_page_id = $this->wpr_get_core_page_id('profile');
			$account_page_id = $this->wpr_get_core_page_id('account');
			
			$user = get_post($profile_page_id);

			if ( isset( $user->post_name ) ) {

				$user_slug = $user->post_name;
				$account = get_post($account_page_id);
				$account_slug = $account->post_name;

				$add_lang_code = '';
				$language_code = '';

				if ( function_exists('icl_object_id') || function_exists('icl_get_current_language')  ) {

					if( function_exists('icl_get_current_language') ){
						$language_code = icl_get_current_language();
					}else if( function_exists('icl_object_id') && defined('ICL_LANGUAGE_CODE') ){
						$language_code = ICL_LANGUAGE_CODE;
					}

					// User page translated slug
					$lang_post_id = icl_object_id( $user->ID, 'post', FALSE, $language_code );
					$lang_post_obj = get_post( $lang_post_id );
					if( isset( $lang_post_obj->post_name ) ){
						$user_slug = $lang_post_obj->post_name;
					}

					// Account page translated slug
					$lang_post_id = icl_object_id( $account->ID, 'post', FALSE, $language_code );
					$lang_post_obj = get_post( $lang_post_id );
					if( isset( $lang_post_obj->post_name ) ){
						$account_slug = $lang_post_obj->post_name;
					}

					if(  $language_code != icl_get_default_language() ){
						$add_lang_code = $language_code;
					}

				}

				add_rewrite_rule( $user_slug.'/([^/]+)/?$',
									'index.php?page_id='.$profile_page_id.'&wpr_user=$matches[1]&lang='.$add_lang_code,
									'top'
				);

				// add_rewrite_rule( $account_slug.'/([^/]+)?$',
				// 					'index.php?page_id='.$account_page_id.'&wpr_tab=$matches[1]&lang='.$add_lang_code,
				// 					'top'
				// );
				

				// if( !apply_filters('wpr_rewrite_flush_rewrite_rules', wpr_get_option('wpr_flush_stop') ) )
				flush_rewrite_rules( true );

			}

		}

	}

}

WPRLOGIN();
function WPRLOGIN() {
	return WPR_login::get_instance();
}