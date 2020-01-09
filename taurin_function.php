<?php 
add_theme_support('post_thumbnails');


// header script

    function header_scripts(){
        wp_enqueue_style( 'taurin-style', get_stylesheet_uri() );
    // main style 
        wp_enqueue_style( 'taurin-bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css');
        wp_enqueue_style( 'taurin-fancybox', get_template_directory_uri() . '/css/jquery.fancybox.css' );
        wp_enqueue_style( 'taurin-fontawesome', get_template_directory_uri() . '/css/all.min.css' );
        wp_enqueue_style( 'taurin-slider', get_template_directory_uri() . '/css/slick.css' );
        wp_enqueue_style( 'taurin-theme', get_template_directory_uri() . '/css/slick-theme.css' );
        // wp_enqueue_style( 'taurin-masonay', get_template_directory_uri() . '/css/masonry.css' );
        // wp_enqueue_style( 'taurin-fonts', get_template_directory_uri() . '/css/fonts.css' );
        wp_enqueue_style( 'taurin-owl-c', get_template_directory_uri() . '/css/owl.carousel.min.css' );
        wp_enqueue_style( 'taurin-owl', get_template_directory_uri() . '/css/owl.theme.default.css' );
        wp_enqueue_style( 'taurin-responsive', get_template_directory_uri() . '/css/rwd.css' ,false, time() , 'all');
        wp_enqueue_style( 'taurin-custom', get_template_directory_uri() . '/css/theme-style.css', false, time() , 'all' );
        wp_enqueue_script( 'jquery' );
    // style end script start

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
    add_action( 'wp_enqueue_scripts', 'header_scripts');

function footer_enqueue_scripts() {
        wp_enqueue_script( 'taurin-bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js' );
        wp_enqueue_script( 'taurin-fancy-js', get_template_directory_uri() . '/js/jquery.fancybox.js' );
        // wp_enqueue_script( 'taurin-iso-js', get_template_directory_uri() . '/js/isotope.pkgd.min.js' );
        wp_enqueue_script( 'taurin-slick-js', get_template_directory_uri() . '/js/slick.js' );
        wp_enqueue_script( 'taurin-pooper-js', get_template_directory_uri() . '/js/jquery.scrolling.js' );
        wp_enqueue_script( 'taurin-iso-js', get_template_directory_uri() . '/js/owl.carousel.min.js' );
        wp_enqueue_script( 'taurin-custom-js', get_template_directory_uri() . '/js/custom.js', array(), time(), true );
    }
add_action('wp_footer', 'footer_enqueue_scripts');



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



// remove version from head
remove_action('wp_head', 'wp_generator');

// remove version from rss
add_filter('the_generator', '__return_empty_string');

// remove version from scripts and styles
function shapeSpace_remove_version_scripts_styles($src) {
    if (strpos($src, 'ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('style_loader_src', 'shapeSpace_remove_version_scripts_styles', 9999);
add_filter('script_loader_src', 'shapeSpace_remove_version_scripts_styles', 9999);


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
	  'main-menu' => __( 'Header Main Menu' ),
      'footer-menu' => __( 'Footer Menu' ),
	  'copyright-menu' => __( 'Copy Right Menu' ),
    )
  );
}
add_action( 'init', 'wpb_custom_new_menu' );
/*--------menus-with-extra-menu+location-ended--------------*/
/*----jquery-migrate-------*/
// add_action( 'wp_default_scripts', function( $scripts ) {
//     if ( ! empty( $scripts->registered['jquery'] ) ) {
//         $scripts->registered['jquery']->deps = array_diff( $scripts->registered['jquery']->deps, array( 'jquery-migrate' ) );
//     }
// } );
/*----jquery-migrate-----------*/

/*-----for-gettingalt-image------------*/
/*---custom-images-size---*/
add_action( 'after_setup_theme', 'ja_theme_setup' );
function ja_theme_setup() {
    add_theme_support( 'post-thumbnails');
}
/* in use del all */
add_image_size( 'thumbnail-all-single-blog-post', 999, 450, array( 'center', 'center' ));


add_image_size( 'recent-blog-image', 170, 122, array( 'center', 'center' ) );

/*--gallery-sizes--*/
add_image_size('gallery-square', 452, 452, array( 'center','center') );
/*--gallery-sizes--*/




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
    if($fdata['phone']){
    $html .='<div class="call-text">';
        $html .= "CALL US NOW! "; 
    $html .='</div>';

    $html .='<div class="call-number"><p>';
        $html .= $fdata['phone'];
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
/*----------*/




function logo_slider() {

    
global $fdata;
    $html .='<div id="logo-slider" class="logo_slider logo-container">';
            $logo = $fdata['logo-gallery'] ;
            $etc = explode(",", $logo) ;
        foreach($etc as $attachmentId){ 
            $metaAttachment = wp_get_attachment_metadata( $attachmentId );
            $url2 =  $metaAttachment['file'];
                


            $post_id = get_post($attachmentId);
            $url = home_url('wp-content/uploads/');

            $html .='<div class="logo-slider-div">';
                $html .='<img src="'.$url . $url2.'"/>';
                // $html .='<a href="'.$post_id->post_excerpt.'" target="_blank" ><img src="'.$url . $url2.'"/></a>';
            $html .='</div>';
}                
    $html .='</div>';
    return $html;

}
add_shortcode("logo_slider","logo_slider");


function naked_register_sidebars() {
register_sidebar(array(                    // Start a series of sidebars to register
    'id' => 'footer-wid',                     // Make an ID
    'name' => 'Footer Widget',              // Name it
    'description' => 'Take it on the side...', // Dumb description for the admin side
    'before_widget' => '<div class="col-lg-4 wd-w col-md-6 col-12">',    // What to display before each widget
    'after_widget' => '</div>', // What to display following each widget
    'before_title' => '<span class="footer-wid-con">',    // What to display before each widget's title
    'after_title' => '</span>',     
    'empty_title'=> '',                 // What to display in the case of no title defined for a widget
));


} 
add_action( 'widgets_init', 'naked_register_sidebars' );


// gallery post type

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
        // 'menu_icon' => get_template_directory_uri() . '/img/gallery.png',
        'menu_position' => 52
    )
  );    
  
}

