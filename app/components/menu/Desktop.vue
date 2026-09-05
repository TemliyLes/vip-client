<template>
  <div
    ref="header"
    class="fixed top-0 left-0 z-[999] w-full h-[80px] grid place-items-center pointer-events-none"
  >
    <div ref="bg" class="absolute inset-0 bg-white origin-top scale-y-0"></div>

    <Container class="relative z-10 pointer-events-auto">
      <div class="flex justify-between">
        <Logo />

        <Button> Rezrvovat Online </Button>
      </div>
    </Container>
  </div>
</template>

<script setup>
import { gsap } from "gsap";

import Container from "../ui/Container.vue";
import Logo from "../icons/logo.vue";
import Button from "../ui/Button.vue";

const bg = ref(null);

let onScroll = null;

onMounted(() => {
  const setProgress = gsap.quickTo(bg.value, "scaleY", {
    duration: 0.4,
    ease: "sine.out",
  });

  onScroll = () => {
    const scroll = window.scrollY;

    const progress = gsap.utils.clamp(
      0,
      1,
      (scroll - window.innerHeight * 0.5) / (window.innerHeight * 0.5),
    );

    setProgress(progress);
  };

  window.addEventListener("scroll", onScroll, {
    passive: true,
  });
});

onUnmounted(() => {
  if (onScroll) {
    window.removeEventListener("scroll", onScroll);
  }
});
</script>
