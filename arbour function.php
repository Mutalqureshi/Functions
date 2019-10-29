<?php 
	require_once get_template_directory() .'/inc/posttype.php';
	require_once get_template_directory() .'/inc/widgets.php';
	function header_scripts(){
	wp_enqueue_style( 'arboursdentistry-style', get_stylesheet_uri() );
// main style 
	wp_enqueue_style( 'arboursdentistry-bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css');
	wp_enqueue_style( 'arboursdentistry-fontawesome', get_template_directory_uri() . '/css/all.min.css' );
	// wp_enqueue_style( 'arboursdentistry-mediaquery', get_template_directory_uri() . '/css/mediaquery.css' );
	wp_enqueue_style( 'arboursdentistry-slider', get_template_directory_uri() . '/css/slick.css' );
	wp_enqueue_style( 'arboursdentistry-theme', get_template_directory_uri() . '/css/slick-theme.css' );
	wp_enqueue_style( 'arboursdentistry-fonts', get_template_directory_uri() . '/css/fonts.css' );
	wp_enqueue_style( 'arboursdentistry-custom', get_template_directory_uri() . '/css/custom.css', false, time() , 'all' );
// style end script start
	wp_enqueue_script( 'arboursdentistry-bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js' );
	wp_enqueue_script( 'arboursdentistry-slick-js', get_template_directory_uri() . '/js/slick.js' );
	wp_enqueue_script( 'arboursdentistry-custom-js', get_template_directory_uri() . '/js/custom.js', array(), time(), true );
	
	

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


	function arboursdentistry(){
		register_nav_menus( array(
		'menu-1' => esc_html__( 'Main Menu', 'arboursdentistry' ),
		'menu-2' => esc_html__( 'Sec Menu', 'arboursdentistry' ),
		'menu-3' => esc_html__( 'Foot Menu', 'arboursdentistry' ),
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
	add_action('after_setup_theme', 'arboursdentistry');

// pagination checking
// Numbered Pagination
#
add_action('after_setup_theme', 'st_thumbnail_setup');
if (!function_exists('st_thumbnail_setup')) {

    function st_thumbnail_setup() {

        add_image_size('st_263_263', 530, 480, true);
        
    }

}


######################################################################################
//ADD custom logo on wordpress login page
######################################################################################
add_action( 'login_enqueue_scripts', 'my_login_logo' );
function my_login_logo() {
	global $fdata;
	//print_r($fdata['login-logo']);
	
	$default_logo = get_template_directory() . '/img/site-logo.png';
	if ( !file_exists( $default_logo ) ) {
		$default_logo = '';
	}
	$logo_url = ( isset($fdata['login-logo']['url']) ? $fdata['login-logo']['url'] : $default_logo );
	$logo_height = ( isset($fdata['login-logo']) ? $fdata['login-logo']['height'] : '111' );
	
	$bg_img = ( empty($logo_url)  ?  ''  :  'background-image: url("'.$logo_url.'");' );
	?>
    <style type="text/css">
		body.login {
			background-color:<?=$fdata['login-color-bg']?>;
		}
        body.login div#login h1 a {
           <?=$bg_img?>
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
// Replaces the excerpt "more" text by a link
######################################################################################
function new_excerpt_more( $more ) {
	return '<a href="'. get_permalink( get_the_ID() ) . '"> ....</a>';
	//return ' &hellip;';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );




######################################################################################
//excerpt character limit
######################################################################################
function custom_excerpt_length( $length ) {
	return 23;
}
add_filter( 'excerpt_length', 'custom_excerpt_length' );





######################################################################################
// remove junk from head
######################################################################################
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);	





############################################################################
//disable wordpress default image resize
############################################################################
function remove_default_image_sizes( $sizes) {
    //unset( $sizes['thumbnail']);
    unset( $sizes['medium']);
    //unset( $sizes['large']);
     
    return $sizes;
}
//add_filter('intermediate_image_sizes_advanced', 'remove_default_image_sizes');





############################################################################
// Enable post thumbnails and custom sizes
############################################################################
//add_image_size( 'blog-thumb', 750, 312, true ); // for homepage product listing
//add_image_size( 'blog-thumb-home', 300, 218, true ); // for homepage product listing







############################################################################
//Shortcodes in Text Widgets
############################################################################
add_filter('widget_text', 'do_shortcode');



####################################################
# custom-pagination
####################################################

function phone_num(){
    global $fdata;
          $html='';
           if( $fdata['phone']){?>
        <a href="tel:<?php echo $fdata['phone']; ?>"><i class="fas fa-phone-alt"></i> <?php echo $fdata['phone']; ?></a ><?php } 
    return $html;
}
add_shortcode("phone","phone_num");


function phone2(){
    global $fdata;
          $html='';
           if( $fdata['phone']){?>
           	<div class="cta-phone">
		        <a href="tel:<?php echo $fdata['phone']; ?>"> <?php echo $fdata['phone']; ?></a>
		    </div><?php } 
           	
    return $html;
}
add_shortcode("phone2","phone2");

function phone_number(){
    global $fdata;

          $html = $fdata['phone'];
          // $html = "<a href='tel:".$fdata['phone'].">".$fdata['phone']."</a>";
            
    return $html;
}
add_shortcode("phone_number","phone_number");

function address_txt(){
    global $fdata;
          $html='';
        if($fdata['address']){?>
        	<div class="head-address foot-address">
                    <i class="fas fa-map-marker-alt"></i><p><?php echo $fdata['address']; ?></p><?php } 
           ?> </div>
   <?php
    return $html;
}
add_shortcode("address" ,"address_txt");


function address_txt2(){
    global $fdata;
          $html='';
        if($fdata['address']){?>
        	<div class="wel-p well-p2">
                   <p><?php echo $fdata['address']; ?></p><?php } 
           ?> </div>
   <?php
    return $html;
}
add_shortcode("address2" ,"address_txt2");
####################################################
// testimonial
function testimonials_list() 
{
	$args = array(
		// 'posts_per_page' => 1,
		'post_type' => 'testimonials',
		'order' => 'ASC',
	); 
	$loop = new WP_Query($args); // The Loop

	// $html .= '<section class="testimonial-sec">';
	// $html .= '<h2>Testimonials</h2>';
	$html .='<div id="testimonial-slider" class="multiple-items">';
		while ( $loop->have_posts() ) : $loop->the_post();
				{ 
					$post_id = get_the_ID();
					$html .='<div class="testimonial-div">';

						$html .= '<div class="testimonial-section">';
						// $html .= '<h2 class="testimonial-tilte">'.get_the_title().' </h2>';
						
						$html .= '<p>'.get_the_content().'</p>';
						

							$html .='<div class="rating">';
							$html .= get_the_post_thumbnail();;
							$html .= '</div><!-- 5start-->';
						$html .= '<h2 class="testimonial-tilte">'.get_the_title().' </h2>';
						
						$html .= '</div>';
					// $html .= '<p><strong>-'.get_the_title().','.get_field("name").'</strong><br>'.get_field("test_location").'</p>';					
					$html .='</div>';
					
				} 
		endwhile;
	$html .='</div>';
	// $html .= '</section>';
	return $html;
}
add_shortcode("testimonials-list","testimonials_list");

// testimonial end 
####################################################
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

function st_wpbeginner_numeric_posts_nav() {
    if (is_singular())
        return;
    global $wp_query;/** Stop execution if there's only 1 page */
    if ($wp_query->max_num_pages <= 1)
        return;
    $paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
    $max = intval($wp_query->max_num_pages);/** Add current page to the array */
    if ($paged >= 1)
        $links[] = $paged;/** Add the pages around the current page to the array */
    if ($paged >= 3) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    } if (( $paged + 2 ) <= $max) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    } echo '<ul class="pagination clearfix">' . "\n";/** Previous Post Link */
    if (get_previous_posts_link())
        printf('<li class="prevPage">%s</li>' . "\n", get_previous_posts_link('&#10094;', ''));/** Link to first page, plus ellipses if necessary */
    if (!in_array(1, $links)) {
        $class = 1 == $paged ? ' class="active"' : '';
        printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link(1)), '1');
        if (!in_array(2, $links))
            echo '<li>...</li>';
    } /** Link to current page, plus 2 pages in either direction if necessary */
    sort($links);
    foreach ((array) $links as $link) {
        $class = $paged == $link ? ' class="active"' : '';
        printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($link)), $link);
    } /** Link to last page, plus ellipses if necessary */
    if (!in_array($max, $links)) {
        if (!in_array($max - 1, $links))
            echo '<li>...</li>' . "\n";
        $class = $paged == $max ? ' class="active"' : '';
        printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($max)), $max);
    } /** Next Post Link */
    if (get_next_posts_link())
        printf('<li class="nextPage">%s</li>' . "\n", get_next_posts_link('&#10095;', ''));
    echo '</ul>' . "\n";
}

