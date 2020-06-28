<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package cartel
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="page-title-area">
        <?php 
        if( has_post_thumbnail() ): ?>
        <a href="<?php the_permalink(); ?>" class="featured-img"><?php the_post_thumbnail('full'); ?></a>
        <?php endif; ?>
        <?php if ( is_single() ) :
        the_title( '<h1 class="entry-title">', '</h1>' );
        else :
        the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
        endif; ?>

    </div>
    <div class="entry-meta">
        <?php cartel_entry_meta(); ?>
    </div>
</article><!-- #post-## -->