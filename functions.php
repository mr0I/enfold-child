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
 * Show product tags
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
		echo '<div class="woo-tags-section" style="line-height: 2;"> برچسب ها: ' . $output . '</div>';
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
	return 'برچسب ها: ' . $output . '</span>';
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

