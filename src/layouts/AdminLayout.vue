<template>
    <div>
        <header>
            <!-- Header administrativo -->
            <h1>Header Administrativo</h1>
        </header>
        <main>
            <router-view></router-view>
        </main>
        <footer>
            <!-- Footer administrativo -->
            <p>Footer Administrativo</p>
        </footer>
    </div>
</template>

<script>
export default {
    name: 'AdminLayout'
};
</script>

<style>

</style>