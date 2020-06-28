<?php
/*
Plugin Name: Efavourite Posts
Plugin URI: https://wordpress.org/plugins/efavourite-posts/
Author: Excellent Webworld
Description: Excellent Webworld is an IT company focus on Web Development and Application Development.
Version: 1.2
Author URI: https://excellentwebworld.com/
License: GPL v3
*/
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}
define('EFAV_PATH', plugins_url() . '/efavourite-posts');
define('EFAV_META_KEY', "efav_posts");
define('EFAV_USER_OPTION_KEY', "efav_useroptions");
define('EFAV_COOKIE_KEY', "efav-posts");


if ( !defined( 'EFAV_DEFAULT_PRIVACY_SETTING' ) )
    define( 'EFAV_DEFAULT_PRIVACY_SETTING', false );

$efav_mode = 1;

function efav_posts_load_translation() 
{
    load_plugin_textdomain("efav-posts",false,dirname(plugin_basename(__FILE__)).'/lang');
}

add_action( 'plugins_loaded', 'efav_posts_load_translation' );

function efav_posts() {
    if (isset($_REQUEST['efavaction'])):
        global $efav_mode;
        $efav_mode = isset($_REQUEST['efav_ajax']) ? $_REQUEST['efav_ajax'] : false;
        if ($_REQUEST['efavaction'] == 'efav_add') {
            efav_add_favourite();
        } else if ($_REQUEST['efavaction'] == 'efav_remove') {
            efav_remove_favourite();
        } else if ($_REQUEST['efavaction'] == 'efav_clear') {
            if (efav_clear_favourites()) efav_die_or_go(efav_get_option('efav_cleared'));
            else efav_die_or_go("ERROR");
        }
    endif;
}
add_action('wp_loaded', 'efav_posts');

function efav_add_favourite($efav_post_id = "") {
    if ( empty($efav_post_id) ) $efav_post_id = $_REQUEST['efav_postid'];
    if (efav_get_option('efav_opt_only_registered') && !is_user_logged_in() ) {
        efav_die_or_go(efav_get_option('efav_text_only_registered') );
        return false;
    }

    if (efav_do_add_to_list($efav_post_id)) {
        // added, now?
        do_action('efav_after_add', $efav_post_id);
        if (efav_get_option('efav_statistics')) efav_update_post_meta($efav_post_id, 1);
        if (efav_get_option('efav_added') == 'show remove link') {
            $efav_str = efav_link(1, "efav_remove", 0, array( 'efav_post_id' => $efav_post_id ) );
            efav_die_or_go($efav_str);
        } else {
            efav_die_or_go(efav_get_option('efav_added'));
        }
    }
}

function efav_do_add_to_list($efav_post_id) {
    if (efav_check_favourited($efav_post_id))
        return false;
    if (is_user_logged_in()) {
        return efav_add_to_usermeta($efav_post_id);
    } else {
        return efav_set_cookie($efav_post_id, "efav_added");
    }
}

function efav_remove_favourite($efav_post_id = "") {
    if (empty($efav_post_id)) $efav_post_id = $_REQUEST['efav_postid'];
    if (efav_do_remove_favourite($efav_post_id)) {
        do_action('efav_after_remove', $efav_post_id);
        if (efav_get_option('efav_statistics')) efav_update_post_meta($efav_post_id, -1);
        if (efav_get_option('efav_removed') == 'show add link') {
            if ( isset($_REQUEST['page']) && $_REQUEST['page'] == 1 ):
                $efav_str = '';
            else:
                $efav_str = efav_link(1, "efav_add", 0, array( 'efav_post_id' => $efav_post_id ) );
            endif;
            efav_die_or_go($efav_str);
        } else {
            efav_die_or_go(efav_get_option('efav_removed'));
        }
    }
    else return false;
}

function efav_die_or_go($efav_str) {
    global $efav_mode;
    if ($efav_mode):
        die($efav_str);
    else:
        wp_redirect($_SERVER['HTTP_REFERER']);
    endif;
}

