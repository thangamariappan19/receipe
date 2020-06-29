<?php
/**
 * WPR_User class will handle Member Registration
 **/
 if( ! defined("ABSPATH" ) )
        die("Not Allewed");

class WPR_Restrict {

	private static $ins = null;

	function __construct() {

		// restrict_contents for access pages
        add_filter( 'the_content', array($this, 'restrict_contents'),10, 2 );

        // saved pages hook
        add_action( 'save_post_page',  array($this, 'saved_restrict_content_meta'), 10, 3 );

	}

	public static function get_instance() {
	    // create a new object if it doesn't exist.
		is_null(self::$ins) && self::$ins = new self;
		return self::$ins;
	}

    // load restrict_contents metabox scripts
	function load_restrict_script(){

        wp_enqueue_script('wpr-frontend', WPR_URL."/js/restrict-content.js", array('jquery'),WPR_VERSION, true);
        
         //select2
        wp_enqueue_style('WPR-select2', WPR_URL."/css/select2.css");
        wp_enqueue_script('WPR-select2', WPR_URL."/js/select2.js", array('jquery'), WPR_VERSION, true);
	}

     /* -----------------------------------------------
     This metabox function use  Restrict Content page 
     -----------------------------------------------*/
    function restrict_content_metabox(  ){
    
        add_meta_box( 
            'wpr_content_page',
            __( 'Content Restriction' , ' wp-registration'),
            array($this, 'restrict_content_render'),
            'page',
            'side',
            'default'
        );
    }

    function restrict_content_render(){
        // load metabox script
        $this -> load_restrict_script();

        // load restrict_contents template
        wpr_load_templates("admin/restrict-content.php");
    }


	function restrict_content_access_option() {

        $restrict_content = array(    
            ''              => __('Select', 'wp-registration'),
            'public'        => __('Public', 'wp-registration'),
            'all_member'    => __('For All Members', 'wp-registration'),
            'user_role'     => __('By User Role', 'wp-registration'),
            );

        return apply_filters('wpr_restrict_option' ,$restrict_content);
    }

	/**
     * Hide admin bar by role
    **/
    function hide_admin_bar() {

        $wpr_restricted_roles = WPR_Settings()->get_option('wpr_admin_bar');

        if( is_admin() ) return;
        if( ! $wpr_restricted_roles ) return;
            
        //Get all capabilities of the current user
        $user = get_userdata( wpr_get_current_user_id() );
        $caps = ( is_object( $user) ) ? array_keys($user->allcaps) : array();
        //All capabilities/roles listed here are not able to see the dashboard
        if(array_intersect($wpr_restricted_roles, $caps)) {
            // show_admin_bar(false);
            add_filter( 'show_admin_bar', '__return_false', PHP_INT_MAX );
        }
    }

    /**
     * restrict users to access dashboard by role
     *
    **/
    function restrict_dashboard() {
        
        $wpr_restricted_roles = WPR_Settings()->get_option('wpr_dash_access') ? WPR_Settings()->get_option('wpr_dash_access') : array();

        if( ! $wpr_restricted_roles ) return;
        // Check if the current page is an admin page
        // && and ensure that this is not an ajax call
        if ( is_admin() && !( defined( 'DOING_AJAX' ) && DOING_AJAX ) ){
          
            //Get all capabilities of the current user
            $user = get_userdata( wpr_get_current_user_id() );
            $caps = ( is_object( $user) ) ? array_keys($user->allcaps) : array();

            //All capabilities/roles listed here are not able to see the dashboard
            $wpr_restricted_roles = array_map('trim', $wpr_restricted_roles);

            if(array_intersect($wpr_restricted_roles, $caps)) {
               wp_redirect( home_url() );
               exit;
            }
        }
    }

    // restriction content for pages
    function restrict_contents($content) {
        
        if( ! is_page() ) return $content;
        global $post;
        // $current_user = get_userdata( wpr_get_current_user_id() );
        // global $current_user;
        $current_user    = wp_get_current_user();
        $wpr_for_members = get_post_meta( $post -> ID, 'wpr_member_restrict', true );
        $wpr_protected   = get_post_meta( $post -> ID, 'wpr_role_restrict', true );
        $error_msg       = get_post_meta( $post -> ID, 'wpr_restrict_msg', true );
        // content set for public
        if( $wpr_for_members == 'public' || $wpr_for_members == '' )  return $content;
        
        // for all members
        if( $wpr_for_members == 'all_member' && is_user_logged_in() ) return $content;
            
        $user_allowed = 'no';
        if (is_array($wpr_protected)){
            $current_user_roles = $current_user->roles; 
            foreach ($current_user_roles as $current_user_role){
                if( in_array( $current_user_role, $wpr_protected ) ){
                    return $content;
                }
            }
        }

        $defualt_msg = __('You are not allowed to see these contents', 'wp-registration');

        if ( !isset($error_msg) || $error_msg == '') {
            $content = $defualt_msg;
        }else{
            $content = $error_msg;
        }
       
        return $content;
    }


    // restrict_contents meta saved
    function saved_restrict_content_meta($post_id, $update){
        if (isset($_POST['wpr_member_restrict']) ||
            isset($_POST['wpr_role_restrict']) ||
            isset($_POST['wpr_restrict_msg'])
            ) {

            update_post_meta( $post_id, 'wpr_member_restrict', $_POST['wpr_member_restrict'] );
            update_post_meta( $post_id, 'wpr_role_restrict',$_POST['wpr_role_restrict'] );
            update_post_meta( $post_id, 'wpr_restrict_msg', $_POST['wpr_restrict_msg'] );
        }
    }


}

// new WPR_Profile();
WPRRESTRICT();
function WPRRESTRICT() {
	return WPR_Restrict::get_instance();
}