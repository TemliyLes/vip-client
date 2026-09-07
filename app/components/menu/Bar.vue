<template>
  <div class="flex justify-between gap-4 h-full items-center">
    <div v-for="item in items" class="relative">
      <NuxtLink :to="item?.to">
        <Paragraph :class="!active ? '!text-white' : '!text-darkbeige'">{{
          item?.title
        }}</Paragraph>
      </NuxtLink>
    </div>
  </div>
</template>

<script setup>
import Paragraph from "../ui/Paragraph.vue";
defineProps({
  items: {
    type: Array,
  },
  active: {
    type: Boolean,
  },
});
</script>
