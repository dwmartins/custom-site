<template>
    <section id="accountView">
        <div class="container-fluid">
            <h5 class="custom_dark mb-3">Minha conta</h5>

            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="shadow p-3 py-4 rounded-2">
                        <div class="d-flex flex-column flex-nowrap align-items-center justify-content-center">
                            <div class="img_user position-relative">
                                <img :src="userStore.user.photo ? user.pathPhoto + userStore.user.photo : require('@/assets/img/default/user.png')" alt="Foto">
                                <button class="btn btn-primary btn_edit_img">
                                    <i class="fa-solid fa-pencil text-white"></i>
                                </button>
                            </div>

                            <div class="text-center">
                                <p class="mt-3 mb-0 custom_dark fw-semibold">{{ userStore.user.name }} {{ userStore.user.lastName }}</p>
                                <p class="text-secondary fw-semibold">{{ capitalizeFirstLetter(userStore.user.role) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8 mb-4">
                    <div class="shadow p-3 py-4 rounded-2 mb-4">
                        <form class="container-fluid">
                            <div class="row">
                                <h6 class="text-secondary mb-3">Informações básicas</h6>

                                <div class="mb-3 col-sm-3">
                                    <label for="name" class="form-label">Nome:</label>
                                    <input v-model="user.name" type="text" class="form-control form-control-sm custom_focus text-secondary" id="name">
                                </div>

                                <div class="mb-3 col-sm-3">
                                    <label for="lastName" class="form-label">Sobrenome:</label>
                                    <input v-model="user.lastName" type="text" class="form-control form-control-sm custom_focus text-secondary" id="lastName">
                                </div>

                                <div class="mb-3 col-sm-6">
                                    <label for="email" class="form-label">E-mail:</label>
                                    <input v-model="user.email" type="text" class="form-control form-control-sm custom_focus text-secondary" id="email">
                                </div>

                                <div class="col-12 mt-4 d-flex justify-content-end">
                                    <el-button native-type="submit" type="primary" :loading="isLoading.userInfo">
                                        {{ isLoading.userInfo ? 'Aguarde...' : 'Atualizar' }}
                                    </el-button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="shadow p-3 py-4 rounded-2 mb-4">
                        <form class="container-fluid">
                            <div class="row">
                                <h6 class="text-secondary mb-3">Senha</h6>

                                <div class="mb-3 col-12">
                                    <label for="currentPassword" class="form-label">Senha Atual:</label>
                                    <el-input
                                        v-model="user.currentPassword"
                                        type="password"
                                        show-password
                                    />
                                </div>

                                <div class="mb-3 col-6">
                                    <label for="password" class="form-label">Senha Atual:</label>
                                    <el-input
                                        v-model="user.password"
                                        type="password"
                                        show-password
                                    />
                                </div>

                                <div class="mb-3 col-6">
                                    <label for="confirmPassword" class="form-label">Senha Atual:</label>
                                    <el-input
                                        v-model="user.confirmPassword"
                                        type="password"
                                        show-password
                                        id="confirmPassword"
                                    />
                                </div>

                                <div class="col-12 mt-4 d-flex justify-content-end">
                                    <el-button native-type="submit" type="primary" :loading="isLoading.newPassword">
                                        {{ isLoading.newPassword ? 'Aguarde...' : 'Atualizar' }}
                                    </el-button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="shadow p-3 py-4 rounded-2  mb-4">
                        <form class="container-fluid">
                            <div class="row">
                                <h6 class="text-secondary mb-3">Excluir conta</h6>

                                <div class="p-2">
                                    <div class="d-flex gap-3 align-items-center bg-danger-subtle rounded-2 p-3">
                                        <i class="fa-solid fa-triangle-exclamation text-danger fs-1"></i>
                                        <div>
                                            <p class="m-0 mb-1 text-danger fw-semibold fs-6">Se você excluir sua conta, perderá todos os seus dados.</p>
                                            <p class="m-0 text-danger fs-6">Esta ação é permanente e não pode ser desfeita.</p>
                                        </div>
                                    </div>
                                </div>

                                <el-checkbox v-model="confirmAccountDeletion" label="Confirmo que gostaria de excluir minha conta." size="large" />

                                <div class="d-flex justify-content-end mt-3">
                                    <el-button type="danger" :loading="isLoading.deleteAccount">
                                        {{ isLoading.deleteAccount ? 'Aguarde...' : 'Excluir conta' }}
                                    </el-button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import { userStore } from '@/store/userStore';

export default {
    name: 'AccountView',
    data() {
        return {
            userStore,
            user: {},
            confirmAccountDeletion: false,
            isLoading: {
                userInfo: false,
                newPassword: false,
                deleteAccount: false
            }
        }
    },

    created() {
        this.user = {...userStore.user};
    },  

    methods: {
        capitalizeFirstLetter(string) {
            if (!string) return '';
            return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
        }
    }
};
</script>

<style scoped>
#accountView > div {
    max-width: 1400px;
}

.img_user img{
    height: 7rem;
    width: 7rem;
    object-fit: cover;
    border-radius: 50%;
}

.btn_edit_img {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    position: absolute;
    right: 0;
    bottom: 5px;
}

</style>