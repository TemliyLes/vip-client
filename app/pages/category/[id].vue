<template>
  <AlterHero />
  <Category :data="categoryStore.category" />
</template>

<script setup>
import AlterHero from "~/components/blocks/AlterHero.vue";

import { useCategoryStore } from "~/store/category";
import Category from "~/components/blocks/Category.vue";

const categoryStore = useCategoryStore();
const route = useRoute();

onMounted(async () => {
  await categoryStore.fetchCategory(route.params.id);
});
</script>
