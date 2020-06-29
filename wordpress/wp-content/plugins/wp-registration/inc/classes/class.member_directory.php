<?php
/**
 * WPR_User class will handle User State
 **/
 if( ! defined("ABSPATH" ) )
        die("Not Allewed");

class WPR_MemberDirectory {

    private static $ins = null;

    function __construct() {

        add_shortcode( 'wpr-member-dir',  array($this, 'render_member_dir' ));
        add_action('user_by_role', array($this, 'get_users_by_role'));
    }

    public static function get_instance() {
        // create a new object if it doesn't exist.
        is_null(self::$ins) && self::$ins = new self;
        return self::$ins;
    }

    function load_dashboard_script(){

        // bootstrap file load
        wp_enqueue_style('wpr-dashboard-bsrtp', WPR_URL."/css/bootstrap.min.css");
        wp_enqueue_style('wpr-member-dir-css', WPR_URL."/css/wpr-member-dir.css");
        wp_enqueue_script('wpr-bsrp', WPR_URL."/js/bootstrap.min.js", array('jquery'), WPR_VERSION, true);
       
    }

/*---------------------------------------------------------
    This shortcode to display all user by role 
--------------------------------------------------------*/
    function render_member_dir() {
        $this -> load_dashboard_script();


        ob_start();

        $member_template   = "member-directory.php";
        $template_vars      = array( "member" => $this );  
        $profile_template   = apply_filters('wpr_member_dir', $member_template , $template_vars);
        // wpr_load_templates( $member_template, $template_vars );

        $wpr_member = ob_get_clean();

        return $wpr_member;
    }
    

    function get_user($role){
        $args = array('role'=>$role,
                        'meta_query' => array(
                            array(
                                'key' => 'wpr_form_id',
                                'compare' => 'EXISTS' // this should work...
                            ),
                        )
                    );
        $get_users = get_users( $args );
        return $get_users;
    }

    // get all user by role
    function get_users_by_role(){
        $user_roles = WPR_Settings()->get_option('membr_rl');
        // if (empty($user_roles)) 
            
        
        $admin = $subscriber = $editor = $author = $contributor = array();
        if ($user_roles) {
            # code...
        foreach ($user_roles as $id => $role) {
            switch ($role) {
                case 'administrator':
                    $admin       = $this->get_user('administrator');
                    break;
                case 'subscriber':
                    $subscriber  = $this->get_user('subscriber');
                    break;
                case 'editor':
                        $editor  = $this->get_user('editor');
                    break;
                case 'author':
                    $author      = $this->get_user('author');
                    break;
                case 'contributor':
                    $contributor = $this->get_user('contributor');
                    break;

            }
        }
        $all_user_by_role = array_merge($admin,$subscriber,$editor,$author,$contributor);
             
        return $all_user_by_role;
        }
    }

}

WPRMEMBERDIRECTORY();
function WPRMEMBERDIRECTORY() {
    return WPR_MemberDirectory::get_instance();
}