<?php
/**
** Class manag input meta for front end
**/

class WPR_InputMeta {
    
    // class properties
    protected static $input;
    
    // legacy file
    private $legacy;
    
    function __construct( $input,$type) {
        
        self::$input = $input;
        $this->type = $type;
        // $this->legacy = new WPFM_File_Legacy($input);

        //Now we are creating properties agains each methods in our Alpha class.
        $methods = get_class_methods( $this );
        $excluded_methods = array('__construct','file_instance');
        foreach ( $methods as $method ) {
            if ( ! in_array($method, $excluded_methods) ) {
                $this->$method = $this->$method();
            }
        }   
    }
    
    public static function file_instance($input){
        
        // $inst = new WPFM_File($input);
        // return $inst;
    }

    // Getting input title
    function title() {

        $title = isset( self::$input['title'] ) ?  self::$input['title']: '';
        return apply_filters('wpr_inpu_title', $title, self::$input);
    }

    // Getting input options
    function options() {

        $options = isset( self::$input['add_options'] ) ?  self::$input['add_options']: '';
        $options = wpr_convert_options($options, self::$input);
        return apply_filters('wpr_input_options', $options, self::$input);
    }

    // Getting input data_name
    function data_name() {

        $data_name = isset( self::$input['data_name'] ) ?  self::$input['data_name']: '';
        return apply_filters('wpr_input_data_name', $data_name, self::$input);
    }

    // getting confirm password value
    function confirm_password() {
        $confirm_pass = isset( self::$input['confirm_pass'] ) ?  self::$input['confirm_pass']: '';
        return apply_filters('wpr_input_confirm_pass', $confirm_pass, self::$input);
    }

    // set name of confirm password input
    function confirm_pass_name(){
        $confirm_pass_name = '';
        if ($this->confirm_password() == 'on') {
            $confirm_pass_name = 'wpr[wp_field][confirm_password]';
        }
        return apply_filters('wpr_input_confirm_pass_name', $confirm_pass_name, self::$input);
    }

    // confirm weak password value
    function accept_weak_password() {
        $accept_weak_pass = isset( self::$input['accpt_weak_pass'] ) ?  self::$input['accpt_weak_pass']: '';
        return apply_filters('wpr_input_accpt_weak_pass', $accept_weak_pass, self::$input);

    }
    
    // Getting value if user is logged-in or get by user_id
    function value() {

        if ($this->type == 'checkbox') {

            $value = array();
            $imp   = $this -> default_value();
            $options = explode(',', $imp);

            foreach ($options as $key => $val) {                
                $value[] = sanitize_key($val);
            }

        }else if ($this->type == 'autocomplete') {
            
            $value = array();
            $imp   = $this -> default_value();
            $options = explode(',', $imp);

            foreach ($options as $key => $val) {                
                $value[] = sanitize_key($val);
            }

        }else{
            $value = $this -> default_value();
        }

        $user_id = wpr_get_current_user_id(); 
        
        if( !empty($user_id) ) {

            $value = get_user_meta($user_id, $this->data_name(), true);
            
        }

        return apply_filters('wpr_input_value', $value, self::$input);
    }

    // getting defualt values of fields
    function default_value(){
        
        $default_value = isset( self::$input['default_value'] ) ?  self::$input['default_value']: '';
        return apply_filters('wpr_input_default', $default_value, self::$input);
    }

    // Input field name
    function input_name() {

        $input_name = "wpr[".$this->type."][".$this->data_name()."]";
       
        return apply_filters('wpr_input_field_name', $input_name, self::$input);
    }

    // Input field name
    function input_name_multiple() {

        $input_name = "wpr[".$this->type."][".$this->data_name()."][]";
        return apply_filters('wpr_input_field_name', $input_name, self::$input);
    }

    // Getting input descriptions
    function desc() {

        $desc = isset( self::$input['desc'] ) ?  self::$input['desc']: '';
        return apply_filters('wpr_input_desc', $desc, self::$input);
    }

    // Getting input error message
    function error_msg() {

        $error_msg = isset( self::$input['error_message'] ) ?  self::$input['error_message']: '';
        return apply_filters('wpr_input_error_msg', $error_msg, self::$input);
    }

