<?php 
	require_once get_template_directory() .'/inc/allwidgets.php';
	
	function header_scripts(){
	wp_enqueue_style( 'ladona-style', get_stylesheet_uri() );
// main style 
	wp_enqueue_style( 'ladona-bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', false, '4', 'all' );
	wp_enqueue_style( 'ladona-fontawesome', get_template_directory_uri() . '/css/all.min.css', false, '5.2.0', 'all' );
// style end script start
	wp_enqueue_script( 'ladona-custom-js', get_template_directory_uri() . '/js/custom.js', array(), time(), true );
	wp_enqueue_script( 'ladona-bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array(), time(), true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
	add_action( 'wp_enqueue_scripts', 'header_scripts');

	//--------//
/**
 * Load redux file.
 */
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

// theme setup
	function ladona_group() {
		global $fdata;
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Main Menu', 'ladona' ),
			'menu-2' => esc_html__( 'Privacy Policy', 'ladona' ),
			'menu-3' => esc_html__( 'Footer Menu', 'ladona' ),
		) );

		
		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
		
		
		$logo_dimensions = $fdata['logo_dimensions'];
		$logo_dimensions = preg_replace( '/[^0-9]/', '', $logo_dimensions );
		//echo '<pre>'; print_r($logo_dimensions); exit;
		add_image_size( 'custom-logo-size', $logo_dimensions['width'], $logo_dimensions['height'] ); // get logo image dimension from redux
		
	}
add_action( 'after_setup_theme', 'ladona_group' );



// theme option


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


// Add Shortcode For Event Date



