<template>
  <div>
    <InitialLoader
      v-if="initialLoaderVisible"
      :ready="initialLoaderReady"
      @before-reveal="prepareInitialReveal"
      @complete="initialLoaderVisible = false"
    />
    <div :inert="initialLoaderVisible && isMounted" :aria-busy="initialLoaderVisible && isMounted">
      <Menu />

      <PageTransition ref="pageTransition" />
      <div id="modal"></div>
      <div id="smooth-wrapper">
        <div id="smooth-content">
          <main>
            <NuxtPage :page-key="(route) => route.path" />
          </main>
          <Footer />
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { nextTick } from "vue";
import { ScrollTrigger } from "gsap/ScrollTrigger";

import Menu from "./components/menu/Controller.vue";
import PageTransition from "./components/layout/PageTransition.vue";
import InitialLoader from "./components/layout/InitialLoader.vue";
import Footer from "./components/blocks/Footer.vue";

const router = useRouter();
const nuxtApp = useNuxtApp();
const isMounted = ref(false);
const { visible: initialLoaderVisible, pageReady, ready: initialLoaderReady } = useInitialLoader();

const { localeProperties } = useI18n({ useScope: 'global' });
useHead({
  htmlAttrs: {
    lang: () => localeProperties.value.language,
    "data-initial-loading": () => initialLoaderVisible.value ? "true" : undefined,
  },
  noscript: [{ innerHTML: "<style>#initial-loader{display:none}html[data-initial-loading]{overflow:auto}</style>" }],
});

const pageTransition = ref(null);

const { init, destroy, refresh, resetScroll } = useGsap();

const removeInitialReadyHook = nuxtApp.hook("app:suspense:resolve", async () => {
  await nextTick();
  await document.fonts.ready;
  pageReady.value = true;
});

function prepareInitialReveal() {
  resetScroll();
  ScrollTrigger.sort();
  ScrollTrigger.refresh();
}

const removePageFinishHook = nuxtApp.hook("page:finish", async () => {
  await nextTick();
  await document.fonts.ready;
  // Async page components are mounted; account for upstream pins first.
  ScrollTrigger.sort();
  refresh();
});

if (process.client) {
  history.scrollRestoration = "manual";
}

const removeBeforeResolve = router.beforeResolve(async () => {
  if (pageTransition.value) {
    await pageTransition.value.leave();
  }

  resetScroll();
});

const removeAfterEach = router.afterEach(async () => {
  await nextTick();

  // новая страница уже в DOM
  resetScroll();

  if (pageTransition.value) {
    await pageTransition.value.enter();
  }
});

onMounted(() => {
  isMounted.value = true;
  // Child animations wait for nextTick so ScrollSmoother exists first.
  init();
});

onBeforeUnmount(() => {
  removeInitialReadyHook();
  removePageFinishHook();
  removeBeforeResolve();
  removeAfterEach();
  destroy();
});
</script>