// ---------------------------------------------------------------

add_image_size( 'small-preview', 90, 90, array( 'center', 'center' ) );
add_image_size( 'gallery-square', 360, 363, array( 'center', 'center' ) );
add_image_size( 'gallery-horizontal', 740, 373, array( 'center', 'center' ) );
add_image_size( 'gallery-vertical', 665, 671, array( 'center', 'center' ) );



add_shortcode("home-gallery","home_gallery");
function home_gallery(){
$html .='<section class="single-gallery container-fluid">'; 
               
                    $html .='<div class="row">';
                    $html .='<div class="col-sm-12 p-none">'; 
                        $html .='<div id="myList" class="all-gallery grid owl-carousel ">';
                            $args = array(
                                'post_type' => 'gallries',
                                'numberposts' => -1,
                                'order'    => 'ASC',
                            );
                            $loop = new WP_Query($args);
                            while($loop->have_posts()): $loop->the_post();
                            
                                if( have_rows('gallery_slide') ):
                                $in = 0;
                                while ( have_rows('gallery_slide') ) : the_row(); 
                                $in++;
                        $html .="<div class='slide clearfix'>";
                                /*----for image-------*/
                                $bigimage = get_sub_field('bigimage');
                                $horizontal_image = get_sub_field('horizontal_image');
                                $horizontal_image_2 = get_sub_field('horizontal_image_2');
                                $square_image = get_sub_field('square_image');
                                $square_image_2= get_sub_field('square_image_2');

        if ($in % 2 == 0){
                          
                                $image_list = array(
                                    array($horizontal_image['sizes']['gallery-horizontal'], $horizontal_image['sizes']['large'] , 'hor-40'), 
                                    array($square_image_2['sizes']['gallery-square'], $square_image_2['sizes']['large'] , 'square'),
                                    array($bigimage['sizes']['gallery-vertical'], $bigimage['sizes']['large'] ,'width-75 fl-right'),
                                    array($square_image['sizes']['gallery-square'], $square_image['sizes']['large'] , 'square'), 
                                    array($horizontal_image_2['sizes']['gallery-horizontal'], $horizontal_image_2['sizes']['large'] , 'hor-40'), 
                                );
        }
        else{
              $image_list = array(
                                    array($bigimage['sizes']['gallery-vertical'], $bigimage['sizes']['large'] ,'width-75'),
                                    array($horizontal_image['sizes']['gallery-horizontal'], $horizontal_image['sizes']['large'] , 'hor-40'), 
                                    array($square_image_2['sizes']['gallery-square'], $square_image_2['sizes']['large'] , 'square'), 
                                    array($square_image['sizes']['gallery-square'], $square_image['sizes']['large'] , 'square'), 
                                    array($horizontal_image_2['sizes']['gallery-horizontal'], $horizontal_image_2['sizes']['large'] , 'hor-40'), 
                                );
        }
                                foreach ($image_list as $key => $image_list) {
                                    $html .='<div class="grid-item '.$image_list[2] .' gallery_product gallery-'.get_the_ID().'">';
                                        $html .='<div class="relative-main">';  
                                            $html .='<a class="box" data-fancybox="gallery" href="'.$image_list[1].'">';
                                                 $html .='<img class="" src="'.$image_list[0].'" alt="" />';
                                            $html .='</a>';
                                        $html .='</div>';   
                                    $html .='</div>'; 
                                 }
                                // $html .= "<div>";
                                    $html .="</div>";
                                endwhile;
                            endif;
                            endwhile;                   
                        
                    $html .='</div>';
                $html .='</div>';
                $html .='</div>';
            $html .='</section>';
    return $html;
}
/*end*/



