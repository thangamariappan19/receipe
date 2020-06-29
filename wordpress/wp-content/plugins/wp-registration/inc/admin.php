<?php 
/*
** These file contain the function to control admin side
*/

// not run if accessed directly
if( ! defined('ABSPATH' ) ){
    die("Not Allowed");
}

    /* --------------------------------------
        user column info
    /* --------------------------------------*/

    function wpr_admin_user_column( $column ) {

        $column['form_id'] = sprintf(__('%s', 'wpr'), 'Form ID');
        $column['user_status'] = sprintf(__('%s', 'wpr'), 'Status');             
        return $column;
    }

    /* --------------------------------------
        
    /* --------------------------------------*/

    function wpr_admin_user_column_data( $val, $column_name, $user_id ) {
        
        
        $return = $val;

        $wpr_user = new WPR_User( $user_id );

        $account_status_val = $wpr_user -> account_status;
        
        switch ( $column_name ) {
            case 'form_id':
                
                $return = $wpr_user -> form_id;
                break;  
            case 'user_status':
                
                $return = account_status_change($account_status_val,$user_id);
                break; 
        }

        return $return;
    }


     function wpr_admin_user_columns_cpt( $column ) {

        $column['form_id'] = sprintf(__('%s', 'wpr'), 'Shortcodes');
        $column['auto_login'] = sprintf(__('%s', 'wpr'), 'Auto Login');        
        $column['profile'] = sprintf(__('%s', 'wpr'), 'Profile & Banner');        
        $column['password'] = sprintf(__('%s', 'wpr'), 'Change Password');        
        return $column;
    }

    /* --------------------------------------
        form cpt column info
    /* --------------------------------------*/

    function wpr_admin_user_columns_data_cpt( $column, $post_id ) {

      $form = new WPR_Form( $post_id  );

      $pass = $form->get_option("wpr_allow_pass") == ''? 'no' : $form->get_option("wpr_allow_pass");
      $profile = $form->get_option("wpr_allow_banner") == ''? 'no' : $form->get_option("wpr_allow_banner");
      $login = $form->get_option("wpr_auto_login") == ''? 'no' : $form->get_option("wpr_auto_login");


        switch ( $column ) {

            case 'form_id':
              echo '[wpr-form id='.$post_id.']';
              break;

            case 'auto_login':
              if ($login == 'yes') {
                  echo "Enable";
              }else{
               echo "Disable";
              }
              break;

            case 'profile':
              if ($profile == 'yes') {
                  echo "Enable";
              }else{
               echo "Disable";
              }
              break;

            case 'password':
              if ($pass == 'yes') {
                  echo "Enable";
              }else{
               echo "Disable";
              }
              break;
        }
    }

    // on user tab show user status column
    function account_status_change($account_status_val,$user_id) {
       
        if ($account_status_val == 'active') {
            $status_val     = 'active';
            $status_update  = 'inactive';
            $title          = 'click to change status inactive';

            $style          = 'background: rgb(87, 191, 67);
                           border-radius: 4px;
                           color: white;
                           display: block;
                           width: 50%;
                           height: 28px;
                           text-align: center;
                           padding-top: 8px;
                           cursor: pointer;';
        }else {

            $status_val     = 'inactive';
            $status_update  = 'active';
            $title          = 'click to change status active';
            $style          = 'background: rgba(234, 35, 20, 0.88);
                           border-radius: 4px;
                           color: white;
                           display: block;
                           width: 50%;
                           height: 28px;
                           text-align: center;
                           padding-top: 8px;
                           cursor: pointer;';
        }

        $status_url = admin_url("admin-post.php")."?action=wpr_update_status&userID={$user_id}&statusKey={$status_update}";
        $html  = '<a title="'.esc_attr($title).'" style="'.esc_attr($style).'" href="'.esc_url($status_url).'">'.$status_val.'</a>';
        return $html;
    }

     // Get woocommerce settings and check its activate
    function wpr_woocommerce_intigration() {
        
        $wc_intigrate = WPR_Settings()->get_option('wpr_wc_intigrate') != ''  ? WPR_Settings()->get_option('wpr_wc_intigrate') : 'no';

        if ($wc_intigrate == 'on') {
            if( class_exists('WooCommerce') ) {
                return $wc_intigrate;
            }else{
                return $wc_intigrate = 'no';
            } 
        }  
    }

    // account statsu admin side post 
     function wpr_update_user_status() {

        $user_id    = $_REQUEST['userID'];
        $status_key = $_REQUEST['statusKey'];

        update_user_meta($user_id ,'wpr_account_status' , $status_key);

        $redirect_to = add_query_arg('wpr_status', $status_key, admin_url("users.php"));

        wp_redirect( $redirect_to );
       
    }

/* -------------------------------------------------------------
    This function is use add the settings into WP Register CPT
/* ------------------------------------------------------------*/

    function wpr_add_admin_menu(){
       add_submenu_page(
           'edit.php?post_type=wpr',
           __('WP Registration', 'wp-registration'),
           __('Settings', 'wp-registration'),
           'manage_options',
           'wpr_settings',
           'wpr_options_page');
       }

    function wpr_options_page() {
        wpr_load_templates("admin/admin-setting.php");
    }

