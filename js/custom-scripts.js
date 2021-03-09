/* Version 1.0.8 */
jQuery(document).ready(function ($) {

    // Inits
    $('[data-toggle="tooltip"]').tooltip({
        delay: {"show": 300, "hide": 100}
    });
    // Inits

    setInterval(function() {
        $('.dial-btn').find('i').addClass('is-animating');
        setTimeout(function() {
            $('.dial-btn').find('i').removeClass('is-animating');
        }, 2000);
    }, 12000);


    // Add Material icons
    $('.single_add_to_cart_button').html('<i class="ic-basket my-2"></i>  افزودن به سبد خرید');
    $('.cart_dropdown_link').find('span:first-child').html('<i class="ic-cart my-2"></i>');

    // Change breadcrumb trails
    $('.breadcrumb-trail').find('span.sep').html('<i class="ic-chevron-left"></i>');
    $('.trail-begin').find('span[itemprop="name"]').html('<span itemprop="name">صفحه اصلی</span>');


    // Full-Width shop page
    $('ul.products').removeClass('columns-3').addClass('col-12');

    // Crisp Avatar
    setTimeout(function () {
        $('.cc-1iv2').find('.cc-15mo').remove();
        $('.cc-7doi.cc-1ada').append('<img src="https://radshid.com/wp-content/uploads/2021/03/support_avatar.jpg" width="70" height="70" alt="">');
    } , 2500)

});
