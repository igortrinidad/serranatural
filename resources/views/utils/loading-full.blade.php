<style>

    .fade-transition {
        transition: opacity .4s ease-in-out;
    }
    .fade-leave {
        opacity: 0;
    }

    .loader-overlay {
        z-index:1200;
        background-color: rgba(0,0,0,0.3);
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }
@media (min-width: 769px) {
    .loader-spinner {
        position: absolute;
        top: 35%;
        left: 44%;

    }
}
@media (max-width: 767px) {
    .loader-spinner {
        position: absolute;
        top: 40%;
        left: 40%;

    }
}

</style>

<div class="loader-overlay" transition="fade">
    <div class="loader-spinner">
                <img src="/assets/ring.svg" />
    </div>
</div>

