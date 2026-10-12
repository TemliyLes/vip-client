<template>
  <section v-if="data.items.length" class="mt-12 sm:mt-24">
    <Container>
      <header class="flex flex-col gap-4 items-center">
        <Title>{{ $t('ui.components.blocks.FAQ.titleText1') }}</Title>
        <Header class="text-center">{{ $t('ui.components.blocks.FAQ.headerText1') }}</Header>
        <Paragraph class="text-center">{{ $t('ui.components.blocks.FAQ.paragraphText1') }}</Paragraph>
      </header>
      <Faq :key="faqKey" :data="data.items" />
      <div v-if="data.page < data.totalPages" class="mt-8 flex flex-col items-center gap-4" :aria-busy="loadingMore">
        <p v-if="loadMoreError" role="alert" class="text-sm text-wine">
          {{ $t('ui.components.blocks.FAQ.loadError') }}
        </p>
        <Button :form="false" :disabled="loadingMore" @click="loadMore">
          {{ $t(loadingMore ? 'ui.components.blocks.FAQ.loading' : 'ui.components.blocks.FAQ.loadMore') }}
        </Button>
      </div>
    </Container>
  </section>
</template>

<script setup>
import Header from "../ui/Header.vue";
import Title from "../ui/Title.vue";
import Paragraph from "../ui/Paragraph.vue";
import Container from "../ui/Container.vue";
import { useFaqStore } from "~/store/faq.js";
import Faq from "../ui/Faq.vue";
import Button from "../ui/Button.vue";
const props = defineProps({
  category: { type: Object, default: null },
});
const store = useFaqStore();
const { locale } = useI18n({ useScope: "global" });
const { $ScrollTrigger } = useNuxtApp();
const loadingMore = ref(false);
const loadMoreError = ref(false);
let disposed = false;
onBeforeUnmount(() => { disposed = true; });
const faqKey = computed(() => `faq:${locale.value}:${props.category?.id ?? 'all'}`);
watch(faqKey, () => {
  loadingMore.value = false;
  loadMoreError.value = false;
});
const { data } = await useAsyncData(faqKey, () =>
  props.category
    ? store.getFaqForCategory(props.category, locale.value)
    : store.getFaq(locale.value),
  { default: () => ({ items: [], page: 1, totalPages: 0, tagId: null }) },
);

async function loadMore() {
  if (loadingMore.value || data.value.page >= data.value.totalPages) return;
  const requestKey = faqKey.value;
  const language = locale.value;
  const current = data.value;
  loadingMore.value = true;
  loadMoreError.value = false;
  try {
    const next = current.tagId == null
      ? await store.getFaq(language, current.page + 1)
      : await store.getFaqByTag(current.tagId, language, current.page + 1);
    if (disposed || faqKey.value !== requestKey || data.value !== current) return;
    const ids = new Set(current.items.map(item => item.id));
    data.value = { ...next, items: [...current.items, ...next.items.filter(item => !ids.has(item.id))] };
    await nextTick();
    if (!disposed && faqKey.value === requestKey) $ScrollTrigger?.refresh();
  } catch {
    if (!disposed && faqKey.value === requestKey) loadMoreError.value = true;
  } finally {
    if (!disposed && faqKey.value === requestKey) loadingMore.value = false;
  }
}
</script>
