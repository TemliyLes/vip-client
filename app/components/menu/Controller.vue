<template>
  <ClientOnly>
    <component :is="isMobile ? Mobile : Desktop" />
  </ClientOnly>
</template>

<script setup>
import Desktop from "./Desktop.vue";
import Mobile from "./Mobile.vue";
import { useServicesStore } from "~/store/services";

const { isMobile } = useDevice();
const { locale } = useI18n({ useScope: 'global' });
const services = useServicesStore();

onMounted(() => {
  watch(locale, () => {
    if (!services.categories.length) services.getData();
  }, { immediate: true });
});
</script>
