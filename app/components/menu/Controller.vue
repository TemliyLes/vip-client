<template>
  <ClientOnly>
    <component :is="isMobile ? Mobile : Desktop" />
  </ClientOnly>
</template>

<script setup>
import Desktop from "./Desktop.vue";
import Mobile from "./Mobile.vue";

const { isMobile } = useDevice();
</script>
