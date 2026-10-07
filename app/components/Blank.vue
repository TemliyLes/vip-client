<template>
  <div :style="[randomStyle(), ranBg()]">{{ $t('ui.components.Blank.divText1') }}</div>
</template>

<script setup>
const randomStyle = () => `height: ${Math.floor(Math.random() * 400) + 400}px`;
const ranBg = () =>
  `background: ${"#" + Math.floor(Math.random() * 16777215).toString(16)}`;
</script>
