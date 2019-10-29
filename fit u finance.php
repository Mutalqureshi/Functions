<?php
// add support for WP 3+ features
add_action('after_setup_theme','emerald_theme_support', 16);
add_filter( 'the_category', 'remove_cat_rel' );
function remove_cat_rel( $text ) {
	$text = str_replace('rel="tag"', "", $text); return $text;
}
/*********************
THEME SUPPORT
*********************/
// Adding WP 3+ Functions & Theme Support
function emerald_theme_support() {

	// wp thumbnails (sizes handled in functions.php)
	add_theme_support('post-thumbnails');

	// default thumb size
	set_post_thumbnail_size(125, 125, true);
	
	// Thumbnail sizes
	add_image_size( 'emerald-thumb-600', 600, 150, true );

	// wp custom background (thx to @bransonwerner for update)
	add_theme_support( 'custom-background',
	    array(
	    'default-image' => '',  // background image default
	    'default-color' => '', // background color default (dont add the #)
	    'wp-head-callback' => '_custom_background_cb',
	    'admin-head-callback' => '',
	    'admin-preview-callback' => ''
	    )
	);
	// rss thingy
	add_theme_support('automatic-feed-links');
	// registering wp3+ menus
	register_nav_menus(
		array(
			'main-nav' => __( 'The Main Menu', 'emeraldtheme' ),   // main nav in header
			'footer-links' => __( 'Footer Links', 'emeraldtheme' ), // secondary nav in footer
			'middle-menu' => __( 'Slider Bottom Menu', 'emeraldtheme' ), // slider bottom menu
		)
	);
} /* end emerald theme support */
/*********************
MENUS & NAVIGATION
*********************/
// the main menu
function emerald_main_nav() {
	// display the wp3 menu if available
    wp_nav_menu(array(
    	'container' => false,                           // remove nav container
    	'container_class' => 'menu clearfix',           // class of container (should you choose to use it)
    	'menu' => __( 'The Main Menu', 'emeraldtheme' ),  // nav name
    	'menu_class' => 'nav top-nav clearfix',         // adding custom nav class
    	'theme_location' => 'main-nav',                 // where it's located in the theme
    	'before' => '',                                 // before the menu
        'after' => '',                                  // after the menu
        'link_before' => '',                            // before each link
        'link_after' => '',                             // after each link
        'depth' => 0,                                   // limit the depth of the nav
    	'fallback_cb' => 'emerald_main_nav_fallback'      // fallback function
	));
} /* end emerald main nav */

// the footer menu (should you choose to use one)
function emerald_footer_links() {
	// display the wp3 menu if available
    wp_nav_menu(array(
    	'container' => '',                              // remove nav container
    	'container_class' => 'footer-links clearfix',   // class of container (should you choose to use it)
    	'menu' => __( 'Footer Links', 'emeraldtheme' ),   // nav name
    	'menu_class' => 'nav footer-nav clearfix',      // adding custom nav class
    	'theme_location' => 'footer-links',             // where it's located in the theme
    	'before' => '',                                 // before the menu
        'after' => '',                                  // after the menu
        'link_before' => '',                            // before each link
        'link_after' => '',                             // after each link
        'depth' => 0,                                   // limit the depth of the nav
    	'fallback_cb' => 'emerald_footer_links_fallback'  // fallback function
	));
} /* end emerald footer link */

