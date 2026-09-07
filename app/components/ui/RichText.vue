<template>
  <div class="rich-text" v-html="content" />
</template>

<script setup>
defineProps({
  content: {
    type: String,
    default: "",
  },
});
</script>
