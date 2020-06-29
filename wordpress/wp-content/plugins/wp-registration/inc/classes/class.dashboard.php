<?php
/**
 * WPR_User class will handle User State
 **/
 if( ! defined("ABSPATH" ) )
        die("Not Allewed");

class WPR_Dashboard {

	private static $ins = null;

	function __construct() {

		add_action( 'admin_menu', array( $this, 'add_dashboard_menu' )  );

		// ajax callback function
        add_action( 'wp_ajax_get_users_by_given_range', array($this, 'get_users_by_given_range') );
        add_action( 'wp_ajax_nopriv_get_users_by_given_range', array($this, 'get_users_by_given_range') );

        // ajax callback function
        add_action( 'wp_ajax_without_field_user_form_submit', array($this, 'without_field_user_form_submit') );
        add_action( 'wp_ajax_nopriv_without_field_user_form_submit', array($this, 'without_field_user_form_submit') );


        add_action( 'wp_ajax_admin_send_message_user', array($this, 'admin_send_message_user') );
        add_action( 'wp_ajax_nopriv_admin_send_message_user', array($this, 'admin_send_message_user') );

        // // // ajax callback function
        add_action( 'wp_ajax_previous_form_array_converted', array($this, 'previous_form_array_converted') );
        add_action( 'wp_ajax_nopriv_previous_form_array_converted', array($this, 'previous_form_array_converted') );
        
        // action to send message to user via email
        add_action( 'wp_ajax_wpr_send_email_to_user', array($this, 'wpr_send_email_to_user') );
        add_action( 'wp_ajax_nopriv_wpr_send_email_to_use', array($this, 'wpr_send_email_to_use') );
	}

	public static function get_instance() {
	    // create a new object if it doesn't exist.
		is_null(self::$ins) && self::$ins = new self;
		return self::$ins;
	}

	function load_dashboard_script(){

		// bootstrap file load
        wp_enqueue_style('wpr-dashboard-bsrtp', WPR_URL."/css/bootstrap.min.css");
        
        // font-awesome and ionic icons 
        wp_enqueue_style('wpr-ftawsome', WPR_URL."/css/font-awesome/css/font-awesome.css");
        
        // dashboard  files load
		wp_enqueue_style('wpr-dashboard-css', WPR_URL."/css/dashboard.css");
    	wp_enqueue_script('wpr-dashboard-js', WPR_URL."/js/dashboard.js", array('jquery'), WPR_VERSION, true);

      //select2
        wp_enqueue_style('WPR-select2', WPR_URL."/css/select2.css");
        wp_enqueue_script('WPR-select2', WPR_URL."/js/select2.js", array('jquery'), WPR_VERSION, true);
        
	}

	 // Add dashboard menu on wpr custom post type
    function add_dashboard_menu(){
         add_submenu_page(
           'edit.php?post_type=wpr',
           __('WP Registration', 'wp-registration'),
           __('Dashboard', 'wp-registration'),
           'manage_options',
           'wpr_dashboard_id',
           array($this, 'load_dashboard_template') 
        );
    }

    function load_dashboard_template() {

     // enqueues dashboard scripts
     WPRDASHBOARD()->load_dashboard_script();
        
         // load dashboard main file
        wpr_load_templates("admin/dashboard.php");
    }

    // get total wordpress register users
    function total_users(){

    	$all_users = count_users();
    	return apply_filters('wpr_total_users_show', $all_users['total_users']);
    }

    // show google api pie chart with users information by role
    function show_users_on_pie_chart(){

    	$all_users = count_users();

    	$html = '';
	    $html .= '<script type="text/javascript">';
			$html .= "google.charts.load('current', {'packages':['corechart']});";
      		$html .= "google.charts.setOnLoadCallback(drawChart);";
		      $html .= "function drawChart() {";
		        $html .= "var data = google.visualization.arrayToDataTable([";
		          $html .= "['Task', 'Hours per Day'],";
		          foreach ($all_users['avail_roles'] as $role_name => $user_role_base) {		
		          	$html .= "['$role_name',     $user_role_base],";
		          }
		        $html  .="]);";
		        $html .= "var options = {";
		        $html .= "title: 'User By Role'";
		        $html .= "};";
		        $html .= "var chart = new google.visualization.PieChart(document.getElementById('wpr_piechart'));";
		        $html .= "chart.draw(data, options);";
		      $html .= "}";
	    $html .= '</script>';

	    $html .= '<div id="wpr_piechart" style="width: 400px; height: 240px;"></div>';
	    return $html;
    }

