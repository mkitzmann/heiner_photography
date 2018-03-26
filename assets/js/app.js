require('../css/app.scss');
var Sortable = require('sortablejs');
//require('../js/index.vue');
var $ = require('jquery');


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

var el = document.getElementById('overviewContainer');
var sortable = Sortable.create(el, {
    onEnd: function (/**Event*/evt) {
    var itemEl = evt.item;  // dragged HTMLElement
    evt.to;    // target list
    evt.from;  // previous list
    evt.oldIndex;  // element's old index within old parent
    console.log(evt.newIndex);  // element's new index within new parent);
}
});