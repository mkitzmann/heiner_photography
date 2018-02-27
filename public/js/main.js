$(document).ready(function() {

   // $('img').css('opacity', '0');

    //$('img').hide(0)



    $('.gallery-next').click(function(event) {

        event.preventDefault();

        newLocation = this.href;

        $('img').fadeOut(300, newpage);

    });



    function newpage() {

        window.location = newLocation;

    }

});