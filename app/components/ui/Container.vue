<template>
  <component :is="tag" class="mx-auto w-full max-w-[1240px] px-5 sm:px-8">
    <slot />
  </component>
</template>

<script setup>
defineProps({ tag: { type: String, default: "div" } });
</script>
