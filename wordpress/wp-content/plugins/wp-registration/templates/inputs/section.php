<?php
/**
** WPR Template to render Section input
**/

    // not run if accessed directly
    if( ! defined("ABSPATH" ) )
        die("Not Allewed");

    $fm = new WPR_InputMeta($field_meta, 'section');
 ?>
    <section class="wpr-section-field">
        <div style="clear: both"></div>
        <header>
            <h2><?php echo $fm->title; ?></h2>
            <p><?php echo $fm->desc; ?></p> 
        </header>
        <div style="clear: both"></div>
    </section>