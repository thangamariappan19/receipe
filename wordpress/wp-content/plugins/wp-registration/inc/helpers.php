<?php 
/*
** all global function in this file
*/

    // not run if accessed directly
    if( ! defined('ABSPATH' ) ){
        die("Not Allowed");
    }
    

    // loading template files
    function wpr_load_templates( $template_name, $vars = null) {

        if( $vars != null && is_array($vars) ){
            extract( $vars );
        }

        $default_path =  WPR_PATH . "/templates/{$template_name}";

        $theme_template = wpr_load_templates_from_theme($template_name);

        if( $theme_template && ! wpr_is_admin_template($template_name) ) {

            $default_path = $theme_template;
        }
        
        if( file_exists( $default_path ) ){
            require ( $default_path );

        }else {
            die( "Error while loading file {$default_path}" );
        }
    }
    
    function from_created_get_meta( $user_id, $key ) {
        
        $user_data = get_user_by('id',$user_id);
        
        if ($key == 'user_login' || $key == 'user_email' || $key == 'display_name') {

            $value = $user_data->data->$key;
            
            return apply_filters('wpr_key_user_meta', $value, $key);
        }
        
        $val =  get_user_meta( $user_id, $key, true );
        return apply_filters('wpr_key_user_meta', $val, $key);
    }
    
    // registration fields use in edit user 
    function profile_user_meta($user){
        
        $meta = get_user_meta($user->ID);
        
        if (isset($meta["wpr_form_id"])) {
        
            $formid = $meta["wpr_form_id"][0];
            $form_meta = new WPR_Form($formid);
            

            if (is_array($form_meta->form_fields)) {
    
                echo '<h1> WPR Form Feild </h1>';
                echo '<table class="form-table">';
                foreach ($form_meta->form_fields as $object => $object_value) {
                    foreach ($object_value as $form_field => $field) {
                        
                            $value = from_created_get_meta($user->ID, $field['data_name']); ?>
                
                            <tr>
                            <th>
                                <label for="my_select"><?php printf(__("%s", 'nm-wpregisration'), $field['title']); ?></label>
                            </th>
                            <td>
                                <?php   if($form_field == 'checkbox' && is_array($value)){
                                            foreach($value as $index){?>
                                                <input type="checkbox" name="wpr[<?php echo esc_attr($form_field); ?>][<?php echo esc_attr($field['data_name']); ?>]" id="<?php echo esc_attr($field['data_name']); ?>" value="" class="regular-text" checked/>
                                                  <span><?php echo $index; ?></span>
                                           <?php }
                                        }         
                                        if($field['data_name'] == 'user_login') { ?>
                                                <input type="text" name="<?php echo esc_attr($field['data_name']); ?>" id="<?php echo esc_attr($field['data_name']); ?>" value="<?php echo $value; ?>" class="regular-text" disabled/> 
                                <?php   }elseif($form_field != 'checkbox') { ?> 
                                                <input type="text" name="wpr[<?php echo esc_attr($form_field); ?>][<?php echo esc_attr($field['data_name']); ?>]" id="<?php echo esc_attr($field['data_name']); ?>" value="<?php echo $value; ?>" class="regular-text" /> 
                                                <?php 
                                        } ?>
                            </td>
                            </tr>
                        <?php 
                    }
                }
                echo '</table>';
            }
        }
    }
    
    function wpr_load_templates_from_theme($template_name) {


        $template_path =  get_stylesheet_directory() . "/wpr/{$template_name}";

        if( ! is_file( $template_path ) ){
            $template_path = null;
        }

        return  $template_path;
    }


    // Check if given tempalate name is admin
    function wpr_is_admin_template( $template_name ) {

        $file_name = basename($template_name);
        $is_value  = false;

        $admin_templates = array('admin-setting.php', 'consent_settings.php', 'dashboard.php', 'email.php', 'fields.php' ,
                                'form-design-setting.php','form-general-setting.php','how-to-use.php','member-directory.php',
                                'profile-setting.php','restrict-content.php', 'shortcode-render.php' );

        if(in_array( $file_name , $admin_templates)) {
            $is_value = true;
        }

        return $is_value;
    }

    // print defualt array
    function wpr_pa($arr){
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
    }

    
    // nav position change dashboard 
    function custom_register_admin_scripts(){
       wp_enqueue_script('WPR-fields', WPR_URL."/js/nav_position.js", array('jquery'), WPR_VERSION, true);
   }

    // get all form saved meta 
    function wpr_get_form_fields( $form_id ) {
        
        
        $wpr_saved_fields = get_post_meta($form_id,'wpr_fields' , true);
        return $wpr_saved_fields;
    }

    // get the upload dir url
    function wpr_upload_dir_url($user_id) {
          $upload_dir = wp_upload_dir();

          $user = new WPR_User( $user_id );
          $use_directory = apply_filters('wpr_user_dir_name', 'wpr_uploads');

          $upload_dir = $upload_dir['baseurl'] .'/'.$use_directory.'/'.$user->username.'/';
          return preg_replace('/^https?:/', '', $upload_dir);
    };

    // create the floder and save the upload photo
    function wpr_files_setup_get_directory($user_id) {
   
       $upload_dir = wp_upload_dir();
       
       $use_directory = apply_filters('wpr_user_dir_name', 'wpr_uploads');
       $user = new WPR_User( $user_id );

       $wpr_user_dir_path = $upload_dir ['basedir'].'/'.$use_directory.'/'.$user->username.'/';
       wp_mkdir_p( $wpr_user_dir_path );

       return apply_filters( 'wpr_user_dir_path', $wpr_user_dir_path );
    }


