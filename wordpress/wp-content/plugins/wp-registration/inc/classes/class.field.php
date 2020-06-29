<?php
/**
 * File Meta Manager Class
 **/
 
 if( ! defined('ABSPATH') ) die('Not Allowed');
 
class WPR_Meta {
 
    private static $ins;
    
    function __construct() {
              
        // scripts and styles
         add_action('admin_enqueue_scripts', array($this, 'add_scripts'));

        // create meta boxes for registration field
         add_action( 'add_meta_boxes', array($this,'admin_registration_field_metabox') );
    }
    
    public static function get_instance() {
        // create a new object if it doesn't exist.
        is_null(self::$ins) && self::$ins = new self;
        return self::$ins;
    }


    // registration field metabox callback function
    function admin_registration_field_metabox(  ){
    
        add_meta_box( 
            'wpr_fields_id',
            __( 'Registration Fields' , ' wp-registration'),
            array($this,'admin_registration_fields_display'),
            'wpr',
            'normal',
            'default'
        );
    }
    
    // all related script enqueue
    function add_scripts($hook) {
      
        global $post;
        
        if ( $hook == 'user-edit.php') {
            wp_enqueue_script('WPR-field', WPR_URL."/js/wpr-admin.js", array('jquery'), WPR_VERSION, true);
            
        }
        
        if( ($hook != 'post.php' && $hook != 'post-new.php') || $post->post_type != 'wpr')
            return '';
        // Bootstrap
        wp_enqueue_style('WPR-bs', WPR_URL."/css/bootstrap.min.css");
        wp_enqueue_script('WPR-bs', WPR_URL."/js/bootstrap.min.js", array('jquery'), WPR_VERSION, true);

        //wpr css and js for admin site
        wp_enqueue_style('WPR_field', WPR_URL."/css/wpr-admin.css");
        wp_enqueue_script('WPR-field', WPR_URL."/js/wpr-admin.js", array('jquery'), WPR_VERSION, true);
        
        // wordpress color picker
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');

        // font-awesome and ionic icons 
        wp_enqueue_style('WPR-fontawsome', WPR_URL."/css/font-awesome/css/font-awesome.css");
        wp_enqueue_style('WPR-icon-ii', WPR_URL."/css/wpr-fonticons-ii.css");
        wp_enqueue_style('WPR-icon-fa', WPR_URL."/css/wpr-fonticons-fa.css");
        
        // Swal
        wp_enqueue_style('WPR-swal', WPR_URL."/css/sweetalert.css");
        wp_enqueue_script('WPR-swal', WPR_URL."/js/sweetalert.js", array('jquery'), WPR_VERSION, true); 
        
        
        
        //select2
        wp_enqueue_style('WPR-select2', WPR_URL."/css/select2.css");
        wp_enqueue_script('WPR-select2', WPR_URL."/js/select2.js", array('jquery'), WPR_VERSION, true);

        wp_enqueue_script('WPR-ckeeditor', "https://cdn.ckeditor.com/4.9.2/standard/ckeditor.js" , array('jquery'), WPR_VERSION, true);

        // codemirror files
        wp_enqueue_style('sccss-codemirror-css', WPR_URL."/js/codemirror/codemirror.min.css");
        wp_enqueue_script('sccss-codemirror-js', WPR_URL."/js/codemirror/codemirror.js", array('jquery'), WPR_VERSION, true);
        wp_enqueue_script('sccss-codemirror-css-js', WPR_URL."/js/codemirror/css.js", array('jquery'), WPR_VERSION, true);
    }

    // render registration field template
    function admin_registration_fields_display(){
        wpr_load_templates('admin/fields.php', array('meta'=>$this));
    }
    
