<?php
/**
 * Settings
 **/

 	// not run if accessed directly
	if( ! defined("ABSPATH" ) )
   		 die("Not Allewed");
?>
<div class="wpr_setting_page_hide" style="display: none;">
	<h2><?php _e('WP Registration' , 'wp-registration') ?></h2>
		<hr class="wpr-heading-line">
</div>
<?php  	

 	WPR_Settings()->display();