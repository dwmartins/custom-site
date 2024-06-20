<template>
    <section id="loginView" class="container-fluid bg-primary">
        <form @submit.prevent="submitLogin()" class="bg-ice-white px-3 py-5 px-sm-4 w-100 rounded shadow mx-1 show-animation-2">
            <h4 class="text-center py-3 custom_dark">Painel</h4>

            <div class="mb-4 position-relative">
                <input @input="validateFormLogin('email')" class="form-control custom_focus custom_placeholder py-2" type="text" name="email" id="email" placeholder="Seu e-mail" autocomplete="email"
                v-model.trim="user.email" :class="{ 'invalid_input': errors.email}">
                <i class="fa-regular fa-user icon-user text-black-50"></i>
            </div>

            <div class="mb-2 position-relative">
                <input @input="validateFormLogin('password')" class="form-control custom_focus custom_placeholder py-2" :type="inputPassword" name="password" id="password" placeholder="Sua senha"
                v-model.trim="user.password" :class="{ 'invalid_input': errors.password}">
                <i @click="showPassword()" :class="viewPassword ? 'fa-eye' : 'fa-eye-slash'" class="fa-regular icon-password text-black-50 cursor_pointer"></i>
            </div>

            <div class="mb-3 text-end">
                <router-link to="/recuperar-senha" class="link_primary fs-7">Esqueci minha senha</router-link>
            </div>

            <button class="btn btn-sm btn-primary fw-semibold w-100 py-2 d-flex justify-content-center">
                <template v-if="!spinnerLoading">
                    ENTRAR
                </template>
                <template v-else>
                    <AppSpinnerLoading message="Aguarde..." color="text-white" />
                </template>
            </button>
        </form>
    </section>
</template>

<script>
import AppSpinnerLoading from '@/components/AppSpinnerLoading.vue';
import { alertStore } from '@/store/alertStore';
import AuthService from '@/services/AuthService';
import { showError } from '@/helpers/showError';

export default {
    name: 'LoginView',
    components: {
        AppSpinnerLoading
    },

    data() {
        return {
            viewPassword: false,
            inputPassword: 'password',
            spinnerLoading: false,
            user: {
                email: "",
                password: ""
            },
            errors: {
                email: null,
                password: null
            }
        }
    },

    methods: {
        showPassword() {
            this.viewPassword = !this.viewPassword;
            this.inputPassword = this.viewPassword ? 'text' : 'password';
        },

        validateFormLogin(field = null) {
            let isValid = true;

            if(field) {
                if(field === 'email') {
                    if(!this.user.email) {
                        this.errors.email = "Por favor insira seu e-mail.";
                        isValid = false;
                    } else if(!this.isValidEmail(this.user.email)) {
                        this.errors.email = "Formato de e-mail inválido.";
                        isValid = false;
                    } else {
                        this.errors.email = null;
                    }
                }

                if(field === 'password') {
                    if (!this.user.password) {
                        this.errors.password = "Por favor, insira sua senha.";
                        isValid = false;
                    } else {
                        this.errors.password = null;
                    }
                }
            } else {
                if(!this.user.email) {
                    this.errors.email = "Por favor insira seu e-mail.";
                    isValid = false;
                } else if(!this.isValidEmail(this.user.email)) {
                    this.errors.email = "Formato de e-mail inválido.";
                    isValid = false;
                } else {
                    this.errors.email = null;
                }

                if (!this.user.password) {
                    this.errors.password = "Por favor, insira sua senha.";
                    isValid = false;
                } else {
                    this.errors.password = null;
                }
            }

            return isValid;
        },

        isValidEmail(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        },

        submitLogin() {
            if(this.validateFormLogin()) {
                this.spinnerLoading = true;

                AuthService.login(this.user).then(response => {
                    this.spinnerLoading = false;
                    alertStore.addAlert('success', 'Login realizado com sucesso.');
                    AuthService.setUserLogged(response.data);
                    this.$router.push('/app/dashboard')
                })
                .catch(error => {
                    showError(error);
                    this.spinnerLoading = false;
                })

            } else {
                alertStore.addAlert('info', 'Preencha todos os campos obrigatórios');
            }
        },
    }
};
</script>

<style scoped>
section {
    display: flex;
    justify-content: center;
    align-items: center;
    height: calc(100vh - 89px);
}

form {
    max-width: 500px;
}

.icon-user, .icon-password {
    position: absolute;
    top: 50%;
    left: 95%;
    transform: translate(-50%, -50%);
    font-size: 18px;
}
</style>