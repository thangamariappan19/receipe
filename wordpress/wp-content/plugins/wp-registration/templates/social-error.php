<?php
/**
 * Settings
 **/

 	// not run if accessed directly
	if( ! defined("ABSPATH" ) )
   		 die("Not Allewed");
?>
<div class="error-container" style="margin: 92px auto; width: 30%; -webkit-box-shadow: 0 3px 9px rgba(0,0,0,.5); box-shadow: 0 3px 9px rgba(0,0,0,.5);">
    <div class="panel-body" style="padding: 16px;">
    	<div style="width: 23%; height: 42px; background: #d72d21; color: white; text-align:center; margin:0px auto; border-radius:9px;">
    		
                <spna style="padding-top: 10px;display: block;font-size: 19px"> Warning ! </span>   
    	</div>
        <div class="row">
            <div class="col-md-12">
            	<p style="text-align: center; font-size: 28px;"><?php echo $error ?></p>
            </div>
        </div>
        <?php
        	$login_tempalte = WPRLOGIN()->wpr_get_core_page_for_redirect('login');
        	
        ?>
        	<a href="<?php echo esc_url($login_tempalte);?>">back</a>
    </div>
</div>