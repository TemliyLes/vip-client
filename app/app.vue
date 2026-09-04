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

router.beforeEach(async () => {
  if (pageTransition.value) {
    await pageTransition.value.leave();
  }
});

router.afterEach(async () => {
  await nextTick();

  // сброс состояния smoother
  resetScroll?.();

  await nextTick();

  if (pageTransition.value) {
    await pageTransition.value.enter();
  }

  setTimeout(() => {
    ScrollTrigger.refresh(true);
  }, 300);
});

onMounted(async () => {
  await nextTick();

  init();

  setTimeout(() => {
    ScrollTrigger.refresh(true);
  }, 300);
});

onBeforeUnmount(() => {
  destroy();
});
</script>
