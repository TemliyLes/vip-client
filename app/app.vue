<template>
  <div>
    <MenuDesktop />

    <PageTransition ref="pageTransition" />

    <div id="smooth-wrapper">
      <div id="smooth-content">
        <main>
          <NuxtPage />
        </main>
      </div>
    </div>
  </div>
</template>
<script setup>
import { nextTick } from "vue";
import { ScrollTrigger } from "gsap/ScrollTrigger";

import MenuDesktop from "./components/menu/Desktop.vue";
import PageTransition from "./components/layout/PageTransition.vue";

const router = useRouter();

const pageTransition = ref(null);

const { init, destroy, refresh, resetScroll } = useGsap();

if (process.client) {
  history.scrollRestoration = "manual";
}

router.beforeResolve(async () => {
  if (pageTransition.value) {
    await pageTransition.value.leave();
  }

  resetScroll();
});

router.afterEach(async () => {
  await nextTick();

  // новая страница уже в DOM
  resetScroll();

  requestAnimationFrame(() => {
    ScrollTrigger.refresh(true);
  });

  if (pageTransition.value) {
    await pageTransition.value.enter();
  }
});

onMounted(async () => {
  await nextTick();

  init();

  setTimeout(() => {
    refresh();
  }, 300);
});

onBeforeUnmount(() => {
  destroy();
});
</script>
