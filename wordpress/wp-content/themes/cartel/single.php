<?php
/**
 * The template for displaying all single posts.
 *
 *
 * @package cartel
 */

get_header(); ?>
    
    <?php if( get_theme_mod('cartel_post_template') != 'full' ) { ?>
    <div class="page-title-area">
        <div class="container">
            <?php $thumb_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_id() ) ); 
                if( has_post_thumbnail() ): ?>
                    <span class="featured-image" style="<?php if( $thumb_url ) { ?> background-image: url( <?php echo esc_url( $thumb_url ); ?> ); <?php } ?>"></span>
            <?php endif; ?>  
            <h1 class="page-title"><?php the_title(); ?></h1>
            <div class="entry-meta">
                <?php cartel_entry_meta(); ?>
            </div>
        </div>      
    </div>
    <?php } else { ?>
        <div class="page-title-area post-full">
         <?php $thumb_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_id() ) ); 
            if( has_post_thumbnail() ): ?>
                <span class="featured-image" style="<?php if( $thumb_url ) { ?> background-image: url( <?php echo esc_url( $thumb_url ); ?> ); <?php } ?>"></span>
        <?php endif; ?>  
        <div class="container">
            <h1 class="page-title"><?php the_title(); ?></h1>
            <div class="entry-meta">
                <?php cartel_entry_meta(); ?>
            </div>
        </div>      
    </div>
    <?php } ?>
    
    <?php if( get_theme_mod('cartel_post_template') != 'full' ) { ?>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <?php
                while ( have_posts() ) : the_post();

                get_template_part( 'contents/content', 'single' );

                endwhile; // End of the loop.
                ?> 
                <span class="clearfix"></span> 
            </div>

            <?php get_sidebar(); ?>

            <span class="clearfix"></span>
        </div>
    </div>
    <?php } else{ ?>

    <div class="container post-full">
        <div class="row">
            <div class="col-md-12">
                <?php
                while ( have_posts() ) : the_post();

                get_template_part( 'contents/content', 'single' );

                endwhile; // End of the loop.
                ?> 
                <span class="clearfix"></span> 
            </div>
        </div>
    </div>

    <?php } ?>

<?php get_footer(); ?>