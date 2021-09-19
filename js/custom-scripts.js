/* Version 1.0.9 */
(function($) {
    $(window).on("load", function() {
        /* Notif Banner */
        if (! localStorage.getItem('notif_banner_closed')){
            setTimeout(function () {
                $('.notif_banner_container').animate({bottom: 0} , 'slow');
            } , 3000);
        }
        $('.notif_close').click(function () {
            $('.notif_banner_container').delay(300).animate({bottom: '-150px'} , 'fast').delay(3000).fadeOut().end();
            localStorage.setItem('notif_banner_closed' , true);
        });
        /* Notif Banner */

        // Start Goftino
        !function(){var a=window,d=document;function g(){var g=d.createElement("script"),i="lXpDBP",s="https://www.goftino.com/widget/"+i,l=localStorage.getItem("goftino_"+i);g.type="text/javascript",g.async=!0,g.src=l?s+"?o="+l:s;d.getElementsByTagName("head")[0].appendChild(g);}"complete"===d.readyState?g():a.attachEvent?a.attachEvent("onload",g):a.addEventListener("load",g,!1);}();
    })
})(jQuery);
jQuery(document).ready(function($){
    // Inits
    const toolTips = $('[data-toggle="tooltip"]');
    toolTips.tooltip({
        delay: {"show": 200, "hide": 100},
        trigger: "hover"
    });
    toolTips.click(function () {
        $('[data-toggle="tooltip"]').tooltip("hide");
    });
    // Inits

    setInterval(function() {
        $('.dial-btn').find('i').addClass('is-animating');
        setTimeout(function() {
            $('.dial-btn').find('i').removeClass('is-animating');
        }, 2000);
    }, 12000);


    // Add Material icons
    $('.single_add_to_cart_button').html('<i class="ic-cart" style="font-size: 150%"></i>  افزودن به سبد خرید');
    $('.cart_dropdown_link').find('span:first-child').html('<i class="ic-cart my-2"></i>');


    // Change breadcrumb trails
    $('.breadcrumb-trail').find('span.sep').html('<i class="ic-line-left"></i>');
    $('.trail-begin').find('span[itemprop="name"]').html('<span itemprop="name">صفحه اصلی</span>');


    // Full-Width shop page
    $('ul.products').removeClass('columns-3').addClass('col-12');


    // Change Sipaad phone number
    $('#product-14049').find('.woo-price').css('display' , 'none');
    // $('#product-14049').find('.woo-price').find('strong').html('برای دریافت قیمت با شماره 03132362894 تماس بگیرید');
    // $('.template-shop').find('.post-14049').find('.price').find('strong').html('برای دریافت قیمت با شماره 03132362894 تماس بگیرید');


    /* Start Change Shop buttons text temporary */
    $('.template-shop').find('li.type-product').find('.inner_product').find('.show_details_button').css('direction', 'rtl').html('افزودن به سبد خرید<i class="ic-basket mx-2" style="font-size: 115%;font-weight: bold;vertical-align: bottom;"></i>');
    $('.template-shop').find('li.type-product.post-16949').find('.inner_product').find('.show_details_button').html('مشاهده مشخصات فنی');
    $('.template-shop').find('li.type-product.post-16940').find('.inner_product').find('.show_details_button').html('مشاهده مشخصات فنی');
    $('.template-shop').find('li.type-product.post-16939').find('.inner_product').find('.show_details_button').html('مشاهده مشخصات فنی');
    $('.template-shop').find('li.type-product.post-16918').find('.inner_product').find('.show_details_button').html('مشاهده مشخصات فنی');
    $('.template-shop').find('li.type-product.post-16917').find('.inner_product').find('.show_details_button').html('مشاهده مشخصات فنی');
    $('.template-shop').find('li.type-product.post-16916').find('.inner_product').find('.show_details_button').html('مشاهده مشخصات فنی');
    $('.template-shop').find('li.type-product.post-16914').find('.inner_product').find('.show_details_button').html('مشاهده مشخصات فنی');
    $('.template-shop').find('li.type-product.post-16913').find('.inner_product').find('.show_details_button').html('مشاهده مشخصات فنی');
    $('.template-shop').find('li.type-product.post-16912').find('.inner_product').find('.show_details_button').html('مشاهده مشخصات فنی');
    $('.template-shop').find('li.type-product.post-16911').find('.inner_product').find('.show_details_button').html('مشاهده مشخصات فنی');
    $('.template-shop').find('li.type-product.post-16907').find('.inner_product').find('.show_details_button').html('مشاهده مشخصات فنی');
    $('.template-shop').find('li.type-product.post-16905').find('.inner_product').find('.show_details_button').html('مشاهده مشخصات فنی');
    $('.template-shop').find('li.type-product.post-16904').find('.inner_product').find('.show_details_button').html('مشاهده مشخصات فنی');
    $('.template-shop').find('li.type-product.post-16900').find('.inner_product').find('.show_details_button').html('مشاهده مشخصات فنی');
    $('.template-shop').find('li.type-product.post-16899').find('.inner_product').find('.show_details_button').html('مشاهده مشخصات فنی');
    $('.template-shop').find('li.type-product.post-16898').find('.inner_product').find('.show_details_button').html('مشاهده مشخصات فنی');
    $('.template-shop').find('li.type-product.post-16897').find('.inner_product').find('.show_details_button').html('مشاهده مشخصات فنی');
    $('.template-shop').find('li.type-product.post-10307').find('.inner_product').find('.show_details_button').html('مشاهده مشخصات فنی');
    $('.template-shop').find('li.type-product.post-10304').find('.inner_product').find('.show_details_button').html('مشاهده مشخصات فنی');
    $('.template-shop').find('li.type-product.post-10299').find('.inner_product').find('.show_details_button').html('مشاهده مشخصات فنی');
    /* End Change Shop buttons text temporary */


    // Customize woocommerce product desc
    //$('.woocommerce-product-details__short-description').before("<p style='font-size: 15px;font-weight: bold;padding: 4px 0;margin: 0;'>ویژگی ها</p>");


    // fadeout UAP REG SUCCESS MSG
    const uap_reg_success_msg = $('.uap-reg-success-msg');
    setTimeout(function () {
        if (uap_reg_success_msg.length == '1'){
            uap_reg_success_msg.fadeOut();
        }
    } , 3000);


    $('#uap_createuser').find('.optional').siblings('label.uap-labels-register').addClass('optional-label');

});


// Toasts
const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger'
    },
    buttonsStyling: false
});


