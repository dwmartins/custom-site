<template>
    <section id="usersView" class="d-flex justify-content-center">
        <div class="w-100 base_table">
            <h5 class="custom_dark mb-3">Usuários</h5>

            <div v-if="loadingUsers" class="alert alert-info fadeIn p-2" role="alert">
                <AppSpinnerLoading message="Buscando usuários..." color="text-primary-emphasis" width="big" />
            </div>

            <el-empty v-if="emptyUsers" description="Nenhum usuário encontrado." :image-size="200" >
                <el-button @click="openModal('newUser')" size="small" type="primary">Adicionar<i class="fa-solid fa-user-plus ms-2"></i></el-button>
            </el-empty>

            <div v-else-if="!loadingUsers" class="base_table overflow-x-auto shadow rounded-2 mb-5 show p-3 w-100">

                <div class="d-flex justify-content-end gap-2">
                    <el-dropdown v-if="usersSelected.length">
                        <el-button>
                            Ações<i class="fa-solid fa-chevron-down ms-2"></i>
                        </el-button>
                        <template #dropdown>
                            <el-dropdown-menu>
                                <el-dropdown-item @click="openModalDelete(true)" class="text-danger">Deletar usuários</el-dropdown-item>
                            </el-dropdown-menu>
                        </template>
                    </el-dropdown>

                    <el-button @click="openModal('newUser')" type="primary">Novo<i class="fa-solid fa-user-plus ms-2"></i></el-button>
                </div>

                <hr class="custom-hr-dark">

                <div class="container-fluid py-3">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <el-input
                                v-model="filters.input"
                                placeholder="Please Input"
                                :prefix-icon="icons.Search"
                                @input="filter()"
                            />
                        </div>
                        <div class="col-6 col-md-2 mb-3">
                            <el-select v-model="filters.role" id="filter_role" placeholder="Tipo">
                                <el-option label="Administrador" value="admin" />
                                <el-option label="Super" value="super"  />
                            </el-select>
                        </div>
                        <div class="col-6 col-md-2 mb-3">
                            <el-select v-model="filters.status" id="filter_status" placeholder="Status">
                                <el-option label="Ativo" value="Y" />
                                <el-option label="Inativo" value="N"  />
                            </el-select>
                        </div>
                        <div class="col-md-4 d-flex justify-content-end">
                            <el-button @click="filter()" type="primary"><i class="fa-solid fa-magnifying-glass me-1"></i>Filtrar</el-button>
                            <el-button @click="cleanFilter()"><i class="fa-solid fa-eraser me-1"></i>Limpar</el-button>
                        </div>
                    </div>
                </div>

                <div v-if="filteredUsers.length">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    <el-checkbox @change="selectAll($event)" size="large" />
                                </th>
                                <th class="custom_dark">Nome</th>
                                <th class="custom_dark">Tipo</th>
                                <th class="custom_dark">E-mail</th>
                                <th class="text-center custom_dark">Status</th>
                                <th class="text-center custom_dark">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in paginatedUsers" :key="user.id">
                                <th>
                                    <el-checkbox size="large" v-model="user.selected" @change="setUserSelected(user)"/>
                                </th>
                                <td class="text-secondary">
                                    <img class="user-photo me-1" :src="user.photo ? user.photo : defaultImgUser"
                                        alt="Usuário">
                                    {{ user.name }}
                                </td>
                                <td class="text-secondary fs-7">
                                    {{ user.role == "admin" ? "Administrador" : "Super" }}
                                </td>
                                <td class="text-secondary"><span class="user_email">{{ user.email }}</span></td>
                                <td class="text-secondary text-center">
                                    <span class="text-white rounded-2 px-2 fs-8"
                                        :class="{'user_active': user.active === 'Y', 'user_inative': user.active === 'N'}">
                                        {{ user.active == "Y" ? "Ativo" : "Inativo" }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <i class="fa-solid fa-eye text-secondary me-3 cursor_pointer"></i>
                                    <i @click="openModal('updateUser', user)" class="fa-solid fa-pen-to-square text-primary cursor_pointer me-3"></i>
                                    <i @click="openModalDelete(), userToDelete = user" class="fa-solid fa-trash-can text-danger cursor_pointer"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-end">
                        <el-pagination size="small" background layout="prev, pager, next" :total="filteredUsers.length ? filteredUsers.length : users.length"
                            :page-size="pagination.usersPerPage" @current-change="handlePageChange" class="mt-4" />
                    </div>
                </div>

                <el-empty v-else
                    description="Nenhum usuário encontrado, verifique os filtros aplicados."
                    :image-size="200"
                />
            </div>
        </div>
    </section>

    <el-dialog  class="dialog-delete-user" v-model="dialogs.deleteUser.active" :title="dialogs.deleteUser.multiples ? 'Excluir usuários' : 'Excluir usuário'">
        <p v-if="dialogs.deleteUser.multiples">Tem certeza que deseja excluir os usuários selecionados? Esta ação é permanente e não pode ser desfeita.</p>
        <p v-else>Tem certeza de que deseja excluir este usuário? Esta ação é permanente e não pode ser desfeita.</p>
        <template #footer>
            <div class="dialog-footer">
                <el-button @click="dialogs.deleteUser.active = false" :disabled="isLoading.deleteUser">Cancelar</el-button>
                <el-button type="danger" @click="deleteUser(dialogs.deleteUser.multiples)" :loading="isLoading.deleteUser">
                    {{ isLoading.deleteUser? "Aguarde" : "Confirmar" }}
                </el-button>
            </div>
        </template>
    </el-dialog>

    <el-dialog  class="dialog-new-user" v-model="dialogs.userInfo.active" :title="dialogs.userInfo.label">
        <form @submit.prevent="submitForm(dialogs.userInfo.action)" class="container-fluid">
            <div class="mb-2 d-flex justify-content-end align-items-center">
                <el-switch 
                    v-model="user.active"
                    :active-text="user.active ? 'Ativo' : 'Inativo'"
                />
            </div>

            <div class="row">
                <div class="mb-2 col-sm-4">
                    <label for="name" class="form-label">Nome:</label>
                    <input v-model="user.name" type="text" class="form-control form-control-sm custom_focus text-secondary" id="name">
                </div>

                <div class="mb-2 col-sm-4">
                    <label for="lastName" class="form-label">Sobrenome:</label>
                    <input v-model="user.lastName" type="text" class="form-control form-control-sm custom_focus text-secondary" id="lastName">
                </div>

                <div class="mb-2 col-sm-4">
                    <label for="email" class="form-label">E-mail:</label>
                    <input v-model="user.email" type="text" class="form-control form-control-sm custom_focus text-secondary" id="email">
                </div>

                <div class="mb-2 col-sm-4">
                    <label for="password" class="form-label">Senha:</label>
                    <el-input
                        v-model="user.password"
                        type="password"
                        show-password
                    />
                </div>

                <div class="mb-2 col-sm-4 d-flex flex-column">
                    <label for="role" class="form-label">Tipo:</label>

                    <el-select v-model="user.role" id="role">
                        <el-option label="Administrador" value="admin" :selected="user.role === 'admin'" />
                        <el-option label="Super" value="super" :selected="user.role === 'super'" />
                    </el-select>
                </div>

                <el-collapse class="mt-3" v-if="user.role === 'admin'">
                    <el-collapse-item title="Permissões">
                        <div class="d-flex flex-wrap">
                            <el-checkbox
                                v-for="permission in user.permissions"
                                :key="permission.label"  
                                :label="permission.label" 
                                v-model="permission.permission"
                                size="large" 
                            />
                        </div>
                    </el-collapse-item>
                </el-collapse>
            </div>
            <div class="dialog-footer">
                <el-button @click="dialogs.userInfo.active = false" :disabled="isLoading.userInfo">Cancelar</el-button>
                <el-button native-type="submit" type="primary" :loading="isLoading.userInfo">
                    {{ isLoading.userInfo ? 'Aguarde...' : dialogs.userInfo.buttonText }}
                </el-button>
            </div>
        </form>
    </el-dialog>
</template>

<script>
import AppSpinnerLoading from '@/components/shared/AppSpinnerLoading.vue';
import UserService from '@/services/UserService';
import defaultImgUser from '@/assets/img/default/user.png';
import { User, Search } from '@element-plus/icons-vue';
import { showAlert } from '@/helpers/showAlert';

export default {
    name: 'UsersView',
    components: {
        AppSpinnerLoading,
    },

    data() {
        return {
            defaultImgUser,
            users: [],
            filteredUsers: [],
            userToDelete: {},
            usersSelected: [],
            defaultUser: {
                name: "",
                lastName: "",
                email: "",
                password: "",
                role: "admin",
                active: false,
                permissions: {
                    users: {
                        permission: false,
                        label: "Usuários"
                    },
                    content: {
                        permission: false,
                        label: "Conteúdos do site"
                    },
                    siteInfo: {
                        permission: true,
                        label: "Informações do site"
                    },
                    emailSending: {
                        permission: false,
                        label: "Configurações de e-mail"
                    }
                }
            },
            user: {},
            pagination: {
                currentPage: 1,
                usersPerPage: 8
            },
            loadingUsers: false,
            dialogs: {
                deleteUser: {
                    active: false,
                    multiples: false,
                },
                userInfo: {
                    active: false,
                    action: "",
                    label: "",
                    buttonText: ""
                }
            },
            icons: {
                User,
                Search
            },
            isLoading: {
                userInfo: false,
                deleteUser: false
            },
            filters: {
                status: "",
                role: "",
                input: ""
            },
            emptyUsers: false,
        }
    },

    created() {
        this.getUsers();
    },

    computed: {
        paginatedUsers() {
            const start = (this.pagination.currentPage - 1) * this.pagination.usersPerPage;
            const end = start + this.pagination.usersPerPage;
            return this.filteredUsers.slice(start, end);
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
                    this.filteredUsers = this.users;

                    this.emptyUsers = !this.users.length ? true : false;
                }
            } catch (error) {
                console.error('Falha ao buscar os usuários', error);
                this.loadingUsers = false;
            }
        },

        handlePageChange(page) {
            this.pagination.currentPage = page;
        },

        selectAll(event) {
            this.users.forEach(user => {
                event ? user.selected = true : user.selected = false;
                this.setUserSelected(user);
            });
        },

        setUserSelected(userSelected) {
            if(userSelected.selected) {
                this.usersSelected.push(userSelected);
            } else {
                const index = this.usersSelected.findIndex(user => user.id === userSelected.id);

                if(index !== -1) {
                    this.usersSelected.splice(index, 1);
                }
            }
        },

        async deleteUser(multiples = false) {
            if(multiples) {
                await this.deleteMultiples();
                return;
            }

            this.isLoading.deleteUser = true;
            try {
                const response = await UserService.deleteUser(this.userToDelete.id);
                this.isLoading.deleteUser = false;
                if(response) {
                    this.dialogs.deleteUser.active = false;

                    const index = this.users.findIndex(user => user.id === this.userToDelete.id);
                    if(index !== -1) {
                        this.users.splice(index, 1);
                    }

                    showAlert('success', 'Sucesso', response.data.message);
                }
            } catch (error) {
                this.isLoading.deleteUser = false;
                this.dialogs.deleteUser.active = false;
                console.error('Falha ao deletar o usuário', error);
            }
        },

        async deleteMultiples() {
            this.isLoading.deleteUser = true;
            try {
                let ids = [];

                for(const user of this.usersSelected) {
                    ids.push(user.id);
                }

                try {
                    const response = await UserService.deleteMultiples({ids: ids});
                    this.isLoading.deleteUser = false;
                    this.usersSelected = [];
                    
                    if(response) {
                        this.dialogs.deleteUser.active = false;

                        for(const id of ids) {
                            const index = this.users.findIndex(user => user.id === id);

                            if(index !== -1) {
                                this.users.splice(index, 1);
                            }
                        }
                    }

                    showAlert('success', 'Sucesso', response.data.message);
                } catch (error) {
                    this.isLoading.deleteUser = false;
                    this.dialogs.deleteUser.active = false;
                }

            } catch (error) {
                console.error('Falha ao deletar os usuários', error);
            }
        },

        openModal(action, user = null) {
            switch (action) {
                case 'newUser':
                    this.dialogs.userInfo.action = "newUser";
                    this.dialogs.userInfo.label = "Novo usuário";
                    this.dialogs.userInfo.buttonText = "Salvar";
                    break;
                case 'updateUser':
                    this.dialogs.userInfo.action = "updateUser";
                    this.dialogs.userInfo.label = "Atualizar usuário";
                    this.dialogs.userInfo.buttonText = "Atualizar";
                    break;
            
                default:
                    break;
            } 

            this.user = {...this.defaultUser};

            if(user) {
                this.user = {...user};
                this.user.active = user.active == "Y" ? true : false;
                console.log(user)
            }

            this.dialogs.userInfo.active = true;
        },

        openModalDelete(multiples = false) {
            this.dialogs.deleteUser.multiples = multiples ? true : false;
            this.dialogs.deleteUser.active = true;
        },

        async submitForm(action) {
            if(action === 'newUser') {
                this.isLoading.userInfo = true;

                try {
                    const response = await UserService.newUser(this.user);
                    this.isLoading.userInfo = false;
                    this.dialogs.userInfo.active = false;

                    if(response) {
                        showAlert('success', 'Sucesso', response.data.message);
                        this.users.push({ ...response.data.userData });
                        this.emptyUsers = !this.users.length ? true : false;
                    }

                    return;
                } catch (error) {
                    this.isLoading.userInfo = false;
                    console.error('Falha ao criar o usuário.', error);
                }
            }
        },

        filter() {
            this.filteredUsers = this.users.filter(user => {
                const matchesInput = user.name.toLowerCase().includes(this.filters.input.toLowerCase()) ||
                                     user.email.toLowerCase().includes(this.filters.input.toLowerCase());
                const matchesRole = this.filters.role ? user.role === this.filters.role : true;
                const matchesStatus = this.filters.status ? (user.active === this.filters.status) : true;

                
                return matchesInput && matchesRole && matchesStatus;
            });
        },

        cleanFilter() {
            this.filters.input = "";
            this.filters.role = "";
            this.filters.status = "";

            this.filteredUsers = this.users;
        }
    }
};
</script>

<style scoped>
.base_table {
    max-width: 1400px;
}

table {
    min-width: 732px;
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