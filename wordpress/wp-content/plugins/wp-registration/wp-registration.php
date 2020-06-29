<?php 
/*
Plugin Name: N-Media WP Member Registration
Plugin URI: http://www.najeebmedia.com
Description: This plugin allow users to register, login and reset password using ajax based forms. Admin can attach unlimited user meta fields. User can update their profile using without going into admin dashboard.
Version: 5.0
Author: Najeeb Ahmad
Text Domain: wp-registration
Author URI: http://www.najeebmedia.com/
*/

// exit if accessed directly
if( ! defined('ABSPATH' ) ){
    exit;
}

define( 'WPR_PATH', untrailingslashit(plugin_dir_path( __FILE__ )) );
define( 'WPR_URL', untrailingslashit(plugin_dir_url( __FILE__ )) );
define( 'WPR_VERSION', 5.0);
define( 'WPR_DEBUG', true );
define( 'LOG_FILE', "./wpr-log.log");


/* ======= plugin includes =========== */
if( file_exists( dirname(__FILE__).'/inc/helpers.php' )) include_once dirname(__FILE__).'/inc/helpers.php';
if( file_exists( dirname(__FILE__).'/inc/cpt.php' )) include_once dirname(__FILE__).'/inc/cpt.php';
if( file_exists( dirname(__FILE__).'/inc/hooks.php' )) include_once dirname(__FILE__).'/inc/hooks.php';
if( file_exists( dirname(__FILE__).'/inc/admin.php' )) include_once dirname(__FILE__).'/inc/admin.php';
if( file_exists( dirname(__FILE__).'/inc/shortcodes.php' )) include_once dirname(__FILE__).'/inc/shortcodes.php';
if( file_exists( dirname(__FILE__).'/inc/classes/class.settings.php' )) include_once dirname(__FILE__).'/inc/classes/class.settings.php';
if( file_exists( dirname(__FILE__).'/inc/classes/class.font-icon.php' )) include_once dirname(__FILE__).'/inc/classes/class.font-icon.php';
if( file_exists( dirname(__FILE__).'/inc/classes/class.form.php' )) include_once dirname(__FILE__).'/inc/classes/class.form.php';
if( file_exists( dirname(__FILE__).'/inc/classes/class.field-meta.php' )) include_once dirname(__FILE__).'/inc/classes/class.field-meta.php';
if( file_exists( dirname(__FILE__).'/inc/classes/class.user.php' )) include_once dirname(__FILE__).'/inc/classes/class.user.php';
if( file_exists( dirname(__FILE__).'/inc/classes/class.email.php' )) include_once dirname(__FILE__).'/inc/classes/class.email.php';
if( file_exists( dirname(__FILE__).'/inc/classes/class.register.php' )) include_once dirname(__FILE__).'/inc/classes/class.register.php';
if( file_exists( dirname(__FILE__).'/inc/classes/class.field.php' )) include_once dirname(__FILE__).'/inc/classes/class.field.php';
if( file_exists( dirname(__FILE__).'/inc/classes/class.profile.php' )) include_once dirname(__FILE__).'/inc/classes/class.profile.php';
if( file_exists( dirname(__FILE__).'/inc/classes/class.wpr-api.php' )) include_once dirname(__FILE__).'/inc/classes/class.wpr-api.php';
if( file_exists( dirname(__FILE__).'/inc/classes/class.restriction.php' )) include_once dirname(__FILE__).'/inc/classes/class.restriction.php';
if( file_exists( dirname(__FILE__).'/inc/classes/class.dashboard.php' )) include_once dirname(__FILE__).'/inc/classes/class.dashboard.php';
if( file_exists( dirname(__FILE__).'/inc/classes/class.member_directory.php' )) include_once dirname(__FILE__).'/inc/classes/class.member_directory.php';
if( file_exists( dirname(__FILE__).'/inc/classes/class.login.php' )) include_once dirname(__FILE__).'/inc/classes/class.login.php';
// if( file_exists( dirname(__FILE__).'/inc/classes/class.deactivate.php' )) include_once dirname(__FILE__).'/inc/classes/class.deactivate.php';
include_once WPR_PATH . "/inc/class.deactivate.php";

if( defined('WPR_PATH_PRO') ) {
    // Libraries
    if( file_exists( WPR_PATH_PRO.'/inc/recaptcha.php' )) include_once WPR_PATH_PRO.'/inc/recaptcha.php';
    if( file_exists( WPR_PATH_PRO.'/lib/class.mailchimp.php' )) include_once WPR_PATH_PRO.'/lib/class.mailchimp.php';
    if( file_exists( WPR_PATH_PRO.'/lib/class.sendinblue.php' )) include_once WPR_PATH_PRO.'/lib/class.sendinblue.php';
}


class WPR_MAIN {

    private static $ins = null;
    
