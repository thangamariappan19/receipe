<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
	<div class="blog_filter_main" >
		<?php
		// get all selected categories
		global $wp_query;
		if($blog_filtering == 'blog_category'){
			$taxonomy_name = 'category';
			$term_args = array( 'hide_empty' => true, 'number' => 4, 'include' => $selected_categories );
		} else if($blog_filtering == 'blog_tag') {
			$taxonomy_name = 'post_tag';
			$term_args = array( 'hide_empty' => true, 'number' => 4, 'include' => $selected_tags, );
		}
		$terms = get_terms($taxonomy_name, $term_args); // Get all terms of a taxonomy
		if($blog_filters == "yes"){ 
			if ( $terms && !is_wp_error( $terms ) ) : ?>
				<!-- filters -->
				<div class="text-center">
					<ul class="simplefilter">
					<?php
					if ( $blog_filter_all == "yes" ) { ?>
						<li id="all" class="snip0047 active" data-filter="all"><span style="pointer-events: none;"><?php _e("All", BF_TXTDM); ?></span><i class="fa fa-check" style="pointer-events: none;"></i></li>
					<?php
					} foreach ( $terms as $term) { ?>
						<li class="snip0047" value="<?php echo $term->term_id; ?>" data-filter="<?php echo $term->term_id; ?>"><span style="pointer-events: none;"><?php _e($term->name, BF_TXTDM); ?></span><i class="fa fa-check" style="pointer-events: none;"></i></li>
						<?php
					} ?>
					</ul>
				</div>
				<?php
			endif;
		}
		//$no_of_page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
		// pagination work with front page
		if(is_front_page()) {
			$no_of_page = (get_query_var('page')) ? get_query_var('page') : 1;
		}else {
			$no_of_page = (get_query_var('paged')) ? get_query_var('paged') : 1;
		}
		
		if($blog_filtering == 'blog_category'){
			$custom_query_args_posts = array( 'cat' => $selected_categories, 'posts_per_page' => $blog_per_page, 'paged' => $no_of_page );
		} else if($blog_filtering == 'blog_tag') { 
			$new_selected_tags = explode(",",$selected_tags);
			$custom_query_args_posts = array( 'tag__in' => $new_selected_tags, 'posts_per_page' => $blog_per_page, 'paged' => $no_of_page, );
		}
		$custom_query = new WP_Query( $custom_query_args_posts );
		$temp_query = $wp_query;
		$wp_query   = NULL;
		$wp_query = $custom_query;
		if( $custom_query->have_posts()) : ?>
		<!-- posts -->
		<div id="bf_gallery_1" class="filtr-container filters-div " style="opacity:0;">
			<?php
			$abc = 0;
			while ( $custom_query->have_posts()) : $custom_query->the_post();
				$post_id = get_the_ID();
				//Categories Fetch
				global $post;
				if($blog_filtering == 'blog_category'){
					$category_detail= get_the_category( $post->ID );
					$prefix = $keys = '';
					foreach ($category_detail as $filter_value) {
						$keys .= $prefix . $filter_value->cat_ID;
						$prefix = ', ';
					}
				} else if($blog_filtering == 'blog_tag') {
					$tag_detail= get_the_tags( $post->ID );
					$prefix = $keys = '';
					foreach ($tag_detail as $filter_value) {
						$keys .= $prefix . $filter_value->term_id;
						$prefix = ', ';
					}
				} ?>
				<div id="bf_<?php echo get_the_ID(); ?>" data-category="<?php echo $keys; ?>" data-sort="<?php echo $filter_value->name; ?>" class=" pfg_theme_1 filtr-item filtr_item_1 single_one col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<div class="bf_thumb_box_1 hvr-shadow-radial">
						<div class="bf_title_box_1">
							<?php
							if($blog_title == "yes"){ ?>
								<h3 class="bf_title_1"><?php echo ucwords(the_title()); ?></h3>
							<?php
							} ?>
						</div>
						<?php
						if($blog_image == "yes"){ 
							$image_id = get_post_thumbnail_id();
							$image_title = get_the_title($image_id);
							$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
							if ( empty( $image_alt )) {
							$image_alt = $image_title; }
							
							if($blog_image_hover_effect == "hover1"){ ?>
								<figure class="snip1550">
									<img title="<?php echo $image_title ?>" class="portfolio_thumbnail" src="<?php echo get_the_post_thumbnail_url(null, $blog_image_quality); ?>" alt="<?php echo $image_alt ?>">
								</figure>
							<?php
							} if($blog_image_hover_effect == "none"){ ?>
								<img title="<?php echo $image_title ?>" class="portfolio_thumbnail" src="<?php echo get_the_post_thumbnail_url(null, $blog_image_quality); ?>" alt="<?php echo $image_alt ?>">
							<?php
							}
						} ?>
						<div class="bf_title_box_2">
							<?php
							if($blog_date == "yes"){ 
								$day   = get_the_date('d');
								$month = get_the_date('M');
								$year = get_the_date('Y');
								?>
								<div class="metaInfo">
									<span><i class="fa fa-calendar"></i> <a href="<?php echo get_day_link( $year, $month, $day ); ?>"><?php the_time('j F, Y'); ?></a> </span>
								</div>
							<?php
							} if($blog_desc == "yes"){ ?>
								<div class="bf_desc_1">
									<?php echo ucfirst(stripcslashes(substr(get_the_excerpt(), 0, $blog_desc_words)).'...'); ?>
								</div>
							<?php
							} if($blog_read_more == "yes"){ ?>
								<div class="bf_read_more_div_1">
									<a class="snip0047 bf_read_more_1" href="<?php the_permalink(); ?>" target="<?php echo $link_open_new_tab; ?>"><span><?php echo $blog_read_more_text; ?></span><i class="fa fa-link"></i></a>
								</div>
							<?php
							} ?>
						</div>
					</div>
				</div>
				<?php
				$abc++;
			endwhile;
			// Reset Post Data
			wp_reset_postdata(); ?>
		</div>
		<div class="loader"></div>
		<div style="text-align: center; <?php if($blog_pagination == "no"){ ?> display:none; <?php } ?>" class="pagination1 font-alt col-lg-12 col-md-12 col-sm-12">
			<?php the_posts_pagination( array(
				'mid_size' => 2,
				'prev_text' => __( '<i class="fa fa-caret-left"></i>', 'textdomain' ),
				'next_text' => __( '<i class="fa fa-caret-right"></i>', 'textdomain' ),
			) );
			// Reset main query object
			$wp_query = NULL;
			$wp_query = $temp_query;
			?>
		</div>
	</div>
	<script>
	jQuery( window ).load(function() {
		var first_active_filter = jQuery( ".simplefilter li:first-child" ).val();
		// Animate loader off screen
		jQuery(".loader").hide();
		jQuery("#bf_gallery_1").css("opacity", 1);
		//Filterizd Default options
		options = {
			animationDuration: 0.5,
			callbacks: {
				onFilteringStart: function() { },
				onFilteringEnd: function() { },
				onShufflingStart: function() { },
				onShufflingEnd: function() { },
				onSortingStart: function() { },
				onSortingEnd: function() { }
			},
			filter:"all",
			layout: 'sameWidth',
			selector: '#bf_gallery_1',
			setupControls: true
		}
		var filterizd = jQuery('#bf_gallery_1').filterizr('setOptions', options);
	});

	//Pagination class add and active class add
	jQuery(document).ready(function(){
		jQuery( "ul.page-numbers" ).addClass( "pagination mrgt-0" );
	});
	</script>
	<?php
	endif; ?>