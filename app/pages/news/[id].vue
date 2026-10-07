<template>
  <div class="page">
    <Article news :store="store" />
  </div>
</template>

<script setup>
import Article from "~/components/cards/Article.vue";
import { useNewsStore } from "~/store/news";

const store = useNewsStore();

const route = useRoute();
const { locale } = useI18n({ useScope: 'global' });

definePageMeta({ middleware: 'wp-language' });

await useAsyncData(`wp-news:${locale.value}:${route.params.id}`, () =>
  store.fetchData(route.params.id, locale.value),
);
</script>
