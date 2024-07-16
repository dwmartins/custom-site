<template>
    <footer id="appFooter" class="container-fluid bg-body-secondary">
        <div class="container p-3">
            <div class="row">
                <div class="col-3 col-md-4 d-flex justify-content-center align-items-center mb-3 p-0">
                    <ul class="navbar-nav fs-7">
                        <li class="nav-item text-secondary"><router-link to="/" class="nav-link">Home</router-link></li>
                        <li class="nav-item text-secondary"><router-link to="/empresa" class="nav-link">Empresa</router-link></li>
                        <li class="nav-item text-secondary"><router-link to="/contato" class="nav-link">Contato</router-link></li>
                        <li class="nav-item text-secondary"><router-link to="/portifolio" class="nav-link">Portfólio</router-link></li>
                        <li class="nav-item text-secondary"><router-link to="/servicos" class="nav-link">Serviços</router-link></li>
                    </ul>
                </div>

                <div class="col-9 col-md-4 fs-7">
                    <div class="d-flex justify-content-center align-items-center h-100 mb-3 p-0">
                        <div class="d-flex flex-column gap-2 fs-7">
                            <a v-if="siteInfoStore.constants.phone" class="link_outline_none text-secondary" :class="siteInfoStore.constants.phoneIsWhatsApp == 'N' && 'ms-4'" :href="`https://wa.me/${siteInfoStore.constants.phone}`" target="_blank"><i v-if="siteInfoStore.constants.phoneIsWhatsApp == 'Y'" class="fa-brands fa-whatsapp me-2"></i>{{ siteInfoStore.constants.phone }}</a>

                            <a v-if="siteInfoStore.constants.email" class="link_outline_none text-secondary" :href="`mailto:${siteInfoStore.constants.email}`" target="_blank"><i class="fa-regular fa-envelope me-2"></i>{{ siteInfoStore.constants.email }}</a>

                            <a v-if="siteInfoStore.constants.instagram" class="link_outline_none text-secondary" :href="siteInfoStore.constants.instagram" target="_blank"><i class="fa-brands fa-instagram me-2"></i>Instagram</a>

                            <a v-if="siteInfoStore.constants.facebook" class="link_outline_none text-secondary" :href="siteInfoStore.constants.facebook" target="_blank"><i class="fa-brands fa-square-facebook me-2"></i>Facebook</a> 
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
            <div class="row fs-8">
                <div v-if="siteInfoStore.constants.webSiteName" class="col-12 col-md-6 text-secondary text-center mb-3">
                    <span>{{ siteInfoStore.constants.webSiteName }} &copy; {{ new Date().getFullYear() }}</span>
                </div>

                <div class="col-12 text-body text-center fs-8" :class="siteInfoStore.constants.webSiteName && 'col-md-6 text-center'">
                    <span>Desenvolvido por: <a class="link_outline_none text-primary" href="https://dwmcode.com" target="_blank">dwmcode</a> Desenvolvimento de sites e otimizações</span>
                </div>
            </div>
        </div>
    </footer>
</template>

<script>
import defaultLogo from '@/assets/img/default/defaultLogo.png';
import { siteInfoStore } from '@/store/siteInfoStore';

export default {
    name: 'AppFooter',
    
    data() {
        return {
            siteInfoStore,
            api_url: this.$API_URL,
            logoImage: siteInfoStore.constants.logoImage ? `${this.$API_URL}/uploads/systemImages/${siteInfoStore.constants.logoImage}` : defaultLogo
        }
    }
};

</script>

<style scoped>
.logo-footer {
    max-width: 100px;
    max-height: 100px;
    object-fit: cover;
}

@media screen and (max-width: 768px) {
    .logo-footer {
        max-width: 50px
    }
}
</style>