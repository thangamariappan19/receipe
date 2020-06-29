<?php
/**
 * Template Name: Homepage
 *
 *
 * @package cartel
 */

get_header(); ?>

    <div id="masonry">
    <?php 
     /**
     * Functions hooked in to cartel_home_banner action.
     *
     * @hooked cartel_template_blog
     */
    do_action('cartel_home_blog'); ?>
    <div class="blog-sticky">
     <div class="container">
        <div class="row">
                <?php
                
                    $clear = 0;
                    $sticky = get_option( 'sticky_posts' );
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    if(count($sticky) > 0 && 1 == $paged) {
                        $query_sticky = new WP_Query( array( 'post__in' => $sticky, 'ignore_sticky_posts' => 1 ) );
                        while ( $query_sticky->have_posts() ) : $query_sticky->the_post();  ?>

                            <div class="blog-item sticky">
                                <?php get_template_part( 'contents/content', 'sticky' ); ?>
                            </div>
                        
                        <?php endwhile; wp_reset_postdata(); 
                    }else{
                        $query_one = new WP_Query( array( 'post__not_in' => $sticky, 'posts_per_page' => 1 ,'ignore_sticky_posts' => 1 ) );
                        while ( $query_one->have_posts() ) : $query_one->the_post();  ?>

                            <div class="blog-item sticky">
                                <?php get_template_part( 'contents/content', 'sticky' ); ?>
                            </div>
                        
                        <?php endwhile; wp_reset_postdata(); 
                    }
                ?>
            </div>
        </div>
    </div>
    <?php if ( is_active_sidebar( 'home-widget' ) ) : ?>
    <div class="container home-widget-area">
        <?php dynamic_sidebar( 'home-widget' ); ?> 
    </div>
    <?php endif; ?>
     <div class="container">
        <div class="row">
                <?php
                $query = new WP_Query( array( 'post__not_in' => $sticky, 'ignore_sticky_posts' => 1 ,'paged' => $paged) ); ?>
                    <div class="blog-masonry">
                        <div class="grid-sizer col-xs-12 col-sm-6 col-md-4"></div>
                        <?php 

                        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                        
                        while ( $query->have_posts() ) : $query->the_post(); ?>
                            
                            <div class="col-xs-12 col-sm-6 col-md-4 blog-item">
                                <?php get_template_part( 'contents/content', 'masonry' ); ?>
                            </div>

                        <?php 

                        endwhile;
                        
                        wp_reset_postdata();

                        ?>

                    </div>
                    <div class="pagination">
                        <?php the_posts_pagination(); ?>
                    </div>
                    <?php
             ?>
    
        </div>
    </div>
</div>

<?php get_footer(); ?>