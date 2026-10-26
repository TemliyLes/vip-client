<template>
  <div class="page">
    <Article news :store="store" :breadcrumbs="[{ label: $t('newsPage.title'), to: 'news' }]" />
    <RelatedNews v-if="store.data" :key="store.data.id" :item="store.data" />
  </div>
</template>

<script setup>
import Article from "~/components/cards/Article.vue";
import RelatedNews from "~/components/blocks/RelatedNews.vue";
import { useNewsStore } from "~/store/news";

const store = useNewsStore();

const route = useRoute();
const { locale } = useI18n({ useScope: 'global' });

definePageMeta({
  i18n: {
    paths: {
      cs: '/novinka/[slug]',
      ru: '/novost/[slug]',
      en: '/news/[slug]',
    },
  },
});

await useAsyncData(`wp-news:${locale.value}:${route.params.slug}`, () =>
  store.fetchData(route.params.slug, locale.value),
);
useWpSeo(() => store.data, () => ({ description: store.data?.news_fields?.description }));
</script>
