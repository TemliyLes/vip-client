<template>
  <div>
    <AlterHero />
    <Container class="mt-6 sm:mt-8">
      <Breadcrumbs :items="[{ label: $t('newsPage.title') }]" />
    </Container>

    <Container tag="section" :aria-labelledby="headingId" class="py-12 sm:py-24">
      <Header tag="h1" :id="headingId" center class="mb-8 sm:mb-12">{{ $t('newsPage.title') }}</Header>
      <NewsGrid v-if="data.items.length" :items="data.items" heading-tag="h2" />
      <Paragraph v-else class="text-center">{{ $t('newsPage.empty') }}</Paragraph>

      <div v-if="data.page < data.totalPages" class="mt-10 flex flex-col items-center gap-4" :aria-busy="loadingMore">
        <p v-if="loadMoreError" role="alert" class="text-sm text-wine">{{ $t('newsPage.loadError') }}</p>
        <Button :form="false" :disabled="loadingMore" @click="loadMore">
          {{ $t(loadingMore ? 'newsPage.loading' : 'newsPage.loadMore') }}
        </Button>
      </div>
    </Container>
  </div>
</template>

<script setup>
import AlterHero from "~/components/blocks/AlterHero.vue";
import NewsGrid from "~/components/blocks/NewsGrid.vue";
import Container from "~/components/ui/Container.vue";
import Breadcrumbs from "~/components/ui/Breadcrumbs.vue";
import Header from "~/components/ui/Header.vue";
import Paragraph from "~/components/ui/Paragraph.vue";
import Button from "~/components/ui/Button.vue";

const { t, locale } = useI18n({ useScope: 'global' });
const api = useWpApi();
const { $ScrollTrigger } = useNuxtApp();
const language = locale.value;
const headingId = useId();
const loadingMore = ref(false);
const loadMoreError = ref(false);
let disposed = false;
onBeforeUnmount(() => { disposed = true; });

function fetchPage(page) {
  return api.getPage('news', {
    page,
    per_page: 9,
    status: 'publish',
    orderby: 'date',
    order: 'desc',
    _fields: 'id,title,images,news_fields,lang',
  }, language);
}

const { data, error } = await useAsyncData(`wp-news-archive:${language}`, () => fetchPage(1));
if (error.value) {
  throw createError({ statusCode: 502, statusMessage: 'News unavailable', message: t('newsPage.loadError') });
}

useWpSeo(null, () => ({ title: t('newsPage.title') }));

async function loadMore() {
  if (loadingMore.value || data.value.page >= data.value.totalPages) return;
  loadingMore.value = true;
  loadMoreError.value = false;
  try {
    const next = await fetchPage(data.value.page + 1);
    if (disposed || locale.value !== language) return;
    const ids = new Set(data.value.items.map(item => item.id));
    data.value = { ...next, items: [...data.value.items, ...next.items.filter(item => !ids.has(item.id))] };
    await nextTick();
    if (!disposed) $ScrollTrigger?.refresh();
  } catch {
    if (!disposed) loadMoreError.value = true;
  } finally {
    if (!disposed) loadingMore.value = false;
  }
}
</script>