add_shortcode("experience_get","experience_get");
function experience_get(){
$html .='<section class="time_line">'; 


        $args = array(
            'post_type' => 'edu_exp',
            'numberposts' => -1,
            'order'    => 'ASC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'edu_exp_tax',//taxonomy ka name ayga category ka nhi
                    'field'    => 'experience',//category slug call hoga
                    'terms'    => array( '9' ), 
                ),
         )
        );
        $loop = new WP_Query($args);
        while($loop->have_posts()){ $loop->the_post();
            $html .='<div class="timeline_section col-10">';

                $html .=  "<div class='ex_year'><div class='year_text'><i class='far fa-calendar'> </i>" . get_field('year') ."</div></div>";
                $html .=  "<h4>" . get_the_title() ."</h4>";
                $html .=  "<p>" . get_the_content() ."<p>";

            $html .='</div>'; 
        }                  
$html .='</section>';
    return $html;
}
/*end*/

add_shortcode("education_get","education_get");
function education_get(){
$html .='<section class="time_line">'; 


        $args = array(
            'post_type' => 'edu_exp',
            'numberposts' => -1,
            'order'    => 'ASC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'edu_exp_tax',//taxonomy ka name ayga category ka nhi
                    'field'    => 'education',//category slug call hoga
                    'terms'    => array( '8' ), 
                ),
         )
        );

        $loop = new WP_Query($args);
        while($loop->have_posts()){ $loop->the_post();
            $html .='<div class="timeline_section col-10">';

                $html .=  "<div class='ex_year'><div class='year_text'><i class='far fa-calendar'> </i>" . get_field('year') ."</div></div>";
                $html .=  "<h4>" . get_the_title() ."</h4>";
                $html .=  "<p>" . get_the_content() ."<p>";

            $html .='</div>'; 
        }                  
$html .='</section>';
    return $html;
}
// =-----------





