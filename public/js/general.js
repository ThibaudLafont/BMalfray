// Hide navbar
$('navbar').hide();

// Add click event
$('#topheader-mobile img').click(function(){
    // If navbar hidden
    if($('navbar').css('display') === 'none') {
        $('navbar').show();

        // If navbar showed
    } else {
        $('navbar').hide();
    }
});

// Dropdown menus

// Set ul width
function setUlMenuWidth($span, $ul)
{
    var width = $($span).outerWidth();
    $($ul).css('width', width);
}
// Show/Hide
function hoverMenu($a, $ul)
{
    $($a).hover(function(){
        $($ul).show()
    }, function(){
        if($($ul).is(':hover')){
            $($ul).hover(function () {}, function(){
                $(this).hide()
            })
        } else {
            $($ul).hide()
        }
    })
}
    // LD menu
setUlMenuWidth('.project-link a[href="/projects/level-design"] span', '#ld-dropdown');
hoverMenu(' .project-link a[href="/projects/level-design"] ', '#ld-dropdown');
    // GD menu
setUlMenuWidth('.project-link a[href="/projects/game-design"] span', '#gd-dropdown');
hoverMenu(' .project-link a[href="/projects/game-design"] ', '#gd-dropdown');

// Detect and put a timer on flash-messages for hide them
$('.flash').delay(5000).fadeOut( 500 );