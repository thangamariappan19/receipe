<?php
/**
 * WPR_User class will handle Member Registration
 **/
 if( ! defined("ABSPATH" ) )
        die("Not Allewed");

class WPR_Profile {

	private static $ins = null;

	function __construct() {

		add_shortcode( 'wpr-profile', array($this, 'render_profile') );  
		add_shortcode( 'wpr-account', array($this, 'render_account') );  
	

		add_filter('wpr_profile_value', array($this, 'filter_value'), 10, 2); 

		// ajax callback function
		add_action( 'wp_ajax_profile_save_field', array($this, 'profile_save_field') );
        add_action( 'wp_ajax_nopriv_profile_save_field', array($this, 'profile_save_field') );

        // ajax callback function
        add_action( 'wp_ajax_profile_change_password', array($this, 'profile_change_password') );
        add_action( 'wp_ajax_nopriv_profile_change_password', array($this, 'profile_change_password') );

        // ajax callback function
        add_action( 'wp_ajax_delete_user_account', array($this, 'delete_user_account') );
        add_action( 'wp_ajax_nopriv_delete_user_account', array($this, 'delete_user_account') );

        // Saving cover/profile photos
        add_action( 'wp_ajax_wpr_save_profile_photo', array($this, 'save_profile_photos') );

        add_action ('init' , array($this, 'wpse_redirect_profile_access') );

        // WC Support in my account
        // Change order detail URL
        add_filter('woocommerce_my_account_my_orders_actions', array($this, 'change_orer_detail_url'), 10, 2);
        

	}

	public function set_user_data( $user_id ) {

        $this->user = new WPR_User( $user_id );
        

        $this->form = new WPR_Form( $this->user->form_id );

        // get profile setting
        $this -> banner_clr = $this-> form->get_option("wpr_pr_bnr_clr") ?   $this-> form->get_option("wpr_pr_bnr_clr") : '#eff6f6';

        $this -> tab_bg_clr = $this-> form->get_option("wpr_tab_bg_clr") ?   $this-> form->get_option("wpr_tab_bg_clr") : '#b2d8dfd4';

        $this -> tab_lb_clr = $this-> form->get_option("wpr_pr_label_clr") ? $this-> form->get_option("wpr_pr_label_clr") : 'black';

        $this -> label_size = $this-> form->get_option("wpr_pr_label_size") ? $this-> form->get_option("wpr_pr_label_size") : '12px';
        

        $this -> enable_photo_area = $this-> form->get_option("wpr_allow_banner") == ''? 'no' : $this-> form->get_option("wpr_allow_banner");

        $this -> enable_pass = $this-> form->get_option("wpr_allow_pass") == ''? 'no' : $this-> form->get_option("wpr_allow_pass");
                                                 
        $this -> img_layout = $this-> form->get_option("wpr_pr_photo_layout") == 'circle' ? 'img-circle' : 'img-square'; 

        $this -> cover_photo_width = $this-> form->get_option("wpr_cover_photo_width") ? $this-> form->get_option("wpr_cover_photo_width") : '980';
        $this -> cover_photo_height = $this-> form->get_option("wpr_cover_photo_height") ? $this-> form->get_option("wpr_cover_photo_height") : '200';
        
        $this -> profile_photo_width = $this-> form->get_option("wpr_profile_photo_width") ? $this-> form->get_option("wpr_profile_photo_width") : '200';
        $this -> profile_photo_height = $this-> form->get_option("wpr_profile_photo_height") ? $this-> form->get_option("wpr_profile_photo_height") : '175';     

         $this -> user_account = $this-> form->get_option('wpr_delete_account') != false ? $this-> form->get_option('wpr_delete_account') : 'no';                
    }

	public static function get_instance() {
	    // create a new object if it doesn't exist.
		is_null(self::$ins) && self::$ins = new self;
		return self::$ins;
	}