    // render all fields setting here
    function render_field_settings() {
        
        $meta_key = 0;
        
        $wpr_fields = $this->meta_array();
        
        $html = '<div id="wpr-fields-wrapper">';
        foreach($wpr_fields as $field_id => $setting) {

            $field_title = $setting['title'];
            $field_description = $setting['description'];

            $html .= '<div class="modal fade wpr-slider wpr-arrange-trash wpr-copy-fields-0 wpr-field-'.esc_attr($field_id).'" role="dialog" data-backdrop="static" data-keyboard="false">';
                $html   .='<div class="modal-dialog">';
                    $html   .= '<div class="modal-content">';
                        $html .= '<div class="modal-header">';
                            $html .= '<h4 class="modal-title">'.sprintf(__("%s","wp-registration"),$field_title).'</h4>';
                        $html .= '</div>';
                        $html .= '<div class="modal-body">';
                            $html  .= '<div class="">';
                                $html .= $this->render_field_meta($setting['field_meta'], $field_id);
                            $html .= '</div>';
                        $html .= '</div>';
                        $html .= '<div class="modal-footer">';
                            $html .='<span class="wpr-req-field-id"></span>';
                            $html .= '<button type="button" class="btn btn-default wpr-close-checker wpr-close-fields" data-dismiss="modal">'.esc_html__( 'close', 'wp-registration' ).'</button>';
                            $html .= '<button type="button" class="btn btn-primary wpr-field-checker  wpr-add-field" data-field-type="'.esc_attr($field_title).'">'.esc_html__( 'Add Field', 'wp-registration' ).'</button>';
                        
                       $html .= '</div>';
                    $html .= '</div>';
                $html .= '</div>';
            $html .= '</div>';

        $meta_key++;
        }

        $html .= '</div>';
        echo $html;
    }

    // render all field meta here
    function render_field_meta($field_meta, $field_id, $field_index='', $save_meta='') {

        $html = '<table class="form-table wpr-pd" data-table-id="'.esc_attr($field_id).'">';

        if ($field_meta) {
            
        foreach ($field_meta as $id => $meta) {
            
            // $data_name  = $meta['data_name'];
            $title      = isset($meta['title']) ? $meta['title'] : '';
            $desc       = isset($meta['desc']) ? $meta['desc'] : '';   
            $type       = isset($meta['type']) ? $meta['type'] : '';

            $values = isset($save_meta[$id]) ? $save_meta[$id] : '';


            $html .= '<tr data-meta-id="'.esc_attr($id).'">';

            $html .= '<td class="wpr-col-title">'.sprintf(__("%s","wp-registration"),$title).'</td>';
            
            $html .= '<td>'.$this->render_input($id, $meta, $field_id, $field_index, $values).'</td>';

            $html .= '<td class="wpr-meta-field-desc">'.sprintf(__("%s","wp-registration"),$desc).'</td>';

            $html .= '</tr>';
        }
      }

        $html .= '</table>';

        return $html;        
    }

    // all inputs render
    function render_input($id, $meta, $field_id, $field_index, $value){
        
        $wpr_fonticons =new WPR_FontIcons();
        $options     = isset($meta['options']) ? $meta['options'] : array();
        $default     = isset($meta['default']) ? $meta['default'] : '';
        $value = ($value == '') ? $default : $value;
        // wpr_pa($meta);
        $existing_name = 'name="wpr['.esc_attr($field_index).']['.esc_attr($field_id).']['.esc_attr($id).']"';
        $meta_type  = $meta['type'];
        if (!is_array($value)) {
            $checkbox_value = checked( $value , 'on' , false);
        } else {
            $checkbox_value = '';
        }
        $html = '';
        
       switch ($meta_type) {
           
       case 'text':
           $html .= '<input type="text" class="wpr-meta-field wpr_inputs_design" data-metatype="'.esc_attr($id).'" value= "'.esc_attr($value).'"';
              if( $field_index != '') {

                  $html .= $existing_name;
                }
              $html .= '>';
           break;

       case 'checkbox':
           $html .= '<input type="checkbox" class="wpr-meta-field wpr_inputs_design" data-metatype="'.esc_attr($id).'" value="on" ';
                if( $field_index != '') {
                  $html .= $existing_name;
                }
           $html .= '"'.esc_attr($checkbox_value).'">';
           break;

       case 'radio':
           $html .= '<input type="radio" class="wpr-meta-field wpr_inputs_design" data-metatype="'.esc_attr($id).'">';
           break;

       case 'wp_color':
           $html .= '<input style="border-color: #c3b9b9cc;" type="wp_color" class="wpr-meta-field" class="wpr-meta-field" data-metatype="'.esc_attr($id).'">';
           break;

       case 'select':
               $html .= '<select class="wpr-select-design wpr-meta-field sl_check" data-metatype="'.esc_attr($id).'"';
                if( $field_index != '') {
                    $html .= $existing_name;
                }
               $html .= '>';
                    foreach($options as $val => $text) {
                        $html .= '<option value="'.esc_attr($val).'" ' . selected( $value, $val, false). '>'.$text.'</option>';
                    }
                   
                   $html .= '</select>';
                   
               break;

        case 'add_options':

                $html .= $this->add_options($id, $value, $field_id, $field_index);
                break; 
        case 'icon':

                $html .= $wpr_fonticons->wpr_icons_render($id, $value, $field_id, $field_index);
                break;

        case 'sp_roles':

                $html .= $this->privacy_sp_roles($id, $value, $field_index, $field_id);
        break;

       }
               

       return $html;
   }

