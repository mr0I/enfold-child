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
                <div class="row" style="width: 94%;margin: 0 auto 30px auto;">
                    <div class="tr-element col-12 mt-3">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <h6 class="threeWords">آدرس دفتر مرکزی</h6>
                                <p>
                                <span>اصفهان – خیابان کاشانی – ابتدای خیابان صاحب روضات – نبش کوچه شماره 3 – پلاک 33       ساعات کار:       8:30 الی 17</span>
                                <br>
                                    <span> کد پستی: <span>8183877113</span></span>
                                </p>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <h6 class="twoWords">آدرس کارخانه</h6>
                                <p><span>نجف آباد – شهرک صنعتی شماره 2 – خیابان ابوریحان – شرکت رادشید</span></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <h6 class="twoWords">واحد بازرگانی</h6>
                                <ul style="display: flex;flex-flow: row wrap;margin: 5px auto;padding: 0;">
                                    <li class="col-6">03132362894</li>
                                    <li class="col-6">03132362947</li>
                                    <li class="col-6">09124735787</li>
                                    <li class="col-6">09124839402</li>
                                </ul>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <h6 class="twoWords">واحد پشتیبانی</h6>
                                <ul id="support_unit" style="display: flex;flex-flow: row wrap;margin: 5px auto;padding: 0;">
                                    <li class="col-lg-4 col-md-4 col-sm-6">03195016151</li>
                                    <li class="col-lg-4 col-md-4 col-sm-6">03132363078</li>
                                    <li class="col-lg-4 col-md-4 col-sm-6">09018377198</li>
                                    <li class="col-lg-4 col-md-4 col-sm-6">09018377021</li>
                                    <li class="col-lg-4 col-md-4 col-sm-6">09018377021</li>
                                    <li class="col-lg-4 col-md-4 col-sm-6">09901883981</li>
                                </ul>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <h6 class="oneWord"> فکس </p></h6>
                                <ul style="display: flex;flex-flow: row wrap;margin: 5px auto;padding: 0;">
                                    <li class="col-12">03132362788 (داخلی 23)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="second-row">
            <div class="container-fluid">
                <div class="row" style="width: 94%;margin: 0 auto 30px auto;">
                    <div class="sr-element col-md-4 col-sm-12">
                        <h6 class="fourWords">راهنمای خرید از رادشید</h6>
                        <ul style="display: flex;flex-flow: row wrap">
                            <li class="col-lg-6 col-md-6 col-sm-12"><a href="https://radshid.com/%d9%86%d8%ad%d9%88%d9%87-%d8%ab%d8%a8%d8%aa-%d8%b3%d9%81%d8%a7%d8%b1%d8%b4/">نحوه ثبت سفارش</a></li>
                            <li class="col-lg-6 col-md-6 col-sm-12"><a href="https://radshid.com/%d8%b4%db%8c%d9%88%d9%87-%d9%87%d8%a7%db%8c-%d9%be%d8%b1%d8%af%d8%a7%d8%ae%d8%aa/">شیوه های پرداخت</a></li>
                            <li class="col-lg-6 col-md-6 col-sm-12"><a href="https://radshid.com/%d8%b4%db%8c%d9%88%d9%87-%d9%87%d8%a7%db%8c-%d8%a7%d8%b1%d8%b3%d8%a7%d9%84/">شیوه های ارسال</a></li>
                            <li class="col-lg-6 col-md-6 col-sm-12"><a href="https://radshid.com/%d8%ae%d8%af%d9%85%d8%a7%d8%aa-%d9%be%d8%b3-%d8%a7%d8%b2-%d9%81%d8%b1%d9%88%d8%b4/">خدمات پس از فروش</a></li>
                        </ul>
                    </div>
                    <div class="sr-element col-md-4 col-sm-12">
                        <h6 class="twoWords">با رادشید</h6>
                        <ul style="display: flex;flex-flow: row wrap">
                            <li class="col-lg-6 col-md-6 col-sm-12"><a href="https://radshid.com/%d8%aa%d9%85%d8%a7%d8%b3-%d8%a8%d8%a7-%d9%85%d8%a7/">تماس ما</a></li>
                            <li class="col-lg-6 col-md-6 col-sm-12"><a href="https://radshid.com/%d8%af%d8%b1%d8%a8%d8%a7%d8%b1%d9%87-%d9%85%d8%a7/">درباره ما</a></li>
                            <li class="col-lg-6 col-md-6 col-sm-12"><a href="https://radshid.com/%d8%af%d8%b1%d8%ae%d9%88%d8%a7%d8%b3%d8%aa-%d9%86%d9%85%d8%a7%db%8c%d9%86%d8%af%da%af%db%8c/">دریافت نمایندگی</a></li>
                            <li class="col-lg-6 col-md-6 col-sm-12"><a href="https://radshid.com/%d9%87%d9%85%da%a9%d8%a7%d8%b1%db%8c-%d8%a8%d8%a7-%d8%b1%d8%a7%d8%af%d8%b4%db%8c%d8%af/">استخدام در رادشید</a></li>
                        </ul>
                    </div>
                    <div class="sr-element col-md-4 col-sm-12">
                        <h6 class="twoWords">درباره رادشید</h6>
                        <div class="footer-aboutUs">
                            <p>
                                شرکت رادشید  با هدف برطرف نمودن نیاز شرکت های صنعتی در رابطه با استفاده از سیستم های نوین و مدیریت هوشمندسازی ناوگان حمل و نقل آغاز گردید.  اما پس از آن با توجه به دانش بنیان بودن ساختار شرکت و با تکیه به توانمندی نیروهای مجرب پا را فراتر نهاده و با توجه به تقاضاهای مطرح شده  از طرف مشتریان در صنعت های مختلف قابلیت های دستگاه های تولیدی خود را کم کم افزایش داده که این مهم با استفاده از  تکنولوژِی های روز دنیا و ایده های نو به حقیقت پیوست.
                            </p>
                        </div>
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

