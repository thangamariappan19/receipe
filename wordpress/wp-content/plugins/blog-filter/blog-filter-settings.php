<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
//toggle button CSS
wp_enqueue_style( 'awl-blog-filter-settings-css', plugin_dir_url( __FILE__ ) . 'css/blog-filter-settings.css' );
wp_enqueue_style( 'awl-font-awesome-4-min-css', plugin_dir_url( __FILE__ ).'css/font-awesome-4.min.css' );
wp_enqueue_style( 'awl-bootstrap-css', plugin_dir_url( __FILE__ ) .'css/blog-filter-bootstrap.css' );
wp_enqueue_style( 'awl-styles-css', plugin_dir_url( __FILE__ ) . 'css/styles.css' );
wp_enqueue_style( 'wp-color-picker' );
//js
wp_enqueue_script('jquery');
wp_enqueue_script('wp-color-picker');
wp_enqueue_script('awl-blog-filter-isotope-js', plugin_dir_url( __FILE__ ) .'js/isotope.pkgd.js', array('jquery'), '' , false);
wp_enqueue_script( 'awl-bootstrap-js',  plugin_dir_url( __FILE__ ) .'js/bootstrap.js', array( 'jquery' ), '', true  ); ?>
<div class="panel panel-info" style="margin-top:20px; margin-bottom:10px;">
	<div class="panel-heading text-center">
		<h3 class="panel-title"><?php _e('Blog Filter Settings Page', BF_TXTDM); ?></h3>
	</div>
	<div class="panel-body " style="padding-top:20px" id="BlogFilter-SettingsPags">
		<div class="module-wrapper masonry-item col-lg-4 col-md-4 col-sm-12 col-xs-12" style="">
			<section class="module module-headings">
				<div class="module-inner">
					<div class="module-heading">
						<h3 class="module-title"><?php _e('Column Settings', BF_TXTDM); ?></h3>
					</div>
					<div class="module-content collapse in" id="content-1">
						<div class="module-content-inner">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Column On Large Desktop', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<p><a class="btn btn-link" target="_blank" href="https://awplife.com/product/blog-filter-wordpress-plugin/" style="text-decoration:none">Upgrade To Pro</a></p>
							</div>
						</div>
						<div class="module-content-inner">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Column On Desktop', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<p><a class="btn btn-link" target="_blank" href="https://awplife.com/product/blog-filter-wordpress-plugin/" style="text-decoration:none">Upgrade To Pro</a></p>
							</div>
						</div>
						<div class="module-content-inner">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Column On Tablet', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<p><a class="btn btn-link" target="_blank" href="https://awplife.com/product/blog-filter-wordpress-plugin/" style="text-decoration:none">Upgrade To Pro</a></p>
							</div>
						</div>
						<div class="module-content-inner">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Column On Phone', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<p><a class="btn btn-link" target="_blank" href="https://awplife.com/product/blog-filter-wordpress-plugin/" style="text-decoration:none">Upgrade To Pro</a></p>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<div class="module-wrapper masonry-item col-lg-4 col-md-4 col-sm-12 col-xs-12" style="">
			<section class="module module-headings">
				<div class="module-inner">
					<div class="module-heading">
						<h3 class="module-title"><?php _e('Image Settings', BF_TXTDM); ?></h3>
					</div>
					<div class="module-content collapse in" id="content-1">
						<div class="module-content-inner">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Show Blog Images', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<label class="switch">
									<input type="checkbox" id="blog_image" name="blog_image" value="yes" checked >
									<div class="slider round"></div>
								</label>
							</div>
						</div>
						<div class="module-content-inner">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Image Quality', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<select id="blog_image_quality" name="blog_image_quality" class="blog_image_quality" style="cursor:pointer;">
									<option value="thumbnail" ><?php _e('Thumbnail', BF_TXTDM); ?></option>
									<option value="medium" selected><?php _e('Medium', BF_TXTDM); ?></option>
									<option value="large" ><?php _e('Large', BF_TXTDM); ?></option>
									<option value="full" ><?php _e('Full', BF_TXTDM); ?></option>
								</select>
							</div>
						</div>
						<div class="module-content-inner">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Image Hover Effect', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<select id="blog_image_hover_effect" name="blog_image_hover_effect" class="selectbox_position_newslide" style="cursor:pointer;">
									<option value="none" ><?php _e('None', BF_TXTDM); ?> &nbsp &nbsp </option>
									<option value="hover1" selected ><?php _e('Hover 1', BF_TXTDM); ?></option>
								</select>
							</div>
						</div>
						<p><?php _e('Get more hover effect in Pro', BF_TXTDM); ?></p>
						<div class="module-content-inner">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Link On Image', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<p><a class="btn btn-link" target="_blank" href="https://awplife.com/product/blog-filter-wordpress-plugin/" style="text-decoration:none">Upgrade To Pro</a></p>
							</div>
						</div>
						<div class="module-content-inner">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Lightbox On Image', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<p><a class="btn btn-link" target="_blank" href="https://awplife.com/product/blog-filter-wordpress-plugin/" style="text-decoration:none">Upgrade To Pro</a></p>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<div class="module-wrapper masonry-item col-lg-4 col-md-4 col-sm-12 col-xs-12" style="">
			<section class="module module-headings">
				<div class="module-inner">
					<div class="module-heading">
						<h3 class="module-title"><?php _e('Title Settings', BF_TXTDM); ?></h3>
					</div>
					<div class="module-content collapse in" id="content-1">
						<div class="module-content-inner ">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Show Blog Title', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<label class="switch">
									<input type="checkbox" id="blog_title" name="blog_title" value="yes" checked >
									<div class="slider round"></div>
								</label>
							</div>
						</div>
						<div class="module-content-inner title_setings">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Title Text Color', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<input type="text" class="form-control" id="blog_title_color" name="blog_title_color" value="#000" default-color="#000">
							</div>
						</div>
						<div class="module-content-inner title_setings">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Title Font Size', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<p><a class="btn btn-link" target="_blank" href="https://awplife.com/product/blog-filter-wordpress-plugin/" style="text-decoration:none">Upgrade To Pro</a></p>
							</div>
						</div>
						<div class="module-content-inner title_setings">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Title Below The Image', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<p><a class="btn btn-link" target="_blank" href="https://awplife.com/product/blog-filter-wordpress-plugin/" style="text-decoration:none">Upgrade To Pro</a></p>
							</div>
						</div>
						<div class="module-content-inner title_setings">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Link On Title', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<p><a class="btn btn-link" target="_blank" href="https://awplife.com/product/blog-filter-wordpress-plugin/" style="text-decoration:none">Upgrade To Pro</a></p>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<div class="module-wrapper masonry-item col-lg-4 col-md-4 col-sm-12 col-xs-12" style="">
			<section class="module module-headings">
				<div class="module-inner">
					<div class="module-heading">
						<h3 class="module-title"><?php _e('Description Settings', BF_TXTDM); ?></h3>
					</div>
					<div class="module-content collapse in" id="content-1">
						<div class="module-content-inner ">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Show Blog Description', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<label class="switch">
									<input type="checkbox" id="blog_desc" name="blog_desc" value="yes" checked >
									<div class="slider round"></div>
								</label>
							</div>
						</div>
						<div class="module-content-inner ">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('How Much Characters Show In Description', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<input type="number" id="blog_desc_words" name="blog_desc_words" value="100" style="width: -webkit-fill-available;" >
							</div>
						</div>
						<div class="module-content-inner">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Description Text Color', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<p><a class="btn btn-link" target="_blank" href="https://awplife.com/product/blog-filter-wordpress-plugin/" style="text-decoration:none">Upgrade To Pro</a></p>
							</div>
						</div>
						<div class="module-content-inner">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Description Box Color', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<p><a class="btn btn-link" target="_blank" href="https://awplife.com/product/blog-filter-wordpress-plugin/" style="text-decoration:none">Upgrade To Pro</a></p>
							</div>
						</div>
						<div class="module-content-inner">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Description Font Size', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<p><a class="btn btn-link" target="_blank" href="https://awplife.com/product/blog-filter-wordpress-plugin/" style="text-decoration:none">Upgrade To Pro</a></p>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<div class="module-wrapper masonry-item col-lg-4 col-md-4 col-sm-12 col-xs-12" style="">
			<section class="module module-headings">
				<div class="module-inner">
					<div class="module-heading">
						<h3 class="module-title"><?php _e('Link (URL) Settings', BF_TXTDM); ?></h3>
					</div>
					<div class="module-content collapse in" id="content-1">
						<div class="module-content-inner ">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Show Read More Link', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<label class="switch">
									<input type="checkbox" id="blog_read_more" name="blog_read_more" value="yes" checked >
									<div class="slider round"></div>
								</label>
							</div>
						</div>
						<div class="module-content-inner ">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Text For Read More Link', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
							<input type="text" id="blog_read_more_text" name="blog_read_more_text" value="Read More" style="width: -webkit-fill-available;" >
							</div>
						</div>
						<div class="module-content-inner ">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Link Open In New Tab', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<p><a class="btn btn-link" target="_blank" href="https://awplife.com/product/blog-filter-wordpress-plugin/" style="text-decoration:none">Upgrade To Pro</a></p>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<div class="module-wrapper masonry-item col-lg-4 col-md-4 col-sm-12 col-xs-12" style="">
			<section class="module module-headings">
				<div class="module-inner">
					<div class="module-heading">
						<h3 class="module-title"><?php _e('Post Meta Settings', BF_TXTDM); ?></h3>
					</div>
					<div class="module-content collapse in" id="content-1">
						<div class="module-content-inner ">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Show Post Date', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<label class="switch">
									<input type="checkbox" id="blog_date" name="blog_date" value="yes" checked >
									<div class="slider round"></div>
								</label>
							</div>
						</div>
						<div class="module-content-inner title_setings">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Date Below The Image', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<p><a class="btn btn-link" target="_blank" href="https://awplife.com/product/blog-filter-wordpress-plugin/" style="text-decoration:none">Upgrade To Pro</a></p>
							</div>
						</div>
						<div class="module-content-inner ">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Show Post Author', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<p><a class="btn btn-link" target="_blank" href="https://awplife.com/product/blog-filter-wordpress-plugin/" style="text-decoration:none">Upgrade To Pro</a></p>
							</div>
						</div>
						
						<div class="module-content-inner ">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Show Post Categories', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<p><a class="btn btn-link" target="_blank" href="https://awplife.com/product/blog-filter-wordpress-plugin/" style="text-decoration:none">Upgrade To Pro</a></p>
							</div>
						</div>
						<div class="module-content-inner ">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Show Post Tags', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<p><a class="btn btn-link" target="_blank" href="https://awplife.com/product/blog-filter-wordpress-plugin/" style="text-decoration:none">Upgrade To Pro</a></p>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<div class="module-wrapper masonry-item col-lg-4 col-md-4 col-sm-12 col-xs-12" style="">
			<section class="module module-headings">
				<div class="module-inner">
					<div class="module-heading">
						<h3 class="module-title"><?php _e('Filter Settings', BF_TXTDM); ?></h3>
					</div>
					<div class="module-content collapse in" id="content-1">
						<div class="module-content-inner ">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Show Filters', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<label class="switch">
									<input type="checkbox" id="blog_filters" name="blog_filters" value="yes" checked >
									<div class="slider round"></div>
								</label>
							</div>
						</div>
						<div class="module-content-inner ">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Show Filter "All"', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<label class="switch">
									<input type="checkbox" id="blog_filter_all" name="blog_filter_all" value="yes" >
									<div class="slider round"></div>
								</label>
							</div>
						</div>
						<div class="module-content-inner">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Buttons Color', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<input type="text" class="form-control" id="blog_buttons_color" name="blog_buttons_color" value="#58BBEE" default-color="#58BBEE">
							</div>
						</div>
						<div class="module-content-inner ">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Already Selected First Filter', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<p><a class="btn btn-link" target="_blank" href="https://awplife.com/product/blog-filter-wordpress-plugin/" style="text-decoration:none">Upgrade To Pro</a></p>
							</div>
						</div>
						<div class="module-content-inner">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Filtering with', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<select id="blog_filtering" name="blog_filtering" class="selectbox_position_newslide" style="cursor:pointer;">
									<option value="blog_category" selected><?php _e('Category', BF_TXTDM); ?></option>
									<option value="blog_tag" ><?php _e('Tag', BF_TXTDM); ?></option>
								</select>
							</div>
						</div>
						<div id="cat_filtering" class="module-content-inner ">
							<div class="table-responsive" style="max-height:400px;" >
								<?php $taxonomy_name = 'category';
								$term_args = array( 'hide_empty' => true, );
								$terms = get_terms($taxonomy_name, $term_args); // Get all terms of a taxonomy
								if ( $terms && !is_wp_error( $terms ) ) : ?>
									<table class="table table-bordered">
										<thead>
										  <tr>
											<th><?php _e('ID', BF_TXTDM); ?></th>
											<th><?php _e('Category', BF_TXTDM); ?></th>
											<th class="text-center"><?php _e('Select', BF_TXTDM); ?></th>
										  </tr>
										</thead>
										<tbody>
										<?php foreach ( $terms as $term) { ?>
										  <tr>
											<td><?php echo $term->term_id; ?></td>
											<td><?php _e($term->name, BF_TXTDM); ?></td>
											<td class="text-center"><input class="checkbox_cat" type="checkbox" id="selected_categories[]" name="selected_categories[]" value="<?php echo $term->term_id; ?>"></td>
										  </tr>
										  <?php } ?>
										</tbody>
									</table>
									<?php
								endif; ?>
							</div>
							<p><b><?php _e('Note: In free version you can use only 4 categories as filters', BF_TXTDM); ?></b></p>
						</div>
						<div id="tag_filtering" style="display:none;" class="module-content-inner ">
							<div class="table-responsive" style="max-height:400px;" >
								<?php $taxonomy_name = 'post_tag';
								$term_args = array( 'hide_empty' => true, );
								$terms = get_terms($taxonomy_name, $term_args); // Get all terms of a taxonomy
								if ( $terms && !is_wp_error( $terms ) ) : ?>
									<table class="table table-bordered">
										<thead>
										  <tr>
											<th><?php _e('ID', BF_TXTDM); ?></th>
											<th><?php _e('Post Tag', BF_TXTDM); ?></th>
											<th class="text-center"><input class="checkbox_tag" type="checkbox" id="all_checked_tag" name="all_checked_tag"></th>
										  </tr>
										</thead>
										<tbody>
										  <?php foreach ( $terms as $term) { ?>
										  <tr>
											<td><?php echo $term->term_id; ?></td>
											<td><?php _e($term->name, BF_TXTDM); ?></td>
											<td class="text-center"><input class="checkbox_tag" type="checkbox" id="selected_tags[]" name="selected_tags[]" value="<?php echo $term->term_id; ?>"></td>
										  </tr>
										  <?php } ?>
										</tbody>
									</table>
									<?php
								endif; ?>
							</div>
							<p><b><?php _e('Note: In free version you can use only 4 tags as filters', BF_TXTDM); ?></b></p>
						</div>
					</div>
				</div>
			</section>
		</div>
		<div class="module-wrapper masonry-item col-lg-4 col-md-4 col-sm-12 col-xs-12" style="">
			<section class="module module-headings">
				<div class="module-inner">
					<div class="module-heading">
						<h3 class="module-title"><?php _e('Pagination Settings', BF_TXTDM); ?></h3>
					</div>
					<div class="module-content collapse in" id="content-1">
						<div class="module-content-inner ">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Pagination', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<label class="switch">
									<input type="checkbox" id="blog_pagination" name="blog_pagination" value="yes" checked>
									<div class="slider round"></div>
								</label>
							</div>
						</div>
						<div class="module-content-inner title_setings">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Blogs On Per Page', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<p><a class="btn btn-link" target="_blank" href="https://awplife.com/product/blog-filter-wordpress-plugin/" style="text-decoration:none">Upgrade To Pro</a></p>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
		<div class="module-wrapper masonry-item col-lg-4 col-md-4 col-sm-12 col-xs-12" style="">
			<section class="module module-headings">
				<div class="module-inner">
					<div class="module-heading">
						<h3 class="module-title"><?php _e('Try Pro Version 4.7 ', BF_TXTDM); ?></h3>
					</div>
					<div class="module-content collapse in" id="content-1">
						<div class="module-content-inner title_setings">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Update Sortcode, Without Regenerate It', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<p><a class="btn button_1 btn-primary" target="_blank" href="https://awplife.com/configure-blog-filter-plugin-shortcode/" style="text-decoration:none">See Post</a></p>
							</div>
						</div>
						<div class="module-content-inner title_setings">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Contact Us', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<p><a class="btn button_1 btn-primary" target="_blank" href="https://awplife.com/contact" style="text-decoration:none">Contact</a></p>
							</div>
						</div>
						<div class="module-content-inner ">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('See Live Demo of Pro', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<p><a class="btn button_1 btn-primary" target="_blank" href="https://awplife.com/demo/blog-filter-premium/" style="text-decoration:none">Live Demo</a></p>
							</div>
						</div>
						<div class="module-content-inner title_setings">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<p><b><?php _e('Buy Pro', BF_TXTDM); ?></b></p>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
								<p><a class="btn button_1 btn-primary" target="_blank" href="https://awplife.com/product/blog-filter-wordpress-plugin/" style="text-decoration:none">Buy Pro Plugin</a></p>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
<div class="panel panel-info bf_pannel_bottom">
	<div class="panel-body eva-bottom-panel">
		<div class="col-md-6 text-left">
			<div class="eva_option_head">
			<h3 class="bf_footer_title"><?php _e('Blog Filter', BF_TXTDM); ?> <p style="display:inline;"><?php _e('Version - ', BF_TXTDM); _e(BF_PLUGIN_VER, BF_TXTDM); ?><p></h3>
			</div>
		</div>
		<div class="col-md-6 text-right">
			<div class="eva_option_head">
			<button type="button" onclick="BfGetShortcode();" class="bf_button button_1"><?php _e('[ Generate Sortcode ]', BF_TXTDM); ?></button>
			</div>
		</div>
	</div>
</div>
<div class="loader" style="display:none;"></div>
<div class="modal" id="modal-show-shortcode" tabindex="-1" role="dialog" aria-labelledby="modal-new-short-code-label">
	<div class="modal-dialog" role="document" id="inner-modal">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="modal-new-ticket-label"><?php _e('Blog Filter Shortcode', BF_TXTDM); ?></h4>
			</div>
			<div id="" class="modal-body text-center">
				<p><?php _e('Copy The Shortcode', BF_TXTDM); ?></p>
				<textarea id="awl-shortcode" readonly rows="13" cols="120" style="width: 468px;">
				</textarea>
				<div id="" class="center-block text-center">
					<button type="button" class="bf_button button_1" data-toggle="tooltip" title="Copied" onclick="CopyShortcode()" ><i class="fa fa-copy" aria-hidden="true"></i> <?php _e('Copy Sortcode', BF_TXTDM); ?></button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
//short code []
function BfGetShortcode() {
	var shortcode = '[AWL-BlogFilter';
	
	var blog_image = jQuery("#blog_image").val();
	if(jQuery("#blog_image").prop('checked') == true){
		shortcode = shortcode + ' blog_image="' + blog_image + '"';
	} else {
		shortcode = shortcode + '';
	}
	
	var blog_image_quality = jQuery("#blog_image_quality").val();
	if(blog_image_quality){
		shortcode = shortcode + ' blog_image_quality="' + blog_image_quality + '"';
	}
	
	var blog_image_hover_effect = jQuery("#blog_image_hover_effect").val();
	if(blog_image_hover_effect){
		shortcode = shortcode + ' blog_image_hover_effect="' + blog_image_hover_effect + '"';
	}
	
	var blog_title = jQuery("#blog_title").val();
	if(jQuery("#blog_title").prop('checked') == true){
		shortcode = shortcode + ' blog_title="' + blog_title + '"';
	} else {
		shortcode = shortcode + '';
	}
	
	var blog_title_color = jQuery("#blog_title_color").val();
	if(blog_title_color){
		shortcode = shortcode + ' blog_title_color="' + blog_title_color + '"';
	}
	
	var blog_desc = jQuery("#blog_desc").val();
	if(jQuery("#blog_desc").prop('checked') == true){
		shortcode = shortcode + ' blog_desc="' + blog_desc + '"';
	} else {
		shortcode = shortcode + '';
	}
	
	var blog_desc_words = jQuery("#blog_desc_words").val();
	if(blog_desc_words){
		shortcode = shortcode + ' blog_desc_words="' + blog_desc_words + '"';
	}
	
	var blog_read_more = jQuery("#blog_read_more").val();
	if(jQuery("#blog_read_more").prop('checked') == true){
		shortcode = shortcode + ' blog_read_more="' + blog_read_more + '"';
	} else {
		shortcode = shortcode + '';
	}
	
	var blog_read_more_text = jQuery("#blog_read_more_text").val();
	if(blog_read_more_text){
		shortcode = shortcode + ' blog_read_more_text="' + blog_read_more_text + '"';
	}
	
	var blog_date = jQuery("#blog_date").val();
	if(jQuery("#blog_date").prop('checked') == true){
		shortcode = shortcode + ' blog_date="' + blog_date + '"';
	} else {
		shortcode = shortcode + '';
	}
	
	var blog_pagination = jQuery("#blog_pagination").val();
	if(jQuery("#blog_pagination").prop('checked') == true){
		shortcode = shortcode + ' blog_pagination="' + blog_pagination + '"';
	} else {
		shortcode = shortcode + '';
	}
	
	var blog_filters = jQuery("#blog_filters").val();
	if(jQuery("#blog_filters").prop('checked') == true){
		shortcode = shortcode + ' blog_filters="' + blog_filters + '"';
	} else {
		shortcode = shortcode + '';
	}
	
	var blog_filter_all = jQuery("#blog_filter_all").val();
	if(jQuery("#blog_filter_all").prop('checked') == true){
		shortcode = shortcode + ' blog_filter_all="' + blog_filter_all + '"';
	} else {
		shortcode = shortcode + '';
	}
	
	var blog_buttons_color = jQuery("#blog_buttons_color").val();
	if(blog_buttons_color){
		shortcode = shortcode + ' blog_buttons_color="' + blog_buttons_color + '"';
	}
	
	var blog_filtering = jQuery("#blog_filtering").val();
	if(blog_filtering){
		shortcode = shortcode + ' blog_filtering="' + blog_filtering + '"';
	}
	
	if( blog_filtering == 'blog_category' ) {
		var selected_categories = [];
		jQuery('.checkbox_cat:checked').map(function() {
			if (jQuery.isNumeric(this.value)) {
				selected_categories.push(this.value);
			}
		});
		shortcode = shortcode + ' selected_categories="' + selected_categories + '"';
	} else if( blog_filtering == 'blog_tag' ) {
		var selected_tags = [];
		jQuery('.checkbox_tag:checked').map(function() {
			if (jQuery.isNumeric(this.value)) {
				selected_tags.push(this.value);
			}
		});
		shortcode = shortcode + ' selected_tags="' + selected_tags + '"';
	}
	
	shortcode = shortcode + ' custom-css="' + ' "';
	
	shortcode = shortcode + ' ]';
	
	jQuery('#awl-shortcode').text(shortcode);
	jQuery('#modal-show-shortcode').modal('show');
}

function CopyShortcode() {
	var copyText = document.getElementById("awl-shortcode");
	copyText.select();
	document.execCommand("copy");
}

jQuery('.checkbox_cat').click(function () {
	jQuery(this).next().next().prop('disabled', !this.checked)
	jQuery('.checkbox_cat').not(':checked').prop('disabled', jQuery('.checkbox_cat:checked').length == 4);
});
jQuery('.checkbox_tag').click(function () {
	jQuery(this).next().next().prop('disabled', !this.checked)
	jQuery('.checkbox_tag').not(':checked').prop('disabled', jQuery('.checkbox_tag:checked').length == 4);
});

jQuery(document).ready(function () {
	// isotope effect function
	// Method 1 - Initialize Isotope, then trigger layout after each image loads.
	var $grid = jQuery('#BlogFilter-SettingsPags').isotope({
		// options...
		itemSelector: '.module-wrapper',
	});
	
	//range slider
	var rangeSlider = function(){
	  var slider = jQuery('.range-slider'),
		range = jQuery('.range-slider__range'),
		value = jQuery('.range-slider__value');
		
	  slider.each(function(){
		value.each(function(){
		  var value = jQuery(this).prev().attr('value');
		  jQuery(this).html(value);
		});
		range.on('input', function(){
		  jQuery(this).next(value).html(this.value);
		});
	  });
	};
	rangeSlider();
	
	//color-picker
	(function( jQuery ) {
		jQuery(function() {
			// Add Color Picker to all inputs that have 'color-field' class
			jQuery('#blog_title_color, #blog_desc_color, #blog_desc_box_color, #blog_buttons_color').wpColorPicker();
		});
	})( jQuery );
	jQuery(document).ajaxComplete(function() {
		jQuery('#blog_title_color, #blog_desc_color, #blog_desc_box_color, #blog_buttons_color').wpColorPicker();
	});
	jQuery('#blog_filtering').change(function () {
		var blog_filtering = jQuery('#blog_filtering').val();
		if (blog_filtering == 'blog_category') {
			jQuery('#cat_filtering').show();
			jQuery('#tag_filtering').hide();
		} else if (blog_filtering == 'blog_tag') {
			jQuery('#cat_filtering').hide();
			jQuery('#tag_filtering').show();
		}
	});
	// Tooltip
	jQuery('[data-toggle="tooltip"]').tooltip({
		animated: 'fade',
		placement: 'bottom',
		trigger: 'focus',
		delay: {hide: 1000}
	});
});
</script>