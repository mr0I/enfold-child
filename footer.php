<?php

if ( ! defined( 'ABSPATH' ) ) {  exit;  }    // Exit if accessed directly


do_action( 'ava_before_footer' );

global $avia_config;
$blank = isset($avia_config['template']) ? $avia_config['template'] : "";

//reset wordpress query in case we modified it
wp_reset_query();


//get footer display settings
$the_id 				= avia_get_the_id(); //use avia get the id instead of default get id. prevents notice on 404 pages
$footer 				= get_post_meta( $the_id, 'footer', true );
$footer_options			= avia_get_option( 'display_widgets_socket', 'all' );

//get link to previous and next post/portfolio entry
$avia_post_nav = avia_post_nav();

/**
 * Reset individual page override to defaults if widget or page settings are different (user might have changed theme options)
 * (if user wants a page as footer he must select this in main options - on individual page it's only possible to hide the page)
 */
if( false !== strpos( $footer_options, 'page' ) )
{
	/**
	 * User selected a page as footer in main options
	 */
	if( ! in_array( $footer, array( 'page_in_footer_socket', 'page_in_footer', 'nofooterarea' ) ) )
	{
		$footer = '';
	}
}
else
{
	/**
	 * User selected a widget based footer in main options
	 */
	if( in_array( $footer, array( 'page_in_footer_socket', 'page_in_footer' ) ) )
	{
		$footer = '';
	}
}

$footer_widget_setting 	= ! empty( $footer ) ? $footer : $footer_options;

/*
 * Check if we should display a page content as footer
 */
if( ! $blank && in_array( $footer_widget_setting, array( 'page_in_footer_socket', 'page_in_footer' ) ) )
{
	/**
	 * Allows 3rd parties to change page id's, e.g. translation plugins
	 */
	$post = AviaCustomPages()->get_custom_page_object( 'footer_page', '' );

	if( ( $post instanceof WP_Post ) && ( $post->ID != $the_id ) )
	{
		/**
		 * Make sure that footerpage is set to fullwidth
		 */
		$old_avia_config = $avia_config;

		$avia_config['layout']['current'] = array(
			'content'	=> 'av-content-full alpha',
			'sidebar'	=> 'hidden',
			'meta'		=> '',
			'entry'		=> '',
			'main'		=> 'fullsize'
		);

		$builder_stat = ( 'active' == Avia_Builder()->get_alb_builder_status( $post->ID ) );
		$avia_config['conditionals']['is_builder'] = $builder_stat;
		$avia_config['conditionals']['is_builder_template'] = $builder_stat;

		/**
		 * @used_by			config-bbpress\config.php
		 * @since 4.5.6.1
		 * @param WP_Post $post
		 * @param int $the_id
		 */
		do_action( 'ava_before_page_in_footer_compile', $post, $the_id );

		$content = Avia_Builder()->compile_post_content( $post );

		$avia_config = $old_avia_config;

		/* was removed in 4.2.7 before rollout - should not break the output - can be removed completly when no errors are reported !
		 *		<div class='container_wrap footer_color footer-page-content' id='footer'>
		 */
		echo $content;
	}
}

/**
 * Check if we should display a footer
 */