    // get all users of last weak
   	function count_last_weak_users(){

		$previous_week = strtotime("-1 week +1 day");
		$start_week    = strtotime("last sunday midnight",$previous_week);
		$end_week      = strtotime("next saturday",$start_week);
		$start_week    = date("Y-m-d",$start_week);
		$end_week      = date("Y-m-d",$end_week);
		
	    $last_weak_users = $this->count_users_on_date_base($users_role='', $start_week, $end_week);
	    return apply_filters('wpr_last_weak_users_filter', $last_weak_users);
   	}

   	// get all users of last month
   	function count_last_month_users(){

		$start_month = date("Y-n-j", strtotime("first day of previous month"));
		$end_month   =  date("Y-n-j", strtotime("last day of previous month"));

		$last_month_users = $this->count_users_on_date_base($users_role='', $start_month, $end_month);
		return apply_filters('wpr_last_month_users_filter', $last_month_users);
   	}

   	// get all users of last year
   	function count_last_year_users(){

   		$last_year = date('Y',strtotime("-1 year"));

        $args = array('role'=>'','meta_key'=>'','meta_value'=>'');
	    if( $last_year !='' ) {
	        $args['date_query']= array(
		        array(
		            'year'     => $last_year,
		        ),
     		);
    	}
    
	    $last_year_users = get_users( $args );
	    return apply_filters('wpr_last_year_users_filter', count($last_year_users));
   	}

   	// count all users by date period
   	function count_users_on_date_base($users_role, $date_after, $date_before){
      // var_dump($date_after);

	    $args = array('role'=>$users_role,'meta_key'=>'','meta_value'=>'');
	    if( $date_after !='' ) {
	        $args['date_query']= array(
		        array(
		            'after'     => $date_after,
		            'before'    => $date_before,
		            'inclusive' => true,
		        ),
     		);
    	}
    
	    $get_all_users = get_users( $args );
	    $users_count = count($get_all_users);
	    return apply_filters('wpr_count_users_on_date_base_filter', $users_count);
   	}

   	// get users by given date range ajax callback function
   	function get_users_by_given_range(){

   		if( ! isset($_POST['wpr_date_start']) || ! isset($_POST['wpr_date_end']) ) return null;
   		$start_date = $_POST['wpr_date_start'];
   		$end_date 	= $_POST['wpr_date_end'];
   		$users_role = $_POST['wpr_get_users_by_role'];

   		$result = $this-> count_users_on_date_base($users_role, $start_date, $end_date);

   		$response = array( 'status'=>'success',
		                   'user'=>$result,
                	);

   		wp_send_json($response);
   	}
   	
   	// send email to user
   	function wpr_send_email_to_user(){

   		if( ! isset($_POST['email_message']) || ! isset($_POST['user_email']) ) return null;
   		
   		$email_message  = $_POST['email_message'];
   		$user_email 	= $_POST['user_email'];
   		$email_subject  = $_POST['email_subject'];
   		$header         = $this->get_mail_header();
   		
   		$message        = $this->email_template($email_message);
   		
   		$response       = array('status'=>'error', 'message'=>__("Email not send!", 'wpr'));
   		if( wp_mail($user_email, $email_subject, $message, $header ) ) {
   		    
   		    $response = array('status'=>'success', 'message'=>__("Send Email Successfully!", 'wpr'));
   		}
   		
   		
   		wp_send_json($response);
   	}
   	
   	function get_mail_header(){
	 	
	 	$site_title = get_bloginfo('name');
		$admin_email = get_bloginfo('admin_email');
		
		$headers[] = "From: {$site_title} <{$admin_email}>";
		$headers[] = "Content-Type: text/html";
		$headers[] = "MIME-Version: 1.0\r\n";
		
		return apply_filters('wpr_email_header', $headers);
	}
	
