<template>
  <Container v-if="items?.length" tag="section" :aria-labelledby="headingId" class="pb-12 sm:pb-24">
    <Header :id="headingId" center class="mb-8 sm:mb-12">{{ $t('newsPage.related') }}</Header>
    <NewsGrid :items="items" />
  </Container>
</template>

<script setup>
import Container from "~/components/ui/Container.vue";
import Header from "~/components/ui/Header.vue";
import NewsGrid from "~/components/blocks/NewsGrid.vue";

const props = defineProps({ item: { type: Object, required: true } });
const { locale } = useI18n({ useScope: 'global' });
const api = useWpApi();
const headingId = useId();
const language = locale.value;
const article = props.item;

const { data: items } = await useAsyncData(
  `wp-related-news:${language}:${article.id}`,
  () => {
    const categories = article['news-categories'] ?? [];
    if (!categories.length) return Promise.resolve([]);

    return api.getList('news', {
      'news-categories': categories.join(','),
      exclude: article.id,
      per_page: 3,
      status: 'publish',
      orderby: 'date',
      order: 'desc',
      _fields: 'id,title,images,news_fields,lang',
    }, language);
  },
  { default: () => [] },
);
</script>
