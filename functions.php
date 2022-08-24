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
  if (get_locale() === 'en_US'){
	wp_enqueue_style( 'child-theme-styles' , get_stylesheet_directory_uri() . '/css/main.css' , array() , '8.4.3');
	wp_enqueue_style( 'child-theme-styles-en' , get_stylesheet_directory_uri() . '/css/style-ltr.css');
  } elseif (get_locale() === 'fa_IR'){
	wp_enqueue_style( 'child-theme-styles' , get_stylesheet_directory_uri() . '/css/main.css' , array() , '8.4.3');
  } else {
	wp_enqueue_style( 'child-theme-styles' , get_stylesheet_directory_uri() . '/css/main.css' , array() , '8.4.3');
  }
  // Scripts
  wp_enqueue_script('sweetAlert', get_stylesheet_directory_uri() .'/js/sweetalert2.all.min.js');
  wp_enqueue_script( 'custom-scripts', get_stylesheet_directory_uri() . '/js/custom-scripts.js', array('jquery','jquery-ui-core'), $vn , true );
  wp_localize_script( 'custom-scripts', 'SpaAjax', array(
	  'ajaxurl' => admin_url( 'admin-ajax.php' ),
	  'security' => wp_create_nonce( '(H+MbPeShVmYq3t6' ),
	  'isEN' => (get_locale() === 'en_US') ? 'en' : 'fa'
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
  $id = '';
  extract( shortcode_atts( array(
	  'id' => ''
  ), $atts ) );
  $servertype = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http');

  return "<div><iframe src='".$servertype."://www.aparat.com/video/video/embed/videohash/{$id}/vt/frame' width='100%' height='450' allowfullscreen='true' style='border:none!important;margin: 10px;'></iframe></div>";
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

  if ( ! session_id() ) session_start();
});
add_filter( 'comment_post_redirect', function( $location, $comment ) {
  $location = get_permalink( $comment->comment_post_ID ) . '#wait_approval';
  return $location;
}, 10, 2 );


/* Add Taxonomies For Pages */
function add_taxonomies_to_pages() {
  register_taxonomy_for_object_type( 'post_tag', 'page' );
  register_taxonomy_for_object_type( 'category', 'page' );
}
add_action( 'init', 'add_taxonomies_to_pages' );


/* Increase ppp_nonce_life For Public Post Preview Plugin */
add_filter( 'ppp_nonce_life', 'my_nonce_life' );
function my_nonce_life() {
  return 60 * 60 * 24 * 15; // 15 days
}

/* modify the breadcrumb’s output */
add_filter( 'avia_breadcrumbs_trail', 'avia_breadcrumbs_trail_mod', 50, 2 );
function avia_breadcrumbs_trail_mod( $trail, $args ) {
  if ( is_single() ) unset($trail[1]);
  return $trail;
}

/* customize wp-login page */
add_action( 'login_enqueue_scripts', function (){
    wp_enqueue_style ( 'wpl-styles', get_stylesheet_directory_uri()  . '/css/wpl-styles.css' );
});
add_filter( 'login_headerurl', function (){
    return home_url();
});
add_filter( 'login_headertitle', function (){
    return 'Radshid';
});
add_filter( 'login_display_language_dropdown', '__return_false' );


/* disable featured image auto cropping */
if (function_exists('add_theme_support')){
  add_theme_support('post-thumbnails');
  set_post_thumbnail_size(150, 150, true);
  add_image_size('single_thumb', 1024, 1024, false);
}

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


