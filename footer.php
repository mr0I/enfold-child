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



    <!--     custom footer -->
    <div id="custom-footer">
        <div class="first-row">
            <div class="container-fluid">
                <div class="row">
                    <div class="fr-element col-3 ">
                        <figure>
                            <img src="<?php echo get_stylesheet_directory_uri(). '/images/express.png' ; ?>" alt="تحویل اکسپرس">
                            <p><span>تحویل اکسپرس</span></p>
                        </figure>
                    </div>
                    <div class="fr-element col-3">
                        <figure>
                            <img src="<?php echo get_stylesheet_directory_uri(). '/images/backup.png' ; ?>" alt="پشتیبانی 24 ساعته">
                            <p><span>پشتیبانی و مشاوره رایگان</span></p>
                        </figure>
                    </div>
                    <div class="fr-element col-3">
                        <figure>
                            <img src="<?php echo get_stylesheet_directory_uri(). '/images/cash-in-place.png' ; ?>" alt="پرداخت در محل"
                            >
                            <p><span>پرداخت در محل</span></p>
                        </figure>
                    </div>
                    <div class="fr-element col-3">
                        <figure>
                            <img src="<?php echo get_stylesheet_directory_uri(). '/images/guarantee.png' ; ?>"
                                 alt="1 سال گارانتی - 5 سال خدمات پس از فروش " >
                            <p><span>1 سال گارانتی</span></p>
                            <p><span> 5 سال خدمات پس از فروش </span></p>
                        </figure>
                    </div>
                </div>
            </div>
        </div>

        <div class="second-row">
            <div class="container-fluid">
                <div class="row">
                    <div class="sr-element col-md-4 col-sm-12">
                        <h6>راهنمای خرید از رادشید</h6>
                        <p><a href="https://radshid.com/%d9%86%d8%ad%d9%88%d9%87-%d8%ab%d8%a8%d8%aa-%d8%b3%d9%81%d8%a7%d8%b1%d8%b4/">نحوه ثبت سفارش</a></p>
                        <p><a href="https://radshid.com/%d8%b4%db%8c%d9%88%d9%87-%d9%87%d8%a7%db%8c-%d9%be%d8%b1%d8%af%d8%a7%d8%ae%d8%aa/">شیوه های پرداخت</a></p>
                        <p><a href="https://radshid.com/%d8%b4%db%8c%d9%88%d9%87-%d9%87%d8%a7%db%8c-%d8%a7%d8%b1%d8%b3%d8%a7%d9%84/">شیوه های ارسال</a></p>
                        <p><a href="https://radshid.com/%d8%b3%d9%88%d8%a7%d9%84%e2%80%8c%d9%87%d8%a7%db%8c-%d9%85%d8%aa%d8%af%d8%a7%d9%88%d9%84-faq/">پاسخ به پرسش های متداول</a></p>
                        <p><a href="https://radshid.com/%d8%ae%d8%af%d9%85%d8%a7%d8%aa-%d9%be%d8%b3-%d8%a7%d8%b2-%d9%81%d8%b1%d9%88%d8%b4/">خدمات پس از فروش</a></p>
                    </div>
                    <div class="sr-element col-md-4 col-sm-12">
                        <h6>با رادشید</h6>
                        <p><a href="https://radshid.com/%d8%a7%d8%ae%d8%a8%d8%a7%d8%b1-%d8%b1%d8%a7%d8%af%d8%b4%db%8c%d8%af/">اخبار رادشید</a></p>
                        <p><a href="https://radshid.com/%d8%af%d8%b1%d8%ae%d9%88%d8%a7%d8%b3%d8%aa-%d9%86%d9%85%d8%a7%db%8c%d9%86%d8%af%da%af%db%8c/">دریافت نمایندگی</a></p>
                        <p><a href="https://radshid.com/%d9%87%d9%85%da%a9%d8%a7%d8%b1%db%8c-%d8%a8%d8%a7-%d8%b1%d8%a7%d8%af%d8%b4%db%8c%d8%af/">استخدام در رادشید</a></p>
                        <p><a href="https://radshid.com/%d8%af%d8%b1%d8%a8%d8%a7%d8%b1%d9%87-%d9%85%d8%a7/">درباره ما</a></p>
                        <p><a href="https://radshid.com/%d8%aa%d9%85%d8%a7%d8%b3-%d8%a8%d8%a7-%d9%85%d8%a7/">تماس ما</a></p>
                    </div>
                    <div class="sr-element col-md-4 col-sm-12">
                        <h6 style="text-align: center;">درباره رادشید</h6>
                        <div class="footer-aboutUs">
                            <p>
                                شرکت ایده پردازان پارسی فردا با نام تجاری رادشید  با هدف برطرف نمودن نیاز شرکت های صنعتی در رابطه با استفاده از سیستم های نوین و مدیریت هوشمندسازی ناوگان حمل و نقل آغاز گردید.  اما پس از آن با توجه به دانش بنیان بودن ساختار شرکت و با تکیه به توانمندی نیروهای مجرب پا را فراتر نهاده و با توجه به تقاضاهای مطرح شده  از طرف مشتریان در صنعت های مختلف قابلیت های دستگاه های تولیدی خود را کم کم افزایش داده که این مهم با استفاده از  تکنولوژِی های روز دنیا و ایده های نو به حقیقت پیوست.
                            </p>
                        </div>