function efav_add_to_usermeta($efav_post_id) {
    $efav_favourites_old = efav_get_user_meta();
    if($efav_favourites_old != '')
    {
        $efav_favourites_old_arr = json_decode($efav_favourites_old);
        $efav_favourites_old_arr[] = $efav_post_id; 
        $efav_favourites_json = json_encode($efav_favourites_old_arr);
    }
    else
    {
        $efav_favourites_arr[] = $efav_post_id; 
        $efav_favourites_json = json_encode($efav_favourites_arr);
    }
    efav_update_user_meta($efav_favourites_json);
    return true;
}

function efav_check_favourited($efav_cid) {
    if (is_user_logged_in()) {
        $efav_post_ids = json_decode(efav_get_user_meta());
        if ($efav_post_ids)
            foreach ($efav_post_ids as $efav_fpost_id)
                if ($efav_fpost_id == $efav_cid) return true;
	} else {
        $efav_cookie_data = efav_get_cookie();
	    if (efav_get_cookie()):
	        foreach (efav_get_cookie() as $efav_fpost_id => $efav_val)
	            if ($efav_fpost_id == $efav_cid) return true;
	    endif;
	}
    return false;
}

function efav_link( $efav_return = 0, $efav_action = "", $efav_show_span = 1, $efav_args = array() ) {
    global $post;
    $efav_post_id = &$post->ID;
     $efav_post_type_name = get_post_type($efav_post_id);
     $efav_post_options = get_option('efav_multi_posts_options');
    if(!is_array($efav_post_options))
    {  
      $posts_in_db[] = "post";  
    } 
    else
    {
     $posts_in_db = get_option('efav_multi_posts_options');
     $posts_in_db[] = "post";
    }  
    extract($efav_args);
    $efav_str = "";
    if ($efav_show_span)
        $efav_str = "<span class='efav-span'>";
    if(in_array($efav_post_type_name, $posts_in_db))
    {
        $efav_str .= efav_before_link_img();
    }
    else
    {
        $efav_str .= "";
    }
    $efav_str .= efav_loading_img();
    if ($efav_action == "efav_remove"):
        $efav_str .= efav_link_html($efav_post_id, efav_get_option('efav_remove_favourite'), "efav_remove");
    elseif ($efav_action == "efav_add"):
        $efav_str .= efav_link_html($efav_post_id, efav_get_option('efav_add_favourite'), "efav_add");
    elseif (efav_check_favourited($efav_post_id)):
        $efav_str .= efav_link_html($efav_post_id, efav_get_option('efav_remove_favourite'), "efav_remove");
    else:
        $efav_str .= efav_link_html($efav_post_id, efav_get_option('efav_add_favourite'), "efav_add");
    endif;
    if ($efav_show_span)
        $efav_str .= "</span>";
    if ($efav_return) { return $efav_str; } else { echo $efav_str; }
}

function efav_link_html($efav_post_id, $efav_opt, $efav_action) {
    $efav_post_type_name = get_post_type($efav_post_id);
    $efav_post_options = get_option('efav_multi_posts_options');
    if(!is_array($efav_post_options))
    {  
      $posts_in_db[] = "post";  
    } 
    else
    {
     $posts_in_db = get_option('efav_multi_posts_options');
     $posts_in_db[] = "post";
    }  
    if(in_array($efav_post_type_name, $posts_in_db))
    {
        $efav_link = "<a class='efav-link' href='?efavaction=".$efav_action."&amp;efav_postid=". esc_attr($efav_post_id) . "' title='". $efav_opt ."' rel='nofollow'>". $efav_opt ."</a>";
    }
    else
    {
        $efav_link = "";
    }
    
    $efav_link = apply_filters( 'efav_link_html', $efav_link );
    return $efav_link;
}

