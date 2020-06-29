<?php 
/*
*** Here is all shortcodes callbacks
*/

    // not run if accessed directly
    if( ! defined('ABSPATH' ) ){
        die("Not Allowed");
    }

/*---------------------------------------------------
this function use to render the login form shortcodes
-----------------------------------------------------*/
function wpr_shortcodes_render_login($attr){

    // css file load
    wp_register_style('wpr-bootstrap', WPR_URL."/css/bootstrap.min.css");
    wp_register_style('wpr-style', WPR_URL."/css/wpr-frontend.css");
    wp_register_style('wpr-font', WPR_URL."/css/font-awesome/css/font-awesome.css");
    wp_register_style('wpr-sweetalert-style', WPR_URL."/css/sweetalert.css");
    
    wp_enqueue_style( 'wpr-bootstrap' );
    wp_enqueue_style( 'wpr-style' );
    wp_enqueue_style( 'wpr-font' );
    wp_enqueue_style( 'wpr-sweetalert-style' );


    global $wp_scripts;

       
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
        
    wp_register_script('wpr-sweetalert-js', WPR_URL."/js/sweetalert.js", array('jquery'), WPR_VERSION, true);
    wp_register_script('wpr-script', WPR_URL."/js/wpr-frontend.js", array('jquery'), WPR_VERSION, true);  
    
    wp_enqueue_script( 'wpr-sweetalert-js' );
    wp_enqueue_script( 'wpr-script' );
    
    // ajax load
    wp_localize_script( 'wpr-script', 'wpr_vars', array(
      'ajax_url' => admin_url( 'admin-ajax.php') ,
    ));

    ob_start();        
    wpr_load_templates("shortcodes/login.php");
    $html = ob_get_clean(); 
    
    return $html;
}


/*----------------------------------------------------------
this function use to render the lost pasword form shortcodes
-------------------------------------------------------------*/
function wpr_shortcodes_render_password_reset($attr){

    // css file load
    wp_register_style('wpr-bootstrap', WPR_URL."/css/bootstrap.min.css");
    wp_register_style('wpr-style', WPR_URL."/css/wpr-frontend.css");
    wp_register_style('wpr-font', WPR_URL."/css/font-awesome/css/font-awesome.css");
    wp_register_style('wpr-sweetalert-style', WPR_URL."/css/sweetalert.css");
    
    wp_enqueue_style( 'wpr-bootstrap' );
    wp_enqueue_style( 'wpr-style' );
    wp_enqueue_style( 'wpr-font' );
    wp_enqueue_style( 'wpr-sweetalert-style' );
        
    // js files load
    wp_register_script('wpr-sweetalert-js', WPR_URL."/js/sweetalert.js", array('jquery'), WPR_VERSION, true);
    wp_register_script('wpr-script', WPR_URL."/js/wpr-frontend.js", array('jquery'), WPR_VERSION, true);     
    
    
    wp_enqueue_script( 'wpr-sweetalert-js' );
    wp_enqueue_script( 'wpr-script' );
    
    // ajax load
    wp_localize_script( 'wpr-script', 'wpr_vars', array(
      'ajax_url' => admin_url( 'admin-ajax.php') ,
    ));

     $form       = new WPR_Form(7);
     $template_vars  = array();
    $template_vars = array('form' => $form);
    ob_start();        
    // wpr_load_templates("email/template.email.php", $template_vars);
    wpr_load_templates("shortcodes/password-reset.php");
    $html = ob_get_clean(); 
    
    return $html;
}


/*---------------------------------------------------
this function use to render the signup form shortcodes
-----------------------------------------------------*/
function wpr_shortcodes_render_signup($atts){


    $wpr_params = shortcode_atts(
    array(
        'id' => null,        
    ), $atts );

    $form_id = $wpr_params['id'];
    if( $form_id == null ) die( __("No form id found","wpr-registration") );

    // css file load
    wp_register_style('wpr-bootstrap', WPR_URL."/css/bootstrap.min.css");
    wp_register_style('wpr-style', WPR_URL."/css/wpr-frontend.css");
    wp_register_style('wpr-font', WPR_URL."/css/font-awesome/css/font-awesome.css");
    wp_register_style('wpr-sweetalert-style', WPR_URL."/css/sweetalert.css");
    wp_register_style('wpr-fr-icon-ii', WPR_URL."/css/wpr-fonticons-ii.css");
    wp_register_style('wpr-fr-icon-fa', WPR_URL."/css/wpr-fonticons-fa.css");
    
    wp_enqueue_style( 'wpr-bootstrap' );
    wp_enqueue_style( 'wpr-style' );
    wp_enqueue_style( 'wpr-font' );
    wp_enqueue_style( 'wpr-sweetalert-style' );
    wp_enqueue_style( 'wpr-fr-icon-ii' );
    wp_enqueue_style( 'wpr-fr-icon-fa' );


    // js files load
    wp_register_script('wpr-script', WPR_URL."/js/wpr-frontend.js", array('jquery'), WPR_VERSION, true);
    wp_register_script('wpr-sweetalert-js', WPR_URL."/js/sweetalert.js", array('jquery'), WPR_VERSION, true);
    wp_register_script('wpr-lib', WPR_URL."/js/wpr-lib.js", array('jquery'), WPR_VERSION, true);
    
    
    wp_enqueue_script( 'wpr-script' );
    wp_enqueue_script( 'wpr-sweetalert-js' );
    wp_enqueue_script( 'wpr-lib' );
    

    $form       = new WPR_Form($form_id);
    $form_title = $form->get_option('wpr_form_heading');
    $wpr_form_css = $form->get_option('wpr_form_css');
    if( !empty($wpr_form_css) ) {
        wp_add_inline_style( 'wpr-style', $wpr_form_css );
    }
    
    $error_msg  = $form->get_option('wpr_error_msg') == ''? 'Check all error message': $form->get_option('wpr_error_msg');
    
    $form_width = $form->get_option('wpr_form_width') == ''? '70%':$form->get_option('wpr_form_width');
    $form_bg_clr = $form->get_option('wpr_form_bg_clr') == ''? '#fffff':$form->get_option('wpr_form_bg_clr');
    $form_header_color = $form->get_option('wpr_form_header_color') == ''? '#fffff':$form->get_option
                    ('wpr_form_header_color');
    // $form_bg_clr = $form->get_option('wpr_icon_color') == ''? '#2dad2d':$form->get_option('wpr_icon_color');

    // ajax load
    wp_localize_script( 'wpr-script', 'wpr_vars', array(
      'ajax_url'    => admin_url( 'admin-ajax.php') ,
      'error_msg'   => $error_msg,
    ));

    $html = '';
    $html .= '<div id="wpr-wrapper">';    
        $html .= '<div class="wpr-field-model" style="width:'.esc_attr($form_width).'; background:'.esc_attr($form_bg_clr).';">';
        $html.='<h2 class="wpr-form-title" style="background:'.esc_attr($form_header_color).';">'.sprintf(__("%s","wp-registration"),$form_title).'</h2>';
            $html .= '<div class="wpr_model_selector">';    

            $form_template  = '';
            $template_vars  = array();
                    $template_vars = array('form' => $form);
                    $form_template = 'forms/registration.php';
            
                ob_start();        
                wpr_load_templates($form_template, $template_vars);
                $html .= ob_get_clean();     
            $html .= '</div>';
        $html .= '</div>';
    $html .= '</div>';
    
    return $html;
}