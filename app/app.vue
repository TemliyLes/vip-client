<template>
  <div id="smooth-wrapper">
    <div id="smooth-content">
      <main>
        <Logo />
        <h1 style="font-family: Lato; font-size: 50px">Заголовок LATO</h1>
        <h1 style="font-size: 50px">Заголовок LATO</h1>
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
