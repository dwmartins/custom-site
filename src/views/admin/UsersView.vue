<template>
    <section id="usersView" class="d-flex justify-content-center">
        <div class="w-100 base_table">
            <h5 class="custom_dark mb-3">Usuários</h5>

            <div v-if="loadingUsers" class="alert alert-info fadeIn p-2" role="alert">
                <AppSpinnerLoading message="Buscando usuários..." color="text-primary-emphasis" width="big" />
            </div>

            <div v-if="!loadingUsers" class="base_table overflow-x-auto shadow rounded-2 mb-5 show p-3 w-100">
                <table class="table">
                    <thead>
                        <tr>
                            <th>
                                <el-checkbox @change="selectAll($event)" size="large" />
                            </th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in paginatedUsers" :key="user.id">
                            <th>
                                <el-checkbox size="large" v-model="user.selected" />
                            </th>
                            <td class="text-secondary">
                                <img class="user-photo me-1" :src="user.photo ? user.photo : defaultImgUser"
                                    alt="Usuário">
                                {{ user.name }}
                            </td>
                            <td class="text-secondary"><span class="user_email">{{ user.email }}</span></td>
                            <td class="text-secondary text-center">
                                <span class="text-white rounded-2 px-2 fs-8"
                                    :class="{'user_active': user.active === 'Y', 'user_inative': user.active === 'N'}">
                                    {{ user.active == "Y" ? "Ativo" : "Inativo" }}
                                </span>
                            </td>
                            <td class="text-center">
                                <i class="fa-solid fa-pen-to-square text-primary cursor_pointer me-3"></i>
                                <i @click="dialogs.deleteUser = true, userToDelete = user" class="fa-solid fa-trash-can text-danger cursor_pointer"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="d-flex justify-content-end">
                    <el-pagination size="small" background layout="prev, pager, next" :total="users.length"
                        :page-size="usersPerPage" @current-change="handlePageChange" class="mt-4" />
                </div>
            </div>
        </div>
    </section>

    <el-dialog  class="dialog-delete-user" v-model="dialogs.deleteUser" title="Excluir usuário">
        <p>Tem certeza de que deseja excluir este usuário? Esta ação é permanente e não pode ser desfeita.</p>
        <template #footer>
            <div class="dialog-footer">
                <el-button @click="dialogs.deleteUser = false">Cancelar</el-button>
                <el-button type="danger" @click="deleteUser()">
                    Confirmar
                </el-button>
            </div>
        </template>
    </el-dialog>
</template>

<script>
import AppSpinnerLoading from '@/components/shared/AppSpinnerLoading.vue';
import UserService from '@/services/UserService';
import defaultImgUser from '@/assets/img/default/user.png';
import { ElNotification } from 'element-plus'

export default {
    name: 'UsersView',
    components: {
        AppSpinnerLoading
    },

    data() {
        return {
            defaultImgUser,
            users: [],
            userToDelete: {},
            currentPage: 1,
            usersPerPage: 8,
            loadingUsers: false,
            dialogs: {
                deleteUser: false
            }
        }
    },

    created() {
        this.getUsers();
    },

    computed: {
        totalPages() {
            return Math.ceil(this.users.length / this.usersPerPage);
        },

        paginatedUsers() {
            const start = (this.currentPage - 1) * this.usersPerPage;
            const end = start + this.usersPerPage;
            return this.users.slice(start, end);
        }
    },

    methods: {
        async getUsers() {
            this.loadingUsers = true;

            try {
                const response = await UserService.getUsers();
                this.loadingUsers = false;

                if(response) {
                    this.users = response.data;
                }
            } catch (error) {
                console.error('Falha ao buscar os usuários', error);
                this.loadingUsers = false;
            }
        },

        handlePageChange(page) {
            this.currentPage = page;
        },

        selectAll(event) {
            this.users.forEach(user => {
                event ? user.selected = true : user.selected = false;
            });
        },

        async deleteUser() {
            try {
                const response = await UserService.deleteUser(this.userToDelete.id);
                if(response) {
                    this.dialogs.deleteUser = false;

                    const index = this.users.findIndex(user => user.id === this.userToDelete.id);
                    if(index !== -1) {
                        this.users.splice(index, 1);
                    }

                    ElNotification({
                        title: 'Sucesso',
                        message: response.data.message,
                        type: 'error',
                    })
                    
                    // alertStore.addAlert('success', response.data.message);
                }
            } catch (error) {
                this.dialogs.deleteUser = false;
                console.error('Falha ao deletar o usuário', error);
            }
        }
    }
};
</script>

<style scoped>
.base_table {
    max-width: 1400px;
}

table {
    min-width: 510px;
}

.user-photo {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    object-fit: cover;
}

.user_active {
    background-color: #31CF80;
}

.user_inative {
    background-color: #D82C5B;
}

@media (max-width: 767.98px) { 
    .user_email {
        display: block;
        max-width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
}
</style>