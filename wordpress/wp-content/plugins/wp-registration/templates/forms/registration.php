<?php
/**
 * Registration form template
**/

	// not run if accessed directly
    if( ! defined("ABSPATH" ) )
    	die("Not Allewed");

?>
<form id="wpr-form-<?php echo esc_attr($form->form_id)?>" class="wpr-forms">

	<div class="row" style="padding: 13px;">
		<input type="hidden" name="action" value="wpr_submit_form">
		<input type="hidden" name="wpr_form_id" value="<?php echo esc_attr($form->form_id)?>">
		<?php wp_nonce_field( 'wpr_register_user', 'wpr_nonce' ) ?>

		<?php
			echo $form->render_form_fields();

			do_action('wpr_before_submit_button', $form);

			
			echo $form->submit_btn();    		


		?>
	</div>
</form>