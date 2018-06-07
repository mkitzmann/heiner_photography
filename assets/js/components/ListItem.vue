<template>
    <div>
        <img class="handle" :src="'../../img/svg/drag.svg'">
        <div class="hovertext">
            <a href="#edit" @click="showModal = true">
                <img class="icon" :src="'../../img/svg/settings-gear-63.svg'">
            </a>
            <a :href="'projects/'+item.slug">
                <img class="icon" :src="'../../img/svg/grid-45.svg'">
            </a>
        </div>
        <div class="overviewImageMask">
            <img :src="imageDirectory+item.image" class="overviewImage">
        </div>
        <modal v-if="showModal" @close="showModal = false">
            <h3 slot="header">{{item.slug}}</h3>
            <div slot="body">
                <form name="project" method="post" enctype="multipart/form-data">
                    <div><label for="project_title" class="required">Title</label><input type="text" id="project_title" name="project[title]" required="required" :value="item.slug"></div>
                    <div><label for="project_thumbnail" class="required">Thumbnail (Image file)</label><input type="file" id="project_thumbnail" name="project[thumbnail]" required="required"></div>
                    </form>
            </div>
            <span slot="footer">
                        <button class="modal-default-button modal-save-button" @click="$emit('close')">
                            Save Project
                        </button>
                        <button class="modal-default-button modal-delete-button" @click="delete_project(item.id)">
                            Delete Project
                        </button>
            </span>

        </modal>
    </div>
</template>

<script>
    import modal from './Modal.vue'
    import axios from 'axios'

    export default {
        components: {
            "modal" : modal
        },
        data:function() {
            return {
                showModal: false,
                imageDirectory: imageDirectory,
            }
        },
        methods: {
            delete_project: function(id) {                
                var r = confirm("Do your really want to delete this project and all included photos?");
                if (r == true) {
                    console.log( 'delete element with id '+id);
                  axios.delete('project/'+id)
                        .then(function (response) {
                            console.log(response);
                        })
                        .catch(function (error) {
                            console.log(error.message);
                        });
                } else {
                  
                }
                

            }
        },
        props: {
            item: {
                item: Object,
                required: true
            }
        },
        mounted: function () {
            document.addEventListener("keydown", (e) => {
                if (this.showModal === true && e.keyCode == 27) {
                    this.showModal = false;
                }
            });
        }
        }
</script>

<style>
    .overviewImageMask {
        display: flex;
        flex-flow: column nowrap;
        align-content: center;
        justify-content: center;
        width: 300px;
        height: 200px;
        overflow: hidden;
        margin: 4px 0;
    }

    .overviewImage {
        width: 100%;
    }

    .hovertext{
        opacity: 0;
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
    }
    .overviewImageContainer:hover .hovertext{
        opacity: 1;
        transition: opacity .6s ease;
    }

    .icon{
        width: 3em;
        margin:0 1.5em;
    }

    .overviewImageContainer:hover .handle {
        opacity: 1;
        transition: opacity .6s ease;
    }
    .handle {
        z-index: 100;
        opacity: 0;
        width: 1.4em;
        position: absolute;
        margin: 0.5em;
        cursor: move;
        cursor: -webkit-grabbing;
    }
</style>