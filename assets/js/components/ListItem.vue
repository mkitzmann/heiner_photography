<template>
    <div>
    <Modal v-if="showModal" @close="showModal = false">
        <div slot="body" :content="project.id"></div>
        <h3 slot="header">custom header</h3>
    </Modal>

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
</template>

<script>
    export default {
        props: {
            project: {
                project: Object,
                required: true
            }
        }
    }
</script>

<style>

</style>