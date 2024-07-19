<template>
    <div class="d-flex align-items-center gap-2">
        <div id="appSpinnerLoading">
            <div class="spinner-border" :class="[color, width]" role="status"></div>
        </div>  
        <p class="m-0 fs-6" :class="color">{{ message }}</p>
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
            },
            width: {
                type: String,
                required: false,
                default: 'small'
            }
        }
    }
</script>

<style scoped>
.small {
    height: 22px;
    width: 22px;
}

.big {
    height: 30px;
    width: 30px; 
}
</style>