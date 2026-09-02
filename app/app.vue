<template>
  <template>
    <div id="smooth-wrapper">
      <div id="smooth-content">
        <main>
          <Logo />
          <NuxtPage />
          <Blank />
          <Blank />
          <Blank />
          <Blank />
          <Blank />
          <Blank />
        </main>
      </div>
    </div>
  </template>
</template>
<script setup>
import Logo from "./components/icons/logo.vue";
import Blank from "./components/Blank.vue";

const { init, destroy } = useGsap();

onMounted(() => {
  init();
});

onUnmounted(() => {
  destroy();
});
</script>
