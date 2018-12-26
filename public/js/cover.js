function redimensionnement(){
    let $image = $('.cover_home');

    let navbar = $('.navbar');
    let navbar_height = navbar.outerHeight();

    var body_width = $(window).width();
    var body_height = $(window).height();

    $image.css({
        'width': body_width + 'px',
        'height': body_height  + 'px',
        'top': '-' + navbar_height + 'px',
        'left': '0px'
    });
}

$(document).ready(function(){

    // Au chargement initial
    redimensionnement();

    // En cas de redimensionnement de la fenêtre
    $(window).resize(function(){
        redimensionnement();
    });

});