<template>
<div>
    <draggable
            v-model="entries"
            @start="drag=true"
            @end="onEnd"
            :options="{handle:'.handle',animation: 300,filter: '.ignore-elements'}"
            class="overview-wrapper">
        <div
                v-for="project in entries"
                :id="project.id"
                class="overviewImageContainer">
            <modal v-if="showModal" @close="showModal = false">
                <div slot="body" :content="project.id"></div>
                <h3 slot="header">custom header</h3>
            </modal>

            <img class="handle" :src="'../img/svg/drag.svg'">
            <div class="hovertext">
                <a href="#edit" @click="showModal = true">
                    <img class="project-icon" :src="'../img/svg/settings-gear-63.svg'">
                </a>
                <a :href="'projects/'+project.slug">
                    <img class="project-icon" :src="'../img/svg/grid-45.svg'">
                </a>
            </div>
            <img :src="'../img/thumbnails/'+project.thumbnail" class="overviewImage">
        </div>
    </draggable>
    <div class="overviewImageContainer ignore-elements">
        <div class="add-project-wrapper">
            <a href="#add" class="add-project-link">+</a>
        </div>
    </div>
</div>
</template>

<script>
    import draggable from 'vuedraggable'
    import modal from './Modal.vue'

    export default {
        component: {
            draggable,
            modal,
        },
        data:function() {
            return {
                entries: twigProjects,
                showModal: false
            }
        },
        methods: {
            onEnd: function( item) {
                if(item.newIndex === item.oldIndex){
                    console.log('element position was not changed');
                }else{
                    console.log( 'moved element with id '+item.clone.id+' to position '+(item.newIndex+1) );

                    axios.post('projects/'+item.clone.id+'/position/'+(item.newIndex+1))
                        .then(function (response) {
                            console.log(response);
                        })
                        .catch(function (error) {
                            console.log(error.message);
                        });
                }

            }
        }
    }
</script>

<style>
    .overview-wrapper {
        display: flex;
        flex-flow: row wrap;
    }
    .container#overviewContainer{
        margin: 0 3vw;
    }
    .overviewImageContainer {
        display: inline-block;
        position: relative;
        margin: 0 3px;
    }

    .add-project-wrapper {
        display: flex;
        flex-flow: column wrap;
        width: 300px;
        height: 200px;
        background-color: #eee;
        align-content: center;
        justify-content: center;
        font-size: 6em;
        font-weight: 300;
        text-align: center;
        box-shadow: inset 0 0 40px #ddd;
        color: #ccc;
        margin: 0px;
        padding: 0px;
    }

    .add-project-link{
        color: #bbb;
    }

    .hovertext{
        display: none;
    }
    .overviewImageContainer:hover .hovertext{
        display: inline-block;
        position: absolute;
        width: 100%;
        z-index: 1;
        left: 50%;
        top: 50%;
        color: #fff;
        text-align: center;
        transform: translate(-50%, -50%);
    }

    .project-icon{
        width: 3em;
        margin:0 1.5em;
    }

    .overviewImageContainer:hover .handle {
        opacity: 1;
    }
    .handle {
        opacity: 0;
        width: 1.3em;
        position: absolute;
        margin: 0.5em;
        cursor: move;
        cursor: -webkit-grabbing;
    }
</style>