$(window).on("load", function () {
    offsetTop = $('h4').offset().top;
});

$(function () {
    var appear = false;
    var pagetop = $('#add');
    $(window).scroll(function () {
        if ($(this).scrollTop() > offsetTop - 100) {
            if (appear === false) {
                appear = true;
                pagetop.stop().animate({
                    'bottom': '50px'
                }, 100);
            }
        } else {
            if (appear) {
                appear = false;
                pagetop.stop().animate({
                    'bottom': '-70px'
                }, 100);
            }
        }
    });
});