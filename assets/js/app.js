require('../css/app.scss');
var Sortable = require('sortablejs');
var $ = require('jquery');

/*
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
    onEnd: function (evt) {
    var itemEl = evt.item;  // dragged HTMLElement
    evt.to;    // target list
    evt.from;  // previous list
    evt.oldIndex;  // element's old index within old parent
    console.log(evt.newIndex);  // element's new index within new parent);
}
});
*/

import Vue from 'vue'
import App from './App.vue'

Vue.config.productionTip = false;

//let initialState = JSON.parse(window.__INITIAL_STATE__);

//console.log(initalState);

/* eslint-disable no-new */
new Vue({
    el: '#app',
    data: {
        projects: '',
    },
    template: '<App/>',
    components: { App },
    beforeMount: function() {
        this.projects = twigProjects;
    }
})

