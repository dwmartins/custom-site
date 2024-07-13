<template>
    <div id="appShowAlert" class="alert-container">
      <div v-for="(alert, index) in alertStore.alerts" :key="index" :class="['alert', 'alert-' + alert.type]" class="d-flex align-items-center">
        <i v-if="alert.type === 'success'" class="fa-regular fa-circle-check fs-5 pe-2 text-white"></i>
        <i v-if="alert.type === 'error'" class="fa-solid fa-circle-exclamation fs-5 pe-2 text-white"></i>
        <i v-if="alert.type === 'info'" class="fa-solid fa-triangle-exclamation fs-5 pe-2 text-white"></i>
        
        {{ alert.message }}
        <button @click="alertStore.removeAlert(alert.id)"><i class="fa-solid fa-xmark fs-5 text-white"></i></button>
      </div>
    </div>
</template>
  
<script>
import { alertStore } from '@/store/alertStore';

export default {
    name: 'AppShowAlert',
    data() {
        return { alertStore };
    },
};
</script>

<style scoped>
.alert-container {
  position: fixed;
  top: 20px;
  right: 20px;
  z-index: 1000;
  max-width: 340px;
  margin-left: 20px;
}

.alert {
  margin-bottom: 10px;
  padding: 10px;
  border-radius: 4px;
  opacity: 1;
  transition: opacity 0.5s ease-in-out;
}

.alert-success {
  background-color: #34a73d;
  color: #fff;
  border: 1px solid #2e9236;
}

.alert-error {
  background-color: #d13030;
  color: #fff;
  border: 1px solid #b83232;
}

.alert-info {
    background-color: #e6b927;
    color: #fff;
    border: 1px solid #d1a820;
}

button {
  border: none;
  background: none;
  cursor: pointer;
  float: right;
}

.alert-leave-active {
  transition: opacity 0.5s ease-in-out;
}

.alert-leave-to {
  opacity: 0;
}
</style>