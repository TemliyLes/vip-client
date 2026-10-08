<template>
  <div>
    <NuxtLinkLocale :to="`/news/${data?.id}`" class="group flex h-full gap-3 min-w-0">
      <img
        :src="data?.images?.card?.url"
        :alt="data?.name"
        class="object-cover brightness-80 transition duration-500 group-hover:brightness-100 h-18 aspect-square shrink-0"
      />

      <div class="min-w-0 flex-1">
        <Header mini class="!font-normal line-clamp-2">
          {{ data?.title?.rendered }}
        </Header>

        <Paragraph tag="div" class="line-clamp-2">
          <div v-html="data?.excerpt?.rendered"></div>
        </Paragraph>
      </div>
    </NuxtLinkLocale>
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
</script>
