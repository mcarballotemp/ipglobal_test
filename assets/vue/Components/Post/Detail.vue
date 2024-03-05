<template>
  <div class="container">
    <h1>Detalle del Post</h1>
    <div class="card">
      <div class="card-body">
        <h2 class="card-title">{{ post.title }}</h2>
        <p class="card-text">{{ post.body }}</p>
        <h3>Autor</h3>
        <p>Nombre: {{ post.author.name }}</p>
        <p>Email: {{ post.author.email }}</p>
        <router-link to="/" class="btn btn-primary">Volver al listado</router-link>
      </div>
    </div>
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
  // Simulamos la carga de un post específico. En un caso real, deberías obtener estos datos de tu backend o API.
  created() {
    const posts = [
      { id: 1, title: "Post 1", body: "Contenido del post 1", author: { name: "Autor 1", email: "autor1@example.com" }},
      { id: 2, title: "Post 2", body: "Contenido del post 2", author: { name: "Autor 2", email: "autor2@example.com" }},
      // Más posts...
    ];

    this.post = posts.find(post => post.id === parseInt(this.$route.params.id));
  },
};
</script>