<!--                        <h6 style="text-align: center;">ما را در شبکه های اجتماعی دنبال کنید</h6>-->
<!--                        <div class="footer-social">-->
<!--                            <a href="https://www.instagram.com/radshid_com/" id="insta" target="_blank" rel="nofollow"-->
<!--                               data-toggle="tooltip" data-placement="top" title="اینستاگرام">-->
<!--                                <i class="ic-instagram"></i>-->
<!--                            </a>-->
<!--                            <a href="https://t.me/Radshid_co" id="telegram" target="_blank" rel="nofollow"-->
<!--                               data-toggle="tooltip" data-placement="top" title="تلگرام">-->
<!--                                <i class="ic-telegram"></i>-->
<!--                            </a>-->
<!--                        </div>-->


<!--                        <form class="tnp-form" action="--><?php //echo get_site_url()."?na=s"; ?><!--" method="post" onsubmit="return newsletter_check(this)">-->
<!--                            <input type="hidden" name="nr" value="widget-minimal">-->
<!--                            <input class="tnp-email" type="email" required="" name="ne" value="" placeholder="Email">-->
<!--                            <input class="tnp-submit" type="submit" value="Subscribe">-->
<!--                        </form>-->
                    </div>
                </div>
            </div>
        </div>

        <div class="third-row mb-5">
            <div class="container-fluid">
                <div class="row">
                    <div class="tr-element col-md-6 col-sm-12">
                        <h6>آدرس دفتر مرکزی</h6>
                        <p>
                                <span>
                                    اصفهان – خیابان کاشانی – ابتدای خیابان صاحب روضات – نبش کوچه شماره 3 – پلاک 33       ساعات کار:       8:30 الی 17
                                </span>
                            <br>
                            <span> کد پستی: <span>8183877113</span></span>
                        </p>
                        <h6>واحد بازرگانی <p>03132362894 - 03132362947 - 09124735787 - 09124839402</p></h6>
                        <h6> واحد پشتیبانی <p >03195016151 - 03132363078 - 09018377198 - 09018377021 - 09018377021 - 09901883981</p></h6>
                        <h6> فکس <p >03132362788 (داخلی 23)</p></h6>
                        <h6 class="mt-4">آدرس کارخانه</h6>
                        <p>
                             <span>
                                    نجف آباد – شهرک صنعتی شماره 2 – خیابان ابوریحان – شرکت رادشید
                             </span>
                            <br>
                        </p>
                    </div>
                    <div class="tr-element col-md-6 col-sm-12" id="gateway">
                        <a>
                            <figure>
                                <img src="<?php echo get_stylesheet_directory_uri().'/images/mellat_gateway.png' ; ?>" alt="درگاه پرداخت ملت" id="mellat_img">
                            </figure>
                        </a>
<!--                        <a href="https://www.zarinpal.com/trustPage/radshid.com" rel="nofollow" target="_blank">-->
<!--                            <figure>-->
<!--                                <img src="--><?php //echo get_stylesheet_directory_uri().'/images/zarinpal-badge.png' ; ?><!--" alt="زرین پال" id="zarin_img">-->
<!--                            </figure>-->
<!--                        </a>-->
                        <a referrerpolicy="origin" target="_blank" href="https://trustseal.enamad.ir/?id=179501&amp;Code=FhjbxasmXXMZd5Y5vKZc">
                            <img referrerpolicy="origin" src="<?php echo get_stylesheet_directory_uri().'/images/star1.png' ; ?>" alt="" style="cursor:pointer" id="FhjbxasmXXMZd5Y5vKZc">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- custom footer -->



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

