<template>
    <section id="adminLayout">
        <nav class="h-100 w-100 shadow" :class="showNav && 'showNav'">
            <div class="nav-logo d-flex justify-content-center py-3">
                <img :src="logoImage" alt="Logo do site">
            </div>
            <ul class="navbar-nav p-2">
                <li class="nav-item p-1">
                    <router-link class="nav-link text-secondary" active-class="active-link" to="/app/dashboard"><i class="fa-solid fa-gears me-2 opacity-75"></i>Dashboard</router-link>
                </li>
                <li class="nav-item p-1" v-if="userStore.user.permissions.siteInfo.permission">
                    <router-link class="nav-link text-secondary" active-class="active-link" to="/app/informacoes-basicas"><i class="fa-solid fa-gears me-2 opacity-75"></i>Informações Básicas</router-link>
                </li>
                <li class="nav-item p-1" v-if="userStore.user.permissions.content.permission">
                    <router-link class="nav-link text-secondary" active-class="active-link" to="/app/portfolio"><i class="fa-solid fa-image me-2 opacity-75"></i>Portfolio</router-link>
                </li>
                <li class="nav-item p-1" v-if="userStore.user.permissions.content.permission">
                    <router-link class="nav-link text-secondary" active-class="active-link" to="/app/projetos-selecionados"><i class="fa-solid fa-photo-film me-2 opacity-75"></i>Projetos Selecionados</router-link>
                </li>
                <li class="nav-item p-1" v-if="userStore.user.permissions.users.permission">
                    <router-link class="nav-link text-secondary" active-class="active-link" to="/app/usuarios"><i class="fa-solid fa-users me-2 opacity-75"></i>Usuários</router-link>
                </li>
                <li class="nav-item p-1" v-if="userStore.user.permissions.emailSending.permission">
                    <router-link class="nav-link text-secondary" active-class="active-link" to="/app/configuracoes-email"><i class="fa-solid fa-envelope me-2 opacity-75"></i>Configurações de e-mail</router-link>
                </li>
            </ul>
        </nav>
        <main :class="showNav && 'showMain'">
            <div class="p-2 d-flex justify-content-between shadow header gap-4">
                <button class="btn border-0" @click="showNavigation()">
                    <i :class="['fa-solid fs-4', iconNavigation]"></i>
                </button>
                <div class="d-flex justify-content-center align-items-center gap-2">
                    <a id="btn-visit-site" href="/" target="_blank" class="btn btn-outline-primary d-flex align-items-center"><i v-if="innerWidth >= 342" class="fa-solid fa-globe me-1 text-primary"></i>SITE</a>
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img class="user-photo me-1" :src="userStore.user.photo ? user.pathPhoto + userStore.user.photo : require('@/assets/img/default/user.png')" alt="Foto">
                            {{ userStore.user.name }}
                            <template v-if="innerWidth >= 375">
                                {{ userStore.user.lastName }}
                            </template>
                        </button>
                        <ul class="dropdown-menu">
                            <li class="mb-2">
                                <router-link class="dropdown-item" to="/app/minha-conta"><v-icon class="me-2" name="md-manageaccounts-outlined"/>Minha conta</router-link>
                            </li>
                            <li>
                                <a class="dropdown-item cursor_pointer" @click="logout()"><v-icon class="me-2" name="md-logout"/>Sair</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="routes p-2">
                <router-view></router-view>
            </div>
        </main>
        
    </section>
</template>

<script>
import { siteInfoStore } from '@/store/siteInfoStore';
import defaultLogo from '@/assets/img/default/defaultLogo.png';
import AuthService from '@/services/AuthService';
import { OhVueIcon, addIcons } from 'oh-vue-icons';
import { MdManageaccountsOutlined, MdLogout } from 'oh-vue-icons/icons';
import { userStore } from '@/store/userStore';

addIcons(MdManageaccountsOutlined, MdLogout);

export default {
    name: 'AdminLayout',

    components: {
        'v-icon': OhVueIcon
    },

    data() {
        return {
            siteInfoStore,
            userStore,
            logoImage: siteInfoStore.constants.logoImage ? `${this.$API_URL}/uploads/systemImages/${siteInfoStore.constants.logoImage}` : defaultLogo, 
            innerWidth: 0,
            showNav: true,
            iconNavigation: "fa-xmark",
            user: {
                pathPhoto: `${this.$API_URL}/uploads/userImages/`
            }
        }
    },
    mounted() {
        window.addEventListener('resize', this.onResize);
        this.innerWidth = window.innerWidth;
        this.updateNavSize();
    },

    methods: {
        onResize() {
            this.innerWidth = window.innerWidth;
            this.updateNavSize();
        },

        updateNavSize() {
            if(this.innerWidth <= 768) {
                this.showNav = false;
                this.iconNavigation = 'fa-bars';
            }
        },

        showNavigation() {
            if(!this.showNav) {
                this.iconNavigation = 'fa-xmark';
                this.showNav = true;
            } else {
                this.iconNavigation = 'fa-bars';
                this.showNav = false;
            }
        },

        logout() {
            AuthService.logout();
            this.$router.push('/');
        }
    }
};
</script>

<style scoped>
.active-link, .active-link i{
    color: var(--text-primary) !important;
    font-weight: bold;
}

nav {
    transition: ease-out 0.3s;
    max-width: 270px;
    position: absolute;
    left: -270px;
}

nav.showNav {
    left: 0;
}

main {
    margin-left: 0px;
    transition: ease-out 0.3s;
}

main.showMain {
    margin-left: 270px;
}

nav .nav-link:hover, nav .nav-link:hover i {
    color: #4e66f8 !important;
    font-weight: 600;
}

.nav-logo img{
    width: 100px;
    height: 50px;
    object-fit: cover;
}

nav .nav-link i {
    min-width: 25px;
}

.routes {
    max-height: calc(100vh - 56px);
    overflow-y: scroll;
}

.routes::-webkit-scrollbar {
    width: 0! important
}

.routes {
    overflow: -moz-scrollbars-none; 
}

.routes {
    -ms-overflow-style: none; 
}

#btn-visit-site:hover .fa-globe {
    color: #fff !important;
    transition: 0.28s ease-in-out;
}

.user-photo {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    object-fit: cover;
}

@media screen and (min-width: 480px){
    .routes {
        padding: 25px !important;
    }
}

</style>