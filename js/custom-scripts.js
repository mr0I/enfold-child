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



    $('.u-column1').addClass('col-lg-6 col-md-6 col-sm-12').removeClass('col-1');
    $('.u-column2').addClass('col-lg-6 col-md-6 col-sm-12').removeClass('col-1');


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
                'color': '#2da5d9'
            })
        }else {
            sic.find('a#' + idd).css({
                'filter': 'initial',
                'color': '#db2975'
            })
        }
    }, function () {
        sic.find('a#telegram').css({
            'filter': 'initial',
            'color': '#2da5d9'
        });
        sic.find('a#insta').css({
            'filter': 'initial',
            'color': '#db2975'
        });
    })

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