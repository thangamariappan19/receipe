<?php
/**
 * The main template file.
 *
 *
 * @package cartel
 */

get_header(); ?>

    <div id="masonry">
     <div class="container">
        <div class="row">
<?php echo do_shortcode( '[searchandfilter fields="search,category,post_tag"]' ); ?>
            <div class="blog-masonry">
				
                <div class="grid-sizer col-xs-12 col-sm-6 col-md-4"></div>
                <?php 

                while ( have_posts() ) : the_post(); ?>
                    
                    <div class="col-xs-12 col-sm-6 col-md-4 blog-item">
                        <?php get_template_part( 'contents/content', 'masonry' ); ?>
                    </div>

                <?php endwhile; ?>

            </div>
            <div class="pagination">
                <?php the_posts_pagination(); ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>