<?php 
add_theme_support('post_thumbnails');


// header script

    function header_scripts(){

          // wp_dequeue_style('vc_shortcodes-custom'); // from parent theme
          // wp_deregister_style('vc_shortcodes-custom'); 


        wp_enqueue_style( 'arboursdentistry-style', get_stylesheet_uri() );
    // main style 
        wp_enqueue_style( 'arboursdentistry-bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css');
        wp_enqueue_style( 'arboursdentistry-fontawesome', get_template_directory_uri() . '/css/font-awesome-all.min.css' );
        // wp_enqueue_style( 'arboursdentistry-mediaquery', get_template_directory_uri() . '/css/mediaquery.css' );
        wp_enqueue_style( 'arboursdentistry-slider', get_template_directory_uri() . '/css/slick.css' );
        wp_enqueue_style( 'arboursdentistry-theme', get_template_directory_uri() . '/css/slick-theme.css' );
        wp_enqueue_style( 'arboursdentistry-fonts', get_template_directory_uri() . '/css/fonts.css' );
        wp_enqueue_style( 'arboursdentistry-responsive', get_template_directory_uri() . '/css/rwd.css' ,false, time() , 'all');
        wp_enqueue_style( 'arboursdentistry-custom', get_template_directory_uri() . '/css/theme-style.css', false, time() , 'all' );
    // style end script start
        wp_enqueue_script( 'arboursdentistry-bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js' );
        wp_enqueue_script( 'arboursdentistry-slick-js', get_template_directory_uri() . '/js/slick.js' );
        wp_enqueue_script( 'arboursdentistry-custom-js', get_template_directory_uri() . '/js/custom.js', array(), time(), true );

        // wp_enqueue_script( 'vc_shortcodes-custom');


    
    

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
    add_action( 'wp_enqueue_scripts', 'header_scripts',999);
/*------------theme-setting-options---------------*/
add_action('admin_head', 'my_custom_css');
function my_custom_css() {
    echo '
    <style>
        .rAds {
            display: none !important;
            opacity: 0 !important;
        } 
    </style>
    <script>
        function home_header12() {
            if(jQuery(".rAds").length){
                jQuery(".rAds").remove();
                console.log("removing banner");
            }
        }
        jQuery(document).ready(function(e) {
            if(jQuery("#redux-header").length){
                setTimeout(home_header12, 3000);
            }
        });
    </script>
    ';
}
######################################################################################
//ADD custom logo on wordpress login page
######################################################################################
add_action( 'login_enqueue_scripts', 'my_login_logo' );
function my_login_logo() {
    global $fdata;
    //print_r($fdata['login-logo']);
    $logo_url = ( isset($fdata['login-logo']) ? $fdata['login-logo']['url'] : get_bloginfo('template_url').'/img/silverfox-logo.png' );
    $logo_height = ( isset($fdata['login-logo']) ? $fdata['login-logo']['height'] : '141' );
    ?>
    <style type="text/css">
        body.login {
            background-color:#fafafa;
        }
        body.login div#login h1 a {
            background-image: url(<?php echo $logo_url ?>);
            padding: 0px;
            margin:0 auto 25px;
            width:auto;
            height:<?=$logo_height?>px;
            background-position:center center;
            background-size:contain;
			}
    </style>
	<?php }
