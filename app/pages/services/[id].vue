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
const { locale } = useI18n({ useScope: 'global' });

definePageMeta({ middleware: 'wp-language' });

await useAsyncData(`wp-service:${locale.value}:${route.params.id}`, () =>
  store.fetchArticle(route.params.id, locale.value),
);
</script>
