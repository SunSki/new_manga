$('head').append(
    '<style>#main{display:none;}',
    '<style>#footer{display:none;}'
);
$(window).on("load", function () {
    $('#main').fadeIn("fast");
    $('#footer').fadeIn("fast");
});
