<template>
  <div class="bg-milk p-8 sm:aspect-square">
    <div class="flex gap-3">
      <img
        v-if="image"
        class="w-12 aspect-square object-cover"
        :src="image?.url"
        :alt="data?.review_fields?.name"
      />
      <div v-else>
        <div class="w-12 aspect-square object-cover bg-beige"></div>
      </div>
      <div class="flex flex-col">
        <Header mini>{{ data?.title?.rendered }}</Header>
        <Paragraph class="text-darkbeige">{{
          data?.review_fields?.date
        }}</Paragraph>
      </div>
    </div>
    <Paragraph class="mt-3">{{
      data?.review_fields?.description?.raw
    }}</Paragraph>
  </div>
</template>

<script setup>
import Header from "../ui/Header.vue";
import Paragraph from "../ui/Paragraph.vue";
const props = defineProps({
  data: {
    type: Object,
  },
});
const image = computed(() => props.data?.review_fields?.image);
</script>
