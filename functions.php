<?php
/*
* Add your own functions here. You can also copy some of the theme functions into this file. 
* Wordpress will use those functions instead of the original functions then.
*/

defined("ABSPATH") || exit();


function load_scripts_styles() {
	$vn = wp_get_theme()->get( 'Version' );
	// Styles
	wp_enqueue_style( 'child-theme-styles' , get_stylesheet_directory_uri() . '/css/main.css');
	// Scripts
	wp_enqueue_script('sweetAlert', get_stylesheet_directory_uri() .'/js/sweetalert2.all.min.js');
	wp_enqueue_script( 'custom-scripts', get_stylesheet_directory_uri() . '/js/custom-scripts.js', array('jquery'), $vn , true );
	wp_localize_script( 'custom-scripts', 'SpaAjax', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'security' => wp_create_nonce( '(H+MbPeShVmYq3t6' )
	));
}
add_action( 'wp_enqueue_scripts', 'load_scripts_styles' , 99999999999);


function myaparat($atts) {
	extract( shortcode_atts( array(
		'id' => '',
		'width' => '100%',
		'height' => 450,
		'style' => 'margin: 10px;'
	), $atts ) );
	$servertype = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http');

	return "<center style='{$style}'><iframe src='".$servertype."://www.aparat.com/video/video/embed/videohash/{$id}/vt/frame' width='{$width}' height='{$height}' allowfullscreen='true' style='border:none!important'></iframe></center>";
}
add_shortcode( 'aparat', 'myaparat' );


/**
 * Show products tags
 */
add_shortcode('show_product_tags', 'product_tags');
function product_tags($attr , $content){
	$output = array();
	$terms = wp_get_post_terms( get_the_id(), 'product_tag' );
	if( count($terms) > 0 ){
		foreach($terms as $term){
			$term_id = $term->term_id; // Product tag Id
			$term_name = $term->name; // Product tag Name
			$term_slug = $term->slug; // Product tag slug
			$term_link = get_term_link( $term, 'product_tag' ); // Product tag link
			$output[] = '<a href="'.$term_link.'" class="product-tag">'.$term_name.'</a>';
		}
		// Set the array in a coma separated string of product tags for example
		$output = implode( ' ، ', $output );
		// Display the coma separated string of the product tags
		echo '<div class="woo-tags-section" style="line-height: 2;"> <span class="font-weight-bold">برچسب ها: </span> ' . $output . '</div>';
	}
}

/*
 * Replace 'textdomain' with your plugin's textdomain. e.g. 'woocommerce'.
 * File to be named, for example, yourtranslationfile-en_GB.mo
 * File to be placed, for example, wp-content/lanaguages/textdomain/yourtranslationfile-en_GB.mo
 */
add_filter( 'load_textdomain_mofile', 'load_custom_plugin_translation_file', 10, 2 );
function load_custom_plugin_translation_file( $mofile, $domain ) {
	if ( 'textdomain' === $domain ) {
		$mofile = WP_LANG_DIR . '/woocommerce/woocommerce-fa_IR-' . get_locale() . '.mo';
	}
	return $mofile;
}

add_filter( 'get_shortlink', function( $shortlink ) {return $shortlink;} );


/**
 * Show single post tags
 */
function avs_posts_tag_cb() {
	global $post;
	$the_tags = get_the_tags( $post->ID );
	$output = '<span class="post_tag">';
	foreach($the_tags as $tag) {
		$taglink = get_tag_link($tag->term_id);
		if(!next($the_tags)) {
			$output .= '<a href='.$taglink.'>'.$tag->name.' </a>';
		}else{
			$output .= '<a href='.$taglink.'>'.$tag->name.' </a>';
		}
	}
	return  $output . '</span>';
}
add_shortcode('avs_posts_tag', 'avs_posts_tag_cb');


/**
 * Remove the generated product schema markup from Product Category and Shop pages.
 */
//function wc_remove_product_schema_product_archive() {
//	remove_action( 'woocommerce_shop_loop', array( WC()->structured_data, 'generate_product_data' ), 10, 0 );
//}
//add_action( 'woocommerce_init', 'wc_remove_product_schema_product_archive' );


