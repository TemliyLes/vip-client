<template>
  <article data-card class="h-full min-w-0">
    <NuxtLinkLocale :to="wpItemRoute('news', data)" class="group flex h-full gap-3 min-w-0">
      <img
        :src="data?.images?.card?.url"
        :alt="data?.images?.card?.alt ?? decodeWpText(data?.title?.rendered)"
        class="object-cover brightness-80 transition duration-500 group-hover:brightness-100 h-18 aspect-square shrink-0"
      />

      <div class="min-w-0 flex-1">
        <Header tag="h3" mini class="focus-label text-wine !font-normal line-clamp-2">
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
import { wpItemRoute } from "~/utils/wpRoutes";

defineProps({
  data: {
    type: Object,
    default: () => ({}),
  },
});
</script>