//  function for login show in model
    function wpr_get_nav_menus_items() {


        $login_model    = WPR_Settings()->get_option('login_form_popup');
        $menu_name      = WPR_Settings()->get_option('main_name')  ? WPR_Settings()->get_option('main_name') : '';

        $get_all_menu   = wp_get_nav_menu_items($menu_name, $args= array());


        $get_core_page  = get_option('wpr_core_pages');
        $login_page_url = WPRLOGIN()->wpr_get_core_page_for_redirect('login');
       
        $login_id       = $get_core_page[ 'login' ];
        $account_id     = $get_core_page[ 'account' ];

        $html = '';
        if ( $login_model == 'on') {

             $html .= '<input type="hidden" class="wpr-get-login-url" data-login-url="'.esc_attr($login_page_url).'">';
            if ($get_all_menu ) {
            
                foreach ($get_all_menu as $key => $value) {

                    if( $value->object_id == $login_id ){


                            $login_page_id = $value->ID;
                            $login_menu = 'menu-item-'. $login_page_id;
                            $html .= '<input type="hidden" class="wpr-get-login-class" data-login-menu="'
                                        .esc_attr($login_menu).'">';
                           
                    }
                     if ($value->object_id == $account_id) {
                         
                            $account_id = $value->ID;
                            $account_menu = 'menu-item-'. $account_id;
                            $html .= '<input type="hidden" class="wpr-get-account-class"
                                 data-account-menu="'.esc_attr($account_menu).'" >';
                     }         
                }
                
            }
                        $html .= '<div class="modal fade-scale" id="menuclass_id" role="dialog">';
                echo $html;
        }
        
    }


    /**
    ** input option will have following keys
    ** key, label, raw, option_id
    **/
    function wpr_convert_options( $options, $field ) {

        if( empty($options) ) return $options;

        $field_name = $field['data_name'];

        $new_options = array();
        foreach( $options as $option ) {

            $option_id   = sanitize_key($field_name . '-' . $option);
            $new_options[] = array(
                                'key'   => sanitize_key($option),
                                'label' => trim($option),
                                'option_id' => $option_id,
                                    );
        }

        return apply_filters('wpr_field_options', $new_options, $field);
    }



    // font size for form design setting
    function wpr_design_label_size(){
        $lb_size = array('12px'=>'12px',
                         '14px'=>'14px',
                         '16px'=>'16px',
                         '18px'=>'18px',
                         '20px'=>'20px',
                        );
        
        return apply_filters('wpr_label_size', $lb_size); 
    }
    
    
    // username options wpr_setting
    function wpr_username_option_field (){
        $username_opt = array(    
            'none'  => __('Just user First and Last like john_wyne', 'wp-registration'),
            'network_post'    => __('Postfix network name with firstname/Screen name like john_google', 'wp-registration'),
            'network_pre'    => __('Prefix network name with first name like google_john', 'wp-registration'),
            'time_post'     => __('Postfix timestamp name with firstname/Screen name like john_77474451',   'wp-registration'),
            'time_pre'    => __('Prefix timestamp name with firstname/Screen name like 77474451_john', 'wp-registration'),
            );

       return apply_filters('wpr_username_option',$username_opt);
    }

    // user subscribe option for both mailchip and sendingblue
    function wpr_select_subscription_option() {
        $subscrition = array(    
            ''              => __('Select', 'wp-registration'),
            'user_select'  => __('Allow User to subscribe List himself?', 'wp-registration'),
            'auto_sub'    => __('User will be automatically subscribed to following list?', 'wp-registration'),
            );
        return apply_filters('wpr_subscription_option',$subscrition);

    }

    // wpr dashboard accessed setting
    function wpr_get_all_wp_roles($name, $id, $value){

        $get_roles = get_editable_roles();
        $html  = '';
        $html .= '<select name="'.esc_attr($name).'[]" id="'.esc_attr($id).'" class="gn_roles" multiple>';
            foreach ($get_roles as $roles => $role_name) {
            
                $selected = '';
                if( !empty($value) ) {
                    $selected = in_array($roles, $value) ? 'selected="selected"' : '';
                }
                $html .= '<option value="'.esc_attr($roles).'" '.$selected.'>'.sprintf(__("%s","wp-registration"),$roles).'</option>';
            }
        $html .= '</select>';
        return $html;
    }

    // Get logged in user role
    function wpr_get_current_user_role() {
      if( is_user_logged_in() ) {
        $user = wp_get_current_user();
        $role = ( array ) $user->roles;
        return $role[0];
      } else {
        return false;
      }
    }
    
    // loggin
    function wpr_log($message){
    	
    	if( WPR_DEBUG ){
    		
    		error_log(date('[Y-m-d H:i e] '). " $message" . PHP_EOL, 3, LOG_FILE);
    	}
    }


    // Return current user id
    function wpr_get_current_user_id() {

        $user_id = null;
        global $wp_query;
        
        if( $wp_query && WPRLOGIN()->wpr_is_core_page('profile')) {
            
            $user_in_query = get_query_var('wpr_user');
            $user_in_query = str_replace(' ', '_', $user_in_query);
            // var_dump($user_in_query);
            $user_id = wpr_get_user_id_by_query( $user_in_query );  

        }
        else if( is_user_logged_in() ) {
            $user_id = get_current_user_id();
        }
        
        return apply_filters('wpr_current_user_id', $user_id);
    }
    
    


    // This will check if user exists defined in query
    function wpr_get_user_id_by_query( $user_in_query ) {

        //@ Get permalink base settings (user_login, user_id)
        $permalink_base = WPR_Settings()->get_option('wpr_profile_link_base') == '' ? 'user_login' : WPR_Settings()->get_option('wpr_profile_link_base') ;
        // $permalink_base = 'user_login';
        
        $user_id = '';
        switch($permalink_base) {
            
            case 'user_login':
                $user = get_user_by('login', $user_in_query);
                if( empty($user) ) {
                    
                    $user_id = wpr_user_exists_by_email_as_username($user_in_query);
                } else{
                    
                    $user_id = $user->ID;
                }
                break;
                
            case 'user_id':
                $user = get_user_by('id', $user_in_query);
                if( !empty($user) ) {
                    $user_id = $user->ID;
                }
                break;
        }      

        return apply_filters('wpr_user_id_by_query', $user_id, $user_in_query);    
    }
    
    function wpr_user_exists_by_email_as_username( $slug ){

		$user_id = false;

		$ids = get_users( array( 'fields' => 'ID', 'meta_key' => 'wpr_email_as_username_'.$slug ) );
		if ( isset( $ids[0] ) && ! empty( $ids[0] ) ){
			$user_id = $ids[0];
		}

		return $user_id;
	}

    // social button style change
    function wpr_social_btn_design() {

       $social_style = array(    
           'soc_btn_sm'  => __('Small', 'wp-registration'),
           'soc_btn_md'  => __('Medium', 'wp-registration'),
           'soc_btn_lg'    => __('Large', 'wp-registration'),
           );

       return apply_filters('wpr_social_style', $social_style);
    }

    // social button loction change
    function wpr_social_btn_location() {

       $social_location = array(
            ''              => __('Select', 'wp-registration'),   
           'loca_top'  => __('Top', 'wp-registration'),
           'loca_bottom'    => __('Bottom', 'wp-registration'),
           );

       return apply_filters('wpr_social_btn_location', $social_location);
    }

    // select form id for social link 
    function wpr_all_form_id() {

        $posts_form = get_posts([
            'post_type' => 'wpr',
            'post_status' => 'publish',
            'numberposts' => -1
        ]);

         $wpr_form_id = array();
        foreach ($posts_form as $form ) {

            $wpr_form_id[$form->ID]  = __($form->post_title, 'wp-registration');
           
        }

       return apply_filters('wpr_social_btn_location', $wpr_form_id);

    }
    
    
    function wpr_send_notification_members() {

       $notification = array(
           'no_one'  => __('No one', 'wp-registration'),
           'user'  => __('User Only', 'wp-registration'),
           'admin'    => __('Admin Only', 'wp-registration'),
           'both'    => __('Both', 'wp-registration'),
           );

       return apply_filters('wpr_user_notify', $notification);
    }
    
    // check core field username and email exist
    function wpr_check_wp_core_fields($wpr_get_all_saved_field){
        $_its_ok = true;
        if(is_array($wpr_get_all_saved_field)){
            foreach($wpr_get_all_saved_field as $index => $wp_fields){
                foreach($wp_fields as $key => $value){
                    if (isset($value["wp_fields"])) {
                        
                        if($value["wp_fields"] == 'user_login' || $value["wp_fields"] == 'user_email'  ){
                             $_its_ok =  false;
                        } 
                    }
                }
                
            }
            return $_its_ok;
        }
    }

