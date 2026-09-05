<template>
  <NuxtLink :to="to">
    <div class="flex gap-2 cursor-pointer">
      <Paragraph class="text-wine!"><slot /></Paragraph>
      <Arrow red />
    </div>
  </NuxtLink>
</template>

<script setup>
import Paragraph from "./Paragraph.vue";
import Arrow from "../icons/arrow.vue";
defineProps({
  to: {
    type: String,
  },
});
</script>
