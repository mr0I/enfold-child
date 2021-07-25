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
                    <span class="post_views_count"><i class="ic-eye mx-1 float-right"></i>تعداد بازدید: '.$pvc.' </span>
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
		//get the tags of the current post
		$the_tags = get_the_tags( $post->ID );
		$output = '<span class="post_tag">';
		$tag_array = [];
		foreach($the_tags as  $key2 => $tag) {
			$taglink = get_tag_link($tag->term_id);
			if(!next($the_tags)) {
				$output .= '<a href='.$taglink.'>'.$tag->name.' </a>';
			}else{
				$output .= '<a href='.$taglink.'>'.$tag->name.' </a>';
			}
			$tag_array[ $key2 ] = $tag->slug;
		}
		//get the categories of the current post
		$cats = get_the_category( $post->ID );
		$cat_array = array();
		foreach ( $cats as $key1 => $cat ) {
			$cat_array[ $key1 ] = $cat->slug;
		}
		$related_posts = new WP_Query(
			array(
				'post_type' => 'post',
				'post_status' => 'publish',
				'tax_query' => array(
					'relation' => 'OR',
					array(
						'taxonomy' => 'category',
						'field' => 'slug',
						'terms' => $cat_array
					),
					array(
						'taxonomy' => 'post_tag',
						'field' => 'slug',
						'terms' => $tag_array
					)
				),
				'posts_per_page' => 3,
				'post__not_in' => array( $post->ID ),
				'orderby' => array( 'title' => 'ASC', 'date' => 'DESC' )
			)
		);

		$html = '<div class="single_post_share_btns">
            <div class="single_post_share_btns_container">
                <div class="share_link col-lg-8 col-md-8 col-sm-12" onclick="copyToClip(event)">
                     <span><i class="ic-copy mx-2"></i>لینک به اشتراک گذاری</span>
                    <span>'.$postUrl.'</span>
                </div>
                 <ul>
                    <li class="icons ln"> <a href="https://www.linkedin.com/shareArticle?mini=true&amp;url='.$fullUrl.'" rel="nofollow" target="_blank" data-toggle="tooltip" data-placement="top" title="اشتراک در لینکدین"> <i class="ic-linkedin"></i> </a> </li>
                    <li class="icons wa"><a href="https://wa.me/?text='.$fullUrl.'" rel="nofollow" target="_blank" data-toggle="tooltip" data-placement="top" title="اشتراک در واتساپ"><i class="ic-whatsapp"></i></a></li>
                    <li class="icons tl"><a href="https://telegram.me/share/url?url='.$fullUrl.'" rel="nofollow" target="_blank" data-toggle="tooltip" data-placement="top" title="اشتراک در تلگرام"><i class="ic-telegram"></i></a></li>
                    <li class="icons tw"><a href="https://twitter.com/share?url='.$fullUrl.'" rel="nofollow" target="_blank" data-toggle="tooltip" data-placement="top" title="اشتراک در توییتر"><i class="ic-twitter"></i></a></li>
                    <li class="icons fb"><a href="https://www.facebook.com/sharer/sharer.php?u='.$fullUrl.'" rel="nofollow" target="_blank" data-toggle="tooltip" data-placement="top" title="اشتراک در فیسبوک"><i class="ic-facebook"></i></a></li>
                </ul>
                <input type="hidden" id="short_link" value="'.$postUrl.'">
            </div>
        </div>';

		$rps = '<h4 class="related-posts-title">شاید از این مقالات هم خوشتان بیاید</h4><div class="card-group related-posts mb-5">';
		if ( $related_posts->have_posts() ) {
			while ( $related_posts->have_posts() ) {
				$related_posts->the_post();
				if ( has_post_thumbnail( $post->ID ) ) $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'small' );
				$rps .= '<div class="card"><a href="'.get_the_permalink().'"><img class="card-img-top" src="'.$image[0].'" alt="Card image cap"></a>';
				$rps .= '<div class="card-body"><a href="'.get_the_permalink().'"><h5 class="card-title">'.get_the_title().'</h5></a>';
				$postContent = str_replace('"' , '' , wp_trim_words(get_post($post->ID)->post_excerpt , 30));
				$rps .= '<p class="card-text">'.$postContent.'</p></div>';
				$rps .= '<div class="card-footer"><small class="text-muted">'.do_shortcode('[rt_reading_time label="خواندن: " postfix="دقیقه" postfix_singular="دقیقه"]') .'</small></div>';
				$rps .= '</div>';
			}
			$rps .= '</div>';
			wp_reset_postdata();
		}
	}


	$tags = $output . '</span>';
	return $tags . $html . $rps;
});


/**
 * Add add_to_cart button for products pages
 */
