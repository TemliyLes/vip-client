<template>
  <article class="h-full w-full flex-1 bg-milk p-8 sm:min-h-[360px]">
    <header class="flex gap-3">
      <img
        v-if="image"
        class="w-12 h-12 shrink-0 object-cover"
        :src="image?.url"
        :alt="data?.review_fields?.name"
      />
      <div v-else class="shrink-0">
        <div class="w-12 aspect-square object-cover bg-beige"></div>
      </div>
      <div class="flex flex-col">
        <Header tag="h3" mini>{{ decodeWpText(data?.title?.rendered) }}</Header>
        <Paragraph class="text-darkbeige">{{
          data?.review_fields?.date
          }}</Paragraph>
      </div>
    </header>
    <blockquote class="mt-3">
      <Paragraph>{{
        data?.review_fields?.description?.raw
        }}</Paragraph>
    </blockquote>
  </article>
</template>

<script setup>
import Header from "../ui/Header.vue";
import Paragraph from "../ui/Paragraph.vue";
import { decodeWpText } from "~/utils/decodeWpText";
const props = defineProps({
  data: {
    type: Object,
  },
});
const image = computed(() => props.data?.review_fields?.image);
</script>
