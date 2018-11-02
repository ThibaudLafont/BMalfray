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
setUlMenuWidth('.project-link a[href="/projects/level-design"] span', '#ld-dropdown');
setUlMenuWidth('.project-link a[href="/projects/game-design"] span', '#gd-dropdown');
// Show/Hide
    // LD menu
$(' .project-link a[href="/projects/level-design"] ').hover(function(){
    $('#ld-dropdown').show()
}, function(){
    $('#ld-dropdown').hide()
})
// GD menu
$(' .project-link a[href="/projects/game-design"] ').hover(function(){
    $('#gd-dropdown').show()
}, function(){
    $('#gd-dropdown').hide()
})

// Detect and put a timer on flash-messages for hide them
$('.flash').delay(5000).fadeOut( 500 );