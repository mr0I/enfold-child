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
    <link rel="preload" href="<?php echo get_stylesheet_directory_uri(). '/fonts/micons.woff2' ?>  " as="font" type="font/woff2" crossorigin="anonymous">

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
<div class="custom-header">
    <div class="custom-header-container">
        <ul>
            <li>
                <svg id="i-telephone" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="20" height="20" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <path d="M3 12 C3 5 10 5 16 5 22 5 29 5 29 12 29 20 22 11 22 11 L10 11 C10 11 3 20 3 12 Z M11 14 C11 14 6 19 6 28 L26 28 C26 19 21 14 21 14 L11 14 Z" />
                    <circle cx="16" cy="21" r="4" />
                </svg>
                <span>   واحد بازرگانی  <span class="phoneNumber">03132362894</span> </span>
            </li>
            <li>
                <svg id="i-mobile" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="20" height="20" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                    <path d="M21 2 L11 2 C10 2 9 3 9 4 L9 28 C9 29 10 30 11 30 L21 30 C22 30 23 29 23 28 L23 4 C23 3 22 2 21 2 Z M9 5 L23 5 M9 27 L23 27" />
                </svg>
                <span>   واحد پشتیبانی  <span class="phoneNumber">03195016151</span> </span>
            </li>
<!--            <li id="social_icons">-->
<!--                <a href="https://www.instagram.com/radshid_com/" id="insta" target="_blank" rel="nofollow" title="اینستاگرام"-->
<!--                   data-toggle="tooltip" data-placement="bottom">-->
<!--                    <i class="fa fa-instagram"></i>-->
<!--                </a>-->
<!--                <a href="https://t.me/Radshid_co" id="telegram" target="_blank" rel="nofollow" title="تلگرام"-->
<!--                   data-toggle="tooltip" data-placement="bottom">-->
<!--                    <i class="fa fa-telegram"></i>-->
<!--                </a>-->
<!--            </li>-->
        </ul>

    </div>
</div><div class="progress" id="scroll-bar">
    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
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
		
