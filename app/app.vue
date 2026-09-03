<template>
  <div>
    <MenuDesktop />
    <div id="smooth-wrapper">
      <div id="smooth-content">
        <main>
          <NuxtPage />
          <ClientOnly>
            <Blank />
            <Blank />
            <Blank />
            <Blank />
            <Blank />
            <Blank />
          </ClientOnly>
        </main>
      </div>
    </div>
  </div>
</template>

<script setup>
import Blank from "./components/Blank.vue";

import MenuDesktop from "./components/menu/Desktop.vue";

const { init, destroy } = useGsap();

onMounted(() => {
  init();
});

onUnmounted(() => {
  destroy();
});
</script>
