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
      <FeedbackModal />
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
import FeedbackModal from "./components/blocks/FeedbackModal.vue";

const router = useRouter();
const route = useRoute();
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

const { init, destroy, resetScroll } = useGsap();
let navigationVersion = 0;
let requestedRoute = null;
let readyPagePath = null;
let transitionPending = false;
const defaultScrollBehavior = router.options.scrollBehavior;
const managedScrollBehavior = (to, from, savedPosition) => {
  // The curtain owns scroll resets between pages. Keep native hash navigation.
  if (to.path !== from.path && !to.hash) return false;
  return defaultScrollBehavior?.(to, from, savedPosition);
};

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

async function revealReadyPage() {
  const path = router.currentRoute.value.path;
  if (!transitionPending || !pageTransition.value ||
      requestedRoute?.path !== path || readyPagePath !== path) return;

  const version = navigationVersion;
  await nextTick();
  await document.fonts.ready;
  if (version !== navigationVersion || readyPagePath !== router.currentRoute.value.path) return;

  // Replace the page and recalculate its pins while the curtain still covers it.
  resetScroll();
  ScrollTrigger.sort();
  ScrollTrigger.refresh();
  transitionPending = false;
  // Do not delay Nuxt's loading:end (and hash scrolling) for the exit animation.
  void pageTransition.value?.enter();
}

const removePageStartHook = nuxtApp.hook("page:start", () => {
  readyPagePath = null;
});

const removePageFinishHook = nuxtApp.hook("page:finish", async () => {
  // Nuxt synchronizes useRoute when the new Suspense branch has resolved.
  const path = route.path;
  await nextTick();
  await document.fonts.ready;
  if (route.path !== path) return;
  readyPagePath = path;

  if (transitionPending) {
    await revealReadyPage();
  } else {
    ScrollTrigger.sort();
    ScrollTrigger.refresh();
  }
});

if (process.client) {
  history.scrollRestoration = "manual";
}

const removeBeforeEach = router.beforeEach((to) => {
  navigationVersion++;
  requestedRoute = to;
});

const removeBeforeResolve = router.beforeResolve(async (to, from) => {
  if (!pageTransition.value || initialLoaderVisible.value) return;
  // Query/hash changes do not replace the page keyed by route.path.
  if (to.path === from.path && !transitionPending) return;

  const version = navigationVersion;
  transitionPending = true;
  await pageTransition.value.leave();
  if (version !== navigationVersion) return false;
});

async function recoverNavigation(to) {
  // A cancelled older navigation must not uncover a newer one.
  if (to !== requestedRoute) return;
  navigationVersion++;
  requestedRoute = router.currentRoute.value;
  await revealReadyPage();
}

const removeAfterEach = router.afterEach(async (to, from, failure) => {
  if (failure) {
    await recoverNavigation(to);
  } else if (to.path === from.path) {
    // No new Suspense branch/page:finish for an unchanged page key.
    await revealReadyPage();
  }
});

const removeRouterError = router.onError((_error, to) => recoverNavigation(to));
const removeAppErrorHook = nuxtApp.hook("app:error", async () => {
  navigationVersion++;
  transitionPending = false;
  await nextTick();
  // Errors must remain visible even if no successful page:finish follows.
  await pageTransition.value?.enter();
});

onMounted(() => {
  isMounted.value = true;
  router.options.scrollBehavior = managedScrollBehavior;
  // Child animations wait for nextTick so ScrollSmoother exists first.
  init();
});

onBeforeUnmount(() => {
  navigationVersion++;
  transitionPending = false;
  removeInitialReadyHook();
  removePageStartHook();
  removePageFinishHook();
  removeBeforeEach();
  removeBeforeResolve();
  removeAfterEach();
  removeRouterError();
  removeAppErrorHook();
  if (router.options.scrollBehavior === managedScrollBehavior) {
    router.options.scrollBehavior = defaultScrollBehavior;
  }
  destroy();
});
</script>
