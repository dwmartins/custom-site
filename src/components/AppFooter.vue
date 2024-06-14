<template>
    <footer class="container-fluid bg-body-secondary">
        <div class="container p-3">
            <div class="row">
                <div class="col-3 col-md-4 d-flex justify-content-center align-items-center mb-3 p-0">
                    <ul class="navbar-nav">
                        <li class="nav-item text-secondary"><router-link to="/" class="nav-link">Home</router-link></li>
                        <li class="nav-item text-secondary"><router-link to="/empresa" class="nav-link">Empresa</router-link></li>
                        <li class="nav-item text-secondary"><router-link to="/contato" class="nav-link">Contato</router-link></li>
                        <li class="nav-item text-secondary"><router-link to="/portifolio" class="nav-link">Portfólio</router-link></li>
                        <li class="nav-item text-secondary"><router-link to="/servicos" class="nav-link">Serviços</router-link></li>
                    </ul>
                </div>

                <div class="col-9 col-md-4">
                    <div class="d-flex justify-content-center align-items-center h-100 mb-3 p-0">
                        <div class="d-flex flex-column gap-2">
                            <a v-if="constants.phone" class="fs-6 link_outline_none text-secondary" :href="`https://wa.me/${constants.phone}`" target="_blank"><i class="fa-brands fa-whatsapp me-2"></i>{{ constants.phone }}</a>

                            <a v-if="constants.email" class="fs-6 link_outline_none text-secondary" :href="`mailto:${constants.email}`" target="_blank"><i class="fa-regular fa-envelope me-2"></i>{{ constants.email }}</a>

                            <a v-if="constants.instagram" class="fs-6 link_outline_none text-secondary" :href="constants.instagram" target="_blank"><i class="fa-brands fa-instagram me-2"></i>Instagram</a>

                            <a v-if="constants.facebook" class="fs-6 link_outline_none text-secondary" :href="constants.facebook" target="_blank"><i class="fa-brands fa-square-facebook me-2"></i>Facebook</a> 
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="h-100 d-flex justify-content-center align-items-center">
                        <img class="logo-footer" :src="logoImage" alt="Logo do site">
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div v-if="constants.webSiteName" class="col-12 col-md-6 text-secondary text-center fs-7 mb-3">
                    <span>{{ constants.webSiteName }} &copy; {{ new Date().getFullYear() }}</span>
                </div>

                <div class="col-12 text-secondary text-center fs-7" :class="constants.webSiteName && 'col-md-6 text-center'">
                    <span>Desenvolvido por: <a class="link_outline_none text-primary" href="https://dwmcode.com" target="_blank">dwmcode</a> Desenvolvimento de sites e otimizações</span>
                </div>
            </div>
        </div>
    </footer>
</template>

<script>
import defaultLogo from '@/assets/img/default/defaultLogo.png';

export default {
    name: 'AppFooter',
    
    data() {
        return {
            constants: this.$store.state.constants,
            api_url: this.$API_URL,
            logoImage: this.$store.state.constants.logoImage ? `${this.$API_URL}/uploads/site/${this.$store.state.constants.logoImage}` : defaultLogo
        }
    }
};

</script>

<style scoped>
.logo-footer {
    width: 130px;
    height: 65px;
    object-fit: cover;
}
</style>