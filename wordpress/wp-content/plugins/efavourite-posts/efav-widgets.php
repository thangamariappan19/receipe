<?php
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}
function efav_widget_init() {
    function efav_widget_view($efav_args) {
        extract($efav_args);
        $efav_options = efav_get_options();
        if (isset($efav_options['efav_widget_limit'])) {
            $efav_limit = $efav_options['efav_widget_limit'];
        }
        $efav_title = empty($efav_options['efav_widget_title']) ? 'Most Favourited Posts' : $efav_options['efav_widget_title'];
        echo $efav_before_widget;
        echo $efav_before_title . $efav_title . $efav_after_title;
        efav_list_most_favourited($efav_limit);
        echo $efav_after_widget;
    }

    function efav_widget_control() {
        $efav_options = efav_get_options();
        if (isset($_POST["efav-widget-submit"])):
            $efav_options['efav_widget_title'] = sanitize_text_field($_POST['efav-title']);
            $efav_options['efav_widget_limit'] = intval($_POST['efav-limit']);
            update_option("efav_options", $efav_options);
        endif;
        $efav_title = $efav_options['efav_widget_title'];
        $efav_limit = $efav_options['efav_widget_limit'];
    ?>
        <p>
            <label for="efav-title">
                <?php _e('Title:'); ?> <input type="text" value="<?php echo $efav_title; ?>" class="widefat" id="efav-title" name="efav-title" />
            </label>
        </p>
        <p>
            <label for="efav-limit">
                <?php _e('Number of posts to show:'); ?> <input type="text" value="<?php echo $efav_limit; ?>" style="width: 28px; text-align:center;" id="efav-limit" name="efav-limit" />
            </label>
        </p>
        <?php if (!$efav_options['efav_statistics']) { ?>
        <p>
            You must enable statistics from favourite posts <a href="plugins.php?page=efavourite-posts" title="favourite Posts Configuration">configuration page</a>.
        </p>
        <?php } ?>
        <input type="hidden" name="efav-widget-submit" value="1" />
    <?php
    }
    wp_register_sidebar_widget('efav-most_favourited_posts', 'Most Favourited Posts', 'efav_widget_view');
    wp_register_widget_control('efav-most_favourited_posts', 'Most favourited Posts', 'efav_widget_control' );

    //*** users favourites widget ***//
    function efav_users_favourites_widget_view($efav_args) {
        extract($efav_args);
        $efav_options = efav_get_options();
        if (isset($efav_options['efav_uf_widget_limit'])) {
            $efav_limit = $efav_options['efav_uf_widget_limit'];
        }
        $efav_title = empty($efav_options['efav_uf_widget_title']) ? 'Users favourites' : $efav_options['efav_uf_widget_title'];
        echo $efav_before_widget;
        echo $efav_before_title
             . $efav_title
             . $efav_after_title;
        $efav_post_ids = efav_get_users_favourites();

		$efav_limit = $efav_options['efav_uf_widget_limit'];
        if (@file_exists(TEMPLATEPATH.'/efav-your-favs-widget.php')):
            include(TEMPLATEPATH.'/efav-your-favs-widget.php');
        else:
            include("efav-your-favs-widget.php");
        endif;
        echo $efav_after_widget;
    }

    function efav_users_favourites_widget_control() {
        $efav_options = efav_get_options();
        if (isset($_POST["efav-uf-widget-submit"])):
            $efav_options['efav_uf_widget_title'] = sanitize_text_field($_POST['efav-uf-title']);
            $efav_options['efav_uf_widget_limit'] = intval($_POST['efav-uf-limit']);
            update_option("efav_options", $efav_options);
        endif;
        $efav_uf_title = $efav_options['efav_uf_widget_title'];
        $efav_uf_limit = $efav_options['efav_uf_widget_limit'];
    ?>
        <p>
            <label for="efav-uf-title">
                <?php _e('Title:'); ?> <input type="text" value="<?php echo $efav_uf_title; ?>" class="widefat" id="efav-uf-title" name="efav-uf-title" />
            </label>
        </p>
        <p>
            <label for="efav-uf-limit">
                <?php _e('Number of posts to show:'); ?> <input type="text" value="<?php echo $efav_uf_limit; ?>" style="width: 28px; text-align:center;" id="efav-uf-limit" name="efav-uf-limit" />
            </label>
        </p>

        <input type="hidden" name="efav-uf-widget-submit" value="1" />
    <?php
    }
    wp_register_sidebar_widget('efav-users_favourites','User\'s favourites', 'efav_users_favourites_widget_view');
    wp_register_widget_control('efav-users_favourites','User\'s Favourites', 'efav_users_favourites_widget_control' );
}
add_action('widgets_init', 'efav_widget_init');
