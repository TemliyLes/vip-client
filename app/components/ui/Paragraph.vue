<template>
  <component :is="tag" class="block text-xs uppercase leading-relaxed text-darkbeige">
    <slot />
  </component>
</template>

<script setup>
defineProps({ tag: { type: String, default: "p" } });
</script>
