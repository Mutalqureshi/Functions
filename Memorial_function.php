<?php 
	function header_scripts(){
	wp_enqueue_style( 'bookmark-style', get_stylesheet_uri() );
// main style 
	wp_enqueue_style( 'bookmark-bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', false, '4', 'all' );
     wp_enqueue_style( 'taurin-fancybox', get_template_directory_uri() . '/css/jquery.fancybox.css' );
	// wp_enqueue_style( 'bookmark-fontawesome', get_template_directory_uri() . '/css/all.min.css', false, '5.2.0', 'all' );
	// wp_enqueue_style( 'bookmark-mediaquery', get_template_directory_uri() . '/css/mediaquery.css', false, '5.2.0', 'all' );
	wp_enqueue_style( 'bookmark-slider', get_template_directory_uri() . '/css/slick.css', false, '5.2.0', 'all' );
	wp_enqueue_style( 'bookmark-theme', get_template_directory_uri() . '/css/slick-theme.css', false, '5.2.0', 'all' );
	// wp_enqueue_style( 'bookmark-fonts', get_template_directory_uri() . '/css/fonts.css', false, '5.2.0', 'all' );
// style end script start
	wp_enqueue_style( 'bookmark-custom', get_template_directory_uri() . '/css/custom.css', false, '5.2.0', 'all' );

	wp_enqueue_script( 'bookmark-bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array(), time(), true );
	  wp_enqueue_script( 'taurin-fancy-js', get_template_directory_uri() . '/js/jquery.fancybox.js' );
	wp_enqueue_script( 'bookmark-slick-js', get_template_directory_uri() . '/js/slick.js', array(), time(), true );
	wp_enqueue_script( 'bookmark-custom-js', get_template_directory_uri() . '/js/custom.js', array(), time(), true );
	
	

	// if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
	// 	wp_enqueue_script( 'comment-reply' );
	// }
}
	add_action( 'wp_enqueue_scripts', 'header_scripts');
// header scrip all 

	//--------//







function recent_gallery($atts) {
		$html = '';
		
		$args = array(
					'post_type'              => array( 'gallery' ),
					'post_status'            => array( 'publish' ),
					'posts_per_page'         => 1,
				);
				
				// The Query
				$query = new WP_Query( $args );
				
				// The Loop
				if ( $query->have_posts() ) {
					while ( $query->have_posts() ) {
						$query->the_post();
						$field_data = get_field( "gallery_recent" );
						$myarr = preg_split ("/\,/", $field_data);  
						//echo "<pre>"; print_r($myarr);
						
						
						if(count($myarr)%2){
							array_pop($myarr);
						}
						$pieces = array_chunk($myarr, ceil(count($myarr) / 2));
						// echo "<pre>"; print_r($pieces);echo "</pre>"; 
						
						$html .= '<div class="row1 c_slider">';
						foreach($pieces[0] as $p1) {
							// print_r( $p1);
							 // print_r($imgm);
							$imgm = wp_get_attachment_image_src($p1 , 'full');
							$imgp = wp_get_attachment_image_src($p1, 'recent_gallery');
							$html .='<a class="box" data-fancybox="gallery" href="'.$imgm[0].'">';
							$html .= '<img src="'.$imgp[0].'">';
						    $html .='</a>';
                             // $html .='<img class="'.$img_size.'" src="'. $imgp .'"  />';

						}
						
						$html .= '</div><div class="row2 c_slider">';
						foreach($pieces[1] as $p2) {

							$imgm = wp_get_attachment_image_src($p2 , 'full');
							$imgp = wp_get_attachment_image_src($p2, 'recent_gallery');
							 // echo $imgp;
							$html .='<a class="box" data-fancybox="gallery" href="'.$imgm[0].'">';
								$html .= '<img src="'.$imgp[0].'">';
						    $html .='</a>';
						}
						$html .= '</div>';
					}
				}
				
				// Restore original Post Data
				wp_reset_postdata();
		return $html;
}
add_shortcode( 'recent_gallery', 'recent_gallery' );

add_image_size( 'recent_gallery', 352, 459, array( 'center', 'center' ));