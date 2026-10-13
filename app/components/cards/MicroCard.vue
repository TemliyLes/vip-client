<template>
  <article class="h-full min-w-0">
    <NuxtLinkLocale :to="`/news/${data?.id}`" class="group flex h-full gap-3 min-w-0">
      <img
        :src="data?.images?.card?.url"
        :alt="data?.images?.card?.alt ?? decodeWpText(data?.title?.rendered)"
        class="object-cover brightness-80 transition duration-500 group-hover:brightness-100 h-18 aspect-square shrink-0"
      />

      <div class="min-w-0 flex-1">
        <Header tag="h3" mini class="!font-normal line-clamp-2">
          {{ decodeWpText(data?.title?.rendered) }}
        </Header>

        <Paragraph tag="div" class="line-clamp-2!">
          <div v-html="data?.excerpt?.rendered"></div>
        </Paragraph>
      </div>
    </NuxtLinkLocale>
  </article>
</template>

<script setup>
import Header from "../ui/Header.vue";
import Paragraph from "../ui/Paragraph.vue";
import { decodeWpText } from "~/utils/decodeWpText";

defineProps({
  data: {
    type: Object,
    default: () => ({}),
  },
});
</script>
