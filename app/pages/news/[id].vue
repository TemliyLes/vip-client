<template>
  <div>
    <Article news :store="store" />
  </div>
</template>

<script setup>
import Article from "~/components/cards/Article.vue";
import { useNewsStore } from "~/store/news";
const store = useNewsStore();
const route = useRoute();

onMounted(async () => {
  await store.fetchData(route.params.id);
});
</script>
