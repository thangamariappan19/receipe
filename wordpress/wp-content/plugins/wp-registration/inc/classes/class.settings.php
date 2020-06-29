<?php
/**
 * N-Media Setting Manager Class
 * 
 * 1- Rendering Settings
 * 2- Save Settings
 * 3- Get Settings
 * 
 */
 
class WPR_Settings {
    
    var $settings;
    var $setting_key;
    var $saved_settings;
    
    private static $ins = null;
    
    function __construct() {
        
        // $this->settings = wpr_get_admin_setting();
        $this->setting_key = 'wpr_settings';
        
        $this->saved_settings = $this->get_settings();
        
        add_action('wp_ajax_save_'.$this->setting_key, array($this, 'save_settings'));
    }
    
    public static function get_instance() {
        // create a new object if it doesn't exist.
        is_null(self::$ins) && self::$ins = new self;
        return self::$ins;
    }
    
    // Display Function
    public function display() {
        
        $this->loader_css();

        wp_enqueue_style('mcqs-bootstrap', WPR_URL."/css/bootstrap.min.css");
        wp_enqueue_style('wpr-setting-css', WPR_URL."/css/wpr-admin-setting.css");
        wp_enqueue_style('wpr-settings-css', WPR_URL."/css/jquery-ui-css.css");
        wp_enqueue_style('wpr-setting-st', WPR_URL."/css/select2.css");
        
        wp_enqueue_script('wpr-setting-js', WPR_URL."/js/wpr-admin-setting.js", array('jquery' ,'jquery-ui-core', 'jquery-ui-tabs'), '1.0', true);
        wp_enqueue_script('wpr-setting-slct', WPR_URL."/js/select2.js", array('jquery'), '1.0', true); 

        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');
        $this->settings = wpr_get_admin_setting();
        ?>
        <div class="wpr_refresh_loader"></div>
        <div class="wpr-settings-wrapper wpr_setting_page_hide" style="display: none;">
            <form id="<?php echo esc_attr($this->setting_key); ?>_form">
                <input type="hidden" name="action" value="save_<?php echo esc_attr($this->setting_key) ?>">
                <div id="tabs">
                  <ul>
                      <?php foreach ($this-> settings as $tab_title => $data) {
                          $tab_id = sanitize_key($tab_title);
                          
                           echo '<li class="settings-li"><a href="#'.esc_attr($tab_id).'">'.$tab_title.'</a></li>';
                      }
                      ?>
                      
                   </ul>
                    <?php foreach ($this-> settings as $tab_title => $data) {
                        
                        $tab_id = sanitize_key($tab_title);
                    ?>
                        <div id="<?php echo esc_attr($tab_id); ?>">
                            <table class="form-table tb-control">
                                <?php foreach ($data as $key => $field_data) {
                                    $type       = isset($field_data['type']) ? $field_data['type'] : '';
                                    $id         = isset($field_data['id']) ? $field_data['id'] : '';
                                    $advance_url = isset($field_data['wpr_advance']) ? $field_data['wpr_advance'] : '';

                                    $label      = isset($field_data['label']) ? $field_data['label'] : '';
                                    $desc       = isset($field_data['description']) ? $field_data['description'] : '';
                                    $default    = isset($field_data['default']) ? $field_data['default'] : '';
                                    $messages    = isset($field_data['message']) ? $field_data['message'] : '';
                                    $options    = isset($field_data['options']) ? $field_data['options'] : '';
                                    $icon       = isset($field_data['icon']) ? $field_data['icon'] : '';
                                    $img        = isset($field_data['img']) ? $field_data['img'] : '';
                                    $icon = '<span class="color '.esc_attr($icon).'"></span>';
                                    // divide rows for heading
                                    $divider  = $type == 'divider' ? 'wpr-divider-heading' : '';
                                    // wpr_pa($type);
                                    $show_url = $id == 'wpr_advance_redirect' ? 'wpr-url-toggle':'';
                                    $hide_url = $advance_url == 'set_advance'? 'set_advance' : '';
                                
                                    ?>
                                        <tr 
                                            class="<?php echo esc_attr($divider); ?>" 
                                            data-hide-url ="<?php echo esc_attr($hide_url); ?>"
                                            data-show-url ="<?php echo esc_attr($show_url); ?>"
                                        >
                                        <?php if($label) { ?>
                                            
                                            <td class="wpr-label-text"><?php echo $img.' '. $icon.' '. $label; ?></td>
                                        <?php } ?>
                                            <td colspan="2"><?php echo $this->input($type, $id, $default, $options, $messages); ?></td>
                                            <td class = "wpr-desc-text"><?php echo $desc; ?></td>
                                        </tr>
                                <?php } ?>
                            </table>
                        </div>
                    <?php } ?>

                </div>
                <span class="wpr_sub_st_control">
                    <input type="submit" class="btn btn-primary">
                     <div class="wpr_save_alert wpr-alert-display"><?php _e('Settings Saved' , 'wp-registration'); ?></div>
                     <span class="wpr-spinner"></span>
                </span>
            </form>
        </div>
        <?php
    }
    
