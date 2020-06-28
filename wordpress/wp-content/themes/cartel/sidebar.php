<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package cartel
 */
?>

<div class="col-md-4 sidebar-area">

    <?php if ( is_active_sidebar( 'sidebar1' ) ) : ?>

        <?php dynamic_sidebar( 'sidebar1' ); ?>

    <?php endif; ?>

</div>