<template>
  <div
    ref="header"
    class="fixed top-0 left-0 z-[999] w-full h-[80px] grid place-items-center pointer-events-none"
  >
    <div ref="bg" class="absolute inset-0 bg-white opacity-0" />

    <Container class="relative z-10 pointer-events-auto">
      <div class="flex items-center justify-between">
        <NuxtLink to="/" class="shrink-0">
          <Logo />
        </NuxtLink>

        <Bar class="flex-1 max-w-[400px]" :active="isScrolled" :items="menu" />

        <Button class="shrink-0"> Rezrvovat Online </Button>
      </div>
    </Container>
  </div>
</template>

<script setup>
import { gsap } from "gsap";

import Container from "../ui/Container.vue";
import Button from "../ui/Button.vue";
import Logo from "../icons/logo.vue";
import Bar from "./Bar.vue";

import { menu } from "#imports";

const bg = ref(null);

const isScrolled = ref(false);

let onScroll = null;

onMounted(() => {
  onScroll = () => {
    isScrolled.value = window.scrollY > 70;
  };

  window.addEventListener("scroll", onScroll, {
    passive: true,
  });
});

watch(isScrolled, (value) => {
  gsap.to(bg.value, {
    opacity: value ? 1 : 0,
    boxShadow: value
      ? "0 12px 25px -12px rgba(0,0,0,0.18)"
      : "0 0 0 transparent",
    duration: 0.5,
    ease: "power3.out",
  });
});

onUnmounted(() => {
  if (onScroll) {
    window.removeEventListener("scroll", onScroll);
  }
});
</script>
