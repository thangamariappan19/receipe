<?php
/**
 * Handle the link shortcode.
 *
 * @link       http://bootstrapped.ventures
 * @since      4.0.0
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public/shortcodes/general
 */

/**
 * Handle the link shortcode.
 *
 * @since      4.0.0
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/includes/public/shortcodes/general
 * @author     Brecht Vandersmissen <brecht@bootstrapped.ventures>
 */
class WPRM_SC_Link extends WPRM_Template_Shortcode {
	public static $shortcode = 'wprm-link';

	public static function init() {
		self::$attributes = array(
			'link' => array(
				'default' => '',
				'type' => 'text',
			),
			'link_target' => array(
				'default' => '_blank',
				'type' => 'dropdown',
				'options' => array(
					'_self' => 'Open in same tab',
					'_blank' => 'Open in new tab',
				),
				'dependency' => array(
					'id' => 'link',
					'value' => '',
					'type' => 'inverse',
				),
			),
			'link_nofollow' => array(
				'default' => 'nofollow',
				'type' => 'dropdown',
				'options' => array(
					'dofollow' => 'Do not add nofollow attribute',
					'nofollow' => 'Add nofollow attribute',
				),
				'dependency' => array(
					'id' => 'link',
					'value' => '',
					'type' => 'inverse',
				),
			),
			'text' => array(
				'default' => '',
				'type' => 'text',
			),
			'text_style' => array(
				'default' => 'normal',
				'type' => 'dropdown',
				'options' => 'text_styles',
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

		$link = esc_url_raw( $atts['link'] );
		if ( ! $link ) {
			return '';
		}

		// Use link as default text.
		$text = $atts['text'];
		if ( ! $text ) {
			$text = $link;
		}

		// Output.
		$classes = array(
			'wprm-link',
			'wprm-block-text-' . $atts['text_style'],
		);

		$nofollow = 'nofollow' === $atts['link_nofollow'] ? ' rel="nofollow"' : '';
		$output = '<a href="' . $link . '" target="' . $atts['link_target']. '" class="' . implode( ' ', $classes ) . '"' . $nofollow . '>' . $text . '</a>';
		return apply_filters( parent::get_hook(), $output, $atts );
	}
}

WPRM_SC_Link::init();