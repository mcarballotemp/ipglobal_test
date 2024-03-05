<template>
  <div id="app">
    <header>
      <h1>Blog Simple en Vue</h1>
    </header>
    <!-- El componente donde se renderizarán las rutas -->
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: 'App',
};
</script>

<style>
/* Estilos globales (puedes modificarlos como prefieras) */
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}

header {
  background-color: #42b983;
  color: white;
  padding: 15px;
}

h1 {
  margin: 0;
}

a {
  color: #42b983;
}
</style>
