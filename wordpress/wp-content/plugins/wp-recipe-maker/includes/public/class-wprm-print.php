<?php
/**
 * Handle the recipe printing.
 *
 * @link       http://bootstrapped.ventures
 * @since      1.0.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 */

/**
 * Handle the recipe printing.
 *
 * @since      1.0.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_Print {

	/**
	 * Register actions and filters.
	 *
	 * @since    1.0.0
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'print_page' ) );

		add_filter( 'wprm_print_output', array( __CLASS__, 'output_first' ), 1, 2 );
		add_filter( 'wprm_print_output', array( __CLASS__, 'output_last' ), 999, 2 );
	}

	/**
	 * Get the print slug.
	 *
	 * @since	6.1.0
	 */
	public static function slug() {
		$slug = WPRM_Settings::get( 'print_slug' );

		if ( ! $slug ) {
			$slug = WPRM_Settings::get_default( 'print_slug' );
		}

		return $slug;
	}

	/**
	 * Check if someone is trying to reach the print page.
	 *
	 * @since    1.3.0
	 */
	public static function print_page() {
		preg_match( '/[\/\?]' . self::slug() . '[\/=](.+?)(\/)?$/', $_SERVER['REQUEST_URI'], $print_url ); // Input var okay.
		$print_query = isset( $print_url[1] ) ? $print_url[1] : '';

		// Get individual print args.
		$print_query = str_ireplace( '?', '/', $print_query );
		$print_query = str_ireplace( '&', '/', $print_query );
		$print_args = explode( '/', $print_query );

		// Backwards compatibility with old /wprm_print/123 URL
		if ( 1 === count( $print_args ) && '' . intval( $print_args[0] ) === $print_args[0] ) {
			$print_args = array(
				'recipe',
				$print_args[0],
			);
		}

		if ( $print_args && 2 <= count( $print_args ) ) {
			
			// Get assets to output while making sure nothing gets output yet.
			ob_start();
			$output = apply_filters( 'wprm_print_output', array(
				'type' => false,
				'assets' => array(),
				''
			), $print_args );
			$prevent_from_getting_output = ob_get_contents();
			ob_end_clean();

			if ( $output && $output['type'] ) {
				// Prevent WP Rocket lazy image loading on print page.
				add_filter( 'do_rocket_lazyload', '__return_false' );

				// Prevent Avada lazy image loading on print page.
				if ( class_exists( 'Fusion_Images' ) && property_exists( 'Fusion_Images', 'lazy_load' ) ) {
					Fusion_Images::$lazy_load = false;
				}

				// Load print template file.
				header( 'HTTP/1.1 200 OK' );
				require( WPRM_DIR . 'templates/public/print.php' );
				flush();
				exit;
			} else {
				// Redirect to homepage.
				wp_redirect( home_url() );
				exit();
			}
		}
	}

	/**
	 * Get output for the print page with high priority.
	 *
	 * @since    6.1.0
	 * @param	array $output 	Current output for the print page.
	 * @param	array $args	 	Arguments for the print page.
	 */
	public static function output_first( $output, $args ) {
		// Default assets to load.
		$output['assets'][] = array(
			'type' => 'css',
			'url' => WPRM_URL . 'dist/public-' . WPRM_Settings::get( 'recipe_template_mode' ) . '.css',
		);
		$output['assets'][] = array(
			'type' => 'css',
			'url' => WPRM_URL . 'dist/print.css',
		);
		$output['assets'][] = array(
			'type' => 'js',
			'url' => WPRM_URL . 'dist/print.js',
		);
		$output['assets'][] = array(
			'type' => 'custom',
			'html' => '<style>' . WPRM_Assets::get_custom_css( 'print' ) . '</style>',
		);
		$output['assets'][] = array(
			'type' => 'custom',
			'html' => self::print_accent_color_styling(),
		);
		$output['assets'][] = array(
			'type' => 'custom',
			'html' => '<script>var wprm_print_settings = ' . wp_json_encode( array(
				'print_remove_links' => WPRM_Settings::get( 'print_remove_links' ),
			) ) . ';</script>',
		);

		if ( WPRM_Settings::get( 'print_recipe_page_break' ) ) {
			$output['assets'][] = array(
				'type' => 'custom',
				'html' => '<style>@media print { .wprm-print-recipe:not(:first-child) { page-break-before: always; } }</style>',
			);
		}

		// Printing a single recipe.
		if ( 'recipe' === $args[0] ) {
			$recipe_id = intval( $args[1] );

			if ( WPRM_POST_TYPE === get_post_type( $recipe_id ) ) {
				$recipe = WPRM_Recipe_Manager::get_recipe( $recipe_id );

				// Don't output if recipe is not published (and setting enabled).
				if ( WPRM_Settings::get( 'print_published_recipes_only' ) && 'publish' !== $recipe->post_status() ) {
					return '';
				}

				// Add styling for this recipe's print template.
				$output['assets'][] = array(
					'type' => 'custom',
					'html' => WPRM_Template_Manager::get_template_styles( $recipe, 'print' ),
				);

				// Add options to header.
				$output['header'] .= self::print_header_images( $recipe );
				$output['type'] = 'recipe';
				$output['recipe'] = $recipe;
				$output['title'] = $recipe->name() . ' - ' . __( 'Print', 'wp-recipe-maker' );
				$output['html'] = '<div id="wprm-print-recipe-0" data-recipe-id="' . $recipe_id . '" class="wprm-print-recipe">' . WPRM_Template_Manager::get_template( $recipe, 'print' ) . '</div>';
			}
		}

		// Printing a list of recipes.
		if ( 'recipes' === $args[0] ) {
			$recipes = array();
			$recipe_ids = self::decode_ids( $args[1] );

			if ( $recipe_ids ) {
				$all_recipes = array();
				for ( $i = 0; $i < count( $recipe_ids ); $i += 2 ) {
					$all_recipes[] = array(
						'id' => intval( $recipe_ids[ $i ] ),
						'servings' => intval( $recipe_ids[ $i + 1 ] ),
					);
				}

				// Remove duplicates.
				$serialized = array_map( 'serialize', $all_recipes );
				$unique = array_unique( $serialized );
				$unique_recipes = array_intersect_key( $all_recipes, $unique );

				foreach ( $unique_recipes as $unique_recipe ) {
					if ( WPRM_POST_TYPE === get_post_type( $unique_recipe['id'] ) ) {
						$recipe = WPRM_Recipe_Manager::get_recipe( $unique_recipe['id'] );
	
						// Don't output if recipe is not published (and setting enabled).
						if ( WPRM_Settings::get( 'print_published_recipes_only' ) && 'publish' !== $recipe->post_status() ) {
							continue;
						}
	
						$recipes[] = array(
							'id' => $recipe_id,
							'original_servings' => intval( $recipe->servings() ),
							'servings' => $unique_recipe['servings'],
						);
	
						// Add styling for this recipe's print template.
						$output['assets'][] = array(
							'type' => 'custom',
							'html' => WPRM_Template_Manager::get_template_styles( $recipe, 'print' ),
						);
						$output['html'] .= '<div id="wprm-print-recipe-' . ( count( $recipes ) - 1 ) . '" data-recipe-id="' . $unique_recipe['id'] . '" class="wprm-print-recipe">' . WPRM_Template_Manager::get_template( $recipe, 'print' ) . '</div>';
					}
				}
			}
			
			// Add options to header.
			$output['header'] .= self::print_header_images();
			$output['type'] = 'recipes';
			$output['recipes'] = $recipes;
		}

		return $output;
	}

	/**
	 * Get custom styling for the print accent color.
	 *
	 * @since    6.1.0
	 */
	public static function print_accent_color_styling() {
		$output = '';
		$color = WPRM_Settings::get( 'print_accent_color' );
		$color_default = WPRM_Settings::get_default( 'print_accent_color' );

		if ( $color !== $color_default ) {
			$output .= '<style>';
			$output .= ' #wprm-print-button-print { border-color: ' . $color . ' !important; background-color: ' . $color . ' !important; }';
			$output .= ' .wprm-print-toggle:checked + label:before { border-color: ' . $color . ' !important; background: ' . $color . ' !important; }';
			$output .= '</style>';
		}

		return $output;
	}

	/**
	 * Get print header image toggles.
	 *
	 * @since    6.1.0
	 * @param	mixed $recipe Recipe getting printed.
	 */
	public static function print_header_images( $recipe = false ) {
		$header = '';

		if ( false === $recipe || $recipe->image() ) {
			$checked = WPRM_Settings::get( 'print_show_recipe_image' ) ? 'checked="checked"' : '';

			$header .= '<div class="wprm-print-toggle-container">';
			$header .= '<input type="checkbox" id="wprm-print-toggle-recipe-image" class="wprm-print-toggle" value="1" ' . $checked . '/><label for="wprm-print-toggle-recipe-image">' . __( 'Recipe Image', 'wp-recipe-maker' ) . '</label>';
			$header .= '</div>';
		}

		$has_instructions_media = false;
		$instructions_flat = $recipe ? $recipe->instructions_flat() : array();

		foreach( $instructions_flat as $instruction ) {
			if ( isset( $instruction['image'] ) && $instruction['image'] || ( isset( $instruction['video'] ) && isset( $instruction['video']['type'] ) && in_array( $instruction['video']['type'], array( 'upload', 'embed' ) ) ) ) {
				$has_instructions_media = true;
				break;
			}
		}

		if ( false === $recipe || $has_instructions_media ) {
			$checked = WPRM_Settings::get( 'print_show_instruction_images' ) ? ' checked="checked"' : '';

			$header .= '<div class="wprm-print-toggle-container">';
			$header .= '<input type="checkbox" id="wprm-print-toggle-recipe-instruction-media" class="wprm-print-toggle" value="1" ' . $checked . '/><label for="wprm-print-toggle-recipe-instruction-media">' . __( 'Instruction Images', 'wp-recipe-maker' ) . '</label>';
			$header .= '</div>';
		}

		return $header;
	}

	/**
	 * Get output for the print page with low priority.
	 *
	 * @since    6.1.0
	 * @param	array $output 	Current output for the print page.
	 * @param	array $args	 	Arguments for the print page.
	 */
	public static function output_last( $output, $args ) {
		if ( $output ) {
			// Add optional custom print CSS setting.
			if ( isset( $output['assets'] ) ) {
				$custom_print_css = WPRM_Settings::get( 'print_css' );

				if ( $custom_print_css ) {
					$output['assets'][] = array(
						'type' => 'custom',
						'html' => '<style>' . $custom_print_css . '</style>',
					);	
				}
			}

			// Add optional print credit.
			if ( 'recipe' === $args[0] && isset( $output['html'] ) ) {
				$credit = WPRM_Settings::get( 'print_credit' );

				if ( $credit ) {
					$recipe = $recipe = WPRM_Recipe_Manager::get_recipe( intval( $args[1] ) );
					$output['html'] .= '<div id="wprm-print-footer">' . WPRM_Template_Helper::recipe_placeholders( $recipe, $credit ) . '</div>';

					// Add class to indicate there's a print credit.
					if ( ! isset( $output['classes'] ) ) {
						$output['classes'] = array();
					}
					$output['classes'][] = 'wprm-print-has-footer';
				}
			}
		}

		return $output;
	}

	/**
	 * Bulk print recipes.
	 *
	 * @since	6.1.0
	 * @param	array $recipe_ids IDs of the recipes to print.
	 */
	public static function bulk_print_url( $recipe_ids ) {
		$ids_to_encode = array();
		foreach( $recipe_ids as $id ) {
			$ids_to_encode[] = $id;
			$ids_to_encode[] = 0; // Use original servings.
		}
		$encoded = self::encode_ids( $ids_to_encode );

		// Combine with function in class-wprm-recipe:
		$home_url = WPRM_Compatibility::get_home_url();
		$query_params = false;

		if ( false !== strpos( $home_url, '?' ) ) {
			$home_url_parts = explode( '?', $home_url, 2 );

			$home_url = trailingslashit( $home_url_parts[0] );
			$query_params = $home_url_parts[1];
		}

		if ( get_option( 'permalink_structure' ) ) {
			$print_url = $home_url . WPRM_Print::slug() . '/recipes/' . $encoded;

			if ( $query_params ) {
				$print_url .= '?' . $query_params;
			}
		} else {
			$print_url = $home_url . '?' . WPRM_Print::slug() . '=recipes&' . $encoded;

			if ( $query_params ) {
				$print_url .= '&' . $query_params;
			}
		}

		return $print_url;
	}

	/**
	 * Encode recipe ids for printing.
	 *
	 * @since	6.1.0
	 * @param	array $recipe_ids	IDs of the recipes to encode for printing.
	 * @param	mixed $servings 	Optional servings for these recipes.
	 */
	public static function encode_ids( $recipe_ids ) {
		require_once( WPRM_DIR . 'vendor/hashids/lib/Hashids/HashGenerator.php' );
		require_once( WPRM_DIR . 'vendor/hashids/lib/Hashids/Hashids.php' );
		$hashids = new Hashids\Hashids('wp-recipe-maker');
		return $hashids->encode( $recipe_ids );
	}

	/**
	 * Encode recipe ids from printed URL.
	 *
	 * @since	6.1.0
	 * @param	mixed $encoded 	Encoded recipe ids.
	 */
	public static function decode_ids( $encoded ) {
		require_once( WPRM_DIR . 'vendor/hashids/lib/Hashids/HashGenerator.php' );
		require_once( WPRM_DIR . 'vendor/hashids/lib/Hashids/Hashids.php' );
		$hashids = new Hashids\Hashids('wp-recipe-maker');
		return $hashids->decode( $encoded );
	}
}

WPRM_Print::init();