// this is the fallback for header menu
function emerald_main_nav_fallback() {
	wp_page_menu( array(
		'show_home' => true,
    	'menu_class' => 'nav top-nav clearfix',      // adding custom nav class
		'include'     => '',
		'exclude'     => '',
		'echo'        => true,
        'link_before' => '',                            // before each link
        'link_after' => ''                             // after each link
	) );
}
// this is the fallback for footer menu
function emerald_footer_links_fallback() {
	/* you can put a default here if you like */
}
/*********************
PAGE NAVI
*********************/
// Numeric Page Navi (built into the theme by default)
function emerald_page_navi($before = '', $after = '') {
	global $wpdb, $wp_query;
	$request = $wp_query->request;
	$posts_per_page = intval(get_query_var('posts_per_page'));
	$paged = intval(get_query_var('paged'));
	$numposts = $wp_query->found_posts;
	$max_page = $wp_query->max_num_pages;
	if ( $numposts <= $posts_per_page ) { return; }
	if(empty($paged) || $paged == 0) {
		$paged = 1;
	}
	$pages_to_show = 7;
	$pages_to_show_minus_1 = $pages_to_show-1;
	$half_page_start = floor($pages_to_show_minus_1/2);
	$half_page_end = ceil($pages_to_show_minus_1/2);
	$start_page = $paged - $half_page_start;
	if($start_page <= 0) {
		$start_page = 1;
	}
	$end_page = $paged + $half_page_end;
	if(($end_page - $start_page) != $pages_to_show_minus_1) {
		$end_page = $start_page + $pages_to_show_minus_1;
	}
	if($end_page > $max_page) {
		$start_page = $max_page - $pages_to_show_minus_1;
		$end_page = $max_page;
	}
	if($start_page <= 0) {
		$start_page = 1;
	}
	echo $before.'<nav class="page-navigation"><ol class="emerald_page_navi clearfix">'."";
	if ($start_page >= 2 && $pages_to_show < $max_page) {
		$first_page_text = __( "First", 'emeraldtheme' );
		echo '<li class="bpn-first-page-link"><a href="'.get_pagenum_link().'" title="'.$first_page_text.'">'.$first_page_text.'</a></li>';
	}
	echo '<li class="bpn-prev-link">';
	previous_posts_link('<<');
	echo '</li>';
	for($i = $start_page; $i  <= $end_page; $i++) {
		if($i == $paged) {
			echo '<li class="bpn-current">'.$i.'</li>';
		} else {
			echo '<li><a href="'.get_pagenum_link($i).'">'.$i.'</a></li>';
		}
	}
	echo '<li class="bpn-next-link">';
	next_posts_link('>>');
	echo '</li>';
	if ($end_page < $max_page) {
		$last_page_text = __( "Last", 'emeraldtheme' );
		echo '<li class="bpn-last-page-link"><a href="'.get_pagenum_link($max_page).'" title="'.$last_page_text.'">'.$last_page_text.'</a></li>';
	}
	echo '</ol></nav>'.$after."";
} /* end page navi */
// cleaning up excerpt
add_filter('excerpt_more', 'emerald_excerpt_more');

// This removes the annoying […] to a Read More link
function emerald_excerpt_more($more) {
	global $post;
	// edit here if you like
return '...  <a class="excerpt-read-more" href="'. get_permalink($post->ID) . '" title="'. __('Read', 'emeraldtheme') . get_the_title($post->ID).'">'. __('Read more &raquo;', 'emeraldtheme') .'</a>';
}
/********************************************************************/
/************* INCLUDE NEEDED FILES ***************/

if ( file_exists( dirname( __FILE__ ) . '/admin/admin-init.php' ) ) {
	require_once( dirname( __FILE__ ) . '/admin/admin-init.php' );
}
//require_once('functions/my-functions.php'); // this comes turned off by default
// Adding excerpt for page
add_post_type_support( 'post', 'excerpt' );

/*------custom-image-sizes----------*/
add_image_size( 'team-image', 370, 310, array( 'center', 'top' ) );
/*------custom-image-sizes----------*/
include('shortcode.php');
/*----------------------custom-post-types------------------------------*/
/*----self-created-post-type-client-logos--------------*/
add_action( 'init', 'create_team_post_type' );
function create_team_post_type() {
  register_post_type( 'teams',
    array(
      'labels' => array(
        'name' => __( 'Team' ),
        'singular_name' => __('team'),
      ),
	  'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
		/* 'taxonomies' => array('category'), */
        /* 'rewrite' => true,  */
	 	'rewrite' => false, 
        'capability_type' => 'post',
        'hierarchical' => true,
        'menu_position' => null,
        'supports' => array('title','thumbnail'),
		'menu_icon'           => get_template_directory_uri() . '/imgs/team.png',
		'menu_position' => 50
    )
  );
}
/*-------*/
register_sidebar( array (
'name' => __( 'Sidebar Widget Area', 'blankslate' ),
'id' => 'primary-widget-area',
'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
'after_widget' => "</div>",
'before_title' => '<h3 class="widget-title"><span>',
'after_title' => '</span></h3>',
) );