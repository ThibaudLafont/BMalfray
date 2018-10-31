// Slick config
$('.slick-container').slick({
    arrow: true,
    dots: true,
    infinite: true,
    centerMode: true,
    variableWidth: true,
    nextArrow: "<button type='button' class='slick-next'><img src='/img/arrow-gallery.png'></img></button>",
    prevArrow: "<button type='button' class='slick-prev'><img src='/img/arrow-gallery.png'></img></button>"
});

// Fancy Box config
$('[data-fancybox="images"]').fancybox({
    protect: true,
    loop: true,
    buttons : [
        'zoom',
        'thumbs',
        'share',
        'close',
    ]
});

// Dailymotion support
$.fancybox.defaults.media.dailymotion = {
    matcher : /dailymotion.com\/embed\/video\/(.*)\/?(.*)/,
    params : {
        additionalInfos : 0,
        autoStart : 1
    },
    type : 'iframe',
    url  : '//www.dailymotion.com/embed/video/$1'
};

// Article image fancybox
$('#project-content img').css('cursor', 'pointer')
$('#project-content img').on('click', function() {
    var image = this;
    $.fancybox.open( {
        src: this.src
    });
});