add_action('wp_logout','auto_redirect_external_after_logout');
function auto_redirect_external_after_logout(){
	?>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script type="text/javascript">
        const BottomToast = Swal.mixin({
            toast: true,
            position: 'bottom-start',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
        BottomToast.fire({
            icon: 'success',
            title: 'با موفقیت از سایت خارج شدید.'
        });
        window.location.replace('http://localhost/wordpress');
        //window.location.replace(document.location.origin);
    </script>
	<?php
	//wp_redirect( get_site_url() );
	exit();
}


/**
 * disable zxcvbn.min.js in wordpress
 */
add_action('wp_print_scripts', 'remove_password_strength_meter');
function remove_password_strength_meter() {
	wp_dequeue_script('zxcvbn-async');
	wp_deregister_script('zxcvbn-async');
}


/**
 * Add extra attributes to posts
 */
function gt_get_post_view() {
	$count = get_post_meta( get_the_ID(), 'post_views_count', true );
	$count = $count != '' ? $count : 0;
	return "$count";
}
function gt_set_post_view() {
	$key = 'post_views_count';
	$post_id = get_the_ID();
	$count = (int) get_post_meta( $post_id, $key, true );
	$count++;
	update_post_meta( $post_id, $key, $count );
}
function gt_posts_column_views( $columns ) {
	$columns['post_views'] = 'تعداد بازدید';
	return $columns;
}
function gt_posts_custom_column_views( $column ) {
	if ( $column === 'post_views') {
		echo gt_get_post_view();
	}
}
add_filter( 'manage_posts_columns', 'gt_posts_column_views' );
add_action( 'manage_posts_custom_column', 'gt_posts_custom_column_views' );



/**
 * Add extra attributes to posts
 */
add_shortcode('post_header_attribs', function (){
	global $post;
	$postUrl = wp_get_shortlink( $post->ID, 'post',  true );
	$postTitle = get_the_title($post->ID);

	gt_set_post_view();
	$pvc = gt_get_post_view();

	if (is_single()){
		$html = '
        <div class="row container" id="post_data_container">
            <div class="post_data">
                    <p class="post_views_count"><i class="ic-eye mx-1 float-right"></i>تعداد بازدید: '.$pvc.' </p>
                    <h1 class="post_title"><a href="'.$postUrl.'">'.$postTitle.'</a></h1>
            </div>
        </div> ';
	}else{
		$html = '
        <div class="row container" id="post_data_container">
            <div class="post_data">
                    <h1 class="post_title"><a href="'.$postUrl.'">'.$postTitle.'</a></h1>
            </div>
        </div> ';
	}

	return $html;
});
add_shortcode('post_footer_attribs', function (){
	global $post;
	$postUrl = wp_get_shortlink( $post->ID, 'post',  true );
	$fullUrl = urlencode($postUrl);

	if( is_single() ) {
		$html = '<div class="single_post_share_btns">
            <div class="w-100">
                <ul>
                    <li class="icons ln"> <a href="https://www.linkedin.com/shareArticle?mini=true&amp;url='.$fullUrl.'" rel="nofollow" target="_blank" data-toggle="tooltip" data-placement="top" title="اشتراک در لینکدین"> <i class="ic-linkedin"></i> </a> </li>
                    <li class="icons wa"><a href="https://wa.me/?text='.$fullUrl.'" rel="nofollow" target="_blank" data-toggle="tooltip" data-placement="top" title="اشتراک در واتساپ"><i class="ic-whatsapp"></i></a></li>
                    <li class="icons tl"><a href="https://telegram.me/share/url?url='.$fullUrl.'" rel="nofollow" target="_blank" data-toggle="tooltip" data-placement="top" title="اشتراک در تلگرام"><i class="ic-telegram"></i></a></li>
                    <li class="icons tw"><a href="https://twitter.com/share?url='.$fullUrl.'" rel="nofollow" target="_blank" data-toggle="tooltip" data-placement="top" title="اشتراک در توییتر"><i class="ic-twitter"></i></a></li>
                    <li class="icons fb"><a href="https://www.facebook.com/sharer/sharer.php?u='.$fullUrl.'" rel="nofollow" target="_blank" data-toggle="tooltip" data-placement="top" title="اشتراک در فیسبوک"><i class="ic-facebook"></i></a></li>
                    <li class="icons link">
                        <a href="#" onclick="copyToClip(event)" data-toggle="tooltip" data-placement="top" title="کپی لینک کوتاه" rel="tooltip"><i class="ic-link"></i> </a>
                    </li>
                </ul>
                <input type="hidden" id="short_link" value="'.$postUrl.'">
            </div>
        </div>';
	}

	$the_tags = get_the_tags( $post->ID );
	$output = '<span class="post_tag">';
	foreach($the_tags as $tag) {
		$taglink = get_tag_link($tag->term_id);
		if(!next($the_tags)) {
			$output .= '<a href='.$taglink.'>'.$tag->name.' </a>';
		}else{
			$output .= '<a href='.$taglink.'>'.$tag->name.' </a>';
		}
	}

	$tags = $output . '</span>';
	return $tags . $html;
});


/**
 * Add add_to_cart button for products pages
 */
add_shortcode('products_addToCart_btns', function (){
    $btn = '<button class="class1">Buy</button>';
    return $btn;
});