function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );
function my_login_logo_url_title() {
    return get_bloginfo('name');//'Your Site Name and Info';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );
######################################################################################
//Redux framework for theme options
######################################################################################
if ( file_exists( get_template_directory() . '/inc/admin-folder/admin-init.php' ) ) {
	require get_template_directory() . '/inc/admin-folder/admin-init.php';
	function infloway_customize_css() {
		global $fdata;
		if(isset($fdata['opt-ace-editor-css'])) {
			echo '<style type="text/css">
			'.$fdata['opt-ace-editor-css'].'
			</style>
			';
		}
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
/*------------theme-setting-options-ended--------------*/
?>
<?php	
/**
 * Filter the excerpt "read more" string.
 *
 * @param string $more "Read more" excerpt string.
 * @return string (Maybe) modified "read more" excerpt string.
 */
function wpdocs_excerpt_more( $more ) {
    return ',';
}
add_filter( 'excerpt_more', 'wpdocs_excerpt_more' );
/*-----menus-with-extra-menu+location---------*/
function wpb_custom_new_menu() {
  register_nav_menus(
    array(
      'top-menu' => __( 'Header Top Menu' ),
	  'main-menu' => __( 'Header Main Menu' ),
	  'copyright-menu' => __( 'Copy Right Menu' ),
    )
  );
}
add_action( 'init', 'wpb_custom_new_menu' );
/*--------menus-with-extra-menu+location-ended--------------*/
/*----jquery-migrate-------*/
add_action( 'wp_default_scripts', function( $scripts ) {
    if ( ! empty( $scripts->registered['jquery'] ) ) {
        $scripts->registered['jquery']->deps = array_diff( $scripts->registered['jquery']->deps, array( 'jquery-migrate' ) );
    }
} );
/*----jquery-migrate-----------*/
/*-----for-getting-alt-image-------------*/	
 function get_image_with_alt($imagefield, $postID, $imagesize = 'full'){
	$imageID = get_field($imagefield, $postID); 
	$image = wp_get_attachment_image_src( $imageID, $imagesize ); 
	$alt_text = get_post_meta($imageID , '_wp_attachment_image_alt', true); 
return '<img src="' . $image[0] . '" alt="' . $alt_text . '" />';
}
/*-----for-gettingalt-image------------*/
/*---custom-images-size---*/
add_action( 'after_setup_theme', 'ja_theme_setup' );
function ja_theme_setup() {
    add_theme_support( 'post-thumbnails');
    add_theme_support( 'title-tag' );
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ) );

        add_theme_support( 'customize-selective-refresh-widgets' );
        
        
        
}
/* in use del all */
add_image_size( 'thumbnail-all-single-blog-post', 999, 450, array( 'center', 'center' ));
/* in use del all */
/*-----in use--*/

add_image_size( 'recent-blog-image', 170, 122, array( 'center', 'center' ) );

/*--gallery-sizes--*/
add_image_size('gallery-square', 452, 452, array( 'center','center') );
/*--gallery-sizes--*/


/*------custom-images-size-------*/
/*------all-about-pages-----------------*/
/*-----assigning.php-page-by-slug-name---------------*/
function get_home($atts) {
    include(WP_CONTENT_DIR . '/themes/waqartheme/home-page.php');
}
/*---short codes of page like [homePage]-----*/
add_shortcode( 'homePage', 'get_home');
/*------all-about-pages-----------------*/
/*----get-the-excerpt----*/
function get_testimonial__excerpt($count){
	$permalink = get_permalink($post->ID);
	$excerpt = get_the_content();
	$excerpt = strip_tags($excerpt);
	$excerpt = substr($excerpt, 0, $count);
	$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
	//$excerpt = $excerpt.' <a href="'.$permalink.'">......</a>';
	return $excerpt;
}
function get_blog__excerpt($count){
	$permalink = get_permalink($post->ID);
	$excerpt = get_the_content();
	$excerpt = strip_tags($excerpt);
	$excerpt = substr($excerpt, 0, $count);
	$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
	$excerpt = $excerpt/*.' <a href="'.$permalink.'">......</a>'*/;
	return $excerpt;
}
/*----get-the-excerpt-ended---*/
/*------Calling image in widget--------------*/
// Enable the use of shortcodes within widgets.
add_filter( 'widget_text', 'do_shortcode' ); 
// Assign the tag for our shortcode and identify the function that will run. 
add_shortcode( 'template_directory_uri', 'wpse61170_template_directory_uri' );
// Define function 
function wpse61170_template_directory_uri() {
    return get_template_directory_uri();
}
/* use like :   [template_directory_uri]/images/image.jpg */
/*-----Calling image in widget-Ended-----*/
/*-----------*/
/*---------*/
/*-----------------------------------------------------------------------------------*/
/* Activate sidebar for Wordpress use
/*-----------------------------------------------------------------------------------*/
function naked_register_sidebars() {
	register_sidebar(array(                    // Start a series of sidebars to register
        'id' => 'blog-sidebar',                     // Make an ID
        'name' => 'Blog Side bar',              // Name it
        'description' => 'Take it on the side...', // Dumb description for the admin side
        'before_widget' => '<div class="blog-sidebar">',    // What to display before each widget
        'after_widget' => '</div>', // What to display following each widget
        'before_title' => '<span class="blog-sidebar">',    // What to display before each widget's title
        'after_title' => '</span>',     
        'empty_title'=> '',                 // What to display in the case of no title defined for a widget
    ));
} 
add_action( 'widgets_init', 'naked_register_sidebars' );
/*-----------------------------------------------------------------------------------*/
/*---------copies-from-old-theme-------------------*/
register_sidebar( array (
'name' => __( 'Sidebar Widget Area', 'blankslate' ),
'id' => 'primary-widget-area',
'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
'after_widget' => "</div>",
'before_title' => '<h3 class="widget-title"><span>',
'after_title' => '</span></h3>',
) );
register_sidebar( array (
'name' => __( 'Footer Bottom Menu col 1', 'blankslate' ),
'id' => 'footer-bottom-menu',
'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
'after_widget' => "</div>",
'before_title' => '<h2 class="widget-title hidden"><span>',
'after_title' => '</span></h2>',
) );
register_sidebar( array (
'name' => __( 'Footer Bottom Menu col 2', 'blankslate' ),
'id' => 'footer-bottom-menu-2',
'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
'after_widget' => "</div>",
'before_title' => '<h2 class="widget-title hidden"><span>',
'after_title' => '</span></h2>',
) );
/*------------------------------------------*/

/*----self-created-post-type-Testimonail---------------------*/
add_action( 'init', 'create_testimonials' );
function create_testimonials() {
  register_post_type( 'testimonials',	
	 array(
      'labels' => array(
        'name' => __( 'Testimonials' ),
        'singular_name' => __( 'Testimonial' ),
		'add_new'            => _( 'Add New Testimonials'),
		'add_new_item'       => __( 'Add New Testimonials'),
		'new_item'           => __( 'New Testimonial'),
		'edit_item'          => __( 'Edit Testimonial'),
		'view_item'          => __( 'View Testimonial'),
		'all_items'          => __( 'All Testimonials'),
		'search_items'       => __( 'Search Testimonial')
      ),		
		'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
	 	'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title','editor','thumbnail','excerpt'),
		'menu_icon'           => 'dashicons-testimonial',
		'menu_position' => 52
	 )	
  );
}
/*-------------------------------------------------------------*/
add_action( 'init', 'create_jobs' );
function create_jobs() {
  register_post_type( 'jobs',   
     array(
      'labels' => array(
        'name' => __( 'jobs' ),
        'singular_name' => __( 'Jobs' ),
        'add_new'            => _( 'Add New jobs'),
        'add_new_item'       => __( 'Add New jobs'),
        'new_item'           => __( 'New Jobs'),
        'edit_item'          => __( 'Edit Jobs'),
        'view_item'          => __( 'View Jobs'),
        'all_items'          => __( 'All Jobs'),
        'search_items'       => __( 'Search Jobs')
      ),        
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title','editor','thumbnail','excerpt'),
        // 'menu_icon'           => 'dashicons-testimonial',
     )  
  );
} 
/*--------self-created-post-type-testimonail-ended------------*/
/*----self-created-post-type-gallery--------------*/
add_action( 'init', 'create_gallery_post_type' );
function create_gallery_post_type() {
  register_post_type( 'gallries',
    array(
		'labels' => array(
        'name' => __( 'Galleries' ),
        'singular_name' => __( 'Gallery' ),
		'add_new'            => _( 'Add New Gallery'),
		'add_new_item'       => __( 'Add New Gallery'),
		'new_item'           => __( 'New Gallery'),
		'edit_item'          => __( 'Edit Gallery'),
		'view_item'          => __( 'View Gallery'),
		'all_items'          => __( 'All Galleries'),
		'search_items'       => __( 'Search Gallery')
      ),			
		'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
	 	'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title'),
		'menu_icon' => get_template_directory_uri() . '/img/gallery.png',
		'menu_position' => 52
    )
  );	
  
}
/*--------self-created-post-type-gallery------------*/
/*contact form 7 ajax url issue*/
/* function change_wpcf7_url($url){
	if (strpos($url, 'semplice') !== false) {
    	$remove_unit_tag = explode('#',$url);
   		$new_url = '/contact'.'#'.$remove_unit_tag[1];
   		return $new_url;
   	}
    return $url;
}

add_filter('wpcf7_form_action_url', 'change_wpcf7_url'); */
/*contact form 7 ajax url issue*/

