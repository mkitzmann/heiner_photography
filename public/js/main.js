$(document).ready(function() {

    $('img').css('display', 'none');

    $('img').fadeIn(2000);



    $('.gallery-next').click(function(event) {

        event.preventDefault();

        newLocation = this.href;

        $('img').fadeOut(300, newpage);

    });



    function newpage() {

        window.location = newLocation;

    }

});