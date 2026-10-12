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
const api = useWpApi();

definePageMeta({ middleware: 'wp-language' });

await useAsyncData(`wp-service:${locale.value}:${route.params.id}`, () =>
  store.fetchArticle(route.params.id, locale.value),
);

// Embedded terms omit is_primary, so read the complete category records.
const { data: serviceCategories } = await useAsyncData(
  `wp-service-categories:${locale.value}:${route.params.id}`,
  () => store.article
    ? api.getList('service-categories', {
      post: store.article.id,
      per_page: 100,
      _fields: 'id,name,lang,translations,is_primary',
    }, locale.value)
    : [],
  { default: () => [] },
);

const category = computed(() => {
  const terms = store.article?._embedded?.['wp:term']?.flat() ?? [];
  const categories = serviceCategories.value.length
    ? serviceCategories.value
    : terms.filter(item => item.taxonomy === 'service_category' && item.lang === locale.value);
  // Promotional labels can precede the actual service category in WordPress.
  return categories.find(item => item.is_primary || item.meta?.service_category_is_primary)
    ?? categories[0]
    ?? null;
});

const breadcrumbs = computed(() => category.value
  ? [{ label: category.value.name, to: `/category/${category.value.id}` }]
  : [],
);
</script>
