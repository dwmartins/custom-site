import { reactive } from 'vue';

export const alertStore = reactive({
    alerts: [],

    addAlert(type, message, time = 3500) {
        const id = Date.now() + Math.random();
        this.alerts.push({ id, type, message });

        setTimeout(() => {
            this.removeAlert(id);
        }, time);
    },

    removeAlert(id) {
        this.alerts = this.alerts.filter(alert => alert.id !== id);
    },
});