// ################################################################################


 function logo_slider() {

    
global $fdata;
    $html .='<div id="logo-slider" class="logo_slider logo-container">';
            $logo = $fdata['logo-gallery'] ;
            $etc = explode(",", $logo) ;
        foreach($etc as $attachmentId){ 
            $metaAttachment = wp_get_attachment_metadata( $attachmentId );
            $url2 =  $metaAttachment['file'];
                // echo '<pre>';
                    // print_r($metaAttachment['file']);
                // echo '</pre>';
            $url = home_url('wp-content/uploads/');
            // $post_id = get_the_ID();


            $html .='<div class="logo-slider-div">';
                $html .='<img src="'.$url . $url2.'"/>';
            $html .='</div>';
}                
    $html .='</div>';
    return $html;

}
add_shortcode("logo_slider","logo_slider");

##########################################################
// different excerpt length
##########################################################

function st_my_excerpt($excerpt_length = 55, $id = false, $echo = true) {

    $text = '';

    if ($id) {
        $the_post = & get_post($my_id = $id);
        $text = ($the_post->post_excerpt) ? $the_post->post_excerpt : $the_post->post_content;
    } else {
        global $post;
        $text = ($post->post_excerpt) ? $post->post_excerpt : get_the_content('');
    }

    $text = strip_shortcodes($text);
    $text = apply_filters('the_content', $text);
    $text = str_replace(']]>', ']]&gt;', $text);
    $text = strip_tags($text);

    $excerpt_more = '';
    $words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
    if (count($words) > $excerpt_length) {
        array_pop($words);
        $text = implode(' ', $words);
        $text = $text . $excerpt_more;
    } else {
        $text = implode(' ', $words);
    }
    if ($echo)
        echo apply_filters('the_content', $text);
    else
        return $text;
}

