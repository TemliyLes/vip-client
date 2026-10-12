<template>
  <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-10">
    <li v-for="item in items" :key="item.id" class="flex min-w-0 flex-col">
      <HomeNew :data="item" compact :heading-tag="headingTag" />
    </li>
  </ul>
</template>

<script setup>
import HomeNew from "~/components/cards/HomeNew.vue";

defineProps({
  items: { type: Array, default: () => [] },
  headingTag: { type: String, default: 'h3' },
});
</script>