    // Getting input required
    function required() {

        $required = isset( self::$input['required'] ) ?  self::$input['required']: '';
        return apply_filters('wpr_input_required', $required, self::$input);
    }


    // Getting email chekbox required
    function email_required() {

        $email_req = isset( self::$input['email_req'] ) ?  self::$input['email_req']: '';
        return apply_filters('wpr_input_email_req', $email_req, self::$input);
    }

    // Getting input placeholder
    function placeholder() {

        $placeholder = isset( self::$input['placeholder'] ) ?  self::$input['placeholder']: '';
        return apply_filters('wpr_input_placeholder', $placeholder, self::$input);
    }

    // Getting input width
    function width() {

        $width = isset( self::$input['width'] ) ?  self::$input['width']: '';
        return apply_filters('wpr_input_width', $width, self::$input);
    }

    // Getting input icons
    function icon(){
        if ( isset(self::$input['wpr_icon']) && self::$input['wpr_icon'] != '') {
            $icon = self::$input['wpr_icon'];
        }else{
            $icon = '';
        }
        return apply_filters('wpr_input_icon', $icon, self::$input);
    }

    // Getting input classes with form-control
    function classes_fm() {

        $classes   = isset( self::$input['class'] ) ? explode(',',self::$input['class']): array();
        $classes[] = 'form-control';
        $classes[] = 'wpr_field_data';
        $input_classes = implode(' ',$classes);

        return apply_filters('wpr_input_classes', $input_classes, self::$input);
    }

    // Getting input classes without form-control
    function input_classes() {

        $classes   = isset( self::$input['class'] ) ? explode(',',self::$input['class']): array();
        $classes[] = 'wpr_field_data';
        $input_classes = implode(' ',$classes);

        return apply_filters('wpr_input_classes', $input_classes, self::$input);
    }

    // Getting max checkbox is checked
    function max_checked() {

        $max_checked = isset( self::$input['max_checked'] ) ?  self::$input['max_checked']: '';
        return apply_filters('wpr_input_max_checked', $max_checked, self::$input);
    }

    // Getting min checkbox is checked
    function min_checked() {

        $min_checked = isset( self::$input['min_checked'] ) ?  self::$input['min_checked']: '';
        return apply_filters('wpr_input_min_checked', $min_checked, self::$input);
    }

    // Getting date formate for date input
    function format() {

        $format = isset( self::$input['date_formats'] ) ?  self::$input['date_formats']: '';
        return apply_filters('wpr_input_format', $format, self::$input);
    }

    // Getting date year range for date input
    function year_range() {

        $year_range = isset( self::$input['year_range'] ) ?  self::$input['year_range']: '';
        return apply_filters('wpr_input_year_range', $year_range, self::$input);
    }

    // Getting show_palletes options from color input
    function show_palletes() {

        $show_palletes = isset( self::$input['show_palletes'] ) ?  self::$input['show_palletes']: '';
        return apply_filters('wpr_input_show_palletes', $show_palletes, self::$input);
    }

    // Getting color show option from color input
    function show_color() {

        $show_color = isset( self::$input['show_clr_picker'] ) ?  self::$input['show_clr_picker']: '';
        return apply_filters('wpr_input_show_color', $show_color, self::$input);
    }

    // Getting input_mask for masked input
    function input_mask() {

        $input_mask = isset( self::$input['input_mask'] ) ?  self::$input['input_mask']: '';
        return apply_filters('wpr_input_input_mask', $input_mask, self::$input);
    }

    // Getting max_values for number input
    function max_values() {

        $max_values = isset( self::$input['max_values'] ) ?  self::$input['max_values']: '';
        return apply_filters('wpr_input_max_values', $max_values, self::$input);
    }

    // Getting min_values for number input
    function min_values() {

        $min_values = isset( self::$input['min_values'] ) ?  self::$input['min_values']: '';
        return apply_filters('wpr_input_min_values', $min_values, self::$input);
    }

    // Getting steps for number input
    function steps() {

        $steps = isset( self::$input['steps'] ) ?  self::$input['steps']: '';
        return apply_filters('wpr_inpu_steps', $steps, self::$input);
    }

    // maximum option select for autocomplete input
    function max_select() {

        $max_select = isset( self::$input['max_select'] ) ?  self::$input['max_select']: '';
        return apply_filters('wpr_input_max_select', $max_select, self::$input);
    }

}