    // Render input control
    function input( $type, $id, $default, $options="", $messages) {
        
        // var_dump($messages);
        $input_html = '';
        $name  = $this->setting_key.'['.$id.']';
        // $messages  = $this->setting_key.'['.$message.']';
        $value = ($this->get_option($id) == '') ? $default : $this->get_option($id);

        // get_pages( $args );
        // wpr_pa($value);
        
        switch( $type ) {
        
            case 'text':
                
                $input_html .= '<input class="form-control wpr-text-option" name="'.esc_attr($name). '" type="text" id="'.esc_attr($id).'" value="'.esc_attr($value).'">';
                break;
            case 'radio':
                
                $input_html .= '<input  name="'.esc_attr($name).'" type="radio" id="'.esc_attr($id).'" value="'.esc_attr($default).'" '.checked( $value, $default, false ).'>';
                break;
            case 'checkbox':
                
                $input_html .= '<input  name="'.esc_attr($name).'" type="checkbox" id="'.esc_attr($id).'" value="on" '.checked($value,'on', false).'>';
                $input_html .='<label for="'.esc_attr($id).'" class="wpr-chk-option">'.esc_html__( 'Yes', 'wp-registration' ).'</label>';
                break;
            case 'select':
                
                $input_html .= '<select class="wpr-select-design wpr_op_select" name="'.esc_attr($name) .'">';
                    foreach($options as $val => $text) {
                        $input_html .= '<option class="wpr-option-width" value="'.esc_attr($val).'" ' . selected( $value, $val, false). '>'.$text.'</option>';
                    }
                    
                    $input_html .= '</select>';
                    
                break;
            case 'textarea':
                
                $input_html .= '<textarea name="'.esc_attr($name).'" rows="4" style="width:66%;">'. esc_textarea($value) .'</textarea>';
                break;
            case 'span':
            
            $input_html .= '<span style="background: #dbdcde94; padding: 5px; font-size: 13px;">'. esc_attr($messages) .'<span>';
                break;
            case 'wpr_color':
                
                $input_html .= '<input name="'.esc_attr($name).'" class="wp-color" id="'.esc_attr($id).'" value="'.esc_attr($value).'">';
                break;

            case 'button':
                $input_html .= '<button class="btn btn-success">'.esc_html__( 'Advance Role Base Redirections', 'wp-registration' ).'</button>';
                break;

            case 'access_roles':
                
                $input_html .= wpr_get_all_wp_roles($name, $id, $value);
                break;

            case 'dash_access_role':
                
                $get_roles = get_editable_roles();
                $input_html .= '<select name="'.esc_attr($name).'[]" id="'.esc_attr($id).'" class="gn_roles" multiple>';
                unset($get_roles['administrator']);
                foreach ($get_roles as $roles => $role_name) {

                    $selected = '';
                    if( !empty($value) ) {
                        $selected = in_array($roles, $value) ? 'selected="selected"' : '';
                    }
                    $input_html .= '<option value="'.esc_attr($roles).'" '.$selected.'>'.sprintf(__("%s","wp-registration"),$roles).'</option>';
                }
                $input_html .= '</select>';


                break;
                
            case 'mc_list':
                
                $mc_lists = WPRMC()->get_lists();
                if( is_wp_error($mc_lists) ) {
                    $input_html .= sprintf(__("%s", "wpr"), $mc_lists->get_error_message());
                } else {
                    
                    if( $mc_lists ) {
                        $input_html .= '<select multiple name="' . esc_attr($name) . '[]" id="' . esc_attr($id) . '" class="wpr-text-option wpr-select2">';
                        foreach ($mc_lists as $list) {
                          
                            $selected = '';
                            if( !empty($value) ) {
                                $selected = in_array($list['id'], $value) ? 'selected="selected"' : '';
                            }
                            $input_html .= '<option value="'.$list['id'].'" '.$selected.'>'.$list['name'].'</option>';
                        }
                        $input_html .= '</select>';
                    } else {
                        
                        $input_html .= __("No List Found", 'wpr');
                    }
                }
                break;
                
            case 'sb_list':
                
                $sb_list = WPRSB()->get_lists();
               
                if( is_wp_error($sb_list) ) {
                    $input_html .= sprintf(__("%s", "wpr"), $sb_list->get_error_message());
                } else {
                    
                    if( $sb_list ) {
                        $input_html .= '<select  class="wpr-text-option wpr-select2" multiple name="' . esc_attr($name) . '[]" id="' . esc_attr($id) . '">';
                        foreach ($sb_list as $list) {
                          
                            $selected = '';
                            if( !empty($value) ) {
                                $selected = in_array($list['id'], $value) ? 'selected="selected"' : '';
                            }
                            $input_html .= '<option value="'.$list['id'].'" '.$selected.'>'.$list['name'].'</option>';
                        }
                        $input_html .= '</select>';
                    } else {
                        
                        $input_html .= __("No List Found", 'wpr');
                    }
                }
                break;

            case 'wpr_get_pages':

                        $input_html .= '<select name="' . esc_attr($name).'" class="wpr-select2">';
                        $input_html .= '<option value="">'. esc_attr( __( 'Select page' ) ). '</option>'; 
 
                          $pages = get_pages(); 
                          foreach ( $pages as $page ) {
                            $input_html .= '<option value="' . $page->ID . '" ' . selected( $value, $page->ID, false). '>';
                            $input_html .= $page->post_title;
                            $input_html .= '</option>';
                          }
                        $input_html .='</select>';

                break;
            case 'file':
                wpr_load_templates("admin/how-to-use.php");
        }
        
        return $input_html;
    }
    
