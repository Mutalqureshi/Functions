<?php 
	require_once get_template_directory() . '/inc/widgets.php';

	function header_scripts(){
	wp_enqueue_style( 'magicofjimpasse', get_stylesheet_uri() );
	// main style 
	wp_enqueue_style( 'magicofjimpasse-bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', false, '4', 'all' );
	wp_enqueue_style( 'magicofjimpasse-fontawesome', get_template_directory_uri() . '/css/all.min.css', false, '5.2.0', 'all' );
	wp_enqueue_style( 'magicofjimpasse-mediaquery', get_template_directory_uri() . '/css/mediaquery.css', false, '5.2.0', 'all' );
	// style end script start
	wp_enqueue_script( 'magicofjimpasse-bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array(), time(), true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
	add_action('wp_enqueue_scripts', 'header_scripts');
// header scrip all --enc
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


	function magic_of(){
		register_nav_menus( array(
		'menu-1' => esc_html__( 'Main Menu', 'ladona' ),
		) );
		// menu
		add_theme_support( 'post-thumbnails' );
		// image

		add_theme_support( 'customize-selective-refresh-widgets' );
		// theme support

		$logo_dimensions = $fdata['logo_dimensions'];

		$logo_dimensions = preg_replace( '/[^0-9]/', '', $logo_dimensions);

		// add_image_size( 'custom-logo-size', $logo_dimensions['width'], $logo_dimensions['height'] );
	}
	add_action('after_setup_theme', 'magic_of');

