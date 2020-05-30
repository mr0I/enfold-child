<?php

/*
* Add your own functions here. You can also copy some of the theme functions into this file. 
* Wordpress will use those functions instead of the original functions then.
*/


function load_scripts_styles() {
	$vn = wp_get_theme()->get( 'Version' );
	// Styles
	wp_enqueue_style( 'font-awesome',     get_template_directory_uri()."/config-layerslider/LayerSlider/static/font-awesome/css/font-awesome.min.css", $vn, 'all' );
	wp_enqueue_style( 'bootstrap' , get_stylesheet_directory_uri() . '/css/bootstrap.min.css');
	wp_enqueue_style( 'custom-styles' , get_stylesheet_directory_uri() . '/css/custom-styles.css');
	// Scripts
	wp_enqueue_script( 'custom-scripts', get_stylesheet_directory_uri() . '/js/custom-scripts.js', array('jquery'), $vn , true );
}
add_action( 'wp_enqueue_scripts', 'load_scripts_styles');


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

