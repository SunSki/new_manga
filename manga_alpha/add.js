$(function () {
    var appear = false;
    var offsetTop = $('.del-btn').offset().top;
    var pagetop = $('#add');
    $(window).scroll(function () {
        if ($(this).scrollTop() > offsetTop) {
            if (appear === false) {
                appear = true;
                pagetop.stop().animate({
                    'bottom': '70px'
                }, 300); //0.3秒かけて現れる
            }
        } else {
            if (appear) {
                appear = false;
                pagetop.stop().animate({
                    'bottom': '-70px' //右から-50pxの位置に
                }, 300); //0.3秒かけて隠れる
            }
        }
    });
});