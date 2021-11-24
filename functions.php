<?php
/*
* Add your own functions here. You can also copy some of the theme functions into this file. 
* Wordpress will use those functions instead of the original functions then.
*/

defined("ABSPATH") || '/' . exit();



/* Start Load Scripts */
function load_scripts_styles() {
  $vn = wp_get_theme()->get( 'Version' );
  // Styles
  wp_enqueue_style( 'child-theme-styles' , get_stylesheet_directory_uri() . '/css/main.css');
  // Scripts
  wp_enqueue_script('sweetAlert', get_stylesheet_directory_uri() .'/js/sweetalert2.all.min.js');
  wp_enqueue_script( 'custom-scripts', get_stylesheet_directory_uri() . '/js/custom-scripts.js', array('jquery','jquery-ui-core'), $vn , true );
  wp_localize_script( 'custom-scripts', 'SpaAjax', array(
	  'ajaxurl' => admin_url( 'admin-ajax.php' ),
	  'security' => wp_create_nonce( '(H+MbPeShVmYq3t6' )
  ));
}
add_action( 'wp_enqueue_scripts', 'load_scripts_styles' , 99999999999);


add_filter( 'script_loader_tag', function ($tag, $handle, $src ){
  $defer = array(
	  'sweetAlert',
	  'custom-scripts'
  );
  if ( in_array( $handle, $defer ) ) {
	return '<script src="' . $src . '" defer="defer" type="text/javascript"></script>' . "\n";
  }

  return $tag;
}, 10, 3 );
/* End Load Scripts */


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
 * Add add_to_cart button for products pages
 */
add_shortcode('products_row_btns', function ($atts, $content = null){
  $pid = 0;
  $type = '';
  extract(shortcode_atts(array(
	  'pid' => 0,
	  'type' => ''
  ), $atts));

  $X1_url = 'https://radshid.com/shop/';
  $X5_url = 'https://radshid.com/Product/shop-car-tracker/%d8%a8%d9%87%d8%aa%d8%b1%db%8c%d9%86-%d8%b1%d8%af%db%8c%d8%a7%d8%a8-%d8%ae%d9%88%d8%af%d8%b1%d9%88-%d8%b1%d8%a7%d8%af%d8%b4%db%8c%d8%af/';
  $Magnet_url = 'https://radshid.com/Product/shop-car-tracker/%d8%ae%d8%b1%db%8c%d8%af-%d8%a7%db%8c%d9%86%d8%aa%d8%b1%d9%86%d8%aa%db%8c-%d8%b1%d8%af%db%8c%d8%a7%d8%a8-%d9%85%da%af%d9%86%d8%aa%db%8c-%d8%b1%d8%a7%d8%af%d8%b4%db%8c%d8%af/';
  $Sipaad_url = 'https://sipaad.ir';
  $X0_url = 'https://radshid.com/Product/shop-car-tracker/%d8%ae%d8%b1%db%8c%d8%af-%d8%a7%db%8c%d9%86%d8%aa%d8%b1%d9%86%d8%aa%db%8c-%d8%b1%d8%af%db%8c%d8%a7%d8%a8-%d9%85%d9%88%d8%aa%d9%88%d8%b1%d8%b3%db%8c%da%a9%d9%84%d8%aa/';
  $PR1S_url = 'https://radshid.com/Product/shop-personal-tracker/%d8%b1%d8%af%db%8c%d8%a7%d8%a8-%d8%b4%d8%ae%d8%b5%db%8c-%d8%a8%d8%a7-%d9%82%d8%a7%d8%a8%d9%84%db%8c%d8%aa-%d9%85%da%a9%d8%a7%d9%84%d9%85%d9%87-%d8%af%d9%88-%d8%b7%d8%b1%d9%81%d9%87/';
  $PR8_url = 'https://radshid.com/Product/shop-car-tracker/%d8%ae%d8%b1%db%8c%d8%af-%d8%a7%db%8c%d9%86%d8%aa%d8%b1%d9%86%d8%aa%db%8c-%d8%b1%d8%af%db%8c%d8%a7%d8%a8-%d8%a2%d9%87%d9%86%d8%b1%d8%a8%d8%a7%db%8c%db%8c-%d8%b1%d8%a7%d8%af%d8%b4%db%8c%d8%af/';
  $PR1_url = 'https://radshid.com/%d8%b1%d8%af%db%8c%d8%a7%d8%a8-%d8%b4%d8%ae%d8%b5%db%8c-%d9%85%d8%af%d9%84-pr1/';
  $PR3_url = 'https://radshid.com/Product/shop-personal-tracker/%d8%b1%d8%af%db%8c%d8%a7%d8%a8-%d9%be%d8%a7%d9%88%d8%b1%d8%a8%d8%a7%d9%86%da%a9%db%8c/';
  switch ($type){
	case 'car':
	  $other_trackers_url = 'https://radshid.com/product-car-tracker/';
	  $OthersBtnText = 'مشاهده سایر ردیاب های خودرو';
	  break;
	case 'personal':
	  $other_trackers_url = 'https://radshid.com/product-personal-tracker/';
	  $OthersBtnText = 'مشاهده سایر ردیاب های شخصی';
	  break;
	case 'tablet':
	  $other_trackers_url = 'https://radshid.com/%d8%a7%d9%86%d9%88%d8%a7%d8%b9-%d8%aa%d8%a8%d9%84%d8%aa-%d9%87%d8%a7%db%8c-%d8%b5%d9%86%d8%b9%d8%aa%db%8c-%d8%b1%d8%a7%d8%af%d8%b4%db%8c%d8%af/';
	  $OthersBtnText = 'مشاهده سایر تبلت های صنعتی';
	  break;
	case 'pda':
	  $other_trackers_url = 'https://radshid.com/%d8%a7%d9%86%d9%88%d8%a7%d8%b9-pda-%d9%87%d8%a7%db%8c-%d8%b5%d9%86%d8%b9%d8%aa%db%8c-%d8%b1%d8%a7%d8%af%d8%b4%db%8c%d8%af/';
	  $OthersBtnText = 'مشاهده سایر pda های صنعتی';
	  break;
	case 'laptop':
	  $other_trackers_url = 'https://radshid.com/%d8%a7%d9%86%d9%88%d8%a7%d8%b9-%d9%84%d9%be-%d8%aa%d8%a7%d9%be-%d9%87%d8%a7%db%8c-%d8%b5%d9%86%d8%b9%d8%aa%db%8c-%d8%b1%d8%a7%d8%af%d8%b4%db%8c%d8%af/';
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
	if (strpos($productUrl , 'sipaad')){
	  $btns = '<div class="addToCart_btns">
                <a href="'.$productUrl.'" class="btn btn-danger mx-1" rel="noopener noreferrer">خرید آنلاین</a>
                <a href="'.$other_trackers_url.'" class="btn btn-danger mx-1">'.$OthersBtnText.'</a>
            </div>';
	} else {
	  $btns = '<div class="addToCart_btns">
                <a href="'.$productUrl.'" class="btn btn-danger mx-1">خرید آنلاین</a>
                <a href="'.$other_trackers_url.'" class="btn btn-danger mx-1">'.$OthersBtnText.'</a>
            </div>';
	}
  }else{
	$btns = '<div class="addToCart_btns">
                <a href="'.$other_trackers_url.'" class="btn btn-danger mx-1">'.$OthersBtnText.'</a>
            </div>';
  }

  return $btns;
});


