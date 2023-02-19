<?php
/*
* Add your own functions here. You can also copy some of the theme functions into this file. 
* Wordpress will use those functions instead of the original functions then.
*/

defined("ABSPATH") || '/' . exit();


/**
 * Hide Page Preview Errors
 */
error_reporting(0);


/* Start Load Scripts */
function load_scripts_styles()
{
  $vn = wp_get_theme()->get('Version');
  // Styles
  if (get_locale() === 'en_US') {
    wp_enqueue_style('child-theme-styles', get_stylesheet_directory_uri() . '/css/main.css', array(), '8.4.8');
    wp_enqueue_style('child-theme-styles-en', get_stylesheet_directory_uri() . '/css/style-ltr.css');
  } elseif (get_locale() === 'fa_IR') {
    wp_enqueue_style('child-theme-styles', get_stylesheet_directory_uri() . '/css/main.css', array(), '8.4.8');
  } else {
    wp_enqueue_style('child-theme-styles', get_stylesheet_directory_uri() . '/css/main.css', array(), '8.4.8');
  }
  // Scripts
  wp_enqueue_script('sweetAlert', get_stylesheet_directory_uri() . '/js/sweetalert2.all.min.js');
  wp_enqueue_script(
    'custom-scripts',
    get_stylesheet_directory_uri() . '/js/custom-scripts.js',
    array('jquery', 'jquery-ui-core'),
    '1.4',
    true
  );
  wp_localize_script('custom-scripts', 'SpaAjax', array(
    'ajaxurl' => admin_url('admin-ajax.php'),
    'security' => wp_create_nonce('(H+MbPeShVmYq3t6'),
    'isEN' => (get_locale() === 'en_US') ? 'en' : 'fa'
  ));
}
add_action('wp_enqueue_scripts', 'load_scripts_styles', 99999999999);


add_filter('script_loader_tag', function ($tag, $handle, $src) {
  $defer = array(
    'sweetAlert',
    'custom-scripts'
  );
  if (in_array($handle, $defer)) {
    return '<script src="' . $src . '" defer="defer" type="text/javascript"></script>' . "\n";
  }

  return $tag;
}, 10, 3);
/* End Load Scripts */


function myaparat($atts)
{
  $id = '';
  extract(shortcode_atts(array(
    'id' => ''
  ), $atts));
  $servertype = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http');

  return "<div><iframe src='" . $servertype . "://www.aparat.com/video/video/embed/videohash/{$id}/vt/frame' width='100%' height='450' allowfullscreen='true' style='border:none!important;margin: 10px;'></iframe></div>";
}
add_shortcode('aparat', 'myaparat');


/**
 * Show products tags
 */
add_shortcode('show_product_tags', 'product_tags');
function product_tags($attr, $content)
{
  $output = array();
  $terms = wp_get_post_terms(get_the_id(), 'product_tag');
  if (count($terms) > 0) {
    foreach ($terms as $term) {
      $term_id = $term->term_id; // Product tag Id
      $term_name = $term->name; // Product tag Name
      $term_slug = $term->slug; // Product tag slug
      $term_link = get_term_link($term, 'product_tag'); // Product tag link
      $output[] = '<a href="' . $term_link . '" class="product-tag">' . $term_name . '</a>';
    }
    // Set the array in a coma separated string of product tags for example
    $output = implode(' ، ', $output);
    // Display the coma separated string of the product tags
    echo '<div class="woo-tags-section" style="line-height: 2;"> <span class="font-weight-bold">برچسب ها: </span> ' . $output . '</div>';
  }
}

/*
 * Replace 'textdomain' with your plugin's textdomain. e.g. 'woocommerce'.
 * File to be named, for example, yourtranslationfile-en_GB.mo
 * File to be placed, for example, wp-content/lanaguages/textdomain/yourtranslationfile-en_GB.mo
 */
add_filter('load_textdomain_mofile', 'load_custom_plugin_translation_file', 10, 2);
function load_custom_plugin_translation_file($mofile, $domain)
{
  if ('textdomain' === $domain) {
    $mofile = WP_LANG_DIR . '/woocommerce/woocommerce-fa_IR-' . get_locale() . '.mo';
  }
  return $mofile;
}

add_filter('get_shortlink', function ($shortlink) {
  return $shortlink;
});


/**
 * Show single post tags
 */
function avs_posts_tag_cb()
{
  global $post;
  $the_tags = get_the_tags($post->ID);
  $output = '<span class="post_tag">';
  foreach ($the_tags as $tag) {
    $taglink = get_tag_link($tag->term_id);
    if (!next($the_tags)) {
      $output .= '<a href=' . $taglink . '>' . $tag->name . ' </a>';
    } else {
      $output .= '<a href=' . $taglink . '>' . $tag->name . ' </a>';
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
function remove_password_strength_meter()
{
  wp_dequeue_script('zxcvbn-async');
  wp_deregister_script('zxcvbn-async');
}


/**
 * Add extra attributes to posts
 */
function gt_get_post_view()
{
  $count = get_post_meta(get_the_ID(), 'post_views_count', true);
  $count = $count != '' ? $count : 0;
  return "$count";
}
function gt_set_post_view()
{
  $key = 'post_views_count';
  $post_id = get_the_ID();
  $count = (int) get_post_meta($post_id, $key, true);
  $count++;
  update_post_meta($post_id, $key, $count);
}
function gt_posts_column_views($columns)
{
  $columns['post_views'] = 'تعداد بازدید';
  return $columns;
}
function gt_posts_custom_column_views($column)
{
  if ($column === 'post_views') {
    echo gt_get_post_view();
  }
}
add_filter('manage_posts_columns', 'gt_posts_column_views');
add_action('manage_posts_custom_column', 'gt_posts_custom_column_views');



/* Disable automatic generation of critical CSS when Optimize CSS Delivery is enabled */
add_filter('do_rocket_critical_css_generation', '__return_false');


/* defer google recaptcha */
function add_defer_attribute($tag, $handle)
{
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


/* Add Taxonomies For Pages */
function add_taxonomies_to_pages()
{
  register_taxonomy_for_object_type('post_tag', 'page');
  register_taxonomy_for_object_type('category', 'page');
}
add_action('init', 'add_taxonomies_to_pages');


/* Increase ppp_nonce_life For Public Post Preview Plugin */
add_filter('ppp_nonce_life', 'my_nonce_life');
function my_nonce_life()
{
  return 60 * 60 * 24 * 15; // 15 days
}

/* modify the breadcrumb’s output */
add_filter('avia_breadcrumbs_trail', 'avia_breadcrumbs_trail_mod', 50, 2);
function avia_breadcrumbs_trail_mod($trail, $args)
{
  if (is_single()) unset($trail[1]);
  return $trail;
}

/* customize wp-login page */
add_action('login_enqueue_scripts', function () {
  wp_enqueue_style('wpl-styles', get_stylesheet_directory_uri()  . '/css/wpl-styles.css');
});
add_filter('login_headerurl', function () {
  return home_url();
});
add_filter('login_headertitle', function () {
  return 'Radshid';
});
add_filter('login_display_language_dropdown', '__return_false');


// eliminate render blocking css
function add_rel_preload($html, $handle, $href, $media)
{
  if (is_admin()) return $html;

  $html = <<<EOT
<link rel='preload' as='style' onload="this.onload=null;this.rel='stylesheet'" id='$handle' href='$href' type='text/css' media='all' />
EOT;
  return $html;
}
add_filter('style_loader_tag', 'add_rel_preload', 10, 4);
