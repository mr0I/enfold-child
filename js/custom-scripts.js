jQuery(document).ready(function ($) {

    // setInterval(function() {
    //     $('.dial-btn').find('i').addClass('ringing');
    //     setTimeout(function() {
    //         $('.dial-btn').find('i').removeClass('ringing');
    //     }, 5000);
    // }, 10000);

    $('.single_add_to_cart_button').html(' <svg id="i-cart" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="24" height="24" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"> <path d="M6 6 L30 6 27 19 9 19 M27 23 L10 23 5 2 2 2" /> <circle cx="25" cy="27" r="2" /> <circle cx="12" cy="27" r="2" /> </svg>افزودن به سبد خرید');

    $('.cart_dropdown_link').find('span:first-child').html('<svg id="i-cart" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="25" height="25" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" style="margin: 10px auto;"> <path d="M6 6 L30 6 27 19 9 19 M27 23 L10 23 5 2 2 2" /> <circle cx="25" cy="27" r="2" /> <circle cx="12" cy="27" r="2" /> </svg>');


    // $('#spa_login_btn').click(function () {
    //     event.preventDefault();
    //     var user_name = $('#exampleInputEmail1').val();
    //     var pass = $('#exampleInputPassword1').val();
    //     //var nonce = $('#planet_nonce').val();
    //     var data = {
    //         action: '/spa.radshid.com',
    //         security: SpaAjax.security,
    //         //act: 'login',
    //         username: 'demo',
    //         pass: '11112'
    //     };
    //     //window.location.href= 'http://spa.radshid.com/?act=' + data.act + '&username=demo&pass=111132';
    //     $.ajax({
    //         url: SpaAjax.ajaxurl,
    //         //url: '/spa.radshid.ir',
    //         type: 'GET',
    //         xhrFields: {
    //             withCredentials: true
    //         },
    //         async: true,
    //         crossDomain: true,
    //         data: data,
    //         dataType: 'JSON',
    //         success: function (res , textStatus , xhr) {
    //             //var res= $.parseJSON( res );
    //             console.log('res ' + res);
    //             console.log('textStatus: ' + textStatus);
    //             console.log('xhr: ' + xhr);
    //         }
    //         , error: function (err) {
    //             console.log(err);
    //         }
    //         , complete: function () {
    //         }
    //     })
    // })




});


document.onscroll = function(){
    var pos = getVerticalScrollPercentage(document.body);
    document.getElementById("scroll-bar").style.width = pos+'%';
};
function getVerticalScrollPercentage( elm ){
    var p = elm.parentNode,
        pos = (elm.scrollTop || p.scrollTop) / (p.scrollHeight - p.clientHeight ) * 100;
    return pos;
}


/* Ripple Button */
var buttons = document.getElementsByClassName("single_add_to_cart_button");
Array.prototype.forEach.call(buttons, function(b){
    b.addEventListener('mouseover', createRipple);
});
function createRipple(e)
{
    var circle = document.createElement('div');
    this.appendChild(circle);
    var d = Math.max(this.clientWidth, this.clientHeight);
    circle.style.width = circle.style.height = d + 'px';
    circle.style.left = e.clientX - this.offsetLeft - d / 2 + 'px';
    circle.style.top = e.clientY - this.offsetTop - d / 2 + 'px';
    circle.classList.add('ripple');
}