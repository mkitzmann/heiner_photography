<template>
    <div>
        <img class="handle" :src="'../img/svg/drag.svg'">
        <div class="hovertext">
            <a href="#edit" @click="showModal = true">
                <img class="icon" :src="'../img/svg/settings-gear-63.svg'">
            </a>
            <a :href="'projects/'+item.slug">
                <img class="icon" :src="'../img/svg/grid-45.svg'">
            </a>
        </div>
        <img :src="'../img/thumbnails/'+item.thumbnail" class="overviewImage">
        <modal v-if="showModal" @close="showModal = false">
            <h3 slot="header">{{item.slug}}</h3>
            <div slot="body">
                <form name="project" method="post" enctype="multipart/form-data">
                    <div><label for="project_title" class="required">Title</label><input type="text" id="project_title" name="project[title]" required="required" :value="item.slug"></div>
                    <div><label for="project_thumbnail" class="required">Thumbnail (Image file)</label><input type="file" id="project_thumbnail" name="project[thumbnail]" required="required"></div>
                    </form>
            </div>

        </modal>
    </div>
</template>

<script>
    import modal from './Modal.vue'

    export default {
        components: {
            "modal" : modal
        },
        data:function() {
            return {
                showModal: false
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

    .icon{
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