	function load_profile_script(){
		global $wp_scripts;

        // Bootstrap
        wp_register_style('wpr-bsrp', WPR_URL."/css/bootstrap.min.css");
        
        wp_enqueue_style( 'wpr-bsrp' );

        // Check if bootstrap is already enqueued
	    $bootstrap_enqueued = FALSE;
	    foreach( $wp_scripts->registered as $script ) {
	        if ((stristr($script->src, 'bootstrap.min.js') !== FALSE or
	             stristr($script->src, 'bootstrap.js') != FALSE) and
	            wp_script_is($script->handle, $list = 'enqueued')) {

	            $bootstrap_enqueued = TRUE;
	            break;
	        }
	    }

	    if (!$bootstrap_enqueued) {
        	wp_register_script('wpr-bsrp', WPR_URL."/js/bootstrap.min.js", array('jquery'), WPR_VERSION, true);
        	wp_enqueue_script( 'wpr-bsrp' );
		}

		// frontent file load
	    wp_register_style('wpr-frontend', WPR_URL."/css/wpr-frontend.css");
		
		wp_enqueue_style( 'wpr-frontend' );
		
		
	    wp_register_script('wpr-frontend', WPR_URL."/js/wpr-frontend.js", array('jquery'),WPR_VERSION, true);
	    wp_register_script('wpr-profile', WPR_URL."/js/wpr-profile.js", array('jquery'),WPR_VERSION, true);
	    wp_register_script('wpr-profile-uploader', WPR_URL."/js/uploader.js", array('jquery'),WPR_VERSION, true);

	    // croppie photo uploader
	    wp_register_style('wpr-croppie', WPR_URL."/css/croppie.css");
	    wp_register_script('wpr-croppie', WPR_URL."/js/croppie.js", array('jquery'),WPR_VERSION, true);

		wp_enqueue_style( 'wpr-croppie' );
		
		wp_enqueue_script( 'wpr-frontend' );
		wp_enqueue_script( 'wpr-profile' );
		wp_enqueue_script( 'wpr-profile-uploader' );
		wp_enqueue_script( 'wpr-croppie' );
	

        // font-awesome and ionic icons 
        wp_register_style('wpr-ftawsome', WPR_URL."/css/font-awesome/css/font-awesome.css");
        wp_register_style('wpr-icon-ii-icon', WPR_URL."/css/wpr-fonticons-ii.css");
        wp_register_style('wpr-icon-fa-icon', WPR_URL."/css/wpr-fonticons-fa.css");

         //select2
        wp_register_style('WPR-select4', WPR_URL."/css/select2.css");
        // wp_register_script('WPR-select2', WPR_URL."/js/select2.js", array('jquery'), WPR_VERSION, true);
		
		wp_enqueue_style( 'wpr-ftawsome' );
		wp_enqueue_style( 'wpr-icon-ii-icon' );
		wp_enqueue_style( 'wpr-icon-fa-icon' );
		wp_enqueue_style( 'WPR-select4' );
		
        // Swal
        wp_register_style('wpr-swal', WPR_URL."/css/sweetalert.css");
        
        wp_enqueue_style( 'wpr-swal' );
        
        wp_register_script('wpr-swal', WPR_URL."/js/sweetalert.js", array('jquery'), WPR_VERSION, true);
        wp_register_script('wpr-lib', WPR_URL."/js/wpr-lib.js", array('jquery'), WPR_VERSION, true);      
		
		wp_enqueue_script( 'wpr-swal' );
		wp_enqueue_script( 'wpr-lib' );
		
        $wpr_profile_vars = array(
	      'ajax_url'   => admin_url( 'admin-ajax.php') ,
	      'strings'    => $this->change_password_validate(),
	      'loading'    => WPR_URL.'/images/wpr-loader.gif',
	      'error_msg'  => 'Please remove above error before update',
	    );
        // ajax load
	    wp_localize_script( 'wpr-frontend', 'wpr_vars', $wpr_profile_vars);
	    wp_localize_script( 'wpr-profile', 'wpr_vars', $wpr_profile_vars);
	    wp_localize_script( 'wpr-profile-uploader', 'wpr_vars', $wpr_profile_vars);
	}

