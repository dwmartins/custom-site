import { createRouter, createWebHistory } from 'vue-router';
import PublicLayout from '@/layouts/PublicLayout.vue';
import AdminLayout from '@/layouts/AdminLayout.vue';
import HomeView from '@/views/public/HomeView.vue';
import LoginView from '@/views/public/LoginView.vue';
import DashBoardView from '@/views/admin/DashBoardView.vue';
import BasicInformationView from '@/views/admin/BasicInformationView.vue'
import PortfolioView from '@/views/admin/PortfolioView.vue';
import UsersView from '@/views/admin/UsersView.vue';
import AuthService from '@/services/AuthService';
import { alertStore } from '@/store/alertStore';
import { loadingPageStore } from '@/store/loadingPageStore';
import { showError } from '@/helpers/showError'; 

const routes = [
    {
        path: '/',
        component: PublicLayout,
        children: [
            {
                path: '',
                name: 'Home',
                component:  HomeView
            },
            {
                path: 'login',
                name: 'Login',
                component: LoginView
            }
        ]
    },
    {
        path: '/app',
        component: AdminLayout,
        meta: { requiresAuth: true },
        children: [
            {
                path: 'dashboard',
                name: 'DashBoard',
                component: DashBoardView,
            },
            {
                path: 'informacoes-basicas',
                name: 'Informacoes-basicas',
                component: BasicInformationView,
                meta: {requirePermission: 'siteInfo' }
            },
            {
                path: 'portfolio',
                name: 'Portfolio',
                component: PortfolioView,
                meta: {requirePermission: 'content' }
            },
            {
                path: 'usuarios',
                name: 'Usuarios',
                component: UsersView,
                meta: {requirePermission: 'users' }
            }
        ]
    },
    {
        path: '/:pathMatch(.*)*',
        redirect: '/'
    },
    {
        path: '/app/:pathMatch(.*)*',
        redirect: '/app/dashboard'
    }
];

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes
});

router.beforeEach((to, from, next) => {
    const { requiresAuth, requirePermission } = to.meta;
    const isEnteringApp = to.path.startsWith('/app') && !from.path.startsWith('/app');
    
    if (requiresAuth && isEnteringApp) {
        loadingPageStore.showLoadingPage();
        AuthService.auth()
            .then(() => {
                loadingPageStore.hideLoadingPage();
                if (requirePermission) {
                    checkPermissions(to, next);
                } else {
                    next();
                }
            })
            .catch((error) => {
                loadingPageStore.hideLoadingPage();
                if (error.statusCode === 401) {
                    alertStore.addAlert('error', error.message);
                    next({ name: 'Login' });
                } else {
                    showError(error);
                    next({ name: 'Home' });
                }
            });
    } else if (requirePermission) {
        checkPermissions(to, next);
    } else {
        next();
    }
});

function checkPermissions(to, next) {
    const { requirePermission } = to.meta;

    const userLogged = AuthService.getUserLogged();
    console.log(userLogged);
    if(userLogged) {
        const permission = userLogged.permissions ?? {};

        if (userLogged.role === "super" || permission[requirePermission]?.permission) {
            next();
        } else {
            alertStore.addAlert('error', 'Você não tem permissão para acessar essa área.');
            next('/app/dashboard');
        }
    } else {
        AuthService.logout();
        next({ name: 'Login' });
    }
}

export default router;