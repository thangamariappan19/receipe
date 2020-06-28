<?php 

/**
 * theme template hooks
 *
 * @package cartel
 */

/**
 * Meta Tags
 */
function cartel_entry_meta(){

    $byline = sprintf(

        esc_html( '%s', 'cartel' ),
        '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_the_author() . '</a></span>'
    );

    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
    if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
        $time_string = '<time class="updated" datetime="%3$s">%4$s</time>';
    }

    $time_string = sprintf( $time_string,
        get_the_date( DATE_W3C ),
        get_the_date(),
        get_the_modified_date( DATE_W3C ),
        get_the_modified_date()
    );

    $get_category_list = get_the_category_list( __( ', ', 'cartel' ) );
    $cat_list = sprintf( esc_html('%s', 'cartel'),
    $get_category_list
    );

    echo '<span class="posted-on">' . $time_string . '</span><span class="cat-list">'. $cat_list .'</span>';
}


add_action( 'cartel_entry_footer', 'cartel_post_cat', 10 );
add_action( 'cartel_entry_footer', 'cartel_next_prev_post', 15 );
add_action( 'cartel_entry_footer', 'cartel_author_bio', 20 );

function cartel_post_cat(){ 

    $get_category_list = get_the_category_list( __( ', ', 'cartel' ) );
    $cat_list = sprintf( esc_html('%s', 'cartel'),
    $get_category_list
    );

    ?>
    <div class="cat-tag-links">
        <?php if(has_tag()): ?>
        <p><i class="fa fa-tag" aria-hidden="true"></i><?php echo ' ' . get_the_tag_list('','',''); ?></p>
        <?php endif; ?>
    </div>
    <?php
}

function cartel_author_bio(){ ?>
    <div class="author-info">
      <div class="avatar">
        <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo get_avatar( get_the_author_meta( 'ID' ) , 100 ); ?></a>
      </div>
      <div class="info">
          <p class="author-name"><span><?php _e('Published By ','cartel'); ?></span><br><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php the_author(); ?></a></p>
          <?php echo get_the_author_meta('description'); ?>
      </div>
      <span class="clearfix"></span>
    </div> 
    <?php
}

function cartel_next_prev_post(){
    ?>
        <div class="next-prev-post">
            <div class="prev col-xs-6">
                <span><?php esc_html_e('Previous','cartel'); ?></span><br>
                <?php previous_post_link('&larr; %link'); ?>
            </div>
            <div class="next col-xs-6">
                <span><?php esc_html_e('Next','cartel'); ?></span><br>
                <?php next_post_link('%link &rarr;'); ?>
            </div>
            <span class="clearfix"></span>
        </div>
    <?php
}

/**
 * site header
 */
add_action( 'cartel_header', 'cartel_template_header' );
function cartel_template_header(){ ?>
    <header id="site-header">
        <div class="container">
            <nav class="navbar navbar-default" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">

                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-navigation">
                    <span class="sr-only"><?php _e( 'Toggle navigation','cartel' ); ?></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>

                    <?php if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ): 
                    $cartel_custom_logo_id = get_theme_mod( 'custom_logo' );
                    $image = wp_get_attachment_image_src( $cartel_custom_logo_id,'full');
                    ?>
                    <h1 id="logo"><a href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'><img src="<?php echo esc_url( $image[0] ); ?>"></a></h1>
                    <?php else : ?>
                    <h1 id="logo"><a href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'><?php echo esc_html( bloginfo('name') ); ?></a></h1>
                    <?php endif; ?>

                </div>

                <div class="collapse navbar-collapse" id="main-navigation">
                    <?php 
                    if ( has_nav_menu( 'main-nav' ) ) {
                    wp_nav_menu( array(
                    'theme_location'    => 'main-nav',
                    'depth'             => 5,
                    'container'         => 'false',
                    'container_class'   => 'collapse navbar-collapse',
                    'container_id'      => 'bs-navbar-collapse-1',
                    'menu_class'        => 'nav navbar-nav navbar-right',
                    'fallback_cb'       => 'cartel_primary_menu_fallback',
                    'walker'            => new wp_bootstrap_navwalker())
                    );
                    }
                    ?>
                </div><!-- /.navbar-collapse -->
            </nav>


        </div>
    </header>
<?php
}


/**
 * Footer Hooks
 */
add_action( 'cartel_footer', 'cartel_template_copyright', 10 );


function cartel_template_copyright(){ ?>
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <?php if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ): 
                $cartel_custom_logo_id = get_theme_mod( 'custom_logo' );
                $image = wp_get_attachment_image_src( $cartel_custom_logo_id,'full');
                ?>
                <h1 id="logo"><a href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'><img src="<?php echo esc_url( $image[0] ); ?>"></a></h1>
                <?php else : ?>
                <h1 id="logo"><a href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'><?php echo esc_html( bloginfo('name') ); ?></a></h1>
                <?php endif; ?>
            </div>
            <div class="col-md-6 footer-nav">
                <?php 
                    if ( has_nav_menu( 'footer-nav' ) ) {
                    wp_nav_menu( array(
                    'theme_location'    => 'footer-nav',
                    'depth'             => 1,
                    'container'         => 'false',
                    'menu_class'        => 'nav navbar-nav',
                    'fallback_cb'       => 'cartel_primary_menu_fallback',
                    'walker'            => new wp_bootstrap_navwalker())
                    );
                    }
                    ?>
            </div>
            <div class="col-md-4 footer-copyright">
                <?php echo bloginfo( 'name' ) . ' ' . '&#169; ' . __('copyright','cartel') . ' ' . date_i18n('Y');  ?>
                <span><?php if(is_home() || is_front_page()): ?>
                    <br><?php esc_html_e('Built with','cartel'); ?> <a href="<?php echo esc_url( __( 'https://wpdevshed.com/themes/cartel', 'cartel' ) ); ?>"><?php printf( esc_html( '%s', 'cartel' ), 'Cartel' ); ?></a>     <span><?php _e('and','cartel'); ?></span> <a href="<?php echo esc_url( __( 'https://wordpress.org/', 'cartel' ) ); ?>"><?php printf( esc_html( '%s', 'cartel' ), 'WordPress' ); ?></a>
                <?php endif; ?>
                </span>
            </div>
        </div>
    </div>
<?php
}