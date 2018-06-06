<template>
<div>
    <draggable
            v-model="items"
            @start="drag=true"
            @end="onEnd"
            :options="{handle:'.handle',animation: 300,filter: '.ignore-elements'}"
            class="overview-wrapper">
        <div
                v-for="item in items"
                :id="item.id"
                class="overviewImageContainer">

            <listitem :item="item"/>
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
    import axios from 'axios'
    import listitem from './ListItem.vue'

    export default {
        components: {
            "draggable" : draggable,
            "listitem" : listitem
        },
        data:function() {
            return {
                items: twigProjects,
                imageDirectory: imageDirectory,
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

</style>