/* Disable automatic generation of critical CSS when Optimize CSS Delivery is enabled */
add_filter( 'do_rocket_critical_css_generation', '__return_false' );


/* defer google recaptcha */
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


/* Add Taxonomies for Pages */
function add_taxonomies_to_pages() {
  register_taxonomy_for_object_type( 'post_tag', 'page' );
  register_taxonomy_for_object_type( 'category', 'page' );
}
add_action( 'init', 'add_taxonomies_to_pages' );



/*
 *  ========== Start Ajax Requests ==========
 */

// show blog posts
function getCatPosts_callback(){
  global $wpdb;
  $posts_table = $wpdb->prefix . 'posts';
  $postmeta_table = $wpdb->prefix . 'postmeta';
  $users_table = $wpdb->prefix . 'users';
  $term_relationships_table = $wpdb->prefix . 'term_relationships';
  $term_taxonomy_table = $wpdb->prefix . 'term_taxonomy';
  $terms_table = $wpdb->prefix . 'terms';


  $limit = $_POST['limit']; // number of rows in page
  $offset = $_POST['offset'];
  $category_id = $_POST['category_id'];


  $posts = $wpdb->get_results("SELECT p.ID,p.post_title AS title,p.post_excerpt AS excerpt, p.post_date AS date , p.post_name AS slug , pm2.meta_value AS image
                                    ,p.comment_count , u.display_name AS author , tax.term_id AS cat_id
                                FROM $posts_table p 
                                INNER JOIN $postmeta_table pm ON (p.ID = pm.post_id AND pm.meta_key = '_thumbnail_id' AND p.post_status='publish' AND p.post_type='post')
                                INNER JOIN $postmeta_table pm2 ON (pm.meta_value = pm2.post_id AND pm2.meta_key = '_wp_attached_file') 
                                INNER JOIN $users_table u ON (p.post_author = u.ID)
                                LEFT JOIN $term_relationships_table rel ON rel.object_id = p.ID
                                LEFT JOIN $term_taxonomy_table tax ON tax.term_taxonomy_id = rel.term_taxonomy_id
                                LEFT JOIN $terms_table t ON t.term_id = tax.term_id
                                WHERE tax.term_id=$category_id
                                ORDER BY post_date DESC LIMIT $offset,$limit ");


  if (sizeof($posts) !== 0){
	$result['result'] = 'Done';
	$result['posts'] = $posts;
	wp_send_json( $result );
	exit();
  }
}
add_action( 'wp_ajax_getCatPosts', 'getCatPosts_callback' );
add_action( 'wp_ajax_nopriv_getCatPosts', 'getCatPosts_callback' );
/* ========== End Ajax Requests ========== */



//var_dump(get_current_user_id());






