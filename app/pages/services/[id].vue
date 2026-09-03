<template>
  <div>
    <Article :store="store" />
  </div>
</template>

<script setup>
import Article from "~/components/cards/Article.vue";
import { useArticleStore } from "~/store/article";
const store = useArticleStore();
const route = useRoute();

onMounted(async () => {
  await store.fetchArticle(route.params.id);
});
</script>