function efav_get_users_favourites($efav_user = "") {
    $efav_post_ids = array();

    if (!empty($efav_user)):
        return efav_get_user_meta($efav_user);
    endif;

    # collect favourites from cookie and if user is logged in from database.
    if (is_user_logged_in()):
        $efav_post_ids = efav_get_user_meta();
	else:
	    if (efav_get_cookie()):
	        foreach (efav_get_cookie() as $efav_post_id => $efav_post_title) {
	            array_push($efav_post_ids, $efav_post_id);
	        }
	    endif;
	endif;
    return $efav_post_ids;
}

function efav_list_favourite_posts( $efav_args = array() ) {
    $efav_user = isset($_REQUEST['efav_user']) ? $_REQUEST['efav_user'] : "";
    extract($efav_args);
    global $efav_post_ids;
    if ( !empty($efav_user) ) {
        if ( efav_is_user_favlist_public($efav_user) )
            $efav_post_ids = efav_get_users_favourites($efav_user);

    } else {
        $efav_post_ids = efav_get_users_favourites();
    }

	if ( @file_exists(TEMPLATEPATH.'/efav-page-template.php') || @file_exists(STYLESHEETPATH.'/efav-page-template.php') ):
        if(@file_exists(TEMPLATEPATH.'/efav-page-template.php')) :
            include(TEMPLATEPATH.'/efav-page-template.php');
        else :
            include(STYLESHEETPATH.'/efav-page-template.php');
        endif;
    else:
        include("efav-page-template.php");
    endif;
}

function efav_list_most_favourited($efav_limit=5) {
    global $wpdb;
    $efav_query = "SELECT post_id, meta_value, post_status FROM $wpdb->postmeta";
    $efav_query .= " LEFT JOIN $wpdb->posts ON post_id=$wpdb->posts.ID";
    $efav_query .= " WHERE post_status='publish' AND meta_key='".EFAV_META_KEY."' AND meta_value > 0 ORDER BY ROUND(meta_value) DESC LIMIT 0, $efav_limit";
    $efav_results = $wpdb->get_results($efav_query);
    if ($efav_results) {
        echo "<ul>";
        foreach ($efav_results as $efav_o):
            $efav_p = get_post($efav_o->post_id);
            echo "<li>";
            echo "<a href='".get_permalink($efav_o->post_id)."' title='". $efav_p->post_title ."'>" . $efav_p->post_title . "</a> ($efav_o->meta_value)";
            echo "</li>";
        endforeach;
        echo "</ul>";
    }
}

include("efav-widgets.php");

function efav_loading_img() {
    return "<img src='".EFAV_PATH."/img/image_1185398.gif' alt='Loading' title='Loading' class='efav-hide efav-img' />";
}

function efav_before_link_img() {
    $efav_options = efav_get_options();
    $efav_option = $efav_options['efav_before_image'];
    if ($efav_option == '') {
        return "";
    } else if ($efav_option == 'efav_custom') {
        return "<img src='" . $efav_options['efav_custom_before_image'] . "' alt='favourite' title='favourite' class='efav-img' />";
    } else {
        return "<img src='". EFAV_PATH . "/img/" . $efav_option . "' alt='favourite' title='favourite' class='efav-img' />";
    }
}

function efav_clear_favourites() {
    if (efav_get_cookie()):
        foreach (efav_get_cookie() as $efav_post_id => $efav_val) {
            efav_set_cookie($efav_post_id, "");
            efav_update_post_meta($efav_post_id, -1);
        }
    endif;
    if (is_user_logged_in()) {
        $efav_post_ids = efav_get_user_meta();
        if ($efav_post_ids):
            foreach ($efav_post_ids as $efav_post_id) {
                efav_update_post_meta($efav_post_id, -1);
            }
        endif;
        if (!delete_user_meta(efav_get_user_id(), EFAV_META_KEY)) {
            return false;
        }
    }
    return true;
}

function efav_do_remove_favourite($efav_post_id) {
    if (!efav_check_favourited($efav_post_id))
        return true;

    $efav_a = true;
    if (is_user_logged_in()) {
        $efav_user_favourites = json_decode(efav_get_user_meta());
        $efav_user_favourites = array_diff($efav_user_favourites, array($efav_post_id));
        $efav_user_favourites = array_values($efav_user_favourites);
        $efav_user_favourites = json_encode($efav_user_favourites);
        $efav_a = efav_update_user_meta($efav_user_favourites);
    }
    if ($efav_a) $efav_a = efav_set_cookie($_REQUEST['efav_postid'], "");
    return $efav_a;
}

