<?php
/**
 * Handle the text shortcode.
 *
 * @link       http://bootstrapped.ventures
 * @since      4.0.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public/shortcodes/general
 */

/**
 * Handle the text shortcode.
 *
 * @since      4.0.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public/shortcodes/general
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_SC_Text extends WPRM_Template_Shortcode {
	public static $shortcode = 'wprm-text';

	public static function init() {
		self::$attributes = array(
			'text' => array(
				'default' => '',
				'type' => 'text',
			),
			'text_style' => array(
				'default' => 'normal',
				'type' => 'dropdown',
				'options' => 'text_styles',
			),
			'tag' => array(
				'default' => 'p',
				'type' => 'dropdown',
				'options' => array(
					'p' => 'p',
					'span' => 'span',
					'div' => 'div',
					'h1' => 'h1',
					'h2' => 'h2',
					'h3' => 'h3',
					'h4' => 'h4',
					'h5' => 'h5',
					'h6' => 'h6',
				),
			),
		);
		parent::init();
	}

	/**
	 * Output for the shortcode.
	 *
	 * @since	4.0.0
	 * @param	array $atts Options passed along with the shortcode.
	 */
	public static function shortcode( $atts ) {
		$atts = parent::get_attributes( $atts );

		$text = $atts['text'];
		if ( ! $text ) {
			return '';
		}

		// Output.
		$classes = array(
			'wprm-text',
			'wprm-block-text-' . $atts['text_style'],
		);

		$tag = trim( $atts['tag'] );

		$output = '<' . $tag . ' class="' . implode( ' ', $classes ) . '">' . $text . '</' . $tag . '>';
		return apply_filters( parent::get_hook(), $output, $atts );
	}
}

WPRM_SC_Text::init();