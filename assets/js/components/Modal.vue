<template>
    <transition name="modal">
        <div class="modal-mask" @click="close">
            <div class="modal-wrapper">
                <div class="modal-container" @click.stop>

                    <div class="modal-header">
                        <slot name="header">
                            default header
                        </slot>
                    </div>

                    <div class="modal-body">
                        <slot name="body">
                            default body
                        </slot>
                    </div>

                    <div class="modal-footer">
                        <button class="modal-default-button" @click="$emit('close')">
                            Cancel
                        </button>
                        <button class="modal-default-button modal-delete-button" @click="$emit('close')">
                            Delete Project
                        </button>
                        <button class="modal-default-button" @click="$emit('close')">
                            Save Project
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        name: 'modal',
        methods: {
            close: function () {
                this.$emit('close');
            }
        }
    }
</script>

<style>
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, .7);
        display: flex;
        box-orient: horizontal;
        flex-flow: column nowrap;
        align-content: center;
        justify-content: center;
        transition: opacity .6s ease;
    }

    .modal-wrapper {
        display: flex;
    }

    .modal-container {
        margin: 0px auto;
        padding: 20px 30px;
        background-color: #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
        transition: all .6s ease;
        font-family: Helvetica, Arial, sans-serif;
    }

    .modal-header h3 {
        margin-top: 0;
        color: #000;
        max-width: 100%;
    }

    .modal-body {
        margin: 20px 0;
    }

    .modal-default-button {
        background-color: #ccc;
        font-size: 0.8em;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
    }

    .modal-delete-button {
        background-color: #d54;
    }


    /*
     * The following styles are auto-applied to elements with
     * transition="modal" when their visibility is toggled
     * by Vue.js.
     *
     * You can easily play with the modal transition by editing
     * these styles.
     */

    .modal-enter {
        opacity: 0;
    }

    .modal-leave-active {
        opacity: 0;
    }

    .modal-enter .modal-container,
    .modal-leave-active .modal-container {
        -webkit-transform: scale(1.0);
        transform: scale(1.0);
    }
</style>