<template>
    <div>
        <header>
            <!-- Header público -->
            <h1>Header Público</h1>
        </header>
        <main>
            <router-view></router-view>
        </main>

        <AppFooter />
    </div>
</template>

<script>
import AppFooter from '@/components/AppFooter.vue';

export default {
    name: 'PublicLayout',
    components: {
        AppFooter
    }
};
</script>

<style>

</style>