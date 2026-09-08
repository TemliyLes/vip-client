<template>
  <ClientOnly>
    <component :is="isMobile ? HeroMobile : HeroDesktop" />
  </ClientOnly>
</template>

<script setup>
import HeroMobile from "./Hero/HeroMobile.vue";
import HeroDesktop from "./Hero/HeroDesktop.vue";

const { isMobile } = useDevice();
</script>
