<?php
/* 
** create the Custome post typr
*/

    // not run if accessed directly
    if( ! defined('ABSPATH' ) ){
  	    die("Not Allowed");
    }

	function wpr_cpt_register_post() {

		// 'wpr' post type lable
		$labels = array(
				'name'               => _x( 'WP Register', 'wp-registration' ),
				'add_new'            => _x( 'Add New', 'wp-registration'),
				'add_new_item'       => __( 'Add New', 'wp-registration'),
				'edit'				 => __('Edit us', 'wp-registration'),
				'new_item'           => __( 'New Form', 'wp-registration' ),
				'edit_item'          => __( 'Edit Form', 'wp-registration' ),
				'view'				 => __('View', 'wp-registration'),
				'view_item'          => __( 'Form', 'wp-registration' ),
				'all_items'          => __( 'Forms', 'wp-registration' ),
				'search_items'       => __( 'Search Forms', 'wp-registration'),
				'not_found'          => __( 'No Form found.', 'wp-registration' ),
				'not_found_in_trash' => __( 'No Forms found in Trash.', 'wp-registration' ),
				'parent'			 => __( 'Parent Form', 'wp-registration' 
										   ),
			);

			$args = array(
				'labels'             => $labels,
		        'description'        => __( 'Registration Forms', 'wp-registration' ),
		        'public' => true,
		        'menu_position' => 20,
		        'menu_icon' => WPR_URL.'/images/logo.png',
		        'has_archive' => true,
		        'supports' => array('title')
			);

			register_post_type( 'wpr', $args );
}