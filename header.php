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
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-59846784-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-59846784-2');
    </script>


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
<!--<div class="custom-header">-->
<!--    <div class="custom-header-container">-->
<!--        <ul>-->
<!--            <li><span>   واحد بازرگانی  <a href="tel:03132362894" class="phoneNumber">03132362894</a> </span></li>-->
<!--            <li><span>   واحد پشتیبانی  <a href="tel:03195016151" class="phoneNumber">03195016151</a> </span></li>-->
<!--        </ul>-->
<!--    </div>-->
<!--</div>-->

<div class="progress" id="scroll-bar">
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
		
