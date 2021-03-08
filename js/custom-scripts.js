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


    // Add Material icons
    $('.single_add_to_cart_button').html('<i class="ic-basket my-2"></i>  افزودن به سبد خرید');
    $('.cart_dropdown_link').find('span:first-child').html('<i class="ic-cart my-2"></i>');


    // Change breadcrumb trails
    $('.breadcrumb-trail').find('span.sep').html('<i class="ic-chevron-left"></i>');


    const sic = $('.social-icons');
    sic.find('a').hover(function () {
        let idd = $(this).attr('id');
        sic.find('a').css({
            'filter': 'blur(1px)',
            'color': '#757575'
        });
        if (idd === 'telegram') {
            sic.find('a#' + idd).css({
                'filter': 'initial',
                'color': '#0088cc'
            })
        }else {
            sic.find('a#' + idd).css({
                'filter': 'initial',
                'color': '#8a3ab9'
            })
        }
    }, function () {
        sic.find('a#telegram').css({
            'filter': 'initial',
            'color': '#0088cc'
        });
        sic.find('a#insta').css({
            'filter': 'initial',
            'color': '#8a3ab9'
        });
    });


    // Full-Width shop page
    $('ul.products').removeClass('columns-3').addClass('col-12');

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