<template>
  <main class="bg-red-100">
    <div v-if="postsStore.loading">Загрузка...</div>

    <div v-else-if="postsStore.error">
      {{ postsStore.error }}
    </div>

    <article v-for="post in postsStore.posts" :key="post.id">
      <h2>
        {{ post.title.rendered }}
      </h2>

      <div v-html="post.excerpt.rendered"></div>
    </article>

    posts {{ posts }}
  </main>
</template>
<script setup>
import { usePostsStore } from "./store/posts";
const postsStore = usePostsStore();

const posts = storeToRefs(postsStore);

await postsStore.fetchPosts();
</script>
