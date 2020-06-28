<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}
$efav_options = get_option('efav_options');
$efav_multi_posts_options = get_option('efav_multi_posts_options');
if ( isset($_POST['submit'])) {
    $efav_nonce = $_REQUEST['_wpnonce'];
    if (!wp_verify_nonce($efav_nonce, 'efav_action' ) ) die( 'Failed security check' );
	if ( function_exists('current_user_can') && !current_user_can('manage_options') )
		die(__('Cheatin&#8217; uh?'));

    if (isset($_POST['efav_show_remove_link']) && $_POST['efav_show_remove_link'] == 'efav_show_remove_link')
        $_POST['efav_added'] = 'show remove link';

    if (isset($_POST['efav_show_add_link']) && $_POST['efav_show_add_link'] == 'efav_show_add_link')
        $_POST['efav_removed'] = 'show add link';

	$efav_options['efav_add_favourite'] = sanitize_text_field($_POST['efav_add_favourite']);
	$efav_options['efav_added'] = sanitize_text_field($_POST['efav_added']);
	$efav_options['efav_remove_favourite'] = sanitize_text_field($_POST['efav_remove_favourite']);
	$efav_options['efav_removed'] = sanitize_text_field($_POST['efav_removed']);
	$efav_options['efav_clear'] = sanitize_text_field($_POST['efav_clear']);
	$efav_options['efav_cleared'] = sanitize_text_field($_POST['efav_cleared']);
	$efav_options['efav_favourites_empty'] = sanitize_text_field($_POST['efav_favourites_empty']);
	$efav_options['efav_rem'] = sanitize_text_field($_POST['efav_rem']);
	$efav_options['efav_cookie_warning'] = sanitize_text_field($_POST['efav_cookie_warning']);
	$efav_options['efav_text_only_registered'] = sanitize_text_field($_POST['efav_text_only_registered']);
	$efav_options['efav_statistics'] = intval($_POST['efav_statistics']);
	$efav_options['efav_before_image'] = sanitize_text_field($_POST['efav_before_image']);
	$efav_options['efav_custom_before_image'] = sanitize_text_field($_POST['efav_custom_before_image']);
	$efav_options['efav_autoshow'] = sanitize_text_field($_POST['efav_autoshow']);
	$efav_options['efav_post_per_page'] = intval($_POST['efav_post_per_page']);

    $efav_options['efav_opt_only_registered'] = '';
    if (isset($_POST['efav_opt_only_registered']))
        $efav_options['efav_opt_only_registered'] = intval($_POST['efav_opt_only_registered']);

    $efav_multi_posts_options = '';
    if (isset($_POST['efav_multi_posts_options']))
        foreach ($_POST['efav_multi_posts_options'] as $efav_key) 
        {
            $efav_single_post_option[] = sanitize_text_field($efav_key);
        }
        $efav_multi_posts_options = $efav_single_post_option;

    update_option('efav_options', $efav_options);
    update_option('efav_multi_posts_options', $efav_multi_posts_options);
}
$efav_message = "";
if ( isset($_GET['efavaction'] ) ) {
	if ($_GET['efavaction'] == 'efav-reset-statistics') {
		global $wpdb;
		    $results = $wpdb->get_results($efav_query);
		$efav_query = "DELETE FROM $wpdb->postmeta WHERE meta_key = 'efav_posts'";
		
		$efav_message = '<div class="updated below-h2" id="efav_message"><p>';
		if ($wpdb->query($efav_query)) {
			$efav_message .= "All statistic data about wp favourite posts plugin have been <strong>deleted</strong>.";
		} else {
			$efav_message .= "Something gone <strong>wrong</strong>. Data couldn't delete. Maybe thre isn't any data to delete?";
		}	
		$efav_message .= '</p></div>';
	}
}
?>
<?php if ( !empty($_POST ) ) : ?>
    <div id="efav_message" class="updated fade"><p><strong><?php _e('Options saved.') ?></strong></p></div>