if( ! $blank && $footer_widget_setting != 'nofooterarea' )
{
	if( in_array( $footer_widget_setting, array( 'all', 'nosocket' ) ) )
	{
		//get columns
		$columns = avia_get_option('footer_columns');
		?>
        <div class='container_wrap footer_color' id='footer'>

            <div class='container'>

				<?php
				do_action('avia_before_footer_columns');

				//create the footer columns by iterating

				switch($columns)
				{
					case 1: $class = ''; break;
					case 2: $class = 'av_one_half'; break;
					case 3: $class = 'av_one_third'; break;
					case 4: $class = 'av_one_fourth'; break;
					case 5: $class = 'av_one_fifth'; break;
					case 6: $class = 'av_one_sixth'; break;
					default: $class = ''; break;
				}

				$firstCol = "first el_before_{$class}";

				//display the footer widget that was defined at appearenace->widgets in the wordpress backend
				//if no widget is defined display a dummy widget, located at the bottom of includes/register-widget-area.php
				for ($i = 1; $i <= $columns; $i++)
				{
					$class2 = ""; // initialized to avoid php notices
					if($i != 1) $class2 = " el_after_{$class}  el_before_{$class}";
					echo "<div class='flex_column {$class} {$class2} {$firstCol}'>";
					if (function_exists('dynamic_sidebar') && dynamic_sidebar('Footer - column'.$i) ) : else : avia_dummy_widget($i); endif;
					echo "</div>";
					$firstCol = "";
				}

				do_action('avia_after_footer_columns');

				?>

            </div>


            <!-- ####### END FOOTER CONTAINER ####### -->
        </div>


	<?php   } //endif   array( 'all', 'nosocket' ) ?>



    <!-- custom footer -->
    <div id="custom-footer">
        <div class="first-row">
            <div class="container-fluid">
                <div class="row m-0">
                    <div class="fr-element col-lg-3 col-md-3 col-6">
                        <figure>
                            <img src="<?php echo get_stylesheet_directory_uri(). '/images/express.png' ; ?>" width="60" height="60" alt="تحویل اکسپرس">
                            <p><span>تحویل اکسپرس</span></p>
                        </figure>
                    </div>
                    <div class="fr-element col-lg-3 col-md-3 col-6">
                        <figure>
                            <img src="<?php echo get_stylesheet_directory_uri(). '/images/backup.png' ; ?>" width="60" height="60" alt="پشتیبانی 24 ساعته">
                            <p><span>پشتیبانی و مشاوره رایگان</span></p>
                        </figure>
                    </div>
                    <div class="fr-element col-lg-3 col-md-3 col-6">
                        <figure>
                            <img src="<?php echo get_stylesheet_directory_uri(). '/images/cash-in-place.png' ; ?>" width="60" height="60" alt="پرداخت در محل"
                            >
                            <p><span>پرداخت در محل</span></p>
                        </figure>
                    </div>
                    <div class="fr-element col-lg-3 col-md-3 col-6">
                        <figure>
                            <img src="<?php echo get_stylesheet_directory_uri(). '/images/guarantee.png' ; ?>" width="60" height="60"
                                 alt="1 سال گارانتی - 5 سال خدمات پس از فروش " >
                            <p><span>1 سال گارانتی</span></p>
                            <p><span> 5 سال خدمات پس از فروش </span></p>
                        </figure>
                    </div>
                </div>
            </div>
        </div>
        <div class="third-row">
            <div class="container-fluid">
                <div class="row" style="width: 94%;margin: 0 auto;">
                    <div class="tr-element col-12">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <p class="threeWords title">آدرس دفتر مرکزی</p>
                                <p>
                                <span>اصفهان – خیابان کاشانی – ابتدای خیابان صاحب روضات – نبش کوچه شماره 3 – پلاک 33       ساعات کار:       8:30 الی 17</span>
                                <br>
                                    <span> کد پستی: <span>8183877113</span></span>
                                </p>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <p class="twoWords title">آدرس کارخانه</p>
                                <p><span>نجف آباد – شهرک صنعتی شماره 2 – خیابان ابوریحان – شرکت رادشید</span></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <p class="twoWords title">واحد بازرگانی</p>
                                <ul style="display: flex;flex-flow: row wrap;margin: 5px auto;padding: 0;">
                                    <li class="col-6 farsi_num"><a href="tel:03132362894">03132362894</a></li>
                                    <li class="col-6 farsi_num"><a href="tel:03132362947">03132362947</a></li>
                                    <li class="col-6 farsi_num"><a href="tel:09124735787">09124735787</a></li>
                                    <li class="col-6 farsi_num"><a href="tel:09124839402">09124839402</a></li>
                                </ul>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <p class="twoWords title">واحد پشتیبانی</p>
                                <ul id="support_unit" style="display: flex;flex-flow: row wrap;margin: 5px auto;padding: 0;">
                                    <li class="col-lg-4 col-md-4 col-sm-6 farsi_num"><a href="tel:03195016151">03195016151</a></li>
                                    <li class="col-lg-4 col-md-4 col-sm-6 farsi_num"><a href="tel:03132363078">03132363078</a></li>
                                    <li class="col-lg-4 col-md-4 col-sm-6 farsi_num"><a href="tel:09018377198">09018377198</a></li>
                                    <li class="col-lg-4 col-md-4 col-sm-6 farsi_num"><a href="tel:09018377021">09018377021</a></li>
                                    <li class="col-lg-4 col-md-4 col-sm-6 farsi_num"><a href="tel:09901883981">09901883981</a></li>
                                </ul>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <p class="oneWord title"> فکس </p>
                                <ul style="display: flex;flex-flow: row wrap;margin: 5px auto;padding: 0;">
                                    <li class="col-12"><span class="farsi_num">03132362788</span> (داخلی 23)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="second-row">
            <div class="container-fluid">
                <div class="row" style="width: 94%;margin: 0 auto;border-bottom: 1px solid #bdbdbd">
                    <div class="sr-element col-md-4 col-sm-12">
                        <p class="twoWords title">با رادشید</p>
                        <ul style="display: flex;flex-flow: row wrap">
                            <li class="col-6"><a href="https://radshid.com/%d8%aa%d9%85%d8%a7%d8%b3-%d8%a8%d8%a7-%d9%85%d8%a7/">تماس با رادشید</a></li>
                            <li class="col-6"><a href="https://radshid.com/%d8%af%d8%b1%d8%a8%d8%a7%d8%b1%d9%87-%d9%85%d8%a7/">درباره رادشید</a></li>
                            <li class="col-6"><a href="https://radshid.com/%d8%af%d8%b1%d8%ae%d9%88%d8%a7%d8%b3%d8%aa-%d9%86%d9%85%d8%a7%db%8c%d9%86%d8%af%da%af%db%8c/">دریافت نمایندگی</a></li>
                            <li class="col-6"><a href="https://radshid.com/%d9%87%d9%85%da%a9%d8%a7%d8%b1%db%8c-%d8%a8%d8%a7-%d8%b1%d8%a7%d8%af%d8%b4%db%8c%d8%af/">استخدام در رادشید</a></li>
                        </ul>
                    </div>
                    <div class="sr-element col-md-4 col-sm-12">
                        <p class="fourWords title">راهنمای خرید از رادشید</p>
                        <ul style="display: flex;flex-flow: row wrap">
                            <li class="col-6"><a href="https://radshid.com/%d9%86%d8%ad%d9%88%d9%87-%d8%ab%d8%a8%d8%aa-%d8%b3%d9%81%d8%a7%d8%b1%d8%b4/">نحوه ثبت سفارش</a></li>
                            <li class="col-6"><a href="https://radshid.com/%d8%b4%db%8c%d9%88%d9%87-%d9%87%d8%a7%db%8c-%d9%be%d8%b1%d8%af%d8%a7%d8%ae%d8%aa/">شیوه های پرداخت</a></li>
                            <li class="col-6"><a href="https://radshid.com/%d8%b4%db%8c%d9%88%d9%87-%d9%87%d8%a7%db%8c-%d8%a7%d8%b1%d8%b3%d8%a7%d9%84/">شیوه های ارسال</a></li>
                            <li class="col-6"><a href="https://radshid.com/%d8%ae%d8%af%d9%85%d8%a7%d8%aa-%d9%be%d8%b3-%d8%a7%d8%b2-%d9%81%d8%b1%d9%88%d8%b4/">خدمات پس از فروش</a></li>
                        </ul>
                    </div>
                    <div class="sr-element col-md-4 col-sm-12" style="margin-top: 30px;">
                        <div id="gateway">
                            <a>
                                <figure>
                                    <img src="<?php echo get_stylesheet_directory_uri().'/images/mellat_gateway.jpg' ; ?>" width="70" height="70" alt="درگاه پرداخت ملت" id="mellat_img">
                                </figure>
                            </a>
                            <a referrerpolicy="origin" target="_blank" href="https://trustseal.enamad.ir/?id=179501&amp;Code=FhjbxasmXXMZd5Y5vKZc">
                                <figure>
                                    <img referrerpolicy="origin" src="<?php echo get_stylesheet_directory_uri().'/images/star1.jpg' ; ?>" width="70" height="70" alt="" style="cursor:pointer" id="FhjbxasmXXMZd5Y5vKZc">
                                </figure>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="fourth-row">
            <div class="mt-1">
                <div class="fourth-row-container">
                    <div class="copyrightText" style="user-select: none;">
                        <span>تمامی حقوق این سایت متعلق به شرکت مهندسی رادشید است.</span>
                    </div>
                    <div class="social-icons">
                        <a href="https://t.me/Radshid_co" id="telegram" target="_blank" data-toggle="tooltip" data-placement="top" title="تلگرام" >
                            <i class="ic-telegram1"></i>
                        </a>
                        <a href="https://www.instagram.com/radshid_com/" id="insta" target="_blank" data-toggle="tooltip" data-placement="top" title="اینستاگرام">
                            <i class="ic-instagram"></i>
                        </a>
                        <a href="https://www.aparat.com/radshid" id="aparat" target="_blank" data-toggle="tooltip" data-placement="top" title="آپارات">
                            <i class="ic-aparat"></i>
                        </a>
                        <a href="http://rx4.ir/android" target="_blank" rel="nofollow" data-toggle="tooltip" data-placement="top" title="برنامه ردیابی رادشید (اندروید)">
                            <i class="ic-android"></i>
                        </a>
                        <a href="http://rx4.ir/ios" target="_blank" rel="nofollow" data-toggle="tooltip" data-placement="top" title="برنامه ردیابی رادشید (ios)">
                            <i class="ic-apple"></i>
                        </a>
                        <a href="tg://resolve?domain=radshid_bot" target="_blank" rel="nofollow" data-toggle="tooltip" data-placement="top" title="ربات تلگرام رادشید">
                            <i class="ic-probot"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- custom footer -->

    <!-- custom code -->

    <!-- Floated Action Button -->
    <div class="fab-wrapper">
        <input id="fabCheckbox" type="checkbox" class="fab-checkbox" />
        <label class="fab" for="fabCheckbox">
            <span class="fab-dots fab-dots-1"></span>
            <span class="fab-dots fab-dots-2"></span>
            <span class="fab-dots fab-dots-3"></span>
        </label>
        <div class="fab-wheel">
            <a class="fab-action fab-action-1" href="tel:03132362894" title="تماس با واحد بازرگانی">
                <i class="ic-headset_mic"></i>
            </a>

            <a class="fab-action fab-action-2" href="tel:03195016151" title="تماس با واحد پشتیبانی">
                <i class="ic-phone1"></i>
            </a>
        </div>
    </div>
    <!-- Floated Action Button -->


    <!-- Notification bar -->
    <?php if(get_option('RADtools_setting_notifbanner_switch' , '') === '1'){ ?>
    <div class="notif_banner_container">
            <div class="rightSide">
                <figure class="banner_logo">
                    <img src="<?php echo RAD_ASSETS . '/images/notices_banner/radassistant.png' ; ?>"
                         width="80" height="80" alt="banner_logo">
                </figure>
            </div>
            <div class="leftSide">
                <div class="banner_title">
                    <p><?php esc_attr_e(get_option('RADtools_setting_notifbanner_title' , '')); ?></p>
                </div>
                <div class="banner_desc">
                    <p><?php esc_attr_e(get_option('RADtools_setting_notifbanner_desc' , '')) ?></p>
                </div>
                <div class="banner_buttons">
                    <a href="https://cafebazaar.ir/app/com.radshid.radassistant" id="banner_btn1" target="_blank">
                        <img src="<?php echo get_stylesheet_directory_uri().'/images/bazaar.png' ; ?>" alt="bazaar">
                        دریافت از کافه بازار
                    </a>
                    <a href="https://myket.ir/app/com.radshid.radassistant" id="banner_btn2" target="_blank">
                        <img src="<?php echo get_stylesheet_directory_uri().'/images/myket.png' ; ?>" alt="bazaar">
                        دریافت از مایکت
                    </a>
                </div>
            </div>
        <button class="notif_close"><i class="ic-close"></i></button>
    </div>
        <?php } ?>
    <!--Notification bar -->


    <!-- floated icons -->

    <div class="floated_icons_footer">
        <div class="fif-container">
            <a href="https://radshid.com/my-account" title="ورود به سایت">
                <i class="ic-user"></i><span>ورود/ثبت نام</span>
            </a>
            <a href="<?= get_permalink( woocommerce_get_page_id( 'shop' ) ) ?>" title="فروشگاه">
                <i class="ic-shopping-bag"></i><span>لیست قیمت ردیاب</span>
            </a>
            <a href="https://radshid.com/Product/shop-personal-tracker/%d8%b1%d8%af%db%8c%d8%a7%d8%a8-%d8%b4%d8%ae%d8%b5%db%8c-%d8%a8%d8%a7-%d9%82%d8%a7%d8%a8%d9%84%db%8c%d8%aa-%d9%85%da%a9%d8%a7%d9%84%d9%85%d9%87-%d8%af%d9%88-%d8%b7%d8%b1%d9%81%d9%87/" title="ردیاب مناسب شما" target="_blank">
                <i class="ic-pin"></i><span>ردیاب مناسب شما</span>
            </a>
        </div>
    </div>
    <!-- floated icons -->
    <!-- custom code -->



	<?php

	//copyright
	$copyright = do_shortcode( avia_get_option( 'copyright', "&copy; ".__('Copyright','avia_framework')."  - <a href='".home_url('/')."'>".get_bloginfo('name')."</a>") );

	// you can filter and remove the backlink with an add_filter function
	// from your themes (or child themes) functions.php file if you dont want to edit this file
	// you can also remove the kriesi.at backlink by adding [nolink] to your custom copyright field in the admin area
	// you can also just keep that link. I really do appreciate it ;)
	$kriesi_at_backlink = kriesi_backlink(get_option(THEMENAMECLEAN."_initial_version"), 'Enfold');


	if( $copyright && strpos( $copyright, '[nolink]' ) !== false )
	{
		$kriesi_at_backlink = '';
		$copyright = str_replace( '[nolink]', '', $copyright );
	}

	/**
	 * @since 4.5.7.2
	 * @param string $copyright
	 * @param string $copyright_option
	 * @return string
	 */
	$copyright_option = avia_get_option( 'copyright' );
	$copyright = apply_filters( 'avf_copyright_info', $copyright, $copyright_option );

	if( in_array( $footer_widget_setting, array( 'all', 'nofooterwidgets', 'page_in_footer_socket' ) ) )
	{

		?>

        <footer class='container_wrap socket_color' id='socket' <?php avia_markup_helper(array('context' => 'footer')); ?>>
            <div class='container'>

                <span class='copyright'><?php echo $copyright . $kriesi_at_backlink; ?></span>

				<?php
				if(avia_get_option('footer_social', 'disabled') != "disabled")
				{
					$social_args 	= array('outside'=>'ul', 'inside'=>'li', 'append' => '');
					echo avia_social_media_icons($social_args, false);
				}


				$avia_theme_location = 'avia3';
				$avia_menu_class = $avia_theme_location . '-menu';

				$args = array(
					'theme_location'=>$avia_theme_location,
					'menu_id' =>$avia_menu_class,
					'container_class' =>$avia_menu_class,
					'fallback_cb' => '',
					'depth'=>1,
					'echo' => false,
					'walker' => new avia_responsive_mega_menu(array('megamenu'=>'disabled'))
				);

				$menu = wp_nav_menu($args);

				if($menu){
					echo "<nav class='sub_menu_socket' ".avia_markup_helper(array('context' => 'nav', 'echo' => false)).">";
					echo $menu;
					echo "</nav>";
				}
				?>

            </div>


            <!-- ####### END SOCKET CONTAINER ####### -->

            <!-- Sidebar Basket -->
            <div class="sideBasket">
                <div class="sideBasket_content">
                    <span>produt 1</span>
                </div>
            </div>
            <!-- Sidebar Basket -->


            <audio id="audio" src="<?= get_stylesheet_uri().'/../assets/beep.wav'; ?>" ></audio>

        </footer>


        <!-- Najva Push Notification -->
<!--        <link rel="manifest" href="/manifest.json">-->
<!--        <script type="text/javascript">-->
<!--            (function(){-->
<!--                var now = new Date();-->
<!--                var version = now.getFullYear().toString() + "0" + now.getMonth() + "0" + now.getDate() +-->
<!--                    "0" + now.getHours();-->
<!--                var head = document.getElementsByTagName("head")[0];-->
<!--                var link = document.createElement("link");-->
<!--                link.rel = "stylesheet";-->
<!--                link.href = "https://app.najva.com/static/css/local-messaging.css" + "?v=" + version;-->
<!--                head.appendChild(link);-->
<!--                var script = document.createElement("script");-->
<!--                script.type = "text/javascript";-->
<!--                script.async = true;-->
<!--                script.src = "https://app.najva.com/static/js/scripts/radshid-website-25447-11035874-788d-4c32-865a-097de0b153e1.js" + "?v=" + version;-->
<!--                head.appendChild(script);-->
<!--            })()-->
<!--        </script>-->
        <!-- END NAJVA PUSH NOTIFICATION -->

		<?php
	} //end nosocket check - array( 'all', 'nofooterwidgets', 'page_in_footer_socket' )




} //end blank & nofooterarea check
?>
<!-- end main -->
</div>