<!-- floated icons -->
<div class="floated_icons-r1">
    <a rel="nofollow" href="https://cafebazaar.ir/app/com.radshid.radassistant" target="_blank" title="دریافت از کافه بازار">
        <img src="<?php echo get_stylesheet_directory_uri().'/images/bazaar.png' ; ?>" alt="دریافت از کافه بازار" width="0">
        <span>برنامه ردیابی رادشید (اندروید)</span>
    </a>
</div>
<div class="floated_icons-r2">
    <a rel="nofollow" title="دریافت از سیب اپ"
       href="https://sibapp.com/applications/%D8%B1%D8%AF%DB%8C%D8%A7%D8%A8-%D8%AE%D9%88%D8%AF%D8%B1%D9%88-%D8%B1%D8%A7%D8%AF%D8%B4%DB%8C%D8%AF" target="_blank">
        <img src="<?php echo get_stylesheet_directory_uri().'/images/sibapp.png' ; ?>" alt="دریافت از سیب اپ">
        <span>برنامه ردیابی رادشید (آی او اس)</span>
    </a>
</div>
<div class="floated_icons-r3">
    <a rel="nofollow" title="دریافت از اناردونی"
       href="https://anardoni.com/ios/app/Y61iN7Xry" target="_blank">
        <img src="<?php echo get_stylesheet_directory_uri().'/images/anaar.png' ; ?>" alt="دریافت نسخه ios از اناردونی">
        <span >برنامه ردیابی رادشید (آی او اس)</span>
    </a>
</div>

<div class="floated_icons_footer">
    <div class="fif-container">
        <a href="https://t.me/Radshid_co" rel="nofollow" title="تلگرام رادشید">
            <i class="ic-telegram"></i>
            <span>تلگرام</span>
        </a>
        <a href="https://www.instagram.com/radshid_com/" title="اینستاگرام رادشید" rel="nofollow">
            <i class="ic-instagram"></i>
            <span>اینستاگرام</span>
        </a>
        <a href="https://radshid.com/?p=10008" title="ورود به فروشگاه">
            <i class="ic-shopping-cart"></i>
            <span>فروشگاه</span>
        </a>

        <a href="https://sibapp.com/applications/%D8%B1%D8%AF%DB%8C%D8%A7%D8%A8-%D8%AE%D9%88%D8%AF%D8%B1%D9%88-%D8%B1%D8%A7%D8%AF%D8%B4%DB%8C%D8%AF" title="برنامه ردیابی رادشید نسخه ios"
           rel="nofollow" target="_blank">
            <img src="<?php echo get_stylesheet_directory_uri().'/images/sibapp.png' ; ?>" alt="دریافت نسخه ios از سیب اپ">
            <span>سیب اپ</span>
        </a>
        <a href="https://anardoni.com/ios/app/Y61iN7Xry" rel="nofollow" target="_blank" title="برنامه ردیابی رادشید نسخه ios">
            <img src="<?php echo get_stylesheet_directory_uri().'/images/anaar.png' ; ?>" alt="دریافت نسخه ios از اناردونی">
            <span>اناردونی</span>
        </a>
        <a href="https://cafebazaar.ir/app/com.radshid.radassistant" target="_blank" rel="nofollow" title="برنامه ردیابی رادشید نسخه اندروید">
            <img src="<?php echo get_stylesheet_directory_uri().'/images/bazaar.png' ; ?>" alt="دریافت از بازار">
            <span>کافه بازار</span>
        </a>
    </div>
</div>
<!-- floated icons -->
<!-- custom code -->



<?php

/* Always have wp_footer() just before the closing </body>
 * tag of your theme, or you will break many plugins, which
 * generally use this hook to reference JavaScript files.
 */

wp_footer();
?>


<!-- Start Crisp Init -->
<script type="text/javascript" defer async>
    window.$crisp=[];
    CRISP_RUNTIME_CONFIG = {
        locale : 'fa'
    };
    window.CRISP_WEBSITE_ID="68e9f005-17da-481c-b8f2-ba184b388aa3";(function(){
        d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();$crisp.push(["set", "session:data", [[["country", "IR"],["shipping_country", "IR"]]]]);
</script>
<!-- End Crisp Init -->


</body>
</html>