<?php endif; ?>
<div class="wrap">
    <h2><?php _e('EFavourite Posts Settings', 'efav-favourite-posts'); ?></h2>
    <div class="tabs">
        <ul class="tab-links">
                <li class="active"><a href="#tab1">General Settings</a></li>
                <li><a href="#tab2">Label Settings</a></li>
                <li><a href="#tab3">Custom Posts Settings</a></li>
                <li><a href="#tab4">Help</a></li>
        </ul>
        <div class="metabox-holder" id="poststuff">
            <div class="meta-box-sortables">
                <script>
                jQuery(document).ready(function($) {
                	$('.postbox').children('h3, .handlediv').click(function(){ $(this).siblings('.inside').toggle();});
                	$('#efav-reset-statistics').click(function(){
                		return confirm('All statistic data will be deleted, are you sure ?');
                		});
                });
                </script>
                <?php echo $efav_message; ?>
                <div class="tab-content">
                    <form action="" method="post">
                    <?php wp_nonce_field('efav_action'); ?>
                        <div id="tab1" class="tab active">
                            <div class="postbox">
                                <div title="<?php _e("Click to open/close", "efav-favourite-posts"); ?>" class="handlediv">
                                  <br>
                                </div>
                                <h3 class="hndle"><span><?php echo esc_attr("EFavourite Options", "efav-favourite-posts"); ?></span></h3>
                                <div class="inside" style="display: block;">

                                    <table class="form-table">
                                        <tr>
                                            <th><?php echo esc_attr("Only registered users can favourite", "efav-favourite-posts") ?></th><td><input type="checkbox" name="efav_opt_only_registered" value="1" <?php if (stripslashes($efav_options['efav_opt_only_registered']) == "1") echo "checked='checked'"; ?> /></td>
                                        </tr>

                                        <tr>
                                            <th><?php echo esc_attr("Auto show favourite link", "efav-favourite-posts") ?></th>
                                            <td>
                                                <select name="efav_autoshow">
                                                    <option value="custom" <?php if ($efav_options['efav_autoshow'] == 'custom') echo "selected='selected'" ?>>Custom</option>
                                                    <option value="after" <?php if ($efav_options['efav_autoshow'] == 'after') echo "selected='selected'" ?>>After post</option>
                                                    <option value="before" <?php if ($efav_options['efav_autoshow'] == 'before') echo "selected='selected'" ?>>Before post</option>
                                                </select>
                                                (Custom: insert <strong>&lt;?php efav_link() ?&gt;</strong> wherever you want to show favourite link)
                                            </td>
                                        </tr>

                                        <tr>
                                            <th><?php echo esc_attr("Before Link Image", "efav-favourite-posts") ?></th>
                                            <td>
                                                <p>
                                                <?php
                                                $efav_images[] = "efav-star.png";
                                                $efav_images[] = "efav-heart.png";
                                                $efav_images[] = "efav-starwithheart.png";
                                                foreach ($efav_images as $efav_img):
                                                ?>
                                                <label for="<?php echo $efav_img ?>">
                                                    <input type="radio" name="efav_before_image" id="<?php echo $efav_img ?>" value="<?php echo $efav_img ?>" <?php if ($efav_options['efav_before_image'] == $efav_img) echo "checked='checked'" ?> />
                                                    <img src="<?php echo EFAV_PATH; ?>/img/<?php echo $efav_img; ?>" alt="<?php echo $efav_img; ?>" title="<?php echo $efav_img; ?>" class="efav-img" />
                                                </label>
                                                <?php
                                                endforeach;
                                                ?>
                                                <label for="none">
                                                    <input type="radio" name="efav_before_image" id="none" value="" <?php if ($efav_options['efav_before_image'] == '') echo "checked='checked'" ?> />
                                                    No Image
                                                </label>
                                                <br/><br/>
                                                <label for="custom">
                                                    <input type="radio" name="efav_before_image" id="efav_custom" value="efav_custom" <?php if ($efav_options['efav_before_image'] == 'efav_custom') echo "checked='checked'" ?> />
                                                    Custom Image URL :
                                                </label>
                                                <input type="efav_custom_before_image" name="efav_custom_before_image" value="<?php echo esc_attr($efav_options['efav_custom_before_image']); ?>" />
                                            </td>
                                        </tr>

                                        <tr>
                                            <th><?php echo esc_attr("Favourite post per page", "efav-favourite-posts") ?></th>
                                            <td>
                                                <input type="text" name="efav_post_per_page" size="2" value="<?php echo esc_attr($efav_options['efav_post_per_page']); ?>" /> * This only works with default favourite post list page (efav-page-template.php).
                                            </td>
                                        </tr>
                                        <tr>
                                            <th><?php echo esc_attr("Most favourited posts statistics", "efav-favourite-posts") ?>*</th>
                                            <td>
                                                <label for="stats-enabled"><input type="radio" name="efav_statistics" id="stats-enabled" value="1" <?php if ($efav_options['efav_statistics']) echo "checked='checked'" ?> /> Enabled</label>
                                                <label for="stats-disabled"><input type="radio" name="efav_statistics" id="stats-disabled" value="0" <?php if (!$efav_options['efav_statistics']) echo "checked='checked'" ?> /> Disabled</label>
                                                <p>(Enable this option to show counts of favourited posts in widget)</p>
                                            </td>
                                        </tr>
                                    	<tr><td></td>
                                            <td>
                                            	<div class="submitbox">
                            	                	<div id="delete-action">
                            						<a href="?page=efav-favourite-posts&amp;efavaction=efav-reset-statistics" id="efav-reset-statistics" class="submitdelete deletion">Click Here Reset Statistic Data</a>
                            						</div>
                            					</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td colspan="2">
                                                <p><a href="widgets.php" title="Go to widgets">"Most Favourited Posts" widget settings</a>.</p>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th></th>
                                            <td>
                                                <div class="push-submit"> 
                                                    <p class="submit">
                                                        <input id="licence_api" type="submit" name="submit" class="button button-primary" value="<?php echo esc_attr('Save Settings'); ?>" />
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>

                                </div>
                            </div>
                        </div>
                        <div id="tab2" class="tab">
                            <div class="postbox">
                                <div title="" class="handlediv">
                                  <br>
                                </div>
                                <h3 class="hndle"><span><?php echo esc_attr("EFavourite Label Settings", "efav-favourite-posts") ?></span></h3>
                                <div class="inside" style="display: block;">


                                    <table class="form-table">
                                        <tr>
                                            <th><?php echo esc_attr("Text for add link", "efav-favourite-posts") ?></th><td><input type="text" name="efav_add_favourite" value="<?php echo esc_attr($efav_options['efav_add_favourite']); ?>" /></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo esc_attr("Text for added", "efav-favourite-posts") ?></th><td><input type="checkbox"  <?php if ($efav_options['efav_added'] == 'show remove link') echo "checked='checked'"; ?> name="efav_show_remove_link" onclick="jQuery('#efav_added').val(''); jQuery('#efav_added').toggle();" value="efav_show_remove_link" id="efav_show_remove_link" /> <label for="efav_show_remove_link">Show remove link</label>
                            				<br /><input id="efav_added" type="text" name="efav_added" <?php if ($efav_options['efav_added'] == 'show remove link') echo "style='display:none;'"; ?> value="<?php echo esc_attr($efav_options['efav_added']); ?>" /></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo esc_attr("Text for remove link", "efav-favourite-posts") ?></th><td><input type="text" name="efav_remove_favourite" value="<?php echo esc_attr($efav_options['efav_remove_favourite']); ?>" /></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo esc_attr("Text for removed", "efav-favourite-posts") ?></th>
                            				<td><input type="checkbox" <?php if ($efav_options['efav_removed'] == 'show add link') echo "checked='checked'"; ?> name="efav_show_add_link" id="efav_show_add_link" onclick="jQuery('#efav_removed').val(''); jQuery('#efav_removed').toggle();" value='efav_show_add_link' /> <label for="efav_show_add_link">Show add link</label>
                            				<br />
                            				<input id="efav_removed" type="text" name="efav_removed" <?php if ($efav_options['efav_removed'] == 'show add link') echo "style='display:none;'"; ?> value="<?php echo esc_attr($efav_options['efav_removed']); ?>" /></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo esc_attr("Text for clear link", "efav-favourite-posts") ?></th><td><input type="text" name="efav_clear" value="<?php echo esc_attr($efav_options['efav_clear']); ?>" /></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo esc_attr("Text for cleared", "efav-favourite-posts") ?></th><td><input type="text" name="efav_cleared" value="<?php echo esc_attr($efav_options['efav_cleared']); ?>" /></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo esc_attr("Text for favourites are empty", "efav-favourite-posts") ?></th><td><input type="text" name="efav_favourites_empty" value="<?php echo esc_attr($efav_options['efav_favourites_empty']); ?>" /></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo esc_attr("Text for [remove] link", "efav-favourite-posts") ?></th><td><input type="text" name="efav_rem" value="<?php echo esc_attr($efav_options['efav_rem']); ?>" /></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo esc_attr("Text for favourites saved to cookies", "efav-favourite-posts") ?></th><td><textarea name="efav_cookie_warning" rows="3" cols="35"><?php echo esc_attr($efav_options['efav_cookie_warning']); ?></textarea></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo esc_attr("Text for \"only registered users can favourite\" error message", "efav-favourite-posts") ?></th><td><textarea name="efav_text_only_registered" rows="2" cols="35"><?php echo esc_attr($efav_options['efav_text_only_registered']); ?></textarea></td>
                                        </tr>

                                        <tr>
                                            <th></th>
                                            <td>
                                                <div class="push-submit"> 
                                                    <p class="submit">
                                                        <input id="licence_api" type="submit" name="submit" class="button button-primary" value="<?php echo esc_attr('Save Settings'); ?>" />
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="tab3" class="tab">
                            <div class="postbox">
                                <div title="<?php echo esc_attr("Click to open/close", "efav-favourite-posts"); ?>" class="handlediv">
                                  <br>
                                </div>
                                <h3 class="hndle"><span><?php echo esc_attr('EFavourite Custom Posts Settings', 'efav-favourite-posts'); ?></span></h3>
                                <div class="inside" style="display: block;">
                                    <table class="form-table">
                                        <tr valign="top">
                                            <th scope="row"><?php echo esc_attr('Select Posts to Display as Favourite', 'push-notifications'); ?></th>
                                            <td>
                                            <?php 
                                            $get_post_args = array(
                                                               'public'   => true,
                                                               '_builtin' => false
                                                            );
                                            $all_post_types = get_post_types($get_post_args,'objects');
                                            $posts_in_db = get_option('efav_multi_posts_options');
                                            foreach ($all_post_types as $all_post_key) {
                                              if(isset($posts_in_db) && $posts_in_db != "")
                                              {
                                                  if(in_array($all_post_key->name, $posts_in_db))
                                                  {
                                                    $checked_val = "checked";
                                                  }
                                              }
                                              else
                                              {
                                                $checked_val = "";
                                              }?>
                                              <input type="checkbox" name="efav_multi_posts_options[]" value="<?php echo $all_post_key->name; ?>" <?php echo $checked_val; ?>><label><?php echo esc_attr($all_post_key->labels->name); ?></label><br/>
                                            <?php }?>
                                            </td>
                                          </tr>			
                                        <tr>
                                            <td>
                                                <div class="push-submit"> 
                                                    <p class="submit">
                                                        <input id="licence_api" type="submit" name="submit" class="button button-primary" value="<?php echo esc_attr('Save Settings'); ?>" />
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div id="tab4" class="tab">
                            <div class="postbox">
                                <div title="<?php echo esc_attr("Click to open/close", "efav-favourite-posts"); ?>" class="handlediv">
                                  <br>
                                </div>
                                <h3 class="hndle"><span><?php echo esc_attr('Efavourite Help', 'efav-favourite-posts'); ?></span></h3>
                                <div class="inside" style="display: block;">
                                     <p style="text-align:center;">If you like EFavourite Posts please leave us a <a href="#" target="_blank">★★★★★</a> rating. A huge thanks in advance! Version 1.0</p>
                                     <p style="text-align:center;">Author <a href="https://excellentwebworld.com/" target="_blank">Excellent WebWorld</a></p>  
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
