// assets/vue/App.vue
<template>
  <div id="app">
    {{ message }}
  </div>
</template>

<script>
export default {
  data() {
    return {
      message: "Hola desde Vue!",
    };
  },
};
</script>

<style scoped>
#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
