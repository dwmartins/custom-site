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
            },
            {
                path: 'portfolio',
                name: 'Portfolio',
                component: PortfolioView
            },
            {
                path: 'usuarios',
                name: 'Usuarios',
                component: UsersView,
                meta: { isAdminOnly: true }
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
    const requiresAuth = to.meta.requiresAuth;
    const isAdminOnly = to.meta.isAdminOnly;
    const isComingFromApp = from.path.startsWith('/app');

    // Função para realizar a autenticação e verificar o papel do usuário
    function authenticateAndCheckRole() {
        loadingPageStore.showLoadingPage();
        AuthService.auth()
            .then((response) => {
                loadingPageStore.hideLoadingPage();
                if (isAdminOnly && response.data.role !== 'admin' && response.data.role !== 'super') {
                    alertStore.addAlert('info', 'Restrito apenas para administradores');
                    next({ name: 'Home' });
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
                    showError(error, router);
                }
            });
    }

    // Verifica se autenticação é necessária e se não vem da rota /app
    if (requiresAuth && !isComingFromApp) {
        authenticateAndCheckRole();
    } else if (isAdminOnly) { // Se apenas a administração é necessária
        authenticateAndCheckRole();
    } else {
        next();
    }
});

export default router;