<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}
    $efav_before = "";
    echo "<div class='efav-span'>";
    if (!empty($user)) {
        if (efav_is_user_favlist_public($user)) {
            $efav_before = "$user's Favourite Posts.";
        } else {
            $efav_before = "$user's list is not public.";
        }
    }

    if ($efav_before):
        echo '<div class="efav-page-before">'.$efav_before.'</div>';
    endif;
    if(isset($efav_post_ids) && $efav_post_ids != "")
    {
        if(is_string($efav_post_ids)){
                $efav_post_ids=json_decode($efav_post_ids,true);
        }
        if (!empty($efav_post_ids)) {
            $efav_post_ids = array_reverse($efav_post_ids);
            $efav_post_per_page = efav_get_option("efav_post_per_page");
            $efav_page = intval(get_query_var('paged'));
            $posts_in_db = get_option('efav_multi_posts_options');
            $posts_in_db[] = "post";
            $efav_qry = array('post_type' => $posts_in_db,'post__in' => $efav_post_ids, 'posts_per_page'=> $efav_post_per_page, 'orderby' => 'post__in', 'paged' => $efav_page);
            $efav_qry_res = query_posts($efav_qry);
             echo "<ul>";
            while ( have_posts() ) : the_post();
                echo "<li><a href='".get_permalink()."' title='". get_the_title() ."'>" . get_the_title() . "</a> ";
                efav_remove_favourite_link(get_the_ID());
                echo "</li>";
            endwhile;
            echo "</ul>";
            echo '<div class="navigation">';
                if(function_exists('wp_pagenavi')) { wp_pagenavi(); } else { ?>
                <div class="alignleft"><?php next_posts_link( __( '&larr; Previous Entries', 'buddypress' ) ) ?></div>
                <div class="alignright"><?php previous_posts_link( __( 'Next Entries &rarr;', 'buddypress' ) ) ?></div>
                <?php }
            echo '</div>';

            wp_reset_query();
        } 
        else 
        {
            $efav_options = efav_get_options();
            echo "<ul><li>";
            echo $efav_options['efav_favourites_empty'];
            echo "</li></ul>";
        }
    } 
    else 
    {
        $efav_options = efav_get_options();
        echo "<ul><li>";
        echo $efav_options['efav_favourites_empty'];
        echo "</li></ul>";
    }
        echo '<p>'.efav_clear_list_link().'</p>';
    echo "</div>";
    efav_cookie_warning();