function get_my_excerpt($excerpt_length = 55, $id = false, $echo = false) {
    return st_my_excerpt($excerpt_length, $id, $echo);
}

add_filter( 'get_the_archive_title', function ($title) {

    if ( is_category() ) {

            $title = single_cat_title( '', false );

        } elseif ( is_tag() ) {

            $title = single_tag_title( '', false );

        } elseif ( is_author() ) {

            $title = '<span class="vcard">' . get_the_author() . '</span>' ;

        }

    return $title;

});

##################################################
##################################################

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

function call_us_now(){
    $html .='<div class="call-us-now">';
    global $fdata;
    if($fdata['st-contact-details']['phone']){
    $html .='<div class="call-text">';
        $html .= "CALL US NOW! "; 
    $html .='</div>';

    $html .='<div class="call-number"><p>';
        $html .= $fdata['st-contact-details']['phone'];
    $html .='</p></div>';
    
    }

    $html .='</div>';
    return $html;
}

add_shortcode("call_us_now","call_us_now");

function SearchFilter($query) {
    if ($query->is_search) {
        $query->set('post_type', 'post');
    }
    return $query;
}
add_filter('pre_get_posts','SearchFilter');

###################### Light Box ReMove #################
// function remove_scripts(){
// wp_enqueue_script('prettyphoto' );
// wp_deregister_script('prettyphoto' );
// }
// add_action( 'wp_enqueue_scripts', 'remove_scripts', 100 );


























################ waqar bhai short codes ########################
/***custom short codes* */
 /*--------testmonial-----------*/
global $fdata;
/* Testimonials List Shortcode */

