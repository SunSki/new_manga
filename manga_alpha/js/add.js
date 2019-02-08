$(function () {
    var appear = false;
    var offsetTop = $('h4').offset().top;
    var pagetop = $('#add');
    $(window).scroll(function () {
        if ($(this).scrollTop() > offsetTop - 100) {
            if (appear === false) {
                appear = true;
                pagetop.stop().animate({
                    'bottom': '50px'
                }, 100); //0.3秒かけて現れる
            }
        } else {
            if (appear) {
                appear = false;
                pagetop.stop().animate({
                    'bottom': '-70px' //右から-50pxの位置に
                }, 100); //0.3秒かけて隠れる
            }
        }
    });
});