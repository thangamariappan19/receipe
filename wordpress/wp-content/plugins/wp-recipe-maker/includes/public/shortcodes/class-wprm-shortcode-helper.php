<?php
/**
 * Providing helper functions to use in the recipe shortcodes.
 *
 * @link       http://bootstrapped.ventures
 * @since      6.0.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public/shortcodes
 */

/**
 * Providing helper functions to use in the recipe shortcodes.
 *
 * @since      6.0.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public/shortcodes
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_Shortcode_Helper {
    /**
	 * Get attributes for the label container.
	 *
	 * @since	6.0.0
	 */
	public static function get_label_container_atts() {
		return array(
			'text_style' => array(
				'default' => 'normal',
				'type' => 'dropdown',
				'options' => 'text_styles',
			),
            'label_container' => array(
				'default' => '0',
				'type' => 'toggle',
			),
            'style' => array(
				'default' => 'separate',
				'type' => 'dropdown',
				'options' => array(
					'inline' => 'Inline',
					'separate' => 'On its own line',
					'separated' => 'On separate lines',
					'columns' => 'Columns',
                ),
                'dependency' => array(
					'id' => 'label_container',
					'value' => '1',
				),
			),
			'icon' => array(
				'default' => '',
                'type' => 'icon',
                'dependency' => array(
					'id' => 'label_container',
					'value' => '1',
				),
			),
			'icon_color' => array(
				'default' => '#333333',
				'type' => 'color',
				'dependency' => array(
                    array(
                        'id' => 'label_container',
                        'value' => '1',
                    ),
                    array(
                        'id' => 'icon',
                        'value' => '',
                        'type' => 'inverse',
                    ),
				),
			),
			'label' => array(
				'default' => '',
                'type' => 'text',
                'dependency' => array(
					'id' => 'label_container',
					'value' => '1',
				),
			),
			'label_separator' => array(
				'default' => ' ',
                'type' => 'text',
                'dependency' => array(
                    array(
                        'id' => 'label_container',
                        'value' => '1',
                    ),
                    array(
                        'id' => 'label',
                        'value' => '',
                        'type' => 'inverse',
                    ),
				),
			),
			'label_style' => array(
				'default' => 'normal',
				'type' => 'dropdown',
				'options' => 'text_styles',
				'dependency' => array(
                    array(
                        'id' => 'label_container',
                        'value' => '1',
                    ),
                    array(
                        'id' => 'label',
                        'value' => '',
                        'type' => 'inverse',
                    ),
				),
			),
			// Needs to pass trough but not actually shown.
			'table_borders' => array(
				'default' => 'top-bottom',
			),
			'table_borders_inside' => array(
				'default' => '1',
			),
			'table_border_width' => array(
				'default' => '1px',
			),
			'table_border_style' => array(
				'default' => 'dotted',
			),
			'table_border_color' => array(
				'default' => '#666666',
			),
		);
    }

    /**
	 * Get label container.
	 *
	 * @since	6.0.0
	 * @param	mixed $atts Attributes for the shortcode.
	 * @param	string $fields Field to get the container for.
     * @param	string $content Content to put inside the container.
	 */
	public static function get_label_container( $atts, $fields, $content ) {
		if ( ! (bool) $atts['label_container'] ) {
			return $content;
		}

		// Clean up $fields.
		if ( ! is_array( $fields ) ) {
			$fields = array( $fields );
		}

		foreach ( $fields as $index => $field ) {
			$fields[ $index ] = str_replace( ' ', '', $field );
		}

		// Get optional icon.
		$icon = '';
		if ( $atts['icon'] ) {
			$icon = WPRM_Icon::get( $atts['icon'], $atts['icon_color'] );

			if ( $icon ) {
				$icon_classes = array(
					'wprm-recipe-icon',
				);
				foreach ( $fields as $field ) {
					$icon_classes[] = 'wprm-recipe-' . $field . '-icon';
				}

				$icon = '<span class="' . implode( ' ', $icon_classes ) . '">' . $icon . '</span> ';
			}
		}

		// Get optional label.
		$label = '';
		if ( $atts['label'] ) {
			$label_classes = array(
				'wprm-recipe-details-label',
				'wprm-block-text-' . $atts['label_style'],
			);
			foreach ( $fields as $field ) {
				$label_classes[] = 'wprm-recipe-' . $field . '-label';
			}

			$label = '<span class="' . implode( ' ', $label_classes ) . '">' . __( $atts['label'], 'wp-recipe-maker' ) . $atts['label_separator'] . '</span>';
		}

		// Inline style.
		$style = '';
		if ( 'table' === $atts['style'] ) {
			if ( 'none' === $atts['table_borders'] ) {
				$atts['table_border_width'] = 0;
			}

			$style .= 'border-width: ' . $atts['table_border_width'] . ';';
			$style .= 'border-style: ' . $atts['table_border_style'] . ';';
			$style .= 'border-color: ' . $atts['table_border_color'] . ';';
		}

        // Get container code.
        $classes = array(
			'wprm-recipe-block-container',
			'wprm-recipe-block-container-' . $atts['style'],
			'wprm-block-text-' . $atts['text_style'],
		);
		foreach ( $fields as $field ) {
			$classes[] = 'wprm-recipe-' . $field . '-container';
		}

		$container = '<div class="' . implode( ' ', $classes ) . '" style="' . $style . '">';
		$container .= $icon;
		$container .= $label;
		$container .= $content;
		$container .= '</div>';
        

		return $container;
	}

	/**
	 * Get attributes for a section.
	 *
	 * @since	6.0.0
	 */
	public static function get_section_atts() {
		return array(
			'text_style' => array(
				'default' => 'normal',
				'type' => 'dropdown',
				'options' => 'text_styles',
			),
			'header' => array(
				'default' => '',
				'type' => 'text',
			),
			'header_tag' => array(
				'default' => 'h3',
				'type' => 'dropdown',
				'options' => 'header_tags',
				'dependency' => array(
					'id' => 'header',
					'value' => '',
					'type' => 'inverse',
				),
			),
			'header_style' => array(
				'default' => 'bold',
				'type' => 'dropdown',
				'options' => 'text_styles',
				'dependency' => array(
					'id' => 'header',
					'value' => '',
					'type' => 'inverse',
				),
			),
			'header_align' => array(
				'default' => 'left',
				'type' => 'dropdown',
				'options' => array(
					'left' => 'Left',
					'center' => 'Center',
					'right' => 'Right',
				),
				'dependency' => array(
                    array(
                        'id' => 'header',
                        'value' => '',
                        'type' => 'inverse',
					),
				),
			),
			'header_decoration' => array(
				'default' => 'none',
				'type' => 'dropdown',
				'options' => array(
					'none' => 'None',
					'line' => 'Line',
					'icon' => 'Icon',
				),
				'dependency' => array(
					'id' => 'header',
					'value' => '',
					'type' => 'inverse',
				),
			),
			'header_line_color' => array(
				'default' => '#9B9B9B',
				'type' => 'color',
				'dependency' => array(
                    array(
                        'id' => 'header',
                        'value' => '',
                        'type' => 'inverse',
					),
					array(
                        'id' => 'header_decoration',
                        'value' => 'line',
                    ),
				),
			),
			'header_icon' => array(
				'default' => '',
				'type' => 'icon',
				'dependency' => array(
					array(
						'id' => 'header',
						'value' => '',
						'type' => 'inverse',
					),
					array(
						'id' => 'header_decoration',
						'value' => 'icon',
					),
				),
			),
			'header_icon_color' => array(
				'default' => '#333333',
				'type' => 'color',
				'dependency' => array(
					array(
						'id' => 'header',
						'value' => '',
						'type' => 'inverse',
					),
					array(
						'id' => 'header_decoration',
						'value' => 'icon',
					),
					array(
						'id' => 'header_icon',
						'value' => '',
						'type' => 'inverse',
					),
				),
			),
		);
	}
	
	/**
	 * Get section header to output.
	 *
	 * @since	6.0.0
	 * @param	mixed $atts Attributes for the shortcode.
	 * @param	string $field Field to get the header for.
	 * @param	string $args Optional arguments.
	 */
	public static function get_section_header( $atts, $field, $args = array() ) {
		$header = '';

		if ( $atts['header'] ) {
			$classes = array(
				'wprm-recipe-header',
				'wprm-recipe-' . $field . '-header',
				'wprm-block-text-' . $atts['header_style'],
				'wprm-align-' . $atts['header_align'],
				'wprm-header-decoration-' . $atts['header_decoration'],
			);

			// Custom inline styling.
			$style = '';

			// Add decoration before/after header.
			$before_header = '';
			$after_header = '';
			if ( 'line' === $atts['header_decoration'] ) {
				if ( 'left' === $atts['header_align'] || 'center' === $atts['header_align'] ) {
					$after_header = '<div class="wprm-decoration-line" style="border-color: ' . $atts['header_line_color'] . '"></div>';
				}
				if ( 'right' === $atts['header_align'] || 'center' === $atts['header_align'] ) {
					$before_header = '<div class="wprm-decoration-line" style="border-color: ' . $atts['header_line_color'] . '"></div>';
				}
			} elseif ( 'icon' === $atts['header_decoration'] ) {
				$icon = '';
				if ( $atts['header_icon'] ) {
					$icon = WPRM_Icon::get( $atts['header_icon'], $atts['header_icon_color'] );

					if ( $icon ) {
						$icon = '<span class="wprm-recipe-icon">' . $icon . '</span> ';
					}
				}
				$before_header = $icon;
			}

			// Special for ingredients.
			if ( 'ingredients' === $field ) {
				if ( 'header' === $atts['unit_conversion'] && isset( $args['unit_conversion_atts'] ) ) {
					$after_header .= '&nbsp;' . WPRM_SC_Unit_Conversion::shortcode( $args['unit_conversion_atts'] );
					$classes[] = 'wprm-header-has-actions';
				}
				if ( 'header' === $atts['adjustable_servings'] && isset( $args['adjustable_servings_atts'] ) ) {
					$after_header .= '&nbsp;' . WPRM_SC_Adjustable_Servings::shortcode( $args['adjustable_servings_atts'] );
					$classes[] = 'wprm-header-has-actions';
				}
			}

			// Special for instructions.
			if ( 'instructions' === $field ) {
				if ( 'header' === $atts['media_toggle'] && isset( $args['media_toggle_atts'] ) ) {
					$after_header .= '&nbsp;' . WPRM_SC_Media_Toggle::shortcode( $args['media_toggle_atts'] );
					$classes[] = 'wprm-header-has-actions';
				}
			}

			$tag = trim( $atts['header_tag'] );
			$header .= '<' . $tag . ' class="' . implode( ' ', $classes ) . '" style="' . $style . '">' . $before_header . __( $atts['header'], 'wp-recipe-maker' ) . $after_header . '</' . $tag . '>';
		}

		return $header;
	}
}
