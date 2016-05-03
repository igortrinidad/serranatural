<template>
<div class="loader-overlay" v-show="isVisible" transition="fade">
    <div class="loader-spinner">
        <div class="preloader pl-xl">
            <svg class="pl-circular" viewBox="25 25 50 50">
                <circle class="plc-path" cx="50" cy="50" r="20"></circle>
            </svg>
        </div>
    </div>

</template>

<script>
    export default {

        props: [],

        events: {
            'open-loader-full' (obj) {
                this.isVisible = true
            },
            'close-loader-full' (obj) {
                this.isVisible = false
            }
        },

        data () {
            return {
                isVisible: false,
                name: ''
            }
        },

        methods: {

            open (obj) {
                //if (obj.modal == this.name) {
                    this.isVisible = !this.isVisible
                //}
            },

        },
    }
</script>

<style scoped>

    .fade-transition {
        transition: opacity .4s ease;
    }
    .fade-leave {
        opacity: 0;
    }

    .loader-overlay {
        z-index:1000;
        background-color: rgba(0,0,0,0.3);
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }
@media (min-width: 768px) {
    .loader-spinner {
        position: absolute;
        top: 46%;
        left: 46%;

    }
}
@media (max-width: 767px) {
    .loader-spinner {
        position: absolute;
        top: 43%;
        left: 40%;

    }
}

</style>