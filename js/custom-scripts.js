/* Version 1.0.8 */
jQuery(document).ready(function ($) {

    setInterval(function() {
        $('.dial-btn').find('i').addClass('is-animating');
        setTimeout(function() {
            $('.dial-btn').find('i').removeClass('is-animating');
        }, 2000);
    }, 12000);

    $('[data-toggle="tooltip"]').tooltip({
        delay: {"show": 300, "hide": 100}
    });

    $('.single_add_to_cart_button').html(' <svg id="i-cart" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="24" height="24" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"> <path d="M6 6 L30 6 27 19 9 19 M27 23 L10 23 5 2 2 2" /> <circle cx="25" cy="27" r="2" /> <circle cx="12" cy="27" r="2" /> </svg>افزودن به سبد خرید');

    $('.cart_dropdown_link').find('span:first-child').html('<svg id="i-bag" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="25" height="25" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" style="margin: 10px auto;"><path d="M5 9 L5 29 27 29 27 9 Z M10 9 C10 9 10 3 16 3 22 3 22 9 22 9" /></svg>');


    $('.u-column1').addClass('col-lg-6 col-md-6 col-sm-12').removeClass('col-1');
    $('.u-column2').addClass('col-lg-6 col-md-6 col-sm-12').removeClass('col-1');


    // setInterval(function () {
    //     $('.custom-header-number').slideUp();
    //     setTimeout(function () {
    //         $('.custom-header-number').slideDown().html('03135135897');
    //     },1000)
    // } , 3000)

});


// document.onscroll = function(){
//     let pos = getVerticalScrollPercentage(document.body);
//     document.getElementById("scroll-bar").style.width = pos+'%';
// };
// function getVerticalScrollPercentage( elm ){
//     let p = elm.parentNode,
//         pos = (elm.scrollTop || p.scrollTop) / (p.scrollHeight - p.clientHeight ) * 100;
//     return pos;
// }