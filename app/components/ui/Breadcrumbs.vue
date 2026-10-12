<template>
  <nav v-if="trail.length > 1" :aria-label="$t('breadcrumbs.label')">
    <ol class="flex flex-wrap items-center gap-x-2 gap-y-1 text-xs sm:text-[13px] leading-relaxed text-darkbeige">
      <li v-for="(item, index) in trail" :key="index" class="flex min-w-0 items-baseline gap-2">
        <span v-if="index" aria-hidden="true" class="opacity-60">/</span>
        <NuxtLinkLocale
          v-if="item.to && index < trail.length - 1"
          :to="item.to"
          class="break-words transition-colors duration-200 hover:text-wine focus-visible:text-wine focus-visible:underline focus-visible:underline-offset-4"
        >
          {{ item.label }}
        </NuxtLinkLocale>
        <span v-else :aria-current="index === trail.length - 1 ? 'page' : undefined" class="break-words">
          {{ item.label }}
        </span>
      </li>
    </ol>
  </nav>
</template>

<script setup>
import { decodeWpText } from "~/utils/decodeWpText";

const props = defineProps({
  items: { type: Array, default: () => [] },
});
const { t } = useI18n({ useScope: 'global' });

const trail = computed(() => [
  { label: t('breadcrumbs.home'), to: '/' },
  ...props.items
    .map(item => ({ ...item, label: decodeWpText(item.label).trim() }))
    .filter(item => item.label),
]);
</script>