    // this function all privacy roles
    function privacy_sp_roles($id, $value, $field_index, $field_id) {
        $_roles = get_editable_roles();
        $html  = '<span class="wpr_roles_set">';
        $html .= '<select class="privacy_check wpr-meta-pr-role" multiple style="width: 190px;" data-metatype="'.esc_attr($id).'"';
        if( $field_index != '') {
            $html .= 'name="wpr['.esc_attr($field_index).']['.esc_attr($field_id).']['.esc_attr($id).'][]"';
        }
        $html .='>';
        foreach ($_roles as $rols => $role_name) {
            $selected = '';
              if( !empty($value) ) {
                $selected = in_array($rols, $value) ? 'selected="selected"' : '';
            }
        $html .= '<option value="'.esc_attr($rols).'" '.$selected.'>'.sprintf(__("%s","wp-registration"),$rols).'</option>';
        }
        $html .= '</select>';
        $html .= '</span>';

       return $html;
    }
   
    // adding forms options for checkbox, radio, select etc.
    function add_options($id, $value=array(), $field_id, $field_index){
        if( empty($value) ) {
            $value = array(__('Option', 'wp-registration'));
        }
        $add_opt_index = 0;
        $html = '<div class="wpr_multi_option_area" data-opt-ex="'.esc_attr($field_index).'">';
        if (is_array($value)) {
            foreach ($value as $opt_index => $opt_val) {
                $existing_name = 'name="wpr['.esc_attr($field_index).']['.esc_attr($field_id).']['.esc_attr($id).']['.esc_attr($opt_index).']"';
                $html .= '<div class="wpr_copy_field_option input-group" style="Width:100%">';
                    $html .= '<input class="wpr-meta-field-opt" type="text" data-metatype="'.esc_attr($id).'" value="'.esc_attr($opt_val).'"';
                        if( $field_index != '') {
                            $html .= $existing_name;
                        }

                    $html .= ' style="width: 100%;">';
                    $add_opt_index =  $opt_index;
                    $add_opt_index++;
            }
            
        }
                    $html .= '<span class="input-group-btn">';
                        $html  .= '<button class="btn btn-success btn-add wpr_add_multi_option btn-sm" type="button" data-field-type="'.esc_attr($field_id).'" style="height:26px;">';
                           $html .=   '<i class="fa fa-plus" aria-hidden="true"></i>';
                        $html .= '</button>';
                    $html  .=  '</span>';
                $html .= '</div>';
                $html .='<input type="hidden" id="meta-opt-index" value="'.esc_attr($add_opt_index).'">';
        $html .='</div>';
        return $html;
    }
    

    //get fields title
    function meta_title(){
    
        return array (
                'type' => 'text',
                'title'=> __ ( 'Title', 'wp-registration' ),
                'desc' => __ ( 'It will be shown as field label', 'wp-registration' ),
                'default' => '',
            );
    }
    
    // get fields data name
    function meta_data_name(){
        return array (
                'type'  => 'text',
                'title' => __ ( 'Field ID', 'wp-registration' ),
                'desc'  => __ ( 'REQUIRED: The identification name of this field, that you can insert into body email configuration. Note:Use only lowercase characters and underscores.', 'wp-registration' )
            );
    }
    
    
    // get fields description
    function meta_desc(){
      return  array (
                'type'  => 'text',
                'title' => __ ( 'Description', 'wp-registration' ),
                'desc'  => __ ( 'Small description, it will be diplay near name title.', 'wp-registration' ) 
            );
    }
    