	function email_template($email_message){
	    
	    ob_start();
			
		$message = $email_message;
		
		$email_vars     = array('form'=>'not exist');						
		$email_template = "email/template.email.php";
		
		wpr_load_templates( $email_template,$email_vars);
			
	    $email_string = ob_get_clean();
	
		// Adding message to template
		$email_string = str_replace("%WPR_EMAIL_CONTENT%", $message, $email_string);
			
		return apply_filters('wpr_email_htmls', $email_string, $message);
	}

    function without_field_user_form_submit(){

        if( empty($_POST['wpr_form_type']) ) {

            $response = array('status'=>'error','message'=>__('Please select any Role and Form','wpr'));
            wp_send_json( $response );
        }


        $form_type   = $_POST['wpr_form_type'];
        $user_role   = $_POST['wpr_get_users_by_role'];


        $total_users = wpr_get_user_without_field($user_role);
        $wpr_fields_applied = 0;
        foreach ($total_users as $object => $value) {

          if( update_user_meta( $value->ID, 'wpr_form_id', $form_type ) ) {
            $wpr_fields_applied += 1;
          }           
        }

        $response = array('status'=>'success', 'message'=>__("{$wpr_fields_applied} users updated", 'wpr'),
                                               'total_users'=>__($wpr_fields_applied, 'wpr'));
        wp_send_json( $response );  
    }


    //get the admin message for user
    function admin_send_message_user(){

        if( empty($_POST['wpr_admin_msg']) ) {

            $response = array('status'=>'error','message'=>__('Please write the message','wpr'));
            wp_send_json( $response );
        }

        $user_role       = $_POST['wpr_get_users_by_role'];
        $admin_message   = $_POST['wpr_admin_msg'];

        $admin_msg = array(        
                            // 'user_role' => $user_role,
                            'msg'       => $admin_message,
        );

        update_option('wpr_user_msg', $admin_msg);

        $response = array('status'=>'success', 'message'=>__("Send Message to: {$user_role}", 'wpr'));
        wp_send_json( $response );  
    }

    // get all users role on date range form
    function users_role(){
        
        $get_roles = get_editable_roles();

        $html  = '';
        $html  = '<label for="date">'.esc_html__( 'Select Role:', 'wp-registration' ).'</label>';
        $html .= '<select name="wpr_get_users_by_role" class="form-control">';
                $html .= '<option value="">'.esc_html__( 'All', 'wp-registration' ).'</option>';
            foreach ($get_roles as $roles => $role_name) {
               $roles_first =  ucfirst($roles);
                $html .= '<option value="'.esc_attr($roles).'">'.sprintf(__("%s","wp-registration"),$roles_first).'</option>';
            }
        $html .= '</select>';
        return $html;
    }

   	// get all users role on date range form
   	function users_role_by_msg(){
   		$msg_from_admin  = get_option('wpr_user_msg');

        if (empty($msg_from_admin)) {
           $msg_from_admin['msg'] = array( 'All' => 'wellcome to profile');
        }

   		$get_roles = get_editable_roles();
        
   		$html  = '';
   		$html  = '<label for="date">'.esc_html__( 'Select Role:', 'wp-registration' ).'</label>';
        $html .= '<select name="wpr_get_users_by_role" class="form-control wpr_select_role">';
                $html .= '<option value="">'.esc_html__( 'Select Role', 'wp-registration' ).'</option>';
            	$html .= '<option value="all">'.esc_html__( 'All', 'wp-registration' ).'</option>';
            foreach ($get_roles as $roles => $role_name) {
                    $roles_first =  ucfirst($roles);
                $html .= '<option value="'.esc_attr($roles).'">'.sprintf(__("%s","wp-registration"),$roles_first).'</option>';
            
            }

        $html .= '</select>';
        $html .= '<div class="wpr_all">';
                foreach ($msg_from_admin as $index => $role_msg) {
                foreach ($get_roles as $roles => $role_name) {
                    $values = isset($role_msg[$roles]) ? $role_msg[$roles] : '';
                    $html .= '<div class="wpr-role-'.$roles.' wpr-msg-box">';
                    $html .= '<label>';
                    $html  .=   sprintf(__("%s","wp-registration"),'Type Message');
                    $html .= '</label>';
                    $html .= '<textarea name="wpr_admin_msg['.$roles.']" class="form-control wpr-bs-setting" 
                              style="min-height: 100px;">';
                    $html.=  sprintf(__("%s","wp-registration"),$values);
                    $html .= '</textarea>';
                    $html .= '</div>';
                }
                    $values = isset($role_msg['all']) ? $role_msg['all'] : '';

                    $html .= '<div class="wpr-role-all wpr-msg-box">';
                    $html .= '<label>';
                    $html  .=   sprintf(__("%s","wp-registration"),'Type Message');
                    $html .= '</label>';
                    $html .= '<textarea name="wpr_admin_msg[all]" class="form-control wpr-bs-setting" 
                                  style="min-height: 100px;">';
                    $html.=  sprintf(__("%s","wp-registration"),$values);
                    $html .= '</textarea>';
                    $html .= '</div>';
                }
                    $html .= '</div>';
            return $html;
   	}

