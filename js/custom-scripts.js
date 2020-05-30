document.onscroll = function(){
    var pos = getVerticalScrollPercentage(document.body);
    document.getElementById("scroll-bar").style.width = pos+'%';
};
function getVerticalScrollPercentage( elm ){
    var p = elm.parentNode,
        pos = (elm.scrollTop || p.scrollTop) / (p.scrollHeight - p.clientHeight ) * 100;
    return pos;
}