add_shortcode('products_row_btns', function ($atts, $content = null){
	$pid = 0;
	$type = '';
	extract(shortcode_atts(array(
		'pid' => 0,
		'type' => ''
	), $atts));

	$X1_url = 'https://radshid.com/shop';
	$X5_url = 'https://radshid.com/?p=11720';
	$Magnet_url = 'https://radshid.com/?p=13574';
	$Sipaad_url = 'https://radshid.com/?p=14049';
	$X0_url = 'https://radshid.com/?p=10216';
	$PR1S_url = 'https://radshid.com/?p=15129';
	$PR8_url = 'https://radshid.com/?p=10285';
	$PR1_url = 'https://radshid.com/?p=12161';
	$PR3_url = 'https://radshid.com/?p=10313';
	switch ($type){
		case 'car':
			$other_trackers_url = 'https://radshid.com/?p=12762';
			$OthersBtnText = 'مشاهده سایر ردیاب های خودرو';
			break;
		case 'personal':
			$other_trackers_url = 'https://radshid.com/?p=12732';
			$OthersBtnText = 'مشاهده سایر ردیاب های شخصی';
			break;
		case 'tablet':
			$other_trackers_url = 'https://radshid.com/?p=12783';
			$OthersBtnText = 'مشاهده سایر تبلت های صنعتی';
			break;
		case 'pda':
			$other_trackers_url = 'https://radshid.com/?p=12775';
			$OthersBtnText = 'مشاهده سایر pda های صنعتی';
			break;
		case 'laptop':
			$other_trackers_url = 'https://radshid.com/?p=12769';
			$OthersBtnText = 'مشاهده سایر لپ تاپ های صنعتی';
			break;
		default:
			$other_trackers_url = '#';
			$OthersBtnText = '';
	}
	switch ($pid){
		case 15129:
			$productUrl = $PR1S_url;
			break;
		case 3733:
			$productUrl = $X1_url;
			break;
		case 11720:
			$productUrl = $X5_url;
			break;
		case 13574:
			$productUrl = $Magnet_url;
			break;
		case 14049:
			$productUrl = $Sipaad_url;
			break;
		case 10216:
			$productUrl = $X0_url;
			break;
		case 10285:
			$productUrl = $PR8_url;
			break;
		case 12161:
			$productUrl = $PR1_url;
			break;
		case 10313:
			$productUrl = $PR3_url;
			break;
		default:
			$productUrl = '#';
	}

	if ($pid != ''){
		$btns = '<div class="addToCart_btns">
                <a href="'.$productUrl.'" class="btn btn-danger mx-1">خرید آنلاین</a>
                <a href="'.$other_trackers_url.'" class="btn btn-danger mx-1">'.$OthersBtnText.'</a>
            </div>';
	}else{
		$btns = '<div class="addToCart_btns">
                <a href="'.$other_trackers_url.'" class="btn btn-danger mx-1">'.$OthersBtnText.'</a>
            </div>';
	}

	return $btns;
});


/* Disable automatic generation of critical CSS when Optimize CSS Delivery is enabled */
add_filter( 'do_rocket_critical_css_generation', '__return_false' );


function add_defer_attribute($tag, $handle) {
	switch ($handle) {
		case 'google.recaptcha':
			return str_replace(' src', ' defer="defer" src', $tag);
			break;
		case 'google.recaptcha.frontend':
			return str_replace(' src', ' defer="defer" src', $tag);
			break;
	}
	return $tag;
}


/*
Plugin Name: Remove Email Field
Description: Removes the Email field from the comments form
*/
//add_filter('comment_form_default_fields', 'url_filtered');
//function url_filtered($fields)
//{
//	if(isset($fields['email']))
//		unset($fields['email']);
//	return $fields;
//}

/* Start Recaptcha */
//function add_google_recaptcha($submit_field) {
//	$submit_field['submit_field'] = '<div class="g-recaptcha" data-sitekey="6LfZS6gZAAAAAC5BMOsbcNQYDqtQm6puHeUmjlid"></div><br>' . $submit_field['submit_field'];
//	return $submit_field;
//}
//if (!is_user_logged_in()) {
//	add_filter('comment_form_defaults','add_google_recaptcha');
//}
//function is_valid_captcha($captcha) {
//	$captcha_postdata = http_build_query(array(
//		'secret' => '6LfZS6gZAAAAAKtbN3kOXbdrjyZZcKUwt8ondcKE',
//		'response' => $captcha,
//		'remoteip' => $_SERVER['REMOTE_ADDR']));
//	$captcha_opts = array('http' => array(
//		'method'  => 'POST',
//		'header'  => 'Content-type: application/x-www-form-urlencoded',
//		'content' => $captcha_postdata));
//	$captcha_context  = stream_context_create($captcha_opts);
//	$captcha_response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify" , false , $captcha_context), true);
//	if ($captcha_response['success'])
//		return true;
//	else
//		return false;
//}
//function verify_google_recaptcha() {
//	$recaptcha = $_POST['g-recaptcha-response'];
//	if (empty($recaptcha))
//		wp_die( __("<b>خطا:</b>لطفا کد امنیتی را تایید کنید!<p><a href='javascript:history.back()'>« بازگشت</a></p>"));
//	else if (!is_valid_captcha($recaptcha))
//		wp_die( __("<b>Go away Spammer!</b>"));
//}
//if (!is_user_logged_in()) {
//	add_action('pre_comment_on_post', 'verify_google_recaptcha');
//}
/* End Recaptcha */


/*
** Show message after comment
*/
add_action( 'set_comment_cookies', function( $comment, $user ) {
	setcookie( 'ta_comment_wait_approval', '1' );
}, 10, 2 );
add_action( 'init', function() {
	if( $_COOKIE['ta_comment_wait_approval'] === '1' ) {
		setcookie( 'ta_comment_wait_approval', null, time() - 3600, '/' );
		add_action( 'comment_form_before', function() {
			echo '<script type="text/javascript"> const TopToast = Swal.mixin({toast: true, position: "bottom-start", showConfirmButton: false, timer: 3500, background: "#1c272b", timerProgressBar: true, didOpen: (toast) => {toast.addEventListener("mouseenter", Swal.stopTimer);toast.addEventListener("mouseleave", Swal.resumeTimer)}});TopToast.fire({ icon: "success", title: "نظر شما ثبت شد و پس از تایید نمایش داده می شود." });</script>';
		});
	}
});
add_filter( 'comment_post_redirect', function( $location, $comment ) {
	$location = get_permalink( $comment->comment_post_ID ) . '#wait_approval';
	return $location;
}, 10, 2 );