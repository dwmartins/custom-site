import { reactive } from "vue";

export const loadingPageStore = reactive({
    props: {
        message: '',
        showAlert: false
    },

    showLoadingPage(message = null) {
        this.props.message = message;
        this.props.showAlert = true;
    },

    hideLoadingPage() {
        this.props.message = '';
        this.props.showAlert = false;
    }
})