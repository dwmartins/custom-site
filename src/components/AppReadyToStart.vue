<template>
    <div class="container text-center my-5" data-aos="zoom-in" data-aos-duration="1000">
        <div class="row text-center justify-content-center mb-3">
            <h2 class="custom_dark fw-bold big-text col-12 col-md-8">Pronto para tirar sua ideia do papel?</h2>
        </div>
        <router-link class="btn btn-outline-primary" to="/contato">CONTATE-NOS</router-link>
    </div>
</template>

<script>
export default {
    name: 'AppReadyToStart'
}
</script>

<style scoped>
.big-text {
    font-size: clamp(30px, 5vw, 50px);
}
</style>