    function __construct(){


        if( !session_id() )
        {
            session_start();
        }


         
        // Will handle all error messages
        add_action( 'init', 'wpr_cpt_register_post', 3);
        
        add_action( 'init', array($this, 'setup_defaults'), 2 );

        $this->errors = array();

        // hide admin bar only for frentend side
        WPRRESTRICT()->hide_admin_bar();

        // // Restrict WP Dashboard access by role via settings
        WPRRESTRICT()->restrict_dashboard();

        // filter add for logout url
        add_filter( 'logout_url','wpr_handle_logout_redirect', 10, 2 );

        // actation run on plugin initialized
        /**
         * =====================================
         * Admin releated hooks and action 
         * =====================================
        **/
         
        add_action( 'admin_notices', 'wpr_admin_show_notices' );

        add_action( 'add_meta_boxes', 'wpr_admin_shortcode_display_metabox' );
        add_action( 'add_meta_boxes', 'wpr_admin_basic_setting_metabox' );

        //GDPR
        add_action( 'add_meta_boxes', 'wpr_consent_basic_setting_metabox' );
    
       
        // delete this
        add_action( 'save_post_wpr',  'wpr_admin_save_form_fields', 10, 3 );


        add_action( 'wp_ajax_wpr_saved_meta_data', 'wpr_saved_meta_data' );

        
        add_shortcode( 'wpr-login', 'wpr_shortcodes_render_login' );
        add_shortcode( 'wpr-form', 'wpr_shortcodes_render_signup' );
        add_shortcode( 'wpr-password-reset', 'wpr_shortcodes_render_password_reset' );

         // wpr settings related hooks
        add_action( 'admin_menu', 'wpr_add_admin_menu' );
        add_filter( 'enter_title_here', 'wpr_admin_change_title_text' );

        //acount_status admin side post
        add_action( 'admin_post_wpr_update_status', 'wpr_update_user_status' );

        //dashboard change postion
        add_action( 'admin_enqueue_scripts', 'custom_register_admin_scripts' );

        
        // frontend form submitted hook
        add_action( 'wp_ajax_wpr_submit_form', 'wpr_hooks_submit_form' );
        add_action( 'wp_ajax_nopriv_wpr_submit_form', 'wpr_hooks_submit_form' );
        


        if ( is_user_logged_in() && ! empty( $_GET['DeleteMyAccount'] ) ) {
            add_action( 'init', 'wpr_remove_logged_in_user' );
        }
        
    
        add_action( 'wpr_before_submit_button', 'wpr_hooks_gdpr_options', 10, 1);

        // Localize permalink
        add_filter("wpr_localize_permalinks","wpr_localize_permalinks", 10, 2);
    

        /**
        ** Setup Pages and Form
        ** 1- Default Signup form
        ** 2- Default pages
        ** 2.1- Login
        ** 2.2- Register
        ** 2.3- Account
        ** 2.4- Profile
        **/
        
    }

    function setup_defaults() {
        
        // Debugging
        // delete_option('wpr_is_installed'); 
        // delete_option('wpr_default_signup_form');
        // delete_option('wpr_core_pages');
        // return;
        
        // setup registation form
        $this -> install_default_form();

        // setup default pages.
        $this -> install_default_pages();
        
        // catch errors
        $this -> catch_errors();
        
        // Language support
        $locale_dir = dirname( plugin_basename( dirname(__FILE__) ) ) . '/languages';
		load_plugin_textdomain('wpr', false, $locale_dir);
    }

    // Default registartion form setup function
    function install_default_form() {

        $default_form_id = get_option('wpr_default_signup_form');

        
        if( get_option('wpr_is_installed') != '1' ) {

           /**
                If page does not exist
                Create it
            **/

            if ( ! $default_form_id ) {

                $form = array(
                    'post_type'         => 'wpr',
                    'post_title'        => 'Default Registration',
                    'post_status'       => 'publish',
                    'post_author'       => wpr_get_current_user_id(),
                );

                $form_id = wp_insert_post( $form );

                update_option('wpr_default_signup_form', $form_id);
                foreach( wpr_set_defualt_form_array() as $key => $value ) {
                    if ( $key == 'wpr_fields' ) {
                        $array = unserialize( $value );
                        update_post_meta( $form_id, $key, $array );
                    } else {
                        update_post_meta($form_id, $key, $value);
                    }
                }

                $this->setup_shortcode['register'] = wpr_get_default_signup_shortcode();
            }
        }


    }


    function install_default_pages(){
        
        if( get_option('wpr_is_installed') != '1' ) {

            // install it
            update_option('wpr_is_installed', 1);
            // Install Core Pages
            foreach(wpr_set_defualt_pages_array() as $slug => $array ) {

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
                        $content =  $this->setup_shortcode['register'];
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
                update_option('wpr_core_pages', $core_pages);
                foreach( $core_pages as $o_slug => $page_id ) {
                    $corpage_name = 'wpr_core_page_'.$o_slug;
                    WPR_Settings()->set_option($corpage_name, $page_id);
                }
            }
        }
    }
    
    // Catch errors
    function catch_errors() {
        
        
        if( !isset($_GET['wpr_error']) ) return;
        
        switch( $_GET['wpr_error'] ) {
            
            case 'invalidcombo':
                $this->errors['invalidcombo'] = __('<strong>ERROR</strong>: Invalid username or email.', 'wpr');
                break;
            case 'empty_username':
                $this->errors['empty_username'] = __('<strong>ERROR</strong>: Enter a username or email address.', 'wpr');
                break;
            case 'invalid_login':
                $this->errors['invalid_login'] = __( '<strong>ERROR</strong>: Invalid username, email address or incorrect password.', 'wpr');
                break;
        }
    }
    
    public static function get_instance() {
          // create a new object if it doesn't exist.
        is_null(self::$ins) && self::$ins = new self;
        return self::$ins;
    }
}

// lets start plugin
add_action('plugins_loaded', 'wpr_start');
function wpr_start() {
    return WPR_MAIN::get_instance();
}

if( is_admin() ) {
    WPR_Settings();
}