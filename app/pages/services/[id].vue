<template>
  <div>
    <Article :store="store" :breadcrumbs="breadcrumbs" />
    <FAQ v-if="store.article" :category="category" class="mb-12 sm:mb-24" />
  </div>
</template>

<script setup>
import Article from "~/components/cards/Article.vue";
import FAQ from "~/components/blocks/FAQ.vue";
import { useArticleStore } from "~/store/article";
const store = useArticleStore();
const route = useRoute();
const { locale } = useI18n({ useScope: 'global' });

definePageMeta({ middleware: 'wp-language' });

await useAsyncData(`wp-service:${locale.value}:${route.params.id}`, () =>
  store.fetchArticle(route.params.id, locale.value),
);

const category = computed(() => {
  const terms = store.article?._embedded?.['wp:term']?.flat() ?? [];
  return terms.find(item =>
    item.taxonomy === 'service_category' && item.lang === locale.value,
  ) ?? null;
});

const breadcrumbs = computed(() => category.value
  ? [{ label: category.value.name, to: `/category/${category.value.id}` }]
  : [],
);
</script>
