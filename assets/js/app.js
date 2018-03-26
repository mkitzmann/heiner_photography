require('../css/app.scss');
var $ = require('jquery');

var app = new Vue({
    el: '#app',
    data: {
        message: 'Hello Vue!'
    }
})

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
