<template>
    <section id="publicLayout">
        <AppHeader />
        <main>
            <router-view></router-view>
        </main>
        <AppFooter />
    </section>
</template>

<script>
import AppFooter from '@/components/AppFooter.vue';
import AppHeader from '@/components/AppHeader.vue';

export default {
    name: 'PublicLayout',
    components: {
        AppFooter,
        AppHeader
    }
};
</script>

<style>

</style>