/*
*** 
*/

    /* -----------------------------------------------
     This metabox function use to display shorcodes 
     -----------------------------------------------*/
    function wpr_admin_shortcode_display_metabox(  ){
    
        add_meta_box( 
            'wpr_shortcodes',
            __( 'Shortcodes' , ' wp-registration'),
            'wpr_admin_shortcodes_display',
            'wpr',
            'side',
            'default'
        );
    }

    function wpr_admin_shortcodes_display(){

        // load shorcode templatse
        wpr_load_templates("admin/shortcode-render.php");
    }

/*
*** 
*/


    /*---------------------------------------------------------
     This metabox function use to display form general setting 
    -----------------------------------------------------------*/
    function wpr_admin_basic_setting_metabox(  ){
    
        add_meta_box( 
            'wpr_basic_settings',
            __( 'General Settings' , ' wp-registration'),
            'wpr_admin_basic_setting_rander',
            'wpr',
            'normal',
            'default'
        );
    }

    function wpr_admin_basic_setting_rander(  ){

        // load form general setting template
        wpr_load_templates("admin/form-general-setting.php" );

    }


/*
*** 
*/



    /*---------------------------------------------------------
     This metabox function use to display GDPR setting 
    -----------------------------------------------------------*/
    function wpr_consent_basic_setting_metabox(  ){
    
        add_meta_box( 
            'wpr_gdpr_settings',
            __( 'GDPR', ' wp-registration'),
            'wpr_consent_gdpr_settings',
            'wpr',
            'normal',
            'default'
        );
    }

    function wpr_consent_gdpr_settings(  ){

        // load GDPR settings template
        wpr_load_templates("admin/consent_settings.php" );

    }


/*
*** 
*/

    /*-----------------------------------------------------------------
     This metabox function use to display form template design setting 
    -------------------------------------------------------------------*/
    function wpr_admin_setting_design_form_metabox(  ){
    
        add_meta_box( 
            'wpr_style_setting',
            __( 'Design Form' , ' wp-registration'),
            'wpr_admin_setting_design_form',
            'wpr',
            'side',
            'default'
        );
    }

    function wpr_admin_setting_design_form(  ){

        // load form design template
        wpr_load_templates("admin/form-design-setting.php" );

    }

/*
*** 
*/

    /*------------------------------------------------------------------------
     This metabox function use to display form email template related setting  
    --------------------------------------------------------------------------*/
    function wpr_admin_setting_email_form_metabox(  ){
    
        add_meta_box( 
            'wpr_email_setting',
            __( 'Email Templates' , ' wp-registration'),
            'wpr_admin_setting_email_form',
            'wpr',
            'normal',
            'default'
        );
    }

    function wpr_admin_setting_email_form(  ){

        // load email template setting
        wpr_load_templates("admin/email.php");
    }

/*
*** 
*/

    /*---------------------------------------------------
     This function use to change forms title placeholder 
    -----------------------------------------------------*/
    function wpr_admin_change_title_text( $title ){
        $screen = get_current_screen();
      
        if  ( 'wpr' == $screen->post_type ) {
            $title = 'Enter New Form';
        }
            return $title;
    }

/*
*** 
*/

    /*-------------------------------------------------
     This save hook function use to save all form meta 
    ---------------------------------------------------*/

    function wpr_admin_save_form_fields($post_id, $update) {

        // If this is a revision, don't send the email.
        if ( wp_is_post_revision( $post_id ) )
            return;
     
        $form = new WPR_Form($post_id);

        // wpr_pa($_POST);  exit;
        
        if ( isset($_POST['wpr']) || isset($_POST['wpr_assign_user_role'])) {
            
            // @sir how to sentize array
            update_post_meta( $post_id, 'wpr_fields', $_POST['wpr']);
            update_post_meta( $post_id, 'wpr_assign_user_role', $_POST['wpr_assign_user_role']);
        }

        //all form setting keys saved array
        $form_setting = array (
                            // general setting
                            'wpr_form_heading', 
                            'wpr_button_label',
                            'wpr_msg_on_reg', 
                            'wpr_error_msg',
                            'wpr_auto_login', 
                            'wpr_new_user', 
                            'wpr_dash_access', 
                            'wpr_admin_bar',

                            // email-template
                        
                            'wpr_change_password_message',


                        // email-template
                           'wpr_email_header',
                           'wpr_new_user_email',
                           'wpr_wait_approval_email',
                           'wpr_on_approval_email',
                           'wpr_on_user_reject',
                           'wpr_pass_reset',
                           'wpr_email_footer',
                           'wpr_change_password_email',

                            // design_setting
                            'wpr_btn_label_clr',
                            'wpr_form_width',
                            'wpr_btn_bg_clr',
                            'wpr_form_bg_clr',
                            'wpr_label_size',
                            'wpr_btn_cls',
                            'wpr_form_css',
                            'wpr_icon_color',
                            'wpr_form_header_color',


                            //profile setting
                            'wpr_allow_banner',
                            'wpr_allow_pass',
                            'wpr_pr_bnr_clr',
                            'wpr_tab_bg_clr',
                            'wpr_pr_label_clr',
                            'wpr_pr_label_size',
                            'wpr_pr_photo_layout',
                            'wpr_cover_photo_width',
                            'wpr_cover_photo_height',
                            'wpr_profile_photo_width',
                            'wpr_profile_photo_height',

                            // email design setting
                            'wpr_email_hd_bg_clr',
                            'wpr_email_bofy_bg_clr',
                            'wpr_email_ft_bg_clr',
                            'wpr_email_font_clr',
                             'wpr_email_font_family',

                            //consent page
                            'wpr_consent',
                            'wpr_consent_url',
                            'wpr_consent_msg',
                            'wpr_delete_account',
                        );
                        
        // Saving settings in form meta
        
        foreach ($form_setting as $key) {
            
            if( isset($_POST[$key]) ) {
                
                $big_text = array('wpr_new_user_email','wpr_change_password_message','wpr_change_password_email');
                
                $sentized_val = '';
                if( in_array($key, $big_text)) {
                    $sentized_val = sanitize_textarea_field($_POST[$key]);
                }else{
                    $sentized_val = sanitize_text_field($_POST[$key]);
                }
                
                update_post_meta($post_id, $key, $sentized_val);
           }
        }
                    
    }

    
