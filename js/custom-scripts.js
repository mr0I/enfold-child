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
        delay: {"show": 300, "hide": 100},
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
    $('.single_add_to_cart_button').html('افزودن به سبد خرید');
    $('.cart_dropdown_link').find('span:first-child').html('<i class="ic-cart my-2"></i>');


    // Change breadcrumb trails
    $('.breadcrumb-trail').find('span.sep').html('<i class="ic-line-left"></i>');
    $('.trail-begin').find('span[itemprop="name"]').html('<span itemprop="name">صفحه اصلی</span>');


    // Full-Width shop page
    $('ul.products').removeClass('columns-3').addClass('col-12');


    // Change Sipaad phone number
    $('#product-14049').find('.woo-price').find('strong').html('برای دریافت قیمت با شماره 03132362894 تماس بگیرید');
    $('.template-shop').find('.post-14049').find('.price').find('strong').html('برای دریافت قیمت با شماره 03132362894 تماس بگیرید');

    /* Start Change Shop buttons text temporary */
    $('.template-shop').find('li.type-product').find('.inner_product').find('.show_details_button').html('مشاهده قیمت ردیاب');
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
    $('.woocommerce-product-details__short-description').before("<p style='font-size: 15px;font-weight: bold;padding: 4px 0;margin: 0;'>ویژگی ها</p>");


    // fadeout UAP REG SUCCESS MSG
    const uap_reg_success_msg = $('.uap-reg-success-msg');
    setTimeout(function () {
        if (uap_reg_success_msg.length == '1'){
            uap_reg_success_msg.fadeOut();
        }
    } , 4000);


    $('.header_phones').find('a').hover(function () {
        $(this).find('i').css('color', '#d91e18');
    } , function () {
        $(this).find('i').css('color', '#616161');
    });


    // Add Down Arrows to Home Slider
    //$('#full_slider_1').append(' <svg class="arrows" onclick="scroll_to_column_boxes()"> <path class="a1" d="M0 0 L30 32 L60 0"></path> <path class="a2" d="M0 20 L30 52 L60 20"></path> <path class="a3" d="M0 40 L30 72 L60 40"></path> </svg>');

});

/* Toasts */
const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger'
    },
    buttonsStyling: false
});
/* Toasts */

// Copy to Clipboard
function copyStringToClipboard (str) {
    let el = document.createElement('textarea');
    el.value = str;
    el.setAttribute('readonly', '');
    el.style = {position: 'absolute', left: '-9999px'};
    document.body.appendChild(el);
    el.select();
    document.execCommand('copy');
    document.body.removeChild(el);
}

function copyToClip(event) {
    event.preventDefault();
    let copyText = document.getElementById("short_link");
    copyStringToClipboard(copyText.value);
    let sound = document.getElementById("audio");
    sound.play();
    swalWithBootstrapButtons.fire({
        position: 'center',
        icon: 'success',
        text: 'لینک کوتاه کپی شد',
        showCloseButton: false,
        showConfirmButton: false,
        timer: 2000
    });
}

function scroll_to_column_boxes() {
    document.getElementById("first_box").scrollIntoView({ behavior: 'smooth', block: 'start' });
}