function my_exp(){
    register_post_type( 'edu_exp',
        array(
            'labels' => array(
                'name' => __( 'edu_exp'),
                'singular_name' => __('edu_exp')
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt')
            )
        );
    }
add_action( 'init', 'my_exp' );

function custom_taxonomy_ee() {
    $labels = array(
    'name'              => _x( 'edu_exp_Category', 'taxonomy general name', 'textdomain' ),
    'singular_name'     => _x( 'edu_exp_Category', 'taxonomy singular name', 'textdomain' ),
    'search_items'      => __( 'Search edu_exp', 'textdomain' ),
    'all_items'         => __( 'All edu_exp', 'textdomain' ),
    'parent_item'       => __( 'Parent Client', 'textdomain' ),
    'parent_item_colon' => __( 'Parent edu_exp:', 'textdomain' ),
    'edit_item'         => __( 'Edit edu_exp', 'textdomain' ),
    'update_item'       => __( 'Update edu_exp', 'textdomain' ),
    'add_new_item'      => __( 'Add New edu_exp Category', 'textdomain' ),
    'new_item_name'     => __( 'New edu_exp Name', 'textdomain' ),
    'menu_name'         => __( 'edu_exp Category', 'textdomain' ),
);

$args = array(
    'hierarchical'      => true,
    'labels'            => $labels,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
);

register_taxonomy( 'edu_exp_tax', array( 'edu_exp' ), $args );

}
add_action('init','custom_taxonomy_ee');



// **********************************************
function my_post(){
    register_post_type( 'skills_hobbies',
        array(
            'labels' => array(
                'name' => __( 'skills_hobbies' ),
                'singular_name' => __( 'Skills & Hobbies' )
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt')

            )
        );
    }
add_action( 'init', 'my_post' );

function custom_taxonomy() {
    $labels = array(
    'name'              => _x( 'skills_hobbies_Category', 'taxonomy general name', 'textdomain' ),
    'singular_name'     => _x( 'skills_hobbies_Category', 'taxonomy singular name', 'textdomain' ),
    'search_items'      => __( 'Search skills_hobbies', 'textdomain' ),
    'all_items'         => __( 'All skills_hobbies', 'textdomain' ),
    'parent_item'       => __( 'Parent Client', 'textdomain' ),


    'parent_item_colon' => __( 'Parent skills_hobbies:', 'textdomain' ),
    'edit_item'         => __( 'Edit skills_hobbies', 'textdomain' ),
    'update_item'       => __( 'Update skills_hobbies', 'textdomain' ),
    'add_new_item'      => __( 'Add New skills_hobbies Category', 'textdomain' ),
    'new_item_name'     => __( 'New skills_hobbies Name', 'textdomain' ),
    'menu_name'         => __( 'skills_hobbies Category', 'textdomain' ),
);

$args = array(
    'hierarchical'      => true,
    'labels'            => $labels,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
);

register_taxonomy( 'skills_hobbies_tax', array( 'skills_hobbies' ), $args );

}
add_action('init','custom_taxonomy');
 
// =------- SKills and hobbies


function skills(){
$html="";
$html .='<section class="skill">'; 
        $args = array(
            'post_type' => 'skills_hobbies',
            'numberposts' => -1,
            'order'    => 'ASC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'skills_hobbies_tax',//taxonomy ka name ayga category ka nhi
                    'field'    => 'skills',//category slug call hoga
                    'terms'    => array( '6' ), 
                ),
         )
    );
        $loop = new WP_Query($args);
        while($loop->have_posts()){ $loop->the_post();
            $html .='<div class="skill_section pdlf col-md-10">';

            // $html .=  "<div class='ex_year'><div class='year_text'><i class='far fa-calendar'> </i>" . get_field('education_year') ."</div></div>";

                $html .=  "<h4>" . get_the_title() ."</h4>";
                $html .=  "<p>" . get_the_content() ."<p>";
               
                $html .= '<div class="progress-bar" data-percentage="' . get_field('progress').'">';
                    $html .= '<div class="red bar"><span></span></div>';
                    $html .= '<div class="label"></div>';
                $html .= '</div>';

               


            $html .='</div>'; 
        }                  
$html .='</section>';
    return $html;
}
add_shortcode("skills","skills");



// ---------------------------------------

function hobbies(){
$html="";
$html .='<section class="hobbies">'; 

        $args = array(
            'post_type' => 'skills_hobbies',
            'numberposts' => -1,
            'order'    => 'ASC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'skills_hobbies_tax',//taxonomy ka name ayga category ka nhi
                    'field'    => 'hobbies',//category slug call hoga
                    'terms'    => array( '7' ), 
                ),
         )
    );

        $loop = new WP_Query($args);
        while($loop->have_posts()){ $loop->the_post();
           $html .='<div class="skill_section pdlf col-md-10">';

            // $html .=  "<div class='ex_year'><div class='year_text'><i class='far fa-calendar'> </i>" . get_field('education_year') ."</div></div>";

                $html .=  "<h4>" . get_the_title() ."</h4>";
                $html .=  "<p>" . get_the_content() ."<p>";
               
                $html .= '<div class="progress-bar" data-percentage="' . get_field('progress').'">';
                    $html .= '<div class="red bar"><span></span></div>';
                    $html .= '<div class="label"></div>';
                $html .= '</div>';

            $html .='</div>'; 
        }                  
$html .='</section>';
    return $html;
}
add_shortcode("hobbies","hobbies");


add_shortcode("contact-details","social_icons_sec");
function social_icons_sec(){
    $html .='<div class="footer-contacts">';
    global $fdata;
    if($fdata['phone']){
        $html .='<a class="with-icon phone" href="tel:'.$fdata['phone'].'"><i class="fas fa-phone fa-flip-horizontal"></i>'.$fdata['phone'].'</a>';
    }
    $html .='<br>';
    if($fdata['email']){
        $html .='<a class="with-icon email" href="mailto:'.$fdata['email'].'"><i class="fas fa-envelope"></i>'.$fdata['email'].'</a>';
    }
    $html .='<br>';
    if($fdata['address']){
        $html .='<a  target="_blank" class="with-icon address"><i class="fas fa-map-marker-alt"></i><div class="address-width"> '.$fdata['address'].'</div></a>';
    }
    $html .='</div>';
    return $html;
}