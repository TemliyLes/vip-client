<template>
  <div class="news-card opacity-0">
    <div class="flex" :class="direction">
      <img
        ref="image"
        :src="data?.images?.card?.url"
        class="object-cover h-[476px]"
        alt=""
      />
      <div class="h-[476px] flex flex-col justify-between p-6">
        <div class="flex flex-col gap-4">
          <Header mini>{{ data?.title?.rendered }}</Header>
          <Paragraph>{{ data?.news_fields?.description }}</Paragraph>
        </div>
        <Link to="/news">Prohlédnout technologie</Link>
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
const direction = computed(() => (props.odd ? "flex-col" : "flex-col-reverse"));
</script>