<!--                        <form class="tnp-form" action="--><?php //echo get_site_url()."?na=s"; ?><!--" method="post" onsubmit="return newsletter_check(this)">-->
<!--                            <input type="hidden" name="nr" value="widget-minimal">-->
<!--                            <input class="tnp-email" type="email" required="" name="ne" value="" placeholder="Email">-->
<!--                            <input class="tnp-submit" type="submit" value="Subscribe">-->
<!--                        </form>-->
                    </div>
                </div>
            </div>
        </div>
        <div class="fourth-row">
            <div class="container-fluid">
                <div class="row d-flex justify-content-center my-3">
                    <div class="social-icons">
                        <a href="https://t.me/Radshid_co" id="telegram" target="_blank" rel="nofollow" data-toggle="tooltip" data-placement="bottom" title="تلگرام" >
                            <i class="ic-telegram"></i>
                        </a>
                        <a href="https://www.instagram.com/radshid_com/" id="insta" target="_blank" rel="nofollow" data-toggle="tooltip" data-placement="bottom" title="اینستاگرام">
                            <i class="ic-instagram"></i>
                        </a>
                        <a href="https://www.aparat.com/radshid" id="aparat" target="_blank" rel="nofollow" data-toggle="tooltip" data-placement="bottom" title="آپارات">
                            <i class="ic-aparat"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- custom footer -->


    <!-- custom code -->
    <div>
        <a class="floated-shop" href="https://radshid.com/shop/" title="ورود به فروشگاه">
            <svg id="i-bag" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="30" height="30" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                <path d="M5 9 L5 29 27 29 27 9 Z M10 9 C10 9 10 3 16 3 22 3 22 9 22 9" />
            </svg>
        </a>
        <a class="dial-btn" href="tel:03132362894" title="تماس با واحد بازرگانی">
            <i class="Phone"></i>
        </a>
    </div>


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
                    <a href="https://cafebazaar.ir/app/com.radshid.radassistant" id="banner_btn1" target="_blank" rel="nofollow">
                        <img src="<?php echo get_stylesheet_directory_uri().'/images/bazaar.png' ; ?>" alt="bazaar">
                        دریافت از کافه بازار
                    </a>
                    <a href="https://myket.ir/app/com.radshid.radassistant" id="banner_btn2" target="_blank" rel="nofollow">
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
    <div class="floated_icons-r1">
        <a href="https://radshid.com/shop" title="فروشگاه اینترنتی">
            <img src="<?php echo get_stylesheet_directory_uri().'/images/shop.png' ; ?>" width="35" height="35" alt="فروشگاه اینترنتی">
            <span>فروشگاه اینترنتی رادشید</span>
        </a>
    </div>
    <div class="floated_icons-r2">
        <a rel="nofollow" href="https://cafebazaar.ir/app/com.radshid.radassistant" target="_blank" title="دریافت از کافه بازار">
            <img src="<?php echo get_stylesheet_directory_uri().'/images/bazaar.png' ; ?>" width="35" height="35" alt="دریافت از کافه بازار">
            <span>برنامه ردیابی رادشید (اندروید)</span>
        </a>
    </div>
    <div class="floated_icons-r3">
        <a rel="nofollow" title="دریافت از سیب اپ"
           href="https://sibapp.com/applications/%D8%B1%D8%AF%DB%8C%D8%A7%D8%A8-%D8%AE%D9%88%D8%AF%D8%B1%D9%88-%D8%B1%D8%A7%D8%AF%D8%B4%DB%8C%D8%AF" target="_blank">
            <img src="<?php echo get_stylesheet_directory_uri().'/images/sibapp.png' ; ?>" width="35" height="35" alt="دریافت از سیب اپ">
            <span>برنامه ردیابی رادشید (آی او اس)</span>
        </a>
    </div>
    <div class="floated_icons-r4">
        <a rel="nofollow" title="دریافت از اناردونی"
           href="https://anardoni.com/ios/app/Y61iN7Xry" target="_blank">
            <img src="<?php echo get_stylesheet_directory_uri().'/images/anaar.png' ; ?>" width="35" height="35" alt="دریافت نسخه ios از اناردونی">
            <span >برنامه ردیابی رادشید (آی او اس)</span>
        </a>
    </div>
    <div class="floated_icons_footer">
        <div class="fif-container">
            <a href="https://t.me/Radshid_co" rel="nofollow" title="تلگرام رادشید" target="_blank">
                <i class="ic-telegram"></i>
                <span>تلگرام</span>
            </a>
            <a href="https://www.instagram.com/radshid_com/" title="اینستاگرام رادشید" rel="nofollow" target="_blank">
                <i class="ic-instagram"></i>
                <span>اینستاگرام</span>
            </a>
            <a href="https://radshid.com/shop" title="ورود به فروشگاه">
                <i class="ic-shopping-cart"></i>
                <span>فروشگاه</span>
            </a>

            <a href="https://sibapp.com/applications/%D8%B1%D8%AF%DB%8C%D8%A7%D8%A8-%D8%AE%D9%88%D8%AF%D8%B1%D9%88-%D8%B1%D8%A7%D8%AF%D8%B4%DB%8C%D8%AF" title="برنامه ردیابی رادشید نسخه ios"
               rel="nofollow" target="_blank">
                <img src="<?php echo get_stylesheet_directory_uri().'/images/sibapp.png' ; ?>" width="22" height="22" alt="دریافت نسخه ios از سیب اپ">
                <span>سیب اپ</span>
            </a>
            <a href="https://anardoni.com/ios/app/Y61iN7Xry" rel="nofollow" target="_blank" title="برنامه ردیابی رادشید نسخه ios">
                <img src="<?php echo get_stylesheet_directory_uri().'/images/anaar.png' ; ?>" width="22" height="22" alt="دریافت نسخه ios از اناردونی">
                <span>اناردونی</span>
            </a>
            <a href="https://cafebazaar.ir/app/com.radshid.radassistant" target="_blank" rel="nofollow" title="برنامه ردیابی رادشید نسخه اندروید">
                <img src="<?php echo get_stylesheet_directory_uri().'/images/bazaar.png' ; ?>" width="22" height="22" alt="دریافت از بازار">
                <span>کافه بازار</span>
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
        </footer>


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
            let my_account_elm = $('ul.menu.av-main-nav').find('li.menu-item.menu-item-top-level-8');
            my_account_elm.find('span.avia-menu-text').html('<i class="ic-user1"></i>حساب کاربری');
        })
    </script>
    <?php
	$user_id = get_current_user_id();
	$user = get_userdata($user_id);
	$user_roles = $user->roles;
	if ($user_roles[0] == 'author'){
        // Append extra element after Agent login
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $('#avia-menu').append('<li id="menu-item-999" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-home menu-item-top-level menu-item-top-level-1"><a href="<?php echo get_option('RADtools_setting_agencies_orders_list_link'); ?>" itemprop="url"><span class="avia-bullet"></span><span class="avia-menu-text"><i class="fa fa-home"></i><?php echo __('Bulk Orders', 'radshid_lan'); ?></span><span class="avia-menu-fx"><span class="avia-arrow-wrap"><span class="avia-arrow"></span></span></span></a></li>');
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
            let my_account_elm = $('ul.menu.av-main-nav').find('li.menu-item.menu-item-top-level-8');
            my_account_elm.find('span.avia-menu-text').html('<i class="ic-user1"></i>ورود / ثبت نام');
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



<!-- Start Crisp Init -->
<script type="text/javascript" defer>
    window.$crisp=[];
    CRISP_RUNTIME_CONFIG = {
        locale : 'fa'
    };
    window.CRISP_WEBSITE_ID="68e9f005-17da-481c-b8f2-ba184b388aa3";(function(){
        d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();$crisp.push(["set", "session:data", [[["country", "IR"],["shipping_country", "IR"]]]]);
</script>
<!-- End Crisp Init -->
<style type="text/css">
    .crisp-client .cc-kv6t[data-full-view=true] .cc-1xry .cc-unoo {
        bottom: 60px !important;
        right: 10px !important;
    }
    .crisp-client .cc-kv6t{
        /*z-index:100 !important;*/
    }
</style>


</body>
</html>
