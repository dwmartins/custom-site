<template>
  <router-view></router-view>
  <AppShowAlert />
  <AppLoadingPage />
</template>

<script>
import AppShowAlert from './components/shared/AppShowAlert.vue';
import AppLoadingPage from '@/components/shared/AppLoadingPage.vue';

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
