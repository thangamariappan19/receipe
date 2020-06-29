<?php  
/*
** show the form id meta
*/

// not run if accessed directly
    if( ! defined("ABSPATH" ) )
        die("Not Allewed");
   	global $post;
?>
<div class="wpr-shorcode">
	<p><?php echo sprintf(__('[wpr-form id="%s"]',"wp-registration"),$post->ID); ?></p>
</div>