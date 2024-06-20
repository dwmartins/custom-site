import { reactive } from "vue";

export const userStore = reactive({
    user: {
        id: null,
        name: "",
        lastName: "",
        email: "",
        password: "",
        token: "",
        active: "",
        role: "",
        photo: "",
        createdAt: "",
        updatedAt: ""
    },

    updateUserLogged(data) {
        userStore.user = { ...userStore.user, ...data };
    },

    clean() {
        for (let key in this.user) {
            this.user[key] = "";
        }
    }
})