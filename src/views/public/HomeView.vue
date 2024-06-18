<template>
    <section>
        <div class="cover-image container-fluid" :style="{backgroundImage: `url(${coverImage})`}">
            <div class="container">
                <div class="container h-100 cover-content">
                    <div class="row align-items-center h-100">
                        <div class="col-12 col-md-8">
                            <h1 class="text-white fw-bold mb-4">Venha fazer seu projeto conosco</h1>
                            <p class="text-white fs-5 mb-4">Solicite um orçamento agora, será um prazer atende-lo</p>
                            <div class="d-flex flex-column gap-3 flex-md-row">
                                <router-link class="link_outline_none btn btn-primary fw-bold" to="/portfolio">VER NOSSOS TRABALHOS</router-link>
                                <router-link class="link_outline_none btn btn-primary fw-bold" to="/contato">CONTATO</router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container my-5">
            <div class="my-5 text-center row justify-content-center">
                <h2 class="custom_dark fw-bold big-text col-12 col-md-8" data-aos="zoom-in" data-aos-duration="1000">
                    Entre em contato e solicite um orçamento!</h2>
                <p class="custom_dark">Ficaremos felizes em atendê-lo.</p>
            </div>
        </div>

        <div class="container my-5">
            <div class="row">
                <div class="col-12 col-md-6 p-3" data-aos="fade-right">
                    <p class="text-primary fw-semibold">Sobre nós</p>
                    <h3 class="custom_dark fw-semibold mb-4">Nossa empresa se dedica à criação de mesas e cadeiras robustas, intuitivas e dinâmicas.</h3>
                    <p class="custom_dark mb-4">Somos uma empresa apaixonada pela arte de criar móveis que unem funcionalidade e estilo. Nossas mesas e cadeiras são projetadas com o compromisso de oferecer durabilidade, facilidade de uso e um toque de dinamismo ao seu espaço.</p>
                    <div class="d-flex justify-content-around custom_dark">
                        <div class="text-center">
                            <h1 class="fw-bolder">30</h1>
                            <span>ANOS DE NEGOCIO</span>
                        </div>

                        <div class="text-center">
                            <h1 class="fw-bolder">120+</h1>
                            <span>PROJETOS CONCLUÍDOS</span>
                        </div>
                    </div>
                </div>
                <div class="d-none d-md-block col-md-6 p-4" data-aos="fade-left">
                    <img class="img-fluid rounded img-about " src="@/assets/img/imgAbout.jpg" alt="imagem sobre nós">
                </div>
            </div>
            <hr class="custom-hr-dark">
        </div>

        <AppReadyToStart />
    </section>
</template>

<script>
import defaultCoverImage from '@/assets/img/default/defaultCoverImage.png';
import AppReadyToStart from '@/components/AppReadyToStart.vue';
import AOS from 'aos';
import 'aos/dist/aos.css';
import { siteInfoStore } from '@/store/siteInfoStore';


export default {
    name: 'HomeView',

    components: {
        AppReadyToStart
    },

    data() {
        return {
            coverImage: siteInfoStore.constants.coverImage ? `${this.$API_URL}/uploads/site/${siteInfoStore.constants.coverImage}` : defaultCoverImage
        }
    },

    mounted() {
        AOS.init();
        this.$nextTick(() => {
            AOS.refresh()
        });
    }
};
</script>

<style scoped>
.cover-image {
    position: relative;
    height: calc(100vh - 78px);
    background-size: cover;
    /* box-shadow: inset 0px 0px 100px 500px rgba(0, 0, 0, 0.733); */
}

.cover-image::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    height: calc(100vh - 78px);
    background-color: #000000a8;
}

.cover-image > div {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}

.cover-image h1 {
    font-size: clamp(50px, 5vw, 120px);
}

.big-text {
    font-size: clamp(30px, 5vw, 50px);
}

.img-about {
    box-shadow: 10px -8px 30px 1px rgba(63, 33, 255, 0.233);
}

.view-photo {
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #00000081;
    transition: opacity 0.3s ease;
    opacity: 0;
    cursor: pointer;
}

.view-photo i {
    font-size: 80px;
    color: #fff;
}

.gallery:hover .view-photo {
    opacity: 1;
}

</style>