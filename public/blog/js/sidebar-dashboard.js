$('.link_arrow').click(function() {
    $('.link_arrow').not($(this)).removeClass('transform_arrow');
    $(this).toggleClass('transform_arrow');
});
$('.bx-menu').click(function() {
    $('.sidebar').toggleClass("close_sidebar");
    $('.list_card').each(function() {
        $(this).toggleClass('card-body2');
    });
});
$('#img_logo').click(function() {
    window.location.href = "/main/view";
});
$('#text_logo').click(function() {
    window.location.href = "/main/view";
});

var elements = $('.profile_name, .job');
elements.each(function() {
    var width = $(this).width();
    if (width > 170) $(this).addClass('truncate');
});