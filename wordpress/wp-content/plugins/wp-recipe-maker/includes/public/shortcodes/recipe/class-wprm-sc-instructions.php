<?php
/**
 * Handle the recipe instructions shortcode.
 *
 * @link       http://bootstrapped.ventures
 * @since      3.3.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public/shortcodes/recipe
 */

/**
 * Handle the recipe instructions shortcode.
 *
 * @since      3.3.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public/shortcodes/recipe
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_SC_Instructions extends WPRM_Template_Shortcode {
	public static $shortcode = 'wprm-recipe-instructions';

	public static function init() {
		$atts = array(
			'id' => array(
				'default' => '0',
			),
			'group_tag' => array(
				'default' => 'h4',
				'type' => 'dropdown',
				'options' => 'header_tags',
			),
			'group_style' => array(
				'default' => 'bold',
				'type' => 'dropdown',
				'options' => 'text_styles',
			),
			'list_style' => array(
				'default' => 'decimal',
				'type' => 'dropdown',
				'options' => 'list_style_types',
			),
			'list_style_continue_numbers' => array(
				'default' => '0',
				'type' => 'toggle',
				'dependency' => array(
					'id' => 'list_style',
					'value' => 'advanced',
				),
			),
			'list_style_background' => array(
				'default' => '#444444',
				'type' => 'color',
				'dependency' => array(
					'id' => 'list_style',
					'value' => 'advanced',
				),
			),
			'list_style_size' => array(
				'default' => '18px',
				'type' => 'size',
				'dependency' => array(
					'id' => 'list_style',
					'value' => 'advanced',
				),
			),
			'list_style_text' => array(
				'default' => '#ffffff',
				'type' => 'color',
				'dependency' => array(
					'id' => 'list_style',
					'value' => 'advanced',
				),
			),
			'list_style_text_size' => array(
				'default' => '12px',
				'type' => 'size',
				'dependency' => array(
					'id' => 'list_style',
					'value' => 'advanced',
				),
			),
			'text_margin' => array(
				'default' => '0px',
				'type' => 'size',
			),
			'image_size' => array(
				'default' => 'thumbnail',
				'type' => 'image_size',
			),
			'image_alignment' => array(
				'default' => 'left',
				'type' => 'dropdown',
				'options' => array(
					'left' => 'Left',
					'center' => 'Center',
					'right' => 'Right',
				),
			),
			'image_position' => array(
				'default' => 'after',
				'type' => 'dropdown',
				'options' => array(
					'before' => 'Before Text',
					'after' => 'After Text',
				),
			),
			'media_toggle' => array(
				'default' => '',
				'type' => 'dropdown',
				'options' => array(
					'' => "Don't show",
					'header' => 'Show media toggle in the header',
					'before' => 'Show media toggle before the instructions',
				),
			),
			'toggle_text_style' => array(
				'default' => 'normal',
				'type' => 'dropdown',
				'options' => 'text_styles',
				'dependency' => array(
					'id' => 'media_toggle',
					'value' => '',
					'type' => 'inverse',
				),
			),
			'toggle_button_background' => array(
				'default' => '#ffffff',
				'type' => 'color',
				'dependency' => array(
					'id' => 'media_toggle',
					'value' => '',
					'type' => 'inverse',
				),
			),
			'toggle_button_accent' => array(
				'default' => '#333333',
				'type' => 'color',
				'dependency' => array(
					'id' => 'media_toggle',
					'value' => '',
					'type' => 'inverse',
				),
			),
			'toggle_button_radius' => array(
				'default' => '3px',
				'type' => 'size',
				'dependency' => array(
					'id' => 'media_toggle',
					'value' => '',
					'type' => 'inverse',
				),
			),
			'toggle_on_icon' => array(
				'default' => 'camera-2',
				'type' => 'icon',
				'dependency' => array(
					'id' => 'media_toggle',
					'value' => '',
					'type' => 'inverse',
				),
			),
			'toggle_on_text' => array(
				'default' => '',
				'type' => 'text',
				'dependency' => array(
					'id' => 'media_toggle',
					'value' => '',
					'type' => 'inverse',
				),
			),
			'toggle_off_icon' => array(
				'default' => 'camera-no',
				'type' => 'icon',
				'dependency' => array(
					'id' => 'media_toggle',
					'value' => '',
					'type' => 'inverse',
				),
			),
			'toggle_off_text' => array(
				'default' => '',
				'type' => 'text',
				'dependency' => array(
					'id' => 'media_toggle',
					'value' => '',
					'type' => 'inverse',
				),
			),
		);
	
		$atts = array_merge( WPRM_Shortcode_Helper::get_section_atts(), $atts );
		self::$attributes = $atts;

		parent::init();
	}

	/**
	 * Output for the shortcode.
	 *
	 * @since	3.3.0
	 * @param	array $atts Options passed along with the shortcode.
	 */
	public static function shortcode( $atts ) {
		$atts = parent::get_attributes( $atts );

		$recipe = WPRM_Template_Shortcodes::get_recipe( $atts['id'] );
		if ( ! $recipe || ! $recipe->instructions() ) {
			return '';
		}

		// Output.
		$classes = array(
			'wprm-recipe-instructions-container',
			'wprm-block-text-' . $atts['text_style'],
		);

		// Args for optional unit conversion and adjustable servings.
		$media_toggle_atts = array(
			'id' => $atts['id'],
			'text_style' => $atts['toggle_text_style'],
			'button_background' => $atts['toggle_button_background'],
			'button_accent' => $atts['toggle_button_accent'],
			'button_radius' => $atts['toggle_button_radius'],
			'on_icon' => $atts['toggle_on_icon'],
			'on_text' => $atts['toggle_on_text'],
			'off_icon' => $atts['toggle_off_icon'],
			'off_text' => $atts['toggle_off_text'],
		);

		$output = '<div class="' . implode( ' ', $classes ) . '">';
		$output .= WPRM_Shortcode_Helper::get_section_header( $atts, 'instructions', array(
			'media_toggle_atts' => $media_toggle_atts,
		) );

		if ( 'before' === $atts['media_toggle'] ) {
			$output .= WPRM_SC_Media_Toggle::shortcode( $media_toggle_atts );
		}

		$instructions = $recipe->instructions();
		foreach ( $instructions as $group_index => $instruction_group ) {
			$output .= '<div class="wprm-recipe-instruction-group">';

			if ( $instruction_group['name'] ) {
				$classes = array(
					'wprm-recipe-group-name',
					'wprm-recipe-instruction-group-name',
					'wprm-block-text-' . $atts['group_style'],
				);

				$tag = trim( $atts['group_tag'] );
				$output .= '<' . $tag . ' class="' . implode( ' ', $classes ) . '">' . $instruction_group['name'] . '</' . $tag . '>';
			}

			$output .= '<ul class="wprm-recipe-instructions">';

			foreach ( $instruction_group['instructions'] as $index => $instruction ) {
				$list_style_type = 'checkbox' === $atts['list_style'] || 'advanced' === $atts['list_style'] ? 'none' : $atts['list_style'];
				$style = 'list-style-type: ' . $list_style_type . ';';
				$output .= '<li id="wprm-recipe-' . $recipe->id() . '-step-' . $group_index . '-' . $index . '" class="wprm-recipe-instruction" style="' . $style . '">';

				if ( 'before' === $atts['image_position'] ) {
					$output .= self::instruction_media( $recipe, $instruction, $atts );
				}
				if ( $instruction['text'] ) {
					$text_style = '';
					if ( '0px' !== $atts['text_margin'] ) {
						$text_style = ' style="margin-bottom: ' . $atts['text_margin'] . '"';
					}

					$text = parent::clean_paragraphs( $instruction['text'] );
					$instruction_text = '<div class="wprm-recipe-instruction-text"' . $text_style . '>' . $text . '</div>';

					// Output checkbox.
					if ( 'checkbox' === $atts['list_style'] ) {
						$instruction_text = apply_filters( 'wprm_recipe_instructions_shortcode_checkbox', $instruction_text );
					}
					$output .= $instruction_text;
				}
				if ( 'after' === $atts['image_position'] ) {
					$output .= self::instruction_media( $recipe, $instruction, $atts );
				}

				$output .= '</li>';
			}

			$output .= '</ul>';
			$output .= '</div>';
		}

		$output .= '</div>';

		return apply_filters( parent::get_hook(), $output, $atts, $recipe );
	}

	/**
	 * Output the instruction media.
	 *
	 * @since	5.11.0
	 * @param	mixed $recipe		Recipe to output the instruction for.
	 * @param	mixed $instruction	Instruction to output the media for.
	 * @param	mixed $atts			Shortcode attributes.
	 */
	private static function instruction_media( $recipe, $instruction, $atts ) {
		$output = '';

		if ( $instruction['image'] ) {
			$output = '<div class="wprm-recipe-instruction-media wprm-recipe-instruction-image" style="text-align: ' . $atts['image_alignment'] . ';">' . self::instruction_image( $recipe, $instruction, $atts['image_size'] ) . '</div> ';
		} else if ( isset( $instruction['video'] ) && isset( $instruction['video']['type'] ) && in_array( $instruction['video']['type'], array( 'upload', 'embed' ) ) ) {
			$output = '<div class="wprm-recipe-instruction-media wprm-recipe-instruction-video">' . self::instruction_video( $recipe, $instruction ) . '</div> ';
		}

		return $output;
	}

	/**
	 * Output an instruction image.
	 *
	 * @since	3.3.0
	 * @param	mixed $recipe			  Recipe to output the instruction for.
	 * @param	mixed $instruction		  Instruction to output the image for.
	 * @param	mixed $default_image_size Default image size to use.
	 */
	private static function instruction_image( $recipe, $instruction, $default_image_size ) {
		$settings_size = 'legacy' === WPRM_Settings::get( 'recipe_template_mode' ) ? WPRM_Settings::get( 'template_instruction_image' ) : false;
		$size = $settings_size ? $settings_size : $default_image_size;

		preg_match( '/^(\d+)x(\d+)$/i', $size, $match );
		if ( ! empty( $match ) ) {
			$size = array( intval( $match[1] ), intval( $match[2] ) );
		}

		$img = wp_get_attachment_image( $instruction['image'], $size );

		// Prevent instruction image from getting stretched in Gutenberg preview.
		if ( isset( $GLOBALS['wp']->query_vars['rest_route'] ) && '/wp/v2/block-renderer/wp-recipe-maker/recipe' === $GLOBALS['wp']->query_vars['rest_route'] ) {
			$image_data = wp_get_attachment_image_src( $instruction['image'], $size );
			if ( $image_data[1] ) {
				$style = 'max-width: ' . $image_data[1] . 'px;';

				if ( false !== stripos( $img, ' style="' ) ) {
					$img = str_ireplace( ' style="', ' style="' . $style, $img );
				} else {
					$img = str_ireplace( '<img ', '<img style="' . $style . '" ', $img );
				}
			}
		}

		// Disable instruction image pinning.
		if ( WPRM_Settings::get( 'pinterest_nopin_instruction_image' ) ) {
			$img = str_ireplace( '<img ', '<img data-pin-nopin="true" ', $img );
		}

		// Clickable images.
		if ( WPRM_Settings::get( 'instruction_image_clickable' ) ) {
			$settings_size = WPRM_Settings::get( 'clickable_image_size' );

			preg_match( '/^(\d+)x(\d+)$/i', $settings_size, $match );
			if ( ! empty( $match ) ) {
				$size = array( intval( $match[1] ), intval( $match[2] ) );
			} else {
				$size = $settings_size;
			}

			$clickable_image = wp_get_attachment_image_src( $instruction['image'], $size );
			$clickable_image_url = $clickable_image && isset( $clickable_image[0] ) ? $clickable_image[0] : '';
			if ( $clickable_image_url ) {
				$img = '<a href="' . esc_url( $clickable_image_url ) . '">' . $img . '</a>';
			}
		}

		return $img;
	}
	
	/**
	 * Output an instruction video.
	 *
	 * @since	3.11.0
	 * @param	mixed $recipe		Recipe to output the instruction for.
	 * @param	mixed $instruction	Instruction to output the video for.
	 */
	private static function instruction_video( $recipe, $instruction ) {
		$output = '';

		if ( 'upload' === $instruction['video']['type'] ) {
			$video_id = $instruction['video']['id'];

			if ( $video_id ) {
				$video_data = wp_get_attachment_metadata( $video_id );
				$video_url = wp_get_attachment_url( $video_id );

				// Construct video shortcode.
				$output = '[video';
				$output .= ' width="' . $video_data['width'] . '"';
				$output .= ' height="' . $video_data['height'] . '"';

				if ( in_array( WPRM_Settings::get( 'video_autoplay' ), array( 'instruction', 'all' ) ) ) { $output .= ' autoplay="true"'; }
				if ( in_array( WPRM_Settings::get( 'video_loop' ), array( 'instruction', 'all' ) ) ) { $output .= ' loop="true"'; }
	
				$format = isset( $video_data['fileformat'] ) && $video_data['fileformat'] ? $video_data['fileformat'] : 'mp4';
				$output .= ' ' . $format . '="' . $video_url . '"';
	
				$thumb_size = array( $video_data['width'], $video_data['height'] );

				// Get thumb URL.
				$image_id = get_post_thumbnail_id( $video_id );
				$thumb = wp_get_attachment_image_src( $image_id, $thumb_size );
				$thumb_url = $thumb && isset( $thumb[0] ) ? $thumb[0] : '';
	
				if ( $thumb_url ) {
					$output .= ' poster="' . $thumb_url . '"';
				}
	
				$output .= '][/video]';
			}
		} else if ( 'embed' === $instruction['video']['type'] ) {
			$video_embed = $instruction['video']['embed'];

			if ( $video_embed ) {	
				// Check if it's a regular URL.
				$url = filter_var( $video_embed, FILTER_SANITIZE_URL );
	
				if ( filter_var( $url, FILTER_VALIDATE_URL ) ) {
					global $wp_embed;
	
					if ( isset( $wp_embed ) ) {
						$output = $wp_embed->run_shortcode( '[embed]' . $url . '[/embed]' );
					}
				} else {
					$output = $video_embed;
				}
			}
		}

		return do_shortcode( $output );
	}
}

WPRM_SC_Instructions::init();