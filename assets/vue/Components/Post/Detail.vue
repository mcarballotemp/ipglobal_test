<template>
  <div>
    <h1>{{ post.title }}</h1>
    <p>{{ post.content }}</p>
    <router-link to="/">Volver al listado</router-link>
  </div>
</template>

<script>
export default {
  props: {
    id: {
      type: Number,
      required: true,
    },
  },
  data() {
    return {
      post: null,
    };
  },
  // Aquí asumimos que tienes los posts almacenados de alguna manera para buscar por ID
  created() {
    // Este es solo un ejemplo para simular la carga de datos
    const posts = [
      { id: 1, title: "Post 1", content: "Contenido del post 1" },
      { id: 2, title: "Post 2", content: "Contenido del post 2" },
    ];

    this.post = posts.find(post => post.id === parseInt(this.$route.params.id));
  },
};
</script>
