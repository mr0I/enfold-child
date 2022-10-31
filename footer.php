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
  //custom footer
  if (get_locale() === 'en_US'){
	?>
      <div id="custom-footer">
          <div class="third-row">
              <div class="container-fluid p-0">
                  <div class="row" style="width: 94%;margin: 0 auto;">
                      <div class="tr-element">
                          <div class="row">
                              <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                                  <p class="threeWords title">Products</p>
                                  <ul style="display: flex;flex-flow: row wrap">
                                      <li class="col-12"><a href="https://radshid.com/product-car-tracker/">Car Trackers</a></li>
                                      <li class="col-12"><a href="https://radshid.com/product-personal-tracker/">Personal Trackers</a></li>
                                      <li class="col-12"><a href="https://radshid.com/types-of-rugged-gadgets/">Rugged Tablets</a></li>
                                      <li class="col-12"><a href="https://radshid.com/%d9%86%d8%b1%d9%85-%d8%a7%d9%81%d8%b2%d8%a7%d8%b1-%d9%84%d8%a7%da%af%d8%b4%db%8c%d8%aa-%d8%b1%d8%a7%d8%af%d8%b4%db%8c%d8%af/">LogSheet</a></li>
                                  </ul>
                              </div>
                              <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                                  <p class="threeWords title">About Us</p>
                                  <ul style="display: flex;flex-flow: row wrap">
                                      <li class="col-12"><a href="https://radshid.com/%d8%aa%d9%85%d8%a7%d8%b3-%d8%a8%d8%a7-%d9%85%d8%a7/">Contact Us</a></li>
                                      <li class="col-12"><a href="https://radshid.com/%d8%af%d8%b1%d8%a8%d8%a7%d8%b1%d9%87-%d9%85%d8%a7/">About Radshid</a></li>
                                  </ul>
                              </div>
                              <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                                  <p class="threeWords title">Social Networks</p>
                                  <ul style="display: flex;flex-flow: row wrap">
                                      <li class="mx-1">
                                          <a href="https://www.instagram.com/radshid_com/" target="_blank" data-toggle="tooltip" data-placement="bottom" title="instagram">
                                              <figure>
                                                  <img src="<?= get_stylesheet_directory_uri().'/images/instagram.png' ; ?>" width="50" height="50" alt="Radshid Instagram">
                                              </figure>
                                          </a>
                                      </li>
                                      <li class="mx-1">
                                          <a href="https://www.linkedin.com/company/radshid/mycompany/" target="_blank" data-toggle="tooltip" data-placement="bottom" title="linkdin">
                                              <figure>
                                                  <img src="<?= get_stylesheet_directory_uri().'/images/linkdin.png' ; ?>" width="35" height="35" alt="Radshid Instagram">
                                              </figure>
                                          </a>
                                      </li>
                                  </ul>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <div class="fourth-row">
              <div class="mt-1">
                  <div class="fourth-row-container">
                      <div class="copyrightText" style="user-select: none;">
                          <span>All rights belongs to Radshid Engineering Complex.</span>
                      </div>
                  </div>
              </div>
          </div>
      </div>
	<?php
  } else {
	?>
      <div id="custom-footer">
          <div class="third-row">
              <div class="container-fluid p-0">
                  <div class="row" style="width: 94%;margin: 0 auto;">
                      <div class="tr-element">
                          <div class="row">
                              <div class="col-lg-3 col-md-3 col-sm-12 mb-3">
                                  <p class="threeWords title">محصولات</p>
                                  <ul style="display: flex;flex-flow: row wrap">
                                      <li class="col-lg-12 col-md-12 col-sm-6"><a href="https://radshid.com/product-car-tracker/">ردیاب خودرو</a></li>
                                      <li class="col-lg-12 col-md-12 col-sm-6"><a href="https://radshid.com/product-personal-tracker/">ردیاب شخصی</a></li>
                                      <li class="col-lg-12 col-md-12 col-sm-6"><a href="https://radshid.com/%d8%a7%d9%86%d9%88%d8%a7%d8%b9-%d8%aa%d8%a8%d9%84%d8%aa-%d9%87%d8%a7%db%8c-%d8%b5%d9%86%d8%b9%d8%aa%db%8c-%d8%b1%d8%a7%d8%af%d8%b4%db%8c%d8%af/">تبلت صنعتی</a></li>
                                      <li class="col-lg-12 col-md-12 col-sm-6"><a href="https://radshid.com/%d8%a7%d9%86%d9%88%d8%a7%d8%b9-pda-%d9%87%d8%a7%db%8c-%d8%b5%d9%86%d8%b9%d8%aa%db%8c-%d8%b1%d8%a7%d8%af%d8%b4%db%8c%d8%af/">هندهلد</a></li>
                                      <li class="col-lg-12 col-md-12 col-sm-6"><a href="https://radshid.com/%d9%86%d8%b1%d9%85-%d8%a7%d9%81%d8%b2%d8%a7%d8%b1-%d9%84%d8%a7%da%af%d8%b4%db%8c%d8%aa-%d8%b1%d8%a7%d8%af%d8%b4%db%8c%d8%af/">نرم افزار لاگشیت</a></li>
                                      <li class="col-lg-12 col-md-12 col-sm-6"><a href="https://radshid.com/%d8%b3%d8%a7%d9%85%d8%a7%d9%86%d9%87-%d8%b1%d8%af%db%8c%d8%a7%d8%a8%db%8c-%d8%b1%d8%a7%d8%af%d8%b4%db%8c%d8%af/">سامانه مدیریت ناوگان</a></li>
                                  </ul>
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-12 mb-3">
                                  <p class="threeWords title">ارتباط با رادشید</p>
                                  <ul style="display: flex;flex-flow: row wrap">
                                      <li class="col-lg-12 col-md-12 col-sm-6"><a href="https://radshid.com/%d8%aa%d9%85%d8%a7%d8%b3-%d8%a8%d8%a7-%d9%85%d8%a7/">تماس با رادشید</a></li>
                                      <li class="col-lg-12 col-md-12 col-sm-6"><a href="https://radshid.com/%d8%af%d8%b1%d8%a8%d8%a7%d8%b1%d9%87-%d9%85%d8%a7/">درباره رادشید</a></li>
                                      <li class="col-lg-12 col-md-12 col-sm-6"><a href="https://radshid.com/%d8%af%d8%b1%d8%ae%d9%88%d8%a7%d8%b3%d8%aa-%d9%86%d9%85%d8%a7%db%8c%d9%86%d8%af%da%af%db%8c-%d8%b1%d8%af%db%8c%d8%a7%d8%a8-%d8%ae%d9%88%d8%af%d8%b1%d9%88-%d8%b1%d8%a7%d8%af%d8%b4%db%8c%d8%af/">دریافت نمایندگی</a></li>
                                      <li class="col-lg-12 col-md-12 col-sm-6"><a href="https://radshid.com/%d9%87%d9%85%da%a9%d8%a7%d8%b1%db%8c-%d8%a8%d8%a7-%d8%b1%d8%a7%d8%af%d8%b4%db%8c%d8%af/">استخدام در رادشید</a></li>
                                  </ul>
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-12 mb-3">
                                  <p class="threeWords title">راهنمای خرید و پرداخت</p>
                                  <ul style="display: flex;flex-flow: row wrap">
                                      <li class="col-lg-12 col-md-12 col-sm-6"><a href="https://radshid.com/%d9%86%d8%ad%d9%88%d9%87-%d8%ab%d8%a8%d8%aa-%d8%b3%d9%81%d8%a7%d8%b1%d8%b4/">نحوه ثبت سفارش</a></li>
                                      <li class="col-lg-12 col-md-12 col-sm-6"><a href="https://radshid.com/%d8%b4%db%8c%d9%88%d9%87-%d9%87%d8%a7%db%8c-%d8%a7%d8%b1%d8%b3%d8%a7%d9%84/">شیوه‌های ارسال</a></li>
                                      <li class="col-lg-12 col-md-12 col-sm-6"><a href="https://radshid.com/%d8%ae%d8%af%d9%85%d8%a7%d8%aa-%d9%be%d8%b3-%d8%a7%d8%b2-%d9%81%d8%b1%d9%88%d8%b4/">گارانتی و خدمات پس از فروش</a></li>
                                      <li class="col-lg-12 col-md-12 col-sm-6"><a href="https://radshid.com/%d9%85%d8%b9%d8%b1%d9%81%db%8c-%d9%be%d8%b1%d9%88%da%98%d9%87-%d9%85%d9%84%db%8c-%d8%b3%db%8c%d9%be%d8%a7%d8%af-%d9%88-%d8%b3%d8%a7%d9%85%d8%a7%d9%86%d9%87-%d8%b3%db%8c%d9%be%d8%a7%d8%af/">نحوه خرید و ثبت نام سیپاد</a></li>
                                  </ul>
                              </div>
                              <div class="col-lg-3 col-md-3 col-sm-12 mb-3">
                                  <p class="threeWords title">آدرس</p>
                                  <ul style="display: flex;flex-flow: row wrap">
                                      <li class="col-12">
                                          اصفهان خیابان کاشانی، خیابان صاحب روضات، کوچه شماره 12، پلاک ۳۲ شرکت رادشید
                                          کدپستی: 8183873541
                                      </li>
                                  </ul>
                                  <div class="my-2" style="display: flex;flex-flow: row wrap">
                                      <div class="iframe-wrapper col-lg-8 col-sm-12">
                                          <iframe height="150" style="border:0;" allowfullscreen="" loading="lazy" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d419.87585558958284!2d51.648433!3d32.659262!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x783b695de580e1b2!2z2LTYsdqp2Kog2LHYp9iv2LTbjNiv!5e0!3m2!1sen!2sus!4v1655546366493!5m2!1sfa!2sus" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                      </div>
                                      <div class="enamad d-flex justify-content-center align-items-center col-lg-4 col-sm-12">
                                          <a referrerpolicy="origin" target="_blank" href="https://trustseal.enamad.ir/?id=179501&amp;Code=FhjbxasmXXMZd5Y5vKZc">
                                              <img referrerpolicy="origin" src="<?= get_stylesheet_directory_uri().'/images/enemad.png' ; ?>"
                                                   alt="نماد اعتماد الکترونیک شرکت مهندسی رادشید" style="cursor:pointer" id="FhjbxasmXXMZd5Y5vKZc">
                                          </a>
                                      </div>
                                  </div>

                                  <div class="apps-wrapper">
                                      <a target="_blank" class="" href="https://rx4.ir/android">
                                          <img src="https://radshid.com/wp-content/uploads/2022/03/android-icon.png"
                                               alt="دانلود اپلیکیشن ردیابی رادشید نسخه اندروید">
                                      </a>
                                      <a target="_blank" class="" href="https://rx4.ir/ios">
                                          <img src="https://radshid.com/wp-content/uploads/2022/03/ios-icon.png"
                                               alt="ورود به برنامه ردیابی رادشید نسخه آی او اس">
                                      </a>
                                      <a target="_blank" class="" href="tg://resolve?domain=radshid_bot/">
                                          <img src="https://radshid.com/wp-content/uploads/2022/03/telegrambot-icon.png"
                                               alt="ورود به ربات ردیابی تلگرام رادشید">
                                      </a>
                                  </div>

                              </div>
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
                  </div>
              </div>
          </div>
      </div>
	<?php
  }
  ?>
    <!-- custom footer -->

    <!-- custom code -->

    <!-- Floated Action Button -->
  <?php
  if (get_locale() !== 'en_US'){
	?>
      <div class="fab-wrapper">
          <input id="fabCheckbox" type="checkbox" class="fab-checkbox" />
          <label class="fab" for="fabCheckbox">
              <span class="fab-dots fab-dots-1"></span>
              <span class="fab-dots fab-dots-2"></span>
              <span class="fab-dots fab-dots-3"></span>
          </label>
          <div class="fab-wheel">
              <a class="fab-action fab-action-1" href="tel:03132362947" title="تماس با واحد بازرگانی">
                  <i class="ic-headset_mic"></i>
              </a>
              <a class="fab-action fab-action-2" href="tel:03132362894" title="تماس با واحد پشتیبانی">
                  <i class="ic-phone1"></i>
              </a>
          </div>
      </div>
	<?php
  }
  ?>
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
  <?php
  if (get_locale() !== 'en_US'){
	?>
      <div class="floated_icons_footer">
          <div class="fif-container">
              <a href="https://radshid.com/footer_login_register" title="ورود به سایت">
                  <i class="ic-user"></i><span>ورود/ثبت نام</span>
              </a>
              <a href="https://radshid.com/footer_shop" title="فروشگاه">
                  <i class="ic-shopping-bag"></i><span>لیست قیمت ردیاب</span>
              </a>
              <a href="https://radshid.com/footer_selected_tracker" title="ردیاب مناسب شما">
                  <i class="ic-pin"></i><span>ردیاب مناسب شما</span>
              </a>
          </div>
      </div>
	<?php
  }
  ?>
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
//echo $avia_post_nav;

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
            let my_account_elm_onmobile = $('.fif-container').find('a[title="ورود به سایت"]');
            my_account_elm_onmobile.html('<i class="ic-user align-text-top mx-1"></i><span>حساب کاربری</span>');
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
            let my_account_elm_onmobile = $('.fif-container').find('a[title="ورود به سایت"]');
            my_account_elm_onmobile.html('<i class="ic-user align-text-top mx-1"></i><span>ورود / ثبت نام</span>');
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
