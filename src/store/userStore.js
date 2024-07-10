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
        updatedAt: "",
        permissions: {
            users: "",
            content: "",
            siteInfo: "",
            emailSending: "",
        }
    },

    updateUserLogged(data) {
        if (data.permissions) {
            this.user.permissions = { ...this.user.permissions, ...data.permissions };
        }
        this.user = { ...this.user, ...data };
    },

    clean() {
        for (let key in this.user) {
            if (typeof this.user[key] === 'object') {
                for (let subKey in this.user[key]) {
                    this.user[key][subKey] = "";
                }
            } else {
                this.user[key] = "";
            }
        }
    }
});
