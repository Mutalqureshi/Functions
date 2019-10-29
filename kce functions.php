<?php 
	require_once get_template_directory() .'/inc/posttype.php';
	require_once get_template_directory() .'/inc/widgets.php';
	function header_scripts(){
	wp_enqueue_style( 'kce-style', get_stylesheet_uri() );
// main style 
	wp_enqueue_style( 'kce-bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', false, '4', 'all' );
	wp_enqueue_style( 'kce-fontawesome', get_template_directory_uri() . '/css/all.min.css', false, '5.2.0', 'all' );
	// wp_enqueue_style( 'kce-mediaquery', get_template_directory_uri() . '/css/mediaquery.css', false, '5.2.0', 'all' );
	wp_enqueue_style( 'kce-slider', get_template_directory_uri() . '/css/slick.css', false, '5.2.0', 'all' );
	wp_enqueue_style( 'kce-theme', get_template_directory_uri() . '/css/slick-theme.css', false, '5.2.0', 'all' );
	wp_enqueue_style( 'kce-fonts', get_template_directory_uri() . '/css/fonts.css', false, '5.2.0', 'all' );
	wp_enqueue_style( 'kce-custom', get_template_directory_uri() . '/css/custom.css', false, '5.2.0', 'all' );
// style end script start
	wp_enqueue_script( 'kce-bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array(), time(), true );
	wp_enqueue_script( 'kce-slick-js', get_template_directory_uri() . '/js/slick.js', array(), time(), true );
	wp_enqueue_script( 'kce-custom-js', get_template_directory_uri() . '/js/custom.js', array(), time(), true );
	
	

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
	add_action( 'wp_enqueue_scripts', 'header_scripts');
// header scrip all 

	//--------//
/**
 * Load redux file.
 */// header scrip all --enc
if ( file_exists( get_template_directory() . '/inc/admin-folder/admin-init.php' ) ) {
	require get_template_directory() . '/inc/admin-folder/admin-init.php';

	function infloway_customize_css() {
		global $fdata;
		echo '<style type="text/css">';
		if(isset($fdata['opt-ace-editor-css'])) {
			echo $fdata['opt-ace-editor-css'];
		}
		echo '</style>';
	}
	add_action( 'wp_head', 'infloway_customize_css', 100);
	
	function infloway_customize_js() {
		global $fdata;
		if(isset($fdata['opt-ace-editor-js'])) {
			echo '<script>
			'.$fdata['opt-ace-editor-js'].'
			</script>
			';
		}
	}
	add_action( 'wp_footer', 'infloway_customize_js', 100);
}


	function kce(){
		register_nav_menus( array(
		'menu-1' => esc_html__( 'Main Menu', 'kce' ),
		'menu-2' => esc_html__( 'Sec Menu', 'kce' ),
		) );

		// menu
		add_theme_support( 'post-thumbnails' );
		// image

		add_theme_support( 'customize-selective-refresh-widgets' );
		// theme support
		// $logo_dimensions = $fdata['logo_dimensions'];
		// $logo_dimensions = preg_replace( '/[^0-9]/', '', $logo_dimensions);
		// add_image_size( 'custom-logo-size', $logo_dimensions['width'], $logo_dimensions['height'] );
	}
	add_action('after_setup_theme', 'kce');

// pagination checking
// Numbered Pagination

####################################################
# vcf
####################################################
function be_enable_vcard_upload( $mime_types ){
	$mime_types['vcf'] = 'text/x-vcard';
	return $mime_types;
}
add_filter('upload_mimes', 'be_enable_vcard_upload' );

####################################################
# custom-pagination
####################################################

function phone_num(){
    global $fdata;
          $html='';
            if($fdata['phone']){
                    $html = $fdata['phone'];
                }
    return $html;
}
add_shortcode("phone","phone_num");

function email_txt(){
    global $fdata;
          $html='';
            if($fdata['email']){
            $html = $fdata['email'];
        }
    return $html;
}
add_shortcode("email" ,"email_txt");
####################################################
	





	function wpbeginner_numeric_posts_nav() {

 

    if( is_singular() )

        return;

 

    global $wp_query;

 

    /** Stop execution if there's only 1 page */

    if( $wp_query->max_num_pages <= 1 )

        return;

 

    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;

    $max   = intval( $wp_query->max_num_pages );

 

    /** Add current page to the array */

    if ( $paged >= 1 )

        $links[] = $paged;

 

    /** Add the pages around the current page to the array */

    if ( $paged >= 3 ) {

        $links[] = $paged - 1;

        $links[] = $paged - 2;

    }

 

    if ( ( $paged + 2 ) <= $max ) {

        $links[] = $paged + 2;

        $links[] = $paged + 1;

    }

 

    echo '<div class="navigation black-temp"><ul>' . "\n";

 

    /** Previous Post Link */

    if ( get_previous_posts_link() )

        printf( '<li class="prev">%s</li>' . "\n", get_previous_posts_link('<i class="fa fa-angle-left" aria-hidden="true"></i>','') );

 

    /** Link to first page, plus ellipses if necessary */

    if ( ! in_array( 1, $links ) ) {

        $class = 1 == $paged ? ' class="active"' : '';

 

        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

 

        if ( ! in_array( 2, $links ) )

            echo '<li>…</li>';

    }

 

    /** Link to current page, plus 2 pages in either direction if necessary */

    sort( $links );

    foreach ( (array) $links as $link ) {

        $class = $paged == $link ? ' class="active"' : '';

        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );

    }

 

    /** Link to last page, plus ellipses if necessary */

    if ( ! in_array( $max, $links ) ) {

        if ( ! in_array( $max - 1, $links ) )

            echo '<li>…</li>' . "\n";

 

        $class = $paged == $max ? ' class="active"' : '';

        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );

    }

 

    /** Next Post Link */

    if ( get_next_posts_link() )

        printf( '<li class="next">%s</li>' . "\n", get_next_posts_link('<i class="fa fa-angle-right" aria-hidden="true"></i>','') );

 

    echo '</ul></div>' . "\n";

 

}


