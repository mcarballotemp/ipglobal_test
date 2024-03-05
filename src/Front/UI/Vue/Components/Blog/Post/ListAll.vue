<template>
  <div class="container my-1">
    <h1 class="mb-4">Posts</h1>
    <div class="row">
      <div class="col-md-4 d-flex align-items-stretch" v-for="post in posts" :key="post.id">
        <div class="card mb-4 w-100">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title mb-2">{{ post.title }}</h5>
            <div class="mt-auto">
              <router-link :to="{ name: 'PostDetail', params: { id: post.id }}" class="btn btn-primary">Read</router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

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
    $route(to, from) {
      this.loadPosts();
    },
  },
  methods: {
    loadPosts() {
      axios
        .get("/api/blog/posts")
        .then((response) => {
          this.posts = response.data;
        })
        .catch((error) => console.error("Error loading Posts data", error));
    },
  },
};
</script>
