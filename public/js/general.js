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

// Detect and put a timer on flash-messages for hide them
$('.flash').delay(5000).fadeOut( 500 );