<template>
    <div>
        <header>
            <!-- Header público -->
            <h1>Header Público</h1>
        </header>
        <main>
            <router-view></router-view>
        </main>
        <footer>
            <!-- Footer público -->
            <p>Footer Público</p>
        </footer>
    </div>
</template>

<script>
export default {
    name: 'PublicLayout'
};
</script>

<style>

</style>