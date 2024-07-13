<template>
    <div id="appSpinnerLoading" class="d-flex align-items-center gap-2">
        <div class="spinner-border custom_spinner_btn" :class="color" role="status"></div>
        <span :class="color">{{ message }}</span>
    </div>  
</template>

<script>
    export default {
        name: 'AppSpinnerLoading',
        props: {
            message: {
                type: String,
                required: false
            },
            color: {
                type: String,
                required: false,
                default: 'text-primary'
            }
        }
    }
</script>

<style scoped>
.custom_spinner_btn {
    height: 22px;
    width: 22px;
}
</style>