<template>
  <AlterHero />
  <Container v-if="title && description" class="-mb-12">
    <div class="text-center">
      <Header class="mt-12" v-if="title">{{ title }}</Header>
      <Paragraph class="mt-6" v-if="description">{{ description }}</Paragraph>
    </div>
  </Container>
  <Category :data="categoryStore.category" />
</template>

<script setup>
import AlterHero from "~/components/blocks/AlterHero.vue";
import Paragraph from "~/components/ui/Paragraph.vue";
import { useCategoryStore } from "~/store/category";
import Category from "~/components/blocks/Category.vue";
import Header from "~/components/ui/Header.vue";
import Container from "~/components/ui/Container.vue";

const categoryStore = useCategoryStore();
const route = useRoute();

const { t, locale } = useI18n({ useScope: 'global' });
definePageMeta({ middleware: 'wp-language' });

await useAsyncData(`wp-category:${locale.value}:${route.params.id}`, () =>
  categoryStore.fetchCategory(route.params.id, locale.value),
);
const table = computed(() => [
  {
    id: 14,
    title: t('categoryPages.id14.title'),
    description: t('categoryPages.id14.description'),
  },
  {
    id: 15,
    title: t('categoryPages.id15.title'),
    description: t('categoryPages.id15.description'),
  },
  {
    id: 16,
    title: t('categoryPages.id16.title'),
    description: t('categoryPages.id16.description'),
  },
]);

const currentCategory = computed(() => {
  const sourceId = categoryStore.info?.translations?.cs ?? route.params.id;
  return table.value.find((e) => e.id === Number(sourceId));
});

const title = computed(() => currentCategory.value?.title);

const description = computed(() => currentCategory.value?.description);

</script>
