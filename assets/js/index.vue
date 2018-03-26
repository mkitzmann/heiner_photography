import Vue from 'vue';
import draggable from 'vuedraggable';

var app = new Vue({
el: '#app',
data: {
message: 'You loaded this page on ' + new Date().toLocaleString()
}
})