	function change_password_validate(){
		$js_strings = array("old_password_empty" => __("Old password is empty!", 'nm-wpregistration'),
					"new_password_empty"	    => __("New password is empty!", 'nm-wpregistration'),
					"new_password_not_match"   => __("New password do not match!", 'nm-wpregistration'),
		);

		return $js_strings;
	}


	function filter_value( $value, $meta ) {

		$type = $meta['type'];

		switch ( $type) {
			case 'checkbox':
				
				$value = implode(',', $value);
				break;

			case 'email':
				
				$value = '<a href="mailto:'.esc_attr($value).'">'.$value.'</a>';
				break;
			
			case 'color':

				$value = '<span style="padding: 3px;background-color:'.esc_attr($value).'">'.$value.'</span>';
				break;
			case 'autocomplete':
				
				$value = implode(',', $value);
				break;
		}

		return $value;
	}


	function render_profile() {

		$user_id = wpr_get_current_user_id();

		$this -> set_user_data( $user_id );

		

		$this -> load_profile_script();

		ob_start();

		$profile_template 	= "profile/home-profile.php";
		$template_vars		= array( "profile" => $this );	
		$profile_template 	= apply_filters('wpr_profile_template', $profile_template);
		wpr_load_templates( $profile_template, $template_vars );

		$wpr_profile = ob_get_clean();

		return $wpr_profile;
	}

	function render_account() {

		$user_id = wpr_get_current_user_id();
		$this -> set_user_data( $user_id );
		$this -> load_profile_script();

		ob_start();

		$profile_template 	= "profile/home-account.php";
		$template_vars		= array( "profile" => $this );	
		$profile_template 	= apply_filters('wpr_profile_template', $profile_template);
		wpr_load_templates( $profile_template, $template_vars );

		$wpr_profile = ob_get_clean();

		return $wpr_profile;
	}


	function render_profile_fields() {

		$form_fields = '';
        
		ob_start();
		foreach($this->form->form_fields as $index => $field) {

			foreach ($field as $type => $meta) {

				$field_setting = WPR_META()->get_field_settings($type);
				if (isset( $field_setting['scripts']) ) {
					wpr_load_input_script ($type, $field_setting['scripts']);
				}


				if ( $this->is_visible($meta) ) {

				$field_template = "inputs/{$type}.php";
				$field_meta		= array( 'field_meta' => $meta );
				$field_template = apply_filters('wpr_field_template', $field_template);
				wpr_load_templates( $field_template, $field_meta );
				}
			}
		}

		$form_fields = ob_get_clean();

		return $form_fields;
	}

	
    function profile_tabs () {
    	
        $tabs = array();
        $tabs['overview_tab'] =  array('menu' => 'Overview',
                        'icon' => 'fa-info-circle',
                        'template' => 'profile/overview.php'
                    );
        // var_dump(wpr_woocommerce_intigration());
    	if (wpr_woocommerce_intigration() == 'on') {
    		$tabs['woocommerce'] =  array('menu' => 'Woocommerce',
                        'icon' => 'fa fa-wikipedia-w',
                        'template' => 'profile/wpr-woocomerce.php'
                    );
    	}
        if (wpr_previous_user_enable_profile() ) {

            
            $tabs['edit_profile_tab'] =  array('menu' => 'Edit Profile',
                            'icon' => 'fa-pencil-square-o',
                            'template' => 'profile/edit-profile.php'
                        );
        }
        if ( $this -> enable_pass == 'yes') {
            $tabs['password_change_tab'] = array('menu' => 'Change Password',
                            'icon' => 'fa-key',
                            'template' => 'profile/change-password.php'
                        );
        }
        if ( $this -> user_account == 'yes') {
            $tabs['delete_account'] = array('menu' => 'Delete Account',
                                            'icon' => 'fa fa-trash',
                                            'template' => 'profile/delete_account.php'
                        );
        }
        
        
        return apply_filters('wrp_profile_tabs', $tabs, $this);
    }

    // profile setting meta box 
    function admin_profile_setting_metabox(  ){
        add_meta_box( 
            'wpr_profile_setting',
            __( 'Profile Setting' , ' wp-registration'),
            array($this, 'admin_profile_setting_field'),
            'wpr',
            'side',
            'default'
        );
    }

