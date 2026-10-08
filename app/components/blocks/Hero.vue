<template>
  <div ref="heroRoot" class="min-h-dvh bg-beige">
    <ClientOnly>
      <component :is="isMobile ? HeroMobile : HeroDesktop" @vue:mounted="onHeroMounted" />
    </ClientOnly>
  </div>
</template>

<script setup>
import HeroMobile from "./Hero/HeroMobile.vue";
import HeroDesktop from "./Hero/HeroDesktop.vue";
import heroTitle from "~/assets/img/minititle.png";
import heroPhoto from "~/assets/img/olga.png";

const { isMobile } = useDevice();
const { visible: loaderVisible, heroPending } = useInitialLoader();
const heroRoot = ref(null);
let readinessVersion = 0;
const imageCleanups = new Set();

if (loaderVisible.value) heroPending.value = true;

// Both viewport variants use the same images. Start loading them in the SSR HTML.
useHead({ link: [
  { rel: "preload", as: "image", href: heroTitle },
  { rel: "preload", as: "image", href: heroPhoto },
] });

function waitForImage(image) {
  if (image.decode) return image.decode().catch(() => {});
  if (image.complete) return Promise.resolve();

  return new Promise((resolve) => {
    const finish = () => {
      image.removeEventListener("load", finish);
      image.removeEventListener("error", finish);
      imageCleanups.delete(finish);
      resolve();
    };
    imageCleanups.add(finish);
    image.addEventListener("load", finish, { once: true });
    image.addEventListener("error", finish, { once: true });
    if (image.complete) finish();
  });
}

async function onHeroMounted() {
  if (!loaderVisible.value) return;
  const version = ++readinessVersion;
  heroPending.value = true;
  await nextTick();
  if (!heroRoot.value || version !== readinessVersion) return;
  await Promise.all(Array.from(heroRoot.value.querySelectorAll("img"), waitForImage));
  if (heroRoot.value && version === readinessVersion) heroPending.value = false;
}

watch(isMobile, () => {
  if (!loaderVisible.value) return;
  readinessVersion++;
  heroPending.value = true;
});

onBeforeUnmount(() => {
  readinessVersion++;
  heroPending.value = false;
  for (const cleanup of imageCleanups) cleanup();
});
</script>
