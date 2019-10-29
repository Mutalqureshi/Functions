<?php
/**
 * Platinum functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Platinum
 */

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
		if( showPackageUser() ) {
			echo '#package_row { display:flex;}';
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




if ( ! function_exists( 'platinum_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function platinum_setup() {
		
		global $fdata;
		
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Platinum, use a find and replace
		 * to change 'platinum' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'platinum', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Main Menu', 'platinum' ),
			'menu-2' => esc_html__( 'Top Links', 'platinum' ),
			'menu-3' => esc_html__( 'Footer Menu', 'platinum' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
		
		
		
		
		
		$logo_dimensions = $fdata['logo_dimensions'];
		$logo_dimensions = preg_replace( '/[^0-9]/', '', $logo_dimensions );
		//echo '<pre>'; print_r($logo_dimensions); exit;
		add_image_size( 'custom-logo-size', $logo_dimensions['width'], $logo_dimensions['height'] ); // get logo image dimension from redux
		
	}
endif;
add_action( 'after_setup_theme', 'platinum_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function platinum_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'platinum_content_width', 640 );
}
add_action( 'after_setup_theme', 'platinum_content_width', 0 );



/**
 * Enqueue scripts and styles.
 */
function platinum_scripts() {
	wp_enqueue_style( 'platinum-style', get_stylesheet_uri() );
	wp_enqueue_style( 'platinum-bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', false, '3.3.7', 'all' );
	wp_enqueue_style( 'platinum-fontawesome', get_template_directory_uri() . '/css/fontawesome.all.min.css', false, '5.2.0', 'all' );
	wp_enqueue_style( 'platinum-custom-css', get_template_directory_uri() . '/css/custom.css', false, time(), 'all' );
	wp_enqueue_style( 'platinum-responsive-css', get_template_directory_uri() . '/css/responsive.css', false, time(), 'all' );
	

	wp_enqueue_script( 'platinum-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );
	wp_enqueue_script( 'platinum-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );
	wp_enqueue_script( 'platinum-custom-js', get_template_directory_uri() . '/js/custom.js', array(), time(), true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'platinum_scripts' );


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';



/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load shortcodes file.
 */
if ( file_exists( get_template_directory() . '/inc/shortcodes.php' ) ) {
	require get_template_directory() . '/inc/shortcodes.php';
}

/**
 * Load sidebar widget file.
 */
if ( file_exists( get_template_directory() . '/inc/sidebars.php' ) ) {
	require get_template_directory() . '/inc/sidebars.php';
}



####################################################
# custom post pagination START
####################################################
if ( file_exists( dirname( __FILE__ ) . '/inc/custom_pagination.php' ) ) {
	require_once( TEMPLATEPATH . '/inc/custom_pagination.php' );
}



####################################################
# custom functions START
####################################################
if ( file_exists( dirname( __FILE__ ) . '/inc/custom_functions.php' ) ) {
	require_once( TEMPLATEPATH . '/inc/custom_functions.php' );
}



























/**
 * Do not allow any subscription to be cancelled, either by the store manager or customer (not a good idea).
 * https://docs.woocommerce.com/document/subscriptions/faq/#section-66
 */
add_filter( 'woocommerce_can_subscription_be_updated_to_cancelled', '__return_false', 100 );







/**
 * Remove the "Change Payment Method" button from the My Subscriptions table.
 *
 * This isn't actually necessary because @see eg_subscription_payment_method_cannot_be_changed()
 * will prevent the button being displayed, however, it is included here as an example of how to
 * remove just the button but allow the change payment method process.
 */
function eg_remove_my_subscriptions_button( $actions, $subscription ) {
	foreach ( $actions as $action_key => $action ) {
		switch ( $action_key ) {
//			case 'change_payment_method':	// Hide "Change Payment Method" button?
//			case 'change_address':		// Hide "Change Address" button?
//			case 'switch':			// Hide "Switch Subscription" button?
//			case 'resubscribe':		// Hide "Resubscribe" button from an expired or cancelled subscription?
//			case 'pay':			// Hide "Pay" button on subscriptions that are "on-hold" as they require payment?
//			case 'reactivate':		// Hide "Reactive" button on subscriptions that are "on-hold"?
			case 'cancel':			// Hide "Cancel" button on subscriptions that are "active" or "on-hold"?
				unset( $actions[ $action_key ] );
				break;
			default: 
				error_log( '-- $action = ' . print_r( $action, true ) );
				break;
		}
	}
	return $actions;
}
add_filter( 'wcs_view_subscription_actions', 'eg_remove_my_subscriptions_button', 100, 2 );






/*
add custom notice on subscription detail page
*/
add_action( 'woocommerce_subscription_after_actions', 'subscription_cancel_notice' , 9);
function subscription_cancel_notice() {
	global $fdata;
	echo '<tfoot>
		<td colspan="5">'.$fdata['subscription_cancel_notice-content'].'</td>
	</tfoot>';
}