    // build array by  old nm register plugin
    function previous_form_array_converted(){

        if( empty($_POST['form_key']) ) {

            $response = array('status'=>'error','message'=>__('your previous plugin not install','wpr'));
            wp_send_json( $response );
        }

        $previous_form_key = $_POST['form_key'];

        if (isset($_POST['form_key'])&& $_POST['form_key'] == 'wpregistration_meta') {
            update_option('wpr_migrate_controle', 1);

                //to get previous plugin form array
                $pre_form_array  = get_option($previous_form_key);
                // $pre_form_array  = get_option('wpregistration_meta');
       
                $build_array = array();

                foreach ($pre_form_array as $index => $fields) {

                    if ($fields['type'] == 'wp') {
                            $type = 'wp_field';
                    }else{
                            $type = $fields['type'];
                    }

                    unset($fields['type']);

                   $all_saved_meta = WPR_META()->get_field_settings($type);
                   $meta_data = $all_saved_meta['field_meta'];

                   $build_fields = $this->recursive_change_key($fields, array(
                                                       'wpfields' => 'wp_fields',
                                                       'description'=> 'desc',
                                                       'confirm_password'=> 'confirm_pass',
                                                       'accept_weak_password'=> 'accpt_weak_pass',
                                                       'max_value'=> 'max_values',
                                                       'min_value'=> 'min_values',
                                                       'step'=> 'steps',
                                                       'options'=> 'add_options',
                                                       'selected'=> 'default_value',
                                                       'mask'=> 'input_mask'    
                                                       
                                                       
                                                    ));

                   $array_diff = array_diff_key($meta_data, $build_fields);
                   foreach ($array_diff as $diff_key => $value) {

                       $build_fields[$diff_key] = '';  
                   }

                    // new array build
                    $build_array[][$type] = $build_fields;
                   
                }


            $new_form_id = $this->create_new_form($build_array);

            // Now assign new form to old users meta
            $total_users_migrated = $this-> set_old_user_meta( $new_form_id );

            $message = "Total {$total_users_migrated} user are assigned new form with ID {$new_form_id}";
            $response = array('status'=>'success', 'message'=> sprintf(__("%s", 'wpr'),$message));
                                               
            wp_send_json( $response );
        }
        // return $build_array;
    }

    function recursive_change_key($field, $field_key) {

       if (is_array($field) && is_array($field_key)) {
           $newArr = array();
           foreach ($field as $key => $value) {

              if( $key == 'options') {
                $value = explode("\n", $value);
              }


               $key = array_key_exists( $key, $field_key) ? $field_key[$key] : $key;
               // $newArr[$key] = is_array($value) ? $this->recursive_change_key($value, $field_key) : $value;
               $newArr[$key] = $value;
           }
           return $newArr;
       }
       return $field;    
    }


    function create_new_form($final_array) {

           $form = array(
                               'post_type'         => 'wpr',
                               'post_title'        => 'Migrated Form',
                               'post_status'       => 'publish',
                               'post_author'       => wpr_get_current_user_id(),
                           );
             $form_id = wp_insert_post( $form );
            update_post_meta( $form_id, 'wpr_fields', $final_array );

            return $form_id;
    }

