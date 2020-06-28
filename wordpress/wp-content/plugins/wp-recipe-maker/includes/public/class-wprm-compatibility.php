<?php
/**
 * Handle compabitility with other plugins/themes.
 *
 * @link       http://bootstrapped.ventures
 * @since      3.2.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 */

/**
 * Handle compabitility with other plugins/themes.
 *
 * @since      3.2.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_Compatibility {

	/**
	 * Register actions and filters.
	 *
	 * @since	3.2.0
	 */
	public static function init() {
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'yoast_seo' ) );
		add_action( 'divi_extensions_init', array( __CLASS__, 'divi' ) );

		add_filter( 'wprm_recipe_ingredients_shortcode', array( __CLASS__, 'mediavine_ingredients_ad' ) );

		// Elementor.
		add_action( 'elementor/controls/controls_registered', array( __CLASS__, 'elementor_controls' ) );
		add_action( 'elementor/preview/enqueue_styles', array( __CLASS__, 'elementor_styles' ) );
		add_action( 'elementor/widgets/widgets_registered', array( __CLASS__, 'elementor_widgets' ) );

		// WP Ultimate Post Grid.
		add_filter( 'wpupg_output_grid_post', array( __CLASS__, 'wpupg_set_recipe_id_legacy' ) );

		add_filter( 'wpupg_set_current_item', array( __CLASS__, 'wpupg_set_recipe_id' ) );
		add_filter( 'wpupg_unset_current_item', array( __CLASS__, 'wpupg_unset_recipe_id' ) );
		add_filter( 'wpupg_template_editor_shortcodes', array( __CLASS__, 'wpupg_template_editor_shortcodes' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'wpupg_template_editor_styles' ) );
	}

	/**
	 * Yoast SEO Compatibility.
	 *
	 * @since	3.2.0
	 */
	public static function yoast_seo() {
		if ( defined( 'WPSEO_VERSION' ) ) {
			wp_enqueue_script( 'wprm-yoast-compatibility', WPRM_URL . 'assets/js/other/yoast-compatibility.js', array( 'jquery' ), WPRM_VERSION, true );
		}
	}

	/**
	 * Divi Builder Compatibility.
	 *
	 * @since	5.1.0
	 */
	public static function divi() {
		// require_once( WPRM_DIR . 'templates/divi/includes/extension.php' );
	}


	/**
	 * Elementor Compatibility.
	 *
	 * @since	5.0.0
	 */
	public static function elementor_controls() {
		include( WPRM_DIR . 'templates/elementor/control.php' );
		\Elementor\Plugin::$instance->controls_manager->register_control( 'wprm-recipe-select', new WPRM_Elementor_Control() );
	}
	public static function elementor_styles() {
		// Make sure default assets load.
		WPRM_Assets::load();
	}
	public static function elementor_widgets() {
		include( WPRM_DIR . 'templates/elementor/widget.php' );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new WPRM_Elementor_Widget() );
	}

	/**
	 * Recipes in WP Ultimate Post Grid Compatibility (after 3.0.0).
	 *
	 * @since	5.9.0
	 * @param	mixed $post Post getting shown in the grid.
	 */
	public static function wpupg_set_recipe_id( $item ) {
		if ( WPRM_POST_TYPE === $item->post_type() ) {
			WPRM_Template_Shortcodes::set_current_recipe_id( $item->id() );
		} else {
			$recipes = WPRM_Recipe_Manager::get_recipe_ids_from_post( $item->id() );

			if ( isset( $recipes[0] ) ) {
				WPRM_Template_Shortcodes::set_current_recipe_id( $recipes[0] );
			}
		}

		return $item;
	}
	public static function wpupg_unset_recipe_id( $item ) {
		WPRM_Template_Shortcodes::set_current_recipe_id( false );
		return $item;
	}

	/**
	 * Recipes in WP Ultimate Post Grid Compatibility (before 3.0.0).
	 *
	 * @since	4.2.0
	 * @param	mixed $post Post getting shown in the grid.
	 */
	public static function wpupg_set_recipe_id_legacy( $post ) {
		if ( WPRM_POST_TYPE === $post->post_type ) {
			WPRM_Template_Shortcodes::set_current_recipe_id( $post->ID );
		}

		return $post;
	}

	/**
	 * Add recipe shortcodes to grid template editor.
	 *
	 * @since	5.9.0
	 * @param	mixed $shortcodes Current template editor shortcodes.
	 */
	public static function wpupg_template_editor_shortcodes( $shortcodes ) {
		$shortcodes = array_merge( $shortcodes, WPRM_Template_Shortcodes::get_shortcodes() );
		return $shortcodes;
	}
	
	/**
	 * Add recipe shortcode styles to grid template editor.
	 *
	 * @since	5.9.0
	 */
	public static function wpupg_template_editor_styles( $shortcodes ) {
		$screen = get_current_screen();
		if ( 'grids_page_wpupg_template_editor' === $screen->id  ) {
			wp_enqueue_style( 'wprm-admin-template', WPRM_URL . 'dist/admin-template.css', array(), WPRM_VERSION, 'all' );
		}
	}

	/**
	 * Add extra Mediavine ad unit after the ingredients.
	 *
	 * @since	5.8.3
	 * @param	mixed $output Current ingredients output.
	 */
	public static function mediavine_ingredients_ad( $output ) {
		if ( WPRM_Settings::get( 'integration_mediavine_ad' ) ) {
			$output = $output . '<div class="mv_slot_target" data-slot="recipe" data-render-default="true"></div>';
		}

		return $output;
	}

	/**
	 * Compatibility with multilingual plugins for home URL.
	 *
	 * @since	5.7.0
	 */
	public static function get_home_url() {
		$home_url = home_url();

		// Polylang Compatibility.
		if ( function_exists( 'pll_home_url' ) ) {
			$home_url = pll_home_url();
		}

		// Add trailing slash unless there are query parameters.
		if ( false === strpos( $home_url, '?' ) ) {
			$home_url = trailingslashit( $home_url );
		}

		return $home_url;
	}
}

WPRM_Compatibility::init();
