<template>
  <div class="container">
    <h1>{{ post.title }}</h1>
    <p>{{ post.body }}</p>
    <div class="card">
      <div class="card-body">
        <h3>{{ post.author.name }}</h3>
        <div class="author-details">
          <p>Email: {{ post.author.email }}</p>
          <p>
            Address: {{ post.author.address.street }}, {{ post.author.address.suite }},
            {{ post.author.address.city }}, {{ post.author.address.zipcode }}
          </p>
          <p>Phone: {{ post.author.phone }}</p>
          <p>
            Website:
            <a :href="`http://${post.author.website}`" target="_blank">{{
              post.author.website
            }}</a>
          </p>
          <p>Company: {{ post.author.company.name }}</p>
        </div>
      </div>
    </div>
    <div class="mt-3">
      <router-link to="/" class="btn btn-primary">Back</router-link>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      post: null,
    };
  },
  created() {
    this.loadPost();
  },
  methods: {
    loadPost() {
      const postId = this.$route.params.id;
      axios
        .get(`/api/blog/posts/${postId}/with/author`)
        .then((response) => {
          this.post = response.data;
        })
        .catch((error) => console.error("Error loading post data", error));
    },
  },
};
</script>
