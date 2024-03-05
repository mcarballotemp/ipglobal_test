<template>
  <div class="container my-2">
    <div class="mb-4">
      <router-link to="/" class="btn btn-primary">← Back to Posts</router-link>
    </div>
    <div class="row">
      <div class="col-lg-8">
        <article class="mb-3">
          <h1 class="mb-3">{{ post.title }}</h1>
          <div class="post-body">
            <p>{{ post.body }}</p>
          </div>
        </article>
      </div>
      <div class="col-lg-4">
        <div class="card">
          <div class="card-header">
            Author Info
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>Name:</strong> {{ post.author.name }}</li>
            <li class="list-group-item"><strong>Email:</strong> <a :href="`mailto:${post.author.email}`">{{ post.author.email }}</a></li>
            <li class="list-group-item">
              <strong>Address:</strong> {{ post.author.address.street }}, {{ post.author.address.suite }},
              {{ post.author.address.city }}, {{ post.author.address.zipcode }}
            </li>
            <li class="list-group-item"><strong>Phone:</strong> {{ post.author.phone }}</li>
            <li class="list-group-item">
              <strong>Website:</strong> <a :href="`http://${post.author.website}`" target="_blank">{{ post.author.website }}</a>
            </li>
            <li class="list-group-item"><strong>Company:</strong> {{ post.author.company.name }}</li>
          </ul>
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
