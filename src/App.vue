<template>
  <router-view></router-view>
  <AppShowAlert />
</template>

<script>
import AppShowAlert from './components/AppShowAlert.vue';

export default {
  name: 'App',
  components: {
    AppShowAlert
  }
}
</script>

<style>

</style>