    // get fields error message
    function meta_error_message(){
       return array (
                    'type'  => 'text',
                    'title' => __ ( 'Error message', 'wp-registration' ),
                    'desc'  => __ ( 'Insert the error message for validation.', 'wp-registration' ) 
                );
    }
    
    // get fields required option
    function meta_required(){
    
        return array (
                'type'  => 'checkbox',
                'title' => __ ( 'Required', 'wp-registration' ),
                'desc'  => __ ( 'Select this if it must be required.', 'wp-registration' ) 
            );
    }

    // get fields required option
    function meta_email_required(){
    
        return array (
                'type'  => 'checkbox',
                'title' => __ ( 'Send in email', 'wp-registration' ),
                'desc'  => __ ( 'Select this if you send in email.', 'wp-registration' ) 
            );
    }
    
    // get fields classes
    function meta_class(){
       return  array (
                'type'  => 'text',
                'title' => __ ( 'Class', 'wp-registration' ),
                'desc'  => __ ( 'Insert an additional class(es) (separateb by comma) for more personalization.', 'wp-registration' ) 
                );
        
    }
    
    // get fields width for col
    function meta_width(){
        return array (
                'type'    => 'select',
                'title'   => __ ( 'Width', 'wp-registration' ),
                'desc'    => __ ( 'Select column for this field from 12 columns Grid', 'wp-registration' ), 
                'options' => $this->input_cols(),
                'default' => '12',
            );
    }
    
    function input_cols() {
        
        $wpr_cols = array(  4=>'4 Col',
                            5=>'5 Col',
                            6=>'6 Col',
                            7=>'7 Col',
                            8=>'8 Col',
                            9=>'9 Col',
                            10=>'10 Col',
                            11=>'11 Col',
                            12=>'12 Col'
                        );
        
        return apply_filters('wpr_field_cols', $wpr_cols);
    }
    
    
    // get fields add options for select
    function meta_add_options(){
        return array (
                'type'  => 'add_options',
                'title' => __ ( 'Add options', 'wp-registration' ),
                'desc'  => __ ( 'Enter multiple options.', 'wp-registration' )
            );
    }
    
    // get fields selected options that already selected for select and radio fields
    function meta_defualt_options() {
        return array (
                    'type'  => 'text',
                    'title' => __ ( 'Defualt selected Option', 'wp-registration' ),
                    'desc'  => __ ( 'Type option name (given above) if you want already selected.', 'wp-registration' ) 
                );
    }
    
    // get fields options that already selected for checkbox and autocomlete fields
    function meta_check_option() {
        return array (
                    'type'  => 'text',
                    'title' => __ ( 'Checked option(s)', 'wp-registration' ),
                    'desc'  => __ ( 'Type each option(s) name seprated by comma(e,g option1, option2) if you want already checked.', 'wp-registration' ) 
                );
    }
    
    // get minimum checkbox is checked for checkbox fields
    function meta_width_min_check() {
        return array (
                    'type'  => 'text',
                    'title' => __ ( 'Min checked option(s)', 'wp-registration' ),
                    'desc'  => __ ( 'How many options can be checked by user e.g: 2. Leave blank for default.', 'wp-registration' ) 
                );
    }
    
    // get maximum checkbox is checked for checkbox fields
    function meta_width_max_check() {
        return array (
                    'type'  => 'text',
                    'title' => __ ( 'Max checked option(s)', 'wp-registration' ),
                    'desc'  => __ ( 'How many options can be checked by user e.g: 3. Leave blank for default.', 'wp-registration' ) 
                );
    }
    
    // get fields icons
    function meta_icons() {
        return array (
                    'type'  => 'icon',
                    'title' => __ ( 'Icon', 'wp-registration' ),
                    'desc'  => __ ( 'Select an icon to appear in the field. Leave blank if you do not want an icon to show in the field.', 'wp-registration' ) 
                );
    }
    
