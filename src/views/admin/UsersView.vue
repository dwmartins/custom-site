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
                                <input @change="selectAll()" class="form-check-input mt-0 custom_focus cursor_pointer"
                                    type="checkbox">
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
                                <input v-model="user.selected" class="form-check-input mt-0 custom_focus cursor_pointer"
                                    type="checkbox">
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
                                <i class="fa-solid fa-trash-can text-danger cursor_pointer"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- Bootstrap Pagination Controls -->
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end">
                        <li class="page-item" :class="{ disabled: currentPage === 1 }">
                            <a class="page-link" @click.prevent="previousPage">Anterior</a>
                        </li>
                        <li class="page-item" v-for="page in totalPages" :key="page"
                            :class="{ active: page === currentPage }">
                            <a class="page-link" @click.prevent="changePage(page)">{{ page }}</a>
                        </li>
                        <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                            <a class="page-link" @click.prevent="nextPage">Proximo</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>
</template>

<script>
import AppSpinnerLoading from '@/components/shared/AppSpinnerLoading.vue';
import UserService from '@/services/UserService';
import defaultImgUser from '@/assets/img/default/user.png'

export default {
    name: 'UsersView',
    components: {
        AppSpinnerLoading
    },

    data() {
        return {
            defaultImgUser,
            users: [],
            currentPage: 1,
            usersPerPage: 8,
            loadingUsers: false
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
                    console.log(this.users);
                }
            } catch (error) {
                console.error('Falha ao buscar os usuários', error);
                this.loadingUsers = false;
            }
        },

        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
            }
        },

        previousPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
        },

        changePage(page) {
            this.currentPage = page;
        },

        selectAll() {
            this.users.forEach(user => {
                user.selected = user.selected ? false : true;
            });
        },

        teste() {
            console.log(this.users);
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