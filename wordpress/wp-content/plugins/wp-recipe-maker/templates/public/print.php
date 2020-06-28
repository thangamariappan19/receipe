<?php
/**
 * Template to be used for the print page.
 *
 * @link       http://bootstrapped.ventures
 * @since      4.0.3
 *
 * @package    WP_Recipe_Maker
 * @subpackage WP_Recipe_Maker/templates/public
 */

?>
<!DOCTYPE html>
<html <?php echo get_language_attributes(); ?>>
	<head>
		<title><?php echo isset( $output['title'] ) && $output['title'] ? $output['title'] : get_bloginfo( 'name' ); ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php echo get_bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<meta name="robots" content="noindex">
		<?php if ( WPRM_Settings::get( 'metadata_pinterest_disable_print_page' ) ) : ?>
			<meta name="pinterest" content="nopin" />
		<?php endif; ?>
		<?php wp_site_icon(); ?>
		<?php
		if ( isset( $output['assets'] ) ) {
			$serialized = array_map( 'serialize', $output['assets'] );
			$unique = array_unique( $serialized );
			$assets = array_intersect_key( $output['assets'], $unique );
			
			foreach ( $output['assets'] as $asset ) {
				switch ( $asset['type'] ) {
					case 'css':
						echo '<link rel="stylesheet" type="text/css" href="' . $asset['url'] . '?ver=' . WPRM_VERSION . '"/>';
						break;
					case 'js':
						echo '<script src="' . $asset['url'] . '?ver=' . WPRM_VERSION . '"></script>';
						break;
					case 'custom':
						echo $asset['html'];
						break;
				}
			}
		}
		?>
	</head>
	<body class="wprm-print<?php echo is_rtl() ? ' rtl' : ''; ?>">
		<div id="wprm-print-header">
			<div id="wprm-print-header-main">
				<?php
				$back_link = home_url();
				if ( isset( $_SERVER['HTTP_REFERER'] ) && $_SERVER['HTTP_REFERER'] ) {
					// Check if same domain.
					if ( $_SERVER['HTTP_HOST'] === parse_url( $_SERVER['HTTP_REFERER'], PHP_URL_HOST ) ) {
						$back_link = $_SERVER['HTTP_REFERER'];
					}
				}
				?>
				<a href="<?php echo $back_link; ?>" id="wprm-print-button-back" class="wprm-print-button"><?php _e( 'Go Back', 'wp-recipe-maker' );?></a>
				<?php
				if ( WPRM_Settings::get( 'print_email_link_button' ) ) {
					echo '<a href="#" id="wprm-print-button-email" class="wprm-print-button">' . __( 'Email Link', 'wp-recipe-maker' ) . '</a>';
				}
				// if ( WPRM_Settings::get( 'print_download_pdf_button' ) ) {
				// 	echo '<a href="#" id="wprm-print-button-pdf" class="wprm-print-button">' . __( 'Download PDF', 'wp-recipe-maker' ) . '</a>';
				// }
				?>
				<button id="wprm-print-button-print" class="wprm-print-button" type="button"><?php _e( 'Print', 'wp-recipe-maker' );?></button>
			</div>
			<div id="wprm-print-header-options"><?php echo $output['header']; ?></div>
		</div>
		<?php
		$classes = isset( $output['classes'] ) ? $output['classes'] : array();

		echo '<div id="wprm-print-content" class="' . implode( ' ', $classes ) . '">';
		echo $output['html'];
		echo '</div>';
		?>
		<?php
		$print_ad = trim( WPRM_Settings::get( 'print_footer_ad' ) );

		if ( $print_ad ) {
			echo '<div id="wprm-print-footer-ad">' . $print_ad . '</div>';
		}
		?>
		<div id="print-pdf"></div>
	</body>
</html>