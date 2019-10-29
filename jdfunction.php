<?php

/*-----------------------------------------------------------------------------------

	Here we have all the custom functions for the theme
	Please be extremely cautious editing this file.
	You have been warned!

-------------------------------------------------------------------------------------*/
// Define Theme Name for localization
define('THB_THEME_ROOT', get_template_directory_uri());
define('THB_THEME_ROOT_ABS', get_template_directory());

// Option-Tree Theme Mode
add_filter( 'ot_show_pages', '__return_false' );
add_filter( 'ot_show_new_layout', '__return_false' );
add_filter( 'ot_theme_mode', '__return_true' );
add_filter( 'ot_override_forced_textarea_simple', '__return_true' );
add_filter( 'ot_google_fonts_api_key', function() { return 'AIzaSyA_sfIukXUl1YF8tpjXNGOvpYKNDnFKwFM'; } );
require get_template_directory() .'/inc/ot-radioimages.php';
require get_template_directory() .'/inc/ot-metaboxes.php';
require get_template_directory() .'/inc/ot-themeoptions.php';
require get_template_directory() .'/inc/ot-functions.php';
if ( ! class_exists( 'OT_Loader' ) ) {
	require get_template_directory() .'/admin/ot-loader.php';
}

// TGM Plugin Activation Class
if ( is_admin() ) {
	require get_template_directory() .'/inc/class-tgm-plugin-activation.php';
	require get_template_directory() .'/inc/plugins.php';
}

// Misc
require get_template_directory() .'/inc/misc.php';

// Script Calls
require get_template_directory() .'/inc/script-calls.php';

// CSS Output of Theme Options
require get_template_directory() .'/inc/selection.php';

// Add Menu Support
require get_template_directory() .'/inc/wp3menu.php';

// Enable Sidebars
require get_template_directory() .'/inc/sidebar.php';

// Ajax
require get_template_directory() .'/inc/ajax.php';

// Portfolio Related
require get_template_directory() .'/inc/portfolio-related.php';

// Visual Composer Integration
require get_template_directory() .'/inc/visualcomposer.php';

// Twitter oAuth
require get_template_directory() .'/inc/thb-twitter-api.php';
require get_template_directory() .'/inc/thb-twitter-helper.php';

// Widgets
require get_template_directory() .'/inc/widgets.php';

// WPML Support
require get_template_directory() .'/inc/wpml.php';

// WooCommerce Support
require get_template_directory() .'/inc/woocommerce.php';

// WordPress Importer
if ( is_admin() ) {
	require get_template_directory() . '/inc/import.php';
	require get_template_directory() . '/inc/one-click-demo-import/one-click-demo-import.php';
}