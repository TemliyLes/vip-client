<template>
  <div class="news-card">
    <div class="sm:flex" :class="direction">
      <img
        ref="image"
        :src="data?.images?.card?.url"
        class="object-cover h-[476px]"
        alt=""
      />
      <div class="sm:h-[476px] flex flex-col justify-between p-6">
        <div class="flex flex-col gap-4">
          <Header mini>{{ data?.title?.rendered }}</Header>
          <Paragraph>{{ data?.news_fields?.description }}</Paragraph>
        </div>
        <Link class="mt-6 sm:mt-0" :to="`/news/${data?.id}`"
          >Prohlédnout technologie</Link
        >
      </div>
    </div>
  </div>
</template>

<script setup>
import Paragraph from "../ui/Paragraph.vue";
import Header from "../ui/Header.vue";
import Link from "../ui/Link.vue";
const props = defineProps({
  data: {
    type: Object,
  },
  odd: {
    type: Boolean,
  },
});
const direction = computed(() =>
  props.odd ? "sm:flex-col" : "sm:flex-col-reverse",
);
</script>
