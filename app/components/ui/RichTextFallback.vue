<!-- components/content/RichTextFallback.vue -->

<template>
  <!-- <div class="border border-dashed border-gray-300 p-4">
    <div class="text-xs text-gray-400 mb-2">
      Компонент "{{ tag }}" пока не реализован
    </div>

    <slot />
  </div> -->
</template>

<script setup>
defineProps({
  tag: {
    type: String,
    required: true,
  },
});
</script>
