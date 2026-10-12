<template>
  <article class="news-card flex h-full w-full flex-1 flex-col">
    <div class="flex flex-1 flex-col" :class="compact ? '' : direction">
      <img
        v-if="data?.images?.card?.url"
        ref="image"
        :src="data?.images?.card?.url"
        class="w-full shrink-0 object-cover"
        :class="compact ? 'h-[280px] sm:h-[340px]' : 'h-[476px]'"
        :loading="compact ? 'lazy' : undefined"
        :alt="decodeWpText(data?.title?.rendered)"
      />
      <div
        v-else
        aria-hidden="true"
        class="w-full shrink-0 bg-milk"
        :class="compact ? 'h-[280px] sm:h-[340px]' : 'h-[476px]'"
      />
      <div class="flex flex-1 flex-col justify-between gap-6 p-6" :class="{ 'sm:min-h-[476px]': !compact }">
        <header class="flex flex-col gap-4">
          <Header :tag="headingTag" mini>{{ decodeWpText(data?.title?.rendered) }}</Header>
          <Paragraph :class="{ 'line-clamp-4!': compact }">{{ data?.news_fields?.description }}</Paragraph>
        </header>
        <Link class="mt-6 sm:mt-0" :class="{ 'transition-opacity hover:opacity-70 focus-visible:opacity-70': compact }" :to="`/news/${data?.id}`"
          >{{ $t('ui.components.cards.HomeNew.linkText1') }}</Link
        >
      </div>
    </div>
  </article>
</template>

<script setup>
import Paragraph from "../ui/Paragraph.vue";
import Header from "../ui/Header.vue";
import Link from "../ui/Link.vue";
import { decodeWpText } from "~/utils/decodeWpText";
const props = defineProps({
  compact: { type: Boolean, default: false },
  headingTag: { type: String, default: 'h3' },
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
