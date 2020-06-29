<?php

	// not run if accessed directly
	if( ! defined("ABSPATH" ) )
		die("Not Allewed");

	global $post;
	$wp_roles    	 = get_editable_roles();

	$content_options  = WPRRESTRICT()->restrict_content_access_option();

	$wpr_restrict_msg =	get_post_meta( $post->ID, 'wpr_restrict_msg', true );
	$wpr_for_members  =	get_post_meta( $post->ID, 'wpr_member_restrict', true );
	$wpr_for_role	  =	get_post_meta( $post->ID, 'wpr_role_restrict', true );
	$wpr_for_role     = isset($wpr_for_role) ? ($wpr_for_role) : array();
?>

<div class="wpr-content-rapper">
	<div class="wpr-member-control">
		<select class="wpr_role wpr_select2" name="wpr_member_restrict">
		<?php 
			foreach($content_options as $val => $text) { ?>
                <option value="<?php echo esc_attr($val); ?>" <?php selected( $val, $wpr_for_members) ?> > <?php echo $text; ?>	
            	</option>
        <?php } ?> 
			
		</select>
	</div>
	<div class="wpr-role-control" style="margin-top: 15px;">
		<select name="wpr_role_restrict[]" class="wpr_select2 yyy" multiple>
			<?php  
				foreach ($wp_roles as $roles => $role_name) {
              	$selected = '';
              	if( !empty($wpr_for_role) ) {
                	$selected = in_array($roles, $wpr_for_role) ? 'selected="selected"' : '';
              	}
			?>
				<option value="<?php echo esc_attr($roles); ?>" <?php echo $selected; ?> >
					<?php echo sprintf(__("%s","wp-registration"),$roles); ?>
				</option>'
			<?php } ?>
		</select>
	</div>
	<div class="wpr-restrict-msg-control" style="margin-top: 15px;">
		<label><?php _e('Error Restriction Message.', 'wp-registration'); ?></label>
		<span style="color: #3ca8e4; cursor: pointer;" class="wpr-label-color" title="<?php _e('did not select any rule them show the error massage','wp-registration'); ?>">
			<i class="dashicons dashicons-editor-help"></i>
		</span>
		<input type="text" name="wpr_restrict_msg" style="width:100%" value="<?php echo $wpr_restrict_msg; ?>">
	</div>
</div>