function efav_content_filter($efav_content) {
    if (is_page()):
        if (strpos($efav_content,'{{efav-favourite-posts}}')!== false) {
            $efav_content = str_replace('{{efav-favourite-posts}}', efav_list_favourite_posts(), $efav_content);
        }
    endif;

    if (strpos($efav_content,'[efav-link]')!== false) {
        $efav_content = str_replace('[efav-link]', efav_link(1), $efav_content);
    }

    if (is_single()) {
        if (efav_get_option('efav_autoshow') == 'before') {
            $efav_content = efav_link(1) . $efav_content;
        } else if (efav_get_option('efav_autoshow') == 'after') {
            $efav_content .= efav_link(1);
        }
    }
    return $efav_content;
}
add_filter('the_content','efav_content_filter');

function efav_shortcode_func() {
    efav_list_favourite_posts();
}
add_shortcode('efav-favourite-posts', 'efav_shortcode_func');


function efav_add_js_script() {
		wp_enqueue_script( "efav-favourite-posts", EFAV_PATH . "/efav.js", array( 'jquery' ) );
}
add_action('wp_print_scripts', 'efav_add_js_script');

function efav_wp_print_styles() {
	echo "<link rel='stylesheet' id='efav-css' href='" . EFAV_PATH . "/efav.css' type='text/css' />" . "\n";
}
add_action('wp_print_styles', 'efav_wp_print_styles');

function efav_init() {
    $efav_options = array();
    $efav_options['efav_add_favourite'] = "Add to favourites";
    $efav_options['efav_added'] = "Added to favourites!";
    $efav_options['efav_remove_favourite'] = "Remove from favourites";
    $efav_options['efav_removed'] = "Removed from favourites!";
    $efav_options['efav_clear'] = "Clear favourites";
    $efav_options['efav_cleared'] = "<p>favourites cleared!</p>";
    $efav_options['efav_favourites_empty'] = "favourite list is empty.";
    $efav_options['efav_cookie_warning'] = "Your favourite posts saved to your browsers cookies. If you clear cookies also favourite posts will be deleted.";
    $efav_options['efav_rem'] = "remove";
    $efav_options['efav_text_only_registered'] = "Only registered users can favourite!";
    $efav_options['efav_statistics'] = 1;
    $efav_options['efav_widget_title'] = '';
    $efav_options['efav_widget_limit'] = 5;
    $efav_options['efav_uf_widget_limit'] = 5;
    $efav_options['efav_before_image'] = 'efav-star.png';
    $efav_options['efav_custom_before_image'] = '';
    $efav_options['efav_post_per_page'] = 20;
    $efav_options['efav_autoshow '] = '';
    $efav_options['efav_opt_only_registered'] = 0;
    $efav_multi_posts_options = '';
    add_option('efav_options', $efav_options);
    add_option('efav_multi_posts_options', $efav_multi_posts_options);
}
add_action('activate_efavourite-posts/efavourite-posts.php', 'efav_init');

function efav_config() { include('efav-admin.php'); }

function efav_config_page() {
        add_menu_page(__('EFAV Posts'), __('Efavourite Posts'), 'manage_options', 'efav-favourite-posts', 'efav_config','',10);
}
add_action('admin_menu', 'efav_config_page');

function efav_update_user_meta($efav_arr) {
    $efav_post_data = $efav_arr;
    return update_user_meta(efav_get_user_id(),EFAV_META_KEY,$efav_post_data);
}

function efav_update_post_meta($efav_post_id, $efav_val) {
	$efav_oldval = efav_get_post_meta($efav_post_id);
	if ($efav_val == -1 && $efav_oldval == 0) {
    	$efav_val = 0;
	} else { 
        $efav_oldval = 0;
		$efav_val = $efav_oldval + $efav_val;
	}
    return add_post_meta($efav_post_id, EFAV_META_KEY, $efav_val, true) or update_post_meta($efav_post_id, EFAV_META_KEY, $efav_val);
}

