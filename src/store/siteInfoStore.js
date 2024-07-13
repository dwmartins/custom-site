import { reactive } from 'vue';

export const siteInfoStore = reactive({
    constants: {
        webSiteName: "",
        email: "",
        phone: "",
        city: "",
        state: "",
        address: "",
        workSchedule: "",
        instagram: "",
        facebook: "",
        description: "",
        keywords: "",
        ico: "",
        logoImage: "",
        coverImage: "",
        defaultImage: ""
    },

    updateConstants(data) {
        siteInfoStore.constants = { ...siteInfoStore.constants, ...data };
    }
});
