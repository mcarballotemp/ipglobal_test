<template>
  <div class="container">
    <h1>Posts</h1>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Título</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="post in posts" :key="post.id">
            <td>
              <router-link :to="{ name: 'PostDetail', params: { id: post.id }}">{{ post.title }}</router-link>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>


<script>
import axios from 'axios';

export default {
  data() {
    return {
      posts: [],
    };
  },
  created() {
    this.loadPosts();
  },
  watch: {
    '$route'(to, from) {
      // Llamada para cargar los datos cuando cambia la ruta
      this.loadPosts();
    }
  },
  methods: {
    loadPosts() {
      axios.get('/api/blog/posts')
        .then(response => {
          this.posts = response.data;
        })
        .catch(error => console.error("Error loading Posts data", error));
    },
  },
};
</script>