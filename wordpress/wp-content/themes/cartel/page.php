<?php
/**
 * The template for displaying all single page.
 *
 *
 * @package cartel
 */

get_header(); ?>

    <div class="page-title-area">
        <div class="container">
            <?php $thumb_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_id() ) ); 
                if( has_post_thumbnail() ): ?>
                    <span class="featured-image" style="<?php if( $thumb_url ) { ?> background-image: url( <?php echo esc_url( $thumb_url ); ?> ); <?php } ?>"></span>
            <?php endif; ?>  
            <h1 class="page-title"><?php the_title(); ?></h1>
        </div>      
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <?php
                while ( have_posts() ) : the_post();

                get_template_part( 'contents/content', 'page' );

                endwhile; // End of the loop.
                ?> 
                <span class="clearfix"></span> 
            </div>

            <?php get_sidebar(); ?>

            <span class="clearfix"></span>
        </div>
    </div>
   
<?php get_footer(); ?>