    function loader_css(){
        ?>
        <style type="text/css">
        .wpr_refresh_loader {
            border: 16px solid #b38e8e; 
            border-top: 16px solid #3498db; 
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
            margin-left: 36%;
            margin-top: 20%;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        </style>
        <?php
    }
    
    // Saving settings
    function save_settings() {
        
       if( !isset($_POST[$this->setting_key]) ) 
            wp_die('No Data Found');
             
        $settings_data = $_POST[$this->setting_key];

        // Need to update wpr_core_page option
        $wpr_core_pages = array();
        foreach (wpr_set_defualt_pages_array() as $slug => $page_meta) {
            
            $core_page_key = "wpr_core_page_{$slug}";
            $wpr_core_pages[$slug] = $settings_data[$core_page_key];
        }

        // wpr core page update
        update_option('wpr_core_pages', $wpr_core_pages);
        
        update_option($this->setting_key, $settings_data);
        wp_die( __("Settings updated successfully", "wpr") );
    }
    
    // Get all settings from option
    function get_settings() {
        
        $settings = get_option($this->setting_key);
        return $settings;
    }
    
    // Get option value
    function get_option($id) {
        
        if( isset($this->saved_settings[$id]) ) {
            return $this->saved_settings[$id];
        }
        
        return '';
    }

    // Set option value
    function set_option($key, $value) {
        
        $this->saved_settings[$key] = $value;
        update_option($this->setting_key, $this->saved_settings);
    }
}

function WPR_Settings() {
    return WPR_Settings::get_instance();
}