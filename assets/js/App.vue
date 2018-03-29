<template>
<div id="app">

    <ul id="example-1">
        <div v-for="project in projects">
            <img :src="'../img/thumbnails/'+project.thumbnail"></img>
        </div>
    </ul>

</div>
</template>

<script>
//import draggable from 'vuedraggable'

module.exports = {
    data:function() {
        return {
            projects: twigProjects
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