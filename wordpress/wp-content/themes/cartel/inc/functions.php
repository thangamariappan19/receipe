<?php 

/**
 * theme main functions
 *
 * @package cartel
 */

/**
 * load template hooks
 */
require get_template_directory() . '/inc/template-hooks.php';

/**
 * load bootstrap navwalker
 */
if ( ! class_exists( 'wp_bootstrap_navwalker' )) {
  require get_template_directory() . '/assets/wp_bootstrap_navwalker.php'; /* Theme wp_bootstrap_navwalker display */
}
/**
 * customizer
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Theme setup
 */
add_action( 'after_setup_theme', 'cartel_theme_setup' );
function cartel_theme_setup() {

    load_theme_textdomain( 'cartel', get_template_directory() . '/inc/translation' );

    add_action( 'wp_enqueue_scripts', 'cartel_scripts_and_styles', 999 );

    add_action( 'widgets_init', 'cartel_register_sidebars' );

    cartel_theme_support();

    global $content_width;
    if ( ! isset( $content_width ) ) {
    $content_width = 640;
    }

    // Thumbnail sizes
    add_image_size( 'cartel-600', 600, 600, true );
    add_image_size( 'cartel-300', 300, 300, true );

} 

/**
 * register sidebar
 */
function cartel_register_sidebars() {

  register_sidebar(array(
    'id' => 'sidebar1',
    'name' => __( 'Posts Widget Area', 'cartel' ),
    'description' => __( 'The Posts Widget Area.', 'cartel' ),
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h3 class="widgettitle">',
    'after_title' => '</h3>',
  ));

  register_sidebar(array(
    'id' => 'home-widget',
    'name' => __( 'Home Widget Area', 'cartel' ),
    'description' => __( 'The Home Widget Area.', 'cartel' ),
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget' => '</aside>',
    'before_title' => '<h3 class="widgettitle">',
    'after_title' => '</h3>',
  ));

}

/**
 * enqueue scripts and styles
 */
function cartel_scripts_and_styles() {

    global $wp_styles; 

    wp_enqueue_script( 'jquery-modernizr', get_template_directory_uri() . '/assets/js/modernizr.custom.min.js', array('jquery'), '2.5.3', false );
    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), '', true );
    wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/fonts/font-awesome.min.css', array(), '', 'all' );
    wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), '', 'all' );
    wp_enqueue_style( 'cartel-main-stylesheet', get_template_directory_uri() . '/assets/css/style.css', array(), '', 'all' );
    if ( is_home() || is_front_page() || is_archive() || is_search() || is_page_template('template-homepage.php')) :
      wp_enqueue_script( 'jquery-masonry' );
      wp_enqueue_script( 'imagesloaded' );

      // Register the script
      wp_register_script( 'cartel-jquery-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '', true );

      // Localize the script with new data
      $translation_array = array(
        'more_text' => __( 'Load more posts', 'cartel' ),
        'nomore_text' => __( 'There are no more posts.', 'cartel' ),
      );
      wp_localize_script( 'cartel-jquery-main', 'more_posts', $translation_array );
      wp_enqueue_script( 'cartel-jquery-main' );

    endif;

    wp_enqueue_script( 'cartel-jquery-menu', get_template_directory_uri() . '/assets/js/menu.js', array('jquery'), '', true );

    if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
      wp_enqueue_script( 'comment-reply' );
    }

}

/**
 * theme support
 */
function cartel_theme_support() {

    add_theme_support( 'post-thumbnails' );

    set_post_thumbnail_size( 600, 600 );

    add_theme_support( 'custom-background',
    array(
    'default-image' => '',    // background image default
    'default-color' => 'ffffff',    // background color default (dont add the #)
    'wp-head-callback' => '_custom_background_cb',
    'admin-head-callback' => '',
    'admin-preview-callback' => ''
    )
    );

    add_theme_support('automatic-feed-links');

    add_theme_support( 'title-tag' );

    add_theme_support( 'custom-logo' );

    register_nav_menus(
    array(
    'main-nav' => __( 'Main Nav', 'cartel' ),
    'footer-nav' => __( 'Footer Nav', 'cartel' ),
    )
    );
  
}

function cartel_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'cartel_content_width', 840 );
}
add_action( 'after_setup_theme', 'cartel_content_width', 0 );

/**
 * Comment layout
 */
function cartel_comments( $comment, $args, $depth ) { ?>
  <div id="comment-<?php comment_ID(); ?>" <?php comment_class('comments'); ?>>

      <header class="comment-author vcard">
        <?php echo get_avatar( $comment,60 ); ?>
      </header>
      <?php if ($comment->comment_approved == '0') : ?>
        <div class="alert alert-info">
          <p><?php esc_html_e( 'Your comment is awaiting moderation.', 'cartel' ) ?></p>
        </div>
      <?php endif; ?>
      <section class="comment_content cf">
        <?php printf(__( '<cite class="fn">%1$s</cite> %2$s', 'cartel' ), get_comment_author_link(), edit_comment_link(__( '(Edit)', 'cartel' ),'  ','') ) ?>
        <a href="<?php comment_link(); ?>"><time datetime="<?php echo comment_time(get_option( 'date_format' )); ?>"><?php comment_date(); ?></time></a>
        <?php comment_text() ?>
        <p class="reply-link"><?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></p>
      </section>
<?php
} // don't remove this bracket!

/**
 * reoder comment form fields
 */
function cartel_move_comment_field_to_bottom( $fields ) {
  $comment_field = $fields['comment'];
  unset( $fields['comment'] );
  $fields['comment'] = $comment_field;
  return $fields;
}

add_filter( 'comment_form_fields', 'cartel_move_comment_field_to_bottom' );

/**
 * wp_nav_menu Fallback
 */
function cartel_primary_menu_fallback() {
    ?>

    <ul id="menu-main-menu" class="nav navbar-nav navbar-right">
        <?php
        wp_list_pages(array(
            'depth'        => 1,
            'exclude' => '', //comma seperated IDs of pages you want to exclude
            'title_li' => '', //must override it to empty string so that it does not break our nav
            'sort_column' => 'post_title', //see documentation for other possibilites
            'sort_order' => 'ASC', //ASCending or DESCending
        ));
        ?>
    </ul>

    <?php
}

add_filter('excerpt_more', 'cartel_new_excerpt_more');
function cartel_new_excerpt_more($more) {
  if ( is_admin() ) {
     return $more;
  }
  global $post;
  return '<a class="moretag" href="'. esc_url( get_permalink($post->ID) ) . '">' . __('Read more','cartel') . '</a>';
}
add_filter('excerpt_more', 'cartel_new_excerpt_more');