<?php


//display link to previous and next portfolio entry
echo	$avia_post_nav;

echo "<!-- end wrap_all --></div>";


if(isset($avia_config['fullscreen_image']))
{ ?>
    <!--[if lte IE 8]>
    <style type="text/css">
        .bg_container {
            -ms-filter:"progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo $avia_config['fullscreen_image']; ?>', sizingMethod='scale')";
            filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo $avia_config['fullscreen_image']; ?>', sizingMethod='scale');
        }
    </style>
    <![endif]-->
	<?php
	echo "<div class='bg_container' style='background-image:url(".$avia_config['fullscreen_image'].");'></div>";
}
?>

<a href='#top' title='<?php _e('Scroll to top','avia_framework'); ?>' id='scroll-top-link' <?php echo av_icon_string( 'scrolltop' ); ?>><span class="avia_hidden_link_text"><?php _e('Scroll to top','avia_framework'); ?></span></a>

<div id="fb-root"></div>


<?php


if (is_user_logged_in()){
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            let my_account_elm = $('ul#avia2-menu').find('li#menu-item-16014');
            my_account_elm.find('a').html('<i class="ic-user align-text-top mx-1"></i>حساب کاربری');
        })
    </script>
    <?php
	$user_id = get_current_user_id();
	$user = get_userdata($user_id);
	$user_roles = $user->roles;
	if ($user_roles[0] == 'agent'){
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                //$('#avia-menu').append('<li id="menu-item-999" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-home menu-item-top-level menu-item-top-level-1"><a href="<?php echo get_option('RADtools_setting_agencies_orders_list_link'); ?>" itemprop="url"><span class="avia-bullet"></span><span class="avia-menu-text"><i class="fa fa-home"></i><?php echo __('Bulk Orders', 'radshid_lan'); ?></span><span class="avia-menu-fx"><span class="avia-arrow-wrap"><span class="avia-arrow"></span></span></span></a></li>');
            })
        </script>
        <?php
    }
} else {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            const elm = $('#menu-item-999');
            if(elm == null){
                $('#avia-menu').remove('<li id="menu-item-999"</li>');
            }
            let my_account_elm = $('ul#avia2-menu').find('li#menu-item-16014');
            my_account_elm.find('a').html('<i class="ic-user align-text-top mx-1"></i> ورود / ثبت نام');
        })
    </script>
<?php
}

/* Always have wp_footer() just before the closing </body>
 * tag of your theme, or you will break many plugins, which
 * generally use this hook to reference JavaScript files.
 */


wp_footer();
?>

</body>
</html>
