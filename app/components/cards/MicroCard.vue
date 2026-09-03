<template>
  <div>
    <NuxtLink :to="`news/${data?.id}`" class="group flex h-full gap-3 min-w-0">
      <img
        :src="data?.images?.card?.url"
        :alt="data?.name"
        class="object-cover brightness-80 transition duration-500 group-hover:brightness-100 h-18 aspect-square shrink-0"
      />

      <div class="min-w-0 flex-1">
        <Header mini class="!font-normal line-clamp-2">
          {{ data?.title?.rendered }}
        </Header>

        <Paragraph class="line-clamp-2">
          <span v-html="data?.excerpt?.rendered"></span>
        </Paragraph>
      </div>
    </NuxtLink>
  </div>
</template>

<script setup>
import Header from "../ui/Header.vue";
import Paragraph from "../ui/Paragraph.vue";

defineProps({
  data: {
    type: Object,
    default: () => ({}),
  },
});
const MAX_TEXT = 50;
function cutText(text) {
  if (!text) return "";

  return text.length > MAX_TEXT ? text.slice(0, MAX_TEXT) + "..." : text;
}
</script>
