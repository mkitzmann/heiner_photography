<template>
<div id="app">
    <draggable v-model="projects" @start="drag=true" @end="onEnd" :options="{delay: 10,animation: 300}">
        <div v-for="project in projects" :id="project.id" class="overviewImageContainer">
            <img :src="'../img/thumbnails/'+project.thumbnail" class="overviewImage">
        </div>
    </draggable>

</div>
</template>

<script>
import draggable from 'vuedraggable'
var axios = require('axios');

export default {
    components: {
        draggable,
    },
    data:function() {
        return {
            projects: twigProjects
        }
    },
    methods: {
        onEnd: function( item) {
            console.log( 'moved element with id '+item.clone.id+' to position '+(item.newIndex+1) );

            axios.post('projects/'+item.clone.id+'/position/'+(item.newIndex+1))
                .then(function (response) {
                    console.log(response);
                })
                .catch(function (error) {
                    // Wu oh! Something went wrong
                    console.log(error.message);
                });
        }
    }
}
</script>

<style lang="scss">

*, *::before, *::after {
    box-sizing: border-box;
}

#app {
    max-width: 400px;
    margin: 0 auto;
    line-height: 1.4;
    font-family: 'Avenir', Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    color: blue;
}

h1 {
    text-align: center;
}
</style>