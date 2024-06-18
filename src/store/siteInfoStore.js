import { createStore } from 'vuex';

export const store = createStore({
    state: {
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
            icon: "",
            logoImage: "",
            coverImage: "",
            defaultImage: ""
        }
    },
    mutations: {
        setConstants(state, payload) {
            state.constants = { ...state.constants, ...payload };
        }
    },
    actions: {
        updateConstants({ commit }, data) {
            commit('setConstants', data);
        }
    },
    getters: {
        constants: (state) => state.constants
    }
});