    function admin_profile_setting_field(){

        // load email template
        wpr_load_templates("admin/profile-setting.php");
    }
    
    function profile_photo_layout(){

        $photo_layout = array('circle'=>'Circle',
                              'sqaure'=>'Sqaure',
                        );
        
        return apply_filters('wpr_profile_img_layout', $photo_layout); 
    }

    function wpse_redirect_profile_access(){
       //admin won't be affected
       if (current_user_can('manage_options')) return '';
       //if we're at admin profile.php page
       if (strpos ($_SERVER ['REQUEST_URI'] , 'wp-admin/profile.php' )) {
           wp_redirect ( home_url( '/profile/' )); // to page like: example.com/my-profile/
           exit();
       }

    }


    function change_orer_detail_url($actions, $order){
		
		if( WPRLOGIN()->wpr_is_core_page("account") ) {

			$myaccount  = WPRLOGIN()->wpr_get_core_page_for_redirect('account');
			$order_url = add_query_arg('order_id', $order->get_id(), $myaccount);

			$actions['view']['url'] = $order_url;
		}
		
		return $actions;
	}


	// Handle field visiblity based on settings
	function is_visible( $meta ) {

		$return = false;

        // wpr_pa($meta);

		if( empty($meta['wpr_visible']) ) {

			$return = true;

		} elseif( $meta['wpr_visible'] == 'visible_in_profile' 
			|| $meta['wpr_visible'] == 'visible_in_both') {

			$return = true;
		}

		// If password, do not render
		if( isset($meta['data_name']) && 
            ($meta['data_name'] == 'password' ||
            $meta['data_name'] == 'user_login' || 
            $meta['data_name'] == 'user_email')
             ) {
			$return = false;
		}

		return apply_filters('wpr_is_profile_field_visible', $return, $meta, $this);
	}

	function profile_save_field(){

		// check nonce for scurity
    	if( ! wpr_is_nonce_clear( 'wpr_profile_updating') )
    		die('sorry for security reason');

		if( ! isset($_POST['wpr']) ) return null;

		$user_id = $_POST['current_user'];
		$this->set_user_data( $user_id );

		$profile_data = $_POST['wpr'];
		$this->user->update_profile( $profile_data );

		$success_msg = __('Profile update successfuly', 'wpr');
	    $response = array(  'user_id'=>$user_id, 
		                    'status'=>'success',
		                    'message'=>$success_msg,
                );
		wp_send_json( $response );
    }


    function profile_change_password(){

    	// check nonce for scurity
    	if( ! wpr_is_nonce_clear( 'wpr_change_user_password') )
    		die('sorry for security reason');

    	if( ! isset($_POST['old_password']) || ! isset($_POST['new_password']) ) return null;

    	$user_id = wpr_get_current_user_id();

        $old_pass = $_POST['old_password'];
        $new_pass = $_POST['new_password'];
        $this->set_user_data( $user_id );

        $this->user->update_user_password( $old_pass, $new_pass );

        wp_send_json($_POST);
    }

 	// delete the account
 	function delete_user_account() {

        if( ! isset($_POST['user_id']) )  return null;
        	$user_id = $_POST['user_id'];
           

            $response = array('status'=>'success','message'=>__('Account Has Been Deleted', 'wpr'));

        require_once(ABSPATH.'wp-admin/includes/user.php' );
        wp_delete_user($user_id );
   		wp_send_json($response);
    }

    function save_profile_photos() {

    	$type = $_POST['photo_type'];
    	$data_url = $_POST['data_url'];

    	$data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data_url));
    
    	$user_id = wpr_get_current_user_id();

    	$filename = $type == 'cover_photo' ? 'wpr_cover_photo.png' : 'wpr_profile_photo.png';

    	$file_destination = wpr_files_setup_get_directory($user_id) . $filename;

    	
    	
    	file_put_contents( $file_destination, $data);

    	die(0);
    }

}

// new WPR_Profile();
WPRPROFILE();
function WPRPROFILE() {
	return WPR_Profile::get_instance();
}