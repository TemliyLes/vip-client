<template>
  <NuxtLinkLocale :to="to" class="focus-link">
    <div class="flex gap-2 cursor-pointer">
      <Paragraph tag="span" class="focus-label text-wine!"><slot /></Paragraph>
      <Arrow red />
    </div>
  </NuxtLinkLocale>
</template>

<script setup>
import Paragraph from "./Paragraph.vue";
import Arrow from "../icons/arrow.vue";
defineProps({
  to: {
    type: [String, Object],
  },
});
</script>
