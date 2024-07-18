<template>
    <section id="emailConfigView" class="d-flex flex-column align-items-center">
        <div>
            <h5 class="custom_dark mb-3">Configurações de e-mail</h5>

            <form @submit.prevent="submitConfigsEmail()" class="container-fluid shadow rounded-2 mb-5">
                <div class="container-fluid p-3">
                    <p class="custom_dark fs-7" >Propriedades do servidor SMTP</p>
                    <hr class="custom-hr-dark">

                    <div class="mb-3 d-flex justify-content-end">
                        <span class="form-label text-secondary me-2" >Ativado</span> 
                        <label class="switch">
                            <input v-model="emailConfig.activated" type="checkbox">
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <fieldset :disabled="!emailConfig.activated" class="row">
                        <div class="mb-3 col-sm-6" :class="{'opacity-75': !emailConfig.activated}">
                            <label for="server" class="form-label">Servidor:</label>
                            <input v-model="emailConfig.server" type="text" class="form-control form-control-sm custom_focus text-secondary" id="server">
                        </div>

                        <div class="mb-3 col-sm-3" :class="{'opacity-75': !emailConfig.activated}">
                            <label for="port" class="form-label">Porta:</label>
                            <input v-model="emailConfig.port" type="number" class="form-control form-control-sm custom_focus text-secondary" id="port">
                        </div>

                        <div class="mb-3 col-sm-3" :class="{'opacity-75': !emailConfig.activated}">
                            <label for="authentication" class="form-label fs-7">Autenticação:</label>
                            <select v-model="emailConfig.authentication" class="form-select custom_focus form-select-sm text-secondary" id="authentication">
                                <option value="SSL" :selected="emailConfig.authentication === 'SSL'">SSL</option>
                                <option value="TLS" :selected="emailConfig.authentication === 'TLS'">TLS</option>
                            </select>
                        </div>

                        <div class="mb-3 col-sm-6" :class="{'opacity-75': !emailConfig.activated}">
                            <label for="emailAddress" class="form-label">Endereço de e-mail:</label>
                            <input v-model="emailConfig.emailAddress" type="text" class="form-control form-control-sm custom_focus text-secondary" id="emailAddress">
                        </div>

                        <div class="mb-3 col-sm-6 col-md-3" :class="{'opacity-75': !emailConfig.activated}">
                            <label for="username" class="form-label">Usuário/E-mail:</label>
                            <input v-model="emailConfig.username" type="text" class="form-control form-control-sm custom_focus text-secondary" id="username">
                        </div>

                        <div class="mb-4 col-sm-6 col-md-3" :class="{'opacity-75': !emailConfig.activated}">
                            <label for="password" class="form-label">Senha:</label>
                            <input v-model="emailConfig.password" type="text" class="form-control form-control-sm custom_focus text-secondary" id="password">
                        </div>

                        <div class="mb-2 d-flex justify-content-end" :class="{'opacity-75': !emailConfig.activated}">
                            <button class="btn btn-sm btn-primary" :disabled="loadingSubmit">
                                <template v-if="!loadingSubmit">
                                Salvar Alterações
                                </template>
                                <template v-else>
                                    <AppSpinnerLoading message="Aguarde..." color="text-white" />
                                </template>
                            </button>
                        </div>
                    </fieldset>
                </div>
            </form>
        </div>
    </section>
</template>
 
<script>
import AppSpinnerLoading from '@/components/shared/AppSpinnerLoading.vue';

export default {
    name: 'EmailConfigView',
    components: {
        AppSpinnerLoading
    },

    data() {
        return {
            emailConfig: {
                id: null,
                server: "",
                emailAddress: "",
                username: "",
                password: "",
                port: 465,
                authentication: "TLS",
                activated: false,
                createdAt: "",
                updatedAt: ""
            },
            loadingSubmit: false
        }
    },
    methods: {
        submitConfigsEmail() {
            console.log(this.emailConfig);
        }
    }
};
</script>

<style scoped>
#emailConfigView > div{
    max-width: 1400px;
}
</style>