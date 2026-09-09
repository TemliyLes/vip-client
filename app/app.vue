<template>
  <div>
    <Menu />

    <PageTransition ref="pageTransition" />

    <div id="smooth-wrapper">
      <div id="smooth-content">
        <main>
          <NuxtPage />
        </main>
        <Footer />
      </div>
    </div>
  </div>
</template>
<script setup>
import { nextTick } from "vue";

import Menu from "./components/menu/Controller.vue";
import PageTransition from "./components/layout/PageTransition.vue";
import Footer from "./components/blocks/Footer.vue";

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
});

router.afterEach(async () => {
  await nextTick();
  await nextTick();

  // новая страница уже в DOM
  resetScroll();

  requestAnimationFrame(() => {
    refresh();
  });

  if (pageTransition.value) {
    await pageTransition.value.enter();
  }
});

onMounted(async () => {
  await nextTick();

  init();

  requestAnimationFrame(() => {
    refresh();
  });
});

onBeforeUnmount(() => {
  destroy();
});
</script>
