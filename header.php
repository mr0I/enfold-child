<?php
if ( ! defined('ABSPATH') ){ die(); }

global $avia_config;

$lightbox_option = avia_get_option( 'lightbox_active' );
$avia_config['use_standard_lightbox'] = empty( $lightbox_option ) || ( 'lightbox_active' == $lightbox_option ) ? 'lightbox_active' : 'disabled';
/**
 * Allow to overwrite the option setting for using the standard lightbox
 * Make sure to return 'disabled' to deactivate the standard lightbox - all checks are done against this string
 *
 * @added_by Günter
 * @since 4.2.6
 * @param string $use_standard_lightbox				'lightbox_active' | 'disabled'
 * @return string									'lightbox_active' | 'disabled'
 */
$avia_config['use_standard_lightbox'] = apply_filters( 'avf_use_standard_lightbox', $avia_config['use_standard_lightbox'] );

$style 					= $avia_config['box_class'];
$responsive				= avia_get_option('responsive_active') != "disabled" ? "responsive" : "fixed_layout";
$blank 					= isset($avia_config['template']) ? $avia_config['template'] : "";
$av_lightbox			= $avia_config['use_standard_lightbox'] != "disabled" ? 'av-default-lightbox' : 'av-custom-lightbox';
$preloader				= avia_get_option('preloader') == "preloader" ? 'av-preloader-active av-preloader-enabled' : 'av-preloader-disabled';
$sidebar_styling 		= avia_get_option('sidebar_styling');
$filterable_classes 	= avia_header_class_filter( avia_header_class_string() );
$av_classes_manually	= "av-no-preview"; /*required for live previews*/

/**
 * Allows to alter default settings Enfold-> Main Menu -> General -> Menu Items for Desktop
 * @since 4.4.2
 */
$is_burger_menu = apply_filters( 'avf_burger_menu_active', avia_is_burger_menu(), 'header' );
$av_classes_manually   .= $is_burger_menu ? " html_burger_menu_active" : " html_text_menu_active";

/**
 * Add additional custom body classes
 * e.g. to disable default image hover effect add av-disable-avia-hover-effect
 *
 * @since 4.4.2
 */
$custom_body_classes = apply_filters( 'avf_custom_body_classes', '' );

/**
 * @since 4.2.3 we support columns in rtl order (before they were ltr only). To be backward comp. with old sites use this filter.
 */
$rtl_support			= 'yes' == apply_filters( 'avf_rtl_column_support', 'yes' ) ? ' rtl_columns ' : '';

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="<?php echo "html_{$style} ".$responsive." ".$preloader." ".$av_lightbox." ".$filterable_classes." ".$av_classes_manually ?> ">
<head>
    <meta name="keywords" content="ردیاب خودرو, ردیاب شخصی , ردیاب موتور سیکلت, ردیاب آهنربایی ,ردیاب کودکان, ردیاب سالمندان,ردیاب پاوربانک, دستگاه شنود,سامانه ردیابی, ردیاب رادشید, خرید اینترنتی ردیاب, فروش اینترنتی ردیاب,خرید تبلت صنعتی, سیپاد">
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="enamad" content="419561"/>

    <?php
	/*
	 * outputs a rel=follow or nofollow tag to circumvent google duplicate content for archives
	 * located in framework/php/function-set-avia-frontend.php
	 */
	if (function_exists('avia_set_follow')) { echo avia_set_follow(); }

	?>


    <!-- mobile setting -->
	<?php

	if( strpos($responsive, 'responsive') !== false ) { echo '<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">';  }
	?>


    <!-- Scripts/CSS and wp_head hook -->
	<?php
	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */

	wp_head();

	?>

</head>




<body id="top" <?php body_class( $custom_body_classes . ' ' . $rtl_support . $style." ".$avia_config['font_stack']." ".$blank." ".$sidebar_styling); avia_markup_helper(array('context' => 'body')); ?>>



<!-- Custom Code -->
<div class="progress" id="scroll-bar">
    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
</div>
<div class="custom-header">
    <div class="custom-header-container">
        <ul>
            <li>
                <svg id="i-telephone" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="20" height="20" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <path d="M3 12 C3 5 10 5 16 5 22 5 29 5 29 12 29 20 22 11 22 11 L10 11 C10 11 3 20 3 12 Z M11 14 C11 14 6 19 6 28 L26 28 C26 19 21 14 21 14 L11 14 Z" />
                    <circle cx="16" cy="21" r="4" />
                </svg>
                <span>   واحد بازرگانی:  <span style="font-family: 'vazir';">03132362894</span> </span>
            </li>
            <li>
                <svg id="i-mobile" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="20" height="20" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <path d="M21 2 L11 2 C10 2 9 3 9 4 L9 28 C9 29 10 30 11 30 L21 30 C22 30 23 29 23 28 L23 4 C23 3 22 2 21 2 Z M9 5 L23 5 M9 27 L23 27" />
                </svg>
                <span>   واحد پشتیبانی:  <span style="font-family: 'vazir';">03195016151</span> </span>
            </li>
            <li id="social_icons">
                <a href="https://www.instagram.com/radshid_com/" id="insta" target="_blank" rel="nofollow" title="اینستاگرام"
                   data-toggle="tooltip" data-placement="bottom">
                    <i class="fa fa-instagram"></i>
<!--                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>-->
                </a>
                <a href="https://t.me/Radshid_co" id="telegram" target="_blank" rel="nofollow" title="تلگرام"
                   data-toggle="tooltip" data-placement="bottom">
                    <i class="fa fa-telegram"></i>
                </a>
            </li>
        </ul>

    </div>
</div>
<!-- Custom Code -->


<?php

/**
 * WP 5.2 add a new function - stay backwards compatible with older WP versions and support plugins that use this hook
 * https://make.wordpress.org/themes/2019/03/29/addition-of-new-wp_body_open-hook/
 *
 * @since 4.5.6
 */
if( function_exists( 'wp_body_open' ) )
{
	wp_body_open();
}
else
{
	do_action( 'wp_body_open' );
}

do_action( 'ava_after_body_opening_tag' );

if("av-preloader-active av-preloader-enabled" === $preloader)
{
	echo avia_preload_screen();
}

?>

<div id='wrap_all'>

	<?php
	if(!$blank) //blank templates dont display header nor footer
	{
		//fetch the template file that holds the main menu, located in includes/helper-menu-main.php
		get_template_part( 'includes/helper', 'main-menu' );

	} ?>

    <div id='main' class='all_colors' data-scroll-offset='<?php echo avia_header_setting('header_scroll_offset'); ?>'>

<?php

if(isset($avia_config['temp_logo_container'])) echo $avia_config['temp_logo_container'];
do_action('ava_after_main_container');
		
