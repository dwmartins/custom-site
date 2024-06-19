<template>
  <router-view></router-view>
  <AppShowAlert />
  <AppLoadingPage />
</template>

<script>
import AppShowAlert from './components/AppShowAlert.vue';
import AppLoadingPage from '@/components/AppLoadingPage.vue';

export default {
  name: 'App',
  components: {
    AppShowAlert,
    AppLoadingPage
  }
}
</script>

<style>

</style>
