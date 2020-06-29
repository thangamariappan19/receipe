<?php 
/*
** woocommerce Tab view show the information
*/

	// not run if accessed directly
    if( ! defined("ABSPATH" ) )
    	die("Not Allewed");

    if (wpr_woocommerce_intigration() == 'on') {
	  $user_id     = wpr_get_current_user_id();
	  $order_count = wc_get_customer_order_count( $user_id );
	  $order_id	   = isset($_GET['order_id']) ? $_GET['order_id'] : null;
	  $account_url = get_permalink( get_option('woocommerce_myaccount_page_id'));
?>
<div class="wpr-tab-pane tab-pane fade in" id="woocommerce" style="margin: 0px;">
	<div class="woocommerce" style="padding: 10px;">
	    <div class="row">
	        <div class="col-md-12">
	            <div class="tab" role="tabpanel">
	                <!-- Nav tabs -->
	                <ul class="nav nav-tabs" role="tablist">
	                    <li role="presentation" class="active"><a href="#Order" aria-controls="home" role="tab" data-toggle="tab"><?php _e('My Order' , 'wp-registration'); ?></a></li>
	                    <li role="presentation"><a href="#Shipping" aria-controls="messages" role="tab" data-toggle="tab"><?php _e('Addresses' , 'wp-registration'); ?></a></li>
	                </ul>
	                <!-- Tab panes -->
	                <div class="tab-content tabs">
	                    <div role="tabpanel" class="tab-pane fade in active" id="Order">

	                	<?php if ($order_count != 0) { ?>

	                    	<div class="wpr-woocomerce-order">
	                    		<?php 
									wc_get_template( 'myaccount/my-orders.php', array(
							           'current_user'  => get_user_by( 'id', $user_id),
							           'order_count'   => $order_count
				        			));
	        					?>
							</div>

							<?php if( $order_id ) { ?>

								<div class="wpr-woocomerce-order-detail">
		                    		<?php 
										wc_get_template( 'order/order-details.php', array(
	      									'order_id' => $order_id,
	    								) );
		        					?>
								</div>
							<?php } ?>
	                	<?php }else { ?>
		                	<div class ="wpr-woocomerce-alert">
		                		<h2>Information</h2>
		                		<p>please create your order first</p>
		                	</div>
	                	<?php } ?>
	                    </div>
	                    <div role="tabpanel" class="tab-pane fade" id="Shipping">
	                        <div class="wpr-woocomerce-biling">
								<?php wc_get_template( 'myaccount/my-address.php')  ?>
							</div>
							<input type="hidden" class ="wpr-edit-url" name="my_account_permalink" 
								   value="<?php echo esc_attr($account_url) ?>">
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
</div>
<?php } 