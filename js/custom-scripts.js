jQuery(document).ready(function ($) {
    // setInterval(function() {
    //     $('.dial-btn').find('i').addClass('ringing');
    //     setTimeout(function() {
    //         $('.dial-btn').find('i').removeClass('ringing');
    //     }, 5000);
    // }, 10000);

    // $('.single_add_to_cart_button').html('<i class="material-icons mx-2 align-middle">add_shopping_cart</i>افزودن به سبد خرید');
    $('.single_add_to_cart_button').html(' <svg id="i-cart" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="24" height="24" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"> <path d="M6 6 L30 6 27 19 9 19 M27 23 L10 23 5 2 2 2" /> <circle cx="25" cy="27" r="2" /> <circle cx="12" cy="27" r="2" /> </svg>افزودن به سبد خرید');
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



