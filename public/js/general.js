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
        if($($ul).css('display') === 'none') {
            $($ul).fadeIn()
        }
    }, function(){
        setTimeout(function(){
            if($($ul).is(':hover')){
                $($ul).hover(function () {}, function(){
                    $(this).fadeOut()
                })
            } else {
                if(!$($a).is(':hover')){
                    $($ul).fadeOut()
                }
            }
        }, 1000)
    })
}
// Inquire menu
function inquireMenu($data, $menuSelector) {
    // For LD
    for (var p in $data){
        // Create link
        var a = document.createElement('a');
        $(a).attr('href', $data[p]['url']);
        $(a).text($data[p]['name']);
        // Create li
        var li = document.createElement('li');
        li.append(a);

        $($menuSelector).append(li);
        $($menuSelector + ' .loading').hide();
    };
}

    // LD menu
setUlMenuWidth('.project-link a[href="/projects/level-design"] span', '#ld-dropdown');
hoverMenu(' .project-link a[href="/projects/level-design"] ', '#ld-dropdown');
    // GD menu
setUlMenuWidth('.project-link a[href="/projects/game-design"] span', '#gd-dropdown');
hoverMenu(' .project-link a[href="/projects/game-design"] ', '#gd-dropdown');

// Inquire menus
$.ajax({
    url: '/menu/projects',
    type: 'GET',
    dataType: 'json',
    success : function(response, statut){
        // LD Projects
        var ld = response['ld'];
        inquireMenu(ld, '#ld-dropdown');

        // GD Projects
        var gd = response['gd'];
        inquireMenu(gd, '#gd-dropdown');
    },
    error: function(resultat, statut, erreur){
        $('li.loading').text(erreur +', rechargez la page');
    }
})

// Detect and put a timer on flash-messages for hide them
$('.flash').delay(5000).fadeOut( 500 );