<?php 

/**
 * Customizer settings
 *
 * @package cartel
 */

if ( ! function_exists( 'cartel_theme_customizer' ) ) :
  function cartel_theme_customizer( $wp_customize ) {

    /* Homepage Sections */
    $wp_customize->add_section( 'cartel_post_section' , array(
      'title'       => __( 'Post Template', 'cartel' ),
      'priority'    => 30,
    ) );
    
    $wp_customize->add_setting( 'cartel_post_template', array(
      'default' => 'wside',
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'cartel_sanitize_select',
    ));
    
    $wp_customize->add_control( 'cartel_post_template', array(
      'settings' => 'cartel_post_template',
      'label' => __( 'Select template:', 'cartel' ),
      'section' => 'cartel_post_section',
      'type' => 'select',
      'choices' => array(
        'wside' => __('With Sidebar (Default)', 'cartel' ),
        'full' => __('Fullwidth', 'cartel' ),
      ),
    ));

    
    /* color scheme option */
    $wp_customize->add_setting( 'cartel_color_settings', array (
      'default' => '#000',
      'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cartel_color_settings', array(
      'label'    => __( 'Accent Color', 'cartel' ),
      'section'  => 'colors',
      'settings' => 'cartel_color_settings',
    ) ) );
  
  }
endif;
add_action('customize_register', 'cartel_theme_customizer');


/**
 * Sanitize checkbox
 */
if ( ! function_exists( 'cartel_sanitize_checkbox' ) ) :
  function cartel_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
      return 1;
    } else {
      return '';
    }
  }
endif;

/**
 * Sanitize text field html
 */
if ( ! function_exists( 'cartel_sanitize_field_html' ) ) :
  function cartel_sanitize_field_html( $str ) {
    $allowed_html = array(
    'a' => array(
    'href' => array(),
    ),
    'br' => array(),
    'span' => array(),
    );
    $str = wp_kses( $str, $allowed_html );
    return $str;
  }
endif;

if ( ! function_exists( 'cartel_sanitize_dropdown_pages' ) ) :
  function cartel_sanitize_dropdown_pages( $page_id, $setting ) {
    // Ensure $input is an absolute integer.
    $page_id = absint( $page_id );

    // If $page_id is an ID of a published page, return it; otherwise, return the default.
    return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
  }
endif;

function cartel_sanitize_select( $input, $setting ){
      
    //input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
    $input = sanitize_key($input);

    //get the list of possible select options 
    $choices = $setting->manager->get_control( $setting->id )->choices;
                     
    //return input if valid or return default option
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );                
     
}