/* Testimonials List Shortcode End */
/*---------------------------------------*/
/* Subscribe_sec Shortcode */
add_shortcode("subscribe","subscribe_sec");
function subscribe_sec() 
{
    global $fdata; 
    if($fdata['subs-switch']==1){
                $html .='<div class="Subscribe-section">';      
                    if($fdata['subs_head']){
                            $html .='<h2 class="sub-title">'.$fdata['subs_head'].'</h2>';
                        }
                        else{
                            $html .='<h2 class="sub-title">Subscribe Section</h2>';
                    }
                    if($fdata['subs_para']){    
                        $data_nor_subs = $fdata['subs_para'];
                        $data_nor_subs_data = apply_filters('the_content', $data_nor_subs);
                        $html .='<div class="top-para">'.$data_nor_subs_data.'</div>';
                            
                        }
                        else{
                            $html .='<p class="top-para"> </p>';
                    }
                    if($fdata['subs_shortcode']){
                            $html .= do_shortcode( ''.$fdata['subs_shortcode'].'');
                        }
                        else{
                            $html .='<p>Insert short code of Constant contact in theme settings</p>';
                    }               
                $html .='</div>';
            $html .='</div>';
    }
    return $html;
    }
/* Subscribe_sec Shortcode Ended */ 
/* Footer-contact-from */
add_shortcode("footer-contact-from","footer_contact_from");
function footer_contact_from(){
    global $fdata;
    if($fdata['subs-switch-footer']==1){
        if($fdata['subs_background_footer']['url']){
            $bg_img='background-image: url('.$fdata['subs_background_footer']['url'].');';
        }
        if($fdata['subs_color_footer']){
            
            $bg_color='background-color: '.$fdata['subs_color_footer'].';';
        }
    $html .='<section class="cus-parallax footer-form-sec" style="'.$bg_img.''.$bg_color.'">';          
        $html .='<div class="container">';                  
            $html .='<div class="col-sm-12">';  
                $html .='<div class="footer-from-inner-col">';  
                if($fdata['subs_shortcode_footer']){
                    $html .= do_shortcode( ''.$fdata['subs_shortcode_footer'].'');
                }
                else{
                        $html .='<p class="errored">Insert short code of Contact Form in theme settings</p>';
                }
                $html .='</div>';
            $html .='</div>';
        $html .='</div>';       
    $html .='</section>';           
    return $html;   
}
}
/* Footer-contact-from */
/*-footwr-contact-details-----*/    

