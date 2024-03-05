<template>
  <div>
    <h1>Listado de Posts</h1>
    <ul>
      <li v-for="post in posts" :key="post.id">
        <router-link :to="{ name: 'PostDetail', params: { id: post.id }}">{{ post.title }}</router-link>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  data() {
    return {
      // Este sería un ejemplo de cómo podrías estructurar tus datos
      posts: [
        { id: 1, title: "Post 1", content: "Contenido del post 1" },
        { id: 2, title: "Post 2", content: "Contenido del post 2" },
        // Agrega más posts según sea necesario
      ],
    };
  },
};
</script>