/*
*** 
*/

    /*--------------------------------------
     This function render all setting array 
    ----------------------------------------*/
   function wpr_get_admin_setting() {

        $wpr_setting_options = array(
            'General Settings' =>  array(
                array(
                    'type'         => 'select',
                    'id'           => 'wpr_user_notify',
                    'label'        => __("New User Notification", 'wp-registration'),
                    'description'  => __('Select member to send new user notification via email.', 'wp-registration'),
                    'options'     => wpr_send_notification_members(),
                ),
                array(
                    'type'          => 'text',
                    'id'            => 'wpr_login_url',
                    'label'         => __("After Login", 'wp-registration'),
                    'description'   => __('Enter the url to redirect after login.'),
                ),
                array(
                    'type'          => 'text',
                    'id'            => 'wpr_reg_url',
                    'label'         => __("After Registration", 'wp-registration'),
                    'description'   => __('Enter the url to redirect after the sing up.'),
                ),
                array(
                    'type'          => 'text',
                    'id'            => 'wpr_logout_url',
                    'label'         => __("After Logout", 'wp-registration'),
                    'description'   => __('Enter the url to redirect after logout.'),
                ),
                array(
                    'type'         => 'select',
                    'id'           => 'wpr_profile_link_base',
                    'label'        => __("Profile Link Base", 'wp-registration'),
                    'description'  => __('Select the link using show User Profile', 'wp-registration'),
                    'options'     => wpr_select_profile_link(),
                ),
            ),
            'Pages' =>  array(
                array(
                    'type'         => 'wpr_get_pages',
                    'id'           => 'wpr_core_page_profile',
                    'label'        => __("Profile Page", 'wp-registration'),
                    'description'  => __('Set Profile Page','
                                          wp-registration'),
                ),
                array(
                    'type'         => 'wpr_get_pages',
                    'id'           => 'wpr_core_page_account',
                    'label'        => __("Account Page", 'wp-registration'),
                    'description'  => __('Set account page.', 'wp-registration'),
                ), 
                array(
                    'type'         => 'wpr_get_pages',
                    'id'           => 'wpr_core_page_register',
                    'label'        => __("Register Page", 'wp-registration'),
                    'description'  => __('Set register page.', 'wp-registration'),
                ),
                array(
                    'type'         => 'wpr_get_pages',
                    'id'           => 'wpr_core_page_login',
                    'label'        => __("Login Page", 'wp-registration'),
                    'description'  => __('Set login page.', 'wp-registration'),
                ),
                array(
                    'type'         => 'wpr_get_pages',
                    'id'           => 'wpr_core_page_logout',
                    'label'        => __("Logout Page", 'wp-registration'),
                    'description'  => __('Set logout page.', 'wp-registration'),
                ),
                array(
                    'type'         => 'wpr_get_pages',
                    'id'           => 'wpr_core_page_password_reset',
                    'label'        => __("Password Reset Page", 'wp-registration'),
                    'description'  => __('Set password Reset page.', 'wp-registration'),
                ),
            ), 
            'How To Use' =>  array(
                    array(
                        'type'      => 'file',  
                    ),
            ),
        );
        
        return apply_filters( 'wpr_options', $wpr_setting_options);
    }

    function wpr_admin_show_notices() {

        $class   = '';
        $message = '';
        if( isset($_GET['wpr_status']) && $_GET['wpr_status'] == 'inactive') {
            
            $class = 'notice notice-error';
            $message = __( 'User status updated to '.$_GET['wpr_status'] );
        } elseif(isset($_GET['wpr_status']) && $_GET['wpr_status'] == 'active') {
            
            $class = 'notice notice-success';
            $message = __( 'User status updated to '.$_GET['wpr_status'] );
        }

        printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
    }