/* contact page social */
add_shortcode("contact-details","social_icons_sec");
function social_icons_sec(){
    $html .='<div class="footer-contacts">';
    global $fdata;
    if($fdata['st-contact-details']['phone']){
        $html .='<a class="with-icon phone" href="tel:'.$fdata['st-contact-details']['phone'].'"><i class="fas fa-phone fa-flip-horizontal"></i>'.$fdata['st-contact-details']['phone'].'</a>';
    }
    $html .='<br>';
    if($fdata['st-contact-details']['faxnumber']){
        $html .='<a class="with-icon faxnumber" href="mailto:'.$fdata['st-contact-details']['faxnumber'].'"><i class="fas fa-fax"></i>'.$fdata['st-contact-details']['faxnumber'].'</a>';
    }
    $html .='<br>';
    if($fdata['st-contact-details']['email']){
        $html .='<a class="with-icon email" href="mailto:'.$fdata['st-contact-details']['email'].'"><i class="fas fa-envelope"></i>'.$fdata['st-contact-details']['email'].'</a>';
    }
    $html .='<br>';
    if($fdata['st-contact-details']['location']){
        $map_link= $fdata['st-contact-details']['location'];
    }
    if($fdata['address']){
        $html .='<a  target="_blank" class="with-icon address"><i class="fas fa-map-marker-alt"></i><div class="address-width"> '.$fdata['address'].'</div></a>';
    }
    $html .='</div>';
    return $html;
}
/* contact page social*/
/*---footer-contact-detail-ended----------*/
/* Footer Bottom Social Links */
add_shortcode("footerbottomsocial","footer_bottom_social");
function footer_bottom_social(){
    global $fdata;
            $html .='<ul class="social-icons">';
            $html .='<li class="text">Follow us</li>';
            if($fdata['st-social']['instagram']){
            $html .='<li><a href="'.$fdata['st-social']['instagram'].'" class="fab fa-instagram" target="_blank"></a></li>';
            }
            
        if($fdata['st-social']['fb']){
            $html .='<li><a href="'.$fdata['st-social']['fb'].'" class="fab fa-facebook-f" target="_blank"></a></li>';
            }
             if($fdata['st-social']['linkedin']){
                $html .='<li><a href="'.$fdata['st-social']['linkedin'].'" class="fab fa-linkedin-in" target="_blank"></a></li>';
                }
        if($fdata['st-social']['twitter']){
            $html .='<li><a href="'.$fdata['st-social']['twitter'].'" class="fab fa-twitter" target="_blank"></a></li>';
            }
        if($fdata['st-social']['gplus']){
            $html .='<li><a href="'.$fdata['st-social']['gplus'].'" class="fab fa-google-plus-g" target="_blank"></a></li>';
            }
        if($fdata['st-social']['pinterest']){
            $html .='<li><a href="'.$fdata['st-social']['pinterest'].'" class="fab fa-pinterest-p" target="_blank"></a></li>';
            } 
        
        if($fdata['st-social']['youtube']){
            $html .='<li><a href="'.$fdata['st-social']['youtube'].'" class="fab fa-youtube" target="_blank"></a></li>';
            } 
        if($fdata['st-social-header']['vimeo']){
            $html .='<li><a href="'.$fdata['st-social']['vimeo'].'" class="fa fa-vimeo" target="_blank"></a></li>';
            }
        
        
        if($fdata['st-social']['yelp']){
            $html .='<li><a href="'.$fdata['st-social']['yelp'].'" class="fab fa-yelp" target="_blank"></a></li>';
            }
        if($fdata['st-social']['rss']){
            $html .='<li><a href="'.$fdata['st-social']['rss'].'" class="fa fa-rss" target="_blank"></a></li>';
            }
        $html .='</ul>';    
    return $html;
}
/* Footer Bottom Social Links End */

/*------my-google-map---------*/
        function my_google_map($atts) {
            $a = shortcode_atts( array(
                'height' => '450px',
                'width' => '100%',
            ), $atts );
            global $fdata;
            $output = '';
            $output .= '<!-- google map code start -->';
                
            if($fdata['address']){
                $address=$fdata['address'];
            }
            else{
                $address="please set the address in theme settings";
            }
            if($fdata['contactnumber']){
                $phone=$fdata['contactnumber'];
            }
            else{
                $phone=" ";
            }
            if($fdata['email']){
                $email=$fdata['email'];
            }
            else{
                $email=" ";
            }
            $address;
            $phone;
            $fax;
            $email;
            if ( isset($address) ) {
                $output .= '
                    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyCRJEorG2FepiXFICMQ_QRCft_WtR632EA"></script>
                    <script>
                    var geocoder;
                    var map;
                    function initialize() {  
                      geocoder = new google.maps.Geocoder();
                      var address = "'.preg_replace('/^\s+|\n|\r|\s+$/m', ' ', strip_tags($address) ).'";//III Lincoln Centre 5430 LBJ Freeway, Suite 1200 Dallas, Texas 75240, United States
                      geocoder.geocode( { "address": address}, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            
                            map.setCenter(results[0].geometry.location);
                          
                            //creating marker
                            var marker = new google.maps.Marker({
                              map: map,
                              position: results[0].geometry.location,
                              title: "Our Location: "+address
                            });
                          
                            //binding info windowon marker click
                            google.maps.event.addListener(marker, "click", function() {
                                infowindow.open(map,marker);
                            });
                            google.maps.event.addListener(marker, "mouseover", function() {
                                //infowindow.open(map,marker);
                            });
                            google.maps.event.addListener(marker, "mouseout", function() {
                                //infowindow.close(map,marker);
                            });
                      
                        } else {
                          alert("Geocode was not successful for the following reason: " + status);
                        }
                      });
                    
                      
                      var myLatlng = new google.maps.LatLng(0,0);//-25.363882,131.044922
                      var mapOptions = {
                        zoom: 17,
                        center: myLatlng
                      };
                      var map = new google.maps.Map(document.getElementById("google_map"), mapOptions);
                ';
                      
                /*
                      var contentString = '<div id="content">'+
                          '<h1 id="firstHeading" class="firstHeading">'.bloginfo('name').'</h1>'+
                          '<div id="bodyContent">'+
                          '<p>Address: <?php echo preg_replace('/^\s+|\n|\r|\s+$/m', ' ', strip_tags($address) ); ?>'+
                          
                          <?php if( $phone ) {?>
                                '<p>Phone: <?=$phone?>'+
                            <?php } ?>
                          
                          <?php if( $fax) {?>
                                '<p>Fax: <?=$fax?>'+
                            <?php } ?>
                            
                          <?php if( $email ) {?>
                                '<p>Email: <?=$email?>'+
                            <?php } ?>
                          '</div>'+
                          '</div>';
                      var infowindow = new google.maps.InfoWindow({
                          content: contentString
                      });
                      */
                $output .= '
                    }
                    google.maps.event.addDomListener(window, "load", initialize);
                
                    </script>
                    <div id="google_map" width="'.$a['width'].'" height="500px"  style="height: '.$a['height'].'; border: 1px solid #ccc;" class="google_map"></div>
                ';
                
                /* return "height = {$a['height']}"." width = {$a['width']}"; */
                
            }
        
    return $output;
    
        }
    add_shortcode('my-google-map', 'my_google_map');
