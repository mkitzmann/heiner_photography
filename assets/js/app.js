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
*/

import Vue from 'vue'
import App from './App.vue'

Vue.config.productionTip = false;

//let initialState = JSON.parse(window.__INITIAL_STATE__);

//console.log(initalState);

/* eslint-disable no-new */
new Vue({
    el: '#app',
    template: '<App/>',
    data: function() {
        return {
            items: twigProjects,
        }
    },
    components: { App },
})