    // get all user form previous form plugin 
    function set_old_user_meta( $new_form_id ) {

        $old_form_meta = get_option('wpregistration_meta', true);        

        $none_core_fields = array();
        $old_users_found = array();
        foreach ($old_form_meta as $wpr_meta) {
            
            if( $wpr_meta['type'] == 'wp' || ! isset($wpr_meta['data_name']) ) continue;

            if( isset($wpr_meta['required']) )
                $none_core_fields[] =  $wpr_meta['data_name'];
        }

        foreach($none_core_fields as $data_name) {

            $args = array('meta_query' => array(
                                array(
                                    'key' => $data_name,
                                    'compare' => 'EXISTS' // this should work...
                                ),
                            )
                        );

            $old_users_found = get_users( $args );
            if( count($old_users_found) > 0 ) {
                break;
            }
        }

        $total_users_migrated = 0;
        if( $old_users_found ) {

            foreach ($old_users_found as $user) {
                
                // New assigning new form to old users
                update_user_meta($user->ID, 'wpr_form_id', $new_form_id);
                $total_users_migrated++;
            }
        }

        return $total_users_migrated;
    }
    
    // get all users role on date range form
   	function all_user_display_in_select(){
   		$msg_from_admin  = get_option('wpr_user_msg');

        if (empty($msg_from_admin)) {
           $msg_from_admin['msg'] = array( 'All' => 'wellcome to profile');
        }

   		$get_roles = get_editable_roles();
        
   		$html  = '';
   		$html  = '<label for="date">'.esc_html__( 'Select Role:', 'wp-registration' ).'</label>';
        $html .= '<select name="wpr_get_users_by_role" class="form-control wpr_select_role">';
                $html .= '<option value="">'.esc_html__( 'Select Role', 'wp-registration' ).'</option>';
            	$html .= '<option value="all">'.esc_html__( 'All', 'wp-registration' ).'</option>';
            foreach ($get_roles as $roles => $role_name) {
                    $roles_first =  ucfirst($roles);
                $html .= '<option value="'.esc_attr($roles).'">'.sprintf(__("%s","wp-registration"),$roles_first).'</option>';
            
            }

        $html .= '</select>';
        $html .= '<div class="wpr_all">';
                foreach ($msg_from_admin as $index => $role_msg) {
                foreach ($get_roles as $roles => $role_name) {
                    $values = isset($role_msg[$roles]) ? $role_msg[$roles] : '';
                    $html .= '<div class="wpr-role-'.$roles.' wpr-msg-box">';
                    $html .= '<label>';
                    $html  .=   sprintf(__("%s","wp-registration"),'Type Message');
                    $html .= '</label>';
                    $html .= '<textarea name="wpr_admin_msg['.$roles.']" class="form-control wpr-bs-setting" 
                              style="min-height: 100px;">';
                    $html.=  sprintf(__("%s","wp-registration"),$values);
                    $html .= '</textarea>';
                    $html .= '</div>';
                }
                    $values = isset($role_msg['all']) ? $role_msg['all'] : '';

                    $html .= '<div class="wpr-role-all wpr-msg-box">';
                    $html .= '<label>';
                    $html  .=   sprintf(__("%s","wp-registration"),'Type Message');
                    $html .= '</label>';
                    $html .= '<textarea name="wpr_admin_msg[all]" class="form-control wpr-bs-setting" 
                                  style="min-height: 100px;">';
                    $html.=  sprintf(__("%s","wp-registration"),$values);
                    $html .= '</textarea>';
                    $html .= '</div>';
                }
                    $html .= '</div>';
            return $html;
   	}

    // active and inactive user count 
    function inactive_user () {

        $args = array('role' =>'',
                        'meta_query' => array(
                            array(
                                'value' => 'inactive',
                                'compare' =>'EXISTS' // this should work...
                            ),
                        )
                    );
        $total_user = get_users( $args );

        return count($total_user);
    }

    function active_user () {

        $args = array('role' =>'',
                        'meta_query' => array(
                            array(
                                'value' => 'active',
                                'compare' =>'EXISTS' // this should work...
                            ),
                        )
                    );
        $total_user = get_users( $args );

        return count($total_user);
    }
}

WPRDASHBOARD();
function WPRDASHBOARD() {
	return WPR_Dashboard::get_instance();
}