/*----------------*/
/*----short-code-with-parameters--------*/
/*  function maparea( $atts ) {
    $a = shortcode_atts( array(
        'height' => '100px',
        'width' => '100%',
    ), $atts );
    return "height = {$a['height']}"." width = {$a['width']}";
}
add_shortcode( 'maparea-to-add', 'maparea');  */
/*----short-code-with-parameters-Ended-------*/
/*----current-year--------*/
function year_shortcode() {
  $year = date('Y');
  return $year;
}
add_shortcode('current-year', 'year_shortcode');
/*----------*/
/*----site-url--------*/
function site_url_shortcode() {
  $url = get_site_url();
  return $url;
}
add_shortcode('site-url', 'site_url_shortcode');

function title_shortcode() {
     $sitetitle =get_bloginfo('name');
     return $sitetitle;
}
add_shortcode('site-title', 'title_shortcode');
/*----------*/


/* home-gallery shortcode */
function jobs(){
      $args = array(
                    'post_type' => array( 'jobs' ),
                    'post_status' => array( 'publish' ),
                    'paged' => $paged,
               );

   $query = new WP_Query( $args );
            $html .='<section class="good-company-section-2">';   
                                $html .='<ul class="jobs-links">';
        if ($query->have_posts()){
            while ( $query->have_posts()){
                $query->the_post();
                    $html .='<li>';
                     $html .='<a href="'.get_the_permalink().'">'.get_the_title().'</a>';
                    $html .='</li>';
     }
} 
            $html .='</ul>';
            $html .='</section>';
    return $html;
}
add_shortcode("jobs-sec","jobs");
/* home-gallery Shortcode */
/* show-gallery*/


    
	
	
	
	
	
	
	
// Add scripts to wp_footer()
function child_theme_footer_script() {
	global $post;
	$thePostID = $post->ID;
	$shortcodes_custom_css = get_post_meta( $thePostID, '_wpb_shortcodes_custom_css', true );
	if ( ! empty( $shortcodes_custom_css ) ) {
		$shortcodes_custom_css = strip_tags( $shortcodes_custom_css );
		echo '<style type="text/css" data-type="vc_shortcodes-custom-css'.$thePostID.'">';
		echo $shortcodes_custom_css;
		echo '</style>';
	}
	
}
add_action( 'wp_footer', 'child_theme_footer_script' );



// add_filter( 'the_content', 'wpautop' );