    // get fields placeholder
    function meta_placeholder() {
        return array (
                    'type'  => 'text',
                    'title' => __ ( 'Placeholder', 'wp-registration' ),
                    'desc'  => __ ( 'Type field Placeholder.', 'wp-registration' ) 
                );
    }
    
    function meta_visibillty(){
        $wpr_visible = array(    
            ''              => __('Select', 'wp-registration'),
            'visible_in_registration'    => __('Registration only', 'wp-registration'),
            'visible_in_profile'  => __('Profile only', 'wp-registration'),
            'visible_in_both'     => __('Both',   'wp-registration'),
            );

        return array (
            'type'  => 'select',
            'title' => __ ( 'Visible', 'wp-registration' ),
            'desc'  => __ ( 'There are following form type to show this field.', 'wp-registration' ),
            'options' => $wpr_visible,
            'default' => 'visible_in_both',

        );

    }
    
    // get date formats for date fields 
    function date_formats(){
        
        $wpr_date_formats = array(    
                'mm/dd/yy'    => __('Default - mm/dd/yy', 'wp-registration'),
                'yy-mm-dd'    => __('ISO 8601 - yy-mm-dd', 'wp-registration'),
                'd M, y'     => __('Short - d M, y',   'wp-registration'),
                'd MM, y'    => __('Medium - d MM, y', 'wp-registration'),
                'DD, d MM, yy'      => __('Full - DD, d MM, yy', 'wp-registration'),
                '\'day\' d \'of\' MM \'in the year\' y'           => __('With text - \'day\' d \'of\' MM \'in the year\' yy', 'wp-registration'),
            );
            
        return array (
            'type'  => 'select',
            'title' => __ ( 'Date formats', 'wp-registration' ),
            'desc'  => __ ( 'Select date format.', 'wp-registration' ),
            'options' => $wpr_date_formats,
            'default' => '', 
        );
    }

    // get fields core wp_fields
    function meta_wp_fields(){

        $wpr_fields = array(    
            ''              => __('Select', 'wp-registration'),
            'user_login'    => __('Username', 'wp-registration'),
            'first_name'    => __('First Name', 'wp-registration'),
            'last_name'     => __('Last Name',   'wp-registration'),
            'user_email'    => __('Email', 'wp-registration'),
            'password'      => __('Password', 'wp-registration'),
            'url'           => __('Website', 'wp-registration'),
            'nickname'      => __('Nickname', 'wp-registration'),
            'display_name'  => __('Display Name', 'wp-registration'),
            'jabber'        => __('Jabber Account', 'wp-registration'),
            'aim'           => __('AOL IM Account', 'wp-registration'),
            'yim'           => __('Yahoo IM', 'wp-registration'),
            'description'   => __('About User', 'wp-registration'),
            );

      return   array (
                'type'    => 'select',
                'title'   => __('WP Fields', 'wp-registration'),
                'desc'    => __('Set as Core WP Field', 'wp-registration'),
                'options' => $wpr_fields,
            );
    }

    // get fields privacy check
    function meta_Privacy() {

        $wpr_privacy_fields = array(    
            'everyone_view'       => __('Everyone', 'wp-registration'),
            'member_view'         => __('Members', 'wp-registration'),
            'only_owner_admin'    => __('Only visible to profile owner and admins',   'wp-registration'),
            'specific_role_1'     => __('Only visible to profile owner and specific roles', 'wp-registration'),
            'specific_role_2'     => __('Only specific member roles', 'wp-registration'),

            );

        return array (
                    'type'    => 'select',
                    'title'   => __ ( 'Privacy', 'wp-registration' ),
                    'desc'    => __ ( 'Field privacy allows you to select who can view this field on the front-end. The site admin can view all fields regardless of the option set here.', 'wp-registration' ),
                    'options' => $wpr_privacy_fields,
                    'default' => 'Everyone', 
                );
    }

    // get fields privacy roles for members and admin
    function meta_Privacy_specific_roles() {
        return array (
                    'type'  => 'sp_roles',
                    'title' => __ ( 'Member Roles', 'wp-registration' ),
                    'desc'  => __ ( 'Select the member roles that can view this field on the front-end.', 'wp-registration' ),
                );
    }

