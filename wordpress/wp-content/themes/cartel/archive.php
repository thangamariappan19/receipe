<?php
/**
 * The template for displaying archive pages.
 *
 * @package cartel
 */

get_header(); ?>

    <div class="page-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="page-title"><?php the_archive_title(); ?></h1>
                </div>
                <?php if(function_exists('bcn_display')){ ?>
                    <div class="col-md-6 breadcrumbs">
                        <?php bcn_display(); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
 
    <div id="masonry">
        <div class="container">
            <div class="row">
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
                <?php
                ?>
            </div>
        </div>
    </div>

<?php get_footer(); ?>