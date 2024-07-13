<template>
    <nav id="appHeader" class="navbar navbar-expand-lg bg-body-tertiary mx-0 z-1">
        <div class="container">
            <router-link class="navbar-brand p-1" to="/">
                <div class="d-flex align-items-center ">
                    <img class="logo-header" :src="logoImage" alt="Logo do site">
                </div>
            </router-link>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#navBar" aria-controls="navBar" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navBar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-center">
                    <li class="nav-item">
                        <router-link @click="closeNavbar()" translate="no" class="nav-link" aria-current="page"
                            to="/">Home</router-link>
                    </li>

                    <li class="nav-item">
                        <router-link @click="closeNavbar()" translate="no" class="nav-link" aria-current="page"
                            to="/empresa">Empresa</router-link>
                    </li>

                    <li class="nav-item">
                        <router-link @click="closeNavbar()" class="nav-link" to="/portfolio">Portfólio</router-link>
                    </li>

                    <li class="nav-item">
                        <router-link @click="closeNavbar()" class="nav-link" to="/serviços">Serviços</router-link>
                    </li>

                    <li class="nav-item">
                        <router-link @click="closeNavbar()" class="nav-link" to="/contato">Contato</router-link>
                    </li>
                </ul>

                <div class="social-network d-flex gap-3 justify-content-center fs-3 text-center">
                    <a v-if="siteInfoStore.constants.instagram" class="text-secondary" :href="siteInfoStore.constants.instagram" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                    <a v-if="siteInfoStore.constants.phone" class="text-secondary" :href="`https://wa.me/${siteInfoStore.constants.phone}`" target="_blank"><i class="fa-brands fa-whatsapp"></i></a>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
import defaultLogo from '@/assets/img/default/defaultLogo.png';
import { siteInfoStore } from '@/store/siteInfoStore';

export default {
    name: 'AppHeader',

    data() {
        return {
            siteInfoStore,
            logoImage: siteInfoStore.constants.logoImage ? `${this.$API_URL}/uploads/systemImages/${siteInfoStore.constants.logoImage}` : defaultLogo
        }
    },

    methods: {
        closeNavbar() {
            const navBar = document.getElementById('navBar');

            if(navBar.classList.contains('show')) {
                navBar.classList.remove('show');
            }
        }
    }
}
</script>

<style scoped>
nav {
    box-shadow: 0 0 1rem rgba(0,0,0,.15)!important;
}

.logo-header {
    width: 130px;
    height: 65px;
    object-fit: cover;
}
</style>