function efav_delete_post_meta($efav_post_id) {
    return delete_post_meta($efav_post_id, EFAV_META_KEY);
}

function efav_get_cookie() {
    if (!isset($_COOKIE[EFAV_COOKIE_KEY])) return;
    return $_COOKIE[EFAV_COOKIE_KEY];
}

function efav_get_options() {
   return get_option('efav_options');
}

function efav_get_user_id() {
    global $current_user;
    get_currentuserinfo();
    return $current_user->ID;
}

function efav_get_user_meta($efav_user = "") {
    if (!empty($efav_user)):
        $efav_userdata = get_user_by( 'login', $efav_user );
        $efav_user_id = $efav_userdata->ID;
        return get_user_meta($efav_user_id, EFAV_META_KEY, true);
    else:
        return get_user_meta(efav_get_user_id(), EFAV_META_KEY, true);
    endif;
}

function efav_get_post_meta($efav_post_id) {
    $efav_val = get_post_meta($efav_post_id, EFAV_META_KEY, true);
    if ($efav_val < 0) $efav_val = 0;
    return $efav_val;
}

function efav_set_cookie($efav_post_id, $efav_str) {
    $efav_expire = time()+60*60*24*30;
    return setcookie("efav-posts[$efav_post_id]", $efav_str, $efav_expire, "/");
}

function efav_is_user_favlist_public($efav_user) {
    $efav_user_opts= efav_get_user_options($efav_user);
    if (empty($efav_user_opts)) return EFAV_DEFAULT_PRIVACY_SETTING;
    if ($efav_user_opts["efav_is_efav_list_public"])
        return true;
    else
        return false;
}

function efav_get_user_options($efav_user) {
    $efav_userdata = get_user_by( 'login', $efav_user );
    $efav_user_id = $efav_userdata->ID;
    return get_user_meta($efav_user_id, EFAV_USER_OPTION_KEY, true);
}

function efav_is_user_can_edit() {
    if (isset($_REQUEST['efav_user']) && $_REQUEST['efav_user'])
        return false;
    return true;
}

function efav_remove_favourite_link($efav_post_id) {
    if (efav_is_user_can_edit()) {
        $efav_options = efav_get_options();
        $class = 'efav-link remove-parent';
        $efav_link = "<a id='rem_$efav_post_id' class='$class' href='?efavaction=efav_remove&amp;page=1&amp;efav_postid=". $efav_post_id ."' title='".efav_get_option('efav_rem')."' rel='nofollow'>".efav_get_option('efav_rem')."</a>";
        $efav_link = apply_filters( 'efav_remove_favourite_link', $efav_link );
        echo $efav_link;
    }
}

function efav_clear_list_link() {
    if (efav_is_user_can_edit()) {
        $efav_options = efav_get_options();
        echo "<div class='efav-clear-fav'>";
        echo efav_before_link_img();
        echo efav_loading_img();
        echo "<a class='efav-link' href='?efavaction=efav_clear' rel='nofollow'>". efav_get_option('efav_clear') . "</a>";
        echo "</div>";
    }
}

function efav_cookie_warning() {
    if (!is_user_logged_in() && !isset($_GET['efav_user']) ):
        echo "<p>".efav_get_option('efav_cookie_warning')."</p>";
    endif;
}

function efav_get_option($efav_opt) {
    $efav_options = efav_get_options();
    return htmlspecialchars_decode( stripslashes ( $efav_options[$efav_opt] ) );
}

function efav_load_custom_wp_admin_style() {
        wp_register_style( 'efav_custom_wp_admin_css', plugin_dir_url( __FILE__ ) . 'efav-style.css', false, '1.0.0' );
        wp_enqueue_style( 'efav_custom_wp_admin_css' );
}
add_action( 'admin_enqueue_scripts', 'efav_load_custom_wp_admin_style' );
