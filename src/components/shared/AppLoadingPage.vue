<template>
    <div id="appLoadingPage" v-if="loadingPageStore.props.showAlert" class="spinner-overlay">
        <div class="d-flex flex-column align-items-center">
            <div class="spinner-border text-primary custom_spinner mb-2" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p v-if="loadingPageStore.props.message" class="custom-dark fw-semibold fs-5 text-center">{{ loadingPageStore.props.message }}</p>
        </div>
    </div>
</template>

<script>
import { loadingPageStore } from '@/store/loadingPageStore';

    export default {
        name: 'AppLoadingPage',
        data() {
            return { loadingPageStore}
        }
    }
</script>

<style scoped>
.spinner-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #f8f9fa;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.custom_spinner {
    height: 60px;
    width: 60px;
    border: 10px solid #4e66f8;
    border-right-color: transparent;
}
</style>