// Select the link to show user profile
    function wpr_select_profile_link() {
        $profile_link = array(
            ''              => __('Select', 'wp-registration'),
            'user_login'  => __('User Login', 'wp-registration'),
            'user_id'    => __('User Id', 'wp-registration'),
        );

       return apply_filters('wpr_profile_link_base', $profile_link);
    }

// member dir profile card gird
    function wpr_member_dir_girds() {


       $card_grid = array(    
           'col-md-3'  => __('col-md-3', 'wp-registration'),
           'col-md-4'    => __('col-md-4', 'wp-registration'),
           'col-md-6'    => __('col-md-6', 'wp-registration'),
           );

       return apply_filters('wpr_profile_card', $card_grid);

    }

    // Loading scripts for inputs based on field meta
    // This function load scripts for inputs
    function wpr_load_input_script( $field_type, $scritps ) {

        foreach($scritps as $type => $source) {
            // wpr_pa($source);

            $script_handler = "{$field_type}-{$type}";
            $scrtipt_source = WPR_URL.'/'.$source['source'];
            if( $type == 'js' ) {
                wp_enqueue_script($script_handler, 
                                $scrtipt_source, 
                                $source['depends'], 
                                WPR_VERSION, 
                                true);
            } else if( $type == 'default' ){
                wp_enqueue_script($source['source']);

            }else{
                wp_enqueue_style($script_handler, $scrtipt_source);
            }
        }
    }
    
    // Get social signup locations
    function wpr_get_social_signup_location() {
        
        $location = WPR_Settings()->get_option('social_btn_loc')  ? WPR_Settings()->get_option('social_btn_loc') : '';
        return apply_filters('wpr_social_button_location', $location);
    }

    
    /**
     * returnin username based on option for social logins/signup
     * @since 2.5
     **/
    function wpr_generate_username($first_name, $last_name, $network) {
    	
    		$username_scheme = WPR_Settings()->get_option('social_username');
    		
    		$wpr_username = '';
    		switch( $username_scheme ) {
    			
    			case 'network_post':
    				$wpr_username = $first_name . '_' . $network;
    				break;
    				
    			case 'network_pre':
    				$wpr_username =  $network . '_' . $first_name;
    				break;
    				
    			case 'time_post':
    				$wpr_username = $first_name . '_' . time();
    				break;
    				
    			case 'time_pre':
    				$wpr_username = time() . '_' . $first_name;
    				break;
    	
    			default:
    				$wpr_username = $first_name . '_' . $last_name;
    				break;
    				
    		}
    		
    		$username = sanitize_user( $wpr_username );
    		return apply_filters('wpr_social_username', $username, $network);
    }
    

    // Checking nonce against actiong
    function wpr_is_nonce_clear( $action_name ) {

        $is_clear = true;
        if ( !wp_verify_nonce( $_POST['wpr_nonce'], $action_name ) ) 
            $is_clear = false;

        return $is_clear;
    }
   
    // // redirect the logout url
    function wpr_after_logout_redirect_url( $language_code='' ) {
        
        $wpr_logout_redirect = WPR_Settings()->get_option('wpr_logout_url');
        if( isset( $_REQUEST['redirect_to']) ) {
            
            $wpr_logout_redirect = $_REQUEST['redirect_to'];
        }
        
        if( $wpr_logout_redirect == ""  ) {
            $wpr_logout_redirect = home_url( $language_code );
            // $wpr_logout_redirect = site_url("login");
        }
         
        return apply_filters('wpr_after_logout_redirect_url', $wpr_logout_redirect);
    }

    /***
    *** @Get posts with specific meta key/value
    ***/
    function wpr_get_post_id_by_meta_key_value($post_type, $key, $value){
        $posts = get_posts( array( 'post_type' => $post_type, 'meta_key' => $key, 'meta_value' => $value ) );
        if ( isset($posts[0]) && !empty($posts) )
            return $posts[0]->ID;
        return false;
    }

    function wpr_handle_logout_redirect( $logout_url, $redirect ) {

        $redirect   = wpr_after_logout_redirect_url();
        $logout_url = add_query_arg(array('redirect_to' => $redirect), $logout_url);

        return $logout_url;
    }
    

   // defualt registration meta array
    function wpr_set_defualt_form_array(){
       $core_form_meta = array(
            'wpr_fields' => 'a:5:{i:1;a:1:{s:8:"wp_field";a:13:{s:5:"title";s:9:"User Name";s:9:"wp_fields";s:10:"user_login";s:9:"data_name";s:10:"user_login";s:4:"desc";s:0:"";s:13:"error_message";s:17:"Username required";s:11:"placeholder";s:14:"Enter Username";s:8:"required";s:2:"on";s:5:"class";s:0:"";s:8:"wpr_icon";s:0:"";s:13:"default_value";s:0:"";s:7:"privacy";s:13:"everyone_view";s:5:"width";s:2:"12";s:11:"wpr_visible";s:15:"visible_in_both";}}i:2;a:1:{s:8:"wp_field";a:13:{s:5:"title";s:10:"First Name";s:9:"wp_fields";s:10:"first_name";s:9:"data_name";s:10:"first_name";s:4:"desc";s:0:"";s:13:"error_message";s:0:"";s:11:"placeholder";s:16:"Enter First Name";s:8:"required";s:2:"on";s:5:"class";s:0:"";s:8:"wpr_icon";s:0:"";s:13:"default_value";s:0:"";s:7:"privacy";s:13:"everyone_view";s:5:"width";s:2:"12";s:11:"wpr_visible";s:15:"visible_in_both";}}i:3;a:1:{s:8:"wp_field";a:13:{s:5:"title";s:9:"Last Name";s:9:"wp_fields";s:9:"last_name";s:9:"data_name";s:9:"last_name";s:4:"desc";s:0:"";s:13:"error_message";s:0:"";s:11:"placeholder";s:15:"Enter Last Name";s:8:"required";s:2:"on";s:5:"class";s:0:"";s:8:"wpr_icon";s:0:"";s:13:"default_value";s:0:"";s:7:"privacy";s:13:"everyone_view";s:5:"width";s:2:"12";s:11:"wpr_visible";s:15:"visible_in_both";}}i:4;a:1:{s:8:"wp_field";a:13:{s:5:"title";s:5:"Email";s:9:"wp_fields";s:10:"user_email";s:9:"data_name";s:10:"user_email";s:4:"desc";s:0:"";s:13:"error_message";s:0:"";s:11:"placeholder";s:11:"Enter Email";s:8:"required";s:2:"on";s:5:"class";s:0:"";s:8:"wpr_icon";s:0:"";s:13:"default_value";s:0:"";s:7:"privacy";s:13:"everyone_view";s:5:"width";s:2:"12";s:11:"wpr_visible";s:15:"visible_in_both";}}i:5;a:1:{s:8:"wp_field";a:15:{s:5:"title";s:8:"Password";s:9:"wp_fields";s:8:"password";s:9:"data_name";s:8:"password";s:12:"confirm_pass";s:2:"on";s:15:"accpt_weak_pass";s:2:"on";s:4:"desc";s:0:"";s:13:"error_message";s:0:"";s:11:"placeholder";s:14:"Enter Password";s:8:"required";s:2:"on";s:5:"class";s:0:"";s:8:"wpr_icon";s:0:"";s:13:"default_value";s:0:"";s:7:"privacy";s:13:"everyone_view";s:5:"width";s:2:"12";s:11:"wpr_visible";s:15:"visible_in_both";}}}',
            '_wpr_mode' => 'register',
            '_wpr_core' => 'register',
            '_wpr_register_use_globals' => 1,
        );
        return apply_filters('wpr_core_form_meta_array', $core_form_meta);

    }

    // default pages array
    function wpr_set_defualt_pages_array(){

        $wpr_core_pages = array(
            'login'    => array( 'title' => 'WPR Login' ),
            'register' => array( 'title' => 'WPR Register' ),
            'account'  => array( 'title' => 'WPR Account' ),
            'profile'  => array( 'title' => 'WPR Profile'),
            'logout'   => array( 'title' => 'WPR Logout'),
            'password_reset'  => array( 'title' => 'WPR Password Reset'),
        );

        return apply_filters('wpr_core_pages_array', $wpr_core_pages);
    }

    // recaptcha enable
    function wpr_recaptcha_enable_setting () {
        $recaptcha_enable = WPR_Settings()->get_option('wpr_recapcta_enable');

            if ($recaptcha_enable == 'on') {

                return true;
            }

            return false;
    }
    
    // Showing errors catched by WPR_Main::catch_errors();
    function wpr_show_errors( $error_types ) {
        
        $errors_catched = wpr_start()->errors;
        
        if( empty($errors_catched) ) return '';
        
        $error_html = '';
        foreach( $errors_catched as $type => $message ) {
            
            if( ! in_array($type, $error_types) ) continue;
            
            $error_html .= sprintf(__("<p class='wpr-error'>%s</p>", 'wpr'), $message);
            // unset(WPR_Main()->errors[$type])
        }
        
        echo $error_html;
    }
    
    function wpr_localize_permalinks( $profile_url,  $page_id ){
    	global $ultimatemember;
    
    	 	if ( function_exists('icl_get_current_language') && icl_get_current_language() != icl_get_default_language() ) {
    			if ( get_the_ID() > 0 && get_post_meta( get_the_ID(), '_wpr_wpml_user', true ) == 1 ) {
    				$profile_url = get_permalink( get_the_ID() );
    			}
    		}
    
    		// WPML compatibility
    		if ( function_exists('icl_object_id') ) {
    			$language_code = ICL_LANGUAGE_CODE;
    			$lang_post_id = icl_object_id( $page_id , 'page', true, $language_code );
    
    			 if($lang_post_id != 0) {
    		        $profile_url = get_permalink( $lang_post_id );
    		    }else {
    		        // No page found, it's most likely the homepage
    		        global $sitepress;
    		        $profile_url = $sitepress->language_url( $language_code );
    		    }
    
    		}
    
    		return $profile_url;
    }

    // return array of all user core fields
    function wpr_get_wp_user_core_fields() {

        $wp_core_fields = array('user_login', 'user_email','user_pass',
                                'user_url', 'display_name','user_registered',
                                'first_name', 'last_name', 'roles', 'description');

        return $wp_core_fields;
    }

    // get the user without field
    function wpr_get_user_without_field ($user_role) {

        if ($user_role == '') {
            $user_role = '';
        }
       

        $args = array('role'=>$user_role,
                        'meta_query' => array(
                            array(
                                'key' => 'wpr_form_id',
                                'compare' => 'NOT EXISTS' // this should work...
                            ),
                        )
                    );
        $total_user = get_users( $args );

        return $total_user;
    }


    function wpr_previous_user_enable_profile(){
       
        $is_ok = true;

        $user_id   = wpr_get_current_user_id();
        
        $all_user  = new WPR_User($user_id);
        if (empty($all_user->form_id)) {
            $is_ok = false;
        }

        return $is_ok;
    }
    
    function wpr_is_email_verification_required() {
        
        $return = false;
        
        $email_varfication = WPR_Settings()->get_option('wpr_activate_email');
        if ($email_varfication ==  'on') {
            $return = true;
        }
        
        return apply_filters('is_email_verification_required', $return);
    }

    // Get shortcode for default form
    function wpr_get_default_signup_shortcode() {

        $signup_shortcode = '';
        $wpr_form_id = get_option('wpr_default_signup_form');
        if( $wpr_form_id ) {
            $signup_shortcode = '[wpr-form id='.$wpr_form_id.']';
        }

        return $signup_shortcode;
    }

    // GDPR render option settings
    function wpr_hooks_gdpr_options($form){


        global $post;
        $form_setting = new WPR_Form($form->form_id);

        $enable_consent = $form_setting->get_option('wpr_consent') != false ? $form_setting->get_option('wpr_consent') :'no';
        $consent_msg = $form_setting->get_option('wpr_consent_msg');
        $consent_url = $form_setting->get_option('wpr_consent_url');
       
        
        if ($enable_consent == 'yes' && $consent_msg != '' ) {
            
            echo '<div class="col-md-12 col-sm-12">';
            echo '<div class="form-group wpr-consent-dspr">';
            echo '<input type="checkbox" name="vehicle2" value=""  required>';
                echo '<a target ="_blank" href="'.$consent_url.'">'.$consent_msg.'</a>';
            echo '</div>';
            echo '</div>';
        }
    }

    function wpr_user_register($form_id, $socail_field ) {
        
        wp_enqueue_script('wpr-sweetalert-js', WPR_URL."/js/sweetalert.js", array('jquery'), WPR_VERSION, true);
    wp_enqueue_script('wpr-script', WPR_URL."/js/wpr-frontend.js", array('jquery'), WPR_VERSION, true);  


        $form       = new WPR_Form($form_id);

        $success_msg = $form->get_option('wpr_msg_on_reg') == '' ? 'Registration Done !' :
                    $form->get_option('wpr_msg_on_reg');

        $wpr_register = new WPR_Register( $form_id, $socail_field );
        $user_id = $wpr_register->create_user();

        if( is_wp_error( $user_id) ) {
            
            if( $user_id->get_error_code() == 'existing_user_login' ||
            $user_id->get_error_code() == 'existing_user_email' ) {
                
                // $response = array('status'=>'error', 'message'=>sprintf(__("%s", "wpr"), $user_id->get_error_message()) );
                // WPRLOGIN()->wpr_get_core_page_for_redirect('register');
                $template_vars  = array();
                    $template_vars = array('error' => $user_id->get_error_message());
                    $form_template = 'social-error.php';
            
                        
                exit(wpr_load_templates($form_template, $template_vars));
            
            }
        }else{
            // 	$user_id = wpr_get_current_user_id();
             $wpr_reg_url = WPR_Settings()->get_option('wpr_reg_url');
            if ($wpr_reg_url) {
               	exit( wp_redirect( $wpr_reg_url ) );
            }else {
				$wp_user = new WPR_User( $user_id );
				
				exit( wp_redirect( $wp_user->profile_url ) );
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
        
    }


    // This function generate username for social networks
    // network: facebook, twitter, google, linkedin
    function wpr_get_username($first_name, $last_name, $network) {
        
        $username_scheme = WPR_Settings()->get_option('_social_username');

        $wpr_username = '';
        switch( $username_scheme ) {
            
            case 'network_post':
                $wpr_username = $first_name . '_' . $network;
                break;
                
            case 'network_pre':
                $wpr_username =  $network . '_' . $first_name;
                break;
                
            case 'time_post':
                $wpr_username = $first_name . '_' . time();
                break;
                
            case 'time_pre':
                $wpr_username = time() . '_' . $first_name;
                break;
                
            default:
                $wpr_username = $first_name . '_' . $last_name;
                break;
                
        }

        return sanitize_user( $wpr_username );
    }