    //get fields defualt values
    function meta_defualt_value(){
    
        return array (
                'type' => 'text',
                'title'=> __ ( 'Default Value', 'wp-registration' ),
                'desc' => __ ( 'Enter defualt value.', 'wp-registration' ),
            );
    }
    
   
    // Get input fields meta
    function meta_array() {

        $wpr_fields = array(
            'wp_field' => array(

                'title'       => __('WordPress Fields','wp-registration'),
                'icon'        => __('<i class="fa fa-list" aria-hidden="true"></i>','wp-registration'),
                'description' => __('WordPress Core Fields','wp-registration'),
                'field_meta'  => array (

                    'title'         => $this->meta_title(),
                    'wp_fields'     => $this->meta_wp_fields(),
                    'data_name'     => $this->meta_data_name(),
                    'confirm_pass'  => array (
                        'type'  => 'checkbox',
                        'title' => __ ( 'Confirm Password', 'wp-registration' ),
                        'desc'  => __ ( 'Select if you want user to confirm password.', 'wp-registration' ) 
                        ),
                    'accpt_weak_pass'    => array (
                        'type'  => 'checkbox',
                        'title' => __ ( 'Accept Weak Password', 'wp-registration' ),
                        'desc'  => __ ( "Select if you want user to register even it's setting weak password.", 'wp-registration' ) 
                        ),
                    'desc'          => $this->meta_desc(),
                    'error_message' => $this->meta_error_message(),
                    'placeholder'   => $this->meta_placeholder(),
                    'required'      => $this->meta_required(),
                    'class'         => $this->meta_class(),
                    'default_value' => $this->meta_defualt_value(),                  
                    'privacy_role'  => $this->meta_Privacy_specific_roles(),
                    'width'         => $this->meta_width(),
                    
                )
            ),

            'text' => array(
    
                'title'       => __('Text Input','wp-registration'),
                'icon'        => __('<i class="fa fa-pencil-square-o" aria-hidden="true"></i>','wp-registration'),
                'description' => __('Textbox Field','wp-registration'),
                'field_meta'  => array (
                    
                    'title'         => $this->meta_title(),
                    'data_name'     => $this->meta_data_name(),
                    'desc'          => $this->meta_desc(),
                    'error_message' => $this->meta_error_message(),
                    'placeholder'   => $this->meta_placeholder(),
                    'required'      => $this->meta_required(),
                    'default_value' => $this->meta_defualt_value(),
                    'class'         => $this->meta_class(),                   
                    'privacy_role'  => $this->meta_Privacy_specific_roles(),
                    'width'         => $this->meta_width(),
                   
                )
            ),
    
            'select' => array(
    
                'title'       => __('Select Input','wp-registration'),
                'icon'        => __('<i class="fa fa-check" aria-hidden="true"></i> ','wp-registration'),
                'description' => __('Select Field','wp-registration'),
                'scripts'     => array( 'js'  =>array(
                                            'source'  => 'js/select2.js',
                                            'depends' => array('jquery'),
                                        ),
                                        'css' => array(
                                            'source'  => 'css/select2.css',
                                        ),
                ),
                'field_meta'  => array (
    
                    'title'         => $this->meta_title(),
                    'data_name'     => $this->meta_data_name(),
                    'desc'          => $this->meta_desc(),
                    'error_message' => $this->meta_error_message(),
                    'placeholder'   => $this->meta_placeholder(),
                    'add_options'   => $this->meta_add_options(),
                    'default_value' => $this->meta_defualt_options(),
                    'required'      => $this->meta_required(), 
                    'class'         => $this->meta_class(),                  
                    'privacy_role'  => $this->meta_Privacy_specific_roles(),
                    'width'         => $this->meta_width(),
                   
                )
            ),
    
            'radio' => array(
    
                'title'       => __('Radio Input','wp-registration'),
                 'icon'       => __('<i class="fa fa-dot-circle-o" aria-hidden="true"></i>','wp-registration'),
                'description' => __('Radio Field','wp-registration'),
                'field_meta'  => array (
    
                    'title'         => $this->meta_title(),
                    'data_name'     => $this->meta_data_name(),
                    'desc'          => $this->meta_desc(),
                    'error_message' => $this->meta_error_message(),
                    'add_options'   => $this->meta_add_options(),
                    'default_value' => $this->meta_defualt_options(),
                    'required'      => $this->meta_required(),
                    'class'         => $this->meta_class(),                  
                    'privacy_role'  => $this->meta_Privacy_specific_roles(),
                    'width'         => $this->meta_width(),
                
                )
            ),
    
            'checkbox' => array(
    
                'title'       => __('Checkbox Input','wp-registration'),
                 'icon'       => __('<i class="fa fa-check-square-o" aria-hidden="true"></i>','wp-registration'),
                'description' => __('Checkbox Field','wp-registration'),
                'field_meta'  => array (
    
                    'title'         => $this->meta_title(),
                    'data_name'     => $this->meta_data_name(),
                    'desc'          => $this->meta_desc(),
                    'error_message' => $this->meta_error_message(),
                    'add_options'   => $this->meta_add_options(),
                    'required'      => $this->meta_required(),
                    'class'         => $this->meta_class(),                   
                    'privacy_role'  => $this->meta_Privacy_specific_roles(),
                    'width'         => $this->meta_width(),
                    'default_value' => $this->meta_check_option(),
                    'min_checked'   => $this->meta_width_min_check(),
                    'max_checked'   => $this->meta_width_max_check(),
                    
                )
            ),
    
            'date' => array(
    
                'title'       => __('Date Input','wp-registration'),
                 'icon'       => __('<i class="fa fa-calendar" aria-hidden="true"></i>','wp-registration'),
                'description' => __('Date Field','wp-registration'),
                'scripts'     => array( 'default'  =>array(
                                                'source' => 'jquery-ui-datepicker',
                                                    ),
                                        'css' => array(
                                                'source' => 'css/ui//css/smoothness/jquery-ui-1.10.3.custom.min.css',
                                                    ),
                            ),
                'field_meta'  => array (
    
                    'title'         => $this->meta_title(),
                    'data_name'     => $this->meta_data_name(),
                    'desc'          => $this->meta_desc(),
                    'error_message' => $this->meta_error_message(),
                    'placeholder'   => $this->meta_placeholder(),
                    'required'      => $this->meta_required(),
                    'class'         => $this->meta_class(),
                    'privacy_role'  => $this->meta_Privacy_specific_roles(),
                    'width'         => $this->meta_width(),
                    'year_range'    => array (
                                        'type'  => 'text',
                                        'title' => __ ( 'Year Range', 'wp-registration' ),
                                        'desc'  => __ ( 'e.g: 1950:2016. (if jQuery enabled above) Set star/end year like ', 'wp-registration') 
                                        ),
                    'default_value'  => array (
                                        'type'  => 'text',
                                        'title' => __ ( 'Default Date', 'wp-registration' ),
                                        'desc'  => __ ( 'Set default date in format selected below.', 'wp-registration' ) 
                                        ),
                    'date_formats'  => $this->date_formats(),
                )
            ),
    
            'textarea' => array(
    
                'title'       => __('Textarea Input','wp-registration'),
                 'icon'       => __('<i class="fa fa-file-text-o" aria-hidden="true"></i>','wp-registration'),
                'description' => __('Textarea Field','wp-registration'),
                'field_meta'  => array (
    
                    'title'         => $this->meta_title(),
                    'data_name'     => $this->meta_data_name(),
                    'desc'          => $this->meta_desc(),
                    'error_message' => $this->meta_error_message(),
                    'placeholder'   => $this->meta_placeholder(),
                    'required'      => $this->meta_required(),
                   
                    'default_value' => $this->meta_defualt_value(),
                    'class'         => $this->meta_class(),
                   
                    'privacy_role'  => $this->meta_Privacy_specific_roles(),
                    'width'         => $this->meta_width(),
                    
    
                )
            ),
        );
    
        return apply_filters('wpr_field_meta_array', $wpr_fields, $this);
    }

    // This function will return field's meta
    function get_field_settings( $field_type ) {
    
        $all_fieds = $this->meta_array();
        
        if( isset( $all_fieds[$field_type]) ) {
            return $all_fieds[$field_type];
        }
    }
}

WPR_META();
function WPR_META(){
    return WPR_Meta::get_instance();
}