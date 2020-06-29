<?php

class WPR_FontIcons {

	function __construct() {
		
		if ( !get_option('wpr_icon_cache_fonticons') ) {
		
			$files['ii'] = WPR_PATH . '/css/wpr-fonticons-ii.css';
			$files['fa'] = WPR_PATH . '/css/wpr-fonticons-fa.css';
			
			foreach( $files as $c => $file ) {

				$css = file_get_contents($file);
				
				if ( $c == 'fa' ) {
					preg_match_all('/(wpr-faicon-.*?)\s?\{/', $css, $matches);
				} else {
					preg_match_all('/(wpr-icon-.*?)\s?\{/', $css, $matches);
				}

				unset($matches[1][0]);
				foreach($matches[1] as $match) {
					$icon = str_replace(':before','',$match);
					$array[] = $icon;
				}
			}
			
			update_option('wpr_icon_cache_fonticons', $array);
		}
		
		$this->all = get_option('wpr_icon_cache_fonticons');	
	}

	/*
		fields icons handle
	*/
	function wpr_icons_render($id, $value, $field_id, $field_index){
		$wpr_icons = $this->all;

        $existing_name = 'name="wpr['.esc_attr($field_index).']['.esc_attr($field_id).']['.esc_attr($id).']"';

        $icon_btn 	= '';
        $icon_model = '';
        $empty_icon = '';

	    if( $field_index != '') {
	        $icon_btn = '#model_no_'.$field_index;
	    }
	    if( $field_index != '') {
	        $icon_model = 'model_no_'.$field_index;
	    }
	    if( $value == '') {
	    	$empty_icon  = 'No Icon';
	    }
	    $html  = ''; 
	 	$html .= '<div class="wpr_field_icons_wrapper">';
		 	$html .='<p>';
				$html .= '<button class="wpr_add_icon_btn btn btn-sm" data-toggle="modal" data-target="'.esc_attr($icon_btn).'">'.esc_html__( 'Add Icon', 'wp-registration' ).'</button>';
			 	$html .= '<span class="wpr_icon_append">'.
			 			esc_attr($empty_icon);
			 	$html .= '<i class="'.esc_attr($value).'"></i>';
			 	$html .= '</span>';
			 	$html .= '<input type="hidden" class="wpr_icon_handle" data-metatype="'.esc_attr($id).'" value="'.esc_attr($value).'"';
			 	   	if( $field_index != '') {
			          	$html .= $existing_name;
			        }
			 	$html .= '>';
			 	
			 	$html .= '<span class="wpr_admin_icon_clear" style="display: none;"><i class="wpr-icon-android-cancel"></i></span>';
		 	$html .='</p>';
	 	$html .= '</div>';

	  	// Modal
		$html .= '<div class="modal fade wpr_icon_model_index" id="'.esc_attr($icon_model).'" role="dialog">';
	    	$html .= '<div class="modal-dialog">';
	       		$html .= '<div class="modal-content">';
	            	$html .= '<div class="modal-header" style="background-color: #00a0d2b3;">';
	            		$html .= '<button class="wpr_attr_add_icon btn btn-success" data-add-icon="">'.esc_html__( 'Add Icon', 'wp-registration' ).'</button>';
	            		$html .= '<span class="wpr-icon-add-notice"></span>';
	            		$html .= '<h4 class="modal-title">'.esc_html__( 'Icons', 'wp-registration' ).'</h4>';
	            	$html .= '</div>';
	            	$html .= '<div class="modal-body wpr-icon-model-scrol">';
	            		// search icon area
						$html .= '<div class="wpr-search-icon-area">';
							$html .= '<input type="text" name="_icon_search" class="form-control wpr_icon_find" value="" placeholder="'.__( 'search icons...', 'wp-registration' ).'"/>';
						$html .= '</div>';

						// icon list area
	                    $html .= '<div class="wpr-admin-icons">';
	                        foreach($wpr_icons as $icon){
	                
	                        	$html .= '<span data-code="'.esc_attr($icon).'" title="'.esc_attr($icon).'"><i class="'.esc_attr($icon).'"></i></span>';
	                       } 
	                    $html .= '</div>';
	            	$html .= '</div>';
	            	$html .='<div class="modal-footer">';
	                	$html .= '<button class="btn btn-default close-icon-model" id="'.esc_attr($field_index).'">'.esc_html__( 'close', 'wp-registration' ).'</button>';
	            	$html .= '</div>';
	        	$html .='</div>';
	    	$html .= '</div>';
		$html .='</div>';

	return $html;
	
	}
}