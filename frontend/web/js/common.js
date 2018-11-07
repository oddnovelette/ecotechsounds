$(window).on('load', function () {
    var $preloader = $('#page-preloader'),
        $spinner   = $preloader.find('.spinner');
    $spinner.fadeOut();
    $preloader.delay(350).fadeOut('slow');
});

$(window).scroll(function() {
    if ($(window).scrollTop() > 10) {
        $('.navbar').addClass('floatingNav');
    } else {
        $('.navbar').removeClass('floatingNav');
    }
});
